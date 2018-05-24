@if(isset($where) and isset($id))
<div class="btn-group">                                                    
    <a  class="btn btn-primary" href="{{ '/'.strtolower($where).'/'.$id  }}" style="color: white" >Editar</a>
    @if($deleted)
        <button type="submit" class="btn btn-warning" onclick="$('#enable{{$where.$id}}').submit()">Habilitar</button>
        <form method="POST" action="{{ '/enable'.$where.'/'.$id }}" id="enable{{ $where.$id }}">
            {{ csrf_field() }}                                                                
        </form>        
    @else
        <button type="submit" class="btn btn-danger" onclick="$('#del{{$where.$id}}').submit()">Eliminar</button>
        <form method="POST" action="{{ '/delete'.$where.'/'.$id }}" id="del{{ $where.$id }}">
            {{ csrf_field() }}                                                            
        </form>
    @endif
</div>
@endif