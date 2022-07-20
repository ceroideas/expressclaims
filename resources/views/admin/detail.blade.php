@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<style>
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
    /* The switch - the box around the slider */
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    .green {
        color: lightgreen;
    }
    #print_sinistro {
        display: none;
    }
    .rotate-inner {
        overflow: hidden;
    }
    .rotate-inner > a > div {
        transform: rotate(90deg);
        height: 300px !important;
        width: 300px !important;
    }
    @media print {
        #print_sinistro {
            display: block !important;
        }
    }
</style>
<input type="hidden" id="nameToUse" value="{{ $u->name }}">
<div class="row">
    <div class="col-xs-12 col-sm-6">
        <h3>{{ $u->name }}</h3>
        <h5>Numero di Telefono: <b>{{ $u->customer ? '+'.$u->customer->phone : $u->webapp->code.$u->webapp->phone }}</b></h5>
        <h5>Ultima data di Contatto: <b>{{ $u->lastContact() }}</b></h5>

        <h5 class="">
            <label for="">Riferimento interno: </label>
            @php
                $res = App\Reservation::where(['customer_id' => $u->id, 'status' => 0])->first();
            @endphp
            @if ($res)
            <script>
                $.get('{{url('addInfoClaims',$res->id)}}', function(data) {
                    console.log('ok');
                });
            </script>   
            {{ $res->sin_number }}
            {{-- <a href="#modal-edit" data-toggle="modal"><i class="fa fa-pencil"></i></a>
            <div class="modal fade" id="modal-edit">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <form action="{{ url('admin/edit-sinister') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $res->id }}">
                            <input type="hidden" name="user_id" value="{{ $u->id }}">
                            <div class="modal-header">
                                Modifica Riferimento interno
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="sin_number" placeholder="Riferimento interno" required value="{{ $res->sin_number }}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-xs btn-info add-sinister" data-id="{{ $u->id }}">Confermare</button>
                                <button type="button" data-dismiss="modal" class="btn btn-xs btn-danger">Annullare</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div> --}}
            @else
            @if ($u->webapp)
                @php
                    $res = App\Reservation::where(['customer_id' => $u->id])->first();
                @endphp
                @if ($res)
                    {{ $res->sin_number }}

                    <script>
                        $.get('{{url('addInfoClaims',$res->id)}}', function(data) {
                            console.log('ok');
                        });
                    </script>   
                @endif
            @else
            <form action="{{ url('admin/create-sinister') }}" method="POST">
                {{ csrf_field() }}
                <div class="input-group">
                    <input type="text" class="form-control" name="sin_number" placeholder="Riferimento interno" required>
                    <input type="hidden" name="user_id" value="{{ $u->id }}">
                    <span class="input-group-btn">
                        <button type="button" class="btn btn-info add-sinister" data-id="{{ $u->id }}">Aggiornare Riferimento interno</button>
                    </span>
                </div>
            </form>
            @endif
            @endif
        </h5>
        @if(Session::get('warning'))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert alert-warning warning-bordered">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
                        <span class="text-semibold">{{session('warning')}}</span>
                    </div>
                </div>
            </div>
        @endif
        @if ($u->customer)
        <h5 class="">
            <label for="">Informazioni:</label>
            <a href="#modal-view-info"><i class="fa fa-eye"></i></a>
            <a href="#modal-edit-info"><i class="fa fa-pencil"></i></a>
        </h5>
        @endif
<style>
    /*#modal-edit-info {
      position: relative;
    }*/

    /*#modal-edit-info .modal-dialog {
      position: fixed;
      margin: 0;
      padding: 10px;
    }*/
    #modal-edit-info .modal-dialog .modal-content {
        box-shadow: 0px 0px 5px silver;
    }
    #modal-view-info .modal-dialog .modal-content {
        box-shadow: 0px 0px 5px silver;
    }
