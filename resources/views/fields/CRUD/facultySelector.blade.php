<div class="row">
    <div class="form-group{{ $errors->has('faculty') ? ' has-error' : '' }}">
        {{ Form::label('faculty', 'Seleccione una Facultad', ['class' => 'control-label col-md-4']) }}
        <?php
            $faculties = App\Http\Controllers\CRUD\FacultiesController::allFaculties();
            $options = array();
            foreach($faculties as $faculty){
                $options += array($faculty->id => $faculty->name);
            }
        ?>
        <div class="col-md-6">
        {{ Form::select('faculty',
                        ['-1'=>'']+$options,
                        (isset($school) ? $school->faculty:old('school')),
                        ['class'=>'form-control','required'=>''])  }}
        {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'faculty')}}
        </div>
        
    </div>
</div>