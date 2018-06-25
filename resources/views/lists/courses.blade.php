@if(isset($courses))
    @php
        $tableHeaders = ['Id','Nombre','Programa Académico','Opciones'];
        $tableContent = array();
        foreach ($courses as $course){
            $row = ['id'=>$course->id,$course->name,$course->program->name,'deleted'=>false];
            array_push($tableContent,$row);
        }
        $what='Cursos';
        $where = 'Course';
        $courseDesign=true;
        $links = $courses->links();
    @endphp
    @include('lists.masterlist')
@endif