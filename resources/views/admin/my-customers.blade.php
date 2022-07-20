@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">Clienti</div>
			<div class="panel-body">
				<table class="display table table-bordered table-striped">
					<thead>
						<tr>
							<th>Riferimento Interno</th>
							<th>Call ID</th>
							<th>Nome</th>
							<th>E-mail</th>
							<th>Telefono</th>
							<th>Indirizzo</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
                        @foreach (App\Customer::whereExists(function($q){
                        	$q->from('users')
                        	  ->whereRaw('users.id = customers.user_id')
                        	  ->whereRaw('customers.operator_id = '.Auth::user()->id);
                        })->get() as $c)
                            <tr>
                            	<td>{{ $c->user->lastSinisterAdmin() ? $c->user->lastSinisterAdmin()->sin_number : '' }}</td>
                            	<td>EC{{ str_pad($c->id,5,0,STR_PAD_LEFT) }}</td>
                            	<td>{{ $c->user->name }}</td>
                            	<td>{{ $c->user->email }}</td>
                            	<td>{{ $c->phone }}</td>
                            	<td>{{ $c->address }}</td>
                                <td>
                                    <a href="{{ url('admin/view-customer',$c->user_id) }}" class="btn btn-xs btn-info edit_feature"
                                    >Vedi la pagina</a>
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