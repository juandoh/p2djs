@if(isset($faculties))
<?php                      
    $tableHeaders = ['Id','Nombre','Descripción','Opciones'];
    $tableContent = array();
    foreach ($faculties as $faculty){
        $row = ['id'=>$faculty->id,$faculty->name,$faculty->detail,'deleted'=>!is_null($faculty->deleted_at)];
        array_push($tableContent,$row);
    }
    $what='Facultades';
    $where = 'Faculty';
    $links = $faculties->links();
?>
    @include('lists.masterlist')
@endif