<?php

namespace App\Http\Controllers\CourseDesign;

use Auth;
use Alert;
use Relations;
use App\Courses;
use App\CourseCompetences;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CourseDesign\LearningOutcomesController;
use App\Http\Controllers\CourseDesign\AchievementIndicatorsController;

class CourseCompetencesController extends Controller
{
    //validator rules
    private $rules = [
        'course_id' => 'required|string|exists:courses,id',
        'name' => 'required|string|max:255',
        'detail' => 'required|string|max:255',
    ];
    //validator messages
    private $messages = [
        'detail.required' => 'La descripción es obligatoria',
        'max' => 'El atributo no debe contener más de :max caracteres',
        'exists' => 'El curso referenciado no existe',
        'required' => "el atributo :attribute es necesario",
    ];

    protected function validator(array $data, $rules, $messages)
    {
        return Validator::make($data, $rules, $messages);
    }

    //Database
    public function store(array $data)
    {
        //id,course,name,detail
        return CourseCompetences::create([
            'course' => (int)$data['course_id'],
            'name' => $data['name'],
            'detail' => $data['detail']
        ]);
    }

    public function edit(array $data, $id)
    {
        $competence = CourseCompetences::find($id);
        $competence->course = (int)$data['course_id'];
        $competence->name = $data['name'];
        $competence->detail = $data['detail'];

        return $competence->save();
    }

    public function destroy($id)
    {
        return CourseCompetences::destroy($id);
    }

    public static function listCompetences($course_id)
    {
        return CourseCompetences::where('course', $course_id)->get();
    }



    //REST FUNCTIONS
    //GET
    public function showEdit()
    {

    }

    public function showCreate($id)
    {
        if (Courses::find($id)) {
            $count = CourseCompetences::where("course", $id)->count() + 1;
            return view('forms.CourseDesign.competence')->with(['course_id' => $id, "competence_id" => $count]);
        }
    }

    //POST
    public function create(Request $request)
    {
        $error = false;
        $data = $request->all();
        $rules = [
            'course_id' => 'required|string|exists:courses,id',
            'name' => 'required|string|max:255',
            'detail' => 'required|string|max:255',
        ];
        $messages = [
            'detail.required' => 'La descripción es obligatoria',
            'max' => 'El atributo no debe contener más de :max caracteres',
            'exists' => 'El curso referenciado no existe',
            'required' => "el atributo :attribute es necesario",
        ];
        //dump($data);
        //dd($data);

        $i = 1;
        while (array_key_exists('ra_' . $i, $data)) {
            #Rules
            $rules['ra_' . $i] = "required|string|max:191";
            $rules['ra_' . $i . '_detail'] = "required|string|max:191";
            #Messages
            $messages['ra_' . $i . '.required'] = "El Nombre del resultado de aprendizaje " . $i . " es necesario";
            $messages['ra_' . $i . '_detail.required'] = "La descripción del resultado de aprendizaje " . $i . " es necesaria";


            $j = 1;
            while (array_key_exists('ra_' . $i . '_achievement_' . $j, $data)) {
                $rules['ra_' . $i . '_achievement_' . $j] = "required|string|max:191|unique:achievement_indicators,name";
                $messages['ra_' . $i . '_achievement_' . $j . ".required"] = "El Nombre del indicador de logro " . $i . "." . $j . " es necesario";
                $rules['ra_' . $i . '_achievement_' . $j . '_detail'] = "required|string|max:191";
                $messages['ra_' . $i . '_achievement_' . $j . '_detail.required'] = "La descripción del indicador de logro " . $i . "." . $j . " es necesario";

                $j++;
            }
            if ($j == 1) {
                $error = true;
                break;
            }
            $i++;
        }
        if($i==1){
            $error = true;
        }

        if ($error) {
            alert()->html("Error!", "<h4>Por cada competencia debe haber al menos 1 resultado de aprendizaje, y por cada resultado de aprendizaje debe haber al menos 1 indicador de logro</h4>", "error")->showCancelButton("Cerrar");
            return redirect()->back()->with(['_old_input' => $data]);
        }

        $validator = $this->validator($data, $rules, $messages);
        if ($validator->fails()) {
            dd($validator);
            return redirect()->back()->withErrors($validator)->with(['_old_input' => $data]);
        }

        $competence = ['course_id' => $data['course_id'], 'name' => $data['name'], 'detail' => $data['detail']];
        $competenceSave = $this->store($competence);
        if ($competenceSave) {
            $competence_id = $competenceSave->id;
            $i = 1;
            while (array_key_exists('ra_' . $i, $data)) {
                $detailL = $data['ra_' . $i . '_detail'];
                $learningoutcome = ['competence' => $competence_id, 'name' => $data['ra_' . $i], 'detail' => (is_null($detailL) ? "" : $detailL)];
                $save = LearningOutcomesController::store($learningoutcome);
                $learning_id = $save->id;
                if ($save) {
                    $j = 1;
                    while (array_key_exists('ra_' . $i . '_achievement_' . $j, $data)) {
                        $detailachv = "";
                        $data['ra_' . $i . '_achievement_' . $j . '_detail'];
                        $achievement = ['learningO' => $learning_id, 'name' => $data['ra_' . $i . '_achievement_' . $j], 'detail' => (is_null($detailachv) ? "" : $detailachv)];
                        $achievement_save = AchievementIndicatorsController::store($achievement);
                        $j += 1;
                    }

                }
                $i += 1;
                if ($error) {
                    $save->delete();
                }
            }
            if ($i == 1) {
                $error = true;
            }
        }

        alert()->success("Exito!", "Se ha registrado correctamente la competencia");
        return redirect()->back();
    }

    public function update(Request $request)
    {

    }

    public function delete($id)
    {

    }
}
