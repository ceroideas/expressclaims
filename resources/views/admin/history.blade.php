@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<style>
    .modal {
        overflow: auto;
    }
	.well {
        min-height: 20px;
        padding: 8px;
        margin-bottom: 2px;
        background-color: #f5f5f5;
        border: 1px solid #e3e3e3;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
        color: #fff;
    }
    .date-me {
        font-size: 10px;
        margin-bottom: 6px;
        text-align: right;
    }
    .date-notme {
        font-size: 10px;
        margin-bottom: 6px;
    }
    .notme {
        float: left;
        margin-right: 16px;
        position: relative;
        border-radius: 0 4px 4px 4px;
        background-color: #f5a623;
    }
    .notme:after {
        content: " ";
        width: 0;
        height: 0;
        border-right: 8px solid #f5a623;
        border-top: 5px solid transparent;
        border-bottom: 5px solid transparent;
        position: absolute;
        left: -8px;
        top: 36%;
    }
    .me {
        float: right !important;
        margin-left: 16px;
        margin-right: 0;
        border-radius: 4px 0 4px 4px;
        background-color: #4990e2;
    }
    .me:after {
        content: " ";
        width: 0;
        height: 0;
        border-left: 8px solid #4990e2;
        border-top: 5px solid transparent;
        border-bottom: 5px solid transparent;
        position: absolute;
        right: -7px;
        top: 30%;
    }
    .contenedor {
        position: relative;
    }
    .contenedor:after {
        content: "";
        display: block;
        clear: both;
    }
