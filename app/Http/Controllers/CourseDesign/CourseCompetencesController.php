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
    public function __construct()
    {
        $this->middleware('auth');
    }

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

    private function rules_competence_tree(&$data,&$rules, &$messages, &$error)
    {
        //############################################################## VALIDATION STAGE
        $i = 1;
        while (array_key_exists('ra_' . $i, $data)) {
            #Rules
            $rules['ra_' . $i] = "required|string|max:191";
            $rules['ra_' . $i . '_detail'] = "required|string|max:191";
            #Messages
            $messages['ra_' . $i . '.required'] = "El Nombre del resultado de aprendizaje " . $i . " es necesario";
            $messages['ra_' . $i . '_detail.required'] = "La Descripción del resultado de aprendizaje " . $i . " es necesaria";

            $j = 1;
            while (array_key_exists('ra_' . $i . '_achievement_' . $j, $data)) {
                #Rules
                $rules['ra_' . $i . '_achievement_' . $j] = "required|string|max:191";
                $rules['ra_' . $i . '_achievement_' . $j . '_detail'] = "required|string|max:191";
                #Messages
                $messages['ra_' . $i . '_achievement_' . $j . ".required"] = "El Nombre del indicador de logro " . $i . "." . $j . " es necesario";
                $messages['ra_' . $i . '_achievement_' . $j . '_detail.required'] = "La descripción del indicador de logro " . $i . "." . $j . " es necesario";
                $j++;
            }
            if ($j == 1) {
                $error = true;
                break;
            }
            $i++;
        }
        if ($i == 1) {
            $error = true;
        }
    }

    private function save_competence_tree(array $data, $competence_id)
    {
        try {
            $i = 1;
            while (array_key_exists('ra_' . $i, $data)) {
                $detailL = $data['ra_' . $i . '_detail'];
                $learningoutcome = ['competence' => $competence_id, 'name' => $data['ra_' . $i], 'detail' => (is_null($detailL) ? "" : $detailL)];
                $save = LearningOutcomesController::store($learningoutcome);
                $learning_id = $save->id;
                if ($save) {
                    $j = 1;
                    while (array_key_exists('ra_' . $i . '_achievement_' . $j, $data)) {
                        $detailachv = $data['ra_' . $i . '_achievement_' . $j . '_detail'];
                        $achievement = ['learningO' => $learning_id, 'name' => $data['ra_' . $i . '_achievement_' . $j], 'detail' => (is_null($detailachv) ? "" : $detailachv)];
                        AchievementIndicatorsController::store($achievement);
                        $j += 1;
                    }
                }
                $i += 1;
            }
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

    private function edit_competence_tree(array $data)
    {
        try {
            //############################################################## EDIT STAGE
            $competence_id = $data["competence_id"];
            $competence = ['course_id' => $data['course_id'], 'name' => $data['name'], 'detail' => $data['detail']];
            $competenceSave = $this->edit($competence,$competence_id);
            if ($competenceSave) {
                $competence_id = $data["competence_id"];
                $i = 1;
                while (array_key_exists('ra_' . $i, $data)) {
                    $detailL = $data['ra_' . $i . '_detail'];
                    $learningoutcome = ['competence' => $competence_id, 'name' => $data['ra_' . $i], 'detail' => (is_null($detailL) ? "" : $detailL)];
                    $save = LearningOutcomesController::store($learningoutcome);
                    $learning_id = $save->id;
                    if ($save) {
                        $j = 1;
                        while (array_key_exists('ra_' . $i . '_achievement_' . $j, $data)) {
                            $detailachv = $data['ra_' . $i . '_achievement_' . $j . '_detail'];
                            $achievement = ['learningO' => $learning_id, 'name' => $data['ra_' . $i . '_achievement_' . $j], 'detail' => (is_null($detailachv) ? "" : $detailachv)];
                            AchievementIndicatorsController::store($achievement);
                            $j += 1;
                        }
                    }
                    $i += 1;
                }
            } else {
                return false;
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    //REST FUNCTIONS
    //GET

    public function showCreate($id)
    {
        if (Courses::find($id)) {
            $count = CourseCompetences::where("course", $id)->count() + 1;
            return view('forms.CourseDesign.competence')->with(['course_id' => $id, "competence_id" => $count]);
        }
    }

    public function showEdit($id, $competence_id)
    {
        $fmt_data = array();
        $course = Courses::find($id);
        //Get the competence
        $competence = $course->competences()->where("id", $competence_id)->first();
        $fmt_data["name"] = $competence->name;
        $fmt_data["detail"] = $competence->detail;
        //get the learning outcomes
        $learning_outcomes = $competence->learning_outcomes()->get();

        $i = 1;
        foreach ($learning_outcomes as $learning_outcome) {
            // ra_id, ra_id_detail, ra_id_achievement_
            $fmt_data["ra_" . $i . "_id"] = $learning_outcome->id;
            $fmt_data["ra_" . $i] = $learning_outcome->name;
            $fmt_data["ra_" . $i . "_detail"] = $learning_outcome->detail;

            $learning_indicators = $learning_outcome->indicators()->get();
            $j = 1;
            foreach ($learning_indicators as $learning_indicator) {
                $fmt_data["ra_" . $i . "_achievement_" . $j . "_id"] = $learning_indicator->id;
                $fmt_data["ra_" . $i . "_achievement_" . $j] = $learning_indicator->name;
                $fmt_data["ra_" . $i . "_achievement_" . $j] = $learning_indicator->name;
                $fmt_data["ra_" . $i . "_achievement_" . $j . "_detail"] = $learning_indicator->detail;
                $j++;
            }
            $i++;
        }
        //dd(["competence_id"=>$competence_id, "_old_input"=>$fmt_data]);
        return view('forms.CourseDesign.competence')
            ->with(['course_id' => $id,
                "competence_id" => $competence_id,
                "edit_data" => $fmt_data
            ]);
    }

    public function showDesign($course_id){
        $course = Courses::find($course_id);
        if($course) {
            $competences = $course->competences()->get();
            return view('forms.CourseDesign.design')->with(['show' => true, 'competences' => $competences, 'course'=>$course]);
        }
        return redirect()->back();
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
      
        $this->rules_competence_tree($data,$rules,$messages, $error);

        $validator = $this->validator($data, $rules, $messages);
        $validator_fails = $validator->fails();
        if ($error) {
            alert()->html("Error!", "<h4>Por cada competencia debe haber al menos 1 resultado de aprendizaje, y por cada resultado de aprendizaje debe haber al menos 1 indicador de logro</h4>", "error")->showCancelButton("Cerrar");
            if ($validator_fails) {
                return redirect()->back()->withErrors($validator)->with(['_old_input' => $data]);
            } else {
                return redirect()->back()->with(['_old_input' => $data]);
            }
        }

        if ($validator_fails) {
            return redirect()->back()->withErrors($validator)->with(['_old_input' => $data]);
        }


        //############################################################## SAVE STAGE
        $competence = ['course_id' => $data['course_id'], 'name' => $data['name'], 'detail' => $data['detail']];
        $competenceSave = $this->store($competence);
        if ($competenceSave) {
            $competence_id = $competenceSave->id;
            if (!$this->save_competence_tree($data,$competence_id)) {
                alert()->error("Error", "Ha ocurrido un inconveniente");
                return redirect()->back()->with(['_old_input' => $data]);
            }
        } else {
            alert()->error("Error", "Ha ocurrido un inconveniente");
            return redirect()->back()->with(['_old_input' => $data]);
        }

        alert()->success("Exito!", "Se ha registrado correctamente la competencia");
        return redirect()->back();
    }

    public function update(Request $request)
    {
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

        $this->rules_competence_tree($data,$rules,$messages, $error);

        $validator = $this->validator($data, $rules, $messages);
        $validator_fails = $validator->fails();
        if ($error) {
            alert()->html("Error!", "<h4>Por cada competencia debe haber al menos 1 resultado de aprendizaje, y por cada resultado de aprendizaje debe haber al menos 1 indicador de logro</h4>", "error")->showCancelButton("Cerrar");
            if ($validator_fails) {
                return redirect()->back()->withErrors($validator)->with(['_old_input' => $data]);
            } else {
                return redirect()->back()->with(['_old_input' => $data]);
            }
        }

        if ($validator_fails) {
            return redirect()->back()->withErrors($validator)->with(['_old_input' => $data]);
        }

        CourseCompetences::find($data["competence_id"])->learning_outcomes()->delete();
        if(!$this->edit_competence_tree($data)){
            alert()->error("Error", "Ha ocurrido un inconveniente");
            return redirect()->back()->with(['_old_input' => $data]);
        }

        alert()->success("Exito!", "Se han modificado correctamente los contenidos de la competencia");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $data = $request->all();
        //dd($data);
        $competence_id = $data["competence_id"];
        $course_id = (int)$data["course_id"];
        CourseCompetences::destroy($competence_id);
        $competences = CourseCompetences::where('course',$course_id)->get();
        $i = 1;
        foreach($competences as $competence){
            $competence->name = "Competencia ".$i;
            $competence->save();
            $i++;
        }
        if($i>1)
            alert()->html("Exito!","<h4>Se han acomodado los nombres de las competencias a conveniencia</h4>","success");
        else
            alert()->info("No hay más competencias","");
        return redirect()->back();
    }
}
