@php
	$a = 0;
	$b = 0;
	$c = 0;

	$h = 0;

	function convertDMS($deg)
	{
		if (!$deg || $deg == 'null') {
			return "";
		}
		$d = intval($deg);
		$m = intval(($deg - $d) * 60);
		$s = ($deg - $d - $m/60) * 3600;

		return $d.'º '.$m.'\''.number_format($s,2);
	}
@endphp
@if (!$files)
	@php
		$files = [];
	@endphp
@endif
@forelse ($files as $m)

	{{-- <div style="position: absolute; background-color: red; display: inline-block; height: 100%; width: 50%;">
		
	</div> --}}
	
	<div style="position: absolute; height:500px; width: 363px;margin-left: {{ $b }}; margin-top: {{ $c }}">
		<img src="{{ url($logo) }}" alt="" style="position: absolute; top: 5px; left: 5px; width: 80px; z-index: 999">


		{{-- <div style="background-position: center; background-size: 100%; background-repeat: no-repeat; position: absolute; width: 362px; height: 490px; background-image: url({{ url('uploads/operator/'.$m->user_id.'/'.$m->sin_number.'/images',$m->file) }});"> --}}

		<div style="position: absolute; width: 362px; height: 490px;">

			<img src="{{ url('uploads/operator/'.$m->user_id.'/'.$m->sin_number.'/images',$m->file) }}" alt="" style="position: absolute; font-family: Helvetica; width: 100%; height: 100%; left: 0; right: 0; bottom: 0; top: 0">

			<div style="position: absolute; top: 0; color: #fff; margin-left: 100px; font-size: 10px; font-weight: 700;
			background-color: #333; padding: 2px;
			top: 5px; right: 5px; font-family: Helvetica;
			">PARTITA DI DANNO: {{$m->type()}}<br></div>

		</div>


			@if ($location)
			<div style="position: absolute; width: 100%; background: rgba(0,0,0,.5); font-family: Helvetica; color: #fff; padding: 10px 5px; font-size: 8px; height: 20px; top: 450px;">
				<table style="width:100%; height: 20px;" border="0">
					<tr>
						<td>
							@if (session('hour'))
								<h4 style=" text-align: center; font-family: Helvetica; color: #fff; margin: 0">{{ $m->web ? Carbon\Carbon::parse($m->web)->format('d-m-Y (D)') : $m->created_at->format('d-m-Y (D)') }}</h4>
							@else
								<h4 style=" text-align: center; font-family: Helvetica; color: #fff; margin: 0">{{ $m->web ? Carbon\Carbon::parse($m->web)->format('d-m-Y (D) h:i (A)') : $m->created_at->format('d-m-Y (D) h:i (A)') }}</h4>
							@endif
						</td>
					</tr>
				</table>
			</div>
			@else
				@if ($m->address != 'N/A')
					<div style="position: absolute; width: 100%; background: rgba(0,0,0,.5); font-family: Helvetica; color: #fff; padding: 10px 5px; font-size: 8px; height: 80px; top: 390px;">
						<table style="width:100%; height: 100px;" border="0">
							<tr>
								<td rowspan="5" style="width: 100px">
									<img
									src="https://maps.googleapis.com/maps/api/staticmap?size=200x200&markers={{$m->lat.','.$m->lon}}&scale=2&zoom=16&key=AIzaSyCAWEZr2CfI6Prw9P4Wp1lG6gW1VBW5t0Y"
									alt="" style="height: 100px; position: absolute; margin-top: -13px; margin-left: -8px;">
									{{-- <img src="{{$m->map_canvas}}" alt="" style="height: 100px; position: absolute; margin-top: -12px; margin-left: -8px;"> --}}
								</td>
								<td colspan="3">
									<h4 style=" text-align: center; font-family: Helvetica; color: #fff; margin: 0;">{{ $m->address }}</h4>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>Decimal</td>
								<td>DMS</td>
							</tr>
							<tr>
								<td>Lattitude</td>
								<td>{{ $m->lat }}</td>
								<td>{{ convertDMS($m->lat) }}</td>
							</tr>
							<tr>
								<td>Longitude</td>
								<td>{{ $m->lon }}</td>
								<td>{{ convertDMS($m->lon) }}</td>
							</tr>
							<tr>
								<td colspan="3">
									@if (session('hour'))
										<h4 style=" text-align: center; font-family: Helvetica; color: #fff; margin: 0">{{ $m->web ? Carbon\Carbon::parse($m->web)->format('d-m-Y (D)') : $m->created_at->format('d-m-Y (D)') }}</h4>
									@else
										<h4 style=" text-align: center; font-family: Helvetica; color: #fff; margin: 0">{{ $m->web ? Carbon\Carbon::parse($m->web)->format('d-m-Y (D) h:i (A)') : $m->created_at->format('d-m-Y (D) h:i (A)') }}</h4>
									@endif
								</td>
							</tr>
						</table>
					</div>
				@endif
			@endif
			
	</div>
	@php
		$a++;
	@endphp

	@if($a == 1)
		@php
			$b = '373px';
			$c = '0';
		@endphp
	@endif

	@if($a == 2)
		@php
			$b = '0';
			$c = '500px';
		@endphp
	@endif

	@if($a == 3)
		@php
			$b = '373px';
			$c = '500px';
		@endphp
	@endif

	@if ($a == 4)
		 @php
			$h += $a;

			$a = 0;
			$b = 0;
			$c = 0;
		@endphp

		@if (count($files) > $h)
			 <div style="page-break-after:always;"></div>
		@endif
	@endif

@empty
@endforelse

<script type="text/php">
	$pdf->page_text(290, 780, "pag. {PAGE_NUM}", "",8, array(0,0,0));
</script>