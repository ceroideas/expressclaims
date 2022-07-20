<table class="table table-bordered">
	<thead>
		<tr>
			<th></th>
			<th></th>

			@php
				$day30 = Carbon\Carbon::today()->subDays(90);
			@endphp
			@while ($day30 <= Carbon\Carbon::today())
				@php
					$ef = App\ExcelFile::where('created_at','>=',$day30)->where('created_at','<',$day30->copy()->addDay())->get()->last();
				@endphp
				@if ($ef)
					<th>{{ $ef->created_at->format('d-m-Y') }}</th>
				@endif
				@php
					$day30->addDay();
				@endphp
			@endwhile
		</tr>
	</thead>

	<tbody>
		<tr>
			<td> TUTTI</td>
			<td></td>
			@php
				$day30 = Carbon\Carbon::today()->subDays(90);
			@endphp
			@while ($day30 <= Carbon\Carbon::today())
				@php
					$ef = App\ExcelFile::where('created_at','>=',$day30)->where('created_at','<',$day30->copy()->addDay())->get()->last();
				@endphp
				@if ($ef)
					<td>{{ $ef->all }}</td>
				@endif
				@php
					$day30->addDay();
				@endphp
			@endwhile
		</tr>

		<tr>
			<td>Non Fissati</td>
			<td></td>
			@php
				$day7 = Carbon\Carbon::today()->subDays(90);
			@endphp
			@while ($day7 <= Carbon\Carbon::today())
				@php
					$ef = App\ExcelFile::where('created_at','>=',$day7)->where('created_at','<',$day7->copy()->addDay())->get()->last();
				@endphp
				@if ($ef)
					<td>{{ $ef->nonf }}</td>
				@endif
				@php
					$day7->addDay();
				@endphp
			@endwhile
		</tr>

		<tr>
			<td>20</td>
			<td></td>
			{{-- /**/ --}}
			@php
				$day30 = Carbon\Carbon::today()->subDays(90);
			@endphp
			@while ($day30 <= Carbon\Carbon::today())
				@php
					$ef = App\ExcelFile::where('created_at','>=',$day30)->where('created_at','<',$day30->copy()->addDay())->get()->last();
				@endphp
				@if ($ef)
					<td>{{ $ef->l20 }}</td>
				@endif
				@php
					$day30->addDay();
				@endphp
			@endwhile
		</tr>

		<tr>
			<td>40</td>
			<td>num.</td>
			{{-- /**/ --}}
			@php
				$day30 = Carbon\Carbon::today()->subDays(90);
			@endphp
			@while ($day30 <= Carbon\Carbon::today())
				@php
					$ef = App\ExcelFile::where('created_at','>=',$day30)->where('created_at','<',$day30->copy()->addDay())->get()->last();
				@endphp
				@if ($ef)
					<td>{{ $ef->l40 }}</td>
				@endif
				@php
					$day30->addDay();
				@endphp
			@endwhile
		</tr>

		<tr>
			<td>60</td>
			<td></td>
			{{-- /**/ --}}
			@php
				$day30 = Carbon\Carbon::today()->subDays(90);
			@endphp
			@while ($day30 <= Carbon\Carbon::today())
				@php
					$ef = App\ExcelFile::where('created_at','>=',$day30)->where('created_at','<',$day30->copy()->addDay())->get()->last();
				@endphp
				@if ($ef)
					<td>{{ $ef->l60 }}</td>
				@endif
				@php
					$day30->addDay();
				@endphp
			@endwhile
		</tr>

		<tr>
			<td>>60</td>
			<td></td>
			{{-- /**/ --}}
			@php
				$day30 = Carbon\Carbon::today()->subDays(90);
			@endphp
			@while ($day30 <= Carbon\Carbon::today())
				@php
					$ef = App\ExcelFile::where('created_at','>=',$day30)->where('created_at','<',$day30->copy()->addDay())->get()->last();
				@endphp
				@if ($ef)
					<td>{{ $ef->p60 }}</td>
				@endif
				@php
					$day30->addDay();
				@endphp
			@endwhile
		</tr>

		<tr>
	 		<td></td>
		</tr>

		<tr>
			<td> TUTTI</td>
			<td></td>
			@php
				$day30 = Carbon\Carbon::today()->subDays(90);
			@endphp
			@while ($day30 <= Carbon\Carbon::today())
				@php
					$ef = App\ExcelFile::where('created_at','>=',$day30)->where('created_at','<',$day30->copy()->addDay())->get()->last();
				@endphp
				@if ($ef)
					<td>{{ $ef->mall }}</td>
				@endif
				@php
					$day30->addDay();
				@endphp
			@endwhile
		</tr>

		<tr>
			<td>20</td>
			<td></td>
			{{-- /**/ --}}
			@php
				$day30 = Carbon\Carbon::today()->subDays(90);
			@endphp
			@while ($day30 <= Carbon\Carbon::today())
				@php
					$ef = App\ExcelFile::where('created_at','>=',$day30)->where('created_at','<',$day30->copy()->addDay())->get()->last();
				@endphp
				@if ($ef)
					<td>{{ $ef->ml20 }}</td>
				@endif
				@php
					$day30->addDay();
				@endphp
			@endwhile
		</tr>

		<tr>
			<td>40</td>
			<td>gg. medi</td>
			{{-- /**/ --}}
			@php
				$day30 = Carbon\Carbon::today()->subDays(90);
			@endphp
			@while ($day30 <= Carbon\Carbon::today())
				@php
					$ef = App\ExcelFile::where('created_at','>=',$day30)->where('created_at','<',$day30->copy()->addDay())->get()->last();
				@endphp
				@if ($ef)
					<td>{{ $ef->ml40 }}</td>
				@endif
				@php
					$day30->addDay();
				@endphp
			@endwhile
		</tr>

		<tr>
			<td>60</td>
			<td></td>
			{{-- /**/ --}}
			@php
				$day30 = Carbon\Carbon::today()->subDays(90);
			@endphp
			@while ($day30 <= Carbon\Carbon::today())
				@php
					$ef = App\ExcelFile::where('created_at','>=',$day30)->where('created_at','<',$day30->copy()->addDay())->get()->last();
				@endphp
				@if ($ef)
					<td>{{ $ef->ml60 }}</td>
				@endif
				@php
					$day30->addDay();
				@endphp
			@endwhile
		</tr>

		<tr>
			<td>>60</td>
			<td></td>
			{{-- /**/ --}}
			@php
				$day30 = Carbon\Carbon::today()->subDays(90);
			@endphp
			@while ($day30 <= Carbon\Carbon::today())
				@php
					$ef = App\ExcelFile::where('created_at','>=',$day30)->where('created_at','<',$day30->copy()->addDay())->get()->last();
				@endphp
				@if ($ef)
					<td>{{ $ef->mp60 }}</td>
				@endif
				@php
					$day30->addDay();
				@endphp
			@endwhile
		</tr>
	</tbody>
	</table>