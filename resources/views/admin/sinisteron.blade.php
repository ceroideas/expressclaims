<tr>
	<td style="display: none;">{{ strtotime($u->lastSinister()->created_at) }}</td>
    <td>EC{{ str_pad($u->customer->id,5,0,STR_PAD_LEFT) }}</td>
	<td>
		@if ($u->lastSinister()->sin_number)
    		{{ $u->lastSinister()->sin_number }}
        @else
            <form action="{{ url('admin/save-sinister') }}" method="POST">
            	{{ csrf_field() }}
            	<input type="hidden" name="sinister_id" value="{{ $u->lastSinister()->id }}">
            	<div class="form-group">
        			<div class="input-group">
        				<input type="text" class="form-control input-sm" name="sin_number" {{ $u->lastSinister()->file == "" ? 'disabled' : '' }} required>
        				<span class="input-group-btn">
        					<button type="submit" {{ $u->lastSinister()->file == "" ? 'disabled' : '' }} class="btn btn-success btn-sm">Inviare</button>
        				</span>
        			</div>
            	</div>
        	</form>
		@endif
    </td>
	<td>{{ str_pad($u->id,5,0,STR_PAD_LEFT) }}</td>
	<td>{{ $u->name }}</td>
	@if (Auth::user()->role_id == -1 || isset($all))
	<td>{{ App\User::find($u->customer->operator_id)->fullName() }}</td>
	@endif
	<td>{{ $u->customer->phone }}</td>
	<td>
		@if ($u->lastSinister()->message != trim(""))
    		@php
    			$info = json_decode($u->lastSinister()->message,true);
    		@endphp
			<a href="#open-information" data-toggle="modal" class="btn btn-info btn-xs"
				data-username="{{$u->lastSinister()->user->name}}"
                data-phone="{{$u->lastSinister()->user->customer->phone}}"
                data-sin_number="{{$u->lastSinister()->sin_number}}"
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
			>Vedi modulo dati</a>
		@endif
	</td>
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
            $o = App\User::find($u->customer->operator_id);
            $sha1 = sha1(sha1($u->email.$o->email));
        @endphp
        <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#share-{{ $u->id }}">Condivisione</button>
        <a target="_blank" href="{{ url('admin/view-customer',$u->id) }}" class="btn btn-xs btn-info edit_feature">Vedi la pagina</a>
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