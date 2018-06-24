@if(isset($where) and isset($id))
<?php if(!isset($deanCourseView)) $deanCourseView=false;?>
<?php if(!isset($directorCourseView)) $directorCourseView=false;?>
<?php if(!isset($courseDesign)) $courseDesign=false;?>
    @if($deanCourseView)
        <div class="btnn-group">
            <a class="btn btn-primary" href="{{ '/info/course/'.$id  }}" style="min-width:60px;">Ver Diseño</a>
        </div>
        <div class="btn-group">
            <a class="btn btn-primary" href="{{ '/info/course/'.$id .'/getPDF' }}" target=_blank style="min-width:60px;">Reporte  de Curso
            </a>
        </div>
    @else
    <div class="btn-group btn-group-justified" style="max-width: 200px;min-width:200px;">
        @isset ($userTypeTab)
            <div class="btn-group">
                <a class="btn btn-primary" href="{{ '/'.strtolower($where).'/'.$id .'/'.strtolower($userTypeTab) }}" style="min-width:60px;">Editar</a>
            </div>        
        @else
            <div class="btn-group">
                <a class="btn btn-primary" href="{{ '/'.strtolower($where).'/'.$id  }}" style="min-width:60px;">Editar</a>
            </div>            
        @endisset
        
        @if($directorCourseView)
            <div class="btn-group">
                <a class="btn btn-warning" href="{{ '/info/course/'.$id  }}" style="min-width:60px;">Ver Diseño</a>
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