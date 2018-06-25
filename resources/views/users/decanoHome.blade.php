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
                    'crear'=>'Crear Programa Académico',
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
                        @include('lists.programs')
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
