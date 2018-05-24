<?php

namespace App\Http\Controllers\Session;

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
            if(Auth::user()->role == 3){ // decano
                $decano = new DecanoController();
                return $decano->index($tab);
            } else if (Auth::user()->role == 2){//director
                $director = new DirectorController();
                return $director->index($tab);

            } else if (Auth::user()->role == 1){ //docente
                $docente = new DocenteController;
                return $docente->index($tab);

            } else if (Auth::user()->role == 0){ //admin
                $root = new RootController;
                return $root->index($tab);
            }else{
                Auth::logout();                
            }
        }

        return redirect("/");
    }
}
