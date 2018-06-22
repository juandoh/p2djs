@php
	$programs = App\Http\Controllers\CRUD\AcademicProgramsController::allPrograms();
    $programOpt = array();
    foreach($programs as $program){
        $programOpt += array($program->id => $program->name);
    }	
    
    if(isset($relation)){
    	if(!is_null($relation->program_id))	
    		$value=$relation->program_id;
        else
            $value = -1;
    }else{
    	$value=(isset($course) ? $course->program_id:old('program_id'));
    }
@endphp
<div class="row">
	<div class="form-group {{ $errors->has('program_id') ? ' has-error' : '' }}">
	    {{ Form::label('program_id', 'Seleccione un Programa Academico', ['class' => 'control-label col-md-4']) }}            
	    <div class="col-md-6">
		    {{ Form::select('program_id',
		                    ['-1'=>'']+$programOpt,
		                    $value,
		                    ['class'=>'form-control','required'=>''])  }}
            {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'program_id')}}
		</div>		
	</div>

</div>