@php
    $faculties = App\Http\Controllers\CRUD\FacultiesController::allFaculties();
    $options = array();
    foreach($faculties as $faculty){
        $options += array($faculty->id => $faculty->name);
    }    
    if(isset($relation)){
        if(!is_null($relation->faculty_id))
            $value=$relation->faculty_id;
    }
    if(!isset($value)){
        $value = -1;
    }
@endphp
<div class="row">
    <div class="form-group {{ $errors->has('faculty_id') ? ' has-error' : '' }}">
        {{ Form::label('faculty', 'Seleccione una Facultad', ['class' => 'control-label col-md-4']) }}
        <div class="col-md-6">
        {{ Form::select('faculty_id',
                        ['-1'=>'']+$options,
                        $value,
                        ['class'=>'form-control','required'=>''])  }}
        {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'faculty_id')}}
        </div>
        
    </div>
</div>