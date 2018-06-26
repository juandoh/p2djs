<!DOCTYPE html>
<html>
<head>
	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
   <div class="panel panel-primary">
	  <div class="panel-heading">Competencias  del Curso: {{$program->name}}</div>
	 </div>	 
</head>
<div class="panel panel-primary">
	<div class="panel-heading">Semestre 1</div>
</div>	 
<ul class ="list-group">	
	@foreach(Relations::getCourseInSemester($program->id, 1)  as $course)
	<li class= "list-group-item">Curso: {{ $course->name}} 
		<ul> 
			@foreach(Relations::getCourseCompetences($course->id) as $comp)			
				{{$comp->name}}:   
				{{$comp->detail}}			
			@endforeach
		</ul>
	</li>
	@endforeach
</ul>

<div class="panel panel-primary">
	<div class="panel-heading">Semestre 2</div>
</div>	 
<ul class= "list-group">
	
	@foreach(Relations::getCourseInSemester($program->id, 2)  as $course)
	<li class= "list-group-item">Curso: {{ $course->name}}
		<ul> 
			@foreach(Relations::getCourseCompetences($course->id) as $comp)			
				{{$comp->name}}:   
				{{$comp->detail}}			
			@endforeach
		</ul>
	</li>
	@endforeach
</ul>

<div class="panel panel-primary">
	<div class="panel-heading">Semestre 3</div>
</div>	 
<ul class= "list-group">
	
	@foreach(Relations::getCourseInSemester($program->id, 3)  as $course)
		<li class= "list-group-item">Curso: {{ $course->name}} 
			<ul> 
				@foreach(Relations::getCourseCompetences($course->id) as $comp)
				<li>
					{{$comp->name}}:   
					{{$comp->detail}}
				</li>
				@endforeach
			</ul>
		</li>
	@endforeach
</ul>

<div class="panel panel-primary">
	<div class="panel-heading">Semestre 4</div>
</div>	 
<ul class= "list-group">
	
	@foreach(Relations::getCourseInSemester($program->id, 4)  as $course)
		<li class= "list-group-item">Curso: {{ $course->name}} 
			<ul> 
				@foreach(Relations::getCourseCompetences($course->id) as $comp)
				<li>
					{{$comp->name}}:   
					{{$comp->detail}}


				</li>
				@endforeach
			</ul>
		</li>
	@endforeach
</ul>
<div class="panel panel-primary">
	<div class="panel-heading">Semestre 5</div>
</div>	 
<ul class= "list-group">
	
	@foreach(Relations::getCourseInSemester($program->id, 5)  as $course)
	<li class= "list-group-item">Curso: {{ $course->name}} 
		<ul> 
			@foreach(Relations::getCourseCompetences($course->id) as $comp)
			<li>
				{{$comp->name}}:   
				{{$comp->detail}}


			</li>
			@endforeach
		</ul>
	</li>
	@endforeach
</ul>

<div class="panel panel-primary">
	<div class="panel-heading">Semestre 6</div>
</div>	 
<ul class= "list-group">
	
	@foreach(Relations::getCourseInSemester($program->id, 6)  as $course)
	<li class= "list-group-item">Curso: {{ $course->name}} 
		<ul> 
			@foreach(Relations::getCourseCompetences($course->id) as $comp)
				<li>
					{{$comp->name}}:   
					{{$comp->detail}}


				</li>
			@endforeach
		</ul>
	</li>
	@endforeach
</ul>
<div class="panel panel-primary">
	<div class="panel-heading">Semestre 7</div>
</div>	 
<ul class= "list-group">
	
	@foreach(Relations::getCourseInSemester($program->id, 7)  as $course)
	<li class= "list-group-item">Curso: {{ $course->name}}
		<ul> 
			@foreach(Relations::getCourseCompetences($course->id) as $comp)
			<li>
				{{$comp->name}}:   
				{{$comp->detail}}


			</li>
			@endforeach
		</ul>
	</li>
	@endforeach
</ul>

<div class="panel panel-primary">
		<div class="panel-heading">Semestre 8</div>
	</div>	 
<ul class= "list-group">
	
	@foreach(Relations::getCourseInSemester($program->id, 8)  as $course)
		<li class= "list-group-item">Curso: {{ $course->name}} 
			<ul>
				@foreach(Relations::getCourseCompetences($course->id) as $comp)
					<li>
						{{$comp->name}}:
						{{$comp->detail}}
						
					</li>
											
				@endforeach
			</ul>

		</li>
	@endforeach
</ul>
<div class="panel panel-primary">
		<div class="panel-heading">Semestre 9</div>
	</div>	 
<ul class= "list-group">
	
	@foreach(Relations::getCourseInSemester($program->id, 9)  as $course)
	<li class= "list-group-item">Curso: {{ $course->name}} 
			<ul>
				@foreach(Relations::getCourseCompetences($course->id) as $comp)
					<li>
						{{$comp->name}}:
						{{$comp->detail}}
						
					</li>
											
				@endforeach
			</ul>

		</li>
	@endforeach
</ul>
<div class="panel panel-primary">
		<div class="panel-heading">Semestre 10</div>
	</div>	 
<ul class= "list-group">
	
	@foreach(Relations::getCourseInSemester($program->id, 10)  as $course)
	<li class= "list-group-item">Curso: {{ $course->name}} 
			<ul>
				@foreach(Relations::getCourseCompetences($course->id) as $comp)
					<li>
						{{$comp->name}}:
						{{$comp->detail}}
						
					</li>
											
				@endforeach
			</ul>

		</li>
	@endforeach
</ul>

</html>

