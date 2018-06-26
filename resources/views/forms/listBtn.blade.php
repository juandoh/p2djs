@if(isset($where) and isset($id))
    @php if(!isset($deanCourseView)) $deanCourseView=false;@endphp
    @php if(!isset($directorCourseView)) $directorCourseView=false;@endphp
    @php if(!isset($courseDesign)) $courseDesign=false;@endphp
    @if($deanCourseView)
        <div class="btn-group">
            <a class="btn btn-success" href="{{ '/design/course/'.$id.'/show'  }}" style="min-width:60px;">Ver Diseño</a>
        </div>

    @else
        <div class="btn-group btn-group-justified" style="max-width: 300px;min-width:200px;">
            @isset ($userTypeTab)
                <div class="btn-group">
                    <a class="btn btn-primary" href="{{ '/'.strtolower($where).'/'.$id .'/'.strtolower($userTypeTab) }}" style="min-width:60px;">Editar</a>
                </div>
            @else
                <div class="btn-group">
                    <a class="btn btn-primary" href="{{ '/'.strtolower($where).'/'.$id  }}" style="min-width:60px;">Editar</a>
                </div>
            @endisset

            @if($where==="Program")
                <div class="btn-group">
                    <a class="btn btn-success" href="{{ '/program/'.$id.'/report'  }}" style="min-width:60px;">Reporte</a>
                </div>
            @endif

            @if($courseDesign)
                <div class="btn-group">
                    <a class="btn btn-success" href="{{ '/design/course/'.$id.'/show'  }}" style="min-width:60px;">Ver Diseño</a>
                </div>
            @endif
            @if(!$directorCourseView)
                @if($courseDesign)
                    <div class="btn-group">
                        <a class="btn btn-warning" href="{{ '/design/course/'.$id  }}" style="min-width:140px;">Diseño del Curso</a>
                    </div>
                @else
                    @if($deleted)
                        <div class="btn-group">
                            <form method="POST" action="{{ '/enable'.$where.'/'.$id }}" id="en{{ $where.$id }}" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            <button type="button" class="btn btn-warning" onclick="$('#en{{$where.$id}}').submit()">Habilitar</button>
                        </div>
                    @else
                        <div class="btn-group">
                            <form method="POST" action="{{ '/delete'.$where.'/'.$id }}" id="del{{ $where.$id }}" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            <button type="button" class="btn btn-danger" onclick="$('#del{{$where.$id}}').submit()">Eliminar</button>
                        </div>
                    @endif
                @endif
            @endif
        </div>
    @endif
@endif