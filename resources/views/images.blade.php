@extends('layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<style>
	#main-content {
    	margin: 0;
    }
</style>

<input type="hidden" name="nameToUse" value="{{ $name }}">
<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">Immagini del sinistro</div>
			<div class="panel-body">
				<div class="row">
					@foreach ($i as $element)
						<div class="col-md-3">
							<a download href="{{ url('uploads/users/'.$element->user_id.'/'.$res->sin_number.'/images',$element->imagen) }}">
							<div style="height: 250px; border: 1px solid silver; background-size: cover; background-position: center; background-image: url({{ url('uploads/users/'.$element->user_id.'/'.$res->sin_number.'/images',$element->imagen) }}); position: relative;">
								{{-- <a href="javascript:;" class="btn btn-xs btn-info rotate" style="position: absolute; right: 0; bottom: 0;">
									<i class="fa fa-undo"></i> Ruotare
								</a>
								<a href="javascript:;" class="btn btn-xs btn-info open-image" style="position: absolute; left: 0; bottom: 0;">
									<i class="fa fa-download"></i> Download
								</a> --}}
							</div></a> <br>
							<small>
							<b>Riferimento Interno:</b> {{ $res->sin_number }} <br>
							<b>Latitudine:</b> {{ $element->lat }} <br>
							<b>Longitudine:</b> {{ $element->lon }} <br>
							<b>Indirizzo:</b> {{ $element->address }} <br>
							<b>Data:</b> {{ $element->created_at->format('d-m-Y H:i:s') }} <br>
							<b>Via:</b> {{ $element->type == 1 ? 'Snapshot' : ($element->type == 4 ? 'Fotocamera' : 'Chat') }} <br> <br></small>
						</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@section('scripts')
<script>
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
</script>
@endsection
@stop