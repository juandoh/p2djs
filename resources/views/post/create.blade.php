@extends('layouts.app')

@section('content')


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
{{--

@if(session()->has('message'))
    <div class="alert alert-success">
        {{ session()->get('message') }}
    </div>
@endif
--}}


@php
    $asd = Form::getSession(); 
    echo var_dump($asd);
    //echo old("body");
@endphp 
{{--
@foreach ($asd as $key=>$el)
    {{ $key }}
    {{ var_dump($el) }}
    
    <br>
@endforeach
--}}

<form action="/post" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    {{--<div class="form-group">
        <input type="text" name="title" class="form-control"/>
        @if ($errors->has('title'))
            <span class="help-block">
                <strong>{{ $errors->first('title') }}</strong>
            </span>
        @endif
    </div>--}}

    <div class="form-group {{ $errors->has('title') ? ' has-error' : '' }}">
        <div class="col-md-6">  
                {{ Form::text('title','',['class'=>'form-control','value'=>old('title')])  }}
                {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'title')}}
        </div>
    </div>
    <div class="form-group {{ $errors->has('option') ? ' has-error' : '' }}">
        <div class="col-md-6">
            
                <?php
                    $users = App\Http\Controllers\CRUD\FacultiesController::allFaculties();
                    $options = array();
                    foreach($users as $user){
                        $options += array($user->id => $user->fullname);
                    }
                ?>
                {{ Form::select('option',
                                ['-1'=>'Select']+$options,
                                'None',
                                ['class'=>'form-control','value'=>old('option')])  }}

                {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'option')}}

        </div>
    </div>
    <div class="form-group {{ $errors->has('body') ? ' has-error' : '' }}">
        <input type="text" name="body" class="form-control" value="{{ old('body') }}"/>
    </div>
    <div class="form-group">
            <input type="submit" name="submit" class="btn btn-info" value="Submit"/>
    </div>
</form>

@endsection