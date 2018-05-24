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
            <ul class="nav nav-tabs">
                <li 
                @if($tab === 'consultar')
                    class = "active"                                
                @endif
                ><a href="/home/consultar">Consultar Usuarios</a></li>
                <li 
                @if($tab === 'crear')
                    class = "active"
                @endif
                ><a href="/home/crear/docente">Crear Usuarios</a></li>
                <li 
                @if($tab === 'facultades')
                    class = "active"
                @endif
                ><a href="/home/facultades">Manejo de Facultades</a></li>
                <li 
                @if($tab === 'escuelas')
                    class = "active"
                @endif
                ><a href="/home/escuelas">Manejo de Escuelas</a></li>
            </ul>
        @endif
        
        <div class="tab-content">
            @if($tab === 'consultar')
                <div id="home" class="tab-pane fade in active">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h4>Listado de Usuarios:</h4>
                            <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
                            <script>
                                $(document).ready(function(){
                                    $("#myInput").on("keyup", function() {
                                    var value = $(this).val().toLowerCase();
                                    $("#myTable tr").filter(function() {
                                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                    });
                                    });
                                });
                            </script>
                        </div>                  
                        <div class="panel-body">
                            <table class="table table-responsive table-hover">
                                <thead>
                                    <th>Id</th>
                                    <th>Nombre</th>                                                
                                    <th>Rol</th>
                                    <th>Habilitado</th>
                                    <th>Opciones</th>
                                </thead>
                                @if(isset($users))
                                    <tbody id="myTable">
                                        @foreach($users as $user)
                                            <tr>
                                                <th>{{$user->id}}</th>
                                                <th>{{$user->fullname}}</th>                                                            
                                                @if($user->role == 0)
                                                    <th> Administrador </th>
                                                @elseif($user->role == 1)
                                                    <th> Docente </th>
                                                @elseif($user->role == 2)
                                                    <th> Director </th>
                                                @elseif($user->role == 3)
                                                    <th> Decano </th>
                                                @endif
                                                @if(!is_null($user->deleted_at))
                                                    <th> No </th>
                                                @else
                                                    <th> Si </th>
                                                @endif

                                                @if($user->role != 0)
                                                    <th>@include('forms.listBtn',['where'=>'User','object'=>$user])</th>
                                                @endif
                                            </tr>                                                        
                                        @endforeach
                                    </tbody>                                                
                                @endif
                            </table>
                            @if(isset($users))
                            <center>{{ $users->links() }}</center>
                            @endif
                        </div>
                    </div>

                </div>
            @endif
            @if($tab === 'crear')
                <div id="menu1" class="tab-pane fade in active">
                    <div class="panel panel-success">
                        <div class="panel-heading"><h4>Crear Usuario</h4></div>
                        <div class="panel-body">
                            
                            {!! Form::open(['route'=>'register','class'=>'form-horizontal']) !!}
                                @include('fields.user')
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
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h5>Listado de Escuelas:</h5>
                                <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
                                <script>
                                    $(document).ready(function(){
                                        $("#myInput").on("keyup", function() {
                                        var value = $(this).val().toLowerCase();
                                        $("#myTable tr").filter(function() {
                                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                        });
                                        });
                                    });
                                </script>                                
                            </div>

                            <div class="panel-body">
                                <table class="table table-responsive table-hover">
                                    <thead>
                                        <th>Id</th>
                                        <th>Nombre</th>                                                
                                        <th>Descripción</th>                                                
                                        <th>Opciones</th>
                                    </thead>
                                    @if(isset($schools))
                                        <tbody id="myTable">
                                            @foreach($schools as $school)
                                                <tr>
                                                    <th>{{$school->id}}</th>
                                                    <th>{{$school->name}}</th>
                                                    <th>{{$school->detail}}</th>
                                                    <th>@include('forms.listBtn',['where'=>'School','object'=>$school])</th>                                  
                                                                                             
                                                </tr>                                                        
                                            @endforeach
                                        </tbody>                                                
                                    @endif
                                </table>
                                @if(isset($schools))
                                <center>{{ $schools->links() }}</center>
                                @endif
                            </div>
                        </div>
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
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h5>Listado de Facultades:</h5>
                                <input class="form-control" id="myInput" type="text" placeholder="Buscar..">
                                <script>
                                    $(document).ready(function(){
                                        $("#myInput").on("keyup", function() {
                                        var value = $(this).val().toLowerCase();
                                        $("#myTable tr").filter(function() {
                                            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                                        });
                                        });
                                    });
                                </script>                                
                            </div>

                            <div class="panel-body">
                                <table class="table table-responsive table-hover">
                                    <thead>
                                        <th>Id</th>
                                        <th>Nombre</th>                                                
                                        <th>Descripción</th>                                                
                                        <th>Opciones</th>
                                    </thead>
                                    @if(isset($faculties))
                                        <tbody id="myTable">
                                            @foreach($faculties as $faculty)
                                                <tr>
                                                    <th>{{$faculty->id}}</th>
                                                    <th>{{$faculty->name}}</th>
                                                    <th>{{$faculty->detail}}</th>
                                                    <th>@include('forms.listBtn',['where'=>'Faculty','object'=>$faculty])</th>
                                                    
                                                </tr>                                                        
                                            @endforeach
                                        </tbody>                                                
                                    @endif
                                </table>
                                @if(isset($faculties))
                                <center>{{ $faculties->links() }}</center>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
        
@endsection
