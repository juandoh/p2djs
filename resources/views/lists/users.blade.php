@if(isset($users))
@php
	$tableHeaders = ['Id','Nombre','Rol','Habilitado','Opciones'];
	$tableContent = array();	
	foreach ($users as $user){
		$user_role = Relations::resolveRole($user->id);
		if($user_role != 0){
			$role='';
			if($user_role == 1)
				$role = 'Docente';
			if($user_role == 2)
				$role = 'Director';                                
			if($user_role == 3)
				$role = 'Decano';

			$row = ['id'=>$user->id,
					$user->fullname,
					'role'=>$role,
					(is_null($user->deleted_at)?'Si':'No'),					
					'deleted'=>!is_null($user->deleted_at)];
			array_push($tableContent, $row);
		}
	}
	$what='Usuarios';
	$where = 'User';	
	$links = $users->links();
@endphp
{{-- listModel uses $where, $what, $tableHeaders, $tableContent --}}
@include('lists.masterlist')
@endif