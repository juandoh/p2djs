@extends('layouts.app')

@section('content')
    @if(isset($course))
        @php  if(!isset($show)) $show=false;@endphp
        <div class="panel-group">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="row">
                        <h4 class="col-md-6">Diseño del Curso: {{ $course->name }}</h4>
                        <div class="col-md-6">
                            <div class="btn-group" style="float:right;">
                                <a class="btn btn-warning" href="/home/consultar">Volver</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <script type="text/javascript">
                                var accordionCount = 1;
                                var competenceCount = 1;
                                var competences = [];
                            </script>
                            <div class="row">
                                <div class="col-md-8 col-sm-9 col-xs-9">
                                    <label class="control-label" style="padding-top: 5px;">
                                        <h4>Competencias</h4>
                                    </label>
                                </div>
                                @if(!$show)
                                    <div class="col-md-4 col-sm-3 col-xs-3">
                                        <a class="btn btn-default btn-lg" style="float:right;" id="addCompetence"
                                           href="/design/course/{{ $course->id }}/new">
                                            Agregar Competencia
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="panel-group" id="accordion0">
                                @isset ($competences)
                                    @if(!count($competences))
                                        <div class="panel panel-warning">
                                            <div class="panel-heading">
                                                <h4>No hay competencias a mostrar</h4>
                                            </div>
                                        </div>
                                    @endif
                                    @foreach ($competences as $competence)
                                        <div class="panel panel-info">
                                            <div class="panel-heading">
                                                <div class="row">
                                                    <div class="col-md-6 col-sm-7 col-xs-7">
                                                        <h4>
                                                            <label>
                                                                {{ $competence->name }}:
                                                            </label>
                                                            @if(!$show)
                                                                <div style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $competence->detail }}</div>
                                                            @endif
                                                        </h4>
                                                    </div>
                                                    @if(!$show)
                                                        <div class="col-md-6 col-sm-5">
                                                            <div class="btn-group btn-group-lg"
                                                                 style="float:right; padding-top: 10px;">
                                                                <a class="btn btn btn-info"
                                                                   href="{{ url('/design/course/'.$course->id.'/edit_competence/'.$competence->id) }}">Modificar</a>
                                                                <a class="btn btn-danger"
                                                                   onclick="$('#eliminarCompetencia').submit()">Eliminar
                                                                    {{ Form::open(['url'=>'/delete_competence', 'id'=>"eliminarCompetencia", 'style'=>"display:none;"]) }}
                                                                    <input type="hidden" name="competence_id"
                                                                           value="{{ $competence->id }}">
                                                                    <input type="hidden" name="course_id"
                                                                           value="{{ $course->id }}">
                                                                    {{ Form::close() }}
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($show)
                                                <div class="panel-body">
                                                    <label>Descripción: {{ $competence->detail }}</label>
                                                    @php
                                                        $learning_outcomes = $competence->learning_outcomes()->get();
                                                    @endphp
                                                    <ul>
                                                        @foreach($learning_outcomes as $learning_outcome)
                                                            <li>
                                                                <label>{{$learning_outcome->name}}</label>
                                                                <p>{{$learning_outcome->detail}}</p>
                                                            </li>
                                                            @php
                                                                $indicators = $learning_outcome->indicators()->get();
                                                            @endphp
                                                            <ul>
                                                                @foreach($indicators as $indicator)
                                                                    <li>
                                                                        <label>{{$indicator->name}}</label>
                                                                        <p>{{$indicator->detail}}</p>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                @endisset()
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{--
    <script type="text/javascript">
        window.onbeforeunload = function() {
            return "La informacion sin guardar se perderá";
        }
    </script>
     --}}
@endsection