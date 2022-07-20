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

	$webappusers = App\WebAppUser::whereExists(function($q){
    	$q->from('users')
    	  ->whereRaw('users.id = web_app_users.user_id')->whereExists(function($q){

	    	$q->from('reservations')
	    	->whereRaw('reservations.customer_id = web_app_users.user_id')->where(function($q){
	        	if (isset($_GET['search']) && $_GET['search'] != "") {
	                $q->where('reservations.sin_number','like','%'.$_GET['search'].'%');
	                $q->orWhere('users.name','like','%'.$_GET['search'].'%');
	                $q->orWhere('web_app_users.phone','like','%'.$_GET['search'].'%');
	            }
	        })
	    	//->whereRaw('reservations.status = 0')
	    	;
    	  });
    })->whereExists(function($q){
    	/* $q->from('users')
    	->whereRaw('users.id = web_app_users.user_id')
    	->whereRaw('users.operator_call_id = '.Auth::user()->id);*/
    })->paginate(10)
@endphp

<div class="row">

	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">Clienti webapp</div>
			<div class="panel-body">

				<div class="row">
                    <div class="col-xs-9">
                    </div>
                    <div class="col-xs-3">
                        <label for="">Filtro</label>
                        <div class="row">
                        	<form action="{{url('admin/web-app-2')}}" method="GET">
	                            <div class="col-xs-9" style="padding-right: 0">
	                                <input type="text" placeholder="Cerca" name="search" class="form-control" value="{{@$_GET['search']}}">
	                            </div>
	                            <div class="col-xs-3">
	                                <button class="btn btn-info btn-block">Go</button>
	                            </div>
	                        </form>
                        </div>
                    </div>
                </div>

				<div class="table-responsive" style="margin-top: 10px">
					<table class="table table-bordered table-striped orderByDate-">
						<thead>
							<tr>
								<th style="display: none;"></th>
								<th>ID</th>
								<th>Riferimento Interno</th>
								{{-- <th>Call Id</th> --}}
								{{-- <th>Società</th> --}}
								<th>Operatore</th>
								<th>Telefono</th>
								<th>Compagnia</th>
								<th>Cognome Nome</th>
								<th>Email</th>
								{{-- <th>Validità</th> --}}
								<th>Data</th>
								<th>Estato</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
	                        @foreach ($webappusers as $w)
	                            <tr>
	                            	<td style="display: none">
	                            		{{$w->user->lastSinister() ? $w->user->lastSinister()->created_at->format('d-m-Y H:i:s') :
	                            		 ($w->user->lastSinisterClose() ? $w->user->lastSinisterClose()->created_at->format('d-m-Y H:i:s') : '')}}</td>
	                            	<td>WA{{ @str_pad(@$w->id,5,0,STR_PAD_LEFT) }}</td>
	                            	<td>{{$w->user->lastSinister() ? $w->user->lastSinister()->sin_number :
	                            		 ($w->user->lastSinisterClose() ? $w->user->lastSinisterClose()->sin_number : '')}}</td>
	                            	{{-- <td>{{ @str_pad(@$w->user_id,5,0,STR_PAD_LEFT) }}</td> --}}
	                            	{{-- <td>{{ $w->society }}</td> --}}
	                            	<td>{{ App\User::find($w->user->operator_call_id) ? App\User::find($w->user->operator_call_id)->fullname() : '' }}</td>
	                            	<td>{{ $w->code.$w->phone }}</td>
	                            	<td>{{ $w->company }}</td>
	                            	<td>{{ @$w->user->name }}</td>
	                            	<td>{{ @$w->user->email }}</td>
	                            	<td>{{ $w->callDate() }}</td>
	                            	<td>{{ $w->generalStatus() }}</td>
	                            	<td>
	                            		<a href="{{ url('admin/web-app',$w->id) }}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
	                            		@if (Auth::user()->role_id != -1)
	                            			<a href="{{ url('admin/videocalls?webapp-user='.@$w->user_id) }}" target="_blank" class="btn btn-xs btn-warning"><i class="fa fa-video-camera"></i></a>
	                            		@endif
	                            		{{-- @if (Auth::user()->role_id != -1) --}}
	                            			<a href="{{ url('admin/sinister/images',($w->user->lastSinister() ? $w->user->lastSinister()->id : ($w->user->lastSinisterClose() ? $w->user->lastSinisterClose()->id : ''))) }}" target="_blank" class="btn btn-xs btn-success"><i class="fa fa-eye"></i></a>
	                            		{{-- @endif --}}
	                            		{{-- @if (Auth::user()->role_id == -1)
	                            		<a href="#delete-{{$w->id}}" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
	                            		@endif

	                            		<div class="modal fade in" id="delete-{{$w->id}}">
	                            			<div class="modal-dialog modal-sm">
	                            				<div class="modal-content">
	                            					<div class="modal-header">Rimuovi l'utente webapp</div>
	                            					<div class="modal-body">
	                            						Questa azione eliminerà l'utente e l'accesso alle informazioni salvate come video e foto.
	                            					</div>
	                            					<div class="modal-footer">
	                            						<a href="{{ url('admin/web-app/delete',$w->id) }}" class="btn btn-xs btn-success">Accettare</a>
	                            						<button class="btn btn-xs btn-warning" data-dismiss="modal">Cancella</button>
	                            					</div>
	                            				</div>
	                            			</div>
	                            		</div> --}}
	                            	</td>
	                            </tr>
	                        @endforeach
						</tbody>
					</table>

					@php
	                    $webappusers->setPath('?search='.@$_GET['search'] )
	                @endphp
					{{$webappusers->links()}}
				</div>
			</div>
		</div>
	</div>
</div>

@stop