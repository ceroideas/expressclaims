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

<div class="row">

	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">Utenti</div>
			<div class="panel-body">

				<div class="table-responsive" style="margin-top: 10px">
					<table class="table table-bordered table-striped orderByDate">
						<thead>
							<tr>
								<th style="display: none;"></th>
								<th>ID</th>
								<th>Riferimento Interno</th>
								<th>Perito</th>
								<th>Telefono</th>
								<th>Compagnia</th>
								<th>Cognome Nome</th>
								<th>Email</th>
								<th>Data</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
	                        @foreach (App\SelfManagement::whereExists(function($q){
	                        	$q->from('reservations')
	                        	->whereRaw('reservations.customer_id = self_managements.user_id')
	                        	->whereRaw('reservations.status = 0');
	                        })->whereExists(function($q){
	                        	/*$q->from('users')
	                        	->whereRaw('users.id = self_managements.user_id')
	                        	->whereRaw('users.operator_call_id = '.Auth::user()->id);*/
	                        })->get() as $m)
	                            <tr>
	                            	<td style="display: none">{{@$m->user->lastSinister()->created_at->format('d-m-Y H:i:s')}}</td>
	                            	<td>AP{{ @str_pad(@$m->id,5,0,STR_PAD_LEFT) }}</td>
	                            	<td>{{ @$m->user->lastSinister()->sin_number}}</td>
	                            	<td>{{ App\User::find($m->user->operator_call_id) ? App\User::find($m->user->operator_call_id)->fullname() : '' }}</td>
	                            	<td>{{ $m->code.$m->phone }}</td>
	                            	<td>{{ $m->company }}</td>
	                            	<td>{{ @$m->user->name }}</td>
	                            	<td>{{ @$m->user->email }}</td>
	                            	<td>{{ @$m->status == 0 ? $m->updated_at->format('d-m-Y H:i:s') : '' }}</td>
	                            	{{-- <td>
	                            		<span style="display: none">{{strtotime($m->expiration)}}</span>
	                            		{{ changeDate($m->expiration) }}</td> --}}
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

@stop