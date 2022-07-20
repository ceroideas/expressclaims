@extends('admin.layout')

@section('content')

<div class="row">
	<div class="col-sm-3">
		<form action="{{ isset($e_c) ? url('admin/customers',$e_c->id) : url('admin/customers') }}" method="post" class="panel send-form">
			{{ csrf_field() }}
			@if(isset($e_c))
	            <div class="panel-heading">Modifica Cliente</div>
	            <input type="hidden" name="id" value="{{ $e_c->id }}">
				{{ method_field('PUT') }}
            @else
            	<div class="panel-heading">Nuovi Clienti</div>
            @endif
			<div class="panel-body">
				<div class="form-group">
					<label>Email</label>
					<input type="text" name="email" value="{{ isset($e_c) ? $e_c->user->email : '' }}" class="form-control">
				</div>
				<div class="form-group">
					<label>Nome</label>
					<input type="text" name="name" value="{{ isset($e_c) ? $e_c->user->name : '' }}" class="form-control">
				</div>
				<div class="form-group">
					<label>Telefono</label>
					<input type="text" name="phone" value="{{ isset($e_c) ? $e_c->phone : '' }}" class="form-control">
				</div>
				<div class="form-group">
					<label>Indirizzo</label>
					<input type="text" name="address" value="{{ isset($e_c) ? $e_c->address : '' }}" class="form-control">
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" name="password" class="form-control">
				</div>
				
				<div class="alert alert-danger hide" id="error"></div>
				
				<div class="alert alert-success hide" id="success">
                    {{ isset($e_c) ? 'Cliente aggiornato...' : 'Cliente aggiunto...' }}
                </div>

				<button class="btn btn-block btn-success">Inviare</button>
			</div>
		</form>
	</div>

	<div class="col-sm-9">
		<div class="panel">
			<div class="panel-heading">Clienti App</div>
			<div class="panel-body">
				<table class="display table table-bordered table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nome</th>
							<th>E-mail</th>
							<th>Operatore</th>
							<th>Telefono</th>
							<th>Indirizzo</th>
							<th>Estato</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
                        @foreach (App\Customer::whereExists(function($q){
                        	$q->from('users')
                        	  ->whereRaw('users.id = customers.user_id');
                        })->get() as $c)
                            <tr>
                            	<td>EC{{ str_pad($c->id,5,0,STR_PAD_LEFT) }}</td>
                            	<td>{{ $c->user->name }}</td>
                            	<td>{{ $c->user->email }}</td>
                            	<td>{{ @App\User::find($c->operator_id)->fullname() }}</td>
                            	<td>{{ $c->phone }}</td>
                            	<td>{{ $c->address }}</td>
                            	<td>{{ $c->generalStatus() }}</td>
                                <td>
                                    <a href="{{ url('admin/customers',$c->id) }}/edit" class="btn btn-xs btn-info edit_feature"
                                    >Modifica</a>
                                    {{-- <a data-toggle="modal" href="#modal-delete-{{ $c->id }}" class="btn btn-xs btn-danger">Rimuovere</a> --}}
                                    <div class="modal fade" id="modal-delete-{{ $c->id }}">
                                    	<div class="modal-dialog">
                                    		<div class="modal-content">
                                    			<div class="modal-header">Vuoi rimuovere l'utente {{ $c->user->name }}?</div>
                                    			<div class="modal-body">Tutti i dati dell'utente saranno cancellati, questa azione non può essere annullata</div>
                                    			<div class="modal-footer">
                                    				<button type="button" data-dismiss="modal" class="btn btn-warning btn-xs">Annullare</button>
                                    				<button data-href="{{ url('admin/customers/delete',$c->id) }}" class="btn btn-success btn-xs delete-user" data-id="{{ $c->user_id }}">Accettare</button>
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