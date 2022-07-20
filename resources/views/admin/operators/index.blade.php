@extends('admin.layout')

@section('content')

<div class="row">
	<div class="col-sm-3">
		<form action="{{ isset($e_c) ? url('admin/operators',$e_c->id) : url('admin/operators') }}" method="post" class="panel send-form">
			{{ csrf_field() }}
			@if(isset($e_c))
	            <div class="panel-heading">Modifica Operatore</div>
	            <input type="hidden" name="id" value="{{ $e_c->id }}">
				{{ method_field('PUT') }}
            @else
            	<div class="panel-heading">Nuovo Operatore</div>
            @endif
			<div class="panel-body">
				<div class="form-group">
					<label>Email</label>
					<input type="text" name="email" value="{{ isset($e_c) ? $e_c->user->email : '' }}" class="form-control">
				</div>
				<div class="form-group">
					<label>Nome</label>
					<input type="text" name="name" value="{{ isset($e_c) ? $e_c->user->fullname() : '' }}" class="form-control">
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" name="password" class="form-control">
				</div>

                <div class="form-group">

                    <label>Permessi</label>

                    <div class="checkbox">
                        <label> <input type="checkbox" {{ isset($e_c) ? ($e_c->ec == 1 ? 'checked' : '') : '' }} name="ec" value="1"> Vedi Express Claims</label>
                    </div>
                    <div class="checkbox">
                        <label> <input type="checkbox" {{ isset($e_c) ? ($e_c->mp == 1 ? 'checked' : '') : '' }} name="mp" value="1"> Vedi Mappa</label>
                    </div>
                    <div class="checkbox">
                        <label> <input type="checkbox" {{ isset($e_c) ? ($e_c->et == 1 ? 'checked' : '') : '' }} name="et" value="1"> Vedi Express Tech</label>
                    </div>

                    {{-- <label>Mappa</label>
                    <div class="checkbox">
                        <label style="padding: 0">
                            Vedi solo la mappa
                            <input type="checkbox" name="map" value="1" {{ isset($e_c) ? ($e_c->user->role_id == 3 ? 'checked' : '') : '' }}>
                        </label>
                    </div> --}}
                </div>
				
				<div class="alert alert-danger hide" id="error"></div>
				
				<div class="alert alert-success hide" id="success">
                    {{ isset($e_c) ? 'Operatore aggiornato...' : 'Operatore aggiunto...' }}
                </div>

				<button class="btn btn-block btn-success">Inviare</button>
			</div>
		</form>
	</div>

	<div class="col-sm-9">
		<div class="panel">
			<div class="panel-heading">Operatori</div>
			<div class="panel-body">
				<table class="display table table-bordered table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nome</th>
							<th>Solo mappa</th>
                            <th>E-mail</th>
							<th>Password</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
                        @foreach (App\Operator::whereExists(function($q){
                        	$q->from('users')
                        	  ->whereRaw('users.id = operators.user_id');
                        	  //->whereRaw('users.status = 1');
                        })->get() as $o)
                            <tr>
                            	<td>OP{{ str_pad($o->id,5,0,STR_PAD_LEFT) }}</td>
                            	<td>{{ $o->user->fullname() }}</td>
                                <td>{{ $o->user->role_id == 3 ? 'Si' : '' }}</td>
                            	<td>{{ $o->user->email }}</td>
                            	<td class="hover-to-show"><span>{{ $o->user->visualPassword }}</span></td>
                                <td>
                                    <a href="{{ url('admin/operators',$o->id) }}/edit" class="btn btn-xs btn-info edit_feature"
                                    >Modifica</a>

                                    @if ($o->user->status == 1)
                                    <a data-toggle="modal" href="#modal-disable-{{ $o->user->id }}" class="btn btn-xs btn-warning">Disattivare</a>
                                    @else
                                    <a data-toggle="modal" href="#modal-enable-{{ $o->user->id }}" class="btn btn-xs btn-success">Riattivare</a>
                                    @endif
                                    {{-- <a data-toggle="modal" href="#modal-delete-{{ $o->id }}" class="btn btn-xs btn-danger">Rimuovere</a> --}}
                                    <div class="modal fade" id="modal-delete-{{ $o->id }}">
                                    	<div class="modal-dialog">
                                    		<div class="modal-content">
                                    			<div class="modal-header">Vuoi rimuovere l'operatore {{ $o->user->fullname() }}?</div>
                                    			<div class="modal-body">Tutti i dati dell'operatore saranno cancellati, questa azione non può essere annullata</div>
                                    			<div class="modal-footer">
                                    				<button type="button" data-dismiss="modal" class="btn btn-warning btn-xs">Annullare</button>
                                    				<a href="{{ url('admin/operators/delete',$o->id) }}" class="btn btn-success btn-xs">Accettare</a>
                                    			</div>
                                    		</div>
                                    	</div>
                                    </div>

                                    <div class="modal fade" id="modal-disable-{{ $o->user->id }}">
                                    	<div class="modal-dialog modal-sm">
                                    		<div class="modal-content">
                                    			<div class="modal-header">Vuoi disattivare l'operatore {{ $o->user->name }}?</div>
                                    			<div class="modal-footer">
                                    				<button type="button" data-dismiss="modal" class="btn btn-warning btn-xs">Annullare</button>
                                    				<a href="{{ url('admin/operators/disable',$o->user->id) }}" class="btn btn-success btn-xs">Accettare</a>
                                    			</div>
                                    		</div>
                                    	</div>
                                    </div>

                                    <div class="modal fade" id="modal-enable-{{ $o->user->id }}">
                                    	<div class="modal-dialog modal-sm">
                                    		<div class="modal-content">
                                    			<div class="modal-header">Vuoi riattivare l'operatore {{ $o->user->name }}?</div>
                                    			<div class="modal-footer">
                                    				<button type="button" data-dismiss="modal" class="btn btn-warning btn-xs">Annullare</button>
                                    				<a href="{{ url('admin/operators/disable',$o->user->id) }}" class="btn btn-success btn-xs">Accettare</a>
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

@stop