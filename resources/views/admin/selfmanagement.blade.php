@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

@php
	function changeDate($date)
	{
		if (!$date) {
			return "";
		}
		$all = explode(" ",$date);
        $date = $all[0];
        $hour = $all[1];

        $t = explode("-",$date);
        $aux = $t[2];
        $t[2] = $t[0];
        $t[0] = $aux;

        $h = explode(":",$hour);

		$f = implode("-",$t)." ".$h[0].':'.$h[1];

		return $f;
	}
@endphp
<style>
	.form-group {
	    margin-bottom: 15px !important;
	}
</style>

<div class="row">
	<div class="col-sm-3">
		
		@isset ($sm)
		<form action="{{ url('admin/self-management',$sm->id) }}" method="post" class="panel send-form">
            <div class="panel-heading">Modificazzione utente autoperizia</div>
		@else
		<form action="{{ url('admin/self-management') }}" method="post" class="panel send-form">
            <div class="panel-heading">Creazione utente autoperizia</div>
		@endisset
			{{ csrf_field() }}
			<div class="panel-body">
				<div class="form-group">
					<label>Cognome Nome</label>
					<input type="text" name="name" class="form-control" value="{{ isset($sm) ? $sm->user->name : '' }}">
				</div>

				<div class="form-group">
					<label>Email</label>
					<input type="email" name="email" class="form-control" value="{{ isset($sm) ? $sm->user->email : '' }}">
				</div>

				<div class="form-group">
					<label>Codice</label>
					<select name="code" class="form-control">
						@include('admin.codes')
					</select>
				</div>

				<div class="form-group">
					<label>Telefono</label>
					<input type="text" name="phone" class="form-control" value="{{ isset($sm) ? $sm->phone : '' }}">
				</div>

				<div class="form-group">
					<label>Riferimento interno</label>
					<input type="text" name="sin_number" class="form-control" value="{{ isset($sm) ? $sm->user->lastSinisterAmb()->sin_number : '' }}">
				</div>

				<div class="form-group">
					<label>Società</label>
					<select name="society" class="form-control">
						<option value="" selected="" disabled=""></option>
						<option {{isset($sm) ? ($sm->society == "Renova" ? "selected" : "") : ""}}>Renova</option>
						<option {{isset($sm) ? ($sm->society == "Studio Zappa" ? "selected" : "") : ""}}>Studio Zappa</option>
						<option {{isset($sm) ? ($sm->society == "Gespea" ? "selected" : "") : ""}}>Gespea</option>
					</select>
				</div>

				<div class="form-group">
					<label>Compagnia</label>
					<select name="company" class="form-control">
						<option value="" selected="" disabled=""></option>
						@foreach (App\Company::all() as $c)
							<option {{isset($sm) ? ($c->name == $sm->company ? 'selected' : '') : ''}} value="{{$c->name}}">{{$c->name}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					@php
						$n = App\Operator::where('ap',1)->get();

						for($i=1;$i<$n->count();$i++)
				        {
			                for($j=0;$j<$n->count()-$i;$j++)
			                {
		                        if($n[$j]->user->lastname() > $n[$j+1]->user->lastname())
		                        {
		                        	$k=$n[$j+1];
		                        	$n[$j+1]=$n[$j];
		                        	$n[$j]=$k;
		                        }
			                }
				        }

					@endphp
					<label>Operatore</label>
					<select name="operator_call_id" class="form-control">
						<option value="" selected="" disabled=""></option>
						@php
							function checkOperator($id)
							{
								return Auth::user()->id == $id ? 'selected' : '';
							}
						@endphp
						@foreach ($n as $u)
							<option {{isset($sm) ? ($u->user_id == $sm->user->operator_call_id ? 'selected' : checkOperator($u->user_id)) : checkOperator($u->user_id)}} required value="{{$u->user_id}}">{{$u->user->fullname()}}</option>
						@endforeach
					</select>
				</div>

				<div class="form-group">
					<label>Validità</label>
					<input size="16" type="text" value="{{isset($sm) ? ($sm->expiration ? changeDate($sm->expiration) : '') : \Carbon\Carbon::now()->addDays(10)->format('d-m-Y H:i')}}" readonly class="form_datetime form-control" name="expiration">
					{{-- <input data-toggle="toggle" data-size="mini" data-on=" " data-off=" " data-onstyle="info" type="checkbox" checked {{ isset($sm) ? ($sm->status == 1 ? 'checked' : '') : '' }}> --}}
				</div>
				
				<div class="alert alert-danger hide" id="error"></div>
				
				<div class="alert alert-success hide" id="success">
                    Utente salvati...
                </div>

				<button class="btn btn-block btn-success">Salva</button>
			</div>
		</form>
	</div>

	<div class="col-sm-9">
		<div class="panel">
			<div class="panel-heading">Utenti</div>
			<div class="panel-body">

				<ul class="nav nav-tabs" role="tablist">
				    <li role="presentation" class="active"><a href="#active" aria-controls="active" role="tab" data-toggle="tab">Solo i link attivi</a></li>
				    <li role="presentation"><a href="#inactive" aria-controls="inactive" role="tab" data-toggle="tab">Solo i link inattivi</a></li>
				</ul>

				<div class="tabbable">

					<div class="tab-content">
					<div class="tab-pane table-responsive active fade in" id="active" style="margin-top: 10px">
						<table class="table table-bordered table-striped orderByDate">
							<thead>
								<tr>
									<th style="display: none;"></th>
									<th>ID</th>
									<th>Riferimento Interno</th>
									{{-- <th>Società</th> --}}
									<th>Telefono</th>
									<th>Compagnia</th>
									<th>Cognome Nome</th>
									<th>Email</th>
									<th>Validità</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
		                        @foreach (App\SelfManagement::where('status',1)->whereExists(function($q){
		                        	$q->from('reservations')
		                        	->whereRaw('reservations.customer_id = self_managements.user_id');
		                        	// ->whereRaw('reservations.status = 0');
		                        })->whereExists(function($q){
		                        	/*$q->from('users')
		                        	->whereRaw('users.id = self_managements.user_id')
		                        	->whereRaw('users.operator_call_id = '.Auth::user()->id);*/
		                        })->where('expiration','>',Carbon\Carbon::now())->get() as $m)
		                            <tr>
		                            	<td style="display: none">{{@$m->user->lastSinisterAmb()->created_at->format('d-m-Y H:i:s')}}</td>
		                            	<td>AP{{ @str_pad(@$m->id,5,0,STR_PAD_LEFT) }}</td>
		                            	<td>{{ @$m->user->lastSinisterAmb()->sin_number}}</td>
		                            	{{-- <td>{{ $m->society }}</td> --}}
		                            	<td>{{ $m->code.$m->phone }}</td>
		                            	<td>{{ $m->company }}</td>
		                            	<td>{{ @$m->user->name }}</td>
		                            	<td>{{ @$m->user->email }}</td>
		                            	<td>
		                            		<span style="display: none">{{strtotime($m->expiration)}}</span>
		                            		{{ changeDate($m->expiration) }}</td>
		                            	<td>
		                            		<a href="#get-link{{$m->id}}" data-toggle="modal" class="btn btn-xs btn-success"><i class="fa fa-link"></i></a>
		                            		<a href="{{ url('admin/self-management-links',$m->id) }}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
		                            		@if (Auth::user()->role_id == -1)
		                            		<a href="#delete-{{$m->id}}" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
		                            		@endif
		                            		<a href="{{url('admin/self-management-data',$m->user_id)}}" target="_blank" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></a>

		                            		<div class="modal fade in" id="delete-{{$m->id}}">
		                            			<div class="modal-dialog modal-sm">
		                            				<div class="modal-content">
		                            					<div class="modal-header">Rimuovi l'utente autoperizia</div>
		                            					<div class="modal-body">
		                            						Questa azione eliminerà l'utente e l'accesso alle informazioni salvate come video e foto.
		                            					</div>
		                            					<div class="modal-footer">
		                            						<a href="{{ url('admin/self-management/delete',$m->id) }}" class="btn btn-xs btn-success">Accettare</a>
		                            						<button class="btn btn-xs btn-warning" data-dismiss="modal">Cancella</button>
		                            					</div>
		                            				</div>
		                            			</div>
		                            		</div>

		                            		<div class="modal fade in" id="get-link{{$m->id}}">
		                            			<div class="modal-dialog modal-sm">
		                            				<div class="modal-content">
		                            					<div class="modal-header">Condividere Link</div>
		                            					<div class="modal-body">
		                            		
		                            						@include('admin.sms_selfmanagement')
		                            					</div>
		                            				</div>
		                            			</div>
		                            		</div>
		                            	</td>
		                            </tr>
		                        @endforeach
							</tbody>
						</table>
					</div>

					<div class="tab-pane table-responsive" id="inactive" style="margin-top: 10px">
						<table class="table table-bordered table-striped orderByDate">
							<thead>
								<tr>
									<th style="display: none;"></th>
									<th>ID</th>
									<th>Riferimento Interno</th>
									{{-- <th>Società</th> --}}
									<th>Telefono</th>
									<th>Compagnia</th>
									<th>Cognome Nome</th>
									<th>Email</th>
									<th>Validità</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
		                        @foreach (
		                        App\SelfManagement::where('status',1)->where('expiration','<',Carbon\Carbon::now())
		                        ->whereExists(function($q){
		                        	$q->from('reservations')
		                        	->whereRaw('reservations.customer_id = self_managements.user_id');
		                        	//->whereRaw('reservations.status = 0');
		                        })->whereExists(function($q){
		                        	/*$q->from('users')
		                        	->whereRaw('users.id = self_managements.user_id')
		                        	->whereRaw('users.operator_call_id = '.Auth::user()->id);*/
		                        })->get() as $m)
		                            <tr>
		                            	<td style="display: none">{{$m->user->lastSinisterAmb()->created_at->format('d-m-Y H:i:s')}}</td>
		                            	<td>AP{{ @str_pad(@$m->id,5,0,STR_PAD_LEFT) }}</td>
		                            	<td>{{ @$m->user->lastSinisterAmb()->sin_number}}</td>
		                            	{{-- <td>{{ $m->society }}</td> --}}
		                            	<td>{{ $m->code.$m->phone }}</td>
		                            	<td>{{ $m->company }}</td>
		                            	<td>{{ @$m->user->name }}</td>
		                            	<td>{{ @$m->user->email }}</td>
		                            	<td>
		                            		<span style="display: none">{{strtotime($m->expiration)}}</span>
		                            		{{ changeDate($m->expiration) }}</td>
		                            	<td>
		                            		<a href="#get-link{{$m->id}}" data-toggle="modal" class="btn btn-xs btn-success"><i class="fa fa-link"></i></a>
		                            		<a href="{{ url('admin/self-management-links',$m->id) }}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
		                            		@if (Auth::user()->role_id == -1)
		                            		<a href="#delete-{{$m->id}}" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
		                            		@endif
		                            		<a href="{{url('admin/self-management-data',$m->user_id)}}" target="_blank" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></a>

		                            		<div class="modal fade in" id="delete-{{$m->id}}">
		                            			<div class="modal-dialog modal-sm">
		                            				<div class="modal-content">
		                            					<div class="modal-header">Rimuovi l'utente autoperizia</div>
		                            					<div class="modal-body">
		                            						Questa azione eliminerà l'utente e l'accesso alle informazioni salvate come video e foto.
		                            					</div>
		                            					<div class="modal-footer">
		                            						<a href="{{ url('admin/self-management/delete',$m->id) }}" class="btn btn-xs btn-success">Accettare</a>
		                            						<button class="btn btn-xs btn-warning" data-dismiss="modal">Cancella</button>
		                            					</div>
		                            				</div>
		                            			</div>
		                            		</div>

		                            		<div class="modal fade in" id="get-link{{$m->id}}">
		                            			<div class="modal-dialog modal-sm">
		                            				<div class="modal-content">
		                            					<div class="modal-header">Condividere Link</div>
		                            					<div class="modal-body">
		                            		
		                            						@include('admin.sms_selfmanagement')
		                            					</div>
		                            				</div>
		                            			</div>
		                            		</div>
		                            	</td>
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

@stop