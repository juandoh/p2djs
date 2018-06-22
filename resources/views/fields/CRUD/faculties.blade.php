@if(isset($faculty))
    <input type="hidden" name="id" value="{{ $faculty->id }}"/>
@endif
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    {{ Form::label('name', 'Nombre de la Facultad', ['class'=>'control-label']) }}        
    {{ Form::text('name', (isset($faculty)?$faculty->name:old('name')), ['class'=>'form-control','required'=>'']) }}
    {{--onkeyup="check('sname','shortname','snamegroup')" --}}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'name')}}
</div>
<div class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
    {{ Form::label('detail', 'Descripción', ['class'=>'control-label']) }}        
    {{ Form::textarea('detail', (isset($faculty)?$faculty->detail:old('detail')), ['class'=>'form-control','required'=>'',"rows"=>3]) }}
    {{--onkeyup="check('sname','shortname','snamegroup')" --}}
    {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'detail')}}
</div>