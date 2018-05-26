@extends('layouts.app')

@section('content')
	@if(isset($course))
	<div class="panel-group">
		<div class="panel panel-success">
			<div class="panel-heading">
				<div class="row">
					<h4 class="col-md-6">Diseño del Curso: {{ $course->name }}</h4>
					<div class="col-md-6">
						<div class="btn-group" style="float:right;">
							<a class="btn btn-success" href="/home/consultar">Guardar</a>
							<a class="btn btn-warning" href="/home/consultar">Volver</a>
						</div>
					</div>
				</div>				
			</div>
			<div class="panel-body">

			</div>
		</div>
	</div>	
	@endif
@endsection