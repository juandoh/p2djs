@extends('layouts.app')

@section('content')
{{  Form::open(["url"=>"/save_competence"])  }}
<div class="panel panel-info">
	<div class="panel-heading">
		<h4 class="panel-title">			
			<input type="hidden" name="name" value="Competencia {{ $competence_id }}"/>
			<input type="hidden" name="course_id" value="{{ $course_id }}"/>
			<h3>Agregar Competencia</h3>			
		</h4>
	</div>

	<script type="text/javascript">
		var ra_count = 0;
		var achv_per_ra = [];
	</script>	
	<div class="panel-body">
		<div class="form-group">
			<label>Descripción de la competencia</label>
			{!! Form::textarea("detail", "", ["class"=>"form-control","rows"=>"3"]) !!}
		</div>
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-8 col-sm-9 col-xs-9">
						<label>Resultados de aprendizaje</label>
					</div>
					<div class="col-md-4 col-sm-3 col-xs-3">
						<a class="btn btn-default" 
						style="float:right;" 
						id="add_ra"
						onclick="addLearningOutcome(event,'ra_acordion')"
						
						>Agregar R.A</a>
					</div>
				</div>
			</div>
			<div class="panel-group" id="ra_acordion">
			</div>
		</div>
		<div class="panel-footer">
			{!! Form::submit("Guardar Competencia", ["class"=>"btn btn-success form-control"]) !!}
		</div>
	</div>
	<script type="text/javascript">		

		function addLearningOutcome(e,target){
			e.preventDefault();
			achv_per_ra.push(0);	
			html = `
			<div class="panel panel-info">
			<div class="panel-heading">
			<h4 class="panel-title">
			<a data-toggle="collapse" data-parent="#${target}" href="#collapse_ra_${ra_count}">
			<input type="hidden" name="ra_${ra_count}" value="ra_${ra_count}"/>
			Resultado de aprendizaje ${ra_count+1}</a>
			</h4>
			</div>
			<div id="collapse_ra_${ra_count}" class="panel-collapse collapse ${(ra_count==0)?"in":""}">
			<div class="panel-body">
			<div class="form-group">
			<label>Descripción del resultado de aprendizaje</label>
			<textarea class="form-control" name="ra_${ra_count}_detail"></textarea>
			</div>
			<div class="panel panel-info">
			<div class="panel-heading">
			<div class="row">
			<div class="col-md-8 col-sm-9 col-xs-9">
			<label>Indicadores de Logro:</label>
			</div>
			<div class="col-md-4 col-sm-3 col-xs-3">
			<a class="btn btn-default" 
			style="float:right;" 			
			onclick="addAchievement('learningO_accordion${ra_count}',${ra_count})"
			href="#"
			>Agregar Indicador</a>
			</div>
			</div>
			</div>
			<div class="panel-group" id="learningO_accordion${ra_count}">
			</div>
			</div>
			</div>
			</div>
			</div>
			`;
			$("#"+target).append(html);
			ra_count += 1;
		}
		function addAchievement(target, learningO_id){
			achievement_id = achv_per_ra[learningO_id];
			html = `
			<div class="panel panel-info">
			<div class="panel-heading">
			<h4 class="panel-title">
			<a data-toggle="collapse" data-parent="#${target}" href="#collapse_achievement_${achievement_id}">
			<input type="hidden" name="ra_${learningO_id}_achievement_${achievement_id}" value="ra_${learningO_id}_achievement_${achievement_id}"/>
			Indicador de logro ${achievement_id+1}</a>
			</h4>
			</div>
			<div id="collapse_achievement_${achievement_id}" class="panel-collapse collapse ${(achievement_id==0)?"in":""}">
			<div class="panel-body">
			<div class="form-group">
			<label>Descripción del indicador de logro</label>
			<textarea class="form-control" name="achievement_${achievement_id}_detail"></textarea>
			</div>										
			</div>
			</div>
			</div>
			`;
			$("#"+target).append(html);
			achv_per_ra[learningO_id] += 1;
		}
	</script>
</div>
{{ Form::close() }}
@endsection