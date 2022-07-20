<div class="col-sm-12">
	<div class="row" id="new_block">
		<button type="button" id="reload-all" class="btn btn-warning" style="position: absolute; top: 4px; right: 4px; z-index: 2;">Finish</button>
	</div>
</div>

{{ csrf_field() }}
<input type="hidden" name="sin_number" value="{{ $sin_number }}">
@foreach ($i as $m)
	<div class="col-md-3 elementSortable" style="height: 412px;" data-file_id="{{$m->id}}">
		<input type="checkbox" class="checks" name="ids[]" -checked value="{{ $m->id }}">
		PARTITA DI DANNO - {{$m->type()}} <br>
		<a download href="{{ url('uploads/operator/'.$m->user_id.'/'.$m->sin_number.'/images',$m->file) }}">
		<div style="height: 250px; border: 1px solid silver; background-size: cover; background-position: center; background-image: url('{{ url('uploads/operator/'.$m->user_id.'/'.$m->sin_number.'/images','t_'.$m->file) }}'); position: relative;">

			@if ($m->web)
				<button type="button" class="btn btn-xs btn-warning btn-delete-img" data-id="{{$m->id}}"><i class="fa fa-trash"></i></button>
			@endif
		</div></a>
		<br>
		<small>
		<b>Riferimento Interno:</b> {{ $m->sin_number }} <br>
		<b>Latitudine:</b> {{ $m->lat ? $m->lat : '---' }} <br>
		<b>Longitudine:</b> {{ $m->lon ? $m->lon : '---' }} <br>
		<span class="add-ovr"><b>Indirizzo:</b> {{$m->address == 'N/A' ? 'N/A' : ''}} <span class="formated_address" data-id="{{$m->id}}" data-latlng="{{$m->lat.','.$m->lon}}"></span> </span> <br>
		<b>Modo:</b> {!!$m->offline == 1 ? 'Offline' : ($m->offline == 2 ? '<span style="color: crimson;">Upload da Galleria</span>' : 'Online')!!} <br>
		{{-- <b>Data:</b> {{ $m->created_at->format('d-m-Y H:i:s') }} <br> <br></small> --}}
		<b>Data:</b> {{ $m->web ? $m->web : $m->created_at->format('d-m-Y H:i:s') }} <br><br></small>
		{{-- <b>CANVAS:</b> {{ $m->map_canvas }} <br> <br></small> --}}
	</div>
@endforeach

<script>
	$('#reload-all').click(function(event) {

		let ids = [];
        $.each($('.connectedSortable').find('.elementSortable'), function(index, val) {
          ids.push($(this).data('file_id'))
        });

		let url = $('#sortable').data('url');

        $.post(url, {_token: '{{csrf_token()}}', ids: ids}, function(data, textStatus, xhr) {
            // console.log(data);
			$.get('{{url('reload-all',$sin_number)}}', function(data) {
				$('#sortable').html(data);
			});
        });

	});
</script>