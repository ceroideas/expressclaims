@if (Auth::user()->role_id == -1)
@else
                        @foreach (App\User::whereExists(function($q){
                            $q->from('customers')
                              ->whereRaw('customers.user_id = users.id')
                              ->whereRaw('customers.operator_id = '.Auth::user()->id);
                        })->whereExists(function($q){
                            $q->from('reservations')
                              ->whereRaw('reservations.customer_id = users.id')
                              ->whereRaw('reservations.status = 1');
                        })->get() as $u)
                            <tr>
                                {{-- <td>{{ $u->id }}</td> --}}
                                <td>{{ str_pad($u->id,5,0,STR_PAD_LEFT) }}</td>
                                <td>{{ $u->name }}</td>
                                <td>{{ $u->customer->phone }}</td>
                                <td>                                    
                                    @if (strpos(e($u->lastMessage()),'img') != 0)
                                        Image
                                    @else
                                        <?= $u->lastMessage(); ?>
                                    @endif
                                        
                                </td>
                                <td>{{ $u->lastMessageDate() }}</td>
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
                                                                        <th width="130px">Media</th>
                                                                        {{-- <th>Status</th> --}}
                                                                        <th>Data</th>
                                                                        <th>Chat</th>
                                                                        <th width="200px"></th>
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
                                                                            {{-- <td>{{ $res->status == 1 ? 'Closed' : 'Open' }}</td> --}}
                                                                            <td>{{ $res->created_at->format('d-m-Y H:i:s') }}</td>
                                                                            <td><button class="btn btn-info btn-xs open-chat"
                                                                                data-name="{{ $u->name }}"
                                                                                data-cl="{{ $u->id }}"
                                                                                data-res="{{ $res->id }}"
                                                                            data-toggle="modal" data-target="#chat-modal"><i class="fa fa-comments-o"></i> Vedi chat</button>
                                                                            </td>
                                                                            <td>
                                                                                @php
                                                                                    $o = App\User::find($u->customer->operator_id);
                                                                                    $sha1 = sha1(sha1($u->email.$o->email));
                                                                                @endphp
                                                                                {{-- <button class="btn btn-info btn-xs share-btn" data-op="{{ $o->id }}" data-name="{{ $u->name }}" data-email="{{ $u->email }}" data-res="{{ $res->id }}" data-id="{{ $u->id }}" data-sha1="{{ $sha1 }}">Condivisione</button> --}}
                        
                                                                                <button class="btn btn-info btn-xs condivisione" data-toggle="modal" data-target="#share-{{ $res->id }}">Condivisione</button>
                                                                                @if ($res->status == 1)
                                                                                    <button class="btn btn-success btn-xs reopen" data-toggle="modal" data-target="#reopen-{{ $res->id }}">Riaprire</button>
                                                                                @endif
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
                                                                <th>Riferimento Interno</th>
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
                                                                    <td>{{ App\Reservation::find($v->reservation_id)->sin_number }}</td>
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
                                    <a href="{{ url('admin/view-customer',$u->id) }}" class="btn btn-xs btn-info edit_feature">Vedi la pagina</a>
                                </td>
                            </tr>
                        @endforeach
                        @endif