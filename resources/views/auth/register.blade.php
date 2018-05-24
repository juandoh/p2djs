{{--@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">--}}
<div class="panel panel-success">
    <div class="panel-heading">Register</div>
    <div class="panel-body">
        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('fullname') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">Nombre Completo</label>

                <div class="col-md-6">
                    <input id="name" type="text" class="form-control" name="fullname" value="{{ old('fullname') }}" required autofocus>
                    @if ($errors->has('fullname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('fullname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('shortname') ? ' has-error' : '' }}">
                <label for="sname" class="col-md-4 control-label">Nombre Corto</label>
                <div class="col-md-6">
                    <input id="sname" type="text" class="form-control" name="shortname" value="{{ old('shortname') }}" required autofocus>

                    @if ($errors->has('shortname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('shortname') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">Correo Electronico</label>

                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Contraseña</label>

                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Crear Usuario
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
{{--
        </div>
    </div>
</div>
@endsection--}}