</style>
<input type="hidden" id="nameToUse">
<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">Sinistri chiusi</div>
			<div class="panel-body">
                <form action="{{url('admin/historial')}}" method="GET">
                    <div class="row">
                        @if (session('message'))
                            <div class="col-xs-12">
                                <div class="alert alert-success alert-dismissible show" role="alert">
                                  <strong>Ok!</strong> {!!session('message')!!}
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                            </div>
                        @endif
                        <div class="col-xs-3" style="padding-right: 0">
                            <!-- <label>Ordina per</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <select name="order" class="form-control">
                                        <option value=""></option>
                                        <option {{@$_GET['order'] == "sin_number" ? "selected" : "" }} value="sin_number">Riferimento Interno</option>
                                        {{-- <option {{@$_GET['order'] == "society" ? "selected" : "" }} value="society">Società</option> --}}
                                        <option {{@$_GET['order'] == "users.name" ? "selected" : "" }} value="users.name">Operatore di strada</option>
                                        <option {{@$_GET['order'] == "name" ? "selected" : "" }} value="name">Nome assicurato</option>
                                        {{-- <option {{@$_GET['order'] == "status" ? "selected" : "" }} value="status">Status</option> --}}
                                        <option {{@$_GET['order'] == "created_at" ? "selected" : "" }} value="created_at">Data</option>
                                        {{-- <option {{@$_GET['order'] == "reassingned" ? "selected" : "" }} value="reassingned">Data restituzione</option> --}}
                                        {{-- <option {{@$_GET['order'] == "supervisor" ? "selected" : "" }} value="supervisor">Supervisor</option> --}}
                                    </select>
                                </div>
                                <div class="col-xs-6" style="padding-left: 0;">
                                    <select name="type" class="form-control" id="">
                                        <option value=""></option>
                                        <option {{@$_GET['type'] == "asc" ? "selected" : "" }} value="asc">Ascendente</option>
                                        <option {{@$_GET['type'] == "desc" ? "selected" : "" }} value="desc">Discendente</option>
                                    </select>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-xs-3">
                        </div>
                        <div class="col-xs-3">
                        </div>
                        <div class="col-xs-3">
                            <label for="">Filtro</label>
                            <div class="row">
                                <div class="col-xs-9" style="padding-right: 0">
                                    <input type="text" placeholder="Cerca" name="search" class="form-control" value="{{@$_GET['search']}}">
                                </div>
                                <div class="col-xs-3">
                                    <button class="btn btn-info btn-block">Go</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
				<table class="display_ table table-bordered table-striped table-responsive">
					<thead>
						<tr>
							{{-- <th>ID</th> --}}
                            <th style="display: none"></th>
							<th>ID</th>
                            <th>Riferimento Interno</th>
                            <th>Call Id</th>
                            <th>Nome</th>
                            <th>Operatore</th>
							<th>Telefono</th>
							<th>Ultimo Messaggio</th>
                            <th>Data di creazione</th>
							<th>Numero di sinistri chiusi</th>
                            <th>Sinistri</th>
                            <th>Records</th>
                            <th></th>
						</tr>
					</thead>
					<tbody>
                        @php
                            $claims = App\User::where(function($q) {
                                $q->whereExists(function($q) {
                                    if (Auth::user()->role_id == -1) {
                                        $q->from('customers')
                                        ->whereNotNull('customers.operator_id')
                                        ->whereRaw('customers.user_id = users.id');
                                    }else{
                                        $q->from('customers')
                                        ->whereNotNull('customers.operator_id')
                                        ->whereRaw('customers.user_id = users.id')
                                        ->whereRaw('customers.operator_id = '.Auth::user()->id);
                                    }
                                    $q->whereExists(function($q){
                                        $q->from('reservations')
                                        ->whereRaw('reservations.customer_id = users.id')
                                        ->whereRaw('reservations.status = 1')->where(function($q){
                                            if (isset($_GET['search']) && $_GET['search'] != "") {
                                                $q->where('reservations.sin_number','like','%'.$_GET['search'].'%');
                                                $q->orWhere('users.name','like','%'.$_GET['search'].'%');
                                                $q->orWhere('customers.phone','like','%'.$_GET['search'].'%');
                                            }
                                        });
                                    });
                                });
                            })->orWhere(function($q) {
                                $q->whereExists(function($q){
                                    $q->from('web_app_users')
                                    ->whereRaw('web_app_users.status = 1')
                                    ->whereRaw('web_app_users.user_id = users.id')

                                    ->whereExists(function($q){
                                        $q->from('reservations')
                                        ->whereRaw('reservations.customer_id = users.id')
                                        ->whereRaw('reservations.status = 1')->where(function($q){

                                            if (isset($_GET['search']) && $_GET['search'] != "") {
                                                $q->where('reservations.sin_number','like','%'.$_GET['search'].'%');
                                                $q->orWhere('users.name','like','%'.$_GET['search'].'%');
                                                $q->orWhere('web_app_users.fullphone','like','%'.$_GET['search'].'%');
                                            }
                                        });
                                    });
                                })/*->where(function($q) {
                                    if (!$all) {
                                        $q->where('operator_call_id',Auth::user()->id);
                                    }
                                })*/;
                            })->orderBy('created_at','desc')->paginate(10);
                        @endphp
                        @foreach ($claims as $u)
                            @if ($u->webapp)
                                <tr style="background-color: #f5f5ff">
                                    {{-- <td>{{ $u->id }}</td> --}}
                                    <td style="display: none">
                                        {{strtotime($u->lastSinisterClose()->created_at)}}
                                    </td>
                                    <td>WA{{ str_pad($u->webapp->id,5,0,STR_PAD_LEFT) }}</td>
                                    <td id="sin_numbers">
                                        @forelse (App\Reservation::where('customer_id',$u->id)->where('status','!=',0)->get() as $res)
                                            <li>{{$res->sin_number}}
                                                @if (App\Question::where('reservation_id',$res->id)->get()->last())
                                                    <img src="{{url('assets/icono-0'.App\Question::where('reservation_id',$res->id)->get()->last()->rate.'-b.png')}}" alt="" style="width: 20px;">
                                                @endif
                                            </li>
                                        @empty
                                        @endforelse
                                    </td>
                                    <td>{{ str_pad($u->id,5,0,STR_PAD_LEFT) }}</td>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ App\User::find($u->operator_call_id)->fullname() }}</td>
                                    <td>{{ $u->webapp->code.$u->webapp->phone }}</td>
                                    <td>                                    
                                        @if (strpos(e($u->lastMessageAdmin()),'img') != 0)
                                            Image
                                        @else
                                            <?= $u->lastMessageAdmin(); ?>
                                        @endif
                                            
                                    </td>
                                    <td>
                                        <span style="display: none">{{strtotime($u->lastSinisterClose()->created_at->format('d-m-Y H:i:s'))}}</span> {{$u->lastSinisterClose()->created_at->format('d-m-Y H:i:s')}}
                                    </td>
                                    <td>{{ App\Reservation::where('customer_id',$u->id)->where('status','!=',0)->count() }}</td>
                                    <td>
                                        <button class="btn btn-info btn-xs incidents" data-toggle="modal" data-target="#incidents-{{ $u->id }}"><i class="fa fa-comments-o"></i> Vedi info ({{ App\Reservation::where('customer_id',$u->id)->where('status','!=',0)->count() }})</button>
                                        <div class="modal fade" id="incidents-{{ $u->id }}">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">Incidents: {{ $u->name }}</div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-xs-12 table-responsive" style="height: 100%; position: relative; overflow: auto">
                                                                <table class="table table-bordered table-condensed table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            {{-- <th>ID</th> --}}
                                                                            <th width="20%">Riferimento Interno</th>
                                                                            <th>Informazione</th>
                                                                            <th>Media</th>
                                                                            <th>Status</th>
                                                                            <th>Data</th>
                                                                            <th>Chat</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse (App\Reservation::where('customer_id',$u->id)->where('status','!=',0)->get() as $res)
                                                                            <tr>
                                                                                {{-- <td>{{ $u->id }}</td> --}}
                                                                                <td>
                                                                                    @if ($res->sin_number)
                                                                                        {{ $res->sin_number }}
                                                                                    @else
                                                                                        <form action="{{ url('admin/save-sinister') }}" method="POST">
                                                                                            {{ csrf_field() }}
                                                                                            <input type="hidden" name="sinister_id" value="{{ $res->id }}">
                                                                                            <div class="form-group">
                                                                                                <div class="input-group">
                                                                                                    <input type="text" class="form-control input-sm" name="sin_number" {{ $res->file == "" ? 'disabled' : '' }} required>
                                                                                                    <span class="input-group-btn">
                                                                                                        <button type="submit" {{ $res->file == "" ? 'disabled' : '' }} class="btn btn-success btn-sm">Inviare</button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    @endif
                                                                                </td>
                                                                                <td>---</td>
                                                                                <td>
                                                                                    <a href="{{ url('admin/sinister/videos',$res->id) }}" target="_blank" class="btn btn-info btn-xs">Video</a>
                                                                                    <a href="{{ url('admin/sinister/images',$res->id) }}" target="_blank" class="btn btn-info btn-xs">Images</a>
                                                                                </td>
                                                                                <td>{{ $res->status == 1 ? 'Closed' : 'Open' }}</td>
                                                                                <td>{{ $res->created_at->format('d-m-Y H:i:s') }}</td>
                                                                                <td><button class="btn btn-info btn-xs open-chat"
                                                                                    data-name="{{ $u->name }}"
                                                                                    data-cl="{{ $u->id }}"
                                                                                    data-res="{{ $res->id }}"
                                                                                data-toggle="modal" data-target="#chat-modal"><i class="fa fa-comments-o"></i> Vedi chat</button>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="#delete-sinister-{{$res->sin_number}}" data-toggle="modal" class="btn btn-xs btn-danger">Delete</a>
                                                                                </td>
                                                                            </tr>
                                                                        @empty
                                                                            <tr>
                                                                                <td colspan="6" class="text-center">No incidents to show...</td>
                                                                            </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target="#record-{{ $u->id }}"><i class="fa fa-camera"></i> Vedi Registrazioni</button>
                                        <div class="modal fade" id="record-{{ $u->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">All records - {{ $u->name }}</div>
                                                    <div class="modal-body table-responsive">
                                                        <table class="table display table-hover table-condensed">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Clienti</th>
                                                                    <th>Indirizzo</th>
                                                                    <th>Data</th>
                                                                    <th>Durata</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach (App\Record::where('user_id',$u->id)->get() as $v)
                                                                    <tr>
                                                                        <td>{{ $v->id }}</td>
                                                                        <td>{{ $v->user->name }}</td>
                                                                        <td>{{ $v->address }}</td>
                                                                        <td>{{ $v->created_at->format('d-m-Y H:i:s') }}</td>
                                                                        <td>{{ $v->duration }}</td>
                                                                        <td>
                                                                            <a target="_blank" href="{{ url('uploads/videos',$v->name) }}" class="btn btn-info btn-xs">Vedi</a>
                                                                            <a target='_blank' download href="{{ url('uploads/videos',$v->name) }}" class="btn btn-info btn-xs">Download</a>
                                                                            {{-- <a href="" class="btn btn-danger btn-xs">Delete</a> --}}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a target="_blank" href="{{ url('admin/view-customer',$u->id) }}" class="btn btn-xs btn-info edit_feature">Vedi la pagina</a>

                                        <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#reopen-{{$u->id}}">Riaprire</button>

                                        <div class="modal fade" id="reopen-{{$u->id}}">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">Vuoi riaprire il sinistro selezionato?</div>
                                                    <div class="modal-footer">
                                                        <a href="{{ url('admin/reopenSinister',$u->id) }}" class="btn btn-xs btn-success">Accettare</a>
                                                        <button type="button" data-dismiss="modal" class="btn btn-xs btn-danger">Annullare</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @foreach (App\Reservation::where('customer_id',$u->id)->where('status','!=',0)->get() as $res)
                                    <div class="modal fade" id="delete-sinister-{{$res->sin_number}}">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">Vuoi eliminare il sinistro selezionato? - {{$res->sin_number}}</div>
                                                <div class="modal-footer">
                                                    <a href="{{ url('admin/deleteSinister',$res->id) }}" class="btn btn-xs btn-success">Accettare</a>
                                                    <button type="button" data-dismiss="modal" class="btn btn-xs btn-danger">Annullare</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <tr>
                                    <td style="display: none">
                                        {{strtotime($u->lastSinisterClose()->created_at)}}
                                    </td>
                                    <td>EC{{ str_pad($u->customer->id,5,0,STR_PAD_LEFT) }}</td>
                                    <td id="sin_numbers">
                                        @forelse (App\Reservation::where('customer_id',$u->id)->where('status','!=',0)->get() as $res)
                                            <li>{{$res->sin_number}}</li>
                                        @empty
                                        @endforelse
                                    </td>
                                    <td>{{ str_pad($u->id,5,0,STR_PAD_LEFT) }}</td>
                                    <td>{{ $u->name }}</td>
                                    <td>{{ App\User::find($u->customer->operator_id)->fullname() }}</td>
                                    <td>{{ $u->customer->phone }}</td>
                                    <td>                                    
                                        @if (strpos(e($u->lastMessageAdmin()),'img') != 0)
                                            Image
                                        @else
                                            <?= $u->lastMessageAdmin(); ?>
                                        @endif
                                            
                                    </td>
                                    <td>
                                        <span style="display: none">{{strtotime($u->lastSinisterClose()->created_at->format('d-m-Y H:i:s'))}}</span> {{$u->lastSinisterClose()->created_at->format('d-m-Y H:i:s')}}
                                    </td>
                                    <td>{{ App\Reservation::where('customer_id',$u->id)->where('status','!=',0)->count() }}</td>
                                    <td>
                                        <button class="btn btn-info btn-xs incidents" data-toggle="modal" data-target="#incidents-{{ $u->id }}"><i class="fa fa-comments-o"></i> Vedi info ({{ App\Reservation::where('customer_id',$u->id)->where('status','!=',0)->count() }})</button>
                                        <div class="modal fade" id="incidents-{{ $u->id }}">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">Incidents: {{ $u->name }}</div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-xs-12 table-responsive" style="height: 100%; position: relative; overflow: auto">
                                                                <table class="table table-bordered table-condensed table-striped">
                                                                    <thead>
                                                                        <tr>
                                                                            {{-- <th>ID</th> --}}
                                                                            <th width="20%">Riferimento Interno</th>
                                                                            <th>Informazione</th>
                                                                            <th>Media</th>
                                                                            <th>Status</th>
                                                                            <th>Data</th>
                                                                            <th>Chat</th>
                                                                            <th></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse (App\Reservation::where('customer_id',$u->id)->where('status','!=',0)->get() as $res)
                                                                            <tr>
                                                                                {{-- <td>{{ $u->id }}</td> --}}
                                                                                <td>
                                                                                    @if ($res->sin_number)
                                                                                        {{ $res->sin_number }}
                                                                                    @else
                                                                                        <form action="{{ url('admin/save-sinister') }}" method="POST">
                                                                                            {{ csrf_field() }}
                                                                                            <input type="hidden" name="sinister_id" value="{{ $res->id }}">
                                                                                            <div class="form-group">
                                                                                                <div class="input-group">
                                                                                                    <input type="text" class="form-control input-sm" name="sin_number" {{ $res->file == "" ? 'disabled' : '' }} required>
                                                                                                    <span class="input-group-btn">
                                                                                                        <button type="submit" {{ $res->file == "" ? 'disabled' : '' }} class="btn btn-success btn-sm">Inviare</button>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </form>
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    @if ($res->message != trim(""))
                                                                                        @php
                                                                                            $info = json_decode($res->message,true);
                                                                                        @endphp
                                                                                        <a href="#open-information" data-toggle="modal" class="btn btn-info btn-xs"
                                                                                            data-username="{{$res->user->name}}"
                                                                                            data-phone="{{$res->user->customer->phone}}"
                                                                                            data-sin_number="{{$res->sin_number}}"
                                                                                            data-lastname="{{$info['lastname']}}"
                                                                                            data-name="{{$info['name']}}"
                                                                                            data-bdate="{{$info['bdate']}}"
                                                                                            data-sdata="{{$info['sdata']}}"
                                                                                            data-quality="{{$info['quality']}}"
                                                                                            data-typology="{{$info['typology']}}"
                                                                                            data-goods="{{$info['goods']}}"
                                                                                            data-unity="{{$info['unity']}}"
                                                                                            data-cond="{{$info['cond']}}"
                                                                                            data-cdenomination="{{$info['cdenomination']}}"
                                                                                            data-cphone="{{$info['cphone']}}"
                                                                                            data-cemail="{{$info['cemail']}}"
                                                                                            data-surface="{{$info['surface']}}"
                                                                                            data-title="{{$info['title']}}"
                                                                                            data-damage="{{$info['damage']}}"
                                                                                            data-residue="{{$info['residue']}}"
                                                                                            data-other="{{$info['other']}}"
                                                                                            data-third="{{$info['third']}}"
                                                                                            data-thirddamage="{{$info['thirddamage']}}"
                                                                                            data-import="{{$info['import']}}"
                                                                                            data-iban="{{$info['iban']}}"
                                                                                        >Info sinistro</a>
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    <a href="{{ url('admin/sinister/videos',$res->id) }}" target="_blank" class="btn btn-info btn-xs">Video</a>
                                                                                    <a href="{{ url('admin/sinister/images',$res->id) }}" target="_blank" class="btn btn-info btn-xs">Images</a>
                                                                                </td>
                                                                                <td>{{ $res->status == 1 ? 'Closed' : 'Open' }}</td>
                                                                                <td>{{ $res->created_at->format('d-m-Y H:i:s') }}</td>
                                                                                <td><button class="btn btn-info btn-xs open-chat"
                                                                                    data-name="{{ $u->name }}"
                                                                                    data-cl="{{ $u->id }}"
                                                                                    data-res="{{ $res->id }}"
                                                                                data-toggle="modal" data-target="#chat-modal"><i class="fa fa-comments-o"></i> Vedi chat</button>
                                                                                </td>
                                                                                <td>
                                                                                    <a href="#delete-sinister-{{$res->sin_number}}" data-toggle="modal" class="btn btn-xs btn-danger">Delete</a>
                                                                                </td>
                                                                            </tr>
                                                                        @empty
                                                                            <tr>
                                                                                <td colspan="6" class="text-center">No incidents to show...</td>
                                                                            </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><button class="btn btn-info btn-xs" data-toggle="modal" data-target="#record-{{ $u->id }}"><i class="fa fa-camera"></i> Vedi Registrazioni</button>
                                        <div class="modal fade" id="record-{{ $u->id }}">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">All records - {{ $u->name }}</div>
                                                    <div class="modal-body table-responsive">
                                                        <table class="table display table-hover table-condensed">
                                                            <thead>
                                                                <tr>
                                                                    <th>ID</th>
                                                                    <th>Clienti</th>
                                                                    <th>Indirizzo</th>
                                                                    <th>Data</th>
                                                                    <th>Durata</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach (App\Record::where('user_id',$u->id)->get() as $v)
                                                                    <tr>
                                                                        <td>{{ $v->id }}</td>
                                                                        <td>{{ $v->user->name }}</td>
                                                                        <td>{{ $v->address }}</td>
                                                                        <td>{{ $v->created_at->format('d-m-Y H:i:s') }}</td>
                                                                        <td>{{ $v->duration }}</td>
                                                                        <td>
                                                                            <a target="_blank" href="{{ url('uploads/videos',$v->name) }}" class="btn btn-info btn-xs">Vedi</a>
                                                                            <a target='_blank' download href="{{ url('uploads/videos',$v->name) }}" class="btn btn-info btn-xs">Download</a>
                                                                            {{-- <a href="" class="btn btn-danger btn-xs">Delete</a> --}}
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a target="_blank" href="{{ url('admin/view-customer',$u->id) }}" class="btn btn-xs btn-info edit_feature">Vedi la pagina</a>

                                        <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#reopen-{{$u->id}}">Riaprire</button>

                                        <div class="modal fade" id="reopen-{{$u->id}}">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">Vuoi riaprire il sinistro selezionato?</div>
                                                    <div class="modal-footer">
                                                        <a href="{{ url('admin/reopenSinister',$u->id) }}" class="btn btn-xs btn-success">Accettare</a>
                                                        <button type="button" data-dismiss="modal" class="btn btn-xs btn-danger">Annullare</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @foreach (App\Reservation::where('customer_id',$u->id)->where('status','!=',0)->get() as $res)
                                    <div class="modal fade" id="delete-sinister-{{$res->sin_number}}">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">Vuoi eliminare il sinistro selezionato? - {{$res->sin_number}}</div>
                                                <div class="modal-footer">
                                                    <a href="{{ url('admin/deleteSinister',$res->id) }}" class="btn btn-xs btn-success">Accettare</a>
                                                    <button type="button" data-dismiss="modal" class="btn btn-xs btn-danger">Annullare</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
					</tbody>
				</table>
                @php
                    $claims->setPath('?search='.@$_GET['search'] )
                @endphp
                {{$claims->links()}}
			</div>
		</div>
	</div>
