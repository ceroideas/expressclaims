@foreach ($m as $mi)
	<tr>
		<td>{{$mi->N_P}}</td>
		<td>{{$mi->Assicurato}}</td>
		<td>{{$mi->COMPAGNIA}}</td>
		<td>{{$mi->TP}}</td>
		<td>{{$mi->Stato}}</td>
		<td>{{$mi->INDIRIZZO}}</td>
		<td>{{$mi->DT_Incarico}}</td>
	</tr>
@endforeach