</style>
        @if ($u->customer)
        <div class="modal fade" id="modal-view-info">
            <div class="modal-dialog">
                <div class="modal-content">
                    @php
                        $info = App\Detail::where('user_id',$u->id)->first();
                    @endphp
                    <div class="modal-header">Vedere le informazioni <button class="btn btn-xs btn-info" id="btn-print-info">Export</button>
                        <span class="pull-right">Riferimento Interno: {{ $res ? $res->sin_number : '' }}</span>
                    </div>
                    <div class="modal-body printAreaInfo">
                        <img src="{{ url('renova.png') }}" alt="" width="100px">
                        <h5><b>Nome: </b>{{$u->name}}</h5>
                        <h5><b>Telefono: </b>{{$u->customer->phone}}</h5>
                        <h5 id="print_sinistro"><b>Riferimento Interno: </b>{{ $res ? $res->sin_number : '' }}</h5>
                        <hr>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b for="">Numero sinistro:</b> <br>
                                    - {{ $info ? $info->sin_number : '' }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b for="">Compagnia:</b> <br>
                                    - {{ $info ? $info->company : '' }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b for="">Numero di polizza:</b> <br>
                                    - {{ $info ? $info->policy : '' }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b for="">Modello di polizza:</b> <br>
                                    - {{ $info ? $info->policy_model : '' }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b for="">Tipologia di danno:</b> <br>
                                    - {{ $info ? $info->damage : '' }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b for="">Tipologia di assicurazione:</b> <br>
                                    - {{ $info ? $info->insurance : '' }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b for="">Franchigia / Scoperto:</b> <br>
                                    - {{ $info ? $info->franchise : '' }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b for="">Limite di indennizzo:</b> <br>
                                    - {{ $info ? $info->limit : '' }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b for="">Quantificazione di danno proposta:</b> <br>
                                    - {{ $info ? $info->quantification1 : '' }}
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <b for="">Quantificazione di danno definita:</b> <br>
                                    - {{ $info ? $info->quantification2 : '' }}
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <b for="">Note:</b> <br>
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
        @endif

        <div class="modal fade" id="modal-edit-info">
            <div class="modal-dialog">
                <form action="{{ url('admin/saveInformation') }}" method="POST" class="modal-content">
                    @php
                        $info = App\Detail::where('user_id',$u->id)->first();
                    @endphp
                    <div class="modal-header">Informazioni
                        <span class="pull-right">Riferimento Interno: {{ $res ? $res->sin_number : '' }}</span>
                        {{-- <span class="pull-right">Riferimento Interno: <input type="text" style="border: 1px solid #ccc; border-radius: 6px; color: #333; padding-left:5px" readonly="" name="sin_number" value="{{ $res ? $res->sin_number : '' }}"></span> --}}
                    </div>
                    <div class="modal-body">
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{ $u->id }}">
                        <div class="row">
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <b for="">Numero sinistro:</b>
                                    <input type="text"{{--  value="{{ $info ? $info->sin_number : '' }}" --}} name="sin_number" class="form-control" value="{{ $info ? $info->sin_number : '' }}">
                                </div>
                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <b for="">Compagnia:</b>
                                    <select name="company" class="form-control">
                                        <option value="" selected disabled></option>
                                        @foreach (App\Company::all() as $cm)
                                            <option {{ $info ? ($info->company == $cm->name ? 'selected' : '') : '' }} value="{{ $cm->name }}">{{ $cm->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <b for="">Numero di polizza:</b>
                                    <input type="text" value="{{ $info ? $info->policy : '' }}" name="policy" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <b for="">Modello di polizza:</b>
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
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <b for="">Tipologia di danno:</b>
                                    <select name="damage" class="form-control">
                                        <option value="" selected disabled></option>
                                        @foreach (App\Damage::all() as $d)
                                            <option {{ $info ? ($info->damage == $d->name ? 'selected' : '') : '' }} value="{{ $d->name }}">{{ $d->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <b for="">Tipologia di assicurazione:</b>
                                    <select name="insurance" class="form-control">
                                        <option value="" selected disabled></option>
                                        <option {{ $info ? ($info->insurance == 'Valore intero' ? 'selected' : '') : '' }} value="Valore intero">Valore intero</option>
                                        <option {{ $info ? ($info->insurance == 'Primo rischio assoluto' ? 'selected' : '') : '' }} value="Primo rischio assoluto">Primo rischio assoluto</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <b for="">Franchigia / Scoperto:</b>
                                    <input type="text" value="{{ $info ? $info->franchise : '' }}" name="franchise" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <b for="">Limite di indennizzo:</b>
                                    <input type="text" value="{{ $info ? $info->limit : '' }}" name="limit" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <b for="">Quantificazione di danno proposta:</b>
                                    <input type="text" value="{{ $info ? $info->quantification1 : '' }}" name="quantification1" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-6">

                                <div class="form-group">
                                    <b for="">Quantificazione di danno definita:</b>
                                    <input type="text" value="{{ $info ? $info->quantification2 : '' }}" name="quantification2" class="form-control">
                                </div>
                            </div>

                            <div class="col-sm-12">

                                <div class="form-group">
                                    <b for="">Note:</b>
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
    </div>
    <div class="col-xs-12 col-sm-6">
        @if ($u->customer)
        <h3>Attiva Chiamata</h3>
        <label class="switch">
          <input type="checkbox" id="can_call" {{ $u->customer->can_call == 1 ? 'checked' : '' }}>
          <span class="slider round"></span>
        </label>
        @else
        <h3>&nbsp;</h3>
        <br><br>
        @endif

        <h4><i class="fa fa-dot-circle-o"></i> <span id="user_status">...</span></h4>
    </div>
</div>
<div class="row">
	<div class="col-md-6 ">
        <div class="row">
            <div class="col-xs-12">
                <span class="hide" id="myCallId"></span>
                <input type="hidden" id="number" value="{{ $u->customer ? $u->customer->call_id : $u->id }}">
                <input type="hidden" id="user_id" value="{{ $u->id}}">
                <div class="panel">
                    <div class="panel-heading">Chiamate Registrate</div>
                    <div class="panel-body" id="panel1" style="position: relative;">
                        <div class="row" style="position: relative;">
                            <div class="col-xs-12 clients table-responsive" style="height: 100%; position: relative;">

                                <table class="table display2 table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            {{-- <th>ID</th> --}}
                                            <th>Clienti</th>
                                            <th>Indirizzo</th>
                                            <th>Data</th>
                                            <th>Durata</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $records = App\Record::where('user_id',$u->id)->whereExists(function($q){
                                                // $q->from('reservations')
                                                  /*->whereRaw('reservations.id = records.reservation_id')
                                                  ->whereRaw('reservations.status = 0');*/
                                            });
                                        @endphp
                                        @foreach ($records->get() as $v)
                                            @if ($v->duration == "0:00")
                                                @php
                                                    @unlink(public_path().'/uploads/videos/'.$v->name);
                                                    $v->delete();
                                                @endphp
                                            @else
                                                @if (file_exists(public_path().'/uploads/videos/'.$v->name))
                                                    <tr>
                                                        {{-- <td>{{ $v->id }}</td> --}}
                                                        <td>{{ $v->user->name }}</td>
                                                        <td>{{ $v->address }}</td>
                                                        <td><span style="display: none">{{Carbon\Carbon::parse($v->created_at)->timestamp}}</span>{{ $v->created_at->format('d-m-Y H:i:s') }}</td>
                                                        <td>{{ $v->duration }}</td>
                                                        <td>
                                                            <a target="_blank" href="{{ url('uploads/videos',$v->name) }}" class="btn btn-info btn-xs">View</a>
                                                            {{-- <a target='_blank' download href="{{ url('uploads/videos',$v->name) }}" class="btn btn-info btn-xs">Download</a> --}}
                                                            {{-- <a href="" class="btn btn-danger btn-xs">Delete</a> --}}
                                                        </td>
                                                    </tr>
                                                @elseif($v->remote_url)
                                                    {{-- <tr>
                                                        <td colspan="6">{{$v->remote_url}}</td>
                                                    </tr> --}}
                                                    @php
                                                        $dest = public_path().'/uploads/videos/' . $v->name;

                                                        try{

                                                            copy($v->remote_url, $dest);
                                                            $v->remote_url = null;
                                                            $v->save();

                                                        }catch (Exception $e){

                                                            echo "";

                                                        }
                                                    @endphp
                                                @endif
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($u->customer)
            <div class="col-xs-12">
                <form action="{{ url('admin/sms') }}" method="post" class="panel send-form">
                    {{ csrf_field() }}
                    <div class="panel-heading">New SMS</div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label>Number</label>
                            <input type="text" name="number" class="form-control" value="+{{ $u->customer->phone }}" readonly="">
                        </div>
                        <div class="form-group">
                            <select id="predefined" class="form-control">
                                    <option value="" selected disabled></option>
                                @foreach (App\Predefined::all() as $sms)
                                    <option data-messge="{{ $sms->message }}" value="{{ $sms->id }}">{{ $sms->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="message" class="form-control" rows="4">Buongiorno, alleghiamo il link per programmarsi in autonomia la videoperizia in data ed ora a Lei più comode. http://www.expressclaims.it/programmazione/</textarea>
                        </div>
                        
                        <div class="alert alert-danger hide" id="error"></div>
                        
                        <div class="alert alert-success hide" id="success">
                            SMS sent...
                        </div>

                        <button class="btn btn-block btn-success">Submit</button>
                    </div>
                </form>
            </div>
            <div class="col-xs-12">
                <div class="panel">
                    <div class="panel-heading">SMS Inviati</div>
                    <div class="panel-body table-responsive">
                        <table class="display table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Messaggio</th>
                                    <th width="15%">Data di invio</th>
                                    <th>Numero cliente</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (App\SMS::where('to','like','%'.$u->customer->phone.'%')->get() as $s)
                                    <tr>
                                        <td>{{ $s->id }}</td>
                                        <td style="word-break: break-all;">{{ $s->message }}</td>
                                        <td>{{ $s->created_at->format('d-m-Y H:i:s') }}</td>
                                        <td>{{ $s->to }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-xs-12">
                <div class="panel">
                    <div class="panel-body">
                        <div class="row">                        
                            <div class="col-xs-12 table-responsive" style="height: 100%; position: relative; overflow: auto">
                                <table class="table table-bordered table-condensed table-striped">
                                    <thead>
                                        <tr>
                                            {{-- <th>ID</th> --}}
                                            {{-- <th>Information</th> --}}
                                            <th>Media</th>
                                            <th>Status</th>
                                            <th>Data</th>
                                            <th width="20%">Riferimento interno</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse (App\Reservation::where('customer_id',$u->id)->get() as $res)
                                            <tr>
                                                {{-- <td>{{ $u->id }}</td> --}}
                                                {{-- <td>
                                                    @if ($res->message != trim(""))
                                                        @php
                                                            $info = json_decode($res->message,true);
                                                        @endphp
                                                        <a href="#open-information" data-toggle="modal" class="btn btn-info btn-xs"
                                                            data-username="{{$res->user->name}}";
                                                            data-phone="{{$res->user->customer ? $res->user->customer->phone : $res->user->webapp->phone}}";
                                                            data-sin_number="{{$res->sin_number}}";
                                                            data-lastname="{{$info['lastname']}}";
                                                            data-name="{{$info['name']}}";
                                                            data-bdate="{{$info['bdate']}}";
                                                            data-sdata="{{$info['sdata']}}";
                                                            data-quality="{{$info['quality']}}";
                                                            data-typology="{{$info['typology']}}";
                                                            data-goods="{{$info['goods']}}";
                                                            data-unity="{{$info['unity']}}";
                                                            data-cond="{{$info['cond']}}";
                                                            data-cdenomination="{{$info['cdenomination']}}";
                                                            data-cphone="{{$info['cphone']}}";
                                                            data-cemail="{{$info['cemail']}}";
                                                            data-surface="{{$info['surface']}}";
                                                            data-title="{{$info['title']}}";
                                                            data-damage="{{$info['damage']}}";
                                                            data-residue="{{$info['residue']}}";
                                                            data-other="{{$info['other']}}";
                                                            data-third="{{$info['third']}}";
                                                            data-thirddamage="{{$info['thirddamage']}}";
                                                            data-import="{{$info['import']}}";
                                                            data-iban="{{$info['iban']}}";
                                                        >Info sinistro</a>
                                                    @endif
                                                </td> --}}
                                                
                                                <td>
                                                    <a href="{{ url('admin/sinister/videos',$res->id) }}" target="_blank" class="btn btn-info btn-xs">Video</a>
                                                    <a href="{{ url('admin/sinister/images',$res->id) }}" target="_blank" class="btn btn-info btn-xs">Images</a>
                                                </td>
                                                <td>{{ $res->status == 1 ? 'Closed' : 'Open' }}</td>
                                                <td>{{ $res->created_at->format('d-m-Y H:i:s') }}</td>
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
                                                    @php
                                                        $o = App\User::find($u->customer ? $u->customer->operator_id : $u->operator_call_id);
                                                        $sha1 = sha1(sha1($u->email.$o->email));
                                                    @endphp
                                                    <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#share-{{ $u->id }}">Condivisione</button>
                                                    {{-- @if ($u->webapp) --}}
                                                        <button type="button" class="btn btn-success btn-xs copy-link" data-url="
{{ url('utente/'.$u->id.'/'.App\User::find($u->customer ? $u->customer->operator_id : $u->operator_call_id)->id.'/'.$res->id.'/'.$sha1) }}
                                                        ">Copia link</button>
                                                    {{-- @endif --}}
                                                    <div class="modal fade" id="share-{{ $u->id }}">
                                                        <div class="modal-dialog modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">Condivisione sinistro</div>
                                                                <div class="modal-body">
                                                                    <input type="text" class="share-email form-control" placeholder="E-mail" value="{{ $u->email }}">
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
	</div>

	<div class="col-md-6 ">
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

            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-heading">Geolocalizzazione</div>
                    <div class="panel-body call-panel" style="overflow: auto; height: 34vh">
                        <div id="panel3" style="height: calc(100% - 80px); margin: -15px -15px 0;"></div>
                        <div style="height:; position: relative;">
                            <h5><b>Nome del cliente:</b> <span id="map-name">{{$u->name}}</span></h5>
                            <h5><b>Indirizzo:</b> <span id="map-address">--</span></h5>
                            <h5><b>Inizio ultima connessione:</b> <span id="last-connected">
                                @if ($u->customer)
                                    {{$u->customer->updated_at->format('d-m-Y H:i:s')}}
                                @elseif($u->webapp)
                                    {{$u->webapp->updated_at->format('d-m-Y H:i:s')}}
                                @endif
                            </span></h5>

                            <button data-toggle="tooltip" title="Cliccando sul pulsante si aggiorna la posizione del dispositivo del client selezionato e contemporaneamente sul backend..." class="btn btn-success update" style="position: absolute; right: 0; bottom: -20px; margin-bottom: 0;">AGGIORNA POSIZIONE</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal fade" id="open-information">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">Informazione <button class="btn btn-info btn-xs" id="btn-print">Export</button></div>
            <div class="modal-body printArea">
                <img src="{{ url('renova.png') }}" alt="" width="100px">
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
    $('[href="#open-information"]').click(function(event) {
        $('#info-name').html('<b>Nome: </b>'+$(this).data('username'));
        $('#info-phone').html('<b>Telefono: </b>'+$(this).data('phone'));
        $('#info-sinister').html('<b>Riferimento interno: </b>'+$(this).data('sin_number'));

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
</script>
<script>
  function initMap() {
    var pos = {
      lat: {{ $u->customer ? $u->customer->lat : ($u->webapp->lat ? $u->webapp->lat : "0") }},
      lng: {{ $u->customer ? $u->customer->lng : ($u->webapp->lng ? $u->webapp->lng : "0") }}
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

    var geo = new google.maps.Geocoder();

    geo.geocode({'latLng': pos}, function(results,status) {
        console.log(results)
        $('#map-address').html(results[0]['formatted_address']);
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

  function sendIMMessage(destId, message) {
    imClient.sendMessage(destId, message);
    $.post('{{ url('getTime') }}', {_token: '{{ csrf_token() }}'}, function(data, textStatus, xhr) {
        $('.messages').append('<div class="contenedor"><div class="well me"><span class="label label-success">Io:</span> '+urlify(message)+'</div></div><div class="date-me">'+data+'</div>');
        setTimeout(()=>{
            $(".messages").scrollTop(document.getElementsByClassName('messages')[0].scrollHeight);
        },100)
    });
    //Optionnal: we scroll the messages
    console.log(document.getElementsByClassName('messages')[0].scrollHeight);
    $(".messages").scrollTop(document.getElementsByClassName('messages')[0].scrollHeight);
  }

  apiRTC.addEventListener('connectedUsersListUpdate',(e)=>{
    if (e.detail.usersList) {
        $.each(e.detail.usersList, function(index, val) {
            if (val == $('#number').val()) {
                if (e.detail.status == 'online') {
                    $('.fa-dot-circle-o').addClass('green');
                    $('#user_status').html('Online');
                }else if(e.detail.status == 'offline'){
                    $('.fa-dot-circle-o').removeClass('green');
                    $('#user_status').html('Offline');
                }
            }else{
                if ($('.fa-dot-circle-o').hasClass('green')) {
                    $('#user_status').html('Online');
                }else{
                    $('#user_status').html('Offline');
                }
            }
        });
    }
  })

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

    $('.open-image').click(function(event) {

        function makeid() {
          // var text = "";
          // var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

          // for (var i = 0; i < 5; i++)
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
        download($(this).data('href'), makeid()+'.jpg', 'image/jpeg');
    });

    $('#img-carousel').owlCarousel({
        items: 5,
        itemsDesktop: [1199,4],
        itemsDesktopSmall: [979,3],
        itemsTablet: [768,3],
        pagination: true
    });
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
    }
    $('.delete-this').click(deleteThis);

    $('#paperclip').change(function(event) {
        var input = this;
        if ($("#number").val() == '' || $("#number").val() == null) {
            alert('No user selected');
        }else{
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                console.log(reader)

                reader.onload = function (e) {
                    var message = '<img src="'+e.target.result+'" alt="" style="max-width:300px;" />';
                    destId = $("#number").val();
                    sendIMMessage(destId, message);
                    savePicture({{ Auth::user()->id }},$('#user_id').val(),message)
                    $(this).val('');
                }

                reader.readAsDataURL(input.files[0]);
            }else{
                console.log('Error selectin image')
            }
        }
    });

    $('#can_call').change(function(event) {
        $.post('{{ url('admin/change_can_call') }}', {id: $('#user_id').val(), _token: '{{ csrf_token() }}'}, function(data, textStatus, xhr) {
            imClient.sendMessage($('#user_id').val(),'eaf2ea9f6559f226c8f433830b397204fe28ffdc');
        });
    });

</script>

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAWEZr2CfI6Prw9P4Wp1lG6gW1VBW5t0Y&callback=initMap">
</script>

<script>
    $('#predefined').change(function(event) {
        $('[name="message"]').html($('#predefined option:selected').data('messge'));
    });
</script>

<script>
    $('#btn-print').click(function(event) {
        $(".printArea").printArea();
    });

    $('#btn-print-info').click(function(event) {
        $(".printAreaInfo").printArea();
    });
</script>


<script>
    @if ($res)
        $('div.div_messages').block({ message: 'Loading Messages from {{ $u->name }}... Please wait...' });

        $.post('{{ url('admin/loadMessages') }}', { to_id: {{ $u->id }}, from_id: {{ Auth::user()->id }}, _token: '{{ csrf_token() }}', res: {{ $res->id }} }, function(data, textStatus, xhr) {
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

            var to_fix = [];

            $.each($('.image-to-check'), function(index, val) {

                let img = $(this);
                let h = val.parentElement.offsetWidth;
                // console.log(img,h);

                val.addEventListener('load',function (e) {
                
                    var canvas = document.createElement("canvas");
                    context = canvas.getContext('2d');


                    base_image = new Image();
                    base_image.src = img.attr('src');

                    if ((base_image.naturalWidth || base_image.width) > (base_image.naturalHeight || base_image.height)) {
                        to_fix.push(img.attr('src'));
                        img.css({'transform':'translateX(-50%) translateY(-50%) rotate(90deg)','height':h+'px'});
                    }
                });
            });

            /**/

            // setTimeout(()=>{
            //     var html = "";
            //     $.each(data[0], function(index, val) {

            //         let coincide = 0;

            //         for (var i = 0; i < to_fix.length; i++) {

            //             if (val.message.indexOf(to_fix[i]) != -1) {
            //                 coincide = 1;
            //             }
            //         }

            //         if (val.from.name == '{{ Auth::user()->name }}') {
            //             html += '<div class="contenedor"><div class="well me"><span class="label label-success">Io:</span> <div '+(coincide == 1 ? 'class="rotate-inner"' : '')+'>'+urlify(val.message)+'</div> </div></div><div class="date-me">'+val.created+'</div>';
            //         }else{
            //             html += '<div class="contenedor"><div class="well notme"><span class="label label-danger">'+val.from.name+':</span> <div '+(coincide == 1 ? 'class="rotate-inner"' : '')+'>'+urlify(val.message)+'</div> </div></div><div class="date-notme">'+val.created+'</div>';
            //         }
            //     });

            //     $('.messages').html(html);
            //     $(".messages").scrollTop(document.getElementsByClassName('messages')[0].scrollHeight);

            // },100)
            $('div.div_messages').unblock();
        });

        $('.share-btn').click(function(event) {
            var email = $(this).parent().prev().find('input').val(),
            url = '{{ url('utente') }}/'+$(this).data('id')+'/'+'{{ App\User::find($u->customer ? $u->customer->operator_id : $u->operator_call_id)->id }}/'+$(this).data('res')+'/'+$(this).data('sha1');

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

$('[href="#modal-edit-info"]').click(function() {
    $('body').css('overflow', 'auto');
  // reset modal if it isn't visible
  if (!($('.modal.in').length)) {
    $('.modal-dialog').css({
      top: 0,
      left: 0
    });
  }
  $('#modal-edit-info').modal({
    backdrop: false,
    show: true
  });

  $('#modal-edit-info .modal-dialog').draggable({
    handle: ".modal-header"
  });
});

$('[href="#modal-view-info"]').click(function() {
    $('body').css('overflow', 'auto');
  // reset modal if it isn't visible
  if (!($('.modal.in').length)) {
    $('.modal-dialog').css({
      top: 0,
      left: 0
    });
  }
  $('#modal-view-info').modal({
    backdrop: false,
    show: true
  });

  $('#modal-view-info .modal-dialog').draggable({
    handle: ".modal-header"
  });
});

function changeEvent(event) {
    var elem = $('.editable-select');
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
$('[name="company"]').change(changeEvent);

    @endif

$('.display2.table').dataTable({
    "aaSorting": [[ 2, "desc" ]]
});
</script>
@endsection

@stop