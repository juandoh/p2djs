<?php

namespace App\Http\Controllers\Testing;

use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{
    public function show(){
        return view('post.create');
     }
     public function store(Request $request){
        //print_r($request->all());
        dd($request->all());
        $validator = Validator::make($request->all(),[
           'title'=>'required|max:8',
           'option'=>'required|exists:users,id',
           'body'=>'required'
        ]);

        $validator->validate();

        //return redirect()->route('post');
        alert()->success("Success","lol success");
        return redirect()->back();
     }
}
