<?php

namespace App\Http\Controllers\CourseDesign;

use Auth;
use Alert;
use App\CourseCompetences;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseCompetencesController extends Controller
{
    //validator rules
    private $rules = [
        'course'=>'required|string|exists:courses,id',
        'name' => 'required|string|max:255',
        'detail'=>'required|string|max:255',        
    ];
    //validator messages
    private $messages=[
        'required'=>'El atributo es obligatorio',
        'exists'=>'El curso referenciado no existe',
    ];

    //Database
    private function store(array $data){
        //id,course,name,detail
        return CourseCompetences::create([
            'course'=>data['course'],
            'name'=>data['name'],
            'detail'=>data['detail']
        ]);
    }
    
    private function edit(array $data, $id){
        $competence = CourseCompetences::find($id);
        $competence->course=data['course'];
        $competence->name=data['name'];
        $competence->detail=data['detail'];

        return $competence->save();
    }

    private function destroy($id){
        return CourseCompetences::destroy($id);
    }

    public static function listCompetences(){
        return CourseCompetences::all();
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
