<?php

namespace App\Http\Controllers\Session;

use App\Models\Decano;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CRUD\CoursesController;
use App\Http\Controllers\CRUD\SchoolsController;
use App\Http\Controllers\CRUD\AcademicProgramsController;

class DecanoController extends Controller
{
    
    private $tabs = array('consultar','crear','configuracion');

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(is_null($id)){
            return redirect('/home/consultar');
        }

        if($id === 'consultar')
            return view("users.decanoHome",["tab"=>$id])
        ->withCourses(CoursesController::paginateCourses())
        ->with(['deanCourseView'=>true]);
        elseif($id === 'crear')
            return view("users.decanoHome",["tab"=>$id])->withSchools(SchoolsController::allSchools());
        elseif($id === 'programas')
            return view("users.decanoHome",["tab"=>$id])->withPrograms(AcademicProgramsController::paginatePrograms());
        else
            return view("users.decanoHome",["tab"=>$id]);
    }
}
