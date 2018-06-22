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
        'course_id'=>'required|string|exists:courses,id',
        'name' => 'required|string|max:255',
        'detail'=>'required|string|max:255',        
    ];
    //validator messages
    private $messages=[
        'detail.required'=>'La descripción es obligatoria',
        'detail.max'=>'La descripción no debe ser mayor a 255 caracteres',
        'exists'=>'El curso referenciado no existe',
    ];

    protected function validator(array $data, $rules){
        return Validator::make($data, $rules, $this->messages);
    }

    //Database
    public function store(array $data){
        //id,course,name,detail
        return CourseCompetences::create([
            'course'=>(int)$data['course_id'],
            'name'=>$data['name'],
            'detail'=>$data['detail']
        ]);
    }
    
    public function edit(array $data, $id){
        $competence = CourseCompetences::find($id);
        $competence->course=(int)$data['course_id'];
        $competence->name=$data['name'];
        $competence->detail=$data['detail'];

        return $competence->save();
    }

    public function destroy($id){
        return CourseCompetences::destroy($id);
    }

    public static function listCompetences($course_id){
        return CourseCompetences::where('course',$course_id)->get();
    }

    

    //REST FUNCTIONS
    //GET
    public function showEdit(){
        
    }

    public function showCreate($id){
        if(Courses::find($id)){
            $count = CourseCompetences::where("course",$id)->count() +1;
            return view('forms.CourseDesign.competence')->with(['course_id'=>$id,"competence_id"=>$count]);
        }
    }

    //POST
    public function create(Request $request){
        $error = false;
        $data = $request->all();
        //dump($data);
        dd($data);
        $validator =$this->validator($data,$this->rules);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->with(['_old_input'=>$data]);
        }

        $competence = ['course_id'=>$data['course_id'], 'name'=> $data['name'],'detail'=>$data['detail']];
        $competenceSave = $this->store($competence);
        if($competenceSave){
            $competence_id = $competenceSave->id;
            $i=0;
            while(array_key_exists('ra_'.$i, $data)){
                $learningoutcome = ['competence'=>$competence_id, 'name'=>$data['ra_'.$i], 'detail'=>$data['ra_'.$i.'_detail']];
                $save = LearningOutcomesController::store($learningoutcome);
                $learning_id = $save->id;
                if($save){
                    $j = 0;
                    while(array_key_exists('ra_'.$i.'_achievement_'.$j, $data)){
                        $achievement = ['learningO'=>$learning_id,'name'=>$data['ra_'.$i.'_achievement_'.$j],'detail'=>$data['achievement_'.$j.'_detail']];
                        $achievement_save = AchievementIndicatorsController::store($achievement);
                        $j+=1;
                    }
                    if($j==0){
                        $error = true;
                    }
                }
                $i+=1;
                if($error){
                    $save->delete();
                }
            }
            if($i==0){
                $error = true;
            }
        }
        if($error){
            $competenceSave->delete();
            alert()->html("Error!","<h4>Por cada competencia debe haber al menos 1 resultado de aprendizaje, y por cada resultado de aprendizaje debe haber al menos 1 indicador de logro</h4>","error")->showCancelButton("Cerrar");
            return redirect()->back()->with(['_old_input'=>$data]);
        }else{
            alert()->success("Exito!","Se ha registrado correctamente la competencia");
        }
        return redirect()->back();
    }

    public function update(Request $request){

    }

    public function delete($id){

    }
}
