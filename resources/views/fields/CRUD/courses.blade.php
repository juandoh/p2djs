<?php 
    $options = [
        '1'=>'Asignatura Basica',
        '2'=>'Asignatura profesional',
        '3'=>'Electiva complementaria',
        '4'=>'Electiva profesional'
    ];
    $programs = App\Http\Controllers\CRUD\AcademicProgramsController::allPrograms();
    $programOpt = array();
    foreach($programs as $program){
        $programOpt += array($program->id => $program->name);
    }
?>

@if(isset($course))
    {!! Form::hidden('id', $course->id) !!}    
@endif

<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">    
    {{ Form::label('name', 'Nombre del curso', ['class' => 'control-label']) }}
    {{ Form::text('name',(isset($course) ? $course->name : old('name')),['class'=>'form-control','required'=>''])  }}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'name')}}
</div>

<div class="form-group {{ $errors->has('credits') ? ' has-error' : '' }}">
    {{ Form::label('credits', 'Creditos:', ['class' => 'control-label']) }}
    {{ Form::number('credits',(isset($course) ? $course->credits:old('credits')),['class'=>'form-control','required'=>'','min'=>0,'max'=>20])  }}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'credits')}}
</div>


<div class="form-group {{ $errors->has('mhours') ? ' has-error' : '' }}">
    {{ Form::label('mhours', 'Horas Magistrales:', ['class' => 'control-label']) }}
    {{ Form::number('mhours',(isset($course) ? $course->mhours:old('mhours')),['class'=>'form-control','required'=>'','min'=>0,'max'=>20])  }}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'mhours')}}
</div>


<div class="form-group {{ $errors->has('ihours') ? ' has-error' : '' }}">
    {{ Form::label('ihours', 'Horas de Trabajo Individual:', ['class' => 'control-label']) }}
    {{ Form::number('ihours',(isset($course) ? $course->ihours:old('ihours')),['class'=>'form-control','required'=>'','min'=>0,'max'=>20])  }}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'ihours')}}
</div>

<div class="form-group well {{ $errors->has('ctype') ? ' has-error' : '' }}">
    {{ Form::label('ctype', 'Tipo de Asignatura:', ['class' => 'control-label']) }}
    @foreach($options as $val=>$opt)
        <div class="radio">
            <label>
                @if(isset($course))
                    @if($course->ctype == (int)$val)
                        {{ Form::radio('ctype',$val, ['checked'=>'']) }}
                    @else
                        {{ Form::radio('ctype',$val) }}
                    @endif
                @else
                    {{ Form::radio('ctype',$val) }}
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
    <div class="checkbox-inline">
        <label>
        <input type="checkbox" class="" name="valuable" value="1" 
            @if(isset($course)) 
                @if($course->valuable) 
                    checked
                @endif
            @endif>
            Validable
        </label>    
    </div>
    <div class="checkbox-inline">
        <label>
        <input type="checkbox" class="" name="qualifiable" value="false"
            @if(isset($course)) 
                @if($course->qualifiable)
                    checked
                @endif
            @endif
        >
        Habilitable
        </label>    
    </div>
</div>
<div class="form-group {{ $errors->has('precourses') ? ' has-error' : '' }}">
    {{ Form::label('precourses', 'Prerrequisitos (separados con comas)', ['class' => 'control-label']) }}
    {{ Form::text('precourses',(isset($course) ? $course->precourses:old('precourses')),['class'=>'form-control','required'=>''])  }}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'precourses')}}
</div>
<div class="form-group {{ $errors->has('p_academico') ? ' has-error' : '' }}">
    {{ Form::label('p_academico', 'Seleccione un Programa Academico', ['class' => 'control-label']) }}            
    {{ Form::select('p_academico',
                    ['-1'=>'']+$programOpt,
                    (isset($course) ? $course->p_academico:old('p_academico')),
                    ['class'=>'form-control','required'=>''])  }}

    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'p_academico')}}
</div>
<div class="form-group">
    {{ Form::label('semester', 'Semestre al que pertenece:', ['class' => 'control-label']) }}
    {{ Form::number('semester',(isset($course) ? $course->semester:old('semester')),['class'=>'form-control','required'=>'','min'=>0,'max'=>20])  }}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'semester')}}
</div>

