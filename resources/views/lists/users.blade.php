@if(isset($users))
<?php
	$tableHeaders = ['Id','Nombre','Rol','Habilitado','Opciones'];
	$tableContent = array();                            
	foreach ($users as $user){                                
		if($user->role != 0){
			$role='';
			if($user->role == 1)
				$role = 'Docente';
			if($user->role == 2)
				$role = 'Director';                                
			if($user->role == 3)
				$role = 'Decano';

			$row = ['id'=>$user->id,$user->fullname,$role,(is_null($user->deleted_at)?'Si':'No'),'deleted'=>!is_null($user->deleted_at)];
			array_push($tableContent, $row);
		}
	}
	$what='Usuarios';
	$where = 'User';
	$links = $users->links();
?>
{{-- listModel uses $where, $what, $tableHeaders, $tableContent --}}
@include('lists.masterlist')
@endif