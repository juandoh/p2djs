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
                <?php $tabs=[
                    'consultar'=>'Consultar Cursos',
                    'crear'=>'Crear Cursos',
                    'configuracion'=>'Configuración'
                ];?>
                @include('users.homeTabs')             
            @endif                    
            
            <div class="tab-content">
                @if($tab === 'consultar')
                    <div id="home" class="tab-pane fade  in active  ">
                        <?php
                            if(isset($courses)){                                
                                $tableHeaders = ['Id','Nombre','Prorgama Academico','Opciones'];
                                $tableContent = array();
                                foreach ($courses as $course){
                                    $row = ['id'=>$course->id,$course->name,$course->program->name,'deleted'=>null];
                                    array_push($tableContent,$row);
                                }
                                $what='Cursos';
                                $where = 'Course';
                                $links = $courses->links();
                            }
                        ?>
                        @include('lists.listModel')
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
