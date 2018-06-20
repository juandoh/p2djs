<?php

namespace App\Http\Controllers\CourseDesign;

use Auth;
use Alert;
use App\LearningOutcomes;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LearningOutcomesController extends Controller
{
    //validator rules
    private $rules = [
        'competence'=>'required|string|exists:course_competences,id',
        'name' => 'required|string|max:255',
        'detail'=>'required|string|max:255',        
    ];
    //validator messages
    private $messages=[
        'required'=>'El atributo es obligatorio',
        'exists'=>'La competencia referenciada no existe',
    ];
    
    //Database
    public static function store(array $data){
        //id,competence,name,detail
        return LearningOutcomes::create([
            'competence'=>$data['competence'],
            'name'=>$data['name'],
            'detail'=>$data['detail']
        ]);
    }
    
    public static function edit(array $data, $id){
        $competence = LearningOutcomes::find($id);
        $competence->competence=$data['competence'];
        $competence->name=$data['name'];
        $competence->detail=$data['detail'];

        return $competence->save();
    }

    public static function destroy($id){
        return LearningOutcomes::destroy($id);
    }
    //REST FUNCTIONS
    //GET
    public function showEdit(){
        
    }

    //POST
    public function create(Request $request){

    }

    public function update(Request $request){

    }

    public function delete($id){

    }
}