</div>

@foreach ($claims as $u)
    @if (!$u->webapp)
        @php
            $o = App\User::find($u->customer->operator_id);
            $sha1 = sha1(sha1($u->email.$o->email));
        @endphp
        @foreach (App\Reservation::where('customer_id',$u->id)->where('status','!=',0)->get() as $res)
            <div class="modal fade" id="share-{{ $res->id }}">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">Condivisione sinistro</div>
                        <div class="modal-body">
                            <input type="text" class="share-email form-control" placeholder="E-mail" value="{{ $u->email }}" style="width: 100%">
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-xs btn-warning">Annullare</button>
                            <button class="btn btn-xs btn-success share-btn"
                                data-op="{{ $o->id }}"
                                data-name="{{ $u->name }}"
                                data-res="{{ $res->id }}"
                                data-id="{{ $u->id }}"
                                data-sha1="{{ $sha1 }}"
                            >Accettare</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="reopen-{{ $res->id }}">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-header">Riaprire sinistro</div>
                        <div class="modal-body">
                            Vuoi riaprire sinistro selezionato?
                        </div>
                        <div class="modal-footer">
                            <button data-dismiss="modal" class="btn btn-xs btn-warning">Annullare</button>
                            <button class="btn btn-xs btn-success reopen-btn"
                                data-res="{{ $res->id }}"
                                data-id="{{ $u->id }}"
                            >Accettare</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
