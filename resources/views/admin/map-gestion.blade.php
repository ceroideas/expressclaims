@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<style>
	#map-locations {
		height: 800px;
	}
	.select2-container {
		z-index: 10000;
		width: 318px !important;
	}
	.select2-selection {
		font-size: 12px;
	}
	#peritoI2 .select2-selection ul, #peritoI .select2-selection ul, #tpI .select2-selection ul {
		padding-right: 74px !important;
	}
	.gm-style > div > div > div > div > div > div > div {
		/*position: relative;
		top: 12px;*/
		margin-top: 16px;
	}

	.siteNotice {
		border-bottom: 1px solid #c8c8c8;
	}
	.loadModal {
		margin-bottom: 8px;
	}
	.exportExcludes {
		text-decoration: underline !important;
	}
	#filtro-perito {
		color: #f00000;
		font-weight: 700;
		font-size: 12px;
		display: block;
		margin-top: 10px;
		margin-bottom: -10px;
	}
</style>

<div class="row" id="blockThis">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading"><span id="reload">Situazione Generale</span>

				{{-- <label for="excel" class="btn btn-info btn-xs pull-right" >Import Excel</label> --}}
				<input type="file" id="excel" style="position: absolute; left: -9999px;">

				{{-- <label style="background-color: #585bf3 !important; border-color: #585bf3; margin-right: 3px;" data-toggle="collapse" data-target="#filtros2" class="btn btn-info btn-xs pull-right" style="margin-right: 3px;">Perito gestore</label> --}}

				<label data-toggle="collapse" data-target="#filtros" class="btn btn-info btn-xs pull-right" style="margin-right: 3px;">Filtro</label>

				{{-- <div id="filtros2" class="collapse" style="
				top: 38px;
				right: 16px;
				position: absolute; min-width: 350px; max-width: 350px; width: auto; padding: 16px; background: #fff; z-index: 9999; box-shadow: 0 0 2px rgba(51,51,51,.5); border-radius: 3px;">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label style="font-size: 12px;">Perito che fa in gestione</label>

								<div class="input-group" id="peritoI2">
									<select id="perito2" class="form-control input-sm select2-multiple"></select>
									<div class="input-group-append">
										<button class="btn btn-info" type="button" id="perito2SelectAll"
										style="position: absolute; z-index: 10001; top: 0; right: 0;"
										>TUTTO</button>

										<button class="btn btn-danger hidden" type="button" id="perito2DeselectAll"
										style="position: absolute; top: 3px; z-index: 10001; right: 3px"
										>X</button>										
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-12" style="">
							<div class="form-group" id="calendarI2">
								<label style="font-size: 12px;">Cerca in un giorno specifico</label>

								<input type="text" class="form-control" id="datepicker" placeholder="DD/MM/YYYY">
							</div>
						</div>

						<div class="col-sm-12">
							<label for=""></label>
							<button style="position: relative;" class="btn btn-block btn-info" id="filter2">Filtro</button>
						</div>
					</div>
				</div> --}}

				<div id="filtros" class="collapse" style="
				top: 38px;
				right: 16px;
				position: absolute; min-width: 350px; max-width: 350px; width: auto; padding: 16px; background: #fff; z-index: 9999; box-shadow: 0 0 2px rgba(51,51,51,.5); border-radius: 3px;">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label style="font-size: 12px;">Compagnia</label>
								<select id="compagnia" class="form-control input-sm select2-multiple" multiple></select>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label style="font-size: 12px;">Perito gestore</label>

								<div class="input-group" id="peritoI">
									<select id="perito" class="form-control input-sm select2-multiple" multiple></select>
									<div class="input-group-append">
										<button class="btn btn-info" type="button" id="peritoSelectAll"
										style="position: absolute; top: 3px; z-index: 10001; right: 3px"
										>TUTTO</button>

										<button class="btn btn-danger hidden" type="button" id="peritoDeselectAll"
										style="position: absolute; top: 3px; z-index: 10001; right: 3px"
										>X</button>										
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-sm-12" style="">
							<div class="form-group" id="calendarI2">
								<label style="font-size: 12px;">Cerca in un giorno specifico</label>

								<input type="text" class="form-control" id="datepicker" placeholder="DD/MM/YYYY">
							</div>
						</div>

						<div class="col-sm-12">
							<div class="form-group">
								<label style="font-size: 12px;">Provincia di accadimento del sinistro</label>
								<select id="provincia" class="form-control input-sm select2-multiple" multiple></select>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label style="font-size: 12px;">Stato pratica</label>
								<select id="stato" class="form-control input-sm select2-multiple" multiple></select>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="form-group">
								<label style="font-size: 12px;">Tipologia</label>

								<div class="input-group" id="tpI">
									<select id="tp" class="form-control input-sm select2-multiple" multiple></select>
									<div class="input-group-append">
										<button class="btn btn-info" type="button" id="tpSelectAll"
										style="position: absolute; top: 3px; z-index: 10001; right: 3px"
										>TUTTO</button>

										<button class="btn btn-danger hidden" type="button" id="tpDeselectAll"
										style="position: absolute; top: 3px; z-index: 10001; right: 3px"
										>X</button>

									</div>
								</div>
							</div>
						</div>

						<div class="col-sm-12">
							<div class="form-group">
								<label style="font-size: 12px;">Incarichi con giorni maggiori di:</label>
								<input id="max" style="border: solid #aaa 1px; height: 40px;" type="number" class="form-control">
							</div>
						</div>

						<div class="col-sm-12">
							<label for=""></label>
							<button style="position: relative;" class="btn btn-block btn-info" id="filter">Filtro</button>
							<button type="button" style="position: relative; margin-top: 8px;" class="btn btn-block btn-success" id="filter-excel"><i class="fa fa-file-excel"></i> Esporta Excel</button>
							<br>
							<button style="position: relative;" class="btn btn-block btn-danger" id="del-filter">Elimina filtro</button>
						</div>
					</div>
				</div>

			</div>
			<div class="panel-body">

				<div class="row">
					{{-- <div class="col-sm-9">
						<div id="map-locations">
						</div>
					</div> --}}
					<div class="col-sm-4 col-sm-offset-4">

						@if (App\MapInformation::first())
							<br>
							<b>Data e nome dell'ultimo file caricato: </b> 
							<span id="date-excel">
								{{App\ExcelFile::orderBy('id','desc')->first() ? App\ExcelFile::orderBy('id','desc')->first()->name.' | '.App\ExcelFile::orderBy('id','desc')->first()->created_at->format('d-m-Y H:i:s') : ''}}
								 {{-- | <span data-toggle="modal" data-target="#excel-table" style="cursor: pointer;">Tabella</span> --}}
							</span>
						@endif

						<br>

						<span id="filtro-perito"></span>

						<hr>

						<div class="form-group" style="position: relative;">
							<div class="dropdown" style="position: absolute; right: 0; top: 0;">
							  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="padding: 0 10px; border: none; background-color: transparent;">
							  <span class="caret"></span></button>
							  <ul class="dropdown-menu" style="right: -1px; left: unset;">
							    <li><a href="javascript:;" id="exportAll">Esporta Excel</a></li>
							  </ul>
							</div>

							<div class="btn btn-info btn-lg btn-block" id="loadAll" style="padding: 14px; font-size: 12px">
								TUTTI: <span id="total-1">0</span>
								<br>
								Giorni medi: <span id="total-media-1">0</span>

								<div class="row">
									<div class="col-sm-6">
										S. Fatto: <span id="total-f">0</span> <br>
										Giorni medi: <span id="total-media-f">0</span>
									</div>
									<div class="col-sm-6">
										S. NON Fatto: <span id="total-nf">0</span> <br>
										Giorni medi: <span id="total-media-nf">0</span>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12">
								<div class="form-group" style="position: relative;">
									<div class="dropdown" style="position: absolute; right: 0; top: 0;">
									  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="padding: 0 10px; border: none; background-color: transparent;">
									  <span class="caret"></span></button>
									  <ul class="dropdown-menu" style="right: -1px; left: unset;">
									    <li><a href="javascript:;" id="exportVerde">Esporta Excel</a></li>
									  </ul>
									</div>
									<div class="btn btn-success btn-lg btn-block" id="loadVerde" style="padding: 14px; font-size: 12px; background-color: #6dbb4a;">

										< 20 gg.: <span id="verde">0</span>
										<br>
										Giorni medi: <span id="verde-media">0</span>

										<div class="row">
											<div class="col-sm-6">
												S. Fatto: <span id="verde-f">0</span> <br>
												{{-- Giorni medi: <span id="verde-media-f">0</span> --}}
											</div>
											<div class="col-sm-6">
												S. NON Fatto: <span id="verde-nf">0</span> <br>
												{{-- Giorni medi: <span id="verde-media-nf">0</span> --}}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group" style="position: relative;">
									
									<div class="dropdown" style="position: absolute; right: 0; top: 0;">
									  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="padding: 0 10px; border: none; background-color: transparent;">
									  <span class="caret"></span></button>
									  <ul class="dropdown-menu" style="right: -1px; left: unset;">
									    <li><a href="javascript:;" id="exportAmarillo">Esporta Excel</a></li>
									  </ul>
									</div>

									<div class="btn btn-warning btn-lg btn-block" id="loadAmarillo" style="padding: 14px; font-size: 12px; background-color: #e4ba00;">
										< 40 gg.: <span id="amarillo">0</span>
										<br>
										Giorni medi: <span id="amarillo-media">0</span>

										<div class="row">
											<div class="col-sm-6">
												S. Fatto: <span id="amarillo-f">0</span> <br>
												{{-- Giorni medi: <span id="amarillo-media-f">0</span> --}}
											</div>
											<div class="col-sm-6">
												S. NON Fatto: <span id="amarillo-nf">0</span> <br>
												{{-- Giorni medi: <span id="amarillo-media-nf">0</span> --}}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group" style="position: relative;">
									
									<div class="dropdown" style="position: absolute; right: 0; top: 0;">
									  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="padding: 0 10px; border: none; background-color: transparent;">
									  <span class="caret"></span></button>
									  <ul class="dropdown-menu" style="right: -1px; left: unset;">
									    <li><a href="javascript:;" id="exportRojo">Esporta Excel</a></li>
									  </ul>
									</div>

									<div class="btn btn-danger btn-lg btn-block" id="loadRojo" style="padding: 14px; font-size: 12px; background-color: #ff6c60;">
										< 60 gg.: <span id="rojo">0</span>
										<br>
										Giorni medi: <span id="rojo-media">0</span>

										<div class="row">
											<div class="col-sm-6">
												S. Fatto: <span id="rojo-f">0</span> <br>
												{{-- Giorni medi: <span id="rojo-media-f">0</span> --}}
											</div>
											<div class="col-sm-6">
												S. NON Fatto: <span id="rojo-nf">0</span> <br>
												{{-- Giorni medi: <span id="rojo-media-nf">0</span> --}}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group" style="position: relative;">
									
									<div class="dropdown" style="position: absolute; right: 0; top: 0;">
									  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="padding: 0 10px; border: none; background-color: transparent;">
									  <span class="caret"></span></button>
									  <ul class="dropdown-menu" style="right: -1px; left: unset;">
									    <li><a href="javascript:;" id="exportVioleta">Esporta Excel</a></li>
									  </ul>
									</div>

									<div class="btn btn-info btn-lg btn-block" id="loadVioleta" style="padding: 14px; font-size: 12px; background-color: blueviolet; border-color: #4a24a6">
										> 60 gg.: <span id="violeta">0</span>
										<br>
										Giorni medi: <span id="violeta-media">0</span>

										<div class="row">
											<div class="col-sm-6">
												S. Fatto: <span id="violeta-f">0</span> <br>
												{{-- Giorni medi: <span id="violeta-media-f">0</span> --}}
											</div>
											<div class="col-sm-6">
												S. NON Fatto: <span id="violeta-nf">0</span> <br>
												{{-- Giorni medi: <span id="violeta-media-nf">0</span> --}}
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-12 hidden" id="marron-div">
								<div class="form-group" style="position: relative;">
									
									<div class="dropdown" style="position: absolute; right: 0; top: 0;">
									  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="padding: 0 10px; border: none; background-color: transparent;">
									  <span class="caret"></span></button>
									  <ul class="dropdown-menu" style="right: -1px; left: unset;">
									    <li><a href="javascript:;" id="exportMarron">Esporta Excel</a></li>
									    <li><a href="javascript:;" id="openAllInfoWindow">Open all Infowindow</a></li>
									    <li class="hide"><a href="javascript:;" id="closeAllInfoWindow">Close all Infowindow</a></li>
									  </ul>
									</div>

									<div class="btn btn-warning btn-lg btn-block" id="loadMarron" style="padding: 14px; font-size: 12px; background-color: #4a46ff; border-color: #0500ff">
										Perito: <span id="marron">0</span>
										<br>
										Giorni medi: <span id="marron-media">0</span>
									</div>
								</div>
							</div>

							<div class="col-sm-12">
								<hr>

								{{-- @php
									$t_s = App\MapInformation::where(function($q){
							            $q->where(['lat'=>'','lng'=>''])
							              ->orWhere(['lat'=>null,'lng'=>null]);
							        })->where('status',1)->count();
								@endphp

								Per <span class="sin_latlng">{{$t_s}}</span> sinistri la API non ha fornito la posizione. <a href="#" data-type="without" class="exportExcludes">Esporta</a><br> <br>

								<button class="btn btn-xs btn-primary btn-block" id="check_gm">Richiedi posizione <span class="sin_latlng">{{$t_s}}</span> sinistri mancanti</button> <br>
								<button style="display: block; margin-top: 8px;" class="btn btn-xs btn-warning btn-block" id="reload_gm">Reload Map</button>

								<hr> --}}

								{{-- @php
									$past = App\MapInformation::where('status',1)->where('DATA_SOPRALLUOGO','<',Carbon\Carbon::today())->where('DATA_SOPRALLUOGO','!=','')->count();
								@endphp

								Nel file caricato erano presenti <span id="past">{{$past}}</span> sinistri con sopralluogo già effettuato che non vengono mostrati nella mappa. --}}
								{{-- <a href="#" data-type="past" class="exportExcludes">Esporta</a> --}}
							</div>
						</div>

						{{-- <div class="row">
							<div class="col-sm-12">
								<table class="table table-hover table-condensed">
									<thead>
										<tr>
											<th>R.Interno</th>
											<th>Assicurato</th>
											<th>Compagnia</th>
											<th>TP</th>
											<th>Stato</th>
											<th>Indirizzo</th>
											<th>DT Incarico</th>
										</tr>
									</thead>
									<tbody id="results">
										@foreach (App\MapInformation::all() as $mi)
											<tr>
												<td>{{$mi->N_P}}</td>
												<td>{{$mi->Assicurato}}</td>
												<td>{{$mi->COMPAGNIA}}</td>
												<td>{{$mi->TP}}</td>
												<td>{{$mi->Stato}}</td>
												<td>{{$mi->INDIRIZZO}}</td>
												<td>{{$mi->DT_Incarico}}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div> --}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="multiple-modal">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Tutti i danneggiati
			</div>
			<div class="modal-body" id="multiple-data">
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-xs btn-danger">Chiudi</button>
			</div>
		</div>
	</div>
</div>
@section('scripts')
	

	<script>

		$( function() {
		  $( "#datepicker" ).datepicker({
		  	dateFormat: "dd/mm/yy"
		  });
		});

		var already_loaded = false;

		var mAll = [];
		var mVerde = [];
		var mAmarillo = [];
		var mRojo = [];
		var mVioleta = [];
		var mMarron = [];

		var infoWindows = [];
		var map;

		function convertDate(date)
		{
			return date;
			// let dhArray = date.split(' ');
			// let dateArray = date.split(' ');
			// let aux;

			// aux = datesArray[0];
			// datesArray[0] = datesArray[1];
			// datesArray[1] = aux;

			// return datesArray.join('/');
		}

		function loadModal(N_Sinistro)
		{
			// alert(lat+" "+lng)
			$('#multiple-data').html("<img src=\"{{url('ajax-loader.gif')}}\" style=\"display: block; margin: auto; width: 100px;\">");
			$('#multiple-modal').modal('show');

			$.post('{{url('multiple-modal')}}', {_token:'{{csrf_token()}}',N_Sinistro:N_Sinistro,compagnia:$('#compagnia').val(),perito3:$('#perito').val(),provincia:$('#provincia').val(),stato:$('#stato').val(),tp:$('#tp').val()},function(data, textStatus, xhr) {
				// console.log(data);

				$('#multiple-data').html(data);
			});
		}

		function initMap(getLocations = "no") {

			infoWindows = [];

			$('#filtro-perito').text("");

			$('#marron-div').addClass('hidden');

			$('#verde').text("0"); $('#verde-media').text((0).toFixed(2));
			$('#amarillo').text("0"); $('#amarillo-media').text((0).toFixed(2));
			$('#rojo').text("0"); $('#rojo-media').text((0).toFixed(2));
			$('#violeta').text("0"); $('#violeta-media').text((0).toFixed(2));

			$('#total-1').text((0).toString());
			$('#total-media-1').text(((0).toFixed(2)).toString());

			$('#total-f').text("0"); $('#total-media-f').text("0");
			$('#total-nf').text("0"); $('#total-media-nf').text("0");

			$('#verde-nf').text("0"); $('#verde-f').text("0");
			$('#amarillo-nf').text("0"); $('#amarillo-f').text("0");
			$('#rojo-nf').text("0"); $('#rojo-f').text("0");
			$('#violeta-nf').text("0"); $('#violeta-f').text("0");

			$('#blockThis').block({ message: "Stiamo caricando i resultati." })

				let address;
				let url;
				let fecha
				let diff
				let color
				let icon

				let verde = {total:0,diff:0,fatto:0,non_fatto:0};
				let amarillo = {total:0,diff:0,fatto:0,non_fatto:0};
				let rojo = {total:0,diff:0,fatto:0,non_fatto:0};
				let violeta = {total:0,diff:0,fatto:0,non_fatto:0};

				let fatto = {total:0,diff:0};
				let non_fatto = {total:0,diff:0};

				mAll = [];
				mVerde = [];
				mAmarillo = [];
				mRojo = [];
				mVioleta = [];

				/**/

				let hoy = moment().tz('Europe/Rome');

				$.post('{{url('getMapInformationG')}}', {_token: '{{csrf_token()}}',ignore:getLocations,data_type:[1,2],datepicker:$('#datepicker').val()}, function(data, textStatus, xhr) {

					var compagnia = [];
					var perito = [];
					var provincia = [];
					var stato = [];
					var tp = [];

					function addToButtons(val,color)
		            {
		            	if (color == 'verde') {mVerde.push(val);}
						if (color == 'amarillo') {mAmarillo.push(val);}
						if (color == 'rojo') {mRojo.push(val);}
						if (color == 'violeta') {mVioleta.push(val);}

						mAll.push(val);
		            }

					let getLocations = localStorage.getItem('getLocations');

					if (getLocations == 'false') {$('#blockThis').unblock();}else{
						$('#date-excel').text(data[0].name+" | "+moment(data[0].created_at).format('DD-MM-YYYY HH:mm'));
					}

					// console.log("data[1]",data[1].filter(x=>x.type == 2));

					$.each(data[1], function(index, v) {

						var sinisters = [];
						var type2 = [];

						if (!v.diferents) {
							sinisters = [v];
							type2 = sinisters.filter(x=>x.type == 2);
						}else{
							type2 = v.diferents.filter(x=>x.type == 2);
							sinisters = v.diferents.sort((a,b)=>{if(a.DATA_SOPRALLUOGO > b.DATA_SOPRALLUOGO){return -1}else{return 1}return 0});
							sinisters = sinisters.filter(x=>(moment(x.DATA_SOPRALLUOGO) >= moment().startOf('day') || x.DATA_SOPRALLUOGO == "") && x.type == 1);
						}

						var val = sinisters[0] || [];
						val.diferents = sinisters;

			            // if (val.lat && val.lng) {

						if (!already_loaded) {

							$.each(/*val.diferents*/sinisters, function(index, val) {
								if(val.COMPAGNIA != "") {compagnia.push(val.COMPAGNIA);}
								if(val.PERITO_GESTORE != "") {perito.push(val.PERITO_GESTORE);}
								if(val.PROVINCIA != "") {provincia.push(val.PROVINCIA);}
								if(val.Stato != "") {stato.push(val.Stato);}
								if(val.TP != "") {tp.push(val.TP);}
							});
						}

						for (var i = 0; i < type2.length; i++) {

							let _val = type2[i];

							let _fecha = moment(_val.DT_Incarico),
							_diff = hoy.diff(_fecha, 'days'),
							_color = "";

							if (_diff <= 20) {
				                _color = "verde";
				                verde.total++;
				                verde.diff+=_diff;
				            }else if (_diff > 20 && _diff <= 40) {
				                _color = "amarillo";
				                amarillo.total++;
				                amarillo.diff+=_diff;
				            }else if (_diff > 40 && _diff <= 60) {
				                _color = "rojo";
				                rojo.total++;
				                rojo.diff+=_diff;
				            }else if (_diff > 60) {
				                _color = "violeta";
				                violeta.total++;
				                violeta.diff+=_diff;
				            }

							addToButtons(_val,_color);

							try{
								eval(_color+"['fatto']++");
							}catch{
								console.log("catch",_color);
							}
							if (_diff) {
	            				fatto.diff += _diff;
	            			}
						}

						if (val.lat && val.lng) {

							for (var i = 0; i < val.diferents.length; i++) {

								let _val = val.diferents[i];

								let _fecha = moment(_val.DT_Incarico),
								_diff = hoy.diff(_fecha, 'days'),
								_color = "";

								if (_diff <= 20) {
					                _color = "verde";
					                verde.total++;
					                verde.diff+=_diff;
					            }else if (_diff > 20 && _diff <= 40) {
					                _color = "amarillo";
					                amarillo.total++;
					                amarillo.diff+=_diff;
					            }else if (_diff > 40 && _diff <= 60) {
					                _color = "rojo";
					                rojo.total++;
					                rojo.diff+=_diff;
					            }else if (_diff > 60) {
					                _color = "violeta";
					                violeta.total++;
					                violeta.diff+=_diff;
					            }

								addToButtons(_val,_color);

								try{
									eval(_color+"['non_fatto']++");
								}catch{
									console.log("catch",_color);
								}
								if (_diff) {
		            				non_fatto.diff += _diff;
		            			}
							}
						}
			            // }

					});

					// console.log(verde.diff,verde.total);
					// console.log(non_fatto.diff,non_fatto.total);

					$('#verde').text(verde.total); $('#verde-media').text(((verde.diff/verde.total) || 0).toFixed(2));
					$('#amarillo').text(amarillo.total); $('#amarillo-media').text(((amarillo.diff/amarillo.total) || 0).toFixed(2));
					$('#rojo').text(rojo.total); $('#rojo-media').text(((rojo.diff/rojo.total) || 0).toFixed(2));
					$('#violeta').text(violeta.total); $('#violeta-media').text(((violeta.diff/violeta.total) || 0).toFixed(2));

					$('#total-1').text((verde.total+amarillo.total+rojo.total+violeta.total).toString());
					$('#total-media-1').text((((verde.diff+amarillo.diff+rojo.diff+violeta.diff)/(verde.total+amarillo.total+rojo.total+violeta.total)).toFixed(2)).toString());

					/**/

					let nft = verde.non_fatto+amarillo.non_fatto+rojo.non_fatto+violeta.non_fatto;
					let ft = (verde.total-verde.non_fatto)+(amarillo.total-amarillo.non_fatto)+(rojo.total-rojo.non_fatto)+(violeta.total-violeta.non_fatto);

					$('#total-nf').text(nft);
					$('#total-media-nf').text((( (non_fatto.diff/nft) || 0 ).toFixed(2)).toString());

					$('#total-f').text(ft);
					$('#total-media-f').text((( (fatto.diff/ft) || 0 ).toFixed(2)).toString());

					/**/

					$('#verde-nf').text(verde.non_fatto); $('#verde-f').text(verde.total-verde.non_fatto);
					$('#amarillo-nf').text(amarillo.non_fatto); $('#amarillo-f').text(amarillo.total-amarillo.non_fatto);
					$('#rojo-nf').text(rojo.non_fatto); $('#rojo-f').text(rojo.total-rojo.non_fatto);
					$('#violeta-nf').text(violeta.non_fatto); $('#violeta-f').text(violeta.total-violeta.non_fatto);

					console.log(verde.non_fatto,amarillo.non_fatto,rojo.non_fatto,violeta.non_fatto);

					$('#blockThis').unblock();

					if (!already_loaded) {

						function onlyUnique(value, index, self) { 
						    return self.indexOf(value) === index;
						}
						let html = "";
						$.each(compagnia.sort().filter( onlyUnique ),function(index, el) {
							if (el != null || el != "") {
								html+="<option>"+el+"</option>";
							}
						});
						$('#compagnia').html(html);
						html = "<option value='none'>-- Senza perito --</option>";
						$.each(perito.sort().filter( onlyUnique ),function(index, el) {
							// console.log(el)
							if (el != null || el != "") {
								html+="<option>"+el+"</option>";
							}
						});
						$('#perito').html(html);
						$('#perito2').html(html);
						html = "";
						$.each(provincia.sort().filter( onlyUnique ),function(index, el) {
							if (el != null || el != "") {
								html+="<option>"+el+"</option>";
							}
						});
						$('#provincia').html(html);
						html = "<option value='none'>-- Tutti tranne quelli in stato Fissato --</option>";
						$.each(stato.sort().filter( onlyUnique ),function(index, el) {
							if (el != null || el != "") {
								html+="<option>"+el+"</option>";
							}
						});
						$('#stato').html(html);
						html = "";
						$.each(tp.sort().filter( onlyUnique ),function(index, el) {
							if (el != null || el != "") {
								html+="<option>"+el+"</option>";
							}
						});
						$('#tp').html(html);

						already_loaded = true;
					}
				});
			
		}

		var allowChange = true;

		$('#perito').change(function(event) {
			if (allowChange) {
				if ($(this).val() != null) {
					if ($(this).val().find(x=>x == "none")) {
						allowChange = false;
						$('#perito').val(["none"]).change();
						setTimeout(()=>{
							allowChange = true;
						},100)
					}
				}
			}
		});

		$('#stato').change(function(event) {
			if (allowChange) {
				if ($(this).val() != null) {
					if ($(this).val().find(x=>x == "none")) {
						allowChange = false;
						$('#stato').val(["none"]).change();
						setTimeout(()=>{
							allowChange = true;
						},100)
					}
				}
			}
		});

		$('#excel').change(function(event) {

			infoWindows = [];

			$('#filtro-perito').text("");

			already_loaded = false;

			var formData = new FormData();

			formData.append('file',document.getElementById('excel').files[0]);
			formData.append('_token','{{csrf_token()}}');

			$('#blockThis').block({ message: "Caricamento..." })


			$.ajax({
				url: '{{url('uploadExcel')}}',
				type: 'POST',
				contentType: false,
				processData: false,
				data: formData,
			})
			.done(function() {
				// console.log("success");
				setTimeout(()=>{
					initMap('si');
				},1000)
			})
			.fail(function(e) {
				$('#blockThis').unblock();
				
				alert("File non leggibile!")
				// console.log(e)
				// console.log("error");

			})
			.always(function() {
				// console.log("complete");

				$('#blockThis').unblock();
			});
			
		});

		$('#filter').click(function(event) {

			infoWindows = [];

			$('#filtro-perito').text("");

			$('#marron-div').addClass('hidden');

			$('#verde').text("0"); $('#verde-media').text((0).toFixed(2));
			$('#amarillo').text("0"); $('#amarillo-media').text((0).toFixed(2));
			$('#rojo').text("0"); $('#rojo-media').text((0).toFixed(2));
			$('#violeta').text("0"); $('#violeta-media').text((0).toFixed(2));

			$('#total-1').text((0).toString());
			$('#total-media-1').text(((0).toFixed(2)).toString());

			$('#total-f').text("0"); $('#total-media-f').text("0");
			$('#total-nf').text("0"); $('#total-media-nf').text("0");

			$('#verde-nf').text("0"); $('#verde-f').text("0");
			$('#amarillo-nf').text("0"); $('#amarillo-f').text("0");
			$('#rojo-nf').text("0"); $('#rojo-f').text("0");
			$('#violeta-nf').text("0"); $('#violeta-f').text("0");
			// function initMap() {
				$('[data-target="#filtros"]').trigger('click');
			  	navigator.geolocation.getCurrentPosition(function(position) {
			        var pos = {
				      lat: position.coords.latitude,
				      lng: position.coords.longitude
				    };

					let address;
					let url;
					let fecha
					let diff
					let color
					let icon

					let verde = {total:0,diff:0,fatto:0,non_fatto:0};
					let amarillo = {total:0,diff:0,fatto:0,non_fatto:0};
					let rojo = {total:0,diff:0,fatto:0,non_fatto:0};
					let violeta = {total:0,diff:0,fatto:0,non_fatto:0};

					let fatto = {total:0,diff:0};
					let non_fatto = {total:0,diff:0};

					$('#verde').text("0");
					$('#amarillo').text("0");
					$('#rojo').text("0");
					$('#violeta').text("0");
					$('#total-1').text("0");

					mAll = [];
					mVerde = [];
					mAmarillo = [];
					mRojo = [];
					mVioleta = [];

					let hoy = moment().tz('Europe/Rome');

					let max = $('#max').val();

					if (!max) {
						max=0;
					}

					let info = {_token: '{{csrf_token()}}',compagnia: $('#compagnia').val(), perito3: $('#perito').val(), provincia: $('#provincia').val(), stato: $('#stato').val(), tp: $('#tp').val(),data_type:[1,2],datepicker:$('#datepicker').val()};

					$.post('{{url('getMapInformationG')}}',info, function(data, textStatus, xhr) {

						function addToButtons(val,color)
			            {
			            	if (color == 'verde') {mVerde.push(val);}
							if (color == 'amarillo') {mAmarillo.push(val);}
							if (color == 'rojo') {mRojo.push(val);}
							if (color == 'violeta') {mVioleta.push(val);}

							mAll.push(val);
			            }

						$.each(data[1], function(index, v) {

							var sinisters = v.diferents.sort((a,b)=>{if(a.DATA_SOPRALLUOGO > b.DATA_SOPRALLUOGO){return -1}else{return 1}return 0});
							var type2 = v.diferents.filter(x=>x.type == 2);
							// sinisters = sinisters.filter(x=>moment(x.DATA_SOPRALLUOGO) >= moment().startOf('day') || x.DATA_SOPRALLUOGO == "");

							var val = sinisters[0] || [];
							val.diferents = sinisters;

							if (!already_loaded) {

								$.each(/*val.diferents*/sinisters, function(index, val) {
									if(val.COMPAGNIA != "") {compagnia.push(val.COMPAGNIA);}
									if(val.PERITO_GESTORE != "") {perito.push(val.PERITO_GESTORE);}
									if(val.PROVINCIA != "") {provincia.push(val.PROVINCIA);}
									if(val.Stato != "") {stato.push(val.Stato);}
									if(val.TP != "") {tp.push(val.TP);}
								});
							}

							for (var i = 0; i < type2.length; i++) {

								let _val = type2[i];

								let _fecha = moment(_val.DT_Incarico),
								_diff = hoy.diff(_fecha, 'days'),
								_color = "";

								if (_diff >= max) {

									if (_diff <= 20) {
						                _color = "verde";
						                verde.total++;
						                verde.diff+=_diff;
						            }else if (_diff > 20 && _diff <= 40) {
						                _color = "amarillo";
						                amarillo.total++;
						                amarillo.diff+=_diff;
						            }else if (_diff > 40 && _diff <= 60) {
						                _color = "rojo";
						                rojo.total++;
						                rojo.diff+=_diff;
						            }else if (_diff > 60) {
						                _color = "violeta";
						                violeta.total++;
						                violeta.diff+=_diff;
						            }

									addToButtons(_val,_color);

									try{
										eval(_color+"['fatto']++");
									}catch{
										console.log("catch",_color);
									}
									if (_diff) {
			            				fatto.diff += _diff;
			            			}
								}

							}

							if (val.lat && val.lng) {

								for (var i = 0; i < val.diferents.length; i++) {

									let _val = val.diferents[i];

									let _fecha = moment(_val.DT_Incarico),
									_diff = hoy.diff(_fecha, 'days'),
									_color = "";

									if (_diff >= max) {

										if (_diff <= 20) {
							                _color = "verde";
							                verde.total++;
							                verde.diff+=_diff;
							            }else if (_diff > 20 && _diff <= 40) {
							                _color = "amarillo";
							                amarillo.total++;
							                amarillo.diff+=_diff;
							            }else if (_diff > 40 && _diff <= 60) {
							                _color = "rojo";
							                rojo.total++;
							                rojo.diff+=_diff;
							            }else if (_diff > 60) {
							                _color = "violeta";
							                violeta.total++;
							                violeta.diff+=_diff;
							            }

										addToButtons(_val,_color);

										try{
											eval(_color+"['non_fatto']++");
										}catch{
											console.log("catch",_color);
										}
										if (_diff) {
				            				non_fatto.diff += _diff;
				            			}
									}

								}
							}

						});

						$('#verde').text(verde.total); $('#verde-media').text(((verde.diff/verde.total) || 0).toFixed(2));
						$('#amarillo').text(amarillo.total); $('#amarillo-media').text(((amarillo.diff/amarillo.total) || 0).toFixed(2));
						$('#rojo').text(rojo.total); $('#rojo-media').text(((rojo.diff/rojo.total) || 0).toFixed(2));
						$('#violeta').text(violeta.total); $('#violeta-media').text(((violeta.diff/violeta.total) || 0).toFixed(2));

						$('#total-1').text((verde.total+amarillo.total+rojo.total+violeta.total).toString());
						$('#total-media-1').text((((verde.diff+amarillo.diff+rojo.diff+violeta.diff)/(verde.total+amarillo.total+rojo.total+violeta.total)).toFixed(2)).toString());

						/**/

						let nft = verde.non_fatto+amarillo.non_fatto+rojo.non_fatto+violeta.non_fatto;
						let ft = (verde.total-verde.non_fatto)+(amarillo.total-amarillo.non_fatto)+(rojo.total-rojo.non_fatto)+(violeta.total-violeta.non_fatto);

						console.log(verde.non_fatto,amarillo.non_fatto,rojo.non_fatto,violeta.non_fatto);
						console.log(verde.total,amarillo.total,rojo.total,violeta.total);

						$('#total-nf').text(nft);
						$('#total-media-nf').text((( (non_fatto.diff/nft) || 0 ).toFixed(2)).toString());

						$('#total-f').text(ft);
						$('#total-media-f').text((( (fatto.diff/ft) || 0 ).toFixed(2)).toString());

						/**/

						$('#verde-nf').text(verde.non_fatto); $('#verde-f').text(verde.total-verde.non_fatto);
						$('#amarillo-nf').text(amarillo.non_fatto); $('#amarillo-f').text(amarillo.total-amarillo.non_fatto);
						$('#rojo-nf').text(rojo.non_fatto); $('#rojo-f').text(rojo.total-rojo.non_fatto);
						$('#violeta-nf').text(violeta.non_fatto); $('#violeta-f').text(violeta.total-violeta.non_fatto);

						// $('.table').dataTable().fnDestroy();

						// $('#results').html(data[0]);

						// $('.table').dataTable()

					});
				});
			// }
		});

		$( ".select2-multiple" ).select2();

		// $('.table').dataTable();


	</script>

	<script>
		$('#peritoSelectAll').click(function(event) {
			let selected = [];
			$.each($('#perito option'), function(index, val) {
				if (val.value != 'none') {
					selected.push(val.value);
				}
			});
			// console.log(selected)
			$('#perito').val(selected).trigger('change');
			$('#peritoDeselectAll').removeClass('hidden');
			$('#peritoSelectAll').addClass('hidden');
		});
		$('#perito2SelectAll').click(function(event) {
			let selected = [];
			$.each($('#perito2 option'), function(index, val) {
				if (val.value != 'none') {
					selected.push(val.value);
				}
			});
			// console.log(selected)
			$('#perito2').val(selected).trigger('change');
			$('#perito2DeselectAll').removeClass('hidden');
			$('#perito2SelectAll').addClass('hidden');
		});
		$('#tpSelectAll').click(function(event) {
			let selected = [];
			$.each($('#tp option'), function(index, val) {
				selected.push(val.value);
			});
			// console.log(selected)
			$('#tp').val(selected).trigger('change');
			$('#tpDeselectAll').removeClass('hidden');
			$('#tpSelectAll').addClass('hidden');
		});

		$('#peritoDeselectAll').click(function(event) {
			$('#peritoDeselectAll').addClass('hidden');
			$('#peritoSelectAll').removeClass('hidden');
			$('#perito').val([]).trigger('change');
		});
		$('#perito2DeselectAll').click(function(event) {
			$('#perito2DeselectAll').addClass('hidden');
			$('#perito2SelectAll').removeClass('hidden');
			$('#perito2').val([]).trigger('change');
		});
		$('#tpDeselectAll').click(function(event) {
			$('#tpDeselectAll').addClass('hidden');
			$('#tpSelectAll').removeClass('hidden');
			$('#tp').val([]).trigger('change');
		});
	</script>

	{{-- <script
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsj-gbtqTAsxtWNbcqrRmE8ExatChS_Ko&callback=initMap">
	</script> --}}

	{{-- ////***//// --}}

	<script>
		$('#reload').dblclick(function(event) {
			$('#excel-table').modal('show');
		});

		function retrieveRestantes()
		{
			$.post('{{url('retrieveRestantes')}}', {_token: '{{csrf_token()}}',data_type:[1,2]}, function(data, textStatus, xhr) {
				$('.sin_latlng').text(data[0]);
				$('#past').text(data[1]);
			});
		}

		$('#del-filter').click(function(event) {
			$('[data-target="#filtros"]').trigger('click');

			$('#compagnia').val([]).change();
			$('#perito').val([]).change();
			$('#provincia').val([]).change();
			$('#stato').val([]).change();
			$('#tp').val([]).change();
			$('#max').val([]).change();


			initMap();
		});

		$('#reload_gm').click(function(event) {
			initMap();
		});
	</script>

	@include('admin.map-script-gestion')

	<script>

		function exportExcel(collection)
		{
			var ids = [];
			$.each(collection, function(index, val) {
				ids.push(val.id);
				// $.each(val.diferents, function(index, _val) {
				// });
			});
			$('#blockThis').block({message:"Esportazione della selezione..."});

			let formData = new FormData;
			formData.append('ids',ids);
			formData.append('_type','gestion');
			formData.append('_token','{{csrf_token()}}');

			$.ajax({
				url: '{{url('exportExcel')}}',
				type: 'POST',
				contentType: false,
				processData: false,
				data: formData,
			})
			.done(function(data) {
				$('#blockThis').unblock();
				$("body").append("<iframe src='" + data[0]+ "' style='display: none;' ></iframe>");
			});
			

			// $.post(, {_token: '{{csrf_token()}}',collection: ids,data_type:[1,2]}, function(data, textStatus, xhr) {
				
			// });
		}
		$('#exportVerde').click(function(event) {
			exportExcel(mVerde);
		});
		$('#exportAmarillo').click(function(event) {
			exportExcel(mAmarillo);
		});
		$('#exportRojo').click(function(event) {
			// console.log(mRojo);
			exportExcel(mRojo);
		});
		$('#exportVioleta').click(function(event) {
			exportExcel(mVioleta);
		});
		$('#exportMarron').click(function(event) {
			exportExcel(mMarron);
		});
		$('#exportAll').click(function(event) {
			exportExcel(mAll);
		});

		$('#openAllInfoWindow').click(function(event) {
			$('#closeAllInfoWindow').parent().removeClass('hide');
			$(this).parent().addClass('hide');
			$.each(infoWindows, function(index, val) {
				 val.infowindow.open(map,val.marker);
			});
		});

		$('#closeAllInfoWindow').click(function(event) {
			$('#openAllInfoWindow').parent().removeClass('hide');
			$(this).parent().addClass('hide');
			$.each(infoWindows, function(index, val) {
				 val.infowindow.close();
			});
		});

		initMap();
	</script>

@endsection
@stop