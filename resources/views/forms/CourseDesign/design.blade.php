@extends('layouts.app')

@section('content')
    @if(isset($course))
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
                        <div class="panel-heading"
                        >
                            <script type="text/javascript">
                                var accordionCount = 1;
                                var competenceCount = 1;
                                var competences = [];
                            </script>
                            <div class="row">
                                <div class="col-md-8 col-sm-9 col-xs-9">
                                    <label class="control-label" style="padding-top: 5px;">
                                        Competencias
                                    </label>
                                </div>
                                <div class="col-md-4 col-sm-3 col-xs-3">
                                    <a class="btn btn-default" style="float:right;" id="addCompetence"
                                       href="/design/course/{{ $course->id }}/new">
                                        Agregar Competencia
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="panel-group" id="accordion0">
                            @isset ($competences)
                                @php
                                    $competence_count = 1;
                                @endphp
                                @foreach ($competences as $competence)
                                    <div class="panel panel-info">
                                        <div class="panel-heading">
                                            <div class="row">
                                                <div class="col-md-8 col-sm-8">
                                                    <h4>
                                                        Competencia {{ $competence_count }}
                                                    </h4>
                                                </div>
                                                <div class="col-md-4 col-sm-4">
                                                    <div class="btn-group" style="float:right;">
                                                        <a class="btn btn-info" href="#">Modificar</a>
                                                        <a class="btn btn-danger" href="#">Elminiar</a>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    @php
                                        $competence_count++;
                                    @endphp
                                @endforeach
                            @endisset()
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