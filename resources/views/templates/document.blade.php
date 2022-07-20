<div class="col s12">
	<div class="card-header">
		<h5 style="padding: 0 10px">
		<img src="{{url('ag/i/marcador.svg')}}" alt="" class="responsive-img" style="width: 40px;position: relative;top: 4px;margin-right:10px;"> 
			<span style="position: relative; top: -8px;">Giustificativi danno</span>
		{{-- <span style="float: right; position: relative; top: 10px;">1/2</span> --}}
	</h5>
	</div>

	<div style="padding: 20px; position: relative;">
		<div class="row">
			<div class="col s12" style="text-align: left; position: relative;">
				<label for="documents"><a class="waves-effect waves-light" id="btnhdDocument" style="margin: 0 0 10px; position: relative; /*bottom: 120px; right: 20px; */"><img src="{{url('ag/i/cargar-documento.svg')}}" alt="" style="width: 70px;"></a>
				</label>
				<span style="text-align: left; font-size: .8rem;color: #9e9e9e;position: absolute;top: 29px; left: 85px">Clicca l'icona per caricare un documento</span> 
			</div>
			<div class="col s12" style="text-align: left; position: relative;">
				<label for="hdCam2"><a class="waves-effect waves-light" id="btnhdCamDoc" style="margin: 0 0 10px; position: relative; /*bottom: 30px; right: 20px; */"><img src="{{url('ag/i/tomar-foto.svg')}}" alt="" style="width: 70px;"></a>
				</label>
				<span style="text-align: left; font-size: .8rem;color: #9e9e9e;position: absolute;top: 25px; left: 85px">Clicca l'icona per scattare una foto</span> 
			</div>
		</div>
		{{-- <h5 id="nodocument-message" style="margin: 0">Nessun documento caricato</h5> --}}
		<h5 id="nodocument-message" class="no-files" style="margin: 0">Nessuna documento caricato</h5>

		<div id="documentsList">
		</div>
	</div>

	{{-- <label for="documents"><a class="btn-floating btn-large waves-effect waves-light red" id="btnhdDocument" style="position: absolute; bottom: 78px; right: 10px;"><img src="{{url('file.png')}}" alt="" style="width: 30px;top: 10px;"></a></label> --}}

	{{-- <label for="hdCam2"><a class="btn-floating btn-large waves-effect waves-light" id="btnhdCamDoc" style="position: absolute; bottom: 10px; right: 10px;"><img src="{{url('ag/camera.svg')}}" alt="" style="width: 30px;top: 10px;"></a></label> --}}


	{{-- <a class="btn-floating btn-large waves-effect waves-light green" id="btnConfirm2" style="display: none; position: absolute; bottom: 10px; left: 10px;"><img src="{{url('ag/confirm.svg')}}" alt="" style="width: 30px;top: 10px;"></a> --}}

	{{-- <a class="waves-effect waves-light" id="btnConfirm2" style="display: none; position: absolute; bottom: 30px; left: 20px;"><img src="{{url('ag/i/aceptar.svg')}}" alt="" style="width: 70px;"></a> --}}
	<button class="waves-effect waves-light btn blue darken-1" id="btnConfirm2-modal" onclick="$('#confirm2').modal('open')" style="display: ; position: absolute; bottom:42px; left:0; right:0; top: auto; margin: auto;">
		{{-- <img src="{{url('ag/i/aceptar.svg')}}" alt="" style="width: 70px;"> --}}
		PROSEGUI
	</button>
</div>