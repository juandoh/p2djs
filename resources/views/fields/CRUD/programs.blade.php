@if(isset($program))
    <input type="hidden" name="id" value="{{ $program->id }}"/>
@endif
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">        
    {{ Form::label('name', 'Nombre del Programa Academico', ['class'=>'control-label']) }}        
    {{ Form::text('name', (isset($program)?$program->name:old('name')), ['class'=>'form-control','required'=>'']) }}
    {{--onkeyup="check('name','fullname','fnamegroup')" --}}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'name')}}
</div>
<div class="form-group{{ $errors->has('school') ? ' has-error' : '' }}" id="schoolgroup">
    <?php 
        $options=[];
        if(isset($schools)){
            foreach($schools as $school){
                $options+=[$school->id=>$school->name];
            }
        }
    ?>
    
    {{ Form::label('school', 'Escuela', ['class'=>'control-label']) }}         
    {{ Form::select('school',
                    ['-1'=>'']+$options,
                    (isset($program)?$program->school:old('school')),
                    ['class'=>'form-control','required'=>'','value'=>old('school')])  }}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'school')}}        
</div>
<div class="form-group{{ $errors->has('semesters') ? ' has-error' : '' }}" id="semestergroup">
    {{ Form::label('semesters', 'Semestre', ['class'=>'control-label']) }}
    {{ Form::number('semesters',(isset($program)?$program->semesters:old('semesters')),['class'=>'form-control','required'=>'']) }}
    {{-- //onkeyup="check('email','shortname','emailgroup')"  --}}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'semesters')}}    
</div>

<div class="form-group{{ $errors->has('credits') ? ' has-error' : '' }}" id="creditsgroup">
        {{ Form::label('credits', 'Creditos', ['class'=>'control-label']) }}
        {{ Form::number('credits',(isset($program)?$program->credits:old('credits')),['class'=>'form-control','required'=>'']) }}
        {{-- //onkeyup="check('email','shortname','emailgroup')"  --}}
        {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'credits')}}    
    </div>