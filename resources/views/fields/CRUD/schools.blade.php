@if(isset($school))
    <input type="hidden" name="id" value="{{ $school->id }}"/>
@endif
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {{ Form::label('name', 'Nombre de la Escuela', ['class'=>'control-label']) }}        
    {{ Form::text('name', (isset($school)?$school->name:old('name')), ['class'=>'form-control','required'=>'']) }}
    {{--onkeyup="check('sname','shortname','snamegroup')" --}}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'name')}}
</div>
<div class="form-group{{ $errors->has('faculty') ? ' has-error' : '' }}">
    {{ Form::label('faculty', 'Seleccione una Facultad', ['class' => 'control-label']) }}
    <?php
        $faculties = App\Http\Controllers\CRUD\FacultiesController::allFaculties();
        $options = array();
        foreach($faculties as $faculty){
            $options += array($faculty->id => $faculty->name);
        }
    ?>
    {{ Form::select('faculty',
                    ['-1'=>'']+$options,
                    (isset($school) ? $school->faculty:old('school')),
                    ['class'=>'form-control','required'=>''])  }}

    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'faculty')}}
</div>
<div class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
    {{ Form::label('detail', 'Descripción', ['class'=>'control-label']) }}        
    {{ Form::textarea('detail', (isset($school)?$school->detail:old('detail')), ['class'=>'form-control','required'=>'']) }}
    {{--onkeyup="check('sname','shortname','snamegroup')" --}}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'detail')}}
</div>