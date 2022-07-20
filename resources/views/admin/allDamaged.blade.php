@foreach ($damaged as $val)
	@php
		$tp = "";

		if ($val->TP == 'AC' || $val->TP == 'RG') {$tp = "Acqua condotta";}
		if ($val->TP == 'AT') {$tp = "Atti Vandalici";}
		if ($val->TP == 'EA') {$tp = "Evento Atmosferico";}
		if ($val->TP == 'FE') {$tp = "Fenomeno Elettrico";}
		if ($val->TP == 'EL') {$tp = "Elettronica";}
		if ($val->TP == 'AL' || $val->TP == 'VA' || $val->TP == 'altre') {$tp = "Pluralità di garanzie";}
		if ($val->TP == 'IN') {$tp = "Incendio";}
		if ($val->TP == 'RE') {$tp = "RC Auto";}
		if ($val->TP == 'CR') {$tp = "Cristalli";}
		if ($val->TP == 'AR') {$tp = "Accertamenti";}
		if ($val->TP == 'FU' || $val->TP == 'AM' || $val->TP == 'RA') {$tp = "Furto";}
		if ($val->TP == 'RC' || $val->TP == 'RU' || $val->TP == 'RP') {$tp = "Responsabilità Civile";}
		if ($val->TP == 'NN') {$tp = "Non indennizzabile";}
	@endphp
	<div id="content">
	  <h5 style="margin-bottom: 3px" id="firstHeading" class="firstHeading">Danneggiato: {{$val->Danneggiato}}</h5>
	  <h5 style="margin-top: 5px; margin-bottom: 3px" id="firstHeading" class="firstHeading"><b>{{$val->N_P}}</b> - {{$val->Assicurato}} {{$val->TP}} - {{$tp}}</h5>
	  <h5 style="margin-top: 5px; margin-bottom: 3px" id="firstHeading"> COMPAGNIA: <b>{{$val->COMPAGNIA}}</b></h5>
	  <h6 style="margin-top: 7px" id="firstHeading"> Stato: <b>{{$val->Stato}}</b> {!!$val->DATA_SOPRALLUOGO ? '<small style="display: inline-block; margin-left: 16px;font-weight: 700">Il: '.$val->DATA_SOPRALLUOGO.'</small>' : ''!!}</h6>
	  <div id="bodyContent">
	  <p>
	  Indirizzo: {{$val->CAP}} {{$val->INDIRIZZO}}, {{$val->COMUNE}}, {{$val->PROVINCIA}}<br>
	  Cellulare: {{$val->CELLULARE == null ? '---' : $val->CELLULARE}}<br>
	  Telefono: {{$val->TELEFONO == null ? '---' : $val->TELEFONO}}<br>
	  Email: {{$val->EMAIL == null ? '---' : $val->EMAIL}}<br>
	  Data Incarico: {{$val->DT_Incarico == null ? '---' : Carbon\Carbon::parse($val->DT_Incarico)->format('d-m-Y H:i')}}<br>
	  Data Assegnata: {{$val->DT_ASSEGNATA == null ? '---' : Carbon\Carbon::parse($val->DT_ASSEGNATA)->format('d-m-Y H:i')}}<br>
	  Accertatore: <b>{{$val->SOPRALLUOGO == null ? '---' : $val->SOPRALLUOGO}}</b><br>

	  </p>
	  @if (Auth::user())
	  	<button onclick="loadManagementModal({{$val->id}})" class="loadManagementModal btn btn-success btn-xs" type="button">Management</button>
	  @endif
	  </div>
	</div>

	<hr>
@endforeach	