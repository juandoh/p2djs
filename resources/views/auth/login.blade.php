@extends('layouts.app')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">Login</div>

    <div class="panel-body">
        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('shortname') ? ' has-error' : '' }}">
                <label for="shortname" class="col-md-4 control-label">Usuario</label>

                <div class="col-md-6">
                    <input id="shortname" type="text" class="form-control" name="shortname" value="{{ old('shortname') }}" required autofocus>

                    @if ($errors->has('shortname'))
                        <span class="help-block">
                            <strong>{{ $errors->first('shortname') }}</strong>
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
                <div class="col-md-6 col-md-offset-4">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Recuerdame
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Login
                    </button>

                    <a class="btn btn-link" href="{{ route('password.request') }}">
                        Olvidaste la contraseña?
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
        
@endsection
