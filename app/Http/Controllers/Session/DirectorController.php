<?php

namespace App\Http\Controllers\Session;

//use App\Models\Director;
use Auth;
use Alert;
use Relations;
use App\Schools;
use App\AcademicPrograms;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CRUD\CoursesController;
//use App\Http\Controllers\CRUD\SchoolsController;

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
        }elseif($id === 'programa'){
            $program_id = Relations::getProgramRelation(Auth::id())->program_id;
            $program = AcademicPrograms::find($program_id);
            $school = Schools::find($program->school);
            return view("users.directorHome")
                    ->withTab($id)
                    ->withProgram($program)
                    ->withSchools([$school]);
        }
        
        return view("users.directorHome")->withTab($id);
    }

}
