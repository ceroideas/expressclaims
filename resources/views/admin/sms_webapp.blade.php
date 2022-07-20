<form action="{{ url('admin/sms') }}" method="post" class="panel send-form-sms" style="margin: 0;">
	{{ csrf_field() }}
		<div class="form-group" style="width: 100%">
			<label>Codice</label>
			<select name="code" class="form-control" style="width: 100%">
				<option {{ ($w->code == '1907' ? 'selected' : '') }} value="1907">Alaska (+1907)</option>
				<option {{ ($w->code == '213' ? 'selected' : '') }} value="213">Argelia (+213)</option>
				<option {{ ($w->code == '355' ? 'selected' : '') }} value="355">Albania (+355)</option>
				<option {{ ($w->code == '54' ? 'selected' : '') }} value="54">Argentina (+54)</option>
				<option {{ ($w->code == '49' ? 'selected' : '') }} value="49">Alemania (+49)</option>
				<option {{ ($w->code == '374' ? 'selected' : '') }} value="374">Armenia (+374)</option>
				<option {{ ($w->code == '376' ? 'selected' : '') }} value="376">Andorra (+376)</option>
				<option {{ ($w->code == '61' ? 'selected' : '') }} value="61">Australia (+61)</option>
				<option {{ ($w->code == '244' ? 'selected' : '') }} value="244">Angola (+244)</option>
				<option {{ ($w->code == '43' ? 'selected' : '') }} value="43">Austria (+43)</option>
				<option {{ ($w->code == '966' ? 'selected' : '') }} value="966">Arabia Saudí (+966)</option>
				<option {{ ($w->code == '973' ? 'selected' : '') }} value="973">Bahreim (+973)</option>
				<option {{ ($w->code == '387' ? 'selected' : '') }} value="387">Bosnia (+387)</option>
				<option {{ ($w->code == '880' ? 'selected' : '') }} value="880">Bangladesh (+880)</option>
				<option {{ ($w->code == '55' ? 'selected' : '') }} value="55">Brasil (+55)</option>
				<option {{ ($w->code == '32' ? 'selected' : '') }} value="32">Bélgica (+32)</option>
				<option {{ ($w->code == '359' ? 'selected' : '') }} value="359">Bulgaria (+359)</option>
				<option {{ ($w->code == '591' ? 'selected' : '') }} value="591">Bolivia (+591)</option>
				<option {{ ($w->code == '238' ? 'selected' : '') }} value="238">Cabo Verde (+238)</option>
				<option {{ ($w->code == '57' ? 'selected' : '') }} value="57">Colombia (+57)</option>
				<option {{ ($w->code == '855' ? 'selected' : '') }} value="855">Camboya (+855)</option>
				<option {{ ($w->code == '242' ? 'selected' : '') }} value="242">Congo, Rep. del (+242)</option>
				<option {{ ($w->code == '237' ? 'selected' : '') }} value="237">Camerún (+237)</option>
				<option {{ ($w->code == '243' ? 'selected' : '') }} value="243">Congo, Rep. Democ. (+243)</option>
				<option {{ ($w->code == '1' ? 'selected' : '') }} value="1">Canadá (+1)</option>
				<option {{ ($w->code == '850' ? 'selected' : '') }} value="850">Corea, Rep. Democ. (+850)</option> 
				<option {{ ($w->code == '236' ? 'selected' : '') }} value="236">Centroafricana, Rep. (+236)</option>
				<option {{ ($w->code == '82' ? 'selected' : '') }} value="82">Corea, Rep. (+82)</option>
				<option {{ ($w->code == '420' ? 'selected' : '') }} value="420">Checa, Rep. (+420)</option>
				<option {{ ($w->code == '225' ? 'selected' : '') }} value="225">Costa de Marfil (+225)</option>
				<option {{ ($w->code == '56' ? 'selected' : '') }} value="56">Chile (+56)</option>
				<option {{ ($w->code == '506' ? 'selected' : '') }} value="506">Costa Rica (+506)</option>
				<option {{ ($w->code == '86' ? 'selected' : '') }} value="86">China (+86)</option>
				<option {{ ($w->code == '385' ? 'selected' : '') }} value="385">Croacia (+385)</option>
				<option {{ ($w->code == '357' ? 'selected' : '') }} value="357">Chipre (+357)</option>
				<option {{ ($w->code == '53' ? 'selected' : '') }} value="53">Cuba (+53)</option>
				<option {{ ($w->code == '45' ? 'selected' : '') }} value="45">Dinamarca (+45)</option>
				<option {{ ($w->code == '1809' ? 'selected' : '') }} value="1809">Dominicana, Rep. (+1809)</option>
				<option {{ ($w->code == '593' ? 'selected' : '') }} value="593">Ecuador (+593)</option>
				<option {{ ($w->code == '386' ? 'selected' : '') }} value="386">Eslovenia (+386)</option>
				<option {{ ($w->code == '20' ? 'selected' : '') }} value="20">Egipto (+20)</option>
				<option {{ ($w->code == '34' ? 'selected' : '') }} value="34">España (+34)</option>
				<option {{ ($w->code == '503' ? 'selected' : '') }} value="503">El Salvador (+503)</option>
				<option {{ ($w->code == '1' ? 'selected' : '') }} value="1">Estados Unidos (+1)</option>
				<option {{ ($w->code == '971' ? 'selected' : '') }} value="971">Emiratos Árabes Unidos (+971)</option>
				<option {{ ($w->code == '372' ? 'selected' : '') }} value="372">Estonia (+372)</option>
				<option {{ ($w->code == '421' ? 'selected' : '') }} value="421">Eslovaca, Rep. (+421)</option>
				<option {{ ($w->code == '251' ? 'selected' : '') }} value="251">Etiopía (+251)</option>
				<option {{ ($w->code == '63' ? 'selected' : '') }} value="63">Filipinas (+63)</option>
				<option {{ ($w->code == '33' ? 'selected' : '') }} value="33">Francia (+33)</option>
				<option {{ ($w->code == '358' ? 'selected' : '') }} value="358">Finlandia (+358)</option>
				<option {{ ($w->code == '9567' ? 'selected' : '') }} value="9567">Gibraltar (+9567)</option>
				<option {{ ($w->code == '502' ? 'selected' : '') }} value="502">Guatemala (+502)</option>
				<option {{ ($w->code == '30' ? 'selected' : '') }} value="30">Grecia (+30)</option>
				<option {{ ($w->code == '240' ? 'selected' : '') }} value="240">Guinea Ecuatorial (+240)</option>
				<option {{ ($w->code == '299' ? 'selected' : '') }} value="299">Groenlandia (+299)</option>
				<option {{ ($w->code == '509' ? 'selected' : '') }} value="509">Haití (+509)</option>
				<option {{ ($w->code == '852' ? 'selected' : '') }} value="852">Hong Kong (+852)</option>
				<option {{ ($w->code == '1808' ? 'selected' : '') }} value="1808">Hawai (+1808)</option>
				<option {{ ($w->code == '36' ? 'selected' : '') }} value="36">Hungría (+36)</option>
				<option {{ ($w->code == '504' ? 'selected' : '') }} value="504">Honduras (+504)</option>
				<option {{ ($w->code == '91' ? 'selected' : '') }} value="91">India (+91)</option>
				<option {{ ($w->code == '353' ? 'selected' : '') }} value="353">Irlanda (+353)</option>
				<option {{ ($w->code == '62' ? 'selected' : '') }} value="62">Indonesia (+62)</option>
				<option {{ ($w->code == '354' ? 'selected' : '') }} value="354">Islandia (+354)</option>
				<option {{ ($w->code == '98' ? 'selected' : '') }} value="98">Irán (+98)</option>
				<option {{ ($w->code == '972' ? 'selected' : '') }} value="972">Israel (+972)</option>
				<option {{ ($w->code == '964' ? 'selected' : '') }} value="964">Irak (+964)</option>
				<option {{ ($w->code == '39' ? 'selected' : '') }} value="39">Italia, Vaticano (+39)</option>
				<option {{ ($w->code == '1876' ? 'selected' : '') }} value="1876">Jamaica (+1876)</option>
				<option {{ ($w->code == '962' ? 'selected' : '') }} value="962">Jordania (+962)</option>
				<option {{ ($w->code == '81' ? 'selected' : '') }} value="81">Japón (+81)</option>
				<option {{ ($w->code == '254' ? 'selected' : '') }} value="254">Kenia (+254)</option>
				<option {{ ($w->code == '965' ? 'selected' : '') }} value="965">Kuwait (+965)</option>
				<option {{ ($w->code == '856' ? 'selected' : '') }} value="856">Laos (+856)</option>
				<option {{ ($w->code == '218' ? 'selected' : '') }} value="218">Libia (+218)</option>
				<option {{ ($w->code == '371' ? 'selected' : '') }} value="371">Letonia (+371)</option>
				<option {{ ($w->code == '41' ? 'selected' : '') }} value="41">Liechtenstein (+41)</option>
				<option {{ ($w->code == '961' ? 'selected' : '') }} value="961">Líbano (+961)</option>
				<option {{ ($w->code == '370' ? 'selected' : '') }} value="370">Lituania (+370)</option>
				<option {{ ($w->code == '231' ? 'selected' : '') }} value="231">Liberia (+231)</option>
				<option {{ ($w->code == '352' ? 'selected' : '') }} value="352">Luxemburgo (+352)</option>
				<option {{ ($w->code == '261' ? 'selected' : '') }} value="261">Madagascar (+261)</option>
				<option {{ ($w->code == '52' ? 'selected' : '') }} value="52">México (+52)</option>
				<option {{ ($w->code == '60' ? 'selected' : '') }} value="60">Malasia (+60)</option>
				<option {{ ($w->code == '373' ? 'selected' : '') }} value="373">Moldavia (+373)</option>
				<option {{ ($w->code == '356' ? 'selected' : '') }} value="356">Malta (+356)</option>
				<option {{ ($w->code == '377' ? 'selected' : '') }} value="377">Mónaco (+377)</option>
				<option {{ ($w->code == '212' ? 'selected' : '') }} value="212">Marruecos (+212)</option>
				<option {{ ($w->code == '976' ? 'selected' : '') }} value="976">Mongolia (+976)</option>
				<option {{ ($w->code == '596' ? 'selected' : '') }} value="596">Martinica (+596)</option>
				<option {{ ($w->code == '258' ? 'selected' : '') }} value="258">Mozambique (+258)</option>
				<option {{ ($w->code == '222' ? 'selected' : '') }} value="222">Mauritania (+222)</option>
				<option {{ ($w->code == '264' ? 'selected' : '') }} value="264">Namibia (+264)</option>
				<option {{ ($w->code == '234' ? 'selected' : '') }} value="234">Nigeria (+234)</option>
				<option {{ ($w->code == '977' ? 'selected' : '') }} value="977">Nepal (+977)</option>
				<option {{ ($w->code == '47' ? 'selected' : '') }} value="47">Noruega (+47)</option>
				<option {{ ($w->code == '505' ? 'selected' : '') }} value="505">Nicaragua (+505)</option>
				<option {{ ($w->code == '64' ? 'selected' : '') }} value="64">Nueva Zelanda (+64)</option>
				<option {{ ($w->code == '31' ? 'selected' : '') }} value="31">Países Bajos (+31)</option>
				<option {{ ($w->code == '51' ? 'selected' : '') }} value="51">Perú (+51)</option>
				<option {{ ($w->code == '92' ? 'selected' : '') }} value="92">Pakistán (+92)</option>
				<option {{ ($w->code == '48' ? 'selected' : '') }} value="48">Polonia (+48)</option>
				<option {{ ($w->code == '507' ? 'selected' : '') }} value="507">Panamá (+507)</option>
				<option {{ ($w->code == '351' ? 'selected' : '') }} value="351">Portugal (+351)</option>
				<option {{ ($w->code == '595' ? 'selected' : '') }} value="595">Paraguay (+595)</option>
				<option {{ ($w->code == '1787' ? 'selected' : '') }} value="1787">Puerto Rico (+1787)</option>
				<option {{ ($w->code == '974' ? 'selected' : '') }} value="974">Qatar (+974)</option>
				<option {{ ($w->code == '44' ? 'selected' : '') }} value="44">Reino Unido (+44)</option>
				<option {{ ($w->code == '7' ? 'selected' : '') }} value="7">Rusia (+7)</option>
				<option {{ ($w->code == '40' ? 'selected' : '') }} value="40">Rumania (+40)</option>
				<option {{ ($w->code == '378' ? 'selected' : '') }} value="378">San Marino (+378)</option>
				<option {{ ($w->code == '94' ? 'selected' : '') }} value="94">Sri-Lanka (+94)</option>
				<option {{ ($w->code == '221' ? 'selected' : '') }} value="221">Senegal (+221)</option>
				<option {{ ($w->code == '27' ? 'selected' : '') }} value="27">Sudáfrica (+27)</option>
				<option {{ ($w->code == '65' ? 'selected' : '') }} value="65">Singapur (+65)</option>
				<option {{ ($w->code == '249' ? 'selected' : '') }} value="249">Sudán (+249)</option>
				<option {{ ($w->code == '963' ? 'selected' : '') }} value="963">Siria (+963)</option>
				<option {{ ($w->code == '46' ? 'selected' : '') }} value="46">Suecia (+46)</option>
				<option {{ ($w->code == '252' ? 'selected' : '') }} value="252">Somalia (+252)</option>
				<option {{ ($w->code == '41' ? 'selected' : '') }} value="41">Suiza (+41)</option>
				<option {{ ($w->code == '66' ? 'selected' : '') }} value="66">Tailandia (+66)</option>
				<option {{ ($w->code == '216' ? 'selected' : '') }} value="216">Túnez (+216)</option>
				<option {{ ($w->code == '886' ? 'selected' : '') }} value="886">Taiwan (+886)</option>
				<option {{ ($w->code == '90' ? 'selected' : '') }} value="90">Turquía (+90)</option>
				<option {{ ($w->code == '255' ? 'selected' : '') }} value="255">Tanzania (+255)</option>
				<option {{ ($w->code == '380' ? 'selected' : '') }} value="380">Ucrania (+380)</option>
				<option {{ ($w->code == '598' ? 'selected' : '') }} value="598">Uruguay (+598)</option>
				<option {{ ($w->code == '256' ? 'selected' : '') }} value="256">Uganda (+256)</option>
				<option {{ ($w->code == '84' ? 'selected' : '') }} value="84">Vietnam (+84)</option>
				<option {{ ($w->code == '58' ? 'selected' : '') }} value="58">Venezuela (+58)</option>
				<option {{ ($w->code == '967' ? 'selected' : '') }} value="967">Yemen (+967)</option>
				<option {{ ($w->code == '381' ? 'selected' : '') }} value="381">Yugoslavia (+381)</option>
				<option {{ ($w->code == '260' ? 'selected' : '') }} value="260">Zambia (+260)</option>
				<option {{ ($w->code == '263' ? 'selected' : '') }} value="263">Zimbawe (+263)</option>
			</select>
		</div>
		<br>
		<br>
		<div class="form-group" style="width: 100%">
			<label>Telefono</label> <br>
			<input type="text" name="number" class="form-control" placeholder="Telefono per condividere il link" style="width: 100%" value="{{$w->phone}}">
		</div>
		<br>
		<br>
		<div class="form-group" style="width: 100%">
			<label>Messaggio</label>
			<textarea name="message" class="form-control" rows="4" style="width: 100%">Per iniziare la videoconferenza clicca il seguente link: {{$w->url}}</textarea>
		</div>

		<br><br>
		
		<div class="alert alert-danger hide" id="error"></div>
		
		<div class="alert alert-success hide" id="success">
            SMS INVIATO <br> Si prega di attendere 10 secondi
        </div>

		<button type="submit" class="btn btn-block btn-success">Invia</button>
		<br>
		<button type="button" class="btn btn-block btn-info copy-link" data-url="{{$w->url}}">copia link</button>
</form>