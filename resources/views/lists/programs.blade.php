@if(isset($programs))
<?php                      
    $tableHeaders = ['Id','Nombre','Escuela','Opciones'];
    $tableContent = array();
    foreach ($programs as $program){
        $row = ['id'=>$program->id,$program->name,$program->fschool->name,'deleted'=>!is_null($program->deleted_at)];
        array_push($tableContent,$row);
    }
    $what='Programas Academicos';
    $where = 'Program';    
    $links = $programs->links();
?>
    @include('lists.masterlist')
@endif