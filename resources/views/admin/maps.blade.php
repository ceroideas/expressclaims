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
	.loadModal, .loadManagementModal {
		margin-bottom: 8px;
		margin-right: 4px;
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
	.gm-style .gm-style-iw-c {
		padding: 6px !important;
		overflow: unset !important;
	}
	.content-alt h5 {
		margin-top: 5px !important;
		margin-right: 5px !important;
		margin-bottom: 5px !important;
	}
</style>

<div class="row" id="blockThis">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading"><span id="reload">Mappe sopralluogo</span>

				<label for="excel" class="btn btn-info btn-xs pull-right" >Import Excel</label>
				<input type="file" id="excel" style="position: absolute; left: -9999px;">

				<label style="background-color: #585bf3 !important; border-color: #585bf3; margin-right: 3px;" data-toggle="collapse" data-target="#filtros2" class="btn btn-info btn-xs pull-right" style="margin-right: 3px;">Pianifica percorso perito</label>

				<label data-toggle="collapse" data-target="#filtros" class="btn btn-info btn-xs pull-right" style="margin-right: 3px;">Filtro</label>


				<div id="filtros2" class="collapse" style="
				top: 38px;
				right: 16px;
				position: absolute; min-width: 350px; max-width: 350px; width: auto; padding: 16px; background: #fff; z-index: 9999; box-shadow: 0 0 2px rgba(51,51,51,.5); border-radius: 3px;">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label style="font-size: 12px;">Perito che fa il sopralluogo</label>

								<div class="input-group" id="peritoI2">
									<select id="perito2" class="form-control input-sm select2-multiple">
										@foreach (App\Expert::groupBy('name')->whereIn('society',['Z','R'])->get() as $pt)
											<option>{{$pt->name}}</option>
										@endforeach
									</select>
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
							{{-- <button type="button" style="position: relative; margin-top: 8px;" class="btn btn-block btn-success" id="filter2-excel"><i class="fa fa-file-excel"></i> Esporta Excel</button> --}}
						</div>
					</div>
				</div>

				<div id="filtros" class="collapse" style="
				top: 38px;
				right: 16px;
				position: absolute; min-width: 350px; max-width: 350px; width: auto; padding: 16px; background: #fff; z-index: 9999; box-shadow: 0 0 2px rgba(51,51,51,.5); border-radius: 3px;">
					<div class="row">
						<div class="col-sm-12 {{session('company') ? 'hidden' : ''}}" id="company-hidden">
							<div class="form-group">
								<label style="font-size: 12px;">Compagnia</label>
								<select id="compagnia" class="form-control input-sm select2-multiple" multiple></select>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
								<label style="font-size: 12px;">Perito che fa il sopralluogo</label>

								<div class="input-group" id="peritoI">
									<select id="perito" class="form-control input-sm select2-multiple" multiple>
										@foreach (App\Expert::groupBy('name')->whereIn('society',['Z','R'])->get() as $pt)
											<option>{{$pt->name}}</option>
										@endforeach
									</select>
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

								<label style="font-size: 12px; margin-top: 4px;">
									<input type="checkbox" id="only_fixed"> Only FIXED
								</label>
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

				<select class="form-control pull-right" style="max-width: 250px; display: inline-block; margin-right: 3px; top: -6px; position: relative;" id="global-company">
					<option value="" selected disabled>Compagnia - general filter</option>
				</select>

			</div>
			<div class="panel-body">

				<div class="row">
					<div class="col-sm-9">

						<div class="row">
							<div class="col-md-4">
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Cerca per riferimento interno" id="specific-id">
									<span class="input-group-btn">
										<button class="btn btn-success" id="find-specific">Cerca</button>
									</span>
								</div>
							</div>
						</div>

						<div id="map-locations">
						</div>

						{{-- @if (Auth::user()->role_id == -1) --}}
						@if (Auth::user())
							<div style="margin-top: 8px; text-align: center;">							

								<label class="btn btn-sm btn-success">Allinea periti Zappa 
									<input type="file" id="per-zappa" data-society="Z" style="position: absolute; left: -9999px;">
								</label>

								<label class="btn btn-sm btn-info">Allinea periti Renova 
									<input type="file" id="per-renova" data-society="R" style="position: absolute; left: -9999px;">
								</label>

								<label class="btn btn-sm btn-success">Allinea Stati 
									<input type="file" id="stati" style="position: absolute; left: -9999px;">
								</label>

							</div>
						@endif
					</div>
					<div class="col-sm-3">

						@if (App\MapInformation::where('type',1)->first())
							<br>
							<b>Data e nome dell'ultimo file caricato: </b> 
							<span id="date-excel">
								{!!App\ExcelFile::orderBy('id','desc')->first() ? '<a href='.url('uploads/excel',App\ExcelFile::orderBy('id','desc')->first()->name).'>'.App\ExcelFile::orderBy('id','desc')->first()->name.'</a> | '.App\ExcelFile::orderBy('id','desc')->first()->created_at->format('d-m-Y H:i:s') : ''!!}
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
										Fissati: <span id="total-f">0</span> <br>
										Giorni medi: <span id="total-media-f">0</span>
									</div>
									<div class="col-sm-6">
										NON fissati: <span id="total-nf">0</span> <br>
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
									</div>
								</div>
							</div>
							<div class="col-sm-12 hidden marron-div" style="margin-bottom: 10px">
								<div class="form-group" style="position: relative;">
									
									<div class="dropdown" style="position: absolute; right: 0; top: 0;">
									  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="padding: 0 10px; border: none; background-color: transparent;">
									  <span class="caret"></span></button>
									  <ul class="dropdown-menu" style="right: -1px; left: unset;">
									    <li><a href="javascript:;" id="exportMarron">Esporta Excel</a></li>
									  </ul>
									</div>

									<div class="btn btn-warning btn-lg btn-block" id="loadMarron" style="padding: 14px; font-size: 12px; background-color: #4a46ff; border-color: #0500ff">
										Perito: <span id="marron">0</span>
										<br>
										Giorni medi: <span id="marron-media">0</span>
									</div>
								</div>

								<div class="form-group" style="position: relative;">
									
									<div class="dropdown" style="position: absolute; right: 0; top: 0;">
									  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="padding: 0 10px; border: none; background-color: transparent;">
									  <span class="caret"></span></button>
									  <ul class="dropdown-menu" style="right: -1px; left: unset;">
									    <li><a href="javascript:;" id="exportBlanco">Esporta Excel</a></li>
									  </ul>
									</div>

									<div class="btn btn-warning btn-lg btn-block" id="loadBlanco" style="padding: 14px; font-size: 12px;  border: 2px solid #000; background-color: transparent; color: #000 !important;">
										Mostra Incarichi Assegnati (e non sopralluogati)
									</div>
								</div>

								<div class="row">
									<div class="col-sm-6">
										<button class=" btn" style="width: 100%; white-space: normal; color: #000 !important; border: 2px solid #000; background-color: transparent;"><a style="color:#000 !important" href="javascript:;" id="openAllInfoWindow">Visualizza rif. e ora fissati</a></button>

										<button class="hide btn" style="width: 100%; white-space: normal; color: #000 !important; border: 2px solid #000; background-color: transparent;"><a style="color:#000 !important" href="javascript:;" id="closeAllInfoWindow">Nascondi rif. e ora fissati</a></button>	
									</div>
									<div class="col-sm-6">
										<button class=" btn" style="width: 100%; white-space: normal; color: #000 !important; border: 2px solid #000; background-color: transparent;"><a style="color:#000 !important" href="javascript:;" id="openAllInfoWindow2">Visualizza rif. NON fissati</a></button>
										
										<button class="hide btn" style="width: 100%; white-space: normal; color: #000 !important; border: 2px solid #000; background-color: transparent;"><a style="color:#000 !important" href="javascript:;" id="closeAllInfoWindow2">Nascondi rif. NON fissati</a></button>	
									</div>
								</div>
							</div>

							<div class="col-sm-12">
								<div class="form-group" style="position: relative;">

									<div class="btn btn-warning btn-lg btn-block" data-toggle="modal" data-target="#excel-table" style="padding: 14px; font-size: 12px; background-color: #c8c8c8; border-color: #4b4b4b">
										<span>Tabella</span>
									</div>
								</div>
							</div>

							<div class="col-sm-12">
								<hr>

								@php
									$t_s = App\MapInformation::where('status',1)->whereIn('type',[1])->where(function($q){
							            $q->where(['lat'=>'','lng'=>''])
							              ->orWhere(['lat'=>null,'lng'=>null]);
							        })->count();
								@endphp

								Per <span class="sin_latlng">{{$t_s}}</span> sinistri la API non ha fornito la posizione. <a href="#" data-type="without" class="exportExcludes">Esporta</a><br> <br>

								<button class="btn btn-xs btn-primary btn-block" id="check_gm">Richiedi posizione <span class="sin_latlng">{{$t_s}}</span> sinistri mancanti</button> <br>
								<button style="display: block; margin-top: 8px;" class="btn btn-xs btn-warning btn-block" id="reload_gm">Reload Map</button>

								<hr>

								@php
									$past = App\MapInformation::where('status',1)->where('DATA_SOPRALLUOGO','<',Carbon\Carbon::today())->where('DATA_SOPRALLUOGO','!=','')->where('type',1)->count();
								@endphp

								Nel file caricato erano presenti <span id="past">{{$past}}</span> sinistri con sopralluogo già effettuato che non vengono mostrati nella mappa. <a href="#" data-type="past" class="exportExcludes">Esporta</a>
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

<div class="modal fade" id="excel-table">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				Map Table
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="table-responsive">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th></th>
										<th></th>

										@php
											$day7 = Carbon\Carbon::today()->subDays(30);
										@endphp
										@while ($day7 <= Carbon\Carbon::today())
											@php
												$ef = App\ExcelFile::where('created_at','>=',$day7)->where('created_at','<',$day7->copy()->addDay())->get()->last();
											@endphp
											@if ($ef)
												<th>{{ $ef->created_at->format('d-m-Y') }}</th>
											@endif
											@php
												$day7->addDay();
											@endphp
										@endwhile
									</tr>
								</thead>

								<tbody>
									<tr>
										<td style="background-color: #58c9f3; color: #000">TUTTI</td>
										<td rowspan="6" style="vertical-align: middle; text-align: center;">num.</td>
										@php
											$day7 = Carbon\Carbon::today()->subDays(30);
										@endphp
										@while ($day7 <= Carbon\Carbon::today())
											@php
												$ef = App\ExcelFile::where('created_at','>=',$day7)->where('created_at','<',$day7->copy()->addDay())->get()->last();
											@endphp
											@if ($ef)
												<td style="background-color: #58c9f3; color: #000">{{ $ef->all }}</td>
											@endif
											@php
												$day7->addDay();
											@endphp
										@endwhile
									</tr>
									<tr>
										<td style="background-color: #58c9f377; color: #000">Non Fissati</td>

										@php
											$day7 = Carbon\Carbon::today()->subDays(30);
										@endphp
										@while ($day7 <= Carbon\Carbon::today())
											@php
												$ef = App\ExcelFile::where('created_at','>=',$day7)->where('created_at','<',$day7->copy()->addDay())->get()->last();
											@endphp
											@if ($ef)
												<td style="background-color: #58c9f377; color: #000">{{ $ef->nonf }}</td>
											@endif
											@php
												$day7->addDay();
											@endphp
										@endwhile
									</tr>

									<tr>
										<td style="background-color: #78CD51; color: #000"><20</td>
										{{-- /**/ --}}
										@php
											$day7 = Carbon\Carbon::today()->subDays(30);
										@endphp
										@while ($day7 <= Carbon\Carbon::today())
											@php
												$ef = App\ExcelFile::where('created_at','>=',$day7)->where('created_at','<',$day7->copy()->addDay())->get()->last();
											@endphp
											@if ($ef)
												<td style="background-color: #78CD51; color: #000">{{ $ef->l20 }}</td>
											@endif
											@php
												$day7->addDay();
											@endphp
										@endwhile
									</tr>

									<tr>
										<td style="background-color: #e4ba00; color: #000"><40</td>
										{{-- /**/ --}}
										@php
											$day7 = Carbon\Carbon::today()->subDays(30);
										@endphp
										@while ($day7 <= Carbon\Carbon::today())
											@php
												$ef = App\ExcelFile::where('created_at','>=',$day7)->where('created_at','<',$day7->copy()->addDay())->get()->last();
											@endphp
											@if ($ef)
												<td style="background-color: #e4ba00; color: #000">{{ $ef->l40 }}</td>
											@endif
											@php
												$day7->addDay();
											@endphp
										@endwhile
									</tr>

									<tr>
										<td style="background-color: #ff6c60; color: #000"><60</td>
										{{-- /**/ --}}
										@php
											$day7 = Carbon\Carbon::today()->subDays(30);
										@endphp
										@while ($day7 <= Carbon\Carbon::today())
											@php
												$ef = App\ExcelFile::where('created_at','>=',$day7)->where('created_at','<',$day7->copy()->addDay())->get()->last();
											@endphp
											@if ($ef)
												<td style="background-color: #ff6c60; color: #000">{{ $ef->l60 }}</td>
											@endif
											@php
												$day7->addDay();
											@endphp
										@endwhile
									</tr>

									<tr>
										<td style="background-color: blueviolet; color: #000">>60</td>
										{{-- /**/ --}}
										@php
											$day7 = Carbon\Carbon::today()->subDays(30);
										@endphp
										@while ($day7 <= Carbon\Carbon::today())
											@php
												$ef = App\ExcelFile::where('created_at','>=',$day7)->where('created_at','<',$day7->copy()->addDay())->get()->last();
											@endphp
											@if ($ef)
												<td style="background-color: blueviolet; color: #000">{{ $ef->p60 }}</td>
											@endif
											@php
												$day7->addDay();
											@endphp
										@endwhile
									</tr>

									<tr>
										<td></td>
									</tr>

									<tr>
										<td style="background-color: #58c9f3; color: #000">TUTTI</td>
										<td rowspan="5" style="vertical-align: middle; text-align: center;">gg. <br> medi</td>
										@php
											$day7 = Carbon\Carbon::today()->subDays(30);
										@endphp
										@while ($day7 <= Carbon\Carbon::today())
											@php
												$ef = App\ExcelFile::where('created_at','>=',$day7)->where('created_at','<',$day7->copy()->addDay())->get()->last();
											@endphp
											@if ($ef)
												<td style="background-color: #58c9f3; color: #000">{{ $ef->mall }}</td>
											@endif
											@php
												$day7->addDay();
											@endphp
										@endwhile
									</tr>

									<tr>
										<td style="background-color: #78CD51; color: #000"><20</td>
										{{-- /**/ --}}
										@php
											$day7 = Carbon\Carbon::today()->subDays(30);
										@endphp
										@while ($day7 <= Carbon\Carbon::today())
											@php
												$ef = App\ExcelFile::where('created_at','>=',$day7)->where('created_at','<',$day7->copy()->addDay())->get()->last();
											@endphp
											@if ($ef)
												<td style="background-color: #78CD51; color: #000">{{ $ef->ml20 }}</td>
											@endif
											@php
												$day7->addDay();
											@endphp
										@endwhile
									</tr>

									<tr>
										<td style="background-color: #e4ba00; color: #000"><40</td>
										{{-- /**/ --}}
										@php
											$day7 = Carbon\Carbon::today()->subDays(30);
										@endphp
										@while ($day7 <= Carbon\Carbon::today())
											@php
												$ef = App\ExcelFile::where('created_at','>=',$day7)->where('created_at','<',$day7->copy()->addDay())->get()->last();
											@endphp
											@if ($ef)
												<td style="background-color: #e4ba00; color: #000">{{ $ef->ml40 }}</td>
											@endif
											@php
												$day7->addDay();
											@endphp
										@endwhile
									</tr>

									<tr>
										<td style="background-color: #ff6c60; color: #000"><60</td>
										{{-- /**/ --}}
										@php
											$day7 = Carbon\Carbon::today()->subDays(30);
										@endphp
										@while ($day7 <= Carbon\Carbon::today())
											@php
												$ef = App\ExcelFile::where('created_at','>=',$day7)->where('created_at','<',$day7->copy()->addDay())->get()->last();
											@endphp
											@if ($ef)
												<td style="background-color: #ff6c60; color: #000">{{ $ef->ml60 }}</td>
											@endif
											@php
												$day7->addDay();
											@endphp
										@endwhile
									</tr>

									<tr>
										<td style="background-color: blueviolet; color: #000">>60</td>
										{{-- /**/ --}}
										@php
											$day7 = Carbon\Carbon::today()->subDays(30);
										@endphp
										@while ($day7 <= Carbon\Carbon::today())
											@php
												$ef = App\ExcelFile::where('created_at','>=',$day7)->where('created_at','<',$day7->copy()->addDay())->get()->last();
											@endphp
											@if ($ef)
												<td style="background-color: blueviolet; color: #000">{{ $ef->mp60 }}</td>
											@endif
											@php
												$day7->addDay();
											@endphp
										@endwhile
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					@php
						$ef = App\ExcelFile::get()->last();
					@endphp
					<div class="col-sm-12">
						{{-- <div class="form-group" style="position: relative;">

							<div class="btn btn-info btn-lg btn-block" style="padding: 14px; font-size: 12px">
								TUTTI: <span >{{$ef->all}}</span>
								<br>
								Giorni medi: <span >{{$ef->mall}}</span>

								<div class="row">
									<div class="col-sm-6">
										Fissati: <span >{{$ef->fiss}}</span> <br>
										Giorni medi: <span >{{$ef->gmfs}}</span>
									</div>
									<div class="col-sm-6">
										NON fissati: <span >{{$ef->nonf}}</span> <br>
										Giorni medi: <span >{{$ef->gmnf}}</span>
									</div>
								</div>
							</div>
						</div> --}}

						<div class="row">
							{{-- <div class="col-sm-12">
								<div class="form-group" style="position: relative;">
									<div class="btn btn-success btn-lg btn-block" style="padding: 14px; font-size: 12px; background-color: #6dbb4a;">

										< 20 gg.: <span >{{$ef->l20}}</span>
										<br>
										Giorni medi: <span >{{$ef->ml20}}</span>
									</div>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group" style="position: relative;">
									

									<div class="btn btn-warning btn-lg btn-block" style="padding: 14px; font-size: 12px; background-color: #e4ba00;">
										< 40 gg.: <span >{{$ef->l40}}</span>
										<br>
										Giorni medi: <span >{{$ef->ml40}}</span>
									</div>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group" style="position: relative;">

									<div class="btn btn-danger btn-lg btn-block" style="padding: 14px; font-size: 12px; background-color: #ff6c60;">
										< 60 gg.: <span >{{$ef->l60}}</span>
										<br>
										Giorni medi: <span >{{$ef->ml60}}</span>
									</div>
								</div>
							</div>
							<div class="col-sm-12">
								<div class="form-group" style="position: relative;">

									<div class="btn btn-info btn-lg btn-block" style="padding: 14px; font-size: 12px; background-color: blueviolet; border-color: #4a24a6">
										> 60 gg.: <span >{{$ef->p60}}</span>
										<br>
										Giorni medi: <span >{{$ef->mp60}}</span>
									</div>
								</div>
							</div> --}}

							<div class="col-sm-12">
								<div class="" style="position: relative; text-align: center; margin-top: 10px">

									<a href="{{url('exportTable')}}" class="btn btn-warning btn-lg" style="padding: 14px; font-size: 12px; background-color: #c8c8c8; border-color: #4b4b4b; width: 270px">
										<span>Esporta</span>
									</a>
								</div>
							</div>

							{{-- <a href="{{url('exportTable')}}" style="display: block; width: 100%; text-align: center;">Esporta</a> --}}
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-xs btn-danger">Chiudi</button>
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

<div class="modal fade" id="data-modal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				Informazione <span id="information-data-modal"></span>
			</div>
			<div class="modal-body" id="data-data">
			</div>
			{{-- <div class="modal-footer">
				<button type="button" id="submit-data" class="btn btn-xs btn-success">Salva</button>
				<button data-dismiss="modal" class="btn btn-xs btn-danger">Chiudi</button>
			</div> --}}
		</div>
	</div>
</div>
@section('scripts')
	

	<script>

		// function mysubmitF(event)
		// {
		// 	console.log('not send')
		// 	event.preventDefault();
		// }

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
		var infoWindows2 = [];
		var map;

		var allStatus = [];

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

			$.post('{{url('multiple-modal')}}', {_token:'{{csrf_token()}}',N_Sinistro:N_Sinistro,compagnia:$('#compagnia').val(),perito:$('#perito').val(),provincia:$('#provincia').val(),stato:$('#stato').val(),tp:$('#tp').val()},function(data, textStatus, xhr) {
				// console.log(data);

				$('#multiple-data').html(data);
			});
		}

		function loadManagementModal(i) {

			$('#multiple-modal').modal('hide');


			$('#data-data').html("<img src=\"{{url('ajax-loader.gif')}}\" style=\"display: block; margin: auto; width: 100px;\">");
			$('#information-data-modal').text("");
			$('#data-modal').modal('show');

			$.get('{{url('data-modal')}}/'+i, function(data, textStatus, xhr) {
				// console.log(data);

				$('#data-data').html(data[0]);
				$('#information-data-modal').text(data[1]);
			});
		}

		localStorage.setItem('close','1');

		function modalChanged() {
			localStorage.removeItem('close');
		}

		// $('#submit-data').click(function(event) {
		function sendAllData(event) {
			event.preventDefault();
			console.log($('#saveAllData').serializeArray());

			$('#modal-data-loader').css('display', 'block');
			$.post('{{url('saveModalData')}}', $('#saveAllData').serializeArray(), function(data, textStatus, xhr) {
				$('#modal-data-loader').hide();

				$.each(data, function(index, val) {


					let type;
					let text;
					
					if (val.error) {
						type = 'error';
						text = val.error;
					}else{
						type = 'success';
						text = val.operation+' | '+val.result;
						localStorage.setItem('close','1');
						$('#data-modal').modal('hide');
					}

					return (PNotify[type]({
			          title: "Operazione "+type,
			          text: text,
			          type: type,
			          desktop: {
			              desktop: false
			          }
			        }));

				});
			});
		}

		function loadButtons(data)
		{
				infoWindows = [];

				$('#openAllInfoWindow').parent().removeClass('hide');
				$('#closeAllInfoWindow').parent().addClass('hide');

				$('#openAllInfoWindow2').parent().removeClass('hide');
				$('#closeAllInfoWindow2').parent().addClass('hide');

				map = new google.maps.Map(document.getElementById('map-locations'), {
			      zoom: 8,
			      center: {lat:45.4628328,lng:9.1076928},
			      // mapTypeControl: false,
				  streetViewControl: false,
				  rotateControl: false,
		          mapTypeId: 'roadmap'
			    });
			    // var marker = new google.maps.Marker({
			    //   position: pos,
			    //   map: map
			    // });

			    let hoy = moment().tz("Europe/Rome");

			    $.each(data, function(index, v) {

			    	var sinisters = [];
							
					if (!v.diferents) {
						sinisters = [v];
					}else{
						sinisters = v.diferents.sort((a,b)=>{if(a.DATA_SOPRALLUOGO > b.DATA_SOPRALLUOGO){return -1}else{return 1}return 0});
						sinisters = sinisters.filter(x=>moment(x.DATA_SOPRALLUOGO) >= moment().startOf('day') || x.DATA_SOPRALLUOGO == "");
					}

					var val = sinisters[0] || [];
					val.diferents = sinisters;

					address = encodeURI(val.CAP+' '+val.INDIRIZZO+', '+val.COMUNE+', '+val.PROVINCIA);
					// console.log(address)

					var fecha = moment(val.DT_Incarico),
					diff = hoy.diff(fecha, 'days'),
					color = "violeta",
					icon = "",
					addn = "";

		            if (val.TP == 'AC' || val.TP == 'RG') { icon = 'ac'; }
					else if (val.TP == 'AT') { icon = 'at'; }
					else if (val.TP == 'EA') { icon = 'ea'; }
					else if (val.TP == 'FE') { icon = 'fe'; }
					else if (val.TP == 'EL') { icon = 'el'; }
					else if (val.TP == 'AL' || val.TP == 'VA' || val.TP == 'altre') { icon = 'altre'; }
					else if (val.TP == 'IN') { icon = 'in'; }
					else if (val.TP == 'RE') { icon = 're'; }
					else if (val.TP == 'CR') { icon = 'cr'; }
					else if (val.TP == 'AR') { icon = 'ar'; }
					else if (val.TP == 'FU' || val.TP == 'AM' || val.TP == 'RA') { icon = 'fu'; }
					else if (val.TP == 'RC' || val.TP == 'RU' || val.TP == 'RP') { icon = 'rc'; }
					else if (val.TP == 'NN') { icon = 'nn'; }
					else {icon = "altre";}

		            if (!val.TELEFONO && !val.CELLULARE && !val.EMAIL) {
		            	addn = '-sin';
		            }

		            let continuar = true;

		            if(val.DATA_SOPRALLUOGO && val.DATA_SOPRALLUOGO != ""){

		            	// fissato.total++;
		            	// fissato.diff += diff;

			            if(moment(val.DATA_SOPRALLUOGO) >= moment.tz("Europe/Rome").startOf('day'))
			            {
			            	continuar = true;
			            	addn+='-transparente';
			            }else{
			            	// data[1].splice(index,1);
			            	continuar = false;
			            }
		            }else{
		            	// non_fissato.total++;
		            	// non_fissato.diff += diff;
		            }

		            if (continuar && val.latlng && val.Stato != '030FATTO') {

		            	if (val.SOPRALLUOGO == $('#perito2').val()) {
			            	color = "marron";
			            	// marron.total+=/*val.sinisters*/sinisters.length;
				            // marron.diff+=diff;
			            }else{
			            	if (diff <= 20) {
				                color = "verde";
				                // verde.total+=val.sinisters;
				                // verde.diff+=diff;
				            }else if (diff > 20 && diff <= 40) {
				                color = "amarillo";
				                // amarillo.total+=val.sinisters;
				                // amarillo.diff+=diff;
				            }else if (diff > 40 && diff <= 60) {
				                color = "rojo";
				                // rojo.total+=val.sinisters;
				                // rojo.diff+=diff;
				            }else if (diff > 60) {
				                color = "violeta";
				                // violeta.total+=val.sinisters;
				                // violeta.diff+=diff;
				            }
			            }

						let l = {lat: val.lat,lng: val.lng};

						var contentString = "<div id='all-content-"+val.id+"'></div>";

						for (var i = 0; i < val.diferents.length; i++) {

							let _val = val.diferents[i];

							let _tp;

							if (_val.TP == 'AC' || _val.TP == 'RG') {_tp = "Acqua condotta";}
							if (_val.TP == 'AT') {_tp = "Atti Vandalici";}
							if (_val.TP == 'EA') {_tp = "Evento Atmosferico";}
							if (_val.TP == 'FE') {_tp = "Fenomeno Elettrico";}
							if (_val.TP == 'EL') {_tp = "Elettronica";}
							if (_val.TP == 'AL' || _val.TP == 'VA' || _val.TP == 'altre') {_tp = "Pluralità di garanzie";}
							if (_val.TP == 'IN') {_tp = "Incendio";}
							if (_val.TP == 'RE') {_tp = "RC Auto";}
							if (_val.TP == 'CR') {_tp = "Cristalli";}
							if (_val.TP == 'AR') {_tp = "Accertamenti";}
							if (_val.TP == 'FU' || _val.TP == 'AM' || _val.TP == 'RA') {_tp = "Furto";}
							if (_val.TP == 'RC' || _val.TP == 'RU' || _val.TP == 'RP') {_tp = "Responsabilità Civile";}
							if (_val.TP == 'NN') {_tp = "Non indennizzabile";}

							if (color == 'marron') {

								contentString += '<div id="content">'+
								"<h5 onclick='loadModal("+_val.id+")' style='margin-bottom: 0' id='firstHeading' class='firstHeading'>"+_val.N_P
								+(_val.DATA_SOPRALLUOGO ? ' - <span style="display: inline-block;font-weight: 700">'+moment(_val.DATA_SOPRALLUOGO).format('HH:mm')+'</span>' : '')+'</h5>\
								</div>';
								
							}else{
								
								// contentString += '<div id="content">'+
							 //      '<div class="siteNotice">'+
							 //      '</div>'+
							 //      '<h5 style="margin-bottom: 0" id="firstHeading" class="firstHeading">'+_val.N_P+' - '+_val.Assicurato+' '+_val.TP+'-'+_tp+'</h5>'+
							 //      '<h5 style="margin-top: 3px; margin-bottom: 0" id="firstHeading"> COMPAGNIA: '+_val.COMPAGNIA+'</h5>'+
							 //      '<h6 style="margin-top: 5px" id="firstHeading"> Stato: '+_val.Stato+(_val.DATA_SOPRALLUOGO ? ' <small style="font-size: 12px; display: inline-block; margin-left: 16px;font-weight: 700">Il: '+moment(_val.DATA_SOPRALLUOGO).format('DD-MM-YYYY HH:mm')+'</small>' : '')+'</h6>'+
							 //      '<div id="bodyContent">'+
							 //      '<p>\
							 //      Indirizzo: '+(_val.CAP+' '+_val.INDIRIZZO+', '+_val.COMUNE+', '+_val.PROVINCIA)+'<br>\
							 //      Cellulare: '+(_val.CELLULARE == null ? '---' : _val.CELLULARE)+'<br>\
							 //      Telefono: '+(_val.TELEFONO == null ? '---' : _val.TELEFONO)+'<br>\
							 //      Email: '+(_val.EMAIL == null ? '---' : _val.EMAIL)+'<br>\
							 //      Data Incarico: '+(_val.DT_Incarico == null ? '---' : moment(_val.DT_Incarico).format('DD-MM-YYYY HH:mm')+' gg. '+moment().diff(moment(_val.DT_Incarico),'days'))+'<br>\
							 //      Data Assegnata: '+(_val.DT_ASSEGNATA == null ? '---' : moment(_val.DT_ASSEGNATA).format('DD-MM-YYYY HH:mm')+' gg. '+moment().diff(moment(_val.DT_ASSEGNATA),'days'))+'<br>\
							 //      Accertatore: '+(_val.SOPRALLUOGO == null ? '---' : _val.SOPRALLUOGO)+'<br>\
							 //      </p>'+
							 //      (_val.total > 1 ? "<button onclick='loadModal("+_val.id+")' class='loadModal btn btn-info btn-xs'>Vedi tutti i danneggiati ("+_val.total+")</button>" : '')+
							 //      @if (Auth::user()->role_id == -1)
								//       '<button onclick="loadManagementModal('+_val.id+')" class="loadManagementModal btn btn-success btn-xs" type="button">Management</button>'+
							 //      @endif
								//       '</div>'+
							 //      '</div>';
							}

						}


						  var infowindow = new google.maps.InfoWindow({
						    content: contentString
						  });

						  let _color = "";

						  if (color == 'amarillo') {_color='#333333';}else{_color='#ffffff'}

						var marker = new google.maps.Marker({
					      position: {lat: parseFloat(l.lat), lng: parseFloat(l.lng)},
					      map: map,
					      icon: {url: '{{url('markers')}}/'+color+'-'+icon+addn+'.png', scaledSize: new google.maps.Size(80, 80)},
					      label: {text: /*val.*/val.diferents.length.toString(),color: _color,fontSize: '12px',fontWeight: 'bolder'}
					    });

					    if (!$('.marron-div').hasClass('hidden')) {
						    if (color == 'marron') {infoWindows.push({marker:marker,infowindow:infowindow});}
							else {infoWindows2.push({marker:marker,infowindow:infowindow});}
					    }

					    marker.addListener('click', function() {
						  infowindow.open(map, marker);
						  setTimeout(()=>{
						  	$.get('{{url('findMapInformation')}}/'+val.id, function(data) {
						  		console.log(data);
						  		if (color != 'marron') {
						  			getInfoWindowInformation(data);
						  		}
						  	});
						  },200)
						});
		            }


				});
			
		}

		$("#loadAll").click(function(event) {
			loadButtons(mAll);
		});
		$("#loadVerde").click(function(event) {
			loadButtons(mVerde);
		});
		$("#loadAmarillo").click(function(event) {
			loadButtons(mAmarillo);
		});
		$("#loadRojo").click(function(event) {
			loadButtons(mRojo);
		});
		$("#loadVioleta").click(function(event) {
			loadButtons(mVioleta);
		});
		$("#loadMarron").click(function(event) {
			loadButtons(mMarron);
		});

		function getInfoWindowInformation(data)
		{		            
			let val = data;
			let contentString = "";
			let hoy = moment().tz('Europe/Rome');
			if (!val.diferents.length) {
				val.diferents = [val];
			}
			for (var i = 0; i < val.diferents.length; i++) {

				let _val = val.diferents[i];

				let _tp;

				if (_val.TP == 'AC' || _val.TP == 'RG') {_tp = "Acqua condotta";}
				if (_val.TP == 'AT') {_tp = "Atti Vandalici";}
				if (_val.TP == 'EA') {_tp = "Evento Atmosferico";}
				if (_val.TP == 'FE') {_tp = "Fenomeno Elettrico";}
				if (_val.TP == 'EL') {_tp = "Elettronica";}
				if (_val.TP == 'AL' || _val.TP == 'VA' || _val.TP == 'altre') {_tp = "Pluralità di garanzie";}
				if (_val.TP == 'IN') {_tp = "Incendio";}
				if (_val.TP == 'RE') {_tp = "RC Auto";}
				if (_val.TP == 'CR') {_tp = "Cristalli";}
				if (_val.TP == 'AR') {_tp = "Accertamenti";}
				if (_val.TP == 'FU' || _val.TP == 'AM' || _val.TP == 'RA') {_tp = "Furto";}
				if (_val.TP == 'RC' || _val.TP == 'RU' || _val.TP == 'RP') {_tp = "Responsabilità Civile";}
				if (_val.TP == 'NN') {_tp = "Non indennizzabile";}
				
				contentString += '<div id="content">'+
			      '<div class="siteNotice">'+
			      '</div>'+
			      '<h5 style="margin-bottom: 0" id="firstHeading" class="firstHeading">'+_val.N_P+' - '+_val.Assicurato+' '+_val.TP+'-'+_tp+'</h5>'+
			      '<h5 style="margin-top: 3px; margin-bottom: 0" id="firstHeading"> COMPAGNIA: '+_val.COMPAGNIA+'</h5>'+
			      '<h6 style="margin-top: 5px" id="firstHeading"> Stato: '+_val.Stato+(_val.DATA_SOPRALLUOGO ? ' <small style="font-size: 12px; display: inline-block; margin-left: 16px;font-weight: 700">Il: '+moment(_val.DATA_SOPRALLUOGO).format('DD-MM-YYYY HH:mm')+'</small>' : '')+'</h6>'+
			      '<div id="bodyContent">'+
			      '<p>\
			      Indirizzo: '+(_val.CAP+' '+_val.INDIRIZZO+', '+_val.COMUNE+', '+_val.PROVINCIA)+'<br>\
			      Cellulare: '+(_val.CELLULARE == null ? '---' : _val.CELLULARE)+'<br>\
			      Telefono: '+(_val.TELEFONO == null ? '---' : _val.TELEFONO)+'<br>\
			      Email: '+(_val.EMAIL == null ? '---' : _val.EMAIL)+'<br>\
			      Data Incarico: '+(_val.DT_Incarico == null ? '---' : moment(_val.DT_Incarico).format('DD-MM-YYYY HH:mm')+' gg. '+moment().diff(moment(_val.DT_Incarico),'days'))+'<br>\
			      Data Assegnata: '+(_val.DT_ASSEGNATA == null ? '---' : moment(_val.DT_ASSEGNATA).format('DD-MM-YYYY HH:mm')+' gg. '+moment().diff(moment(_val.DT_ASSEGNATA),'days'))+'<br>\
			      Accertatore: '+(_val.SOPRALLUOGO == null ? '---' : _val.SOPRALLUOGO)+'<br>\
			      </p>'+
			      (_val.total > 1 ? "<button onclick='loadModal("+_val.id+")' class='loadModal btn btn-info btn-xs'>Vedi tutti i danneggiati ("+_val.total+")</button>" : '')+
			      @if (Auth::user())
			        '<button onclick="loadManagementModal('+_val.id+')" class="loadManagementModal btn btn-success btn-xs" type="button">Management</button>'+
	      		  @endif
			        '</div>'+
			      '</div>';
			}
			// console.log("contentString",contentString);

			$('#all-content-'+val.id).html(contentString);
		}

		___total = 0;

		function initMap(getLocations = "no") {

			infoWindows = [];

			$('#filtro-perito').text("");

			$('.marron-div').addClass('hidden');

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

			localStorage.setItem("getLocations",getLocations == 'si' ? 'true' : 'false');

			if (getLocations == 'si') {
				$('#blockThis').block({ message: "Stiamo caricando le posizioni sulla mappa. Per i sinistri non ancora presenti nel database è in corso la ricerca della posizione con Google Maps." })
			}else{
				$('#blockThis').block({ message: "Stiamo caricando le posizioni sulla mappa." })
			}

			    map = new google.maps.Map(document.getElementById('map-locations'), {
			      zoom: 8,
			      center: {lat:45.4628328,lng:9.1076928},
			      // mapTypeControl: false,
				  streetViewControl: false,
				  rotateControl: false,
		          mapTypeId: 'roadmap'
			    });
			    // var marker = new google.maps.Marker({
			    //   position: pos,
			    //   map: map
			    // });

				let address;
				let url;
				let fecha
				let diff
				let color
				let icon

				let verde = {total:0,diff:0};
				let amarillo = {total:0,diff:0};
				let rojo = {total:0,diff:0};
				let violeta = {total:0,diff:0};

				let fissato = {total:0,diff:0};
				let non_fissato = {total:0,diff:0};

				mAll = [];
				mVerde = [];
				mAmarillo = [];
				mRojo = [];
				mVioleta = [];

				/**/

				let hoy = moment().tz('Europe/Rome');

				setTimeout(()=>{

					$.post('{{url('getMapInformation')}}', {_token: '{{csrf_token()}}',ignore:getLocations,data_type:[1]}, function(data, textStatus, xhr) {

						let total = data[1].length;

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

			            function fgetLocations(url,val)
						{
							$.post(url, [], function(data, textStatus, xhr) {
								if (data.status != "ZERO_RESULTS" && data.status != "OVER_QUERY_LIMIT" && data.status != "REQUEST_DENIED") {

									if (data.results[0]) {
										let l = data.results[0].geometry.location;

										if (val.id) {
											$.post('{{'saveLatLng'}}/'+val.id, {_token: '{{csrf_token()}}', lat: l.lat, lng: l.lng}, function(data, textStatus, xhr) {
												console.log('saved excel');
											});
										}
									}
								}else{

									var message = "";
									if (data.status == "ZERO_RESULTS") {
										message = "Per il sinistro "+val.N_P+" l'API non è stata in grado di fornire la posizione";
										console.log(message);
									}else{
										message = "OVER_QUERY_LIMIT, devi attendere per effettuare nuovamente le richieste all'API...";
										console.log(message);
								        setTimeout(()=>{
								        	retrieveRestantes();
								        },2000);
								        $('#blockThis').unblock();
								        initMap();
								        return false;
									}
								}
							});
						}

						let getLocations = localStorage.getItem('getLocations');

						if (getLocations == 'false') {$('#blockThis').unblock();}else{
							$('#date-excel').text(data[0].name+" | "+moment(data[0].created_at).format('DD-MM-YYYY HH:mm'))+" | <span data-toggle=\"modal\" data-target=\"#excel-table\" style=\"cursor: pointer;\">Tabella</span>";
						}

						$.each(data[1], function(index, v) {

							var sinisters = [];
							
							if (!v.diferents) {
								sinisters = [v];
							}else{
								sinisters = v.diferents.sort((a,b)=>{if(a.DATA_SOPRALLUOGO > b.DATA_SOPRALLUOGO){return -1}else{return 1}return 0});
								sinisters = sinisters.filter(x=>moment(x.DATA_SOPRALLUOGO) >= moment().startOf('day') || x.DATA_SOPRALLUOGO == "");
							}

							var val = sinisters[0] || [];
							val.diferents = sinisters;

							address = encodeURI(val.CAP+' '+val.INDIRIZZO+', '+val.COMUNE+', '+val.PROVINCIA);

							var fecha = moment(val.DT_Incarico),
							diff = hoy.diff(fecha, 'days'),
							color = "violeta",
							icon = "",
							addn = "";

				            if (val.TP == 'AC' || val.TP == 'RG') { icon = 'ac'; }
							else if (val.TP == 'AT') { icon = 'at'; }
							else if (val.TP == 'EA') { icon = 'ea'; }
							else if (val.TP == 'FE') { icon = 'fe'; }
							else if (val.TP == 'EL') { icon = 'el'; }
							else if (val.TP == 'AL' || val.TP == 'VA' || val.TP == 'altre') { icon = 'altre'; }
							else if (val.TP == 'IN') { icon = 'in'; }
							else if (val.TP == 'RE') { icon = 're'; }
							else if (val.TP == 'CR') { icon = 'cr'; }
							else if (val.TP == 'AR') { icon = 'ar'; }
							else if (val.TP == 'FU' || val.TP == 'AM' || val.TP == 'RA') { icon = 'fu'; }
							else if (val.TP == 'RC' || val.TP == 'RU' || val.TP == 'RP') { icon = 'rc'; }
							else if (val.TP == 'NN') { icon = 'nn'; }
							else {icon = "altre";}

				            if (!val.TELEFONO && !val.CELLULARE && !val.EMAIL) {
				            	addn = '-sin';
				            }

				            let continuar = true;

				            if(val.DATA_SOPRALLUOGO && val.DATA_SOPRALLUOGO != ""){
					            if(moment(val.DATA_SOPRALLUOGO) >= moment.tz("Europe/Rome").startOf('day'))
					            {
					            	// fissato.total++;
					            	// fissato.diff += diff;
					            	continuar = true;
					            	addn+='-transparente';
					            }else{
					            	// data[1].splice(index,1);
					            	continuar = false;
					            }
				            }else{
				            	// if (diff){
				            	// 	non_fissato.total++;
				            	// 	non_fissato.diff += diff;
				            	// }
				            }

				            if (continuar && val.latlng && val.Stato != '030FATTO') {

				            	if (diff <= 20) {
					                color = "verde";
					            }else if (diff > 20 && diff <= 40) {
					                color = "amarillo";
					            }else if (diff > 40 && diff <= 60) {
					                color = "rojo";
					            }else if (diff > 60) {
					                color = "violeta";
					            }

								if (!already_loaded) {

									$.each(sinisters, function(index, val) {
										if(val.COMPAGNIA != "") {compagnia.push(val.COMPAGNIA);}
										if(val.SOPRALLUOGO != "") {perito.push(val.SOPRALLUOGO);}
										if(val.PROVINCIA != "") {provincia.push(val.PROVINCIA);}
										if(val.Stato != "") {stato.push(val.Stato);}
										if(val.TP != "") {tp.push(val.TP);}
									});
								}

								let getLocations = localStorage.getItem('getLocations');

								if (getLocations == 'true') {

									url = 'https://maps.googleapis.com/maps/api/geocode/json?address='+address+'&key=AIzaSyDsj-gbtqTAsxtWNbcqrRmE8ExatChS_Ko';

									if (!val.lat || !val.lng) {
										return fgetLocations(url,val);
									}

								}else{

									let l = {lat: val.lat,lng: val.lng};

									var contentString = "<div id='all-content-"+val.id+"'></div>";

									for (var i = 0; i < val.diferents.length; i++) {

										let _val = val.diferents[i];

										let _fecha = moment(_val.DT_Incarico),
										_diff = hoy.diff(_fecha, 'days'),
										_color = "";

										if (_diff <= 20) {
							                _color = "verde";
							                verde.total++;
							                verde.diff+=_diff ? _diff : 0;
							            }else if (_diff > 20 && _diff <= 40) {
							                _color = "amarillo";
							                amarillo.total++;
							                amarillo.diff+=_diff ? _diff : 0;
							            }else if (_diff > 40 && _diff <= 60) {
							                _color = "rojo";
							                rojo.total++;
							                rojo.diff+=_diff ? _diff : 0;
							            }else if (_diff > 60) {
							                _color = "violeta";
							                violeta.total++;
							                violeta.diff+=_diff ? _diff : 0;
							            }

										addToButtons(_val,_color);

										if(moment(_val.DATA_SOPRALLUOGO) >= moment.tz("Europe/Rome").startOf('day')){
											fissato.total++;
											if (_diff) {
					            				fissato.diff += _diff;
					            			}
										}else{
											non_fissato.total++;
											if (_diff) {
					            				non_fissato.diff += _diff;
											}
										}
									}

									  var infowindow = new google.maps.InfoWindow({
									    content: contentString
									  });

									  let _color = "";

									  if (color == 'amarillo') {_color='#333333';}else{_color='#ffffff'}

									var marker = new google.maps.Marker({
								      position: {lat: parseFloat(l.lat), lng: parseFloat(l.lng)},
								      map: map,
								      icon: {url: '{{url('markers')}}/'+color+'-'+icon+addn+'.png', scaledSize: new google.maps.Size(80, 80)},
								      label: {text: /*val.*/val.diferents.length.toString(),color: _color,fontSize: '12px',fontWeight: 'bolder'}
								    });

								    marker.addListener('click', function() {
									  infowindow.open(map, marker);
									  setTimeout(()=>{
									  	$.get('{{url('findMapInformation')}}/'+val.id, function(data) {
									  		console.log(data);
									  		getInfoWindowInformation(data);
									  	});
									  },200)
									});

								}
				            }
				            if (getLocations == 'true') {
								if (!--total) {
									$('#blockThis').unblock();
									setTimeout(()=>{
										console.log('reloadingMap');
										setTimeout(()=>{
								        	retrieveRestantes();
								        },2000);
										$('#blockThis').block({message:"Ricaricare la mappa..."});

										(PNotify.success({
								          title: "Excel File",
								          text: "Nuovo file caricato con successo!",
								          type: 'success',
								          desktop: {
								              desktop: false
								          }
								        }));
										initMap();
									},2000);
								}else{
									// console.log(total);
								}
				            }

						});

						// console.log(verde.diff,verde.total);
						// console.log(non_fissato.diff,non_fissato.total);

						$('#verde').text(verde.total); $('#verde-media').text(((verde.diff/verde.total) || 0).toFixed(2));
						$('#amarillo').text(amarillo.total); $('#amarillo-media').text(((amarillo.diff/amarillo.total) || 0).toFixed(2));
						$('#rojo').text(rojo.total); $('#rojo-media').text(((rojo.diff/rojo.total) || 0).toFixed(2));
						$('#violeta').text(violeta.total); $('#violeta-media').text(((violeta.diff/violeta.total) || 0).toFixed(2));

						$('#total-1').text((verde.total+amarillo.total+rojo.total+violeta.total).toString());
						$('#total-media-1').text((((verde.diff+amarillo.diff+rojo.diff+violeta.diff)/(verde.total+amarillo.total+rojo.total+violeta.total)).toFixed(2)).toString());

						$('#total-f').text(fissato.total);
						$('#total-media-f').text((( (fissato.diff/fissato.total) || 0 ).toFixed(2)).toString());

						$('#total-nf').text($('#total-1').text()-fissato.total/*non_fissato.total*/);
						$('#total-media-nf').text((( (non_fissato.diff/non_fissato.total) || 0 ).toFixed(2)).toString());

						console.log(non_fissato);

						$('#blockThis').unblock();

						let information = {
							_token:'{{csrf_token()}}',

							all: (verde.total+amarillo.total+rojo.total+violeta.total),
							l20: verde.total,
							l40: amarillo.total,
							l60: rojo.total,
							p60: violeta.total,

							mall: ((verde.diff+amarillo.diff+rojo.diff+violeta.diff)/(verde.total+amarillo.total+rojo.total+violeta.total)).toFixed(2),
							ml20: ((verde.diff/verde.total) || 0).toFixed(2),
							ml40: ((amarillo.diff/amarillo.total) || 0).toFixed(2),
							ml60: ((rojo.diff/rojo.total) || 0).toFixed(2),
							mp60: ((violeta.diff/violeta.total) || 0).toFixed(2),

							fiss: fissato.total,
							nonf: $('#total-1').text()-fissato.total,
							gmfs: ((fissato.diff/fissato.total) || 0 ).toFixed(2),
							gmnf: ((non_fissato.diff/non_fissato.total) || 0 ).toFixed(2),
						}

						// console.log("saveExcelData",information);

						$.post('{{url('saveExcelData')}}', information, function(data, textStatus, xhr) {
						});

						if (!already_loaded) {

							function onlyUnique(value, index, self) { 
							    return self.indexOf(value) === index;
							}
							let html = "";
							let html2 = "<option value='0'>Mostra tutte le compagnie</option>";
							$.each(compagnia.sort().filter( onlyUnique ),function(index, el) {
								if (el != null || el != "") {
									html+="<option>"+el+"</option>";

									let option = '{{ session('company') }}' == el ? 'selected' : '';

									html2+="<option "+option+">"+el+"</option>";
								}
							});
							$('#compagnia').html(html);
							$('#global-company').html('<option value="" disabled>Compagnia - general filter</option>'+html2);
							html = "<option value='none'>-- Senza perito --</option>";
							// $.each(perito.sort().filter( onlyUnique ),function(index, el) {
							// 	// console.log(el)
							// 	if (el != null || el != "") {
							// 		html+="<option>"+el+"</option>";
							// 	}
							// });
							// $('#perito').html(html);
							// $('#perito2').html(html);
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
									allStatus.push(el);
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
				},1000)
			
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

		/**/

		$('#per-zappa, #per-renova').change(function(event) {

			var formData = new FormData();

			formData.append('file',document.getElementById($(this).attr('id')).files[0]);
			formData.append('type',$(this).data('society'));
			formData.append('_token','{{csrf_token()}}');

			$('#blockThis').block({ message: "Caricamento..." })

			$.ajax({
				url: '{{url('alignExperts')}}',
				type: 'POST',
				contentType: false,
				processData: false,
				data: formData,
			})
			.done(function() {
				// console.log("success");
				$('#blockThis').unblock();
				alert('Periti caricati!');
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

		$('#stati').change(function(event) {

			var formData = new FormData();

			formData.append('file',document.getElementById('stati').files[0]);
			formData.append('_token','{{csrf_token()}}');

			$('#blockThis').block({ message: "Caricamento..." })

			$.ajax({
				url: '{{url('alignStates')}}',
				type: 'POST',
				contentType: false,
				processData: false,
				data: formData,
			})
			.done(function() {
				// console.log("success");
				$('#blockThis').unblock();
				alert('Stati caricati!');
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

		$('#filter-excel').click(function(event) {
			let info = {_token: '{{csrf_token()}}',compagnia: $('#compagnia').val(), perito: $('#perito').val(), provincia: $('#provincia').val(), stato: $('#stato').val(), tp: $('#tp').val(), excel: 'true',data_type:[1]};

			$.post('{{url('getMapInformation')}}',info, function(data, textStatus, xhr) {
				$("body").append("<iframe src='" + data[0]+ "' style='display: none;' ></iframe>");
			});
		});

		$('#find-specific').click(function(event) {
			console.log('aqui')
			if ($('#specific-id').val()) {

				$('#compagnia').val([]).change();
				$('#perito').val([]).change();
				$('#provincia').val([]).change();
				$('#stato').val([]).change();
				$('#tp').val([]).change();
				$('#max').val([]).change();

				filter(event);
			}
		});

		$('#filter').click(function(event) {
			$('#specific-id').val("");
			filter(event);
		});;

		function filter(event) {

			infoWindows = [];

			$('#filtro-perito').text("");

			$('.marron-div').addClass('hidden');

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
				if ($('#specific-id').val() == "") {
					$('[data-target="#filtros"]').trigger('click');
				}
			  	navigator.geolocation.getCurrentPosition(function(position) {
			        var pos = {
				      lat: position.coords.latitude,
				      lng: position.coords.longitude
				    };

				    map = new google.maps.Map(document.getElementById('map-locations'), {
				      zoom: 8,
				      center: {lat:45.4628328,lng:9.1076928},
				      // mapTypeControl: false,
					  streetViewControl: false,
					  rotateControl: false,
			          mapTypeId: 'roadmap'
				    });
				    var marker = new google.maps.Marker({
				      position: pos,
				      map: map
				    });

					let address;
					let url;
					let fecha
					let diff
					let color
					let icon

					let verde = {total:0,diff:0};
					let amarillo = {total:0,diff:0};
					let rojo = {total:0,diff:0};
					let violeta = {total:0,diff:0};

					let fissato = {total:0,diff:0};
					let non_fissato = {total:0,diff:0};

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
					let only_fixed = $('#only_fixed').is(':checked');

					if (!max || max == "") {
						max=0;
					}

					let info = {_token: '{{csrf_token()}}',compagnia: $('#compagnia').val(), perito: $('#perito').val(), provincia: $('#provincia').val(), stato: $('#stato').val(), tp: $('#tp').val(),data_type:[1], specific: $('#specific-id').val()};

					$.post('{{url('getMapInformation')}}',info, function(data, textStatus, xhr) {

						console.log(data);

						$.each(data[1], function(index, v) {

							var sinisters = [];
							
							if (!v.diferents) {
								sinisters = [v];
							}else{
								sinisters = v.diferents.sort((a,b)=>{if(a.DATA_SOPRALLUOGO > b.DATA_SOPRALLUOGO){return -1}else{return 1}return 0});
								sinisters = sinisters.filter(x=>moment(x.DATA_SOPRALLUOGO) >= moment().startOf('day') || x.DATA_SOPRALLUOGO == "");
							}

							var val = sinisters[0] || [];
							val.diferents = sinisters;

							address = encodeURI(val.CAP+' '+val.INDIRIZZO+', '+val.COMUNE+', '+val.PROVINCIA);

							if (!val.lat && !val.lng) {
								url = 'https://maps.googleapis.com/maps/api/geocode/json?address='+address+'&key=AIzaSyDsj-gbtqTAsxtWNbcqrRmE8ExatChS_Ko';

								$.post(url, [], function(data, textStatus, xhr) {

									if (data.status != "ZERO_RESULTS" && data.status != "OVER_QUERY_LIMIT" && data.status != "REQUEST_DENIED") {

										if (data.results[0]) {
											let l = data.results[0].geometry.location;

											if (val.id) {
												$.post('{{'saveLatLng'}}/'+val.id, {_token: '{{csrf_token()}}', lat: l.lat, lng: l.lng}, function(data, textStatus, xhr) {
													// console.log('saved filtered');
												});
											}
										}else{
											console.log('no results');
										}

									}

								});
							}

							var fecha = moment(val.DT_Incarico),
							diff = hoy.diff(fecha, 'days'),
							color = "",
							icon = "violeta",
							addn = "";

				            if (val.TP == 'AC' || val.TP == 'RG') { icon = 'ac'; }
							else if (val.TP == 'AT') { icon = 'at'; }
							else if (val.TP == 'EA') { icon = 'ea'; }
							else if (val.TP == 'FE') { icon = 'fe'; }
							else if (val.TP == 'EL') { icon = 'el'; }
							else if (val.TP == 'AL' || val.TP == 'VA' || val.TP == 'altre') { icon = 'altre'; }
							else if (val.TP == 'IN') { icon = 'in'; }
							else if (val.TP == 'RE') { icon = 're'; }
							else if (val.TP == 'CR') { icon = 'cr'; }
							else if (val.TP == 'AR') { icon = 'ar'; }
							else if (val.TP == 'FU' || val.TP == 'AM' || val.TP == 'RA') { icon = 'fu'; }
							else if (val.TP == 'RC' || val.TP == 'RU' || val.TP == 'RP') { icon = 'rc'; }
							else if (val.TP == 'NN') { icon = 'nn'; }
							else {icon = "altre";}

				            if (!val.TELEFONO && !val.CELLULARE && !val.EMAIL) {
				            	addn = '-sin';
				            }

				            let continuar;
				            if (only_fixed) {
				            	continuar = false;
				            }else{
				            	continuar = true;
				            }

				            if(val.DATA_SOPRALLUOGO && val.DATA_SOPRALLUOGO != ""){

				            	// fissato.total++;
				            	// fissato.diff += diff;

					            if(moment(val.DATA_SOPRALLUOGO) >= moment.tz("Europe/Rome").startOf('day'))
					            {
					            	continuar = true;
					            	addn+='-transparente';
					            }else{
					            	// data[1].splice(index,1);
					            	continuar = false;
					            }
				            }else{
				            	// non_fissato.total++;
				            	// non_fissato.diff += diff;
				            }

				            console.log(continuar , val.latlng , val.Stato != '030FATTO')

				            if (continuar && val.latlng && val.Stato != '030FATTO') {

				            	console.log('deberia continuar')

				            	if (diff <= 20) {
					                color = "verde";
					            }else if (diff > 20 && diff <= 40) {
					                color = "amarillo";
					            }else if (diff > 40 && diff <= 60) {
					                color = "rojo";
					            }else if (diff > 60) {
					                color = "violeta";
					            }

				            	// console.log('{{url('markers')}}/'+color+'-'+icon+addn+'.png');

								let l = {lat: val.lat,lng: val.lng};

								var contentString = "<div id='all-content-"+val.id+"'></div>";
								var putMarker = true;

								for (var i = 0; i < val.diferents.length; i++) {

									let _val = val.diferents[i];

									let _tp;

									if (_val.TP == 'AC' || _val.TP == 'RG') {_tp = "Acqua condotta";}
									if (_val.TP == 'AT') {_tp = "Atti Vandalici";}
									if (_val.TP == 'EA') {_tp = "Evento Atmosferico";}
									if (_val.TP == 'FE') {_tp = "Fenomeno Elettrico";}
									if (_val.TP == 'EL') {_tp = "Elettronica";}
									if (_val.TP == 'AL' || _val.TP == 'VA' || _val.TP == 'altre') {_tp = "Pluralità di garanzie";}
									if (_val.TP == 'IN') {_tp = "Incendio";}
									if (_val.TP == 'RE') {_tp = "RC Auto";}
									if (_val.TP == 'CR') {_tp = "Cristalli";}
									if (_val.TP == 'AR') {_tp = "Accertamenti";}
									if (_val.TP == 'FU' || _val.TP == 'AM' || _val.TP == 'RA') {_tp = "Furto";}
									if (_val.TP == 'RC' || _val.TP == 'RU' || _val.TP == 'RP') {_tp = "Responsabilità Civile";}
									if (_val.TP == 'NN') {_tp = "Non indennizzabile";}

									let _fecha = moment(_val.DT_Incarico),
									_diff = hoy.diff(_fecha, 'days'),
									_color = "";

									if (_diff >= max) {
										if (_diff <= 20) {
							                _color = "verde";
							                verde.total++;
							                verde.diff+=_diff ? _diff : 0;
							            }else if (_diff > 20 && _diff <= 40) {
							                _color = "amarillo";
							                amarillo.total++;
							                amarillo.diff+=_diff ? _diff : 0;
							            }else if (_diff > 40 && _diff <= 60) {
							                _color = "rojo";
							                rojo.total++;
							                rojo.diff+=_diff ? _diff : 0;
							            }else if (_diff > 60) {
							                _color = "violeta";
							                violeta.total++;
							                violeta.diff+=_diff ? _diff : 0;
							            }

										if (_color == 'verde') {mVerde.push(_val);}
										if (_color == 'amarillo') {mAmarillo.push(_val);}
										if (_color == 'rojo') {mRojo.push(_val);}
										if (_color == 'violeta') {mVioleta.push(_val);}

										mAll.push(_val);

										if (val.DATA_SOPRALLUOGO && val.DATA_SOPRALLUOGO != "") {

											if(moment(_val.DATA_SOPRALLUOGO) >= moment.tz("Europe/Rome").startOf('day')){
												fissato.total++;
												if (_diff) {
						            				fissato.diff += _diff;
						            			}
											}else{
												non_fissato.total++;
												if (_diff) {
						            				non_fissato.diff += _diff;
												}
											}
										}else{
											non_fissato.total++;
											if (_diff) {
					            				non_fissato.diff += _diff;
											}
										}
										
										// contentString += '<div id="content">'+
									 //      '<div class="siteNotice">'+
									 //      '</div>'+
									 //      '<h5 style="margin-bottom: 0" id="firstHeading" class="firstHeading">'+_val.N_P+' - '+_val.Assicurato+' '+_val.TP+'-'+_tp+'</h5>'+
									 //      '<h5 style="margin-top: 3px; margin-bottom: 0" id="firstHeading"> COMPAGNIA: '+_val.COMPAGNIA+'</h5>'+
									 //      '<h6 style="margin-top: 5px" id="firstHeading"> Stato: '+_val.Stato+(_val.DATA_SOPRALLUOGO ? ' <small style="font-size: 12px; display: inline-block; margin-left: 16px;font-weight: 700">Il: '+moment(_val.DATA_SOPRALLUOGO).format('DD-MM-YYYY HH:mm')+'</small>' : '')+'</h6>'+
									 //      '<div id="bodyContent">'+
									 //      '<p>\
									 //      Indirizzo: '+(_val.CAP+' '+_val.INDIRIZZO+', '+_val.COMUNE+', '+_val.PROVINCIA)+'<br>\
									 //      Cellulare: '+(_val.CELLULARE == null ? '---' : _val.CELLULARE)+'<br>\
									 //      Telefono: '+(_val.TELEFONO == null ? '---' : _val.TELEFONO)+'<br>\
									 //      Email: '+(_val.EMAIL == null ? '---' : _val.EMAIL)+'<br>\
									 //      Data Incarico: '+(_val.DT_Incarico == null ? '---' : moment(_val.DT_Incarico).format('DD-MM-YYYY HH:mm')+' gg. '+moment().diff(moment(_val.DT_Incarico),'days'))+'<br>\
									 //      Data Assegnata: '+(_val.DT_ASSEGNATA == null ? '---' : moment(_val.DT_ASSEGNATA).format('DD-MM-YYYY HH:mm')+' gg. '+moment().diff(moment(_val.DT_ASSEGNATA),'days'))+'<br>\
									 //      Accertatore: '+(_val.SOPRALLUOGO == null ? '---' : _val.SOPRALLUOGO)+'<br>\
									 //      </p>'+
									 //      (_val.total > 1 ? "<button onclick='loadModal("+_val.id+")' class='loadModal btn btn-info btn-xs'>Vedi tutti i danneggiati ("+_val.total+")</button>" : '')+
									  //		@if (Auth::user()->role_id == -1)
									  //       '<button onclick="loadManagementModal('+_val.id+')" class="loadManagementModal btn btn-success btn-xs" type="button">Management</button>'+
									  //        @endif
									  //     		'</div>'+
									  //      '</div>';
									}else{
										putMarker = false;
									}

								}

								console.log('putMarker',putMarker)

								if (putMarker) {
									var infowindow = new google.maps.InfoWindow({
										content: contentString
									});

									let _color = "";

									if (color == 'amarillo') {_color='#333333';}else{_color='#ffffff'}

									var marker = new google.maps.Marker({
								      position: {lat: parseFloat(l.lat), lng: parseFloat(l.lng)},
								      map: map,
								      icon: {url: '{{url('markers')}}/'+color+'-'+icon+addn+'.png', scaledSize: new google.maps.Size(80, 80)},
								      label: {text: /*val.*/val.diferents.length.toString(),color: _color,fontSize: '12px',fontWeight: 'bolder'}
								    });

								    marker.addListener('click', function() {
									  infowindow.open(map, marker);
									  setTimeout(()=>{
									  	$.get('{{url('findMapInformation')}}/'+val.id, function(data) {
									  		console.log(data);
									  		getInfoWindowInformation(data);
									  	});
									  },200)
									});
								}

				            }

						});

						$('#verde').text(verde.total); $('#verde-media').text(((verde.diff/verde.total) || 0).toFixed(2));
						$('#amarillo').text(amarillo.total); $('#amarillo-media').text(((amarillo.diff/amarillo.total) || 0).toFixed(2));
						$('#rojo').text(rojo.total); $('#rojo-media').text(((rojo.diff/rojo.total) || 0).toFixed(2));
						$('#violeta').text(violeta.total); $('#violeta-media').text(((violeta.diff/violeta.total) || 0).toFixed(2));

						$('#total-1').text((verde.total+amarillo.total+rojo.total+violeta.total).toString());
						$('#total-media-1').text((((verde.diff+amarillo.diff+rojo.diff+violeta.diff)/(verde.total+amarillo.total+rojo.total+violeta.total)).toFixed(2)).toString());

						$('#total-f').text(fissato.total);
						$('#total-media-f').text((( (fissato.diff/fissato.total) || 0 ).toFixed(2)).toString());

						$('#total-nf').text($('#total-1').text()-fissato.total/*non_fissato.total*/);
						$('#total-media-nf').text((( (non_fissato.diff/non_fissato.total) || 0 ).toFixed(2)).toString());

						// $('.table').dataTable().fnDestroy();

						// $('#results').html(data[0]);

						// $('.table').dataTable()

					});
				});
			// }
		}

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

	<script
		src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsj-gbtqTAsxtWNbcqrRmE8ExatChS_Ko">
	</script>

	{{-- ////***//// --}}

	<script>
		$('#reload').dblclick(function(event) {
			$('#excel-table').modal('show');
		});

		$('#check_gm').click(check_gm);

		function check_gm(event) {

			console.log('aqui')

			$('#blockThis').block({message:"Stiamo verificando le posizioni nell'API di Google Maps, attendere ..."});

			let info = {_token: '{{csrf_token()}}',data_type:[1]};

			$.post('{{url('getMapInformation2')}}',info, function(data, textStatus, xhr) {

				$.each(data, function(index, val) {

					address = encodeURI(val.CAP+' '+val.INDIRIZZO+', '+val.COMUNE+', '+val.PROVINCIA);

					if (!val.lat && !val.lng) {
						url = 'https://maps.googleapis.com/maps/api/geocode/json?address='+address+'&key=AIzaSyDsj-gbtqTAsxtWNbcqrRmE8ExatChS_Ko';

						$.post(url, [], function(data, textStatus, xhr) {

							if (data.status != "ZERO_RESULTS" && data.status != "OVER_QUERY_LIMIT" && data.status != "REQUEST_DENIED") {

								if (data.results[0]) {
									let l = data.results[0].geometry.location;

									if (val.id) {
										$.post('{{'saveLatLng'}}/'+val.id, {_token: '{{csrf_token()}}', lat: l.lat, lng: l.lng}, function(data, textStatus, xhr) {
											console.log('saved filtered');
										});
									}


								}
							}else{
								var message = "";
								if (data.status == "ZERO_RESULTS") {
									message = "Per il sinistro "+val.N_P+" l'API non è stata in grado di fornire la posizione";
								}else{
									message = "OVER_QUERY_LIMIT, devi attendere per effettuare nuovamente le richieste all'API..."
								}
							}

						});
					}

				});
				setTimeout(()=>{
					retrieveRestantes();
				},2000);
				$('#blockThis').unblock();
				initMap();
			});
		}

		function retrieveRestantes()
		{
			$.post('{{url('retrieveRestantes')}}', {_token: '{{csrf_token()}}',data_type:[1]}, function(data, textStatus, xhr) {
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

	@include('admin.map-script')

	@include('admin.white-script')

	<script>
		$('.exportExcludes').click(function(event) {
			let type = $(this).data('type');
			$.post('{{url('exportExcel')}}', {_token: '{{csrf_token()}}', type: type,data_type:[1]}, function(data, textStatus, xhr) {
				$('#blockThis').unblock();
				$("body").append("<iframe src='" + data[0]+ "' style='display: none;' ></iframe>");
			});
		});
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

		/**/

		$('#openAllInfoWindow2').click(function(event) {
			$('#closeAllInfoWindow2').parent().removeClass('hide');
			$(this).parent().addClass('hide');
			$.each(infoWindows2, function(index, val) {
				 val.infowindow.open(map,val.marker);
			});
		});

		$('#closeAllInfoWindow2').click(function(event) {
			$('#openAllInfoWindow2').parent().removeClass('hide');
			$(this).parent().addClass('hide');
			$.each(infoWindows2, function(index, val) {
				 val.infowindow.close();
			});
		});

		$('#global-company').change(function(event) {
			if ($(this).val() == 0) {
				$('#company-hidden').removeClass('hidden');
			}else{
				$('#company-hidden').addClass('hidden');
			}
			$.post('{{url('setCompanySession')}}', {_token: '{{csrf_token()}}',company:$(this).val()}, function(data, textStatus, xhr) {
				
			});
		});

		$("#data-modal").on("hide.bs.modal", function (e) {
		    // put your default event here

		    if (!localStorage.getItem('close')) {
		    	let a = confirm("Attenzione. Non hai salvato le modifiche");
		    	if (!a) {
		    		return false;
		    	}
		    }
		});
	</script>

	<script>
		
		@if ($t_s)
			check_gm();
		@else
			initMap();
		@endif

	</script>

@endsection
@stop