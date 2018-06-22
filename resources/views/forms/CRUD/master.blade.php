@if(isset($master))
<div class="panel-group">
    <div class="panel panel-success">
        @if($master['option']!=='show')
        <div class="panel-heading">
                @if($master['option']=='create')
                    <h4>Crear {{ $master['title'] }}:</h4>
                @elseif($master['option']=='update')                    
                    <div class="row">
                        <div class="col-md-9 col-sm-9">
                            <h4>Modificar {{ $master['title'] }}:</h4>
                        </div>                        
                        <div class="col-md-3 col-sm-3">
                            @if(!isset($tab))
                                <a style="min-width: 90px;" onclick="window.history.back()" class="btn btn-success form-control">Volver</a> 
                            @endif
                        </div>
                    </div>                    
                @endif
        </div>
        @else
            <div class="panel-heading">
                <a style="min-width: 90px;" onclick="window.history.back()" class="btn btn-success form-control">Volver</a> 
            </div>
        @endif
        <div class="panel-body">
            @if($master['option']==='register')
                @php
                    $route=route('register');
                @endphp            
            @elseif($master['option']==='create')
                @php
                    $route='create'.$master['model'];
                @endphp                
            @elseif($master['option']==='update')
                @php
                    $route='update'.$master['model'];    
                @endphp                
            @elseif($master['option']==='show')
                @php
                    $route='dump';
                @endphp                
            @endif
            
            <div class="container-fluid col-md-offset-1 r-offset">
            {{ (($master['option']!=='show')? (Form::open(['route'=>$route,'class'=>'form'])):'') }}
                @if(isset($data))
                    @include('fields.CRUD.'.$master['fields'],[$master['object']=>$data])
                @else
                    @include('fields.CRUD.'.$master['fields'])
                @endif
                @if($master['option']!=='show')
                    <div class="form-group">
                        {{ Form::submit('Guardar',["class"=>"btn btn-primary form-control"]) }}
                    </div>
                @endif
            {{ (($master['option']!=='show')? (Form::close()):'')}}
            </div>
        </div>
    </div>
    
    @if($master['option']=='update' and isset($data))
        <div class="panel panel-danger">
            <div class="panel-heading">
                Eliminar {{ $master['title']}}
            </div>
            <div class="panel-body">
                <div class="form-group">
                    <form method="POST" action="{{ '/delete'.$master['model'].'/'.$data->id }}" id="delete" style="display: none;">
                        {{ csrf_field() }}            
                    </form>
                    <button value="Eliminar" id="submit" class="btn btn-danger form-control" >                        
                            Eliminar
                    </button>
                </div>
                <script>
                    $(document).ready(function(){
                        $("#submit").click(function(){
                            swal({
                                title: 'Está seguro?',
                                html:  "Esta acción no se puede deshacer",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Eliminar'
                            }).then((result) => {
                                console.log(result);
                                if (result.value) {
                                    $("#delete").submit();
                                }
                            });
                        });
                    });                
                </script>        
            </div>        
        </div>
    @endif
</div>

@endif

