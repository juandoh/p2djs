@if(isset($school))
    <input type="hidden" name="id" value="{{ $school->id }}"/>
@endif
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {{ Form::label('name', 'Nombre de la Escuela', ['class'=>'control-label']) }}        
    {{ Form::text('name', (isset($school)?$school->name:old('name')), ['class'=>'form-control','required'=>'']) }}
    {{--onkeyup="check('sname','shortname','snamegroup')" --}}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'name')}}
</div>
<div class="well">
	@include('fields.CRUD.facultySelector')	
</div>

<div class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
    {{ Form::label('detail', 'Descripción', ['class'=>'control-label']) }}        
    {{ Form::textarea('detail', (isset($school)?$school->detail:old('detail')), ['class'=>'form-control','required'=>'']) }}
    {{--onkeyup="check('sname','shortname','snamegroup')" --}}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'detail')}}
</div>