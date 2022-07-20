<table class="display table table-bordered table-striped">
	<thead>
	    <tr>
	        <th>ID</th>
	        <th>Telefono</th>
	        <th>Nome</th>
	        <th>EXPclaims</th>
	        <th>EXPtech</th>
	        <th>Supervisore</th>
	        <th>Mappa</th>
	        <th>Autoperizia</th>
	        <th>E-mail</th>
	        <th>Password</th>
	    </tr>
	</thead>
	<tbody>
	    @foreach (App\User::where('role_id','!=',-1)->where('role_id','!=',0)->where('status',$status)->whereExists(function($q){
	        $q->from('operators')
	          ->whereRaw('operators.user_id = users.id');
	    })->get() as $o)
	        <tr>
	            <td>{{ str_pad($o->id,0,0,STR_PAD_LEFT) }}</td>
	            <td>{{ $o->street_phone }}</td>
	            <td>{{ $o->fullname() }}</td>

	            <td class="ec-{{$o->id}}">
	                {!! @$o->operator->ec == 1 ? 'Si' : 'No' !!}
	            </td>
	            <td class="et-{{$o->id}}">
	                {!! @$o->operator->et == 1 ? 'Si' : 'No' !!}
	            </td>
	            <td class="sp-{{$o->id}}">
	                {!! @$o->supervisor == 1 ? 
	                'Si' :
	                'No' !!}
	            </td>
	            <td class="mp-{{$o->id}}">
	                {!! @$o->operator->mp == 1 ? 'Si' : 'No' !!}
	            </td>

	            <td class="ap-{{$o->id}}">
	                {!! @$o->operator->ap == 1 ? 'Si' : 'No' !!}
	            </td>

	            <td>{{ $o->email }}</td>
	            <td>{{ $o->visualPassword }}</td>
	        </tr>
	    @endforeach
	</tbody>
</table>