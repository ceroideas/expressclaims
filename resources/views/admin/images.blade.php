@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

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
</style>


<input type="hidden" name="nameToUse" value="{{ $name }}">








<div class="row">
	<div class="col-sm-12">
		<form class="panel" method="POST" action="{{ url('admin/express-claims-export') }}" target="_blank">
			<div class="panel-heading">Immagini del sinistro
				{{-- <button class="btn btn-info btn-xs pull-right">Export</button> --}}
				<div style="margin-left: 10px" class="pull-right"><label><input type="checkbox" name="location" value="1"> <small>Senza posizione</small></label></div>
				<button type="submit" class="btn btn-info btn-xs pull-right" >Esportare Checked</button>
				{{-- <a href="{{ url('admin/express-claims-export-all',$reservation_id) }}" style="margin-right: 5px;" target="_blank" class="btn btn-info btn-xs pull-right" id="export-all">Esportare tutto</a> --}}
				<button type="button" class="btn btn-info btn-xs pull-right" style="margin-right: 5px;" id="export-all">Esportare tutto</button>
				<a href="{{ url('admin/express-claims-export-zip',$reservation_id) }}" style="margin-right: 5px;" target="_blank" class="btn btn-info btn-xs pull-right">Esportare Zip</a>
				<button type="button" class="btn btn-secondary btn-xs pull-right" style="margin-right: 5px;" id="export-full">Esportare senza info</button>
				<button type="button" class="btn btn-success btn-xs pull-right" style="margin-right: 5px;" id="check-uncheck">Check/Uncheck tutto</button>

				<select name="empresa" class="pull-right" style="margin-right: 5px; position: relative; border-radius: 3px; height: 22px; font-size: 12px; opacity: 1">
					<option value="renova">Renova</option>
					<option value="studio zappa">Studio Zappa</option>
					<option value="gespea">Gespea</option>
				</select>

			</div>
			<div class="panel-body">
				<div class="row connectedSortable" id="sortable" data-url="{{url('admin/changeOrderClaims')}}">

					<div class="col-sm-12">
						<button data-toggle="modal" data-target="#add-image" class="btn btn-sm btn-info" type="button"><i class="fa fa-plus"></i></button>
						<br>
						<br>
					</div>

					{{ csrf_field() }}
					<input type="hidden" name="reservation_id" value="{{ $reservation_id }}">
					@foreach ($i as $element)
						<div class="col-md-3 elementSortable" style="height: 412px;" data-file_id="{{$element->id}}">
							<input type="checkbox"class="checks" name="ids[]" -checked value="{{ $element->id }}">
							<a download href="{{ url('uploads/users/'.$element->user_id.'/'.$res->sin_number.'/images',$element->imagen) }}">
							<div style="height: 250px; border: 1px solid silver; background-size: cover; background-position: center; background-image: url('{{ url('uploads/users/'.$element->user_id.'/'.$res->sin_number.'/images','t_'.$element->imagen) }}'); position: relative;">
								{{-- <a href="javascript:;" class="btn btn-xs btn-info rotate" style="position: absolute; right: 0; bottom: 0;">
									<i class="fa fa-undo"></i> Ruotare
								</a>
								<a href="javascript:;" class="btn btn-xs btn-info open-image" style="position: absolute; left: 0; bottom: 0;">
									<i class="fa fa-download"></i> Download
								</a> --}}
								@if ($element->type == 5)
									<button type="button" class="btn btn-xs btn-warning btn-delete-img" data-id="{{$element->id}}"><i class="fa fa-trash"></i></button>
								@endif
							</div></a>
							<br>
							<small>
							<b>Riferimento Interno:</b> {{ $res->sin_number }} <br>
							<b>Latitudine:</b> {{ $element->lat ? $element->lat : '---' }} <br>
							<b>Longitudine:</b> {{ $element->lon ? $element->lon : '---' }} <br>
							<span class="add-ovr"><b>Indirizzo:</b> {{$element->address == 'N/A' ? 'N/A' : ''}} <span class="formated_address" data-id="{{$element->id}}" data-latlng="{{$element->lat.','.$element->lon}}"></span> </span> <br>
							{{-- <b>Indirizzo:</b> <span class="formated_address" data-id="{{$element->id}}" data-latlng="{{$element->lat.','.$element->lon}}"></span> <br> --}}
							{{-- <b>Indirizzo:</b> {{ $element->address }} <br> --}}
							<b>Data:</b> {{ $element->web ? $element->web : $element->created_at->format('d-m-Y H:i:s') }} <br>
							<b>Via:</b> {{ $element->type == 1 ? 'Snapshot' : ($element->type == 4 ? 'Fotocamera' : ($element->type == 5 ? 'Web' : 'Chat')) }} <br> <br></small>
						</div>
					@endforeach
				</div>
			</div>
		</form>
	</div>
