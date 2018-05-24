@if(isset($where) and isset($object))
<div class="btn-group">                                                    
    <a  class="btn btn-primary" href="{{ '/'.strtolower($where).'/'.$object->id  }}" style="color: white" >Editar</a>
    @if(!is_null($object->deleted_at))
        <button type="submit" class="btn btn-warning" onclick="$('#enable{{$where}}').submit()">Habilitar</button>
        <form method="POST" action="{{ '/enable'.$where.'/'.$object->id }}" id="enable{{ $where }}">
            {{ csrf_field() }}                                                                
        </form>
    @else
        <button type="submit" class="btn btn-danger" onclick="$('#del{{$where}}').submit()">Eliminar</button>
        <form method="POST" action="{{ '/delete'.$where.'/'.$object->id }}" id="del{{ $where }}">
            {{ csrf_field() }}                                                            
        </form>
    @endif
</div>
@endif