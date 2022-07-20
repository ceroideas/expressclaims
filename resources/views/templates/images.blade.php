<div class="col s12" id="images1">
	<div class="card-header">
		<h5 style="padding: 0 10px">
		<img src="{{url('ag/i/marcador.svg')}}" alt="" class="responsive-img" style="width: 40px;position: relative;top: 4px;margin-right:10px;"> 
			<span style="position: relative; top: -8px;">Geolocalizzazione</span>
		<span style="float: right; position: relative; top: 10px;">1/2</span></h5>
	</div>
	<div style="padding: 20px;">
		<h5 style="margin: 0">Indirizzo</h5>

		<input type="text" id="mapSearchInput">

		<div id="map">
		</div>

		<div style="">
			<button class="waves-effect waves-light btn orange" onclick="reloadPosition()" style="margin-bottom: 20px; width: 100%;">Ricarica posizione</button>

			<button class="waves-effect waves-light btn blue darken-1 goto2" disabled="disabled" style="width: 100%;">CONFERMA POSIZIONE E PROSEGUI</button>
		</div>
	</div>

</div>

<div class="col s12" id="images2">
	<div class="card-header">
		<h5 style="padding: 0 10px">
		<img src="{{url('ag/i/imagenes.svg')}}" alt="" class="responsive-img" style="width: 40px;position: relative;top: 4px;margin-right:10px;">
			<span style="position: relative; top: -8px;">Scatta foto</span>
		<span style="float: right; position: relative; top: 10px;">2/2</span></h5>
	</div>
	<div style="padding: 20px; text-align: center; position: relative;">

		<label for="hdCam"><a class="waves-effect waves-light" id="btnhdCam" style="margin: 0 0 10px; position: relative;/* bottom: 30px; right: 20px;*/"><img src="{{url('ag/i/tomar-foto.svg')}}" alt="" style="width: 70px;"></a>
			<span style="position: absolute;top: 38px;margin-left: 10px;">Clicca l'icona per <br> scattare una foto</span> 
		</label>

		<h5 id="noimages-message" class="no-files" style="margin: 0">Nessuna immagine caricata</h5>

		<div id="imagesList">
		</div>
	</div>

	<button class="waves-effect waves-light btn blue darken-1" id="btnConfirm-modal" onclick="$('#confirm1').modal('open')" style="display: none; position: absolute; bottom:42px; left:0; right:0; top: auto; margin: auto;">
		{{-- <img src="{{url('ag/i/aceptar.svg')}}" alt="" style="width: 70px;"> --}}
		PROSEGUI
	</button>
</div>