<div class="col s12" id="information1">
	<div class="card-header">
		<h5 style="padding: 0 10px">
		<img src="{{url('ag/i/informacion.svg')}}" alt="" class="responsive-img" style="width: 40px;position: relative;top: 4px;margin-right:10px;"> 
			<span style="position: relative; top: -8px;">Informazioni sinistro</span>
		<span style="float: right; position: relative; top: 10px;">1/2</span></h5>
	</div>

	<div style="padding: 20px;">
		<div class="row" style="margin: auto .375rem 0;">
		    <div class="input-field col s12">
				<select name="typology">
					<option value="" selected disabled></option>
					<option>Danno d'acqua condotta</option>
					<option>Fenomeno elettrico</option>
					<option>Evento atmosferico</option>
					<option>Guasti ladri</option>
					<option>Atti vandalici</option>
					<option>Incendio</option>
					<option>Furto</option>
					<option>Altro</option>
				</select>
			    <label>Seleziona tipologia sinistro</label>
		    </div>
		</div>

		<div class="row">
		    <div class="input-field col s12" style="margin: auto 1rem 0; width: calc(100% - 2rem) !important">
				<input type="text" class="datepicker" id="date" name="date">
			    <label for="date">Indica data del sinistro</label>
		    </div>
		</div>

		<div class="row">
		    <div class="input-field col s12" style="margin: auto 1rem 0; width: calc(100% - 2rem) !important">
				<input type="number" id="ammount" name="ammount">
			    <label style="width: 100%;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;" for="ammount">Indica importo danno lordo richiesto alla Compagnia</label>
		    </div>
		</div>
	</div>

	<div style="text-align: center;">
		<button class="waves-effect waves-light btn blue darken-1 _goto2" disabled>CONFERMA E PROSEGUI</button>
	</div>
</div>

<div class="col s12" id="information2">
	<div class="card-header">
		<h5 style="padding: 0 10px">
		<img src="{{url('ag/i/informacion.svg')}}" alt="" class="responsive-img" style="width: 40px;position: relative;top: 4px;margin-right:10px;"> 
			<span style="position: relative; top: -8px;">Informazioni sinistro</span>
		<span style="float: right; position: relative; top: 10px;">2/2</span></h5>
	</div>

	<div style="padding: 20px;">
		<h5 style="text-align: center;margin-top: 0">Foto codice IBAN</h5>
		<label id="beforephoto" for="iban" style="width: 300px; height: 170px; border: 1px solid #dedede; display: block;margin: auto; border-radius: 3px; background-size: cover; background-position: center; text-align: center; position: relative;">
			<span id="text-placeholder" style="font-size: 18px; position: absolute; top: 0; bottom: 0; left: 0; right: 0; padding: 17% 0;">Clicca qui per scattare la foto dell’IBAN</span>
		</label>

		<div id="afterphoto" style="text-align: center; display:none;">
			<div style="display:block; width: 300px; height: 170px; border: 1px solid #dedede; margin: auto; border-radius: 3px; background-size: cover; background-position: center; text-align: center; position: relative;">
				
			</div>

			<img src="{{url('ag/i/borrar.svg')}}" onclick="deleteIban()" class="waves-effect waves-light" style="width:30px;margin-top: 10px;">
		</div>
		<br>
		<div class="row">
	    <div class="input-field col s12">
		  <h5 style="text-align: center;margin: 0">In alternativa, digiti il codice IBAN</h5>
	      <input id="text_iban" type="text" style="text-align: center;">
	      {{-- <label class="active" for="iban">In alternativa, digiti il codice IBAN</label> --}}
	    </div>
	  </div>
	</div>


	<div style="text-align: center;">
		<button class="waves-effect waves-light btn blue darken-1 finalize mb-20" id="finalize-1-modal" onclick="$('#confirm3').modal('open')" disabled>CONFERMA E TERMINA</button>

		<br>

		<button class="waves-effect waves-light btn red finalize mb-20" id="finalize-2-modal" onclick="$('#confirm3').modal('open')">TERMINA SENZA INSERIRE I DATI</button>
	</div>
</div>