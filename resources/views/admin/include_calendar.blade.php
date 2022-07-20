@php
setlocale(LC_ALL,
	'italian',
	'it_CH',
	'it_CH.iso88591',
	'it_CH.utf8',
	'it_IT',
	'it_IT@euro',
	'it_IT.iso88591',
	'it_IT.iso885915@euro',
	'it_IT.utf8'

);
$month = isset( $backMonth ) ? $backMonth : date( 'Y-n' );
$carbon = new Carbon\Carbon;
$week = 1;
for ( $i=1;$i<=date( 't', strtotime( $month ) );$i++ ) {
	
	$day_week = date( 'N', strtotime( $month.'-'.$i )  );
	
	$calendar[ $week ][ $day_week ] = $i;
	if ( $day_week == 7 )
		$week++;
	
}
@endphp
<style>
	.calendar-badge {
		position: absolute; font-size: 8px; font-weight: 700; color: #fff;display: block; width: 14px; height: 14px; text-align: center; border-radius: 64px; top: 5px; right:5px; cursor: pointer;
	}
	.popover-content ul {padding: 0;margin-bottom:0;}
	.popover-content ul li{list-style: none;}
	.popover-content, .popover-title {
		font-size: 12px;
	}
	.calendar-list {padding: 0;margin-bottom:0; position: relative; width: 100%}
	.calendar-list li{list-style: none; width: 100%; padding: 1px 6px; font-size: 10px; border-radius: 3px; margin-bottom:3px;height: 20px}
	.calendar-list li.vacanze{background-color: #69d6b9; color: #fff; }
	.calendar-list li.eventi{background-color: #fff; color: #69d6b9; border: 1px solid #69d6b9; }

	.calendar-list li.eventi.past{background-color: #fff; color: silver; border: 1px solid silver; }
	.calendar-list li.vacanze.past{background-color: silver; color: #fff; }
	marquee {
		cursor: pointer;
	}
	.popover-content a {
		display: block;
		margin: 8px 0;
	}
	.ev-data {
		display: block;
		margin: 8px 0;
	}
</style>
<div class="panel-heading">
	<table class="table table-calendar mb0">
	<thead>
		<tr>
			<th width="10%">
				<a href="#" data-month="{{ $month }}" data-action="sub" class="changeMonth-full" style="float:left; font-size: 18px"> < </a>
			</th>
			<th class="text-center" colspan="5" width="80%">
				{{ ucwords($carbon->parse($month)->formatLocalized('%B %Y')) }}
			</th>
			<th width="10%">
				<a href="#" data-month="{{ $month }}" data-action="add" class="changeMonth-full" style="float:right; font-size: 18px"> > </a>
			</th>
		</tr>
		<tr>
			<th style="width: 14.30%; text-align: center;">L</th>
			<th style="width: 14.30%; text-align: center;">M</th>
			<th style="width: 14.30%; text-align: center;">M</th>
			<th style="width: 14.30%; text-align: center;">G</th>
			<th style="width: 14.30%; text-align: center;">V</th>
			<th style="width: 14.30%; text-align: center;">S</th>
			<th style="width: 14.30%; text-align: center;">D</th>
		</tr>
	</thead>

	</table>
</div>

<div class="panel-body table-responsive">
	<table class="table table-calendar table-bordered mb0">
		<tbody>
			@foreach ($calendar as $days)
				<tr>
					@for ($i=1;$i<=7;$i++)
						<td class="{{ (date('d') == @$days[$i] && date('Y-n') == $month) ? 'active' : '' }}" {{ isset($days[$i]) ? "data-day='$days[$i]'" : '' }} style="position: relative;height: 100px; width: 14.30%">
							{{ isset($days[$i]) ? $days[$i] : '' }}
							@if (isset($days[$i]))
								@php
									$d1  = $carbon->parse($month.'-'.$days[$i]);
									$d2  = $d1->copy()->addDay();

									$today = $d1->copy()->format('Y-m-d') ;

									$can = true;

									if (Auth::user()->role_id != -1) {
										$can = false;
										$a = 0;
										foreach ($events as $key => $ev) {
											foreach ($ev->googleEvent->attendees as $at) {
												if (Auth::user()->google_calendar_email == $at->email) {
													$a++;
												}
											}
										}
										if ($a > 0) {
											$can = true;
										}
									}

								@endphp
								{{-- @if ($ac->count() > 0) --}}

								@if ($can)
									@foreach ($events as $key => $day)
										@php
											$date = $carbon->parse($day->googleEvent->start->dateTime)->startOfDay();
										@endphp
										@if ($date->copy()->format('d-m-Y') == $d1->format('d-m-Y'))
											<ul class="calendar-list">
												<li id="popoverId{{$key}}"
												data-toggle="popover" data-html="true" title="<b>Opzioni</b>"
												data-content="
													<a href='#' data-target='#modal-show' data-toggle='modal' data-id='#popoverId{{$key}}' data-content='{{json_encode($day->googleEvent)}}'>Vedi evento</a>
													{{-- <a href='#' data-target='#modal-invite' data-toggle='modal' data-id='{{$day->googleEvent->id}}'>Invita partecipante</a> --}}
													<a href='#' data-target='#modal-delete' data-toggle='modal' data-id='{{$day->googleEvent->id}}'>Elimina evento</a>
												"

												class="vacanze {{ strtotime($d1) < strtotime($carbon->today()) ? 'past' : '' }}">
													<marquee scrollamount="2" direction="">
														{{$day->googleEvent->summary ?? 'Evento '.$date->copy()->format('d-m-Y')}}
													</marquee>
												</li>
											</ul>
										@endif
									@endforeach
								@endif
									{{-- <span data-toggle="popover"data-placement="right"
									class="calendar-badge" style="background-color: {{ strtotime($d1) < strtotime($carbon->today()) ? 'silver' : '#69d6b9' }};">
										{{ $ac->count() }}
									</span> --}}
								{{-- @endif --}}
							@endif
						</td>
					@endfor
				</tr>
			@endforeach
		</tbody>
	</table>
</div>

<div class="modal fade" id="modal-show">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">Visualizza evento</div>
			<div class="modal-body">
				<span class="ev-data" id="desc-ev" style="font-size: 18px; margin-bottom: 4px;"></span>
				<span class="ev-data"><b>Data d'inizio:</b> <span id="date-ev"></span></span>
				<span class="ev-data"><b>Ora di inizio:</b> <span id="hour-ev"></span></span>

				<span class="ev-data"><b>Data finale:</b> <span id="edate-ev"></span></span>
				<span class="ev-data"><b>Ora finale:</b> <span id="ehour-ev"></span></span>

				<div id="attendees">
					
				</div>

				<hr>

				<div>
					<h4 id="ev-orgnm"></h4>
					<b>Creato da:</b> <span style="display: block;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;" id="ev-orgem"></span>
				</div>

				<hr>

				<a target="_blank" id="calendar-link" class="btn btn-info"><i class="fa fa-calendar"></i> Vedi in Google Calendar</a>
			</div>
		</div>
	</div>
</div>

{{-- <div class="modal fade" id="modal-invite">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">Invita i partecipanti</div>
			<div class="modal-body">
				<div class="form-group">
					<label>E-mail</label>
					<input type="hidden" id="ev-id">
					<input type="text" class="form-control" id="ev-email">
				</div>
				<div class="modal-footer">
					<button class="btn btn-success ev-invita">Ok</button>
					<button data-dismiss="modal" class="btn btn-danger">Cancella</button>
				</div>
			</div>
		</div>
	</div>
</div> --}}

<div class="modal fade" id="modal-delete">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">Elimina evento <span id="ev-title"></span></div>
			<div class="modal-footer">
				<button id="ev-delete" class="btn btn-success">Elimina</button>
				<button data-dismiss="modal" class="btn btn-danger">Cancella</button>
			</div>
		</div>
	</div>
</div>