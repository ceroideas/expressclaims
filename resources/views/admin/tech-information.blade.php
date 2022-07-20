@php
	$info = json_decode($c->information,true);
	 // $c->information;
	 $logo = strtolower($c->society).'.png'
@endphp
<img src="{{ url($logo) }}" alt="" width="100px">
<h5><b>Nome assicurato:</b> {{ $c->name }}</h5>
<h5><b>Riferimento Interno:</b> {{ $c->sin_number }}</h5>
<hr>
<div>
	<li>
		<b>Partita di danno:</b> <br>
		<ul><li>{{ isset($info['typology']) ? $info['typology'] : '...'}}</li></ul>
	</li>

	<li>
		<b>Marca:</b> <br>
		<ul><li>{{ isset($info['brand']) ? $info['brand'] : '...'}}</li></ul>
	</li>

	<li>
		<b>Modello:</b> <br>
		<ul><li>{{ isset($info['model']) ? $info['model'] : '...'}}</li></ul>
	</li>

	<li>
		<b>N. Seriale:</b> <br>
		<ul><li>{{ isset($info['serial']) ? $info['serial'] : '...'}}</li></ul>
	</li>

	<li>
		<b>Anno fabbricazione:</b> <br>
		<ul><li>{{ isset($info['year']) ? $info['year'] : '...'}}</li></ul>
	</li>

	<li>
		<b>Componente a danno:</b> <br>
		<ul><li>{{ isset($info['component']) ? $info['component'] : '...'}}</li></ul>
	</li>

	<li>
		<b>Ubicazione bene a danno:</b> <br>
		<ul><li>{{ isset($info['location']) ? $info['location'] : '...'}}</li></ul>
	</li>

	<li>
		<b>Condizione del bene:</b> <br>
		<ul><li>{{ isset($info['condition']) ? $info['condition'] : '...'}}</li></ul>
	</li>

	<li>
		<b>Bene già riparato ?:</b> <br>
		<ul><li>{{ isset($info['repaired']) ? $info['repaired'] : '...'}}</li></ul>
	</li>

	<li>
		<b>Il bene al momento del sinistro era collegato a:</b> <br>
		<ul><li>
			@php
				if (isset($info['connected'])) {
					foreach ($info['connected'] as $value) {
						echo "- $value <br>";
					}
				}else{
					'...';
				}
			@endphp
		</li></ul>
	</li>

	<li>
		<b>Speicificare:</b> <br>
		<ul><li>{{ isset($info['specify']) ? $info['specify'] : '...'}}</li></ul>
	</li>

	<li>
		<b>Si rilevano anomalie all'impianto elettrico:</b> <br>
		<ul><li>{{ isset($info['anomalies']) ? $info['anomalies'] : '...'}}</li></ul>
	</li>

	<li>
		<b>Se SI, quali?:</b> <br>
		<ul><li>{{ isset($info['which_anomalies']) ? $info['which_anomalies'] : '...'}}</li></ul>
	</li>

	<li>
		<b>Esistevamo sistemi di protezione:</b> <br>
		<ul><li>{{ isset($info['protection']) ? $info['protection'] : '...'}}</li></ul>
	</li>

	<li>
		<b>Se SI, quali?:</b> <br>
		<ul><li>{{ isset($info['which_protection']) ? $info['which_protection'] : '...'}}</li></ul>
	</li>

	{{-- /**/ --}}

	<br>

	<li>
		<b>Funzionante:</b> <br>
		<ul><li>{{ isset($info['working']) ? $info['working'] : '...' }}</li></ul>
	</li>

	<li>
		<b>Visivo interno:</b> <br>
		<ul><li>{{ isset($info['inside']) ? $info['inside'] : '...' }}</li></ul>
	</li>

	<li>
		<b>Olfattivo:</b> <br>
		<ul><li>{{ isset($info['olfactory']) ? $info['olfactory'] : '...' }}</li></ul>
	</li>

	<li>
		<b>Strumentale:</b> <br>
		<ul><li>{{ isset($info['instruments']) ? $info['instruments'] : '...' }}</li></ul>
	</li>

	<li>
		<b>Ritiro Bene:</b> <br>
		<ul><li>{{ isset($info['withdrawal']) ? $info['withdrawal'] : '...' }}</li></ul>
	</li>

	<li>
		<b>Nessuna verifica:</b> <br>
		<ul><li>{{ isset($info['no_verification']) ? $info['no_verification'] : '...' }}</li></ul>
	</li>

	<li>
		<b>Presso:</b> <br>
		<ul><li>{{ isset($info['in']) ? $info['in'] : '...' }}</li></ul>
	</li>

	<br>

	<li>
		<b>Conclusioni:</b> <br>
		<ul><li>{{ isset($info['conclussion']) ? $info['conclussion'] : '...' }}</li></ul>
	</li>
</div>