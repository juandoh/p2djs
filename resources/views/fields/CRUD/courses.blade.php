@php
    $options = [
        '1'=>'Asignatura Basica',
        '2'=>'Asignatura profesional',
        '3'=>'Electiva complementaria',
        '4'=>'Electiva profesional'
    ];
@endphp

<div style="display: none;" id="precourseSelector">
    @isset ($availableCourses)
        @php
            $precoursesOptions = array();
            foreach($availableCourses as $elem){
                $precoursesOptions[$elem->id]=$elem->name;
            }
            echo "<script>var precoursesOptions=".json_encode($precoursesOptions).";</script>";
            unset($precoursesOptions);
        @endphp
    @endisset
</div>

<script type="text/javascript">
    var precourseList = [];
</script>

@if(isset($course))
    {!! Form::hidden('id', $course->id, ['id'=>"course_id"]) !!}
    {!! Form::hidden('created_by', $course->creator->id) !!}
@else
    {!! Form::hidden('created_by', Auth::id()) !!}
@endif

<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
    {{ Form::label('name', 'Nombre del curso', ['class' => 'control-label']) }}
    {{ Form::text('name',(isset($course) ? $course->name : old('name')),['class'=>'form-control','required'=>''])  }}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'name')}}
</div>

<div class="row {{ $errors->has('weekHours') ? ' has-error' : '' }}">
    <div class="form-group col-md-4 col-sm-4 {{ $errors->has('credits') ? ' has-error' : '' }}">
        {{ Form::label('credits', 'Creditos:', ['class' => 'control-label']) }}
        {{ Form::number('credits',(isset($course) ? $course->credits:old('credits')),['class'=>'form-control','required'=>'','min'=>0,'max'=>20])  }}
        {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'credits')}}
    </div>

    <div class="form-group col-md-4 col-sm-4 {{ $errors->has('mhours') ? ' has-error' : '' }}">
        {{ Form::label('mhours', 'Horas Magistrales:', ['class' => 'control-label']) }}
        {{ Form::number('mhours',(isset($course) ? $course->mhours:old('mhours')),['class'=>'form-control','required'=>'','min'=>0,'max'=>20])  }}
        {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'mhours')}}
    </div>

    <div class="form-group col-md-4 col-sm-4 {{ $errors->has('ihours') ? ' has-error' : '' }}">
        {{ Form::label('ihours', 'Horas Individuales:', ['class' => 'control-label']) }}
        {{ Form::number('ihours',(isset($course) ? $course->ihours:old('ihours')),['class'=>'form-control','required'=>'','min'=>0,'max'=>20])  }}
        {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'ihours')}}
    </div>
</div>

<div class="form-group col-md-offset-1 {{ $errors->has('weekHours') ? ' has-error' : '' }}">
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'weekHours')}}
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group well {{ $errors->has('ctype') ? ' has-error' : '' }}">
            {{ Form::label('ctype', 'Tipo de Asignatura:', ['class' => 'control-label']) }}
            @foreach($options as $val=>$opt)
                <div class="radio">
                    <label>
                        @if(isset($course))
                            @if($course->ctype == (int)$val)
                                {{ Form::radio('ctype',$val, true) }}
                            @else
                                {{ Form::radio('ctype',$val) }}
                            @endif
                        @else
                            @if (old('ctype')==(int)$val)
                                {{ Form::radio('ctype',$val, true) }}
                            @else
                                {{ Form::radio('ctype',$val) }}
                            @endif
                            @if(is_null(old('ctype')))
                                {{ Form::radio('ctype',$val, ((((int)$val)==1)?true:false)) }}
                            @endif
                        @endif
                        {{ $opt }}
                    </label>
                </div>
            @endforeach
            {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'ctype')}}
        </div>
    </div>
    <div class="col-md-6">
        <div class="well">
            {{ Form::label('', 'Caracteristicas:', ['class' => 'control-label']) }}
            <br>
            <div class="row">
                {{ Form::label('valuable', 'Validable:', ['class' => 'control-label col-md-4']) }}
                <div class="col-md-8">
                    <label class="radio-inline">
                        {{ Form::radio('valuable', 1, (isset($course)?(($course->valuable==1)?true:false):true)) }}
                        Si
                    </label>
                    <label class="radio-inline">
                        {{ Form::radio('valuable',0, (isset($course)?(($course->valuable==0)?true:false):true)) }}
                        No
                    </label>
                </div>
            </div>
            <div class="row">
                {{ Form::label('qualifiable', 'Habilitable:', ['class' => 'control-label col-md-4']) }}
                <div class="col-md-8">
                    <label class="radio-inline">
                        {{ Form::radio('qualifiable', 1, (isset($course)?(($course->qualifiable==1)?true:false):true)) }}
                        Si
                    </label>
                    <label class="radio-inline">
                        {{ Form::radio('qualifiable',0, (isset($course)?(($course->qualifiable==0)?true:false):true)) }}
                        No
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="well">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-responsive">
                @php $precourseCount = 1; @endphp
                <thead>
                <th>#</th>
                <th>Precurso</th>
                <th>Opciones</th>
                </thead>
                @isset ($precourseList)
                    <tbody id="precourses">
                    @foreach ($precourseList as $precourse)
                        <tr>
                            <th>{{ $precourseCount }}</th>
                            <th>
                                @php $field = "precourse_id_".$precourseCount; @endphp
                                {!! Form::hidden($field, $precourse->id, ["id"=>$field,"style"=>"display:none;"]) !!}
                                {!! Form::hidden($field."_exists", true, ["style"=>"display:none;"]) !!}
                                <label class="control-label">  {{ $precourse->name }} </label>
                                <script type="text/javascript">
                                    precourseList.push({{ $precourseCount }});
                                </script>
                            </th>
                            <th>
                                <a class="btn btn-danger"
                                   onclick="deletePrerequisite('precourse_id_{{$precourseCount}}')">Eliminar
                                    prerrequisito</a>
                            </th>
                        </tr>
                        @php $precourseCount++ @endphp
                    @endforeach
                    </tbody>
                    <script>
                        function deletePrerequisite(id) {
                            var prerequisite = $('#' + id).val();
                            var course_id = $('#course_id').val();
                            axios.post('{{ route('deletePrerequisite') }}', {
                                course_id: course_id,
                                prerequisite: prerequisite
                            })
                                .then(
                                    function (response) {
                                        console.log(response);
                                        if (response['data']['done']) {
                                            swal("Eliminado con exito", "", "success").then(function () {
                                                location.reload()
                                            });
                                        } else {
                                            swal("Ha ocurrido un inconveniente", "", "error").then(function () {
                                                location.reload()
                                            });
                                        }
                                    })
                                .catch(
                                    function (error) {
                                        console.log(error);
                                    });
                        }
                    </script>
                @else
                    <tbody id="precourses">
                    </tbody>
                @endisset
            </table>
        </div>
    </div>
    <label>Agregar Precurso</label>
    <label class="form-control" class="btn btn-info" onclick="addPrerequisite()">
        <center>
            <span class="glyphicon glyphicon-plus"></span>
        </center>
    </label>
