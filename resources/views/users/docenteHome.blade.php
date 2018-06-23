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
                @php
                    $tabs=[
                        'consultar'=>'Consultar Cursos',
                        'crear'=>'Crear Cursos',
                        'configuracion'=>'Configuración',
                        'reportes'=>"Reportes de Aplicación" //home/reportes
                    ];
                @endphp                
                @include('users.homeTabs')
            @endif                    
            
            <div class="tab-content">
                @if($tab === 'consultar')
                    <div id="home" class="tab-pane fade  in active  ">
                        @include('lists.courses')
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
                @if($tab === 'reportes')
                    @include('reports.report')
                @endif
            </div>
        </div>
    </div>        
@endsection
