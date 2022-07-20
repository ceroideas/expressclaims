@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')
<style>
    canvas{
        display: none;
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
    #load-border {
        width:  100%;
        height:  30px;
        border-top: 1px solid;
    }
    #load-border #load-bar {
        height: 100%;
        background-color: lightblue;
        width: 0;
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
    .well.notme img,.well.me img{
        cursor: pointer;
    }
    .contenedor {
        position: relative;
    }
    .contenedor:after {
        content: "";
        display: block;
        clear: both;
    }
    #myRemoteVideo {
        position: relative;
    }
    #stage {
        overflow: hidden;
        height: calc(100% - 133px);
        width: 100%;
        position: absolute;
    }

    .modal-edit .form-control {
        width: 100% !important;
    }

    /**/

    .line {
        border-right: 3px solid #f5a623;
    }

    .btn-circle {
        border-radius: 50px;
        height: 60px;
        width: 60px;
    }

    #call, #hangup {
        top: 18px;
        position: relative;
    }
    .dot-in-call {
        width: 18px;
        height: 18px;
        border-radius: 39px;
        background-color: #81d223;
        display: inline-block;
    }
    #send_my_message {
        color: #f5a623;
        background-color: transparent;
        border: none !important;
    }
    .btn-paperclip {
        color: #ccc;
        background-color: transparent;
        border: none !important;
    }
    #my_message {
        border: none;
        background-color: transparent;
    }
    #chat-input {
        border: 2px solid #aaa;
    }
    #mini video {
        /*opacity: 0;*/
        width: 96px !important;
        height: 96px !important;
        /*margin: 15px;*/
        z-index: 9999;
        position: relative;
        float:right;
    }
    .green {
        color: lightgreen;
    }
    .toggle-handle {
        background-color: #fff !important;
    }

    /*#modal-edit-info .modal-dialog {
      position: fixed;
      margin: 0;
      padding: 10px;
    }*/
    [id*="modal-view-info"] .modal-dialog .modal-content {
        box-shadow: 0px 0px 5px silver;
    }

    [id*="modal-edit-info"] .modal-dialog .modal-content {
        box-shadow: 0px 0px 5px silver;
    }
    #panel1 {
        height: 16vh;
    }
</style>
@php
    $inside_call_page = true;
