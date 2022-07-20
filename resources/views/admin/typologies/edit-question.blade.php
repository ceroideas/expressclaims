<div class="modal fade" id="edit-q-{{$inp->id}}">
	<div class="modal-dialog">
		<form action="{{url('admin/updateInput')}}" method="POST" class="modal-content addInput">
			{{csrf_field()}}
			<div class="modal-header"></div>
			<div class="modal-body">
			    <div class="creator">
			      <input type="hidden" name="id" value="{{$inp->id}}">

			      <div class="row">
			      	<div class="col-sm-12">
			      		
				      <div class="form-group">
				        <label>Tipo di dati</label>
				        <select name="type" disabled class="form-control" onchange="changeType(this)" data-id="{{$inp->phase_id}}">
				          {{-- <option value="text">Texto</option> --}}
				          <option {{$inp->type == 'text' ? 'selected' : ''}} value="text">Testo</option>
				          <option {{$inp->type == 'number' ? 'selected' : ''}} value="number">Numerico</option>
				          <option {{$inp->type == 'select' ? 'selected' : ''}} value="select">Menu a tendina</option>
				          {{-- <option {{$inp->type == 'radio' ? 'selected' : ''}} value="radio">Radio</option> --}}
				          <option {{$inp->type == 'checkbox' ? 'selected' : ''}} value="checkbox">Casella di controllo</option>
				        </select>
				      </div>
			      	</div>
			      	<div class="col-sm-12">
			      		
				      <div class="form-group">
				        <label>Domanda / titolo</label>
			          <input name="question" class="form-control" required value="{{$inp->question}}">
				        {{-- <input type="text" class="form-control" name="question"> --}}
				      </div>
			      	</div>

			      	<div class="col-sm-12">
			      		
				      <div class="form-group">
				        <label>Key</label>
			          <input name="key" class="form-control" required value="{{$inp->key}}">
				        {{-- <input type="text" class="form-control" name="question"> --}}
				      </div>
			      	</div>
			      	<div class="col-sm-12">
			      		
				      <div class="form-group">
				        <label>Informazione</label>
			          	<textarea name="info" class="form-control" rows="3">{{$inp->info}}</textarea>
				        {{-- <input type="text" class="form-control" name="question"> --}}
				      </div>
			      	</div>
			      	{{-- <div class="col-sm-12">
				      <div class="form-group">
		                <label for="file">Imagen(Opcional)</label>
		                <input type="file" id="file" class="dropify" name="file" data-height="130" accept="image/*" data-default-file="{{ $inp->file ? $inp->file : '' }}" />
		            </div>
			      	</div> --}}
			      </div>

			      <label><input type="checkbox" name="modify" onclick="modifyOptions(this)" /> Modifica le opzioni</label>

			      <div class="input-list hidden">

					@if ($inp->type == 'checkbox' || $inp->type == 'radio' || $inp->type == 'select')

					<div class="form-group">
						<label style="display:block; width: 100%; margin-bottom: 15px">Aggiungi opzione <button type="button" onclick="addOption(this)" class="btn btn-xs btn-success pull-right" type=""><i class="fa fa-plus"></i></button></label>
						<ul class="option-list" style="padding-left: 20px">
							@foreach ($inp->options as $op)
								<li class="option-li">
									<div class="form-group">
										<div class="input-group">
											<input type="text" name="options[]" required class="form-control" style="width:100%;float:left;" placeholder="Opzione" value="{{$op->option}}" />
										
											<div class="input-group-btn">
												<button onclick="removeOption(this)" type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>
											</div>
										</div>
									</div>
									
								</li>
							@endforeach
						</ul>

					</div>

					@endif

				  </div>

			    </div>
			    <div class="form-group">
			      <button type="submit" class="btn btn-xs btn-success">Salva</button>
			      {{-- <button type="button" data-dismiss="modal" class="btn btn-xs btn-warning">Cancelar</button> --}}
			    </div>
			</div>

		</form>
	</div>
</div>	