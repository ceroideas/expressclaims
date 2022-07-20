@extends('admin.layout')

@section('title','EXPRESS TECH')
@section('content')

{{-- <style>
	.visible_print {
		display: none;
	}
	@media print {
		.visible_print {
			display: block !important;
		}
	}
</style> --}}

<style>
	.preview {
		height: 250px;
		background-size: cover;
		background-position: center;

		width: 100%;
		border-radius: 6px;
		border: 1px solid #f2f4f6;
	}
	#map {
		width: 100%;
		height: 250px;
		border-radius: 6px;
		border: 1px solid #f2f4f6;
	}

	.pac-container {
	    background-color: #FFF;
	    z-index: 99999;
	    position: fixed;
	    display: inline-block;
	    float: left;
	}

	.add-ovr {
		width: 100%;
		display: inline-block;
		text-overflow: ellipsis;
		overflow: hidden;
		white-space: nowrap;
	}
	.btn-delete-img {
		position: absolute;
		bottom: 8px;
		right: 8px;
	}
	/*.modal{
	    z-index: 20;   
	}
	.modal-backdrop{
	    z-index: 10;        
	}​*/

	.move_block {
		border: 2px dashed crimson;
		border-radius: 4px;
		position: relative;
	}

	.move_block:before {
		content: "";
		position: absolute;
		background-color: rgba(0, 0, 0, .1);
		left: 0;
		top: 0;
		right: 0;
		bottom: 0;
		display: block;
		z-index: 1;
	}
	.move_block:after {
		content: "";
		clear: both;
	}

	#new_block .btn {
		display: none;
	}

	#new_block.move_block .btn {
		display: block !important;
	}
</style>

<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#images">Immagini</a></li>
  <li><a data-toggle="tab" href="#video">Video</a></li>
  <li><a data-toggle="tab" href="#audio">Audio</a></li>
</ul>

