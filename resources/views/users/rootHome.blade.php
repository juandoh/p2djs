@extends('layouts.app')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">Bienvenido Administrador</div>
    <div class="panel-body">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if(isset($tab))
            <?php $tabs=[
                'consultar'=>'Consultar Usuarios',
                'crear/docente'=>'Crear Usuarios',
                'facultades'=>'Manejo de Facultades',
                'escuelas'=>'Manejo de Escuelas'
            ];?>
            
            @include('users.homeTabs')             
            
        @endif 
                
        <div class="tab-content">
            @if($tab === 'consultar')
                <div id="home" class="tab-pane active">
                    @include('lists.users')
                </div>
            @endif
            @if($tab === 'crear')
                <div id="menu1" class="tab-pane fade in active">                    
                    <div class="panel panel-success">
                        <div class="panel-heading"><h4>Crear Usuario</h4></div>
                        <div class="panel-body">

                            {!! Form::open(['route'=>'register','class'=>'form-horizontal']) !!}
                            @include('fields.CRUD.user')
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary form-control">
                                        Crear Usuario
                                    </button>
                                </div>
                            </div>
                            {!! Form::close() !!}                             
                        </div>
                    </div>
                </div>
            @endif
            @if($tab === 'escuelas')
                <div id="menu2" class="tab-pane fade in active">
                    <div class="panel-group">
                        @include('forms.CRUD.master',
                            ['master'=>
                                ['title'=>'Escuela',
                                'option'=>'create',
                                'model'=>'School',
                                'fields'=>'schools']])
                        @include('lists.schools')
                    </div>
                </div>
            @endif
            @if($tab === 'facultades')
                <div id="menu3" class="tab-pane fade  in active">
                    <div class="panel-group">
                        @include('forms.CRUD.master',
                            ['master'=>
                                ['title'=>'Facultad',
                                'option'=>'create',
                                'model'=>'Faculty',
                                'fields'=>'faculties']]) 
                        @include('lists.faculties')
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
        
@endsection
