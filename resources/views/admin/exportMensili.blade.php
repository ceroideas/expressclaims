<table class="table table-responsive">
	<thead>
		<tr>
			@if ($r->operator == 'all')
			<th>Operatori</th>
			@endif
			<th>Rif. Interno</th>
			<th>Nominativo</th>
			<th>Num. telefono</th>
			<th>Data e ora inizio</th>
			<th>Durata</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($bucle as $rec)
			<tr>
				@if ($r->operator == 'all')
				<td>
					{{App\User::find(@$rec->user->operator_call_id) ? App\User::find(@$rec->user->operator_call_id)->fullname() : ''}}
				</td>
				@endif
				<td>{{$rec->reservation->sin_number}}</td>
				<td>{{$rec->user->name()}}</td>
				<td>
					@if ($rec->user->webapp)
                    ={{$rec->user->webapp->code.$rec->user->webapp->phone}}
                    @elseif($rec->user->customer)
                    {{$rec->user->customer->phone}}
                    @endif
				</td>
				<td>{{$rec->created_at->format('d-m-Y H:i')}}</td>
				<td>00:{{$rec->duration}}</td>
			</tr>
		@endforeach
	</tbody>
</table>