<div class="tab-content">
  <div id="images" class="tab-pane fade in active">
    <div class="row">
		<div class="col-sm-12">
			<form class="panel" method="POST" action="{{ url('admin/express-tech-export') }}" target="_blank">
				<div class="panel-heading">Immagini interna del sinistro
					<div style="margin-left: 10px" class="pull-right"><label><input type="checkbox" name="location" value="1"> <small>Senza posizione</small></label></div>
					<div style="margin-left: 10px" class="pull-right"><label><input type="checkbox" name="hour" value="1"> <small>Senza ora</small></label></div>
					<button type="submit" class="btn btn-info btn-xs pull-right" >Esportare Checked</button>
					<a data-href="{{ url('admin/express-tech-export-all/'.$sin_number,'0') }}" href="{{ url('admin/express-tech-export-all/'.$sin_number,'0') }}/{{$society}}" style="margin-right: 5px;" target="_blank" class="btn btn-info btn-xs pull-right" id="export-all">Esportare tutto</a>

					<a data-href="{{ url('admin/express-tech-export-all/'.$sin_number,true) }}" href="{{ url('admin/express-tech-export-all/'.$sin_number,true) }}/{{$society}}" style="margin-right: 5px;" target="_blank" class="btn btn-info btn-xs pull-right hidden" id="export-all-l">Esportare tutto</a>

					<a href="{{ url('admin/express-tech-export-zip',$sin_number) }}" style="margin-right: 5px;" target="_blank" class="btn btn-info btn-xs pull-right">Esportare Zip</a>
					<button type="button" class="btn btn-secondary btn-xs pull-right" style="margin-right: 5px;" id="export-full">Esportare senza info</button>
					<button type="button" class="btn btn-success btn-xs pull-right" style="margin-right: 5px;" id="check-uncheck">Check/Uncheck tutto</button>

					<select name="empresa" class="pull-right" style="margin-right: 5px; position: relative; border-radius: 3px; height: 22px; font-size: 12px;">
						<option value="" selected disabled></option>
						<option {{$society == 'renova' ? 'selected' : ''}} value="renova">Renova</option>
						<option {{$society == 'studio zappa' ? 'selected' : ''}} value="studio zappa">Studio Zappa</option>
						<option {{$society == 'gespea' ? 'selected' : ''}} value="gespea">Gespea</option>
					</select>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12">
							<button data-toggle="modal" data-target="#add-image" class="btn btn-sm btn-info" type="button"><i class="fa fa-plus"></i></button>

							<button id="move-checked" class="btn btn-sm btn-success" type="button"></i>Move checked</button>
							<br>
							<br>
						</div>
					</div>
					<div class="row connectedSortable" id="sortable" data-url="{{url('admin/changeOrder')}}">
						@include('admin.template-images')
					</div>
				</div>
			</form>
		</div>
	</div>
  </div>
  <div id="video" class="tab-pane fade">
    <div class="row">
		<div class="col-sm-12">
			<div class="panel">
				<div class="panel-heading">Video interno del sinistro {{-- <button class="btn btn-info btn-xs btn-print pull-right">Export</button> --}}</div>
				<div class="panel-body">
					<div class="row">
						@foreach ($v as $m)
							<div class="col-sm-3" style="height: 350px;">
								PARTITA DI DANNO - {{$m->type()}} <br>
								<video controls="" src="{{ url('uploads/operator/'.$m->user_id.'/'.$m->sin_number.'/videos',$m->file) }}" style="width:100% !important;height:200px !important; position: relative;"></video><br>
								<small>
								<b>Riferimento Interno:</b> {{ $m->sin_number }} <br>
								<b>Latitudine:</b> {{ $m->lat }} <br>
								<b>Longitudine:</b> {{ $m->lon }} <br>
								<span class="add-ovr"><b>Indirizzo:</b> <span class="formated_address" data-id="{{$m->id}}" data-latlng="{{$m->lat.','.$m->lon}}"></span> </span> <br>
								<b>Modo:</b> {{$m->offline == 1 ? 'Offline' : 'Online'}} <br>
								<b>Data:</b> {{ $m->web ? $m->web : $m->created_at->format('d-m-Y H:i:s') }} <br><br></small>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
  </div>
  <div id="audio" class="tab-pane fade">
    <div class="row">
		<div class="col-sm-12">
			<div class="panel">
				<div class="panel-heading">Audio interno del sinistro {{-- <button class="btn btn-info btn-xs btn-print pull-right">Export</button> --}}</div>
				<div class="panel-body">
					<div class="row">
						@foreach ($a as $m)
							<div class="col-sm-3" style="height: 220px;">
								PARTITA DI DANNO - {{$m->type()}} <br>

								<br>

								<audio controls>
								  <source src="{{ url('uploads/operator/'.$m->user_id.'/'.$m->sin_number.'/audios',$m->file) }}" type="audio/mpeg">
									Your browser does not support the audio element.
								</audio>
								<br>
								<br>
								<small>
								<b>Riferimento Interno:</b> {{ $m->sin_number }} <br>
								<b>Latitudine:</b> {{ $m->lat }} <br>
								<b>Longitudine:</b> {{ $m->lon }} <br>
								<span class="add-ovr"><b>Indirizzo:</b> <span class="formated_address" data-id="{{$m->id}}" data-latlng="{{$m->lat.','.$m->lon}}"></span> </span> <br>
								{{-- <b>Modo:</b> {{$m->offline == 1 ? 'Offline' : 'Online'}} <br> --}}
								<b>Data:</b> {{ $m->web ? $m->web : $m->created_at->format('d-m-Y H:i:s') }} <br><br></small>
							</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
  </div>
</div>








