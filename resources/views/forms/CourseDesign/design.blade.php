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
						<a class="btn btn-warning" href="/home/consultar">Volver</a>
					</div>
				</div>
			</div>				
		</div>
		<div class="panel-body">
			<div class="panel panel-primary">
				<div class="panel-heading"
>					<script type="text/javascript">
						var accordionCount = 1;
						var competenceCount = 1;
						var competences = [];
					</script>
					<div class="row"> 
						<div class="col-md-8 col-sm-9 col-xs-9">
							<label class="control-label" style="padding-top: 5px;">
								Competencias	
							</label>								
						</div>
						<div class="col-md-4 col-sm-3 col-xs-3">
							<a class="btn btn-default" style="float:right;" id="addCompetence" href="/design/course/{{ $course->id}}/add_competence">
								Agregar Competencia
								{{-- 
								<script type="text/javascript">
									function addLearningOutcome(target, competence_id){
										learningO_id = competences[competence_id]["learningOCount"];
										competences[competence_id]["learningOs"].push({"achievementCount":1});
										html = `
										<div class="panel panel-info">
										<div class="panel-heading">
										<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#${target}" href="#collapse_learningO_${learningO_id}">
										<input type="hidden" name="competence_${competence_id+1}_learningO_${learningO_id}"/>
										Resultado de aprendizaje ${competences[competence_id]["learningOCount"]}</a>
										</h4>
										</div>
										<div id="collapse_learningO_${learningO_id}" class="panel-collapse collapse ${(learningO_id==1)?"in":""}">
										<div class="panel-body">
										<div class="form-group">
										<label>Descripción del resultado de aprendizaje</label>
										<textarea class="form-control" name="detail_learningO_${learningO_id}"></textarea>
										</div>
										<div class="panel panel-info">
											<div class="panel-heading">
												<div class="row">
													<div class="col-md-8 col-sm-9 col-xs-9">
														<label>Indicadores de Logro:</label>
													</div>
													<div class="col-md-4 col-sm-3 col-xs-3">
														<button class="btn btn-default" 
															style="float:right;" 
															id="learningO_${learningO_id}_add_achievement"
															onclick="addAchievement('competence_${competence_id}_learningO_accordion${learningO_id}',${learningO_id-1},${competence_id})"
															>Agregar Indicador</button>
													</div>
												</div>
											</div>
											<div class="panel-group" id="competence_${competence_id}_learningO_accordion${learningO_id}">
											</div>
										</div>
										</div>
										</div>
										</div>
										`;
										$("#"+target).append(html);
										competences[competence_id]["learningOCount"] += 1;
									}
									function addAchievement(target, learningO_id, competence_id){
										achievement_id = competences[competence_id]["learningOs"][learningO_id]["achievementCount"];
										html = `
										<div class="panel panel-info">
										<div class="panel-heading">
										<h4 class="panel-title">
										<a data-toggle="collapse" data-parent="#${target}" href="#collapse_achievement_${achievement_id}">
										<input type="hidden" name="competence_${learningO_id+1}_learningO_${learningO_id}_achievement${achievement_id}"/>
										Indicador de logro ${achievement_id}</a>
										</h4>
										</div>
										<div id="collapse_achievement_${achievement_id}" class="panel-collapse collapse ${(achievement_id==1)?"in":""}">
										<div class="panel-body">
										<div class="form-group">
										<label>Descripción del indicador de logro</label>
										<textarea class="form-control" name="detail_achievement_${achievement_id}"></textarea>
										</div>										
										</div>
										</div>
										</div>
										`;
										$("#"+target).append(html);
										competences[competence_id]["learningOs"][learningO_id]["achievementCount"] += 1;
									}
									$(document).ready(function(){
										$("#addCompetence").click(
											function(){
												competences.push({"learningOCount":1,"learningOs":[]});													
												var html=`
												<div class="panel panel-info">
												<div class="panel-heading">
												<h4 class="panel-title">
												<a data-toggle="collapse" data-parent="#accordion0" href="#collapse${competenceCount}">
												<input type="hidden" name="name_${competenceCount}" value="Competencia ${competenceCount}"/>
													Competencia ${competenceCount}</a>
												</h4>
												</div>
												<div id="collapse${competenceCount}" class="panel-collapse collapse ${(competenceCount==1)?"in":""}">
												<div class="panel-body">
													<div class="form-group">
														<label>Descripción de la competencia</label>
														<textarea class="form-control" name="detail_${competenceCount}"></textarea>
													</div>
													<div class="panel panel-info">
														<div class="panel-heading">
															<div class="row">
																<div class="col-md-8 col-sm-9 col-xs-9">
																	<label>Resultados de aprendizaje</label>
																</div>
																<div class="col-md-4 col-sm-3 col-xs-3">
																	<button class="btn btn-default" 
																		style="float:right;" 
																		id="competence_${competenceCount}_add_ra"
																		onclick="addLearningOutcome('accordion${accordionCount}',${competenceCount-1})"
																		>Agregar R.A</button>
																</div>
															</div>
														</div>
														<div class="panel-group" id="accordion${accordionCount}">
														</div>
													</div>
												</div>
												</div>
												</div>`;
												$("#accordion0").append(html);
												competenceCount+=1;
											 	accordionCount+=1;
											});
									});									
								</script>
								--}}
							</a>	
						</div>
					</div>
				</div>
				
				<div class="panel-group" id="accordion0">
					@isset ($competences)						
						@php
							$competence_count = 0;
						@endphp
					    @foreach ($competences as $competence)
					    	<div class="panel panel-info">
					    		<div class="panel-heading">
					    			Competencia {{ $competence_count }}
					    		</div>
					    		<div class="panel-body">
					    			<textarea class="form-control">
					    				{{ $competence->detail }}
					    			</textarea>
					    		</div>
					    	</div>
					    	@php
					    		$competence_count++;
					    	@endphp
					    	@endforeach
					@endisset()
				</div> 				
				
			</div> 
		</div>
	</div>
</div>
@endif
{{-- 
<script type="text/javascript">
	window.onbeforeunload = function() {
		return "La informacion sin guardar se perderá";
	}
</script>
 --}}
@endsection