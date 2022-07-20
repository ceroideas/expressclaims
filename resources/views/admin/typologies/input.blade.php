<li class="create-input" style="position: relative; border-bottom: 1px solid #f0f0f0">
	<span onclick="$(this).parent().remove()" style="position: absolute; top: 0; right: 0; cursor: pointer; z-index: 9999">x</span>
  <form action="{{url('admin/addInput')}}" method="POST" class="addInput">
    {{csrf_field()}}
    <div class="creator">
      <input type="hidden" name="typology_section_id" value="{{$typology_section_id}}">

      <div class="row">
      	<div class="col-sm-12">
      		
  	      <div class="form-group">
  	        <label>Tipo di dati</label>
  	        <select name="type" class="form-control" onchange="changeType(this)" data-id="{{$typology_section_id}}">
  	          <option value="text">Testo</option>
  	          <option value="number">Numerico</option>
  	          <option value="select">Menu a tendina</option>
  	          {{-- <option value="radio">Radio</option> --}}
  	          <option value="checkbox">Casella di controllo</option>
  	        </select>
  	      </div>
        </div>

      	<div class="col-sm-12">
      		
  	      <div class="form-group">
  	        <label>Domanda / titolo</label>
            <input type="text" name="question" class="form-control" required />
  	        {{-- <input type="text" class="form-control" name="question"> --}}
  	      </div>
  	      <div class="form-group">
  	        <label>Key</label>
            <input type="text" name="key" class="form-control" required />
  	      </div>
            <div class="form-group">
                <label for="info">Informazione</label>
                <textarea name="info" id="info" cols="30" rows="3" class="form-control"></textarea>
            </div>
      	</div>
      </div>

      <div class="input-list">
	    </div>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-xs btn-success">Salva</button>
      {{-- <button type="button" data-dismiss="modal" class="btn btn-xs btn-warning">Cancelar</button> --}}
    </div>
  </form>
</li>