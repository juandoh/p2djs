@extends('layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Bienvenido Decano</div>
        <div class="panel-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @if(isset($tab))
                <?php $tabs=[
                    'consultar'=>'Consultar Cursos',
                    'programas'=>'Consultar Programas',
                    'crear'=>'Crear Programa Academico',
                    'configuracion'=>'Configuración'
                ];?>
                @include('users.homeTabs')                
            @endif

            <div class="tab-content">
                @if($tab === 'consultar')
                    <div id="home" class="tab-pane fade  in active  ">
                        @include('lists.courses')
                    </div>
                @endif
                @if($tab === 'programas')
                    <div id="home" class="tab-pane fade  in active  ">
                        <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4>Listado de Programas Academicos:</h4>
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
                                            <th>Escuela</th>
                                            <th>Opciones</th>
                                        </thead>
                                        @if(isset($programs))
                                            <tbody id="myTable">                                                
                                                @foreach($programs as $program)
                                                    <tr>
                                                        <th>{{$program->id}}</th>
                                                        <th>{{$program->name}}</th>
                                                        <th>{{ $program->fschool->name }}</th>
                                                        <th>@include('forms.listBtn',['where'=>'Program','id'=>$program->id,'deleted'=>!is_null($program->deleted_at)])</th>
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
                    @include('forms.CRUD.master',
                            ['master'=>
                                ['title'=>'Programa Académico',
                                'option'=>'create',
                                'model'=>'Program',
                                'fields'=>'programs']])
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
