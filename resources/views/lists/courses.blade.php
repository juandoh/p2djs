@if(isset($courses))
<?php                      
    $tableHeaders = ['Id','Nombre','Prorgama Academico','Opciones'];
    $tableContent = array();
    foreach ($courses as $course){
        $row = ['id'=>$course->id,$course->name,$course->program->name,'deleted'=>false];
        array_push($tableContent,$row);
    }
    $what='Cursos';
    $where = 'Course';
    $links = $courses->links();    
?>
    @include('lists.masterlist')
@endif