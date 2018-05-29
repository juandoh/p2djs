<?php

namespace App\Http\Controllers\Session;

use Relations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class ViewsController extends Controller
{
    /**
     * Display a listing of the resource.
     * Strategy pattern implement
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tab = null)
    {
        //check auth, get login
        if(Auth::check()){
            //the user is logged in
            $user_id = Auth::id();
            $role = Relations::resolveRole($user_id);
            if($role == 3){ // decano
                $decano = new DecanoController();
                return $decano->index($tab);
                //return 'yay decano';
            } else if ($role == 2){//director
                $director = new DirectorController();
                return $director->index($tab);
                //return 'yay director';
            } else if ($role == 1){ //docente
                $docente = new DocenteController;
                return $docente->index($tab);
                //return 'yay docente';
            } else if ($role == 0){ //admin
                $root = new RootController;
                return $root->index($tab);
                //return 'yay root';
            }else{
                Auth::logout();                
            }
        }

        return redirect("/");
    }
}
