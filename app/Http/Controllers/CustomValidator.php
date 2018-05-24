<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CustomValidator extends Controller{
    public static function validateField($request,&$rules,&$messages){        
        $data = $request->all();
        $field = $data['field'];
        $toEval = $data['data'];        
        $valid = !Validator::make([$field=>$toEval],[$field=>$rules[$field]],$messages)->fails();
        return ['valid'=>$valid]; 
    }

    public static function errorHelp($errors, string $key){
        if($errors->has($key)){
            echo '<span class="help-block"><strong>'.$errors->first($key).'</strong></span>';
        }
    }

}


