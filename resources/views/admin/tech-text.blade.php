<span>{{ $c->sin_number }}</span>
<span>{{ isset($info_text['typology']) ? $info_text['typology'] : NULL}}</span>
<span>{{ isset($info_text['brand']) ? $info_text['brand'] : NULL}}</span>
<span>{{ isset($info_text['model']) ? $info_text['model'] : NULL}}</span>
<span>{{ isset($info_text['serial']) ? $info_text['serial'] : NULL}}</span>
<span>{{ isset($info_text['year']) ? $info_text['year'] : NULL}}</span>
<span>{{ isset($info_text['component']) ? $info_text['component'] : NULL}}</span>
<span>
@if (isset($info_text['location']))
@php
if ($info_text['location'] == "Sotto tetto") {
echo "1";
}else{
echo "2";
}
@endphp
@else
@php NULL @endphp
@endif
</span>
<span>
@if (isset($info_text['condition']))
@php
if ($info_text['condition'] == "Adeguate al tempo di utilizzo") {
echo "1";
}elseif ($info_text['condition'] == "Presenti evidenti segni di dannegiamento meccanico") {
echo "2";
}elseif ($info_text['condition'] == "Il bene non è stato mostrato perchè non conservato") {
echo "3";
}elseif ($info_text['condition'] == "Presenti evidenti segni di vetustà") {
echo "4";
}elseif ($info_text['condition'] == "Presenti evidenti segni di dannegiamento da fenomeno elettrico") {
echo "5";
}
@endphp
@else
@php NULL @endphp
@endif
</span>
<span>
@if (isset($info_text['repaired']))
@php
if ($info_text['repaired'] == "Si, con residui conservati") {
echo "1";
}elseif ($info_text['repaired'] == "No") {
echo "2";
}elseif ($info_text['repaired'] == "Si, ma con residui NON conservati") {
echo "3";
}
@endphp
@else
@php NULL @endphp
@endif
</span>
@if (isset($info_text['connected']))
@foreach ($info_text['connected'] as $value)
@if ($value == "Corrente Elettrica")
<span>S</span>
@else
<span>N</span>
@endif
@endforeach
@else
<span>N</span>
@endif
@if (isset($info_text['connected']))
@foreach ($info_text['connected'] as $value)
@if ($value == "Linea tel./adsl")
<span>S</span>
@else
<span>N</span>
@endif
@endforeach
@else
<span>N</span>
@endif
@if (isset($info_text['connected']))
@foreach ($info_text['connected'] as $value)
@if ($value == "Gruppo di continuità")
<span>S</span>
@else
<span>N</span>
@endif
@endforeach
@else
<span>N</span>
@endif
@if (isset($info_text['connected']))
@foreach ($info_text['connected'] as $value)
@if ($value == "Antenna TV")
<span>S</span>
@else
<span>N</span>
@endif
@endforeach
@else
<span>N</span>
@endif
@if (isset($info_text['connected']))
@foreach ($info_text['connected'] as $value)
@if ($value == "Differenziale")
<span>S</span>
@else
<span>N</span>
@endif
@endforeach
@else
<span>N</span>
@endif
@if (isset($info_text['connected']))
@foreach ($info_text['connected'] as $value)
@if ($value == "Altro (specificare)")
<span>S</span>
@else
<span>N</span>
@endif
@endforeach
@else
<span>N</span>
@endif
<span>{{ isset($info_text['specify']) ? $info_text['specify'] : NULL}}</span>
<span>
@if (isset($info_text['anomalies']))
@php
if ($info_text['anomalies'] == "Si") {
echo "1";
}else{
echo "2";
}
@endphp
@else
@php NULL @endphp
@endif
</span>
<span>{{ isset($info_text['which_anomalies']) ? $info_text['which_anomalies'] : NULL}}</span>
<span>
@if (isset($info_text['protection']))
@php
if ($info_text['protection'] == "Si, danneggiati") {
echo "1";
}elseif($info_text['protection'] == "Si, NON danneggiati") {
echo "2";
}elseif($info_text['protection'] == "No") {
echo "3";
}
@endphp
@else
@php NULL @endphp
@endif
</span>
<span>{{ isset($info_text['which_protection']) ? $info_text['which_protection'] : NULL}}</span>
<span>
@if(isset($info_text['working']))
@php
if($info_text['working'] == "Eseguito, il bene NON funziona"){
echo "1";
}elseif($info_text['working'] == "Eseguito, il bene FUNZIONA"){
echo "2";
}elseif($info_text['working'] == "NON eseguibile in loco"){
echo "3";
}
@endphp
@else
@php NULL @endphp
@endif
</span>
<span>
@if(isset($info_text['inside']))
@php
if($info_text['inside'] == "Evidente bruciatura"){
echo "1";
}elseif($info_text['inside'] == "Bruciatura non visible"){
echo "2";
}elseif($info_text['inside'] == "Non eseguibile"){
echo "3";
}
@endphp
@else
@php NULL @endphp
@endif
</span>
<span>
@if(isset($info_text['olfactory']))
@php
if($info_text['olfactory'] == "Odore acre di brucio"){
echo "1";
}elseif($info_text['olfactory'] == "Nula rilevabile"){
echo "2";
}
@endphp
@else
@php NULL @endphp
@endif
</span>
<span>
@if(isset($info_text['instruments']))
@php
if($info_text['instruments'] == "Effettuata verifica - SI danno"){
echo "1";
}elseif($info_text['instruments'] == "Effettuata verifica - NO danno"){
echo "2";
}elseif($info_text['instruments'] == "Non effettuata verifica / Non definitiva"){
echo "3";
}
@endphp
@else
@php NULL @endphp
@endif
</span>
<span>
@if(isset($info_text['withdrawal']))
@php
if($info_text['withdrawal'] == "SI, il Perito ritira il Bene"){
echo "1";
}elseif($info_text['withdrawal'] == "NO, il Perito NON ritira il Bene"){
echo "2";
}
@endphp
@else
@php NULL @endphp
@endif
</span>
<span>
@if(isset($info_text['no_verification']))
@php
if($info_text['no_verification'] == "Il bene non è stato conservato"){
echo "1";
}elseif($info_text['no_verification'] == "Il bene è presso..."){
echo "2";
}
@endphp
@else
@php NULL @endphp
@endif
</span>
<span>{{ isset($info_text['in']) ? $info_text['in'] : NULL }}</span>
<span>{{ isset($info_text['conclussion']) ? $info_text['conclussion'] : NULL }}</span>