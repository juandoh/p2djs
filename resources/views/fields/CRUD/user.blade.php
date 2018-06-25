
{{ csrf_field() }}
@php
    $user_id=Auth::id();
    $role = Relations::resolveRole($user_id);
    if(isset($user))
        $relation = Relations::getRelation($user->id);
@endphp

@if(isset($user))
    <input type="hidden" name="id" id="userid" value="{{ $user->id }}"/>
@endif
    @if($role == 0)
        <div class="form-group {{ $errors->has('role') ? ' has-error' : '' }}">
            <label for="role" class="col-md-4 control-label">Rol del usuario </label>
            <div class="col-md-6">
                <ul class="nav nav-pills nav-justified">
                    @php
                        if(isset($editing)){
                            if($editing)
                                $href="/user/".((string)$user->id);
                        }else{
                            $href='/home/crear';
                        }
                    @endphp
                    <li class="{{ (isset($userType)?(($userType==='docente')?'active':''):'active') }}">                         
                        <a href="{{ $href.'/docente' }}">Docente</a>
                    </li>
                    <li class="{{ (isset($userType)?(($userType==='director')?'active':''):'') }}">
                        <a href="{{ $href.'/director' }}">Director</a>
                    </li>
                    <li class="{{ (isset($userType)?(($userType==='decano')?'active':''):'') }}">
                        <a href="{{ $href.'/decano' }}">Decano</a>
                    </li>
                </ul> 

                @if(Relations::isAdmin(Auth::id()))
                    @isset ($userType)
                        @if ($userType==='docente')
                            {!! Form::hidden('role', 1, []) !!} 
                        @elseif ($userType==='director')
                            {!! Form::hidden('role', 2, []) !!}
                        @elseif ($userType==='decano')
                            {!! Form::hidden('role', 3, []) !!}
                        @else
                            {!! Form::hidden('role', -1, []) !!}                         
                        @endif
                    @else
                        {!! Form::hidden('role', -1, []) !!}
                    @endisset
                @else
                    {!! Form::hidden('role', $user->role, []) !!} 
                @endif                

                {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'role')}}
            </div>
        </div>

        @if(Relations::isAdmin(Auth::id()))
            <div class="well">
                @isset ($userType)
                    @if ($userType==='docente' or $userType === 'director')
                        @include('fields.CRUD.programSelector')
                    @elseif($userType === 'decano')
                        @include('fields.CRUD.facultySelector')
                    @endif
                @endisset
            </div>   
        @endif
    @endif
    <div class="form-group {{ $errors->has('fullname') ? ' has-error' : '' }}" id="fnamegroup">    
        {{ Form::label('fullname', 'Nombre Completo', ['class' => 'control-label col-md-4',]) }}
        <div class="col-md-6">
        {{ Form::text('fullname',(isset($user) ? $user->fullname : old('fullname')),
                ['class'=>'form-control',
                'id'=>'fname',
                'required'=>'',
                "onkeyup"=>"check('fname','fullname','fnamegroup')"
                ])  }}
        {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'fullname')}}
        </div>
    </div>
    <div class="form-group{{ $errors->has('shortname') ? ' has-error' : '' }}" id="snamegroup">
        {{ Form::label('shortname', 'Nombre Corto (Usuario)', ['class' => 'control-label col-md-4',]) }}
        <div class="col-md-6">
            {{ Form::text('shortname',(isset($user) ? $user->shortname : old('shortname')),
                ['class'=>'form-control',
                'id'=>'sname',
                'required'=>'',
                "onkeyup"=>"check('sname','shortname','snamegroup')"
                ])  }}
            {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'shortname')}}
        </div>
    </div>
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" id="emailgroup">
        {{ Form::label('email', 'Correo Electrónico', ['class' => 'control-label col-md-4',]) }}        

        <div class="col-md-6">
            {{ Form::email('email',(isset($user) ? $user->email : old('email')),
                ['class'=>'form-control',
                'id'=>'email',
                'required'=>'',
                "onkeyup"=>"check('email','email','emailgroup')"
                ])  }}            
            {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'email')}}
        </div>
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password" class="col-md-4 control-label">Contraseña</label>

        <div class="col-md-6">
            <input id="password" type="password" class="form-control" name="password" required>

            {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'password')}}
        </div>
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="password-confirm" class="col-md-4 control-label">Confirmar Contraseña</label>

        <div class="col-md-6">
            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
        </div>
    </div>
    
    @if($role !=0)
        <div class="form-group">
            <label class="control-label col-md-4">Rol</label>
            <div class="col-md-6">
                <label class="form-control">
                    @if ($role == 1)
                        Docente
                    @elseif ($role == 2)
                        Director de Plan
                    @elseif ($role == 3)
                        Decano
                    @endif
                </label>
            </div>
        </div>
    @endif

    <script>                                                    
        function check(id,fielrget){
            var data = $('#'+id).val();                                                        
            axios.post('{{ route('check') }}', {
                field: field, data: data
                })
                .then(
                function (response) {
                    //console.log(response['data'][valid]);
                    if(response['data']['valid']){
                        $('#'+target).removeClass('has-error');
                        $('#'+target).addClass('has-success');
                    }else{                                                    
                        $('#'+target).removeClass('has-success');
                        $('#'+target).addClass('has-error');
                    }
                })
                .catch(function (error) {
                console.log(error);
                });
        }
    </script>