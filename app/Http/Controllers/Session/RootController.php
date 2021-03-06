<?php

namespace App\Http\Controllers\Session;

use Auth;
use Alert;
use App\User;
use Relations;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CRUD\CoursesController;
use App\Http\Controllers\CRUD\FacultiesController;
use App\Http\Controllers\CRUD\SchoolsController;
use App\Http\Controllers\Auth\RegisterController;

class RootController extends Controller
{
    private $tabs = array('consultar','crear','escuelas','facultades');
    private $create = array('docente','director','decano');
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, $createWhat=null)
    {        
        if(!is_null($createWhat))
            if(in_array($id,$this->tabs) and in_array($createWhat,$this->create))
                return view("users.rootHome",["tab"=>$id,"userType"=>$createWhat]);
            else
                return redirect('/home/consultar'); 
        if(is_null($id) or !in_array($id,$this->tabs)){
            return redirect('/home/consultar');
        }

        if($id==='consultar'){
            return view("users.rootHome",["tab"=>$id])->withUsers(RegisterController::listUsers());
        } else if ($id==='facultades'){
            return view("users.rootHome",["tab"=>$id])->withFaculties(FacultiesController::paginateFaculties());
        } else if ($id==='escuelas'){
            return view("users.rootHome",["tab"=>$id])->withSchools(SchoolsController::paginateSchools());  
        } else {
            return view("users.rootHome",["tab"=>$id]);
        }
    }

    public function editUser($id = null, $tab = null){
        if(!is_null($id)){
            if(!is_null($tab))
                if(!in_array($tab,$this->create))
                    return redirect()->back();
            
            if (Relations::isAdmin(Auth::id())){
                $user = User::find($id);                
                if(!is_null($user))
                    return view('forms.rootUserConfig',['user'=>$user, 'userType'=>$tab,'editing'=>true]);
                else
                    alert()->error('Error!','La cuenta se encuentra deshabilitada');
            }
        }
        return redirect()->back();
    }

}
