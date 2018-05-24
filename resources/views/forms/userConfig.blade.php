@if(isset($user))
    <div class="panel panel-info">        
        <div class="panel-heading">
            Datos basicos de usuario:
        </div>
        <div class="panel-body">            
            <form class="form-horizontal" method="POST" action="{{ route('updateUser') }}">
                @include('fields.user')
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <input type="submit" value="Guardar Cambios" class="btn btn-info form-control"/>
                    </div>  
                </div>
            </form>
        </div>
        </div>
    <div class="panel panel-danger">
        <div class="panel-heading">
            Eliminar Cuenta
        </div>
        <div class="panel-body">
            <div class="form-group">
                <form method="POST" action="{{ '/deleteUser/'.$user->id }}" id="deleteUser">
                    {{ csrf_field() }}            
                </form>
                <button value="Eliminar" id="eliminarCuenta" class="btn btn-danger form-control" >
                        Eliminar
                </button>
            </div>
            <script>
                $(document).ready(function(){
                    $("#eliminarCuenta").click(function(){
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
                                $("#deleteUser").submit();
                            }
                        });
                    });
                });                
            </script>        
        </div>        
    </div>
@endif


