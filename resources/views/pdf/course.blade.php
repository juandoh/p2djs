<!DOCTYPE html>
<html>

<head>
	<title></title>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"  >

</head>
<body>
	<table class = "table table-hover table-bordered" >
		<tr>
			<td>Id</td>
			<td>{{ $course->id }}</td>
		</tr>
		<tr>
			<td>Nombre</td>
			<td>{{ $course->name}}</td>
		</tr>
		<tr>
			<td>Créditos</td>
			<td>{{ $course->credits }}</td>
		</tr>
		<tr>
			<td>Horas Magistrales</td>
			<td>{{ $course->mhours}}</td>
		</tr>
		<tr>
			<td>Horas Independientes</td>
			<td>{{ $course->ihours }}</td>
		</tr>
		<tr>
			<td>Tipo de Curso</td>
			@if($course->ctype == 1)
				<td> Asignatura Básica</td>
				@elseif ($course->ctype == 2)
				<td> Asignatura Profesional</td>
				
			@endif
		</tr>
		<tr>
		<td>Prerrequisito</td>
			<td>
			<ul> 
				@foreach(Relations::getCoursePrerequisites($course->id) as $prereq )
				 <li>
				 	 {{$prereq->name }} 
				 </li>
			@endforeach
			</ul>
		</td>
		</tr>
		<tr>
		<td>Validable</td>
		
			@if($course->valuable == 1)
				<td> Sí</td>
			@else
				<td>No</td>
			@endif
		</tr>
		<tr>
			<td>Habilitable</td>

			@if($course->valuable == 1)
				<td> Sí</td>
			@else
				<td>No</td>
			@endif
		</tr>
		<tr>
			<td>Programa Académico</td>

			<td>
				{{$course->program_id}}
			</td>

		</tr>
		<tr>
			<td>Semestre</td>
			<td>{{$course->semester}}</td>

		</tr>
			<td>Creado por</td>	
			<td>{{$course->created_by}}</td>		
		</tr>
	</table>	

	<h2>Competencias</h2>
</body>
</html>
