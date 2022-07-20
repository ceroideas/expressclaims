@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<style>
	/*.green-chart{
		background: #a9d96c;
	}
	.red {background: #ff6c60;}
	.terques {background: #6ccac9;}
	.yellow {background: #f8d347;}
	.blue {background: #57c8f2;}
	.green {background: #99c262;}
	.violet {background: #8075c4;}
	.navy {background: #7087A3;}
	.def {background: #bec3c7;}
	.inverse {background: #344860;}
	.lg {background: lightgreen;}
	.cw {color: #fff;}*/

	.td-export {
		position: relative;
	}
	.td-export a {
		position: absolute;
		right: 0;
		background-color: #fff;
		display: none;
	}
	.td-export:hover a {
		display: inline-block;
	}

	.oddeven tr:nth-child(odd) {background: #e2f4ff; color: #333;}
	.oddeven tr:nth-child(even) {}
</style>

@php
	function minutes($time){
		$time = explode(':', $time);
		return ($time[0]*60) + ($time[1]);
	}
	$meses = ["Gen","Feb","Mar","Apr","Mag","Giu","Lug","Ago","Set","Ott","Nov","Dic"];
	$kpi = ["red","terques","yellow","bg-primary","blue","green-chart","green","violet","navy","def","inverse","lg"];
@endphp

<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">Videochiamate Mensile
			</div>
			<div class="panel-body">
				<div class="form-group">
						
						<div class="row">
							<div class="col-sm-12">
								<label>Filtro</label>
							</div>
							<div class="col-sm-2">
								<input type="text" class="form-control mpick" placeholder="Data da" id="from" value="{{isset($_GET['from']) ? $_GET['from'] : ''}}">
							</div>
							<div class="col-sm-2">
								<input type="text" class="form-control mpick" placeholder="Data a" id="to" value="{{isset($_GET['to']) ? $_GET['to'] : ''}}">
							</div>
							{{-- @if (Auth::user()->role_id == -1)
								<div class="col-sm-2">
									<select id="operator" class="select2example">
										<option value="all">Tutti gli operatori</option>
										@foreach (App\User::whereNotIn('role_id',[-1,0])->get() as $op)
											@if ($op->operator && $op->operator->ec == 1)
												<option {{isset($_GET['operator']) && $_GET['operator'] == $op->id ? 'selected' : ''}} value="{{$op->id}}">{{$op->fullname()}}</option>
											@endif
										@endforeach
									</select>
								</div>
							@endif --}}
							<div class="col-sm-6">
								<button class="btn btn-success start-search">Cerca</button>
								@if (isset($_GET['from']) || isset($_GET['to']) || isset($_GET['operator']))
									<button class="btn btn-danger stop-search">Cancella filtro</button>
								@endif
							</div>
						</div>
				</div>
				<div class="row">
					@php
						$fixed = (isset($_GET['to']) && $_GET['to'] != "") ? Carbon\Carbon::createFromFormat('m/Y',$_GET['to'])->startOfMonth()->addMonth() : Carbon\Carbon::today()->startOfMonth()->addMonth();
						$variable = (isset($_GET['from']) && $_GET['from'] != "") ? Carbon\Carbon::createFromFormat('m/Y',$_GET['from'])->startOfMonth() : $fixed->copy()->subMonths(6);
						$a = 0;

						$totals = [
							0 => 0,
							1 => 0,
							2 => 0,
							3 => 0,
							4 => 0,
							5 => 0,
							6 => 0,
							7 => 0,
							8 => 0,
							9 => 0,
							10 => 0,
							11 => 0,
						];

						$operators = App\User::whereNotIn('role_id',[-1,0])->orderBy('name','desc')->where(function($q){
							if (Auth::user()->role_id != -1) {
								$q->where('id',Auth::user()->id);
							}
						})->get();
					@endphp

					<div class="col-sm-12">
						
						<table class="table table-condensed">
							<thead>
								<tr style="background-color: #f6f3f0">
									<th>Operatori</th>
									@while ($variable < $fixed)
										
										<th>{{$meses[$variable->format('m')-1].' '.$variable->format('Y')}}</th>
										@php
											$variable->addMonth();
										@endphp
									@endwhile
									<th></th>
								</tr>
							</thead>

							<tbody class="oddeven">
								@foreach ($operators as $op)
									@if ($op->operator && $op->operator->ec == 1)

										<tr>
											<td>{{$op->fullname()}}</td>
											@php
												$subtotal = 0;
												$variable = (isset($_GET['from']) && $_GET['from'] != "") ? Carbon\Carbon::createFromFormat('m/Y',$_GET['from'])->startOfMonth() : $fixed->copy()->subMonths(6);
											@endphp

											@while ($variable < $fixed)

												@php
													$duration = 0;
													$bucle = App\Record::where('created_at','>=',$variable)->where('created_at','<',$variable->copy()->addMonth())->whereExists(function($q) use($op){
														$q->from('users')
														  ->whereRaw('users.id = records.user_id')
														  ->whereRaw('users.operator_call_id = '.$op->id);
													})->get();
												@endphp
												@foreach ($bucle as $rec)
													@php
														$duration+=minutes($rec->duration);
													@endphp
												@endforeach
										
												<td class="td-export">{{gmdate("H:i:s", $duration)}}
													<a href="{{url('admin/exportRecord')}}"
	                          						data-start="{{$variable->format('d-m-Y')}}"
	                          						data-operator="{{ $op->id }}"
	                          						class="exportMensili">Esporta</a>
												</td>
												@php
													$totals[$variable->format('m')-1] += $duration ;
													$subtotal += $duration;
													$variable->addMonth();
												@endphp
											@endwhile
											<td class="td-export">
												<b>{{gmdate("H:i:s", $subtotal)}}</b>

												{{-- <a href="">Esporta</a> --}}
											</td>
										</tr>

									@endif
								@endforeach
								@if (Auth::user()->role_id == -1)
								<tr>
									<th><h4><b>TOTAL</b></h4></th>
										@php
											$variable = (isset($_GET['from']) && $_GET['from'] != "") ? Carbon\Carbon::createFromFormat('m/Y',$_GET['from'])->startOfMonth() : $fixed->copy()->subMonths(6);
										@endphp

										@while ($variable < $fixed)
											<td>
												<h5><b>{{gmdate("H:i:s", $totals[$variable->format('m')-1])}}</b></h5>

												<a href="{{url('admin/exportRecord')}}"
	                          						data-start="{{$variable->format('d-m-Y')}}"
	                          						data-operator="all"
	                          						class="exportMensili">Esporta</a>
											</td>
											@php
												$variable->addMonth();
											@endphp
										@endwhile
										<td></td>
								</tr>
								@endif
							</tbody>
						</table>

					</div>

					{{-- @while ($variable < $fixed)
						<div class="col-sm-2">
							@php
								$duration = 0;
								$bucle = App\Record::where('created_at','>=',$variable)->where('created_at','<',$variable->copy()->addMonth())->whereExists(function($q){
									if (Auth::user()->role_id == -1) {
										if (isset($_GET['operator']) && $_GET['operator'] != 'all') {
											$q->from('users')
											  ->whereRaw('users.id = records.user_id')
											  ->whereRaw('users.operator_call_id = '.$_GET['operator']);
										}
									}else{
										$q->from('users')
										  ->whereRaw('users.id = records.user_id')
										  ->whereRaw('users.operator_call_id = '.Auth::user()->id);
									}
								})->get();
							@endphp
							@foreach ($bucle as $rec)
								@php
									$duration+=minutes($rec->duration);
								@endphp
							@endforeach
	                          <section class="panel" data-toggle="modal" data-target="#detalles-{{$a}}" style="cursor: pointer;">
	                              <div class="value {{$kpi[$variable->format('m')-1]}}" style="padding: 16px; border-radius: 8px; color: #fff; text-align: center;">
	                                  <h3 style="margin-top: 0"><span>{{$meses[$variable->format('m')-1].' '.$variable->format('Y')}}</span></h3>
	                                  <h5>{{gmdate("H:i:s", $duration)}}</h5>
	                              </div>
	                          </section>

	                          <div class="modal fade" id="detalles-{{$a}}">
	                          	<div class="modal-dialog modal-lg">
	                          		<div class="modal-content">
	                          			<div class="modal-header">
	                          				<h4>{{$meses[$variable->format('m')-1].' '.$variable->format('Y')}}

	                          					<a href="{{url('admin/exportRecord')}}"
	                          						data-start="{{$variable->format('d-m-Y')}}"
	                          						data-operator="{{ Auth::user()->role_id != -1 ? Auth::user()->id : (isset($_GET['operator']) ? $_GET['operator'] : 'all') }}"
	                          						class="btn btn-xs pull-right btn-success exportMensili">Esporta</a></h4>
	                          			</div>
	                          			<div class="modal-body">
	                          				<div class="row">
	                          					<div class="col-sm-12">
	                          						
			                          				<table class="table table-responsive">
			                          					<thead>
			                          						<tr>
			                          							<th>Riferimento Interno</th>
			                          							<th>Nominativo</th>
			                          							<th>Operatore</th>
			                          							<th>Telefono</th>
			                          							<th>Data di chiamata</th>
			                          							<th>Tempo</th>
			                          						</tr>
			                          					</thead>
			                          					<tbody>
			                          						@foreach ($bucle as $rec)
			                          							<tr>
			                          								<td>{{@$rec->reservation->sin_number}}</td>
			                          								<td>{{@$rec->user->name()}}</td>
			                          								<td>{{App\User::find(@$rec->user->operator_call_id) ? App\User::find(@$rec->user->operator_call_id)->fullname() : ''}}</td>
			                          								<td>
			                          									@if ($rec->user->webapp)
                                                                        {{$rec->user->webapp->code.$rec->user->webapp->phone}}
                                                                        @elseif($rec->user->customer)
                                                                        {{$rec->user->customer->phone}}
                                                                        @endif
			                          								</td>
			                          								<td>{{@$rec->created_at->format('d-m-Y H:i')}}</td>
			                          								<td>{{@$rec->duration}}</td>
			                          							</tr>
			                          						@endforeach
			                          					</tbody>
			                          				</table>
	                          					</div>
	                          				</div>
	                          			</div>
	                          		</div>
	                          	</div>
	                          </div>
						</div>
						@php
							$a++;
							$variable->addMonth();
						@endphp
					@endwhile --}}
				</div>
			</div>
		</div>
	</div>
</div>
@section('scripts')
<script>
	// $('.table').dataTable({
	// 	"lengthMenu": [ 10, 25, 50 ],
 //    	"pageLength":25
	// });

	$('.exportMensili').click(function(event) {
		event.preventDefault();

		$.post($(this).attr('href'), {_token:'{{csrf_token()}}',start:$(this).data('start'),operator:$(this).data('operator')} , function(data) {
			$("body").append("<iframe src='" + data[0]+ "' style='display: none;' ></iframe>");
		});
	});

	$('.start-search').click(function(event) {
		var from = $('#from').val();
		var to = $('#to').val();
		var operator = $('#operator').val();

		@if (Auth::user()->role_id == -1)
			window.open('{{url('admin/videochiamate-mensili')}}?from='+from+'&to='+to+'&operator='+operator,'_self');
		@else
			window.open('{{url('admin/videochiamate-mensili')}}?from='+from+'&to='+to,'_self');
		@endif
	});
	$('.stop-search').click(function(event) {
		window.open('{{url('admin/videochiamate-mensili')}}','_self');
	});
</script>
@endsection
@stop