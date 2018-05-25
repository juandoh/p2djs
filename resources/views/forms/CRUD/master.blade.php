@if(isset($master))
<div class="panel-group">
    <div class="panel panel-success">
        <div class="panel-heading">
                @if($master['option']=='create')
                    <h4>Crear {{ $master['title'] }}:</h4>
                @elseif($master['option']=='update')
                    <a onclick="window.history.back()" class="btn btn-success form-control">Volver</a>
                @endif
        </div>
        <div class="panel-body">
            @if($master['option']=='create')
                <?php $route='create'.$master['model'] ?>
            @elseif($master['option']=='update')
                <?php $route='update'.$master['model'] ?>
            @endif

            <?php
                //name, faculty, detail
                $testObj = (object)[
                    ];
            ?>
            
            <div class="container-fluid col-md-offset-1 r-offset">
            {{ Form::open(['route'=>$route,'class'=>'form']) }}
                @if(isset($data))
                    @include('fields.CRUD.'.$master['fields'],[$master['object']=>$data])
                @else
                    @include('fields.CRUD.'.$master['fields'])
                @endif
                <div class="form-group">
                    {{ Form::submit('Guardar',["class"=>"btn btn-primary form-control"]) }}
                </div>
            {{ Form::close()}}
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
                    <form method="POST" action="{{ '/delete'.$master['model'].'/'.$data->id }}" id="delete">
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