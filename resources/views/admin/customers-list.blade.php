@php
    $a = 0;
@endphp
@foreach (App\User::where('role_id',0)->where(function($q){
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
    })->orderBy('created_at','desc')->get() as $u)
    @php
        $res = App\Reservation::where(['customer_id' => $u->id, 'status' => 0])->first();
    @endphp
    @if ($a > 9)
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
                                                <td>
                                                    <a {{-- data-toggle="modal" data-target="#video-modal" href="javascript:;" data- --}}href="{{ url('uploads/videos',$v->name) }}" target="_blank" class="btn btn-info btn-xs">View</a>
                                                    <a target='_blank' download href="{{ url('uploads/videos',$v->name) }}" class="btn btn-info btn-xs">Download</a>
                                                    {{-- <a href="" class="btn btn-danger btn-xs">Delete</a> --}}
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
            <td>
                @if ($u->customer)
                <input data-toggle="toggle" data-size="mini" data-on=" " data-off=" " data-onstyle="info" type="checkbox" data-id="{{ $u->id }}" class="can_call" onclick="event.stopPropagation();" {{ $u->customer->can_call == 1 ? 'checked' : '' }}>
                @endif
            </td>
            <td class="select-user {{$u->webapp ? 'webappuser' : ''}}" data-id="{{ $u->id }}">

                <button style="border-radius: 64px; width:15px; height: 15px; font-size: 9px; padding: 0 2px; line-height: 1.3" data-modal="#modal-view-info-{{ $u->id }}" class="modal-view-info btn btn-xs btn-info"><i class="fa fa-info"></i></button>

                <button style="border-radius: 64px; width:15px; height: 15px; font-size: 9px; padding: 0 2px; line-height: 1.3" data-modal="#modal-edit-info-{{ $u->id }}" class="modal-edit-info btn btn-xs btn-success"><i class="fa fa-pencil"></i></button>
                <a href="{{ url('admin/view-customer',$u->id) }}" target="blank" style="border-radius: 64px; width:15px; height: 15px; font-size: 9px; padding: 0 2px; line-height: 1.3" class="btn btn-xs btn-warning"><i class="fa fa-eye"></i></a>

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
                                <h5><b>Telefono: </b>{{$u->webapp->code.$u->webapp->phone}}</h5>
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
            </td>
            <td class="select-user" data-id="{{ $u->id }}">
                <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#richiesta-{{ $u->id }}" style="font-size: 10px">Contrassegnare come gestito</button>
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
    @endif
    @php
        $a++;
    @endphp
@endforeach