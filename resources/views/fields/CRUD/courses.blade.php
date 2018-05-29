@php
    $options = [
        '1'=>'Asignatura Basica',
        '2'=>'Asignatura profesional',
        '3'=>'Electiva complementaria',
        '4'=>'Electiva profesional'
    ];
    //$availableCourses = App\Http\Controllers\CRUD\CoursesController::allCourses();
    //$userRole =  Role::resolveRole(Auth::id()); 
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

@if(isset($course))
    {!! Form::hidden('id', $course->id) !!}
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

<div class="well">
    {{ Form::label('', 'Caracteristicas:', ['class' => 'control-label']) }}
    <br>
    <div class="row">
        {{ Form::label('valuable', 'Validable:', ['class' => 'control-label col-md-2']) }}
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
        {{ Form::label('qualifiable', 'Habilitable:', ['class' => 'control-label col-md-2']) }}
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

<div class="well">
    <div class="row" id="precourses">        
    </div>
    <label> Agregar Precurso</label>
    <label class="form-control" class="btn btn-info" id="addPrecourse">
        <center>
            <span class="glyphicon glyphicon-plus"></span>
        </center>
    </label>
</div>

<script type="text/javascript">
    var precourseCount = 1;
    $(document).ready(function() {
        $("#addPrecourse").click(function(){
            var selector = $("#precourseSelector").html();            
            swal({
              title: '<h3>Seleccione un curso prerrequisito</h3>',
              type:'info',
              input: 'select',
              inputClass:'form-control',
              inputOptions: precoursesOptions,
              inputPlaceholder: '',
              showCancelButton: true,              
            }).then(function (result) {                
                if(result.value){
                    console.log(result);
                    var html = `<div class="col-md-12">
                                    <label>Precurso ${precourseCount}</label>
                                    <input type="hidden" name="precourse_id_${precourseCount}" value="${result.value}">
                                    <label class="control-label form-control">${precoursesOptions[result.value]}</label>
                                </div>`;
                    $("#precourses").append(html);
                }
            });
        });
    });
</script>

<div class="well">
    @include('fields.CRUD.programSelector')    
</div>


<div class="form-group">
    {{ Form::label('semester', 'Semestre al que pertenece:', ['class' => 'control-label']) }}
    {{ Form::number('semester',(isset($course) ? $course->semester:old('semester')),['class'=>'form-control','required'=>'','min'=>0,'max'=>20])  }}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'semester')}}
</div>
