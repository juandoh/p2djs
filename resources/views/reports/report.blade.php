<div class="panel panel-info">
	<div class="panel-heading">
		REPORTES 
		@if (Relations::resolveRole(Auth::id()))
			{{ ": Docente" }}
		@endif
		
		@php
			if(true){
				$codigo =" en php";
				echo $codigo;
			}	
		@endphp
		
	</div>


</div>