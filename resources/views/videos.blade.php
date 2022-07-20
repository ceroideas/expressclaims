@extends('layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<style>
	#main-content {
    	margin: 0;
    }
</style>

<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">Video del sinistro</div>
			<div class="panel-body">
				<div class="row">
					@foreach ($rc as $element)
						<div class="col-sm-3">
							<video controls="" src="{{ url('uploads/videos',$element->name) }}" style="width:100% !important;height:200px !important; position: relative;"></video><br>
							<small>
							<b>Riferimento Interno:</b> {{ $res->sin_number }} <br>
							<b>Latitudine:</b> {{ $element->lat }} <br>
							<b>Longitudine:</b> {{ $element->lon }} <br>
							<b>Indirizzo:</b> {{ $element->address }} <br>
							<b>Data:</b> {{ $element->created_at }} <br> 
							<b>Via:</b> Registrazione <br> <br></small>
						</div>
					@endforeach
					@foreach ($v as $element)
						<div class="col-sm-3">
							<video controls="" src="{{ url('uploads/users/'.$element->user_id.'/'.$res->sin_number.'/videos',$element->video) }}" style="width:100% !important;height:200px !important; position: relative;"></video><br>
							<small>
							<b>Riferimento Interno:</b> {{ $res->sin_number }} <br>
							<b>Latitudine:</b> {{ $element->lat }} <br>
							<b>Longitudine:</b> {{ $element->lon }} <br>
							<b>Indirizzo:</b> {{ $element->address }} <br>
							<b>Data:</b> {{ $element->created_at->format('d-m-Y H:i:s') }} <br> 
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@stop