</div>

{{-- {{App\User::find($res->customer_id)}} --}}

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

@section('scripts')

<script
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsj-gbtqTAsxtWNbcqrRmE8ExatChS_Ko&libraries=places">
</script>

<script>

	$.get('{{url('addInfoClaims',$reservation_id)}}', function(data) {
		console.log('ok');
	});

	// $('.btn-print').click(function(event) {
 //        $("#printArea").printArea();
 //    });
	// $('.open-image').click(function(event) {

 //        function makeid() {
 //          // var text = "";
 //          // var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

 //          // for (var i = 0; i < 8; i++)
 //          // text += possible.charAt(Math.floor(Math.random() * possible.length));

 //          // return text;
 //          	var today = new Date();
 //            var dd = today.getDate();var mm = today.getMonth()+1;var yyyy = today.getFullYear();
 //            var hh = today.getHours();var ii = today.getMinutes();var ss = today.getSeconds();
 //            if(dd<10) {dd = '0'+dd} 
 //            if(mm<10) {mm = '0'+mm} 
 //            today = dd + '/' + mm + '/' + yyyy + '-' + hh + ':' + ii + ':' + ss;
 //            return $('#nameToUse').val()+'-'+today;
 //        }
 //        var base64 = $(this).data('href');

 //    	var rotate64 = function(base64data, degrees, enableURI) {
	// 		return new Promise(function(resolve, reject) {
	// 			//assume 90 degrees if not provided
	// 	    degrees = degrees ? degrees : 0;
			
	// 			var canvas = document.createElement("canvas");
	// 			canvas.setAttribute("id", "hidden-canvas");
	// 			canvas.style.display = "none";
	// 			document.body.appendChild(canvas);
			
	// 	    var ctx = canvas.getContext("2d");

	// 	    var image = new Image();
	// 	    //assume png if not provided
	// 	    image.src = (base64data.indexOf(",") == -1 ? "data:image/png;base64," : "") + base64data;
	// 	    image.onload = function() {
	// 	      var w = image.width;
	// 	      var h = image.height;
	// 	      var rads = degrees * Math.PI/180;
	// 	      var c = Math.cos(rads);
	// 	      var s = Math.sin(rads);
	// 	      if (s < 0) { s = -s; }
	// 	      if (c < 0) { c = -c; }
	// 	      //use translated width and height for new canvas
	// 	      canvas.width = h * s + w * c;
	// 	      canvas.height = h * c + w * s;
	// 	      //draw the rect in the center of the newly sized canvas
	// 	      ctx.translate(canvas.width/2, canvas.height/2);
	// 	      ctx.rotate(degrees * Math.PI / 180);
	// 	      ctx.drawImage(image, -image.width/2, -image.height/2);
	// 	      //assume plain base64 if not provided
	// 	      resolve(enableURI ? canvas.toDataURL() : canvas.toDataURL().split(",")[1]);
	// 	      document.body.removeChild(canvas);
	// 	    };
	// 	    image.onerror = function() {
	// 	      reject("Unable to rotate data\n" + image.src);
	// 	    };
	// 	  });
	// 	}

	// 	function doIt() {
	// 		rotate64(base64)
	// 		.then(function(rotated) {			
 //        		download("data:image/png;base64,"+rotated, makeid()+'.jpg', 'image/jpeg');
 //        		download("data:image/png;base64,"+rotated, makeid()+'.jpg', 'image/jpeg');
	// 			console.log(rotated);
	// 		}).catch(function(err) {
	// 			console.error(err);
	// 		});
	// 	}
	// 	doIt();
 //    });

  //   $('.rotate').click(function(event) {
  //   	var data = $(this).parent().data('href');
  //   	var _this_ = $(this);

  //   	var rotate64 = function(base64data, degrees, enableURI) {
		// 	return new Promise(function(resolve, reject) {
		// 		//assume 90 degrees if not provided
		//     degrees = degrees ? degrees : 90;
			
		// 		var canvas = document.createElement("canvas");
		// 		canvas.setAttribute("id", "hidden-canvas");
		// 		canvas.style.display = "none";
		// 		document.body.appendChild(canvas);
			
		//     var ctx = canvas.getContext("2d");

		//     var image = new Image();
		//     //assume png if not provided
		//     image.src = (base64data.indexOf(",") == -1 ? "data:image/png;base64," : "") + base64data;
		//     image.onload = function() {
		//       var w = image.width;
		//       var h = image.height;
		//       var rads = degrees * Math.PI/180;
		//       var c = Math.cos(rads);
		//       var s = Math.sin(rads);
		//       if (s < 0) { s = -s; }
		//       if (c < 0) { c = -c; }
		//       //use translated width and height for new canvas
		//       canvas.width = h * s + w * c;
		//       canvas.height = h * c + w * s;
		//       //draw the rect in the center of the newly sized canvas
		//       ctx.translate(canvas.width/2, canvas.height/2);
		//       ctx.rotate(degrees * Math.PI / 180);
		//       ctx.drawImage(image, -image.width/2, -image.height/2);
		//       //assume plain base64 if not provided
		//       resolve(enableURI ? canvas.toDataURL() : canvas.toDataURL().split(",")[1]);
		//       document.body.removeChild(canvas);
		//     };
		//     image.onerror = function() {
		//       reject("Unable to rotate data\n" + image.src);
		//     };
		//   });
		// }

		// function doIt() {
		// 	rotate64(data)
		// 	.then(function(rotated) {			
		// 		_this_.parent().css('background-image', 'url(data:image/png;base64,'+rotated+')');
		// 		console.log(rotated);
		// 	}).catch(function(err) {
		// 		console.error(err);
		// 	});
		// }
		// doIt();
  //   });

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
		formData.append('id',{{$res->id}});

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
			url: '{{url('api/uploadExtraFileImage')}}',
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

  	$.each($('.formated_address'), function(index, val) {
		var id = $(this).data('id');
		 $.ajax({
		 	url: 'https://maps.googleapis.com/maps/api/geocode/json?latlng='+$(this).data('latlng')+'&key=AIzaSyCAWEZr2CfI6Prw9P4Wp1lG6gW1VBW5t0Y',
		 })
		 .done(function(data) {
		 	val.innerText = data.results[0].formatted_address;
		 	$.post('{{url('admin/updateAddressClaims')}}', {_token: '{{csrf_token()}}',id:id,address:data.results[0].formatted_address}, function(data, textStatus, xhr) {
		 	});
		 })		 
	});

  	$('#export-full').click(function(event) {
		$('form.panel').attr('action','{{url('admin/express-claims-export-full')}}');
		$('form.panel').submit();
		$('form.panel').attr('action','{{url('admin/express-claims-export')}}');
	});

	$('#export-all').click(function(event) {
		$('form.panel').attr('action','{{url('admin/express-claims-export-all',$reservation_id)}}');
		$('form.panel').submit();
		$('form.panel').attr('action','{{url('admin/express-claims-export')}}');
	});


	/**/

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

		$('#btn-delete-img').attr('href', '{{url('deleteFile')}}/'+$(this).data('id'));
		$('#modal-delete-img').modal('show');
	});

	showPosition();
</script>
@endsection
@stop