</div>

<script type="text/javascript">
    var precourseCount = {{ $precourseCount }};

    function removePrerequisite(key) {
        var i;
        for (i = 0; i < precourseList.length; i++) {
            if (key === precourseList[i]["key"])
                break;
        }
        //var index = precourseList.indexOf(key);
        if (precourseList.length > 0) {
            precourseList.splice(i, 1);
            $("#pre" + key).remove();
        }
    }

    function addPrerequisite() {
        var selector = $("#precourseSelector").html();
        swal({
            title: '<h3>Seleccione un curso prerrequisito</h3>',
            type: 'info',
            input: 'select',
            inputClass: 'form-control',
            inputOptions: precoursesOptions,
            inputPlaceholder: '',
            showCancelButton: true,
        }).then(function (result) {
            if (result.value) {
                var key = precourseList.length;
                var j, exists = false;
                for (j = 0; j < key; j++) {
                    if (precourseList[j]["result"] === result.value) {
                        exists = true;
                    }
                }
                if (!exists) {
                    var toPush = {"key": key, "result": result.value};
                    var i, done = false;

                    if (key > 0) {
                        if (precourseList[0]["key"] !== 0) {
                            key = 0;
                            toPush["key"] = 0;
                            precourseList.splice(0, 0, toPush);
                            done = true;
                        }
                    }

                    if (!done) {
                        for (i = 0; i < key - 1; i++) {
                            if (precourseList[i + 1]["key"] - precourseList[i]["key"] > 1) {
                                key = precourseList[i]["key"] + 1;
                                toPush["key"] = key;
                                precourseList.splice(i + 1, 0, toPush);
                                done = true;
                                break;
                            }
                        }
                    }

                    if (!done) {
                        precourseList.push(toPush);
                    }
                    console.log(precourseList);

                    $("#precourses").html("");
                    precourseList.forEach(function (item, index) {
                        key = item["key"];
                        result = item["result"];
                        var html = `
                    <tr id="pre${key}">
                    <th>
                    ${key + 1}
                    </th>
                    <th>
                    <input type="hidden" name="precourse_id_${key + 1}" value="${result}" style="display:none;">
                    <input type="hidden" name="precourse_id_${key + 1}_exists" value="0" style="display:none;">
                    <label class="control-label">${precoursesOptions[result]}</label>
                    </th>
                    <th>
                    <a class="btn btn-warning" onclick="removePrerequisite(${key})">X</a>
                    </th>
                    </tr>`;
                        $("#precourses").append(html);
                    });
                } else {
                    swal("Error", "El Prerequisito ya existe", "error");
                }
            }
        });
    }

</script>

<div class="well">
    @include('fields.CRUD.programSelector')
</div>


<div class="form-group">
    {{ Form::label('semester', 'Semestre al que pertenece:', ['class' => 'control-label']) }}
    {{ Form::number('semester',(isset($course) ? $course->semester:old('semester')),['class'=>'form-control','required'=>'','min'=>0,'max'=>20])  }}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'semester')}}
</div>
