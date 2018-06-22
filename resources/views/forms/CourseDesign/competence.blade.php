@extends('layouts.app')

@section('content')
<script type="text/javascript">		
	var learning_outcomes = [{id:1,name:"Resultado de aprendizaje 1",detail:"",
								achievements:[{father:1,id:1,name:"Indicador de Logro 1", detail:""}]},
							{id:2,name:"Resultado de aprendizaje 2",detail:"",
								achievements:[{father:2,id:1,name:"Indicador de Logro 1", detail:""}]}
								];

	function printLearningOutcome(id){		
		html = `
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">
					<div class="row">
						<h4 class="col-md-9 col-sm-9">
							<input type="hidden" name="ra_${id}" value="ra_${id}"/>
							<a data-toggle="collapse" data-parent="#ra_acordion" href="#collapse_ra_${id}">		
							Resultado de aprendizaje ${id}</a>
						</h4>
						<div class="col-md-3 col-sm-3">
							<a class="btn btn-warning">Eliminar Resultado</a>
						</div>
					</div>
				</div>
			</div>
			<div id="collapse_ra_${id}" class="panel-collapse collapse ${(id==1? "in":"")}">
				<div class="panel-body">
					<div class="form-group">
						<label>Descripción del resultado de aprendizaje</label>
						<textarea class="form-control" name="ra_${id}_detail"></textarea>
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
									onclick="addAchievement(${id})"
									>Agregar Indicador</a>
								</div>
							</div>
						</div>
						<div class="panel-group" id="ra_${id}_accordion">
						</div>
					</div>
				</div>
			</div>
		</div>`;
		$("#ra_acordion").append(html);			
	}
	function printAchievement(achievement){
		father = achievement["father"];
		achievement_id = achievement["id"];		
		target = "ra_"+father+"_accordion";		
		html = `
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">
					<div class="row">
						<h4 class="col-md-9 col-sm-3">
						<a data-toggle="collapse" data-parent="#${target}" href="#collapse_achievement_${achievement_id}">
						<input type="hidden" name="ra_${father}_achievement_${achievement_id}" value="ra_${father}_achievement_${achievement_id}"/>
							Indicador de logro ${achievement_id}</a>
						</h4>
						<div class="col-md-3 col-sm-3">
							<a class="btn btn-warning">Eliminar Indicador</a>
						</div>
					</div>
				</div>
			</div>
			<div id="collapse_achievement_${achievement_id}" class="panel-collapse collapse ${(achievement_id==1)?"in":""}">
				<div class="panel-body">
					<div class="form-group">
						<label>Descripción del indicador de logro</label>
						<textarea class="form-control" name="ra_${father}_achievement_${achievement_id}_detail"></textarea>
					</div>										
				</div>
			</div>
		</div>
		`;
		$("#"+target).append(html);
	}

	function addLearningOutcome(){
		var id = learning_outcomes.length+1;
		new_outcome = {id:id,name:"Resultado de aprendizaje "+id, detail:"", achievements:[]};
		learning_outcomes.push(new_outcome);
		printLearningOutcome(id);
	}

	function addAchievement(ra_id){
		var id = learning_outcomes[ra_id]["achievements"].length+1;
		new_achievement = {father:ra_id,id:id,name:"Indicador de logro "+id,detail:""};
		learning_outcomes[ra_id]["achievements"].push(new_achievement);
		printAchievement(new_achievement);
	}

	function removeLearningOutcome(id){

	}


	function removeAchievement(){

	}
</script>


{{  Form::open(["url"=>"/save_competence"])  }}
<div class="panel panel-info">
	<div class="panel-heading">
		<h4 class="panel-title">			
			<div class="row">
				<div class="col-md-9 col-sm-9 col-xs-9">
					<input type="hidden" name="name" value="Competencia {{ $competence_id }}"/>
					<input type="hidden" name="course_id" value="{{ $course_id }}"/>
					<h4>Competencia {{ $competence_id }}</h4>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<a style="min-width: 90px;" onclick="{{ url('/home/consultar') }}" class="btn btn-success form-control">Volver</a> 
				</div>
			</div>
		</h4>
	</div>
	<div class="panel-body">
		<div class="form-group {{ ($errors->has("detail")? " has-error":"") }}">
			<label>Descripción de la competencia</label>			
			{!! Form::textarea("detail", old("detail"), ["class"=>"form-control","rows"=>"3"]) !!}
			{{ App\Http\Controllers\CustomValidator::errorHelp($errors,'detail')}}
		</div>
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-8 col-sm-9 col-xs-9">
						<h4>Resultados de aprendizaje</h4>
					</div>
					<div class="col-md-4 col-sm-3 col-xs-3">
						<a class="btn btn-default" 
						style="float:right;" 
						id="add_ra"
						onclick="addLearningOutcome()"
						>Agregar R.A</a>
					</div>
				</div>
			</div>
			<div class="panel-group" id="ra_acordion">
				<script type="text/javascript">
					learning_outcomes.forEach(function(item,index){
						printLearningOutcome(item["id"]);
						item["achievements"].forEach(function(item,index){
							printAchievement(item)
						});
					});
				</script>
			</div>
		</div>
		<div class="panel-footer">
			{!! Form::submit("Guardar Competencia", ["class"=>"btn btn-success form-control"]) !!}
		</div>
	</div>	
</div>
{{ Form::close() }}
@endsection