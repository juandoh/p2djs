@if(isset($schools))
<?php                      
    $tableHeaders = ['Id','Nombre','Prorgama Academico','Opciones'];
    $tableContent = array();
    foreach ($schools as $school){
        $row = ['id'=>$school->id,$school->name,$school->detail,'deleted'=>!is_null($school->deleted_at)];
        array_push($tableContent,$row);
    }
    $what='Escuelas';
    $where = 'School';
    $links = $schools->links();
?>
    @include('lists.masterlist')
@endif