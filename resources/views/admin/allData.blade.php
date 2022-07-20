<form action="{{url('saveAllData')}}" method="POST" id="saveAllData" onsubmit="return mysubmitF(event)">
	{{csrf_field()}}
	
	<input type="hidden" name="operation" value="update">
	<input type="hidden" name="id" value="{{$data->id}}">

	<div class="row">
		<div class="col-sm-4">
			
			<div class="form-group">
				<label>Stato pratica</label>
				<input type="hidden" name="Stato" value="{{$data->Stato}}"> <br>

				{{-- <b>{{$statos->description}}</b> --}}
				<select name="Stato" class="form-control changed">
						<option value=""></option>
					@foreach ($statos as $st)
						<option value="{{$st->idav}}" {{$st->order == $data->Stato ? 'selected' : ''}}>{{$st->description}}</option>
					@endforeach
				</select>
			</div>

			{{-- <div class="form-group">
				<label>Società</label>
				<select name="society" class="form-control changed">
						<option value="" disabled selected></option>
						<option {{$data->society == 'Z' ? 'selected' : ''}} value="Z">Studio Zappa - Z</option>
						<option {{$data->society == 'R' ? 'selected' : ''}} value="R">Renova - R</option>
				</select>
			</div> --}}
		</div>
		
		<div class="col-sm-4">
			<div class="form-group">
				<label>Società:</label> <br>

				<b>{{$data->society ? ($data->society == 'Z' ? 'Studio Zappa - Z' : 'Renova - R') : '...'}}</b>
				{{-- <select name="Stato" class="form-control changed">
						<option value=""></option>
					@foreach ($statos as $st)
						<option value="{{$st->idav}}" {{$st->order == $data->Stato ? 'selected' : ''}}>{{$st->description}}</option>
					@endforeach
				</select> --}}
			</div>
		</div>

		<div class="col-sm-4">
			<div style="height: 72px;">
				<div class="checkbox">
					<button type="submit" id="submit-data" class="btn btn-xs btn-success" style="width: 49%">Salva</button>
					<button type="button" data-dismiss="modal" class="btn btn-xs btn-danger" style="width: 49%">Chiudi</button>
				</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="form-group">
				<label>Cambia sopralluoghista 1</label>
				<select name="SOPRALLUOGO" class="form-control changed">
						<option value=""></option>
					@foreach ($peritos as $pt)
						<option {{$pt->name == $data->SOPRALLUOGO ? 'selected' : ''}}>{{$pt->name}}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="form-group">
				<label>Data sopralluogo 1</label>
				<input type="text" name="DATA_SOPRALLUOGO" class="form-control changed" value="{{$data->DATA_SOPRALLUOGO ? \Carbon\Carbon::parse($data->DATA_SOPRALLUOGO)->format('d-m-Y H:i') : ""}}" id="data-sopralluogo" >
			</div>
		</div>

		<div class="col-sm-4">
			<div class="form-group">
				<label>Cambia perito gestore</label>
				<select name="PERITO_GESTORE" class="form-control changed">
						<option value=""></option>
					@foreach ($gestore as $gt)
						<option {{$gt->name == $data->PERITO_GESTORE ? 'selected' : ''}}>{{$gt->name}}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="col-sm-4">
			<div class="form-group">
				<label>Cambia sopralluoghista 2</label>
				<select name="SOPRALLUOGO_2" class="form-control changed">
						<option value=""></option>
					@foreach ($peritos as $pt)
						<option {{$pt->name == $data->SOPRALLUOGO_2 ? 'selected' : ''}}>{{$pt->name}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="form-group">
				<label>Data sopralluogo 2</label>
				<input type="text" name="DATA_SOPRALLUOGO_2" class="form-control changed" value="{{$data->DATA_SOPRALLUOGO_2 ? \Carbon\Carbon::parse($data->DATA_SOPRALLUOGO_2)->format('d-m-Y H:i') : ""}}" id="data-sopralluogo2" >
			</div>
		</div>

		<div class="col-sm-6">
			<div class="form-group">
				<div class="checkbox">
				  <label style="padding: 0;"><input type="checkbox" name="vdp" value="vdp" {{$data->VDP == 1 ? 'checked' : ''}}> Videoperizia</label>
				</div>
				<div class="checkbox">
				  <label style="padding: 0;"><input type="checkbox" name="aut" value="aut" {{$data->AUT == 1 ? 'checked' : ''}}> Authority</label>
				</div>
			</div>
		</div>

		<div class="col-sm-6">
			<div class="form-group">
				<div class="checkbox">
				
				<label>Assegnazione in E.T.:</label>

				<b>{{$data->ET ? $data->ET : '...'}}</b>

				</div>
				{{-- <select name="Stato" class="form-control changed">
						<option value=""></option>
					@foreach ($statos as $st)
						<option value="{{$st->idav}}" {{$st->order == $data->Stato ? 'selected' : ''}}>{{$st->description}}</option>
					@endforeach
				</select> --}}
			</div>
		</div>


		<div class="col-sm-12">
			<div class="form-group">
				<label>Note</label>
				<textarea name="daily" class="form-control changed" rows="8">{{$data->note}}{{"\n"}}-------------------------{{ "\n".Carbon\Carbon::now()->format('d-m-Y H:i')."\n"}}-------------------------{{"\n"}}</textarea>
			</div>	
		</div>

		{{-- <div class="col-sm-6">
			<div class="form-group">
				<label>Operazione (Required)</label>
				<select name="operation" class="form-control changed" required id="">
					<option value="" selected disabled></option>
					<option value="ass1">Assegna sopralluoghista 1</option>
					<option value="ass2">Fissa la data del Sopralluogo 1</option>
					<option value="fix1">Assegna sopralluoghista 2</option>
					<option value="fix2">Fissa la data del Sopralluogo 2</option>
					<option value="close">Chiudi il Sopralluogo</option>
					<option value="update">Aggiorna solo Aut e Vdp</option>
				</select>
			</div>	
		</div> --}}

		<img id="modal-data-loader" src="{{url('ajax-loader.gif')}}" style="display: block; margin: auto; width: 100px; display: none;">
	</div>
</form>

<script>
	
	localStorage.setItem('close','1');

	$("#data-sopralluogo").datetimepicker({format: 'dd-mm-yyyy hh:ii',autoclose:true}).on('hide', function(e) {
	    e.stopPropagation();
	  });
	$("#data-sopralluogo2").datetimepicker({format: 'dd-mm-yyyy hh:ii',autoclose:true}).on('hide', function(e) {
	    e.stopPropagation();
	  });

	$('#saveAllData').unbind('click', sendAllData);
	$('#saveAllData').submit(sendAllData);

	$('.changed').unbind('change', modalChanged);
	$('.changed').on('change', modalChanged);
</script>