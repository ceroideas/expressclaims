@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">Nuovi utenti</div>
			<div class="panel-body">
				<table class="display table table-bordered table-striped">
					<thead>
						<tr>
							{{-- <th>ID</th> --}}
							<th>Call Id</th>
							<th>Nome</th>
							<th>Riferimento Interno</th>
							<th>Fotografie</th>
							<th>Data di registrazione</th>
							<th>Operatore</th>
							@if (Auth::user()->role_id==1)
								<th></th>
							@endif
							{{-- <th></th> --}}
						</tr>
					</thead>
					<tbody>
                        @foreach (App\User::whereExists(function($q){
                        	$q->from('customers')
                        	->whereRaw('customers.user_id = users.id')
                        	->whereNull('customers.operator_id');
                        })->get() as $u)
                            <tr>
                            	{{-- <td>{{ $u->id }}</td> --}}
                            	<td>{{ str_pad($u->id,5,0,STR_PAD_LEFT) }}</td>
                            	<td>{{ $u->name }}</td>
                            	<td><input type="text" class="form-control" id="sinister-{{$u->id}}" value="{{ $u->lastSinister() ? $u->lastSinister()->message : $u->lastSinister() }}"></td>
                            	<td><?= $u->lastSinister() ? ($u->lastSinister()->file ? '<a onclick="var image = new Image(); image.src = this.href; var w = window.open(\'\',\'_blank\'); w.document.write(image.outerHTML)" href="'.$u->lastSinister()->file.'">Open Image</a>' : '---') : '---'; ?></td>
                            	<td>{{ $u->created_at->format('d-m-Y H:i:s') }}</td>
                            	<td>
                            		<select name="operator_id" id="operator-{{$u->id}}" class="form-control">
										@foreach (App\Operator::whereExists(function($q){
				                        	$q->from('users')
				                        	  ->whereRaw('users.id = operators.user_id')
				                        	  ->whereRaw('users.role_id = 1')
				                        	  ->whereRaw('users.status = 1');
				                        })->get() as $o)
											<option {{ Auth::user()->id == $o->user->id ? 'selected' : '' }} value="{{ $o->user->id }}">{{ $o->user->fullname() }}</option>
										@endforeach
									</select>
                            	</td>
                            	@if (Auth::user()->role_id==1)
                            	<td>
                            		<button class="btn btn-success btn-xs button-link" data-id="{{$u->id}}">Link utente</button>
                            		<div class="modal fade" id="modal-{{ $u->id }}">
                            			<div class="modal-dialog modal-sm">
	                            			<form action="{{ url('admin/link-user',$u->id) }}" method="POST">
                            				{{ csrf_field() }}
	                            				<div class="modal-content">
	                            					<div class="modal-header">
	                            						Vuoi collegarti con questo cliente?
	                            					</div>
	                            					<div class="modal-footer">
	                            						<button type="button" class="btn btn-success btn-xs link-user" data-id="{{ $u->id }}">Accettare</button>
	                            						<button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Cancella</button>
	                            					</div>
	                            				</div>
	                            			</form>
                            			</div>
                            		</div>

                            		<button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#modal-delete{{$u->id}}">Delete</button>
                            		<div class="modal fade" id="modal-delete{{ $u->id }}">
                            			<div class="modal-dialog modal-sm">
                            				{{ csrf_field() }}
                            				<div class="modal-content">
                            					<div class="modal-header">
                            						Vuoi cancellare questo utente?
                            					</div>
                            					<div class="modal-footer">
                            						<button data-href="{{ url('admin/customers/delete',$u->customer->id) }}" class="btn btn-success btn-xs delete-user">Si</button>
                            						<button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Cancella</button>
                            					</div>
                            				</div>
                            			</div>
                            		</div>
                            			
                            	</td>
                            	@endif
                            	{{-- <td><button class="btn btn-sm btn-danger">Delete</button></td> --}}
                            </tr>
                        @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop