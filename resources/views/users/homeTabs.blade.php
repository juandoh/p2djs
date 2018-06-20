@if(isset($tabs))

<style type="text/css">
@media (max-width: 767px) {
	.nav-tabs > li {
		float: left;
		width: 50%;
	}
}
</style>
<ul class="nav nav-tabs">
	@foreach ($tabs as $target=>$title)	
		<li @if($tab === $target xor ($target === "crear/docente" and $tab==="crear")) class="active" @endif>
			<a href="/home/{{ $target }}">{{ $title }}</a>
		</li>	
	@endforeach	
</ul>

@endif