<div class="modal fade in" id="add-image">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			
			<div class="modal-header">
				Aggiungere Immagine
			</div>

			<div class="modal-body">
				
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label>Immagine</label>

							<label class="preview" for="imgInp">
							</label>

							<input type="file" id="imgInp" style="position: absolute; left: -9999px;">
						</div>
					</div>

					<div class="col-sm-8">

						<div class="form-group">
							<label>Localization</label>
							<div id="map">
								
							</div>
						</div>

						<input type="hidden" name="lat">
						<input type="hidden" name="lng">

						<div class="form-group">
							<label>Indirizzo</label>
							<input type="text" class="form-control" id="searchTextField" name="address">
						</div>

						<div class="form-group">
							<label>Tipologia</label>

							<select name="typology" class="form-control">
								<option value="{{$s->id}}" selected>Non legare a nessuna partita di danno</option>
								@forelse ($s->claims as $c)
									<option value="{{ $c->id }}">{{ isset(json_decode($c->information,true)['typology']) ? json_decode($c->information,true)['typology'] : "" }}</option>
	                            @empty
	                            	@if (isset(json_decode($s->information,true)['typology']))
										<option value="{{ $s->id }}">{{ isset(json_decode($s->information,true)['typology']) ? json_decode($s->information,true)['typology'] : "" }}</option>
	                            	@endif
	                            @endforelse
							</select>
						</div>

						<div class="form-group">
							<label>Data e ora</label>
							<input type="text" name="date" class="form_datetime form-control">
						</div>

						<div class="checkbox">
							<label style="padding: 0 !important;">
								<input type="checkbox" id="without-addr-hour">

								Non devono avere nessun attributo
							</label>
						</div>
					</div>
				</div>

			</div>

			<div class="modal-footer">
				<button type="button" id="save-picture" class="btn btn-sm btn-success">Salva</button>
				<button type="button" data-dismiss="modal" class="btn btn-sm btn-warning">Chiudi</button>
			</div>

		</div>
	</div>
</div>

<div class="modal fade in" id="modal-delete-img">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				Vuoi eliminare la foto selezionata?
			</div>
			<div class="modal-footer">
				<a href="#" id="btn-delete-img" class="btn btn-xs btn-success">Si</a>
				<button data-dismiss="modal" class="btn btn-xs btn-danger">No</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade in" id="modal-pre-upload">
	<div class="modal-dialog" style="margin-top: 15%;">
		<div class="modal-content" style="box-shadow: 0 0 5px silver">
			<div class="modal-header">
				Stai caricando la foto <span id="address-modal"></span>, devo procedere?
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" id="btn-pre-upload" class="btn btn-xs btn-success">Si</a>
				<button data-dismiss="modal" class="btn btn-xs btn-danger">No</button>
			</div>
		</div>
	</div>
</div>

