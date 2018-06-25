<!DOCTYPE html>
<html>
<title>Competencias  del Curso: {{$program->name}}</title>
<h2>Semestre 1</h2>
<ul>
	
	@foreach(Relations::getCourseInSemester($program->id, 1)  as $course)
	<li>{{ $course->name}} </li>
	@endforeach
</ul>

<h2>Semestre 2</h2>
<ul>
	
	@foreach(Relations::getCourseInSemester($program->id, 2)  as $course)
	<li>{{ $course->name}} </li>
	@endforeach
</ul>

<h2>Semestre 3</h2>
<ul>
	
	@foreach(Relations::getCourseInSemester($program->id, 3)  as $course)
	<li>{{ $course->name}} </li>
	@endforeach
</ul>

<h2>Semestre 4</h2>
<ul>
	
	@foreach(Relations::getCourseInSemester($program->id, 4)  as $course)
	<li>{{ $course->name}} </li>
	@endforeach
</ul>

<h2>Semestre 5</h2>
<ul>
	
	@foreach(Relations::getCourseInSemester($program->id, 5)  as $course)
	<li>{{ $course->name}} </li>
	@endforeach
</ul>

<h2>Semestre 6</h2>
<ul>
	
	@foreach(Relations::getCourseInSemester($program->id, 6)  as $course)
	<li>{{ $course->name}} </li>
	@endforeach
</ul>

<h2>Semestre 7</h2>
<ul>
	
	@foreach(Relations::getCourseInSemester($program->id, 7)  as $course)
	<li>{{ $course->name}} </li>
		@foreach(Relations::getCourseCompetences($course->id) as $comp)
			{{$comp->name}} 
			{{$comp->detail}}
		@endforeach
	@endforeach
</ul>

<h2>Semestre 8</h2>
<ul>
	
	@foreach(Relations::getCourseInSemester($program->id, 8)  as $course)
	<li>{{ $course->name}} </li>
	@endforeach
</ul>

<h2>Semestre 9</h2>
<ul>
	
	@foreach(Relations::getCourseInSemester($program->id, 9)  as $course)
	<li>{{ $course->name}} </li>
	@endforeach
</ul>

<h2>Semestre 10</h2>
<ul>
	
	@foreach(Relations::getCourseInSemester($program->id, 10)  as $course)
	<li>{{ $course->name}} </li>
	@endforeach
</ul>

</html>
