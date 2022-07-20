<tr style="background-color: #f5f5ff">
	<td style="display: none;">{{ @strtotime($u->lastSinister()->created_at) }}</td>
    <td>WA{{ str_pad($u->webapp->id,5,0,STR_PAD_LEFT) }}</td>
	<td>
		@if ($u->lastSinister()->sin_number)
    		{{ $u->lastSinister()->sin_number }}
    		@if (App\Question::where('reservation_id',$u->lastSinister()->id)->get()->last())
                <img src="{{url('assets/icono-0'.App\Question::where('reservation_id',$u->lastSinister()->id)->get()->last()->rate.'-b.png')}}" alt="" style="width: 20px;">
            @endif
        @endif
	</td>
	<td>{{ str_pad($u->id,5,0,STR_PAD_LEFT) }}</td>
	<td>{{ $u->name }}</td>
	@if (Auth::user()->role_id == -1 || isset($all))
	<td>{{ App\User::find($u->operator_call_id)->fullName() }}</td>
	@endif
	<td>{{$u->webapp->code.$u->webapp->phone}}</td>
	<td>---</td>
	<td>
		<a href="{{ url('admin/sinister/videos',$u->lastSinister()->id) }}" target="_blank" class="btn btn-info btn-xs">Video</a>
		<a href="{{ url('admin/sinister/images',$u->lastSinister()->id) }}" target="_blank" class="btn btn-info btn-xs">Immagini</a>
	</td>
	<td>{{ $u->lastSinister()->status == 1 ? 'Closed' : 'Open' }}</td>
	<td> <span style="display: none">{{strtotime($u->lastSinister()->created_at)}}</span>{{ $u->lastSinister()->created_at->format('d-m-Y H:i:s') }}</td>

    <td>
        @if ($u->lastSinister()->reopen)
            <span style="display: none">{{strtotime($u->lastSinister()->made)}}</span>{{ Carbon\Carbon::parse($u->lastSinister()->made)->format('d-m-Y H:i:s') }}
        @endif
    </td>
	<td>
        @php
            $o = App\User::find($u->operator_call_id);
            $sha1 = sha1(sha1($u->email.$o->email));
        @endphp
        <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#share-{{ $u->id }}">Condivisione</button>
        <a target="_blank" href="{{ url('admin/view-customer',$u->id) }}" class="btn btn-xs btn-warning edit_feature">Vedi la pagina</a>

        <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#richiesta-{{ $u->id }}">Gestito</button>


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

        <div class="modal fade" id="share-{{ $u->id }}">
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
                            data-res="{{ $u->lastSinister()->id }}"
                            data-id="{{ $u->id }}"
                            data-sha1="{{ $sha1 }}"
                        >Accettare</button>
                    </div>
                </div>
            </div>
        </div>
    </td>
</tr>