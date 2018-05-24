@if(isset($tabs))
<ul class="nav nav-tabs">
	@foreach ($tabs as $target=>$title)
	<li @if($tab === $target) class = "active" @endif>
		<a href="/home/{{ $target }}">{{ $title }}</a>
	</li>	
	@endforeach	
</ul>
@endif