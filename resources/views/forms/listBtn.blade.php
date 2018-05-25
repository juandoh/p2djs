@if(isset($where) and isset($id))
<div class="btn-group btn-group-justified" style="max-width: 300px;min-width: 160px;">    
    <a  class="btn btn-primary" href="{{ '/'.strtolower($where).'/'.$id  }}" >Editar</a>
    @if($deleted)
        <a class="btn btn-warning" onclick="$('#en{{$where.$id}}').submit()">Habilitar</a>
        <form method="POST" action="{{ '/enable'.$where.'/'.$id }}" id="en{{ $where.$id }}" style="display: none;">
            {{ csrf_field() }} 
        </form>
    @else
        <a class="btn btn-danger" onclick="$('#del{{$where.$id}}').submit()">Eliminar</a>
        <form method="POST" action="{{ '/delete'.$where.'/'.$id }}" id="del{{ $where.$id }}" style="display: none;">
            {{ csrf_field() }} 
        </form>
    @endif
</div>
@endif