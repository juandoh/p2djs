@extends('layouts.app')

@section('content')
<script type="text/javascript">
	@php
	if(false){//Session::has('_old_input')){
		echo 'console.log("fuuuuuuuuuuuuuuuuuuuuuuuu");';
		$data=Session::get("_old_input");
		
		$i=1;
		$learning_outcomes = [];
		while(array_key_exists('ra_'.$i, $data)){
			$item = ["id"=>$i,"name"=>$data['ra_'.$i], "detail"=> $data['ra_'.$i.'_detail'] ];
			$achievements = [];
			$j = 1;
			while(array_key_exists('ra_'.$i.'_achievement_'.$j, $data)){
				$achievement = ["father"=>$i,
								"id"=>$j,
								"name"=>$data['ra_'.$i.'_achievement_'.$j],
								"detail"=>$data['ra_'.$i.'_achievement_'.$j.'_detail']];
				
				if($errors->has('ra_'.$i.'_achievement_'.$j.'_detail')){
					$achievement["error"]=true;
					$achievement["error_msg"]=$errors->first('ra_'.$i.'_achievement_'.$j.'_detail');
				}else{
					$achievement["error"]=false;
					$achievement["error_msg"]="";
				}
				array_push($achievements, $achievement);
				$j++;
			}
			if($errors->has('ra_'.$i.'_detail')){
				$item["error"]=true;
				$item["error_msg"]=$errors->first('ra_'.$i.'_detail');
			}else{
				$item["error"]=false;
				$item["error_msg"]="";
			}
			$item["achievements"]=$achievements;
			array_push($learning_outcomes, $item);
			$i++;
		}

		echo 'var learning_outcomes ='.json_encode($learning_outcomes).';';
		echo 'console.log("learning:",learning_outcomes);';
	}else{
		echo 'var learning_outcomes = [{id:1,name:"Resultado de aprendizaje 1",detail:"",
								achievements:[{father:1,id:1,name:"Indicador de Logro 1", detail:"",error:false,error_msg:""}],
								error:false, error_msg:""
							}];';
	}
	

	@endphp


	function printLearningOutcome(id){
		html = `
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">
					<div class="row">
						<div class="col-md-5 col-sm-5">
							<label>
								<input type="hidden" name="ra_${id}" value="${learning_outcomes[id-1]["name"]}"/>
								<a data-toggle="collapse" data-parent="#ra_acordion" href="#collapse_ra_${id}">		
								Resultado de aprendizaje ${id}</a>
							</label>
						</div>
						<div class="col-md-7 col-sm-7">
							<div class="btn-group btn-justified" style="float:right;">
								<a class="btn btn-primary"												
										onclick="addAchievement(${id})"
										>Agregar Indicador</a>
								<a class="btn btn-danger" onclick="removeLearningOutcome(${id})"><span class="glyphicon glyphicon-remove"></span></a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="collapse_ra_${id}" class="panel-collapse collapse ${(id==1? "in":"")}">
				<div class="panel-body">
					<div class="form-group ${(learning_outcomes[id-1]["error"])?"has-error":""}">
						<label>Descripción del resultado de aprendizaje</label>
						<textarea class="form-control" name="ra_${id}_detail" id="ra_${id}_detail"></textarea>
						${(learning_outcomes[id-1]["error"])?'<span class="help-block"><strong>'+learning_outcomes[id-1]["error_msg"]+'</strong></span>':""}
					</div>
					<div class="panel-group" id="ra_${id}_accordion">
					</div>
				</div>
			</div>
		</div>`;
		$("#ra_acordion").append(html);		
		$("#ra_"+id+"_detail").val(learning_outcomes[id-1]["detail"]);
	}
	function printAchievement(achievement){
		father = achievement["father"];
		achievement_id = achievement["id"];		
		target = "ra_"+father+"_accordion";
		detail = achievement["detail"];
		html = `
		<div class="panel panel-info">
			<div class="panel-heading">
				<div class="panel-title">
					<div class="row">
						<div class="col-md-9 col-sm-3">
						<label>
							<a data-toggle="collapse" data-parent="#${target}" href="#collapse_achievement_${achievement_id}">
							<input type="hidden" name="ra_${father}_achievement_${achievement_id}" value="${achievement["name"]}"/>
								Indicador de logro ${achievement_id}</a>
						</label>
						</div>
						<div class="col-md-3 col-sm-3">
							<a class="btn btn-danger" style="float:right;" onclick="removeAchievement(${father},${achievement_id})">
								<span class="glyphicon glyphicon-remove"></span>
							</a>
						</div>
					</div>
				</div>
			</div>
			<div id="collapse_achievement_${achievement_id}" class="panel-collapse collapse ${(achievement_id==1)?"in":""}">
				<div class="panel-body">
					<div class="form-group ${(achievement["error"]?"has-error":"")}">
						<label>Descripción del indicador de logro</label>
						<textarea class="form-control" name="ra_${father}_achievement_${achievement_id}_detail" id="ra_${father}_achievement_${achievement_id}_detail"></textarea>
						${(achievement["error"])?'<span class="help-block"><strong>'+achievement["error_msg"]+'</strong></span>':""}
					</div>										
				</div>
			</div>
		</div>
		`;
		$("#"+target).append(html);
		$("#ra_"+father+"_achievement_"+achievement_id+"_detail").val(detail);
	}

	function displayLearningOutcomes(){
		learning_outcomes.forEach(function(item,index){
			printLearningOutcome(item["id"]);
			item["achievements"].forEach(function(item,index){
				printAchievement(item)
			});
		});
	}

	function addLearningOutcome(){
		var id = learning_outcomes.length+1;
		new_outcome = {id:id,name:"Resultado de aprendizaje "+id, detail:"", achievements:[]};
		learning_outcomes.push(new_outcome);
		printLearningOutcome(id);
	}

	function addAchievement(ra_id){
		var id = (learning_outcomes[ra_id-1]["achievements"].length)+1;
		new_achievement = {father:ra_id,id:id,name:"Indicador de logro "+id,detail:""};
		learning_outcomes[ra_id-1]["achievements"].push(new_achievement);
		printAchievement(new_achievement);
	}

	function removeLearningOutcome(id){
		learning_outcomes.splice(id-1,1); //remove element;
		learning_outcomes.forEach(function(item,index){
			var id = item["id"];
			item["id"]=index+1;
			item["name"] = "Resultado de aprendizaje "+index;
			item["detail"] = $("#ra_"+id+"_detail").val();
			item["achievements"].forEach((function(old,father){
				return function(item,index2){
					item["father"] = father;
					item["name"] = "Indicador de logro "+index2;
					item["detail"] = $("#ra_"+old+"_achievement_"+item["id"]+"_detail").val();
				}
			}) (id,index+1));
		});
		$("#ra_acordion").html("");
		console.log(learning_outcomes)
		displayLearningOutcomes();
	}


	function removeAchievement(ra_id,achv_id){
		console.log(ra_id,achv_id);
		learning_outcomes[ra_id-1]["achievements"].splice(achv_id-1,1);
		console.log(learning_outcomes[ra_id-1]["achievements"]);
		learning_outcomes[ra_id-1]["achievements"].forEach(function(item,index){
			var old = item["id"];
			item["id"] = index+1;
			item["name"]="Indicador de logro "+(index+1);
			item["detail"] = $("#ra_"+item["father"]+"_achievement_"+old+"_detail").val();
		});
		console.log(learning_outcomes[ra_id-1]["achievements"]);
		$("#ra_"+ra_id+"_accordion").html("");
		learning_outcomes[ra_id-1]["achievements"].forEach(function(item,index){
			printAchievement(item)
		});
	}
</script>


{{  Form::open(["url"=>"/save_competence"])  }}
<div class="panel panel-primary">
	<div class="panel-heading">
		<h4 class="panel-title">			
			<div class="row">
				<div class="col-md-9 col-sm-9 col-xs-9">
					<input type="hidden" name="name" value="Competencia {{ $competence_id }}"/>
					<input type="hidden" name="course_id" value="{{ $course_id }}"/>
					<h4>Competencia {{ $competence_id }}</h4>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3">
					<a style="min-width: 90px;" href="{{ url('/home/consultar') }}" class="btn btn-info form-control">Volver</a> 
				</div>
			</div>
		</h4>
	</div>
	<div class="panel-body">
		@if($errors->any())
			<div class="alert alert-danger">
				<ul>
				@foreach($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
				</ul>
			</div>
		@endif
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
						<a class="btn btn-primary" 
						style="float:right;" 
						id="add_ra"
						onclick="addLearningOutcome()"
						>Agregar Resultado</a>
					</div>
				</div>
			</div>
			<div class="panel-group" id="ra_acordion">
				<script type="text/javascript">
					displayLearningOutcomes();
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