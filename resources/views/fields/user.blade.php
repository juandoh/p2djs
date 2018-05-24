
{{ csrf_field() }}

@if(isset($user))
    <input type="hidden" name="id" id="userid" value="{{ $user->id }}"/>
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

    @if(Auth::user()->role != 0)
        <div class="form-group">
            <label class="control-label col-md-4">Rol</label>
            <div class="col-md-6">
                <label class="form-control">
                    @if ($user->role == 0)
                        Administrador
                    @elseif ($user->role == 1)
                        Docente
                    @elseif ($user->role == 2)
                        Director de Plan
                    @elseif ($user->role == 3)
                        Decano
                    @endif
                </label>
            </div>
        </div>
    @else    
        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
            <label for="role" class="col-md-4 control-label">Rol del usuario</label>
            <div class="col-md-6">
                <div class="radio"><label>
                    <input type="radio" name="role" value="1" 
                        @if(isset($userType))
                            @if($userType==='docente')
                                {{ 'checked' }}
                            @endif
                        @endif
                    >
                    <a href="
                        @if(isset($editing))
                            @if($editing)
                                {{ '/user/'.$user->id.'/docente' }}
                            @endif
                        @else
                            {{ '/home/crear/docente' }}
                        @endif
                    ">Docente</a>
                </label></div>
                <div class="radio"><label>
                    <input type="radio" name="role" value="2"
                        {{ (isset($userType) ? (($userType==='director')?'checked':''):'') }}
                    >
                    <a href="
                        @if(isset($editing))
                            @if($editing)
                                {{ '/user/'.$user->id.'/director' }}
                            @endif
                        @else
                            {{ '/home/crear/director' }}
                        @endif
                    ">Director de Programa</a>
                </label></div>
                <div class="radio"><label>
                    <input type="radio" name="role" value="3"
                        {{ (isset($userType) ? (($userType==='decano')?'checked':''):'') }}
                    >
                    <a href="
                        @if(isset($editing))
                            @if($editing)
                                {{ '/user/'.$user->id.'/decano' }}
                            @endif
                        @else
                            {{ '/home/crear/decano' }}
                        @endif
                    ">Decano</a>
                </label></div>

                {{ App\Http\Controllers\CustomValidator::errorHelp($errors,'role')}}
            </div>
        </div>
    @endif

    <script>                                                    
        function check(id,field,target){
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