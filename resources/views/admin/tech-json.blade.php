@php
	$info = $c->json_information;
	 // $c->information;
	 $logo = strtolower($c->society).'.png'
@endphp
<img src="{{ url($logo) }}" alt="" width="100px">
<h5><b>Nome assicurato:</b> {{ $c->name }}</h5>
<h5><b>Riferimento Interno:</b> {{ $c->sin_number }}</h5>
<hr>
<div>
	@foreach ($info['questions'] as $i)
		<li>
			<b>{{$i['q']}}</b> <br>
			<ul style="padding-left: 40px;">
				@foreach ($i['v'] as $v)
					<li style="list-style: circle;">{{$v}}</li>
				@endforeach
			</ul>
		</li>
	@endforeach
</div>