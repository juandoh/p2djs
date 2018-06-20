<?php

namespace App\Http\Controllers\CourseDesign;

use Auth;
use Alert;
use App\AchievementIndicators;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AchievementIndicatorsController extends Controller
{
    //validator rules
    private $rules = [
        'learningO'=>'required|string|exists:learning_outcomes,id',
        'name' => 'required|string|max:255',
        'detail'=>'required|string|max:255',        
    ];
    //validator messages
    private $messages=[
        'required'=>'El atributo es obligatorio',
        'exists'=>'El resultado de aprendizaje referenciado no existe',
    ];

    //Database
    public static function store(array $data){
        //id,learningO,name,detail
        return AchievementIndicators::create([
            'learningO'=>$data['learningO'],
            'name'=>$data['name'],
            'detail'=>$data['detail']
        ]);
    }
    
    public static function edit(array $data, $id){
        $competence = AchievementIndicators::find($id);
        $competence->learningO=$data['learningO'];
        $competence->name=$data['name'];
        $competence->detail=$data['detail'];

        return $competence->save();
    }

    public static function destroy($id){
        return AchievementIndicators::destroy($id);
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