{{-- <div id="printArea">
@foreach ($i as $m)
	<div class="visible_print">
		<img src="{{ url('uploads/users/'.$m->user_id.'/'.$m->sin_number.'/images',$m->imagen) }}" style="max-height: 400px; display: block; margin: auto">
		<br>
		<small>
		<b>Riferimento Interno:</b> {{ $m->sin_number }} <br>
		<b>Latitudine:</b> {{ $m->lat }} <br>
		<b>Longitudine:</b> {{ $m->lon }} <br>
		<b>Indirizzo:</b> {{ $m->address }} <br>
		<b>Data:</b> {{ $m->created_at->format('d-m-Y H:i:s') }} <br>
		<b>Via:</b> {{ $m->type == 1 ? 'Snapshot' : 'Chat' }} <br> <br></small>
	</div>
@endforeach --}}
</div>
@section('scripts')
{{-- <script>
	$('.btn-print').click(function(event) {
        $("#printArea").printArea();
    });
</script> --}}
<script
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsj-gbtqTAsxtWNbcqrRmE8ExatChS_Ko&libraries=places">
</script>
<script>

	$.get('{{url('addInfo',$sin_number)}}', function(data) {
		console.log('ok');
	});

	$('#without-addr-hour').click(function(event) {
		if ($(this).is(':checked')) {
			$('[name="address"]').prop('disabled','disabled');
			$('[name="date"]').prop('disabled','disabled');
		}else{
			$('[name="address"]').removeAttr('disabled');
			$('[name="date"]').removeAttr('disabled');
		}
	});

	$('#save-picture').click(function(event) {

		if ($('#without-addr-hour').is(':checked')) {

			$('#address-modal').text("senza indirizzo ed senza ora");

		}else{

			if ((!$('[name="address"]').val() || !$('[name="date"]').val()) || ($('[name="address"]').val() == "" || $('[name="date"]').val() == "")) {
				return alert("Inserisci l'indirizzo e la data");
			}else{
				$('#address-modal').text("con l’indirizzo "+($('[name="address"]').val())+" ed all’ora"+($('[name="date"]').val()));
			}
		}

		$('#modal-pre-upload').modal({backdrop:false, show: true});
		// $('#modal-pre-upload').modal('show');

	});

	$('#btn-pre-upload').click(function(event) {

		let formData = new FormData();

		formData.append('file',document.getElementById('imgInp').files[0]);
		formData.append('id',$('[name="typology"]').val());

		if ($('#without-addr-hour').is(':checked')) {

			formData.append('lat',"");
			formData.append('lng',"");
			formData.append('address',"N/A");
			formData.append('date',"");

		}else{

			formData.append('lat',$('[name="lat"]').val());
			formData.append('lng',$('[name="lng"]').val());
			formData.append('address',$('[name="address"]').val());
			formData.append('date',$('[name="date"]').val());
		}
		
		// $.post(, formData, function(data, textStatus, xhr) {
		// 	console.log(data);
		// });

		$.ajax({
			url: '{{url('api/uploadExtraFileImageTech')}}',
			type: 'POST',
			data: formData,
			contentType: false,
			processData: false
		})
		.done(function(data) {
			console.log(data);

			location.reload();
		})
		.fail(function(r) {

			var errors = $.parseJSON(r.responseText);
			var html = "";

			$.each(errors, function(index, val) {
			 html += val+'<br>'
			});

			(new PNotify({
                title: 'Error',
                text: html,
                type: 'error',
                // desktop: {
                //     desktop: true
                // }
            })).get().click(function(e) {
                // if ($('.ui-pnotify-closer, .ui-pnotify-sticker, .ui-pnotify-closer *, .ui-pnotify-sticker *').is(e.target)) return;
                // alert('Hey! You clicked the desktop notification!');
            });
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	$('#move-checked').click(function (e) {
		e.preventDefault();
		let el = $('.checks:checked');

		$.each(el, function(index, val) {
			 $(this).parent().detach().appendTo('#new_block');
		});

		if (el.length > 0) {
			$('#new_block').addClass('move_block');
		}
	});

	$.each($('.formated_address'), function(index, val) {
		var id = $(this).data('id');
		 $.ajax({
		 	url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+$(this).data('latlng')+'&key=AIzaSyCAWEZr2CfI6Prw9P4Wp1lG6gW1VBW5t0Y',
		 })
		 .done(function(data) {
		 	val.innerText = data.results[0].formatted_address;
		 	$.post('{{url('admin/updateAddress')}}', {_token: '{{csrf_token()}}',id:id,address:data.results[0].formatted_address}, function(data, textStatus, xhr) {
		 	});
		 })		 
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
		$('form.panel').attr('action','{{url('admin/express-tech-export-full')}}');
		$('form.panel').submit();
		$('form.panel').attr('action','{{url('admin/express-tech-export')}}');
	});

	$('[name="location"]').click(function(event) {
		if ($(this).is(':checked')) {
			$('#export-all').addClass('hidden');
			$('#export-all-l').removeClass('hidden');
		}else{
			$('#export-all-l').addClass('hidden');
			$('#export-all').removeClass('hidden');
		}
	});

	$('[name="empresa"]').change(function(event) {
		$('#export-all').attr('href',$('#export-all').data('href')+'/'+$(this).val());
		$('#export-all-l').attr('href',$('#export-all-l').data('href')+'/'+$(this).val());
	});


	function readURL(input) {
	  if (input.files && input.files[0]) {
	    var reader = new FileReader();
	    
	    reader.onload = function(e) {
	      $('.preview').css('background-image', 'url('+e.target.result+')');
	    }
	    
	    reader.readAsDataURL(input.files[0]); // convert to base64 string
	  }
	}

	$("#imgInp").change(function() {
	  readURL(this);
	});

	function showPosition() {
        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {

				$('[name="lat"]').val(position.coords.latitude);
				$('[name="lng"]').val(position.coords.longitude);

                initMap(position.coords.latitude,position.coords.longitude);

                // geocodeLatLng({lat: position.coords.latitude, lng: position.coords.longitude});
            });
        } else {
            alert("Sorry, your browser does not support HTML5 geolocation.");
        }
    }

    map = null;
    marker = null;

	function initMap(lat,lng)
	{
		map = new google.maps.Map(document.getElementById('map'), {
	      zoom: 8,
	      center: {lat:lat,lng:lng},
	      // mapTypeControl: false,
		  streetViewControl: false,
		  rotateControl: false,
          mapTypeId: 'roadmap'
	    });

	    marker = new google.maps.Marker({
	    	position: {lat:lat,lng:lng},
	    	map: map,
	    	draggable:true,
	    })

	    google.maps.event.addListener(marker,'dragend',function(event) {
          $('[name="lat"]').val(event.latLng.lat());
		  $('[name="lng"]').val(event.latLng.lng());

		  geocodeLatLng({lat: event.latLng.lat(), lng: event.latLng.lng()});
        });

	    initAutocomplete();
	}

	function initAutocomplete()
	{
		var geocoder = new google.maps.Geocoder;
		var input = document.getElementById('searchTextField');
		var options = {
		  types: ['address']
		};

		autocomplete = new google.maps.places.Autocomplete(input, options);

		autocomplete.setComponentRestrictions(
        {'country': 'it'});

		autocomplete.addListener('place_changed', fillInAddress);

		function fillInAddress() {
		  // Get the place details from the autocomplete object.
		  var arr = autocomplete.getPlace();
		  // document.getElementById('searchTextField').value = "";

		  var latlng = {lat:arr.geometry.location.lat(),lng:arr.geometry.location.lng()};

		  $('[name="lat"]').val(arr.geometry.location.lat());
		  $('[name="lng"]').val(arr.geometry.location.lng());

		  marker.setMap(null);

		  marker = new google.maps.Marker({
	    	position: latlng,
	    	map: map,
	    	draggable:true,
	      });

	      map.setCenter(latlng);

	      google.maps.event.addListener(marker,'dragend',function(event) {
            $('[name="lat"]').val(event.latLng.lat());
		    $('[name="lng"]').val(event.latLng.lng());

		    geocodeLatLng({lat: event.latLng.lat(), lng: event.latLng.lng()});
          });

		  // geocoder.geocode({'location': latlng}, function(results, status) {
	   //      if (status === 'OK') {
	   //        if (results[0]) {
	          	
	   //        	$('[name="address"]').val(results[0].formatted_address);

	   //        } else {
	   //          window.alert('No results found');
	   //        }
	   //      } else {
	   //        window.alert('Geocoder failed due to: ' + status);
	   //      }
    //   	  });
		}
	}

	function geocodeLatLng(latlng) {

		console.log(latlng);

	  const geocoder = new google.maps.Geocoder();

	  geocoder.geocode({'location': latlng}, function(results, status) {
	      if (status === 'OK') {
	        if (results[0]) {
	        	$('[name="address"]').val(results[0].formatted_address);
	        } else {
	          window.alert('No results found');
	        }
	      } else {
	        window.alert('Geocoder failed due to: ' + status);
	      }
		});
	}

	$('.btn-delete-img').click(function(event) {
		event.preventDefault();
		event.stopPropagation();

		$('#btn-delete-img').attr('href', '{{url('deleteClaimFile')}}/'+$(this).data('id'));
		$('#modal-delete-img').modal('show');
	});

	$('[name="hour"]').change(function (e) {
		e.preventDefault();

		let c = $(this).is(':checked') ? '1' : '0';

		$.get('{{url('setHour')}}/'+c, function(data) {
			console.log(data);
		});
	});

	showPosition();
</script>
@endsection
@stop