<?php

namespace App\Http\Controllers\Session;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CRUD\CoursesController;

class DocenteController extends Controller
{   
    private $tabs = array('consultar','crear','configuracion');

    public function index($id)
    {        
        if(is_null($id) or !in_array($id,$this->tabs)){
            return redirect('/home/consultar');
        }

        if($id === 'consultar'){
            return view("users.docenteHome")
                    ->withTab($id) 
                    ->withCourses(CoursesController::allTeacherCourses());
        }elseif($id==='crear'){
            return view("users.docenteHome")->withTab($id)->withAvailableCourses(CoursesController::allCourses());
        }
        
        return view("users.docenteHome")->withTab($id);
    }
}
