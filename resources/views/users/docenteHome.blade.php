@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Bienvenido Docente</div>

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
                    ><a href="/home/consultar">Consultar Cursos</a></li>
                    <li 
                    @if($tab === 'crear')
                        class = "active"
                    @endif
                    ><a href="/home/crear">Crear Cursos</a></li>
                    <li 
                    @if($tab === 'configuracion')
                        class = "active"
                    @endif
                    ><a href="/home/configuracion">Configuración</a></li>
                </ul>
            @endif           
            
            <div class="tab-content">
                @if($tab === 'consultar')
                    <div id="home" class="tab-pane fade  in active  ">
                        <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h3>Listado de Cursos:</h3>
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
                                            <th>Programa Academico</th>                                        
                                            <th>Opciones</th>
                                        </thead>
                                        @if(isset($courses))
                                            <tbody id="myTable">
                                                @foreach($courses as $course)
                                                    <tr>
                                                        <th>{{$course->id}}</th>
                                                        <th>{{$course->name}}</th>
                                                        <th>{{$course->p_academico->name}}</th>
                                                        {{--
                                                        @if($user->role != 0)
                                                        <th>
                                                            <a href="{{ '/home/user/'.$user->id }}" class="btn btn-primary">Editar</a>
                                                            @if(!is_null($user->deleted_at))
                                                                <form method="POST" action="{{ '/enableUser/'.$user->id }}" class="btn">
                                                                    {{ csrf_field() }}
                                                                    <input type="submit" class="btn btn-warning" value="Habilitar"/>
                                                                </form>
                                                            @else
                                                                <form method="POST" action="{{ '/deleteUser/'.$user->id }}" class="btn">
                                                                    {{ csrf_field() }}
                                                                    <input type="submit" class="btn btn-danger" value="Eliminar"/>
                                                                </form>
                                                            @endif                                                        
                                                        </th>
                                                        @endif--}}
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
                    <div id="menu1" class="tab-pane fade  in active ">
                        {{--@include('forms.CRUD.courses',['type'=>'create'])--}}
                        @include('forms.CRUD.master',
                                ['master'=>
                                    ['title'=>'Cursos',
                                    'option'=>'create',
                                    'model'=>'Course',
                                    'fields'=>'courses']])
                    </div>
                @endif
                @if($tab === 'configuracion')
                    <div id="menu2" class="tab-pane fade  in active">
                        @include('forms.userConfig', ['user'=>Auth::user()])
                    </div>
                @endif
            </div>
        </div>
    </div>        
@endsection