@endforeach

<div class="modal fade" id="chat-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">Chat</div>
            <div class="modal-body" style="max-height: 90vh;overflow: auto;">
                <div class="row">
                    <div class="col-xs-12" id="messages" style="height: 100%; position: relative; overflow: auto">
                        Caricamento dei messaggi...
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="open-information">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">Information <button class="btn btn-info btn-xs" id="btn-print">Export</button></div>
            <div class="modal-body printArea">
                <h5 id="info-name"></h5>
                <h5 id="info-phone"></h5>
                <h5 id="info-sinister"></h5>
                <hr>
                <li><b>1 - Per cortesia, la invitiamo ad identificarsi: </b>
                    <ul id="info-1"></ul></li>
                <li><b>2 - Data di accadimento del sinistro: </b>
                    <ul id="info-2"></ul></li>
                <li><b>3 - Lei interviene nella definizione de sinistro in qualità di: </b>
                    <ul id="info-3"></ul></li>
                <li><b>4 - Che tipologia di danno ha subito ? </b>
                    <ul id="info-4"></ul></li>
                <li><b>5 - Quali beni hanno subito danni ? </b>
                    <ul id="info-5"></ul></li>
                <li><b>6 - L'unita immobiliare assicurata è: </b>
                    <ul id="info-6"></ul></li>
                <li><b>7 - Qualora l'unità immobiliare assicurata faccia parte di un condominio, a che piano è ubicata ? (se non è in condominio scriva semplicemente NO) </b>
                    <ul id="info-7"></ul></li>
                <li><b>8 - Qualora l'unità immobiliare assicurata faccia parte di un condominio, ci indichi i riferimenti dell'amministratore condominiale (se non è in condominio scriva semplicemente NO alle tre successive domande) </b>
                    <ul id="info-8"></ul></li>
                <li><b>9 - Qual è la superficie complessiva dell'unità immobiliare assicurata? (dati in mq. senza considerare balconi, terrazze e gairdini) </b>
                    <ul id="info-9"></ul></li>
                <li><b>10 - In forza di quale titolo conduce l'appartamento ? </b>
                    <ul id="info-10"></ul></li>
                <li><b>11 - I riprisinti del danno sono già stati effettuati ? </b>
                    <ul id="info-11"></ul></li>
                <li><b>12 - I residui del sinistro sono visibili ? </b>
                    <ul id="info-12"></ul></li>
                <li><b>13 - Lei ha contratto altre assicurazioni a copertura del medesimo rischio colpito dal presente sinistro ? qualora ne disponga la invitiamo ad inviare foto / pdf del frontespizio di polizza tramite la successiva schermata </b>
                    <ul id="info-13"></ul></li>
                <li><b>14 - E' a conoscenza se vi sono altre polizza assicurative contratte da terzi a copertura del presente rischio (ad esempio polizza del condominio o della proprietà) ? </b>
                    <ul id="info-14"></ul></li>
                <li><b>15 - E' a conoscenza se vi sono terzi danneggiati in conseguenza al sinistro in oggetto ? </b>
                    <ul id="info-15"></ul></li>
                <li><b>16 - Ammontare approssimativo del danno subito </b>
                    <ul id="info-16"></ul></li>
                <li><b>17 - Per favore ci fornisca di seguito il suo IBAN: si precisa che tale richiesta avanzata in sede di istruttoria della posizione non implica che il suo sinistro sia indennizzabile </b>
                    <ul id="info-17"></ul></li>
            </div>
            {{-- <div class="modal-footer"></div> --}}
        </div>
    </div>
