<?php

namespace App\Http\Controllers\Session;

use App\Models\Director;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CRUD\CoursesController;

class DirectorController extends Controller
{
    private $tabs = array('consultar','crear','configuracion','programa');

    public function index($id)
    {        
        if(is_null($id) or !in_array($id,$this->tabs)){
            return redirect('/home/consultar');
        }

        if($id === 'consultar'){
            return view("users.directorHome")
                    ->withTab($id) 
                    ->withCourses(CoursesController::paginateCourses())
                    ->with(['directorCourseView'=>true]);
        }elseif($id === 'crear'){
            return view("users.directorHome")
                    ->withTab($id) 
                    ->withAvailableCourses(CoursesController::allCourses());
        }
        
        return view("users.directorHome")->withTab($id);
    }

}
