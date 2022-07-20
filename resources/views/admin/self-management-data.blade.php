@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<style>
	.modal {
        overflow: auto;
    }
</style>

<div class="row">
	<div class="col-sm-3">
		<div class="panel">
			<div class="panel-heading">Informazioni Autoperizia</div>
			<div class="panel-body">
				<div class="form-group">
					<b>RIFERIMENTO INTERNO</b> <br>
					{{ $res->sin_number }}
				</div>

				<div class="form-group">
					<b>TIPOLOGIA SINISTRO</b> <br>
					{{$sm->typology}}
				</div>

				<div class="form-group">
					<b>DATA DEL SINISTRO</b> <br>
					{{$sm->date}}
				</div>

				<div class="form-group">
					<b> IMPORTO DANNO RICHIESTO ALLA COMPAGNIA</b> <br>
					<h4>{{$sm->ammount}}€</h4>
				</div>

				<div class="form-group">
					<b> IBAN</b> <br>
					@if ($sm->iban)
						@if (file_exists(public_path().'/uploads/autoperizia/'.$sm->iban))
						<a href="{{url('uploads/autoperizia',$sm->iban)}}" target="_blank">{{$sm->iban}}</a>
						@else
						{{$sm->iban}}
						@endif
					@else
						N/A
					@endif
				</div>
			</div>
		</div>

		<div class="panel">
			<div class="panel-heading">Giustificativi danno</div>
			<div class="panel-body">
				
				@forelse ($sm->documents as $key => $_i)
					<div data-file_id="{{$_i->id}}">
						<a style="display: block; text-overflow: ellipsis; white-space: nowrap;overflow: hidden; font-size: 18px; margin-bottom: 8px" download href="{{ url('uploads/autoperizia',$_i->document) }}"> 
							Documento {{$key+1}} {{-- $_i->document --}}</a>

						<small>
						<b>Latitudine:</b> {{ $_i->lat }} <br>
						<b>Longitudine:</b> {{ $_i->lng }} <br>
						<b>Indirizzo:</b> <span class="" data-id="{{$_i->id}}" data-latlng="{{$_i->lat.','.$_i->lng}}">{{$_i->address}}</span> <br>
						<b>Data:</b> {{ $_i->created_at->format('d-m-Y H:i:s') }} <br>
						{{-- <b>Via:</b> {{ $_i->type == 1 ? 'Snapshot' : ($_i->type == 4 ? 'Fotocamera' : 'Chat') }} <br> --}} <br></small>
					</div>
				@empty
					<h5>N/A</h5>
				@endforelse

			</div>
		</div>
	</div>

	<div class="col-sm-9">
		<form class="panel" method="POST" action="{{ url('admin/autoperizia-export') }}" target="_blank">
			<div class="panel-heading">Immagini Autoperizia
				<div style="margin-left: 10px" class="pull-right"><label><input type="checkbox" name="location" value="1"> <small>Senza posizione</small></label></div>
				
				<button type="submit" class="btn btn-info btn-xs pull-right" >Esportare Checked</button>

				<button type="button" class="btn btn-info btn-xs pull-right" style="margin-right: 5px;" id="export-all">Esportare tutto</button>

				<a href="{{ url('admin/autoperizia-export-zip',$sm->id) }}" style="margin-right: 5px;" target="_blank" class="btn btn-info btn-xs pull-right">Esportare Zip</a>

				<button type="button" class="btn btn-secondary btn-xs pull-right" style="margin-right: 5px;" id="export-full">Esportare senza info</button>

				<button type="button" class="btn btn-success btn-xs pull-right" style="margin-right: 5px;" id="check-uncheck">Check/Uncheck tutto</button>

				<select name="empresa" class="pull-right" style="margin-right: 5px; position: relative; border-radius: 3px; height: 22px; font-size: 12px; opacity: 1">
					<option {{$sm->society == 'Renova' ? 'selected' : ''}} value="renova">Renova</option>
					<option {{$sm->society == 'Studio Zappa' ? 'selected' : ''}} value="studio zappa">Studio Zappa</option>
					<option {{$sm->society == 'Gespea' ? 'selected' : ''}} value="gespea">Gespea</option>
				</select>

			</div>
			<div class="panel-body">
				<div class="row">
					{{ csrf_field() }}
					<input type="hidden" name="sin_number" value="{{ $res->sin_number }}">
					@foreach ($sm->images as $_i)
						<div class="col-md-3" style="height: 412px;" data-file_id="{{$_i->id}}">
							<input type="checkbox"class="checks" name="ids[]" checked value="{{ $_i->id }}">
							<a download href="{{ url('uploads/autoperizia',$_i->image) }}">
							<div style="height: 250px; border: 1px solid silver; background-size: cover; background-position: center; background-image: url('{{ url('uploads/autoperizia','t_'.$_i->image) }}'); position: relative;">
							</div></a>
							<br>
							<small>
							{{-- <b>Riferimento Interno:</b> {{ $res->sin_number }} <br> --}}
							<b>Latitudine:</b> {{ $_i->lat }} <br>
							<b>Longitudine:</b> {{ $_i->lng }} <br>
							<b>Indirizzo:</b> <span class="formated_address" data-id="{{$_i->id}}" data-latlng="{{$_i->lat.','.$_i->lng}}">{{$_i->address}}</span> <br>
							<b>Data:</b> {{ $_i->created_at->format('d-m-Y H:i:s') }} <br>
							{{-- <b>Via:</b> {{ $_i->type == 1 ? 'Snapshot' : ($_i->type == 4 ? 'Fotocamera' : 'Chat') }} <br> --}} <br></small>
						</div>
					@endforeach
				</div>
			</div>
		</form>
	</div>
</div>
@section('scripts')
	<script>

		$.each($('.formated_address'), function(index, val) {
			if ($(this).text() !== "") {
				console.log("false");
			}else{

			var id = $(this).data('id');
			 $.ajax({
			 	url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+$(this).data('latlng')+'&key=AIzaSyCAWEZr2CfI6Prw9P4Wp1lG6gW1VBW5t0Y',
			 })
			 .done(function(data) {
			 	val.innerText = data.results[0].formatted_address;
			 	$.post('{{url('admin/updateAddressAutoperizia')}}', {_token: '{{csrf_token()}}',id:id,address:data.results[0].formatted_address}, function(data, textStatus, xhr) {
			 	});
			 })		 
			}
		});

		$('#check-uncheck').click(function(event) {
		  	if ($('.checks:checked').length == $('.checks').length) {
		  		$('.checks').each(function() { 
					this.checked = false; 
				});
		  	}else{
		  		$('.checks').each(function() { 
					this.checked = true; 
				});
		  	}
		});

		$('#export-full').click(function(event) {
			$('form.panel').attr('action','{{url('admin/autoperizia-export-full')}}');
			$('form.panel').submit();
			$('form.panel').attr('action','{{url('admin/autoperizia-export')}}');
		});

		$('#export-all').click(function(event) {
			$('form.panel').attr('action','{{url('admin/autoperizia-export-all',$sm->id)}}');
			$('form.panel').submit();
			$('form.panel').attr('action','{{url('admin/autoperizia-export')}}');
		});
		
	</script>
@endsection
@stop