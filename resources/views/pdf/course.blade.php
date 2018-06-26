
<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"  >
</head>
<body>	
  <div class="panel panel-primary">
		<div class="panel-heading">Curso: {{$course->name}}</div>
    <div class="panel-body">
    	<table class = "table table-hover table-bordered table-striped" >
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
       		@if($course->qualifiable == 1)
				    <td> Sí</td>
			    @else
				    <td>No</td>
			    @endif
    </tr>
    <tr>
        <td>Semestre</td>
        <td>{{$course->semester}}</td>
    </tr>
	    <tr>
	        <td>Creado por:</td>
	        <td>{{$course->created_by}}</td>
    	</tr>
	</table>

<div class="panel panel-primary">
	<div class="panel-heading">Competencias</div>
</div>

@foreach(Relations::getCourseCompetences($course->id) as $comp)
	<ul class= "list-group">
		<li class = "list-group-item">
			<h4>{{$comp->name}}:</h4>
			<h5>{{$comp->detail}}</h5>
	
			@foreach(Relations::getCompetenceResult($comp->id) as $result)

				<h4>{{$result->name}} de {{$comp->name}}: </h4>
					<h5>{{$result->detail}}</h5>
				<ul>
					@foreach(Relations::getAchievements($result->id) as $achieve)
						<h4>{{$achieve->name}} de {{$result->name}}: </h4>
						<ul>
								<h5>{{$achieve->detail}}</h5>
						</ul>
					@endforeach	
				</ul>
			@endforeach
		</li>
	</ul>
@endforeach
    </div>
	</div>

</body>
</html>