@endphp
<input type="hidden" id="latToSave">
<input type="hidden" id="lonToSave">
<input type="hidden" id="nameToUse">
<input type="hidden" id="can_call" value="1">
<div class="row">
    <div class="col-md-6 line-">
        <div class="panel">
            <div class="panel-heading" style="position: relative;">Video Chat <button class="hidden btn btn-xs btn-info" style="position: absolute;" >Take snapshot</button>
                 <span class="pull-right"><b>Data:</b> {{ date('d-m-Y') }}</span>
            </div>
            <div class="panel-body call-panel" id="panel2" style="position: relative;">
              <div id="mini">
                {{-- <video id="myMiniVideo" autoplay="autoplay" muted="0" volume="0"></video> --}}
            </div>
              {{-- Please, change the camera [FRONT] [REAR] --}}
              <div id="stage">
                  <div id="controls" style="position: absolute;z-index: 9999;"></div>
                  <img src="{{ url('rotate.png') }}" alt="" class="hidden" width="50px" id="changeCamera" style="position: absolute; right: 10px; bottom: 10px;z-index: 9999; cursor: pointer;">
                  <img src="{{ url('camera.png') }}" alt="" class="hidden" width="50px" id="takeSnapshot" style="position: absolute; left: 10px; bottom: 22px;z-index: 9999; cursor: pointer;">
                  <div id="myRemoteVideo">
                  </div>
              </div>
                <div class="panel-body">
                    <div class="row" style="position: absolute; bottom: 0; width: 100%; padding: 16px 0; background: #fff;">
                        <div class="col-xs-12">
                            <input type="hidden" id="user_id" data-url="{{ url('admin/see-user-status') }}">
                            <input type="hidden" id="inCall_user_id">
                            <input type="hidden" id="number">
                            <div class="input-group">
                                <span class="input-group-addon" style="border: 1px solid #e2e2e4">Nome:</span>
                                <input type="text" id="user_name" value="" disabled="" placeholder="Utente da chiamare..." class="form-control"/>
                            </div>
                            <div class="row" style="margin-top: 8px;">
                                <div class="col-xs-4">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-success btn-block dropdown-toggle" data-toggle="dropdown" id="call" type="button" disabled="true">Connessione con il server...</button>
                                        <ul class="dropdown-menu" style="top: 48px;">
                                            <li><a href="#" id="video-call">Videochiamata</a></li>
                                            {{-- <li><a href="#" id="video-call">Videochiamata</a></li> --}}
                                            <li><a href="#" id="audio-call">Chiamata Audio</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <button class="btn btn-sm btn-primary btn-circle" id="inicio" type="button" ><span id="minutos">00</span>:<span id="segundos">00</span></button>
                                </div>
                                <div class="col-xs-4">
                                    <input class="btn btn-sm btn-danger btn-block" id="hangup" type="button" disabled="true" value="Riattacca" />
                                </div>
                            </div>
                            {{-- <span id="status"></span> --}}
                        </div>

                        <div class="col-sm-12 col-sm-6 col-lg-6">
                           <div id="hangupButtons"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <span class="hide" id="myCallId"></span>
        <div class="panel">
            <div class="panel-heading">
                {{-- <a href="javascript:;" data-toggle="tab" data-target="#clients">Elenco di clienti</a> | <a href="javascript:;" data-toggle="tab" data-target="#wapp-clients">Web App clienti</a> --}}
                <div class="row">
                    <div class="col-sm-6">
                        Elenco di clienti
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group" style="right:8px;top:-6px; position: absolute;">
                            <input type="text" class="form-control" name="search" placeholder="Ricerca">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-info start-search"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-body call-panel" id="panel1" style="position: relative;">
                <div class="row" style="position: relative; /*height: calc(100% - 104px);*/">
                    <div class="col-xs-12 clients table-responsive" style="/*height: 100%;*/ position: relative; overflow: auto">

                        <div class="tabbable">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="clients">
                                    <table class="table operator table-hover table-condensed">
                                        <thead>
                                            <tr>
                                                <th style="display: none;"></th>
                                                <th>Rif. interno</th>
                                                <th>Call Id</th>
                                                {{-- <th>Id</th> --}}
                                                <th>Nome</th>
                                                <th>Registrazioni</th>
                                                {{-- <th>Attiva Chiamata</th> --}}
                                                {{-- <th>Chiamata in corso</th> --}}
                                                <th>Opzioni</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody id="load-just-here">
                                            @if (isset($_GET['webapp-user']))
                                                @php
                                                    $users = App\User::where('id',$_GET['webapp-user'])->whereExists(function($q){
                                                        $q->from('web_app_users')
                                                        ->whereRaw('web_app_users.status = 1')
                                                        ->whereRaw('web_app_users.user_id = users.id')
                                                        ->where('web_app_users.expiration','>',Carbon\Carbon::now()->format('Y-m-d H:i:s'));
                                                    })->whereExists(function($q){
                                                        // $q->from('reservations')
                                                        //   ->whereRaw('reservations.customer_id = users.id')
                                                        //   ->whereRaw('reservations.status = 0')
                                                        //   ->whereRaw('reservations.sin_number != ""');
                                                    })->get();

                                                    if (count($users) == 0) {
                                                        echo "<script>
                                                            alert('Sinister closed or not found!');
                                                        </script>";
                                                    }
                                                @endphp
                                            @elseif(isset($_GET['incoming_call']))
                                                @php
                                                    $users = App\User::where('id',$_GET['incoming_call'])->get();
                                                @endphp
                                            @else
                                                @php
                                                    $users = [];/*App\User::where('role_id',0)->where(function($q){
                                                    $q->where('operator_call_id',Auth::user()->id)->orWhereExists(function($q){
                                                        $q->from('customers')
                                                          ->whereRaw('customers.user_id = users.id')
                                                          ->whereRaw('operator_id = '.Auth::user()->id);
                                                        });
                                                    })->whereExists(function($q){
                                                        $q->from('reservations')
                                                          ->whereRaw('reservations.customer_id = users.id')
                                                          ->whereRaw('reservations.status = 0')
                                                          ->whereRaw('reservations.sin_number != ""');
                                                    })->where(function($q){
                                                        if (isset($_GET['webapp-user'])) {
                                                            $q->where('id',$_GET['webapp-user']);
                                                        }
                                                    })->orderBy('created_at','desc')->get();*/
                                                @endphp
                                            @endif
                                            @forelse ($users as $u)
                                                @if ($u->lastSinister())
                                                @php
                                                    $res = App\Reservation::where(['customer_id' => $u->id, 'status' => 0])->first();
                                                @endphp
                                                <tr data-id="{{ $u->id }}" data-name="{{ $u->name }}" style="{{$u->webapp ? 'background-color: #f5f5ff' : ''}}">
                                                    <td style="display: none">{{ strtotime($u->lastSinister()->created_at->format('d-m-Y H:i:s')) }}</td>
                                                    <td class="select-user {{$u->webapp ? 'webappuser' : ''}}" data-id="{{ $u->id }}" id="call_id-{{ $u->id }}">{{$u->lastSinister()->sin_number}}</td>
                                                    <td class="select-user {{$u->webapp ? 'webappuser' : ''}}" data-id="{{ $u->id }}" id="call_id-{{ $u->id }}">{{ str_pad($u->id,5,0,STR_PAD_LEFT) }}</td>
                                                    <td class="select-user {{$u->webapp ? 'webappuser' : ''}}" data-id="{{ $u->id }}">
                                                        <i id="dot-online-{{ $u->id }}" class="fa fa-dot-circle-o green hide" title="User online"></i>
                                                        <span class="select-name">{{$u->name}}</span>
                                                    </td>
                                                    <td class="select-user {{$u->webapp ? 'webappuser' : ''}}" data-id="{{ $u->id }}">
                                                        <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#records-{{ $u->id }}">Vedere</button>
                                                        <div class="modal fade" id="records-{{ $u->id }}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        Chiamate Registrate
                                                                    </div>
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
                                                                            <tbody id="videos-{{ $u->id }}">
                                                                                @foreach (App\Record::where('user_id',$u->id)->whereExists(function($q){
                                                                                    $q->from('reservations')
                                                                                      ->whereRaw('reservations.id = records.reservation_id')
                                                                                      ->whereRaw('reservations.status = 0');
                                                                                })->get() as $v)
                                                                                    <tr>
                                                                                        <td>{{ $v->id }}</td>
                                                                                        <td>{{ $v->user->name }}</td>
                                                                                        <td>{{ $v->address }}</td>
                                                                                        <td>{{ $v->created_at->format('d-m-Y H:i:s') }}</td>
                                                                                        <td>{{ $v->duration }}</td>
                                                                                        <td id="links-{{$v->id}}">
                                                                                            @if (strpos($v->name,'.mp4'))
                                                                                                <a href="{{ url('uploads/videos',$v->name) }}" target="_blank" class="btn btn-info btn-xs">View</a>
                                                                                                {{-- <a target='_blank' download href="{{ url('uploads/videos',$v->name) }}" class="btn btn-info btn-xs">Download</a> --}}
                                                                                            @else
                                                                                                <button data-id="{{$v->id}}" class="btn btn-info btn-xs convertMp4">View</button>
                                                                                                {{-- <button data-id="{{$v->id}}" data-href="{{ url('uploads/videos',$v->name) }}" class="btn btn-info btn-xs downloadMp4">Download</button> --}}
                                                                                            @endif
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="modal-footer"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    {{-- <td>
                                                        @if ($u->customer)
                                                        <input data-toggle="toggle" data-size="mini" data-on=" " data-off=" " data-onstyle="info" type="checkbox" data-id="{{ $u->id }}" class="can_call" onclick="event.stopPropagation();" {{ $u->customer->can_call == 1 ? 'checked' : '' }}>
                                                        @endif
                                                    </td> --}}
                                                    <td class="select-user {{$u->webapp ? 'webappuser' : ''}}" data-id="{{ $u->id }}">

                                                        <button data-toggle="tooltip" title="Vedere le informazioni" style="border-radius: 64px; width:20px; height: 20px; font-size: 12px; padding: 0 2px; line-height: 1.3" data-modal="#modal-view-info-{{ $u->id }}" class="modal-view-info btn btn-xs btn-info"><i class="fa fa-info"></i></button>

                                                        <button data-toggle="tooltip" title="Modificare informazioni" style="border-radius: 64px; width:20px; height: 20px; font-size: 12px; padding: 0 2px; line-height: 1.3" data-modal="#modal-edit-info-{{ $u->id }}" class="modal-edit-info btn btn-xs btn-success"><i class="fa fa-pencil"></i></button>

                                                        <a data-toggle="tooltip" title="Vedere utente" href="{{ url('admin/view-customer',$u->id) }}" target="blank" style="border-radius: 64px; width:20px; height: 20px; font-size: 12px; padding: 0 2px; line-height: 1.3" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></a>

                                                        @if ($u->webapp)

                                                        <button data-toggle="tooltip" title="Condividere link" style="border-radius: 64px; width:20px; height: 20px; font-size: 12px; padding: 0 2px; line-height: 1.3" data-modal="#get-link{{ $u->id }}" class="modal-edit-info btn btn-xs btn-danger"><i class="fa fa-link"></i></button>
                                                            
                                                        @endif

                                                        <div class="modal fade" id="modal-view-info-{{ $u->id }}">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    @php
                                                                        $info = App\Detail::where('user_id',$u->id)->first();
                                                                    @endphp
                                                                    <div class="modal-header">Vedere le informazioni
                                                                        {{-- <span class="pull-right">Numero sinistro: <span class="riferimento-{{ $u->id }}">{{ $info ? $info->sin_number : '' }}</span></span> --}}
                                                                        <span class="pull-right">Riferimento Interno: {{ $res ? $res->sin_number : '' }}</span>
                                                                    </div>
                                                                    <div class="modal-body printAreaInfo">
                                                                        <img src="{{ url('renova.png') }}" alt="" width="100px">
                                                                        <h5><b>Nome: </b>{{$u->name}}</h5>
                                                                        @if ($u->webapp)
                                                                        <h5><b>Telefono: </b>{{$u->webapp->fullphone}}</h5>
                                                                        @elseif($u->customer)
                                                                        <h5><b>Telefono: </b>{{$u->customer->phone}}</h5>
                                                                        @endif
                                                                        <hr>
                                                                        <div class="row" id="info-{{ $u->id }}">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Numero sinistro:</b> <br>
                                                                                    - {{ $info ? $info->sin_number : '' }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Compagnia:</b> <br>
                                                                                    - {{ $info ? $info->company : ($u->webapp ? $u->webapp->company : '') }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Numero di polizza:</b> <br>
                                                                                    - {{ $info ? $info->policy : '' }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Modello di polizza:</b> <br>
                                                                                    - {{ $info ? $info->policy_model : '' }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Tipologia di danno:</b> <br>
                                                                                    - {{ $info ? $info->damage : '' }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Tipologia di assicurazione:</b> <br>
                                                                                    - {{ $info ? $info->insurance : '' }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Franchigia / Scoperto:</b> <br>
                                                                                    - {{ $info ? $info->franchise : '' }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Limite di indennizzo:</b> <br>
                                                                                    - {{ $info ? $info->limit : '' }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Quantificazione di danno proposta:</b> <br>
                                                                                    - {{ $info ? $info->quantification1 : '' }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Quantificazione di danno definita:</b> <br>
                                                                                    - {{ $info ? $info->quantification2 : '' }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Modello di telefono:</b> <br>
                                                                                    - {{ $info ? $info->phone_model : '' }}
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Funziona:</b> <br>
                                                                                    - {{ $info ? $info->phone_works : '' }}
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-12">
                                                                                <div class="form-group">
                                                                                    <b>Note:</b> <br>
                                                                                    {{ $info ? $info->notes : '' }}
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-danger" data-dismiss="modal">CHIUDERE DETTAGLIO</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal fade" id="modal-edit-info-{{ $u->id }}">
                                                            <div class="modal-dialog">
                                                                <form action="{{ url('admin/saveInformation') }}" method="POST" class="modal-content ajax_info">
                                                                    @php
                                                                        $info = App\Detail::where('user_id',$u->id)->first();
                                                                    @endphp
                                                                    <div class="modal-header">Informazioni
                                                                        <span class="pull-right">Riferimento Interno: {{ $res ? $res->sin_number : '' }}</span>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {{ csrf_field() }}
                                                                        <input type="hidden" name="user_id" value="{{ $u->id }}">
                                                                        <div class="row modal-edit">
                                                                            <div class="col-sm-6">

                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Numero Sinistro:</b>
                                                                                    <input type="text" name="sin_number" value="{{ $info ? $info->sin_number : $u->lastSinister()->sin_number }}" class="form-control">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">

                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Compagnia:</b>
                                                                                    <select name="company" class="form-control">
                                                                                        <option value="" selected disabled></option>
                                                                                        @foreach (App\Company::all() as $cm)
                                                                                            @if ($u->customer)
                                                                                                <option {{ $info ? ($info->company == $cm->name ? 'selected' : '') : '' }} value="{{ $cm->name }}">{{ $cm->name }}</option>
                                                                                            @else
                                                                                                <option {{ $info ? ($info->company == $cm->name ? 'selected' : '') : ($u->webapp->company == $cm->name ? 'selected' : '') }} value="{{ $cm->name }}">{{ $cm->name }}</option>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">

                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Numero di polizza:</b>
                                                                                    <input type="text" value="{{ $info ? $info->policy : '' }}" name="policy" class="form-control">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">

                                                                                <div class="form-group" style="margin-bottom: 10px; width: 100%">
                                                                                    <b>Modello di polizza:</b>
                                                                                    <div class="editable-select">
                                                                                    <select name="policy_model" class="form-control">
                                                                                        @php
                                                                                            $last = $info ? $info->policy_model : '';
                                                                                        @endphp
                                                                                        <option selected>{{ $last }}</option>
                                                                                        @if ($info)
                                                                                            @if ($info->company)
                                                                                                @php
                                                                                                    $company = App\Company::where('name',$info->company)->first();
                                                                                                    $policies = App\PolicyModel::where('company_id',$company->id)->get();
                                                                                                @endphp
                                                                                                @foreach ($policies as $pm)
                                                                                                    @if ($pm->name != $last)
                                                                                                        <option {{ $info ? ($info->policy_model == $pm->name ? 'selected' : '') : '' }} value="{{ $pm->name }}">{{ $pm->name }}</option>
                                                                                                    @endif
                                                                                                @endforeach
                                                                                            @endif
                                                                                        @else
                                                                                            @if ($u->webapp)
                                                                                                @if ($u->webapp->company)
                                                                                                    @php
                                                                                                        $company = App\Company::where('name',$u->webapp->company)->first();
                                                                                                        $policies = App\PolicyModel::where('company_id',$company->id)->get();
                                                                                                    @endphp
                                                                                                    @foreach ($policies as $pm)
                                                                                                        @if ($pm->name != $last)
                                                                                                            <option {{ $info ? ($info->policy_model == $pm->name ? 'selected' : '') : '' }} value="{{ $pm->name }}">{{ $pm->name }}</option>
                                                                                                        @endif
                                                                                                    @endforeach
                                                                                                @endif
                                                                                            @endif
                                                                                        @endif
                                                                                    </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">

                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Tipologia di danno:</b>
                                                                                    <select name="damage" class="form-control">
                                                                                        <option value="" selected disabled></option>
                                                                                        @foreach (App\Damage::all() as $d)
                                                                                            <option {{ $info ? ($info->damage == $d->name ? 'selected' : '') : '' }} value="{{ $d->name }}">{{ $d->name }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">

                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Tipologia di assicurazione:</b>
                                                                                    <select name="insurance" class="form-control">
                                                                                        <option value="" selected disabled></option>
                                                                                        <option {{ $info ? ($info->insurance == 'Valore intero' ? 'selected' : '') : '' }} value="Valore intero">Valore intero</option>
                                                                                        <option {{ $info ? ($info->insurance == 'Primo rischio assoluto' ? 'selected' : '') : '' }} value="Primo rischio assoluto">Primo rischio assoluto</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">

                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Franchigia / Scoperto:</b>
                                                                                    <input type="text" value="{{ $info ? $info->franchise : '' }}" name="franchise" class="form-control">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">

                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Limite di indennizzo:</b>
                                                                                    <input type="text" value="{{ $info ? $info->limit : '' }}" name="limit" class="form-control">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">

                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Quantificazione di danno proposta:</b>
                                                                                    <input type="text" value="{{ $info ? $info->quantification1 : '' }}" name="quantification1" class="form-control">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">

                                                                                <div class="form-group" style="margin-bottom: 10px;">
                                                                                    <b>Quantificazione di danno definita:</b>
                                                                                    <input type="text" value="{{ $info ? $info->quantification2 : '' }}" name="quantification2" class="form-control">
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group" style="margin-bottom: 10px; width: 100%">
                                                                                    <b>Modello di telefono:</b>
                                                                                    <div class="">
                                                                                        <select name="phone_model" class="form-control">
                                                                                            <option value="" selected disabled></option>
                                                                                            @foreach (App\PhoneModel::all() as $pm)
                                                                                                <option
                                                                                                {{ $info ? ($info->phone_model == $pm->name ? 'selected' : '') : '' }}>{{$pm->name}}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-6">
                                                                                <div class="form-group" style="margin-bottom: 10px; width: 100%">
                                                                                    <b>Funziona?</b>
                                                                                    <div class="">
                                                                                        <select name="phone_works" class="form-control">
                                                                                            <option value="" selected disabled></option>
                                                                                            <option {{ $info ? ($info->phone_works == "Si" ? 'selected' : '') : '' }}>Si</option>
                                                                                            <option {{ $info ? ($info->phone_works == "No" ? 'selected' : '') : '' }}>No</option>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-sm-12">

                                                                                <div class="form-group" style="width: 100% !important;">
                                                                                    <b>Note:</b>
                                                                                    <textarea rows="3" name="notes" class="form-control">{{ $info ? $info->notes : '' }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button class="btn btn-success">SALVA</button>
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">CHIUDERE DETTAGLIO</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        @if ($u->webapp)
                                                        <div class="modal fade in" id="get-link{{$u->id}}">
                                                            <div class="modal-dialog modal-sm">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">Condividere Link
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                          <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">

                                                                        @php
                                                                            $w = $u->webapp;
                                                                        @endphp

                                                                        @include('admin.sms_webapp')
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </td>
                                                    <td class="select-user" data-id="{{ $u->id }}">
                                                        <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#richiesta-{{ $u->id }}" style="font-size: 10px">Gestito</button>

                                                        @if ($u->customer)
                                                        <input title="Attiva Chiamata" data-toggle="toggle" data-size="mini" data-on=" " data-off=" " data-onstyle="info" type="checkbox" data-id="{{ $u->id }}" class="can_call" onclick="event.stopPropagation();" {{ $u->customer->can_call == 1 ? 'checked' : '' }}>
                                                        @endif

                                                        <div class="modal fade" id="richiesta-{{ $u->id }}">
                                                            <div class="modal-dialog modal-sm">
                                                                <form class="modal-content" action="{{ url('admin/close-request',$u->id) }}" method="POST">
                                                                    {{ csrf_field() }}
                                                                    <div class="modal-header">
                                                                        Sei sicuro di voler chiudere questa richiesta?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-success btn-xs contrassegnare" data-id="{{ $u->id }}">Accettare</button>
                                                                        <button type="button" data-dismiss="modal" class="btn btn-warning btn-xs">Cancela</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @else
                                                    @if (count($users) == 1)
                                                        <tr>
                                                            <td colspan="6" style="text-align: center;"><i>Usa la funzione ricerca per far comparire qui i clienti...</i></td>
                                                        </tr>
                                                    @endif
                                                @endif
                                            @empty
                                                <tr>
                                                    <td colspan="6" style="text-align: center;"><i>Usa la funzione ricerca per far comparire qui i clienti...</i></td>
                                                </tr>
                                                {{-- <script>
                                                    alert('Sinister closed!');
                                                </script> --}}
                                            @endforelse
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-6">
        <div class="row">

            <div class="col-md-12 div_messages">
                <div class="panel">
                    <div class="panel-heading">Screenshoot</div>
                    <div class="panel-body call-panel" id="panel-imagenes" style="position: relative; height: calc(23vh - 21px);">
                    </div>
                    <div class="panel-heading">Immagine HD</div>
                    <div class="panel-body call-panel" id="panel4" style="position: relative; height: calc(23vh - 21px);">
                        <div class="row" style="position: relative;">
                            <div class="col-xs-12 messages" style="height: 100%; position: relative; overflow: auto;">
                            </div>
                        </div>
                        <div class="row" style="position: absolute; width: 100%; display: none">
                            <div class="col-xs-12">
                                <div class="input-group" id="chat-input">
                                    <span class="input-group-btn">
                                        <label for="paperclip" class="btn btn-paperclip"><i class="fa fa-paperclip"></i></label>
                                    </span>
                                    <input type="file" style="display: none" id="paperclip" accept=".jpg, .png">
                                    <input type="text" class="form-control" id="my_message">
                                    <span class="input-group-btn">
                                        <button class="btn" id="send_my_message">Inviare</button>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        	<div class="col-md-12 line- map-user">
                <div class="panel">
                    <div class="panel-heading">Geolocalizzazione</div>
                    <div class="panel-body call-panel" style="overflow: auto; height: 34vh">
                        <div id="panel3" style="height: calc(100% - 80px); margin: -15px -15px 0;"></div>
                        <div style="height:; position: relative;">
                            <h5><b>Nome del cliente:</b> <span id="map-name">--</span></h5>
                            <h5><b>Indirizzo:</b> <span id="map-address">--</span></h5>
                            <h5><b>Inizio ultima connessione:</b> <span id="last-connected">--</span></h5>

                            <button data-toggle="tooltip" title="Cliccando sul pulsante si aggiorna la posizione del dispositivo del client selezionato e contemporaneamente sul backend..." class="btn btn-success update" style="position: absolute; right: 0; bottom: -20px; margin-bottom: 0;">AGGIORNA POSIZIONE</button>
                        </div>
                    </div>
                </div>
        	</div>
            
        </div>
    </div>

    {{-- <div class="col-md-6">
        
    </div> --}}

</div>

<div class="modal fade" id="incoming-call" data-keyboard="false" data-backdrop="static" style="z-index: 10000;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">Chiamata in arrivo da <span id="incoming-call-name"></span></div>
            <input type="hidden" id="incoming-call-id">
            <div class="modal-body">
                <div class="row text-center">
                    <div class="col-xs-6">
                        <img width="70px" src="{{ url('incoming.png') }}" alt="" style="cursor: pointer;" data-dismiss="modal" id="answerCall">
                    </div>
                    <div class="col-xs-6">
                        <img width="70px" src="{{ url('refuse.png') }}" alt="" style="cursor: pointer;" data-dismiss="modal" class="sendNonAnswer" onclick="clearTimeout(lostCall);">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="lostCall">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">Hai una chiamata persa <span id="lost-call-name"></span></div>
            <div class="modal-footer">
                <button class="btn btn-xs btn-success" data-dismiss="modal">ACCETTARE</button>
            </div>
        </div>
    </div>    
</div>

<div class="modal fade" id="sendQuestion">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">Chiamata completata, desideri inviare un sondaggio al cliente per valutare il servizio?</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-warning" data-dismiss="modal">ANNULLARE</button>
                <button type="button" class="btn btn-xs btn-success" id="sendQuestionButton" data-dismiss="modal">ACCETTARE</button>
            </div>
        </div>
    </div>    
</div>

<div class="modal fade" id="desactivar">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">Disattivare il link</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-xs btn-warning" data-dismiss="modal">ANNULLARE</button>
                <button type="button" class="btn btn-xs btn-success" id="sendDesactivarLink" data-dismiss="modal">ACCETTARE</button>
            </div>
        </div>
    </div>    
</div>

<div class="modal fade" id="video-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <video src="" id="video-record" style="position: relative;" controls></video>
            </div>
        </div>
    </div>    
</div>

@section('scripts')
<script>
	'use strict';

    $('#sendQuestion').on('hide.bs.modal',function(){
        $('#desactivar').modal('show');
    })

    $('.update').click(function(event) {
        if ($('#user_id').val() == "") {
            return alert("Nessun utente selezionato!");
        }
        if (!apiRTC.session.isConnectedUser($('#number').val())) {
            return alert('User is offline!');
        }
        sendIMMessage($('#user_id').val(), "ff754c36216281cf74abf11c93906ffcfaa1f484");
        $('.map-user').block({ message: "Caricamento della posizione..." });
    });

    var event = new Event('custom');

	var session = null,
        imClient = null,
        webRTCClient = null,
        destId = null,
        recording = null,
        control = null,
        xhr_msgs = null,
        recordRTC = null,
        VanswerCall = null,
        lostCall = null,
        incomingCallId = null,
        recordId = null;

    $('#sendQuestionButton').click(function(event) {
        imClient.sendMessage($('#user_id').val(),'Can you answer the following questionnaire?');
        (PNotify.success({
          title: "Sondaggio inviato",
          text: "Il sondaggio è stato inviato, se il cliente lo risponde, si rifletterà nel file del cliente",
          type: 'success',
          desktop: {
              desktop: false
          }
        }));
    });

    $('#answerCall').click(function(e){

        webRTCClient.acceptCall(incomingCallId/*,{muted:"VIDEOONLY"}*/);

        document.getElementById('new-call').pause();

        // $('#video-call').trigger('click');
        // setTimeout(function(){
        //     imClient.sendMessage($('#user_id').val(),'AUTOANSWER');
        // },2000);
        clearTimeout(lostCall);
    })

    $('#changeCamera').click(function(event) {
        imClient.sendMessage($('#user_id').val(),'Please, change the camera [FRONT] [REAR]');
    });

    function b64toBlob(b64Data, contentType, sliceSize) {
        contentType = contentType || '';
        sliceSize = sliceSize || 512;

        var byteCharacters = atob(b64Data);
        var byteArrays = [];

        for (var offset = 0; offset < byteCharacters.length; offset += sliceSize) {
            var slice = byteCharacters.slice(offset, offset + sliceSize);

            var byteNumbers = new Array(slice.length);
            for (var i = 0; i < slice.length; i++) {
                byteNumbers[i] = slice.charCodeAt(i);
            }

            var byteArray = new Uint8Array(byteNumbers);

            byteArrays.push(byteArray);
        }

        var blob = new Blob(byteArrays, {type: contentType});
        return blob;
    }

    $('.sendNonAnswer').click(function(event) {
        imClient.sendMessage($('#incoming-call-id').val(),'Call refused CODE 1310');

        $("#call").attr("disabled", false).html("Chiamata <span class='caret'></span>");
        $("#hangup").attr("disabled", true).val("Riattacca");

        webRTCClient.refuseCall(incomingCallId); 
        document.getElementById('new-call').pause();
    });

    // function downloadFromChat() {
    //     function makeid() {
    //       // var text = "";
    //       // var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    //       // for (var i = 0; i < 8; i++)
    //       //   text += possible.charAt(Math.floor(Math.random() * possible.length));

    //       // return text;
    //         var today = new Date();
    //         var dd = today.getDate();var mm = today.getMonth()+1;var yyyy = today.getFullYear();
    //         var hh = today.getHours();var ii = today.getMinutes();var ss = today.getSeconds();
    //         if(dd<10) {dd = '0'+dd} 
    //         if(mm<10) {mm = '0'+mm} 
    //         today = dd + '/' + mm + '/' + yyyy + '-' + hh + ':' + ii + ':' + ss;
    //         return $('#nameToUse').val()+'-'+today;
    //     }
    //     download($(this).attr('src'), makeid()+'.jpg', 'image/jpeg');
    // }

    function takeSnapshot(event) {

        imClient.sendMessage($('#user_id').val(),'Snapshot Taken CODE 0004');

        $('div#panel-imagenes').block({ message: "Caricamento dell'immagine..." });

        let myRemoteVideo = document.querySelector('#myRemoteVideo video:last-child');
        let snapshot = document.createElement('canvas');

        snapshot.width = myRemoteVideo.videoWidth;
        snapshot.height = myRemoteVideo.videoHeight;

        let c = snapshot.getContext('2d');
        c.drawImage(myRemoteVideo, 0, 0, snapshot.width, snapshot.height);

        let image = snapshot.toDataURL("image/jpeg");
        let id = $('#inCall_user_id').val();

        var block = image.split(";");
        var contentType = block[0].split(":")[1];// In this case "image/gif"
        var realData = block[1].split(",")[1];// In this case "R0lGODlhPQBEAPeoAJosM...."
        var blob = b64toBlob(realData, contentType);

        console.log(blob);

        var formData = new FormData();
        formData.append('file',blob);
        formData.append('id',$("#number").val());
        formData.append('lat',$('#latToSave').val());
        formData.append('lng',$('#lonToSave').val());
        formData.append('address',$('#map-address').text());
        formData.append('type',1);

        $.ajax({
            url: '{{ url('api/uploadFileImage') }}',
            type: 'POST',
            contentType: false,
            processData: false,
            data: formData,
        })
        .done(function() {
            $.get('{{url('addInfoClaimsUser')}}/'+$('#user_id').val(), function(data) {
                console.log('ok');
            });
            $.post('{{ url('api/uploadImageB') }}', {image:image, id: id, platform: 'ios'}, function(data, textStatus, xhr) {
                var imagenes = "<div id='img-carousel'>";
                $.each(data[0], function(index, val) {
                    imagenes += "<div style='padding: 0 6px;'>\
                            <div style='position:relative;'><button style='position:absolute; right: -5px; top: 15px;' class='btn badge label-danger delete-this' data-id='"+val.id+"'><i class='fa fa-times'></i></button>\
                                <a href='"+val.full_imagen+"' download class='btn btn-info btn-xs'><i class='fa fa-download'></i> SALVA</a>   \
                            </div>\
                            <div style='background-image: url("+val.imagen+"); background-size: cover; background-position: center; height: 110px;'>\
                            </div>\
                        </div>";
                });
                imagenes += "</div>";

                $('#panel-imagenes').html(imagenes);

                $('#img-carousel').owlCarousel({
                    items: 5,
                    itemsDesktop: [1199,4],
                    itemsDesktopSmall: [979,3],
                    itemsTablet: [768,3],
                    pagination: true
                });
                /**/
                setTimeout(()=>{
                    $(".messages").scrollTop(document.getElementsByClassName('messages')[0].scrollHeight);
                },100);

                var imagenes = "<div id='img-carousel-1'>";
                $.each(data[1], function(index, val) {
                    imagenes += "<div style='padding: 0 6px;'>\
                            <div style='position:relative;'><button style='position:absolute; right: -5px; top: 15px;' class='btn badge label-danger delete-this' data-id='"+val.id+"'><i class='fa fa-times'></i></button>\
                                <a href='"+val.full_imagen+"' download class='btn btn-info btn-xs'><i class='fa fa-download'></i> SALVA</a>   \
                            </div>\
                            <div style='background-image: url("+val.imagen+"); background-size: cover; background-position: center; height: 110px;'>\
                            </div>\
                        </div>";
                });
                imagenes += "</div>";

                $('.messages').html(imagenes);

                $('#img-carousel-1').owlCarousel({
                    items: 5,
                    itemsDesktop: [1199,4],
                    itemsDesktopSmall: [979,3],
                    itemsTablet: [768,3],
                    pagination: true
                });
                $('.delete-this').click(deleteThis);
                $('div.div_messages .panel').unblock();
            });
        });
        

    }

    $('#takeSnapshot').click(takeSnapshot);

    /*function PostBlob(recordedBlob) {
        // return console.log(recordedBlob);

        // return saveBlobToDB(recordedBlob);


        var formData = new FormData();
        var user_id = localStorage.getItem('to_record');
        if (!user_id) {
            user_id = $('#user_id').val();
        }
        if (!user_id) {
            user_id = localStorage.getItem('to_record');
        }

        formData.append('data', recordedBlob);
        formData.append('address', $('#map-address').html());
        formData.append('lat', $('#latToSave').val());
        formData.append('lon', $('#lonToSave').val());
        formData.append('user_id', user_id);
        formData.append('duration', $('#minutos').html()+':'+$('#segundos').html());

        if (_webappuser) {
            $('#sendQuestion').modal('show');
        }
        $('#panel2').block({ message: '<h3 id="message-loading" style="margin-top:10px">Caricamento del file video...</h3> <div id="load-border"><div id="load-bar"></div></div>' });

        $.ajax({
            xhr: function() {
              var xhr = new window.XMLHttpRequest();

              xhr.upload.addEventListener("progress", function(evt) {
                if (evt.lengthComputable) {
                  var percentComplete = evt.loaded / evt.total;
                  percentComplete = parseInt(percentComplete * 100);
                  $('#load-bar').width(percentComplete+'%')

                  if (percentComplete === 100) {
                    $('#message-loading').text('Converting video to MP4 file format, attendere...')
                    console.log('Completed');
                  }

                }
              }, false);

              return xhr;
            },
            url: '{{ url('api/adminUploadVideo') }}',
            type: 'POST',
            contentType: false,
            processData: false,
            data: formData,
        })
        .done(function(data) {
            var html;
            $('.display.table').dataTable().fnDestroy();
            $('.display.table').css('width', 'auto');
            $.each(data[0], function(index, val) {
                html += "<tr>\
                    <td>"+val.id+"</td>\
                    <td>"+val.user.name+"</td>\
                    <td>"+val.address+"</td>\
                    <td>"+val.created+"</td>\
                    <td>"+val.duration+"</td>\
                    <td>";
                    if (val.name.indexOf('.mp4') != -1) {
                        html+='<a href="{{url('uploads/videos')}}/'+val.name+'" target="_blank" class="btn btn-info btn-xs">View</a>';

                    }else{
                        html+="<button data-id='"+val.id+"' class='btn btn-info btn-xs convertMp4'>View</button>";
                    }
                    html+="</td>\
                </tr>";
            });
            $('#videos-'+user_id).html(html);
            $('.convertMp4').click(convertMp4);
            $('.display.table').dataTable();
            recordRTC = null;
        })
        .fail(function() {
            console.log("error");
            $('#panel2').unblock();
            setTimeout(function(){
                $('#load-bar').width(0);
            },3000)
        })
        .always(function() {
            recordRTC = null;
            console.log("complete");
            $('#panel2').unblock();
            setTimeout(function(){
                $('#load-bar').width(0);
            },3000)
        });
    }

    // function log(message) {
    //     console.log(message);
    // }

    function _stopRecording() {
        if (recordRTC) {
            recordRTC.stop(function (audioVideoWebMURL) {
                console.log('audioVideoWebMURL',audioVideoWebMURL)

                var recordedBlob = recordRTC.blob;
                // console.log(recordedBlob)

                // convertStreams(recordedBlob);
                PostBlob(recordedBlob);

                // return false;
            });
        }
    }*/

    function startRecording(remote_url) {

        recordId = null;

        var formData = new FormData();
        var user_id = localStorage.getItem('to_record');
        if (!user_id) {
            user_id = $('#user_id').val();
        }
        if (!user_id) {
            user_id = localStorage.getItem('to_record');
        }

        formData.append('remote_url', remote_url);
        formData.append('address', $('#map-address').html());
        formData.append('lat', $('#latToSave').val());
        formData.append('lon', $('#lonToSave').val());
        formData.append('user_id', user_id);

        $.ajax({
            url: '{{ url('api/adminUploadVideo') }}',
            type: 'POST',
            contentType: false,
            processData: false,
            data: formData,
        })
        .done(function(data) {

            console.log("predata record",data)

            recordId = data.id;

        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
    }


    function userMediaErrorHandler(e) {
        $("#call").attr("disabled", false).html("Chiamata <span class='caret'></span>");
        $("#hangup").attr("disabled", true).val("Riattacca");
    }
    function remoteHangupHandler(e) {
        if (e.detail.lastEstablishedCall === true) {
            $("#call").attr("disabled", false).html("Chiamata <span class='caret'></span>");
            $("#hangup").attr("disabled", true).val("Riattacca");
        }
        clearInterval(control);
        control = null;
        // clearInterval(recording);
    }
    function hangUpHandler(e) {

        if (_webappuser) {
            $('#sendQuestion').modal('show');
        }

        localStorage.setItem('to_record',$('#inCall_user_id').val());
        $('#recording-time').addClass('hidden');

        clearInterval(control);
        control = null;
        // clearInterval(recording);
        // $('.messages').html("");
        // $('#callId_' + e.detail.callId + '-' + apiRTC.session.apiCCId).remove();

        $('#dot-in-call-'+($('#inCall_user_id').val())).html('');
        $('#name-in-call-'+($('#inCall_user_id').val())).html('');

        // $.post('{{ url('admin/inCallNull') }}', {_token: '{{ csrf_token() }}', id: $('#inCall_user_id').val()}, function(data, textStatus, xhr) {
        // });

        $("#inCall_user_id").val('');

        console.log('VanswerCall');

        resetZoom();
        if (VanswerCall != null) {
            VanswerCall = null;
            /*_stopRecording();*/
            var duration = $('#minutos').html()+':'+$('#segundos').html();
            $.post('{{url('api/saveDuration')}}', {id: recordId,duration: duration}, function(data, textStatus, xhr) {
                console.log("guardada duracion de llamada",data)
            });
        }else{
            recordRTC = null;
        }
        $("#takeSnapshot").addClass("hidden");
        $("#changeCamera").addClass("hidden");

        // sendSocket( JSON.stringify({id: $('#inCall_user_id').val(), type: 0}) );
    }

    function addStreamInDiv(stream, callType, divId, mediaEltId, style, muted) {
        var mediaElt = null,
            divElement = null,
            funcFixIoS = null,
            promise = null;
        if (callType === 'audio') {
            mediaElt = document.createElement("audio");
        } else {
            mediaElt = document.createElement("video");
        }

        mediaElt.id = mediaEltId;
        mediaElt.autoplay = true;
        mediaElt.muted = muted;
        mediaElt.style.width = style.width;
        mediaElt.style.height = style.height;

        funcFixIoS = function () {
            var promise = mediaElt.play();
            console.log('funcFixIoS');
            if (promise !== undefined) {
                promise.then(function () {
                    // Autoplay started!
                    mediaElt.srcObject.getVideoTracks()[0].applyConstraints(constraints).catch(e => console.log('errorApplyConstraints',e));
                    console.log('Autoplay started');
                    console.error('Audio is now activated');
                    document.removeEventListener('touchstart', funcFixIoS);
                    $('#modal1').modal('close');
                }).catch(function (error) {
                    // Autoplay was prevented.
                    console.error('Autoplay was prevented');
                });
            }
        };

        console.log('apiRTC.browser :', apiRTC.browser);
        console.log('apiRTC.browser_major_version :', apiRTC.browser_major_version);
        console.log('apiRTC.osName :', apiRTC.osName);
        //Patch for ticket on Chrome 61 Android : https://bugs.chromium.org/p/chromium/issues/detail?id=769148
        if (apiRTC.browser === 'Chrome' && apiRTC.browser_major_version === '61' && apiRTC.osName === "Android") {
            mediaElt.style.borderRadius = "1px";
            console.log('Patch for video display on Chrome 61 Android');
        }
        
        webRTCClient.attachMediaStream(mediaElt, stream);
        divElement = document.getElementById(divId);
        divElement.appendChild(mediaElt);
        promise = mediaElt.play();
        if (promise !== undefined) {
            promise.then(function () {
                mediaElt.srcObject.getVideoTracks()[0].applyConstraints(constraints).catch(e => console.log('errorApplyConstraints',e));
                // Autoplay started!
                console.log('Autoplay started');
            }).catch(function (error) {
                // Autoplay was prevented.
                if (apiRTC.osName === "iOS") {
                    console.info('iOS : Autoplay was prevented, activating touch event to start media play');
                    //Show a UI element to let the user manually start playback
                    //In our sample, we display a modal to inform user and use touchstart event to launch "play()"
                    document.addEventListener('touchstart',  funcFixIoS);
                    console.error('WARNING : Audio autoplay was prevented by iOS, touch screen to activate audio');
                    $('#modal1').modal('open');
                } else {
                    console.error('Autoplay was prevented');
                }
            });
        }
    }


    function userMediaSuccessHandler(e){
        // console.log('stream',e.detail);
        /*if (!recordRTC) {
            console.log('aqui0')
            if (e.detail.callType != "audio") {
                var options = {
                    mimeType: 'video/webm;codecs=h264',
                    frameInterval: 1,
                    video: {width: 480, height: 640}
                };
                recordRTC = new MultiStreamRecorder([e.detail.stream], options);
                console.log(recordRTC);
                recordRTC.record();
            }
        }else{
            recordRTC.addStreams([e.detail.stream]);
            recordRTC.resetVideoStreams([e.detail.stream]);
            console.log(recordRTC);
            // recordRTC.reset();
            // recordRTC.startRecording();
        }*/

        /*webRTCClient.*/addStreamInDiv(e.detail.stream, e.detail.callType, "mini", 'miniElt-' + e.detail.callId,
            {width : "128px", height : "96px"}, true);
    }
    function remoteStreamAddedHandler(e){
        console.log('remoteStreamAddedHandler',e.detail);
        VanswerCall = true;
        console.log('stream',e.detail)
        // console.log('callId',e.detail)
        $("#inCall_user_id").val($('#user_id').val());

        $("#takeSnapshot").removeClass("hidden");
        $("#changeCamera").removeClass("hidden");

        $.post('{{ url('admin/inCallTrue') }}', {_token: '{{ csrf_token() }}', id: $('#inCall_user_id').val()}, function(data, textStatus, xhr) {
            $.post('{{ url('admin/findInCall') }}', {_token: '{{ csrf_token() }}', id: $('#inCall_user_id').val()}, function(data, textStatus, xhr) {
                // sendSocket( JSON.stringify({id: $('#inCall_user_id').val(), type: 1, name: data}) );
                $('#name-in-call-'+($('#inCall_user_id').val())).html(data);
                $('#dot-in-call-'+($('#inCall_user_id').val())).html('<span class="dot-in-call"></span>');
            });
        });

        /*webRTCClient.*/addStreamInDiv(e.detail.stream, e.detail.destCallType, "myRemoteVideo", 'remoteElt-' + e.detail.callId,
            {width : "640px", height : "480px"}, false);

        // $("#myRemoteVideo video").prop("volume", 0);

        setTimeout(()=>{
            setZoom();
        },2000)

        /*if (!recordRTC) {
            console.log('aqui1',e.detail.callType)
            if (e.detail.callType != "audio") {
                var options = {
                    mimeType: 'video/webm;codecs=h264',
                    frameInterval: 1,
                    video: {width: 480, height: 640}
                };
                recordRTC = new MultiStreamRecorder([e.detail.stream], options);
                console.log(recordRTC);
                recordRTC.record();
            }
        }else{
            recordRTC.addStreams([e.detail.stream]);
            recordRTC.resetVideoStreams([e.detail.stream]);
            console.log(recordRTC);
            // recordRTC.reset();
            // recordRTC.startRecording();
        }*/
    }
    function incomingCallHandler(e) {

        console.log("incomingCallHandler",e.detail);

        incomingCallId = e.detail.callId;;

        apiRTC.addEventListener("remoteHangup", remoteHangupHandler);
        $("#call").attr("disabled", true).val("Chiamata in corso");
        $("#hangup").attr("disabled", false).val("Riattacca");

        document.getElementById('new-call').play();

        $('.select-user[data-id="'+e.detail.callerId+'"]:first').trigger('click');

        // $('#incoming-call-name').text(e.detail.senderNickname);
        $('#incoming-call-id').val(e.detail.CallerId);
        $('#incoming-call').modal('show');

        lostCall = setTimeout(()=>{
            $('#incoming-call').modal('hide');
            $('#lostCall').modal('show');
            $('#lost-call-name').text($('#user_name').val());
            webRTCClient.refuseCall(incomingCallId); 
        },20000)
    }

    function remoteStreamRemovedHandler(e) {
        console.log('remoteStreamRemovedHandler',e.detail);
        $('#myRemoteVideo video').remove();
        $('#callId_' + e.detail.callId + '-' + e.detail.remoteId).remove();
    }

    /**/

    function deleteThis() {
        $(this).parent().parent().remove();
        var id = $(this).data('id');
        $.post('{{ url('admin/deleteImage') }}', {id: id, _token: '{{ csrf_token() }}'}, function(data, textStatus, xhr) {
        });
        $('#img-carousel').owlCarousel({
            items: 5,
            itemsDesktop: [1199,4],
            itemsDesktopSmall: [979,3],
            itemsTablet: [768,3],
            pagination: true
        });
        $('#img-carousel-1').owlCarousel({
            items: 5,
            itemsDesktop: [1199,4],
            itemsDesktopSmall: [979,3],
            itemsTablet: [768,3],
            pagination: true
        });
    }

    function sendIMMessage(destId, message) {

        if (!apiRTC.session.isConnectedUser(destId)) {
            // var usuarios = JSON.parse(localStorage.getItem('notificationTo'));
            $.post('{{ url('admin/send-msg-notification') }}', {_token:'{{ csrf_token() }}',message: message, id: destId}, function(data, textStatus, xhr) {
            });
            // var a = 0;
            // if (usuarios != null) {
            //     $.each(usuarios, function(index, val) {
            //         if (val == destId) {
            //             a++;
            //         }
            //     });
            // }else{
            //     usuarios = [];
            // }
            // if (a == 0) {
            //     $.post('{{ url('admin/send-msg-notification') }}', {_token:'{{ csrf_token() }}',message: message, id: destId}, function(data, textStatus, xhr) {
            //     });
            //     usuarios.push(destId);
            //     // localStorage.setItem('notificationTo',JSON.stringify(usuarios));
            // }
        }else{
            imClient.sendMessage(destId, message);
            //Optionnal: we scroll the messages
            // console.log(document.getElementsByClassName('messages')[0].scrollHeight);
        }
        if (message != "a42a97e5fc834380e2ead93c15504f54b90ec3f9" && message != "a37bb50762b2f84b70c682d4d1f0ae4c34da1a8c" && message != "7b7571496c87c763011dda72cb82e2a919724203" && message != "ff754c36216281cf74abf11c93906ffcfaa1f484") {
            $.post('{{ url('getTime') }}', {_token: '{{ csrf_token() }}'}, function(data, textStatus, xhr) {
                $('.messages').append('<div class="contenedor"><div class="well me"><span class="label label-success">Io:</span> '+urlify(message)+'</div></div><div class="date-me">'+data+'</div>');
                setTimeout(()=>{
                    $(".messages").scrollTop(document.getElementsByClassName('messages')[0].scrollHeight);
                },100)
            });
        }
    }

    var actual_modal;
    $('button[data-target]').click(function(event) {
        console.log($(this).data())
        actual_modal = $(this).data('target');
    });
    $('[data-target="#video-modal"]').click(function(event) {
        $('#video-record').attr('src',$(this).data('href'));
        $('[id*=records-]').modal('hide');
    });
    $('#video-modal').on('hidden.bs.modal', function () {
      $('#video-record').attr('src','');
      $(actual_modal).modal('show');
    })
    function loadPosition()
    {
        $.ajax({
            url: $('#user_id').data('url')+'/'+$('#user_id').val(),
            type: 'GET'
        })
        .done(function(data) {
            // alert('call_id: '+data.call_id)
            if (!apiRTC.session.isConnectedUser(data.call_id)) {
                console.log('User is offline!')
            }
            // $("#number").val(data.call_id);
            // $("#call_id-"+data.user_id).html(data.fake_call_id);
            // console.log(data)
            $('#latToSave').val(data.lat);
            $('#lonToSave').val(data.lng);
            $('#last-connected').html(data.date);

            var pos = {
              lat: parseFloat(data.lat),
              lng: parseFloat(data.lng)
            };

            var map = new google.maps.Map(document.getElementById('panel3'), {
              zoom: 16,
              center: pos,
              // mapTypeControl: false,
              streetViewControl: false,
              rotateControl: false,
              mapTypeId: 'roadmap'
            });
            var marker = new google.maps.Marker({
              position: pos,
              map: map
            });

            console.log(pos);

            var geo = new google.maps.Geocoder();

            geo.geocode({'latLng': pos}, function(results,status) {
                console.log(results)
                $('#map-address').html(results[0]['formatted_address']);
            });
        })
        .fail(function(r) {
            // initMap();
            // $('#can_call').val('2');
            // alert(JSON.parse(r.responseText)[0]);
        });
    }
    function receiveIMMessageHandler(e) {

        // aqui para recibir imagenes
        console.log(e);

        if (e.detail.message.indexOf("La velocità di connessione dell'utente è inferiore a quella richiesta dal nostro server!") != -1) {
            let msg = e.detail.message.split('-');
            let color = 'red';

            if (msg[1] < 1) {
                color = 'orange';
            }
            $('#dot-online-'+e.detail.senderId).css('color', color);
            (PNotify.info({
              title: e.detail.senderNickname,
              text: msg[0],
              type: 'info',
              desktop: {
                  desktop: true
              }
            }));

            return false;
        }

        if (e.detail.senderId == $('#number').val()) {

            if (e.detail.message.indexOf('recording') != -1) {
                recordId = e.detail.message.split('|')[1];
                (PNotify.success({
                    title: "Videochiamata",
                    text: "Il video si sta caricando in background",
                    type: 'success',
                    desktop: {
                        desktop: false
                    }
                }));
            }

            if (e.detail.message == "92ef97f1cadcae6b4cb70ba141a68bf78580f3ff") {
                $('div#panel-imagenes').block({ message: "Caricamento dell'immagine..." });
                $.post('{{ url('admin/receiveImage') }}', {senderId: e.detail.senderId, _token: '{{ csrf_token() }}' }, function(data, textStatus, xhr) {
                    /**/
                    var imagenes = "<div id='img-carousel'>";
                    $.each(data[0], function(index, val) {
                        imagenes += "<div style='padding: 0 6px;'>\
                                <div style='position:relative;'><button style='position:absolute; right: -5px; top: 15px;' class='btn badge label-danger delete-this' data-id='"+val.id+"'><i class='fa fa-times'></i></button>\
                                    <a href='"+val.full_imagen+"' download class='btn btn-info btn-xs'><i class='fa fa-download'></i> SALVA</a>   \
                                </div>\
                                <div style='background-image: url("+val.imagen+"); background-size: cover; background-position: center; height: 110px;'>\
                                </div>\
                            </div>";
                    });
                    imagenes += "</div>";

                    $('#panel-imagenes').html(imagenes);

                    $('#img-carousel').owlCarousel({
                        items: 5,
                        itemsDesktop: [1199,4],
                        itemsDesktopSmall: [979,3],
                        itemsTablet: [768,3],
                        pagination: true
                    });
                    /**/
                    setTimeout(()=>{
                        $(".messages").scrollTop(document.getElementsByClassName('messages')[0].scrollHeight);
                    },100);

                    var imagenes = "<div id='img-carousel-1'>";
                    $.each(data[1], function(index, val) {
                        imagenes += "<div style='padding: 0 6px;'>\
                                <div style='position:relative;'><button style='position:absolute; right: -5px; top: 15px;' class='btn badge label-danger delete-this' data-id='"+val.id+"'><i class='fa fa-times'></i></button>\
                                    <a href='"+val.full_imagen+"' download class='btn btn-info btn-xs'><i class='fa fa-download'></i> SALVA</a>   \
                                </div>\
                                <div style='background-image: url("+val.imagen+"); background-size: cover; background-position: center; height: 110px;'>\
                                </div>\
                            </div>";
                    });
                    imagenes += "</div>";

                    $('.messages').html(imagenes);

                    $('#img-carousel-1').owlCarousel({
                        items: 5,
                        itemsDesktop: [1199,4],
                        itemsDesktopSmall: [979,3],
                        itemsTablet: [768,3],
                        pagination: true
                    });

                    $('.delete-this').click(deleteThis);
                    $('div.div_messages .panel').unblock();
                });
                return false;
                
            }else if(e.detail.message == "3c05ebcf376c5eaa2fbb79019c26fd691207898f"){
                // alert('Chiamata con registrazione rifiutata!')
                $("#call").attr("disabled", false).html("Chiamata <span class='caret'></span>");
                $("#hangup").attr("disabled", true).val("Riattacca");
                webRTCClient.hangUp();
                return false;

            }/*else if(e.detail.message == "Incoming call from a customer - CODE 0001"){

                document.getElementById('new-call').play();

                console.log('llamada entrante 2');

                $('.select-user[data-id="'+e.detail.senderId+'"]:first').trigger('click');
                $('#incoming-call-name').text(e.detail.senderNickname);
                $('#incoming-call-id').val(e.detail.senderId);
                $('#incoming-call').modal('show');
                lostCall = setTimeout(()=>{
                    $('#incoming-call').modal('hide');
                    $('#lostCall').modal('show');
                    $('#lost-call-name').text(e.detail.senderNickname);
                },20000)

                return false;

            }*/
            else if(e.detail.message == "c39d8c95216d7fa04bed5befd831cecbf6291c72"){

                loadPosition();
                $('.map-user').unblock();
                return false;

            }else if(e.detail.message == "Richiesta istantanea inviata - ExpressClaims"){

                takeSnapshot();

            }else{
                //If chatbox not visible, we set it visible
                if (_webappuser) {
                    $.post('{{ url('admin/receiveImage') }}', {senderId: e.detail.senderId, _token: '{{ csrf_token() }}' }, function(data, textStatus, xhr) {
                        var imagenes = "<div id='img-carousel'>";
                        $.each(data[0], function(index, val) {
                            imagenes += "<div style='padding: 0 6px;'>\
                                    <div style='position:relative;'><button style='position:absolute; right: -5px; top: 15px;' class='btn badge label-danger delete-this' data-id='"+val.id+"'><i class='fa fa-times'></i></button>\
                                        <a href='"+val.full_imagen+"' download class='btn btn-info btn-xs'><i class='fa fa-download'></i> SALVA</a>   \
                                    </div>\
                                    <div style='background-image: url("+val.imagen+"); background-size: cover; background-position: center; height: 110px;'>\
                                    </div>\
                                </div>";
                        });
                        imagenes += "</div>";

                        $('#panel-imagenes').html(imagenes);

                        $('#img-carousel').owlCarousel({
                            items: 5,
                            itemsDesktop: [1199,4],
                            itemsDesktopSmall: [979,3],
                            itemsTablet: [768,3],
                            pagination: true
                        });
                        /**/
                        setTimeout(()=>{
                            $(".messages").scrollTop(document.getElementsByClassName('messages')[0].scrollHeight);
                        },100);

                        var imagenes = "<div id='img-carousel-1'>";
                        $.each(data[1], function(index, val) {
                            imagenes += "<div style='padding: 0 6px;'>\
                                    <div style='position:relative;'><button style='position:absolute; right: -5px; top: 15px;' class='btn badge label-danger delete-this' data-id='"+val.id+"'><i class='fa fa-times'></i></button>\
                                        <a href='"+val.full_imagen+"' download class='btn btn-info btn-xs'><i class='fa fa-download'></i> SALVA</a>   \
                                    </div>\
                                    <div style='background-image: url("+val.imagen+"); background-size: cover; background-position: center; height: 110px;'>\
                                    </div>\
                                </div>";
                        });
                        imagenes += "</div>";

                        $('.messages').html(imagenes);

                        $('#img-carousel-1').owlCarousel({
                            items: 5,
                            itemsDesktop: [1199,4],
                            itemsDesktopSmall: [979,3],
                            itemsTablet: [768,3],
                            pagination: true
                        });
                        $('.delete-this').click(deleteThis);
                        $('div.div_messages .panel').unblock();
                    });
                    // return false;
                }
            }
        }else{
            if (e.detail.message != "92ef97f1cadcae6b4cb70ba141a68bf78580f3ff" && e.detail.message.indexOf('<a href=') == -1 && e.detail.message != "Incoming call from a customer - CODE 0001" && e.detail.message != "c39d8c95216d7fa04bed5befd831cecbf6291c72" && e.detail.message != "Richiesta istantanea inviata - ExpressClaims" && e.detail.message.indexOf('recording') == -1) {
                (PNotify.info({
                  title: e.detail.senderNickname,
                  text: e.detail.message,
                  type: 'info',
                  desktop: {
                      desktop: true
                  }
                }));
                return false;
            }
            if(e.detail.message == "c39d8c95216d7fa04bed5befd831cecbf6291c72"){
                console.log('get position skiped')
                return false;
            }
            if (e.detail.message.indexOf('recording') != -1) {
                recordId = e.detail.message.split('|')[1];
                (PNotify.success({
                    title: "Videochiamata",
                    text: "Il video si sta caricando in background",
                    type: 'success',
                    desktop: {
                        desktop: false
                    }
                }));
            }
            // if(e.detail.message == "Incoming call from a customer - CODE 0001"){

            //     document.getElementById('new-call').play();

            //     console.log('llamada entrante 1');

            //     $('.select-user[data-id="'+e.detail.senderId+'"]:first').trigger('click');
            //     $('#incoming-call-name').text(e.detail.senderNickname);
            //     $('#incoming-call-id').val(e.detail.senderId);
            //     $('#incoming-call').modal('show');
            //     lostCall = setTimeout(()=>{
            //         $('#incoming-call').modal('hide');
            //         $('#lostCall').modal('show');
            //         $('#lost-call-name').text(e.detail.senderNickname);
            //     },20000)
            //     return false;

            // }
        }
    }
    function userMediaStopHandler(e) {
        // console.log('userMediaStopHandler :', e.detail);
        webRTCClient.removeElementFromDiv('mini', 'miniElt-' + e.detail.callId);
    }

    var datatable = false;

    /**/
    var user_array = [];

    function sessionReadyHandler(e) {
        webRTCClient = apiCC.session.createWebRTCClient({
            // localVideo : "myLocalVideo",
            // minilocalVideo : "myMiniVideo",
            // remoteVideo : "myRemoteVideo"
            status : "status"
        });            
        webRTCClient.setUserAcceptOnIncomingCallBeforeGetUserMedia(true);

        webRTCClient.setMCUConnector('mcu4.apizee.com');
        webRTCClient.setVideoBandwidth(1000);
        webRTCClient.setAllowMultipleCalls(true);

        // apiRTC.session.apiCCWebRTCClient.setRecordedCall(true);

        // var constraint = {};
        // constraint.video = {width: {exact: 1920}, height: {exact: 1080}};
        // constraint.audio = {};

        // webRTCClient.setGetUserMediaConfig(constraint);

        $("#call").attr("disabled", false).html("Chiamata <span class='caret'></span>");
        $('#myCallId').html(apiRTC.session.apiCCId);
        apiRTC.addEventListener("incomingCall", incomingCallHandler);
        apiRTC.addEventListener("userMediaError", userMediaErrorHandler);
        // apiRTC.addEventListener("onFileReceived", onFileReceivedHandler);
        apiRTC.addEventListener("remoteStreamAdded", remoteStreamAddedHandler);
        apiRTC.addEventListener("userMediaSuccess", userMediaSuccessHandler);
        apiRTC.addEventListener("userMediaStop", userMediaStopHandler);
        apiRTC.addEventListener("remoteStreamRemoved", remoteStreamRemovedHandler);
        apiRTC.addEventListener("receiveIMMessage", receiveIMMessageHandler);
        apiRTC.addEventListener("hangup",hangUpHandler);

        apiRTC.addEventListener("MCURecordingStarted",function(e){
            console.log('url',e.detail)
            if (!control) {
                control = setInterval(cronometro,1000);
            }
            startRecording(e.detail.mediaURL);

            (PNotify.success({
                title: "Videochiamata",
                text: "Il video si sta caricando in background",
                type: 'success',
                desktop: {
                    desktop: false
                }
            }));

            /**/
        });

        apiRTC.addEventListener("recordedStreamsAvailable", function(e){
            console.error("recordedStreamsAvailableHandler");
            console.log("confId : " + e.detail.confId);
            console.log("userId1 : " + e.detail.userId1);
            console.log("userId2 : " + e.detail.userId2);

            if (e.detail.mediaURL !== undefined) {
                console.log(e.detail.mediaURL);
                $.post('{{url('api/downloadVideo')}}', {remote_url: e.detail.mediaURL}, function(data, textStatus, xhr) {
                    console.log(data);
                    (PNotify.success({
                        title: "Videochiamate",
                        text: "Il video è stato caricato correttamente",
                        type: 'success',
                        desktop: {
                            desktop: false
                        }
                    }));
                });
            }
        });

        // apiRTC.addEventListener("remoteStreamAdded", function(){
        // });

        apiRTC.addEventListener('connectedUsersListUpdate',(e)=>{
            if (e.detail.usersList) {
                $.each(e.detail.usersList, function(index, val) {
                    if (e.detail.status == 'online') {
                        $('#dot-online-'+val).removeClass('hide');
                        user_array.push(val);
                    }else{
                        $('#dot-online-'+val).addClass('hide');
                        user_array.slice(user_array.findIndex(x=> x == val),1);
                    }
                });
            }

            if (!datatable) {
                $('.operator.table-').dataTable({
                    "aaSorting": [[ 0, "desc" ]]
                });
                datatable = true;
            }
        })

        imClient = apiCC.session.createIMClient();
        imClient.nickname = '{{ Auth::user()->name }}';

        $.post('{{ url('admin/operator_call_id') }}', {operator_call_id: apiRTC.session.apiCCId, _token: '{{ csrf_token() }}'}, function(data, textStatus, xhr) {
            $.each(data[1], function(index, val) {
                imClient.sendMessage(val.call_id,'eaf2ea9f6559f226c8f433830b397204fe28ffdc');
            });
        });

        @if (isset($_GET['incoming_call']))
            if (localStorage.getItem('call_token')) {

                if (localStorage.getItem('call_token') == '{{$_GET['token']}}') {
                    localStorage.removeItem('call_token');
                    $('.select-user[data-id={{$_GET['incoming_call']}}]:first').trigger('click');
                    setTimeout(()=>{
                        $('#video-call').trigger('click');
                        setTimeout(function(){
                            imClient.sendMessage($('#user_id').val(),'AUTOANSWER');
                        },2000);
                    },500)
                }
            }
        @endif

        @if (isset($_GET['webapp-user']))
            // $('.tab-pane').removeClass('active in');
            // $('#wapp-clients').addClass('active in');
            $('.select-user[data-id="{{$_GET['webapp-user']}}"]:first').trigger('click');
        @endif

        // $.ajax({
        //     url: '{{url('loadRest')}}',
        //     type: 'GET',
        // })
        // .done(function(data) {

        //     $('#load-just-here').append(data);

        //     $.each(user_array, function(index, val) {
        //         console.log(val);
        //         $('#dot-online-'+val).removeClass('hide');
        //     });

        //     $('.operator.table').DataTable().fnDestroy()
            
        //     $('.select-user').unbind('click',selectUser);
        //     $('.modal-view-info').unbind('click',makeDraggable);
        //     $('.modal-edit-info').unbind('click',makeDraggable);
        //     $('[name="company"]').unbind('change',changeEvent);
        //     $('.ajax_info').unbind('submit',ajaxInfo);

        //     $('.select-user').click(selectUser);
        //     $('.modal-view-info').click(makeDraggable);
        //     $('.modal-edit-info').click(makeDraggable);
        //     $('[name="company"]').change(changeEvent);
        //     $('.ajax_info').submit(ajaxInfo);

        //     $('[name="policy_model"]').editableSelect();
        //     $('[name="phone_model"]').editableSelect();

        //     $('.wrapper [data-toggle="modal"]').click(function(e) {
        //         e.preventDefault();
        //         e.stopPropagation();
        //         var target = $(this).data('target');
        //         $(target).modal('show');
        //     });

        //     $('.wrapper .modal').click(function(e) {
        //         e.stopPropagation();
        //     });
            
        //     $('.operator.table').dataTable({
        //         "aaSorting": [[ 0, "desc" ]]
        //     });


        //     apiRTC.addEventListener("receiveIMMessage", receiveIMMessageHandler);
        //     apiRTC.addEventListener('connectedUsersListUpdate',(e)=>{
        //         if (e.detail.usersList) {
        //             $.each(e.detail.usersList, function(index, val) {
        //                 if (e.detail.status == 'online') {
        //                     $('#dot-online-'+val).removeClass('hide');
        //                 }else{
        //                     $('#dot-online-'+val).addClass('hide');
        //                 }
        //             });
        //         }

        //         if (!datatable) {
        //             $('.operator.table').dataTable({
        //                 "aaSorting": [[ 0, "desc" ]]
        //             });
        //             datatable = true;
        //         }
        //     })
        // });
    }

    function notificationCallOffline(id)
    {
        if (!apiRTC.session.isConnectedUser(id)) {
            // var usuarios = JSON.parse(localStorage.getItem('notificationCall'));
            $.post('{{ url('admin/send-call-notification') }}', {_token:'{{ csrf_token() }}', id: id}, function(data, textStatus, xhr) {
            });
            // var a = 0;
            // if (usuarios != null) {
            //     $.each(usuarios, function(index, val) {
            //         if (val == id) {
            //             a++;
            //         }
            //     });
            // }else{
            //     usuarios = [];
            // }
            // if (a == 0) {
            //     $.post('{{ url('admin/send-call-notification') }}', {_token:'{{ csrf_token() }}', id: id}, function(data, textStatus, xhr) {
            //     });
            //     usuarios.push(id);
            //     // localStorage.setItem('notificationCall',JSON.stringify(usuarios));
            // }
        }
    }

    $("#video-call").click(function () {
        if(!apiRTC.session.isConnectedUser($('#number').val())){
            notificationCallOffline($('#number').val())
            return alert('User is offline!')
        }
        if ($('#can_call').val() == 0) {
            alert('Non puoi chiamare! Verificare la configurazione...');
            return false;
        }else if($('#can_call').val() == -1){
            alert('Non puoi chiamare! Seleziona un cliente...');
            return false;
        }else if($('#can_call').val() == 2){
            alert('Non puoi chiamare! User offline...');
            return false;
        }else{
            segundos = 0;
            minutos = 0;
            $('#segundos').html('00');
            $('#minutos').html('00');
            $("#call").attr("disabled", true).html("Videochiamata");
            $("#hangup").attr("disabled", false).val("Riattacca");
            apiRTC.addEventListener("remoteHangup", remoteHangupHandler);
            // sendIMMessage($('#number').val(),'a42a97e5fc834380e2ead93c15504f54b90ec3f9');
            var _callId = webRTCClient.call($("#number").val(),{},{record:true,mode:"efficient"/*,muted:"VIDEOONLY"*/});
        }
    });
    $("#audio-call").click(function () {
        if(!apiRTC.session.isConnectedUser($('#number').val())){
            notificationCallOffline($('#number').val())
            return alert('User is offline!')
        }
        if ($('#can_call').val() == 0) {
            alert('Non puoi chiamare! Verificare la configurazione...');
            return false;
        }else if($('#can_call').val() == -1){
            alert('Non puoi chiamare! Seleziona un cliente...');
            return false;
        }else if($('#can_call').val() == 2){
            alert('Non puoi chiamare! User offline...');
            return false;
        }else{
            segundos = 0;
            minutos = 0;
            $('#segundos').html('00');
            $('#minutos').html('00');
            $("#call").attr("disabled", true).html("Chiamata Audio");
            $("#hangup").attr("disabled", false).val("Riattacca");
            apiRTC.addEventListener("remoteHangup", remoteHangupHandler);
            // sendIMMessage($('#number').val(),'a37bb50762b2f84b70c682d4d1f0ae4c34da1a8c');
            var _callId = webRTCClient.callAudio($("#number").val());
        }
    });
    $("#hangup").click(function () {
        $("#call").attr("disabled", false).html("Chiamata <span class='caret'></span>");
        $("#hangup").attr("disabled", true).val("Riattacca");
        // sendIMMessage($('#number').val(),'7b7571496c87c763011dda72cb82e2a919724203');
        webRTCClient.hangUp();
    });

    $('#my_message').on('keyup', function(e) {
        var variable = "";
        if ($(this).val() != variable.trim()) {
            if (e.which == 13) {
                destId = $("#number").val();
                var message=$("#my_message").val();
                sendIMMessage(destId, message);
                saveMessage({{ Auth::user()->id }},$('#user_id').val())
                //Just reset your message box
                $("#my_message").val('');
            }
        }
    });

    $('#send_my_message').on('click', function(e) {
        var variable = "";
        if ($("#my_message").val() != variable.trim()) {
            destId = $("#number").val();
            var message=$("#my_message").val();
            sendIMMessage(destId, message);
            saveMessage({{ Auth::user()->id }},$('#user_id').val())
            //Just reset your message box
            $("#my_message").val('');
        }
    });

    function saveMessage(from_id, to_id){
        var message = $('#my_message').val();
        $.post('{{ url('admin/saveMessage') }}', {to_id: to_id, from_id: from_id, message: message, _token: '{{ csrf_token() }}'}, function(data, textStatus, xhr) {
            /*optional stuff to do after success */
        });
    }

    function savePicture(from_id, to_id, picture){
        var message = picture;
        $.post('{{ url('admin/saveMessage') }}', {to_id: to_id, from_id: from_id, message: message, _token: '{{ csrf_token() }}'}, function(data, textStatus, xhr) {
            /*optional stuff to do after success */
        });
    }
</script>

<script>
  function initMap() {
  	navigator.geolocation.getCurrentPosition(function(position) {
        var pos = {
	      lat: position.coords.latitude,
	      lng: position.coords.longitude
	    };

	    var map = new google.maps.Map(document.getElementById('panel3'), {
	      zoom: 16,
	      center: pos,
	      // mapTypeControl: false,
		  streetViewControl: false,
		  rotateControl: false,
          mapTypeId: 'roadmap'
	    });
	    var marker = new google.maps.Marker({
	      position: pos,
	      map: map
	    });
	});
  }

  function urlify(text) {
    if (text.indexOf('<a href="#" data-url') != -1) {
        return text.replace('href="#" data-url','target="_blank" href');
    }
    if (text.indexOf('<a href="#" data-img') != -1) {
        return text.replace('href="#" data-img','target="_blank" href');
    }
    return text;
    // var urlRegex = /(https?:\/\/[^\s]+)/g;
    // return text.replace(urlRegex, function(url) {
    //     return '<a href="' + url + '" target="_blank">' + url + '</a>';
    // })
}

    var _webappuser = false;

    function selectUser(event) {
        if ($(this).hasClass('webappuser')) {
            _webappuser = true;
        }else{
            _webappuser = false;
        }
        console.log('select-user')
        var id = $(this).parent('tr').data('id');

        $('div.div_messages .panel').block({ message: 'Loading Messages from '+($(this).parent('tr').data('name'))+'... Please wait...' });

        if (xhr_msgs) {   
            xhr_msgs.abort();
        }

        xhr_msgs = $.post('{{ url('admin/loadMessages') }}', { to_id: id, from_id: {{ Auth::user()->id }}, _token: '{{ csrf_token() }}'}, function(data, textStatus, xhr) {
            var html = "";
            // $.each(data[0], function(index, val) {
            //     if (val.from.name == '{{ Auth::user()->name }}') {
            //         html += '<div class="contenedor"><div class="well me"><span class="label label-success">Io:</span> '+urlify(val.message)+' </div></div><div class="date-me">'+val.created+'</div>';
            //     }else{
            //         html += '<div class="contenedor"><div class="well notme"><span class="label label-danger">'+val.from.name+':</span> '+urlify(val.message)+' </div></div><div class="date-notme">'+val.created+'</div>';
            //     }
            // });

            // $('.messages').html(html);

            var imagenes = "<div id='img-carousel'>";
            $.each(data[1][0], function(index, val) {
                imagenes += "<div style='padding: 0 6px;'>\
                        <div style='position:relative;'><button style='position:absolute; right: -5px; top: 15px;' class='btn badge label-danger delete-this' data-id='"+val.id+"'><i class='fa fa-times'></i></button>\
                            <a href='"+val.full_imagen+"' download class='btn btn-info btn-xs'><i class='fa fa-download'></i> SALVA</a>   \
                        </div>\
                        <div style='background-image: url("+val.imagen+"); background-size: cover; background-position: center; height: 110px;'>\
                        </div>\
                    </div>";
            });
            imagenes += "</div>";

            $('#panel-imagenes').html(imagenes);

            $('#img-carousel').owlCarousel({
                items: 5,
                itemsDesktop: [1199,4],
                itemsDesktopSmall: [979,3],
                itemsTablet: [768,3],
                pagination: true
            });
            /**/
            setTimeout(()=>{
                $(".messages").scrollTop(document.getElementsByClassName('messages')[0].scrollHeight);
            },100);

            var imagenes = "<div id='img-carousel-1'>";
            $.each(data[1][1], function(index, val) {
                imagenes += "<div style='padding: 0 6px;'>\
                        <div style='position:relative;'><button style='position:absolute; right: -5px; top: 15px;' class='btn badge label-danger delete-this' data-id='"+val.id+"'><i class='fa fa-times'></i></button>\
                            <a href='"+val.full_imagen+"' download class='btn btn-info btn-xs'><i class='fa fa-download'></i> SALVA</a>   \
                        </div>\
                        <div style='background-image: url("+val.imagen+"); background-size: cover; background-position: center; height: 110px;'>\
                        </div>\
                    </div>";
            });
            imagenes += "</div>";

            $('.messages').html(imagenes);

            $('#img-carousel-1').owlCarousel({
                items: 5,
                itemsDesktop: [1199,4],
                itemsDesktopSmall: [979,3],
                itemsTablet: [768,3],
                pagination: true
            });
            $('.delete-this').click(deleteThis);
            if (data[2] == 1) {
                $('#can_call').val('1');
            }else{
                $('#can_call').val('1');
            }
            $('div.div_messages .panel').unblock();
        });

        $('#user_id').val(id);
        $("#number").val(id);
        $('#user_name').val($(this).parent('tr').find('.select-name').html());
        $('#map-name').html($(this).parent('tr').find('.select-name').html());
        $('#nameToUse').val($(this).parent('tr').find('.select-name').html());

        $.ajax({
            url: $('#user_id').data('url')+'/'+$('#user_id').val(),
            type: 'GET'
        })
        .done(function(data) {
            if (!apiRTC.session.isConnectedUser(data.call_id)) {
                console.log('User is offline!')
            }
            $('#latToSave').val(data.lat);
            $('#lonToSave').val(data.lng);
            $('#last-connected').html(data.date);

            var pos = {
              lat: parseFloat(data.lat),
              lng: parseFloat(data.lng)
            };

            var map = new google.maps.Map(document.getElementById('panel3'), {
              zoom: 16,
              center: pos,
              // mapTypeControl: false,
              streetViewControl: false,
              rotateControl: false,
              mapTypeId: 'roadmap'
            });
            var marker = new google.maps.Marker({
              position: pos,
              map: map
            });

            console.log(pos);

            var geo = new google.maps.Geocoder();

            geo.geocode({'latLng': pos}, function(results,status) {
                console.log('1',results)
                $('#map-address').html(results[0]['formatted_address']);
            });
        })
        .fail(function(r) {
            // initMap();
            // $('#can_call').val('2');
            // alert(JSON.parse(r.responseText)[0]);
        });
        /**/
    }

    var segundos = 0;
    var minutos = 0;
    var segundosr = 0;
    var minutosr = 0;

    function cronometro () {
        if (segundos < 59) {
            segundos ++;
            if (segundos < 10) {segundos = "0"+segundos}
            $('#segundos').html(segundos);
        }
        if (segundos == 59) {
            segundos = -1;
        }
        if (segundos == 0) {
            minutos++;
            if (minutos < 10) {minutos = "0"+minutos}
            $('#minutos').html(minutos);
        }

    }

    function cronometro2 () {
        if (segundosr < 59) {
            segundosr ++;
            if (segundosr < 10) {segundosr = "0"+segundosr}
            $('#segundos-rec').html(segundosr);
        }
        if (segundosr == 59) {
            segundosr = -1;
        }
        if (segundosr == 0) {
            minutosr++;
            if (minutosr < 10) {minutosr = "0"+minutosr}
            $('#minutos-rec').html(minutosr);
        }
    }

    $('#paperclip').change(function(event) {
        var input = this;
        var _this = $(this);
        if ($("#number").val() == '' || $("#number").val() == null) {
            alert('No user selected');
        }else{
            var formData = new FormData();
            formData.append('file',input.files[0]);
            formData.append('id',$("#number").val());
            formData.append('_token','{{ csrf_token() }}');
            $.ajax({
                url: '{{ url('uploadFileChat') }}',
                type: 'POST',
                contentType: false,
                processData: false,
                data: formData,
            })
            .done(function(data) {
                var message = '<a href="#" data-img="'+data+'"><div style="background-size:cover;background-position:center; background-image:url('+data+');width:300px;height:200px"></div></a>';
                destId = $("#number").val();
                sendIMMessage(destId, message);
                savePicture({{ Auth::user()->id }},$('#user_id').val(),message)
                _this.val('');
                console.log("success");
            });
            
            // if (input.files && input.files[0]) {
            //     var reader = new FileReader();

            //     console.log(reader)

            //     reader.onload = function (e) {
            //         var message = '<img src="'+e.target.result+'" alt="" style="max-width:300px;height:200px" />';
            //         destId = $("#number").val();
            //         sendIMMessage(destId, message);
            //         savePicture({{ Auth::user()->id }},$('#user_id').val(),message)
            //         $(this).val('');
            //     }

            //     reader.readAsDataURL(input.files[0]);
            // }else{
            //     console.log('djfhsdkjf')
            // }
        }
    });

    $('.wrapper [data-toggle="modal"]').click(function(e) {
        e.preventDefault();
        e.stopPropagation();
        var target = $(this).data('target');
        $(target).modal('show');
    });

    $('.wrapper .modal').click(function(e) {
        e.stopPropagation();
    });

    $('[data-toggle="tooltip"]').tooltip();

</script>

<script
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsj-gbtqTAsxtWNbcqrRmE8ExatChS_Ko&callback=initMap">
</script>

<script>
    function setZoom(){

    /* predefine zoom and rotate */
      var zoom = 1,
          rotate = 0;

    /* Grab the necessary DOM elements */
      var stage = document.getElementById('myRemoteVideo'),
          v = document.querySelector('#myRemoteVideo video'),
          controls = document.getElementById('controls');
      
    /* Array of possible browser specific settings for transformation */
      var properties = ['transform', 'WebkitTransform', 'MozTransform',
                        'msTransform', 'OTransform'],
          prop = properties[0];

    /* Iterators and stuff */    
      var i,j,t;
      
    /* Find out which CSS transform the browser supports */
      for(i=0,j=properties.length;i<j;i++){
        if(typeof stage.style[properties[i]] !== 'undefined'){
          prop = properties[i];
          break;
        }
      }

    /* Position video */
      v.style.left = 0;
      v.style.top = 0;

    /* If there is a controls element, add the player buttons */
    /* TODO: why does Opera not display the rotation buttons? */
      $('#controls').removeClass('hidden');
      if(controls){
        controls.innerHTML =  '<div id="change">' +
                                '<button class="zoomin">+</button>' +
                                '<button class="zoomout">-</button>' +
                                '<button class="left">⇠</button>' +
                                '<button class="right">⇢</button>' +
                                '<button class="up">⇡</button>' +
                                '<button class="down">⇣</button>' +
                                '<button class="rotateleft">&#x21bb;</button>' +
                                '<button class="rotateright">&#x21ba;</button>' +
                                '<button class="reset">reset</button>' +
                              '</div>';
      }

    /* If a button was clicked (uses event delegation)...*/
      controls.addEventListener('click',function(e){
        t = e.target;
        if(t.nodeName.toLowerCase()==='button'){

    /* Check the class name of the button and act accordingly */    
          switch(t.className){

    /* Toggle play functionality and button label */    
            case 'play':
              if(v.paused){
                v.play();
                t.innerHTML = 'pause';
              } else {
                v.pause();
                t.innerHTML = 'play';
              }
            break;

    /* Increase zoom and set the transformation */
            case 'zoomin':
              zoom = zoom + 0.1;
              v.style[prop]='scale('+zoom+') rotate('+rotate+'deg)';
            break;

    /* Decrease zoom and set the transformation */
            case 'zoomout':
              zoom = zoom - 0.1;
              v.style[prop]='scale('+zoom+') rotate('+rotate+'deg)';
            break;

    /* Increase rotation and set the transformation */
            case 'rotateleft':
              rotate = rotate + 5;
              v.style[prop]='rotate('+rotate+'deg) scale('+zoom+')';
            break;
    /* Decrease rotation and set the transformation */
            case 'rotateright':
              rotate = rotate - 5;
              v.style[prop]='rotate('+rotate+'deg) scale('+zoom+')';
            break;

    /* Move video around by reading its left/top and altering it */
            case 'left':
              v.style.left = (parseInt(v.style.left,10) - 5) + 'px';
            break;
            case 'right':
              v.style.left = (parseInt(v.style.left,10) + 5) + 'px';
            break;
            case 'up':
              v.style.top = (parseInt(v.style.top,10) - 5) + 'px';
            break;
            case 'down':
              v.style.top = (parseInt(v.style.top,10) + 5) + 'px';
            break;

    /* Reset all to default */
            case 'reset':
              zoom = 1;
              rotate = 0;
              v.style.top = 0 + 'px';
              v.style.left = 0 + 'px';
              v.style[prop]='rotate('+rotate+'deg) scale('+zoom+')';
            break;
          }        

          e.preventDefault();
        }
      },false);
    }
    function resetZoom()
    {
        $('.reset').trigger('click');
        $('#controls').addClass('hidden');
    }

    $('.can_call').change(function(event) {
        event.stopPropagation();
        var id = $(this).data('id');
        $.post('{{ url('admin/change_can_call') }}', {id: id, _token: '{{ csrf_token() }}'}, function(data, textStatus, xhr) {
            imClient.sendMessage(id,'eaf2ea9f6559f226c8f433830b397204fe28ffdc');
        });
    });

$('.select-user').click(selectUser);
$('.modal-view-info').click(makeDraggable);
$('.modal-edit-info').click(makeDraggable);
$('[name="company"]').change(changeEvent);
$('.ajax_info').submit(ajaxInfo);

function makeDraggable(e) {
    $('body').css('overflow', 'auto');
  e.stopPropagation();
  // reset modal if it isn't visible
  var modal = $(this).data('modal');
  if (!($(modal+'.modal.in').length)) {
    $(modal+' .modal-dialog').css({
      top: 0,
      left: 0
    });
  }
  $(modal).modal({
    backdrop: false,
    show: true
  });

  $(modal+' .modal-dialog').draggable({
    handle: ".modal-header"
  });
}

$('[name="phone_model"]').editableSelect();

function changeEvent(event) {
    var elem = $(this).parents('.modal-edit').find('.editable-select');
    elem.html("");
    var company = $(this).val();
    $.post('{{ url('find_company') }}', {_token: '{{ csrf_token() }}', company : company}, function(data, textStatus, xhr) {
        var html = "<select name='policy_model' class='form-control'>";
            html+="<option value='' selected disabled></option>"
        $.each(data, function(index, val) {
            html+="<option value='"+val.name+"'>"+val.name+"</option>"
        });
        html+="</select>"
        elem.html(html);
        $('[name="policy_model"]').editableSelect();
    });
}

function ajaxInfo(event) {
    event.preventDefault();

    $.post($(this).attr('action'), $(this).serialize(), function(data, textStatus, xhr) {
        alert('Informazioni salvate!')

        let new_model = data[1];
        data = data[0];

        $('#modal-edit-info-'+data.user_id).modal('hide');
        $('#info-'+data.user_id).html('\
            <div class="col-sm-6">\
                <div class="form-group" style="margin-bottom: 10px;">\
                    <b>Riferimento Interno:</b> <br>\
                    - '+(data.sin_number != null ? data.sin_number : "")+'\
                </div>\
            </div>\
            <div class="col-sm-6">\
                <div class="form-group" style="margin-bottom: 10px;">\
                    <b>Compagnia:</b> <br>\
                    - '+(data.company != null ? data.company : "")+'\
                </div>\
            </div>\
            <div class="col-sm-6">\
                <div class="form-group" style="margin-bottom: 10px;">\
                    <b>Numero di polizza:</b> <br>\
                    - '+(data.policy != null ? data.policy : "")+'\
                </div>\
            </div>\
            <div class="col-sm-6">\
                <div class="form-group" style="margin-bottom: 10px;">\
                    <b>Modello di polizza:</b> <br>\
                    - '+(data.policy_model != null ? data.policy_model : "")+'\
                </div>\
            </div>\
            <div class="col-sm-6">\
                <div class="form-group" style="margin-bottom: 10px;">\
                    <b>Tipologia di danno:</b> <br>\
                    - '+(data.damage != null ? data.damage : "")+'\
                </div>\
            </div>\
            <div class="col-sm-6">\
                <div class="form-group" style="margin-bottom: 10px;">\
                    <b>Tipologia di assicurazione:</b> <br>\
                    - '+(data.insurance != null ? data.insurance : "")+'\
                </div>\
            </div>\
            <div class="col-sm-6">\
                <div class="form-group" style="margin-bottom: 10px;">\
                    <b>Franchigia / Scoperto:</b> <br>\
                    - '+(data.franchise != null ? data.franchise : "")+'\
                </div>\
            </div>\
            <div class="col-sm-6">\
                <div class="form-group" style="margin-bottom: 10px;">\
                    <b>Limite di indennizzo:</b> <br>\
                    - '+(data.limit != null ? data.limit : "")+'\
                </div>\
            </div>\
            <div class="col-sm-6">\
                <div class="form-group" style="margin-bottom: 10px;">\
                    <b>Quantificazione di danno proposta:</b> <br>\
                    - '+(data.quantification1 != null ? data.quantification1 : "")+'\
                </div>\
            </div>\
            <div class="col-sm-6">\
                <div class="form-group" style="margin-bottom: 10px;">\
                    <b>Quantificazione di danno definita:</b> <br>\
                    - '+(data.quantification2 != null ? data.quantification2 : "")+'\
                </div>\
            </div>\
            <div class="col-sm-6">\
                <div class="form-group" style="margin-bottom: 10px;">\
                    <b>Modello di telefono:</b> <br>\
                    - '+(data.phone_model != null ? data.phone_model : "")+'\
                </div>\
            </div>\
            <div class="col-sm-6">\
                <div class="form-group" style="margin-bottom: 10px;">\
                    <b>Funziona:</b> <br>\
                    - '+(data.phone_works != null ? data.phone_works : "")+'\
                </div>\
            </div>\
            <div class="col-sm-12">\
                <div class="form-group">\
                    <b>Note:</b> <br>\
                    '+(data.notes != null ? data.notes : "")+'\
                </div>\
            </div>\
            ');

        if (new_model) {
            $('[name="phone_model"]').editableSelect('add', new_model.name);
        }
        // $('.riferimento-'+data.user_id).text(data.sin_number);
        console.log(data);
    });


}

$('#sendDesactivarLink').click(function(event) {
    $('tr[data-id="'+$('#user_id').val()+'"').remove();

    if ($('#load-just-here tr[data-id').length == 0) {
        $('#load-just-here').html('<tr>\
                                    <td colspan="6" style="text-align: center;"><i>Usa la funzione ricerca per far comparire qui i clienti...</i></td>\
                                   </tr>');
    }
    $('#user_name').val("");
    $.get('{{url('admin/desactivarLink')}}/'+$('#user_id').val(), function(data) {
        let id = $('#user_id').val();
        window.open('{{url('admin/view-customer')}}/'+id,'_blank');
        $('#user_id').val("");
        console.log('complete');
    });
});

$('.start-search').click(function(event) {
    if ($('[name="search"]').val() == "" || !$('[name="search"]').val()) {
        return false;
    }

    $.post('{{url('admin/startSearch')}}', {search: $('[name="search"]').val(), _token:'{{csrf_token()}}'}, function(data, textStatus, xhr) {
        $('#load-just-here').html(data);

        $('.select-user').click(selectUser);
        $('.modal-view-info').click(makeDraggable);
        $('.modal-edit-info').click(makeDraggable);
        $('[name="company"]').change(changeEvent);
        $('.ajax_info').submit(ajaxInfo);
        $('.copy-link').click(copyLink);
        $('.send-form-sms').submit(sendFormSms);

        $('.wrapper [data-toggle="modal"]').click(function(e) {
            e.preventDefault();
            e.stopPropagation();
            var target = $(this).data('target');
            $(target).modal('show');
        });

        $('.wrapper .modal').click(function(e) {
            e.stopPropagation();
        });

        $('[data-toggle="tooltip"]').tooltip();

        $.each($('tr[data-id').find('.select-user.webappuser:first'), function(index, val) {
            if (apiRTC.session.isConnectedUser($(this).data('id').toString())) {
                $('#dot-online-'+$(this).data('id')).removeClass('hide');
                user_array.push($(this).data('id'));
            }else{
                $('#dot-online-'+$(this).data('id')).addClass('hide');
                user_array.slice(user_array.findIndex(x=> x == $(this).data('id')),1);
            }
            // if (e.detail.status == 'online') {
            //     $('#dot-online-'+val).removeClass('hide');
            //     user_array.push(val);
            // }else{
            //     $('#dot-online-'+val).addClass('hide');
            //     user_array.slice(user_array.findIndex(x=> x == val),1);
            // }
        });

        if (!datatable) {
            $('.operator.table-').dataTable({
                "aaSorting": [[ 0, "desc" ]]
            });
            datatable = true;
        }

        $('.convertMp4').click(convertMp4);

        $('.display.table').dataTable();
    });
});

    function convertMp4(event) {
        $('.modal.fade.in .modal-content').block({message:'Converting video to MP4... please wait'});
        let id = $(this).data('id');
        let video = $(this).data('href');
        $.post('{{url('api/convertMp4')}}', {id: id}, function(data, textStatus, xhr) {

            $('#links-'+id).html('<a href="'+data[0]+'" target="_blank" class="btn btn-info btn-xs">View</a>');

            window.open(data[0],'_blank');

            $('.modal.fade.in .modal-content').unblock();
        });
    }

    $('.convertMp4').click(convertMp4);


    /****/

    function saveBlobToDB(recordedBlob) {
        // IndexedDB
        var /*indexedDB = window.indexedDB || window.webkitIndexedDB || window.mozIndexedDB || window.OIndexedDB || window.msIndexedDB,
            IDBTransaction = window.IDBTransaction || window.webkitIDBTransaction || window.OIDBTransaction || window.msIDBTransaction,*/
            dbVersion = 1.0;

        // Create/open database
        var request = indexedDB.open("elephantFiles", dbVersion),
            db,
            createObjectStore = function (dataBase) {
                // Create an objectStore
                console.log("Creating objectStore")
                dataBase.createObjectStore("elephants");
            },

            putElephantInDb = function (blob) {
                console.log("Putting elephants in IndexedDB");

                // Open a transaction to the database
                var transaction = db.transaction(["elephants"], "readwrite");

                // Put the blob into the dabase
                transaction.objectStore("elephants").put(blob, "file");
                transaction.objectStore("elephants").put($('#map-address').text(),"address");

                // Retrieve the file that was just stored
                // transaction.objectStore("elephants").get("blob").onsuccess = function (event) {
                //     var imgFile = event.target.result;
                //     console.log("Got elephant!" + imgFile);

                //     // Get window.URL object
                //     var URL = window.URL || window.webkitURL;

                //     // Create and revoke ObjectURL
                //     var imgURL = URL.createObjectURL(imgFile);

                //     // Set img src to ObjectURL
                //     var imgElephant = document.getElementById("elephant");
                //     imgElephant.setAttribute("src", imgURL);

                //     // Revoking ObjectURL
                //     URL.revokeObjectURL(imgURL);
                // };
            };

        request.onerror = function (event) {
            console.log("Error creating/accessing IndexedDB database");
        };

        request.onsuccess = function (event) {
            console.log("Success creating/accessing IndexedDB database");
            db = request.result;

            db.onerror = function (event) {
                console.log("Error creating/accessing IndexedDB database");
            };
            
            // Interim solution for Google Chrome to create an objectStore. Will be deprecated
            if (db.setVersion) {
                if (db.version != dbVersion) {
                    var setVersion = db.setVersion(dbVersion);
                    setVersion.onsuccess = function () {
                        createObjectStore(db);
                        putElephantInDb(recordedBlob);
                    };
                }
                else {
                    putElephantInDb(recordedBlob);
                }
            }
            else {
                putElephantInDb(recordedBlob);
            }
        }
        
        // For future use. Currently only in latest Firefox versions
        // request.onupgradeneeded = function (event) {
        //     createObjectStore(event.target.result);
        // };
    };


    /**/
    // detect indexeddb
    /**/
    function getDB() {
        var dbVersion = 1.0;
        // Create/open database
        var request = indexedDB.open("elephantFiles", dbVersion),
            db,
            retrieveFile = function () {

                var transaction = db.transaction(["elephants"], "readwrite");

                // Retrieve the file that was just stored
                transaction.objectStore("elephants").get("address").onsuccess = function (event) {
                    console.log(event.target.result);
                };
                // transaction.objectStore("elephants").get("file").onsuccess = function (event) {
                //     var imgFile = event.target.result;
                //     console.log("Got elephant!" + imgFile);

                //     // Get window.URL object
                //     var URL = window.URL || window.webkitURL;

                //     // Create and revoke ObjectURL
                //     var imgURL = URL.createObjectURL(imgFile);

                //     // Set img src to ObjectURL
                //     var imgElephant = document.getElementById("elephant");
                //     imgElephant.setAttribute("src", imgURL);

                //     // Revoking ObjectURL
                //     URL.revokeObjectURL(imgURL);
                // };
            };

        request.onerror = function (event) {
            console.log("Error creating/accessing IndexedDB database");
        };

        request.onsuccess = function (event) {
            console.log("Success creating/accessing IndexedDB database");
            db = request.result;

            db.onerror = function (event) {
                console.log("Error creating/accessing IndexedDB database");
            };
            
            // Interim solution for Google Chrome to create an objectStore. Will be deprecated
            if (db.setVersion) {
                if (db.version != dbVersion) {
                    var setVersion = db.setVersion(dbVersion);
                    setVersion.onsuccess = function () {
                        retrieveFile();
                    };
                }
                else {
                    retrieveFile();
                }
            }
            else {
                retrieveFile();
            }
        }
        
        // For future use. Currently only in latest Firefox versions
        // request.onupgradeneeded = function (event) {
        //     createObjectStore(event.target.result);
        // };
    };

</script>

@endsection

@stop