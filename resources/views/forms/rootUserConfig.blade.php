@extends('layouts.app')

@section('content')    
    <div class="panel panel-success">
        <div class="panel-heading">            
            <a href="/home" class="btn btn-success form-control">Volver</a>
        </div>
        <div class="panel-body">
            @include('forms.userConfig')
        </div>        
    </div>            
@endsection