</div>
@section('scripts')
    <script>
    var actual_modal;
    $('.incidents').click(function(event) {
        console.log($(this).data())
        actual_modal = $(this).data('target');
    });
    $('[data-target="#chat-modal"]').click(function(event) {
        $('[id*=incidents-]').modal('hide');
    });
    $('#chat-modal').on('hidden.bs.modal', function () {
      $(actual_modal).modal('show');
    });
    $('.condivisione, .reopen').click(function(event) {
        $('[id*=incidents-]').modal('hide');
    });
    $('[id*=share-').on('hidden.bs.modal', function () {
      $(actual_modal).modal('show');
    });
    $('[id*=reopen-').on('hidden.bs.modal', function () {
      $(actual_modal).modal('show');
    });
    $('[href="#open-information"]').click(function(event) {
        $('[id*=incidents-]').modal('hide');
    });
    $('#open-information').on('hidden.bs.modal', function () {
      $(actual_modal).modal('show');
    });

    $('[href*="#delete-sinister"]').click(function(event) {
        $('[id*=incidents-]').modal('hide');
    });
    $('[id*="delete-sinister"]').on('hidden.bs.modal', function () {
      $(actual_modal).modal('show');
    });

    /**/
        $('[href="#open-information"]').click(function(event) {
            $('#info-name').html('<b>Nome: </b>'+$(this).data('username'));
            $('#info-phone').html('<b>Telefono: </b>'+$(this).data('phone'));
            $('#info-sinister').html('<b>Riferimento Interno: </b>'+$(this).data('sin_number'));
            $('#info-1').html(
                "<li> <b>- Cognome: </b>"+$(this).data('lastname')+"</li>\
                <li> <b>- Nome: </b>"+$(this).data('name')+"</li>\
                <li> <b>- Data di nascita: </b>"+$(this).data('bdate')+"</li>"
            );

            $('#info-2').html(
                "<li>"+$(this).data('sdata')+"</li>"
            );

            $('#info-3').html(
                "<li>"+$(this).data('quality')+"</li>"
            );
            var resp;
            if ($(this).data('typology') == 1) {resp = "Danno d'acqua condotta";}
            if ($(this).data('typology') == 2) {resp = "Fenomeno elettrico";}
            if ($(this).data('typology') == 3) {resp = "Evento atmosferico";}
            if ($(this).data('typology') == 4) {resp = "Guasti ladri";}
            if ($(this).data('typology') == 5) {resp = "Atti vandalici";}
            if ($(this).data('typology') == 6) {resp = "Incendio";}
            if ($(this).data('typology') == 7) {resp = "Furto";}
            if ($(this).data('typology') == 8) {resp = "Altro";}

            $('#info-4').html(
                "<li>"+resp+"</li>"
            );

            $('#info-5').html(
                "<li>"+$(this).data('goods')+"</li>"
            );

            $('#info-6').html(
                "<li>"+$(this).data('unity')+"</li>"
            );

            $('#info-7').html(
                "<li>"+$(this).data('cond')+"</li>"
            );

            $('#info-8').html(
                "<li> <b>- Denominazione: </b>"+$(this).data('cdenomination')+"</li>\
                <li> <b>- Telefono: </b>"+$(this).data('cphone')+"</li>\
                <li> <b>- E-mail: </b>"+$(this).data('cemail')+"</li>"
            );

            $('#info-9').html(
                "<li>"+$(this).data('surface')+"</li>"
            );

            $('#info-10').html(
                "<li>"+$(this).data('title')+"</li>"
            );

            $('#info-11').html(
                "<li>"+$(this).data('damage')+"</li>"
            );

            $('#info-12').html(
                "<li>"+$(this).data('residue')+"</li>"
            );

            $('#info-13').html(
                "<li>"+$(this).data('other')+"</li>"
            );

            $('#info-14').html(
                "<li>"+$(this).data('third')+"</li>"
            );

            $('#info-15').html(
                "<li>"+$(this).data('thirddamage')+"</li>"
            );

            $('#info-16').html(
                "<li>"+$(this).data('import')+"</li>"
            );

            $('#info-17').html(
                "<li>"+$(this).data('iban')+"</li>"
            );
        });
        function downloadFromChat() {
            function makeid() {
              // var text = "";
              // var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

              // for (var i = 0; i < 8; i++)
              //   text += possible.charAt(Math.floor(Math.random() * possible.length));

              // return text;
                var today = new Date();
                var dd = today.getDate();var mm = today.getMonth()+1;var yyyy = today.getFullYear();
                var hh = today.getHours();var ii = today.getMinutes();var ss = today.getSeconds();
                if(dd<10) {dd = '0'+dd} 
                if(mm<10) {mm = '0'+mm} 
                today = dd + '/' + mm + '/' + yyyy + '-' + hh + ':' + ii + ':' + ss;
                return $('#nameToUse').val()+'-'+today;
            }
            download($(this).attr('src'), makeid()+'.jpg', 'image/jpeg');
        }

        $('.open-chat').click(function(event) {
            $('#messages').html('Caricamento dei messaggi...');
            $('#nameToUse').val($(this).data('name'))
            $.post('{{ url('admin/open_chat') }}', {_token: '{{ csrf_token() }}', id: $(this).data('cl'), res: $(this).data('res')}, function(data, textStatus, xhr) {
                console.log('messages',data)
                var html = "";
                if (data.length == 0) {
                    html = ' <h3 class="text-center">No messages to show...</h3>';
                }
                $.each(data, function(index, val) {
                    if (val.from.name == '{{ Auth::user()->name }}') {
                        html += '<div class="contenedor"><div class="well me"><span class="label label-success">'+val.from.name+':</span> '+val.message+'</div></div><div class="date-me">'+val.created+'</div>';
                    }else{
                        html += '<div class="contenedor"><div class="well notme"><span class="label label-danger">'+val.from.name+':</span> '+val.message+'</div></div><div class="date-notme">'+val.created+'</div>';
                    }
                });

                $('#messages').html(html);
                setTimeout(()=>{
                    $('#messages').scrollTop($('#messages')[0].scrollHeight);
                },100)

                $('.well.notme img,.well.me img').click(downloadFromChat);
            });
        });
        $('.share-btn').click(function(event) {
            var email = $(this).parent().prev().find('input').val(),
            url = '{{ url('utente') }}/'+$(this).data('id')+'/'+$(this).data('op')+'/'+$(this).data('res')+'/'+$(this).data('sha1');

            if (email == "") {
                return alert('Scrivi una mail per condividere')
            }
            $.post('{{ url('admin/share') }}', {url: url, email: email, name: $(this).data('name'), _token: '{{ csrf_token() }}'}, function(data, textStatus, xhr) {
                $('[id*="share-').modal('hide')
                (new PNotify({
                    title: 'Condivisione',
                    text: "Il collegamento con l'utente è stato condiviso",
                    type: 'success',
                    desktop: {
                        desktop: false
                    }
                })).get().click(function(e) {
                    // if ($('.ui-pnotify-closer, .ui-pnotify-sticker, .ui-pnotify-closer *, .ui-pnotify-sticker *').is(e.target)) return;
                    // alert('Hey! You clicked the desktop notification!');
                });
            });
        });
        $('.reopen-btn').click(function(event) {
            var id = $(this).data('id');
            var res = $(this).data('res');
            $.post('{{ url('admin/reopen') }}', {res: res, id: id, _token: '{{ csrf_token() }}'}, function(data, textStatus, xhr) {
                location.reload();
            }).fail(function(err){
                console.log(err);
                alert(JSON.parse(err.responseText)[0]);
            });
        });
    </script>
    <script>
        $('#btn-print').click(function(event) {
            $(".printArea").printArea();
        });
    </script>
@endsection
@stop