@php
	$a = 0;
@endphp
@if (!$files)
	@php
		$files = [];
	@endphp
@endif
@foreach ($files as $m)
	
	<div style="position: absolute; height:1000px; width: 726px;margin-left: 0; margin-top: 0">

		<div style="position: absolute; width: 724px; height: 980px;">

			<img src="{{ url('uploads/operator/'.$m->user_id.'/'.$m->sin_number.'/images',$m->file) }}" alt="" style="position: absolute; font-family: Helvetica; width: 100%; height: 100%; left: 0; right: 0; bottom: 0; top: 0">

		</div>
	</div>

	@php
		$a++;
	@endphp
	
	@if ($a < $files->count())
		<div style="page-break-after:always;"></div>
	@endif


@endforeach

<script type="text/php">
	$pdf->page_text(290, 780, "pag. {PAGE_NUM}", "",8, array(0,0,0));
</script>