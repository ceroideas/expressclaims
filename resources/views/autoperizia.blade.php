
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>EXPRESS CLAIMS - Autogestione</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<meta name="theme-color" content="#5b6e84" />
	<link rel="shortcut icon" href="{{ url('favicon.ico') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">

    <link href="{{ url('/js') }}/pnotify.custom.min.css" rel="stylesheet" />
	{{-- <link href="https://dev.apirtc.com/themes/apirtc/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"> --}}
    <audio loop src="{{ url('tone.mp3') }}" id="new-call" ></audio>

	<style>
		body {
			background: #f1f2f7;
		}

        input:not([type]):focus:not([readonly]), input[type=text]:not(.browser-default):focus:not([readonly]), input[type=password]:not(.browser-default):focus:not([readonly]), input[type=email]:not(.browser-default):focus:not([readonly]), input[type=url]:not(.browser-default):focus:not([readonly]), input[type=time]:not(.browser-default):focus:not([readonly]), input[type=date]:not(.browser-default):focus:not([readonly]), input[type=datetime]:not(.browser-default):focus:not([readonly]), input[type=datetime-local]:not(.browser-default):focus:not([readonly]), input[type=tel]:not(.browser-default):focus:not([readonly]), input[type=number]:not(.browser-default):focus:not([readonly]), input[type=search]:not(.browser-default):focus:not([readonly]), textarea.materialize-textarea:focus:not([readonly]), .select-wrapper input.select-dropdown:focus {
            border-bottom: 1px solid #4384c5;
            -webkit-box-shadow: 0 1px 0 0 #4384c5;
            box-shadow: 0 1px 0 0 #4384c5;
        }
        input:not([type]):focus:not([readonly])+label, input[type=text]:not(.browser-default):focus:not([readonly])+label, input[type=password]:not(.browser-default):focus:not([readonly])+label, input[type=email]:not(.browser-default):focus:not([readonly])+label, input[type=url]:not(.browser-default):focus:not([readonly])+label, input[type=time]:not(.browser-default):focus:not([readonly])+label, input[type=date]:not(.browser-default):focus:not([readonly])+label, input[type=datetime]:not(.browser-default):focus:not([readonly])+label, input[type=datetime-local]:not(.browser-default):focus:not([readonly])+label, input[type=tel]:not(.browser-default):focus:not([readonly])+label, input[type=number]:not(.browser-default):focus:not([readonly])+label, input[type=search]:not(.browser-default):focus:not([readonly])+label, textarea.materialize-textarea:focus:not([readonly])+label {
                color: #4384c5;
        }

        button:focus {background-color: #4384c5;}

        /**/

        .datepicker-date-display {
            background-color: #4384c5 !important;
        }
        .datepicker-cancel, .datepicker-clear, .datepicker-today, .datepicker-done {
            color: #4384c5 !important;
        }
        .datepicker-table td.is-today {
            color: #4384c5 !important;
        }
        .datepicker-table td.is-selected {
            background-color: #4384c5 !important;
            color: #fff !important;
        }
        .dropdown-content li>a, .dropdown-content li>span {
            color: #4384c5 !important;
        }
        .btn {
            border-radius: 15px;
            height: 46px;
            font-size: 14px;
            font-weight: bolder;
            position: relative;
            transition: none;
        }
        .blue.darken-1 {
            background-color: #4384c5 !important;
            box-shadow: 0 8px 0 #25598d;
        }
        .orange {
            background-color: #fbc399 !important;
            box-shadow: 0 8px 0 #ea9975;
            color:#b67c62;
        }
        .red {
            background-color: #fbc399 !important;
            box-shadow: 0 8px 0 darkred;
            color:beige;
        }
        .btn:hover {
            box-shadow: none;
            top: 8px;
            box-shadow: 0 0 0 #25598d;
        }

        #content-webapp {
            padding: 20px;
        }

        .card {
            border-radius: 15px;
            background-color: #4384c5;
            margin-bottom: 20px;
        }

        .activator {
            width: 100%;
        }
        h5.activator {
            width: 100%;
            color: #fff;
        }

        .no-files {
            padding: 15px;
            width: 100%;
            background-color: #65b5fd;
            color: #fff;
            font-weight: bold;
            text-align: center;
            font-size: 18px;
            border-radius: 15px;
        }

        span.badge.new {
            border-radius: 10px;
            background-color: #65b5fd;
            font-size: 16px;
            padding: 0 15px;
        }

        #btnhdCam[disabled] {
            opacity: .5;
        }

        .modal {
            border-radius: 15px;
        }

        /**/


		.site-footer {
		    background: #5b6e84;
		    color: #fff;
		    padding: 6px 0;
            text-align: center;
		}
		.main-wrapper {
			height: calc(100vh - 33px);
			overflow: auto;
			position: relative;
		}
		header {
			background-color: #fff;
			padding: 8px;
            border-radius: 8px;
			/*text-align: center;*/
			box-shadow: 0 0 5px 1px rgba(0,0,0,.2);
            position: relative;
            /*z-index: 5;*/
		}
        .hidden {
            display: none !important;
        }

		/**/
        #content-disclaimer {
            text-align: center;
            width: 90%;
            margin: auto;
        }
        [text-center] {
            text-align: center;
        }
        .list {
            text-align: left;
        }
        [type="checkbox"].filled-in:checked+span:not(.lever):after {
            border: 2px solid #1E88E5;
            background-color: #1E88E5;
        }
        [type="checkbox"]+span:not(.lever) {
            height: auto;
        }
        .list-item label > span > span {
            position: relative;
            top: -8px;
        }
        .selected {
            transition: all 200ms;
            transform: scale(1.5);
            border-radius: 64px;
        }
        /*.modal {
            max-height: fit-content;
            border-radius: 6px;
        }*/
        .danger-bg {
            background-color: #f2dede;
            color: #a94442;
            padding: 20px;
        }

        .container {
        	width: 100%;
        }

        .card-content {
        	padding: 10px !important;
        }

        .disabled-op {
        	opacity: .5;
            background-color: #e0e0e0;
        }
        .black-text h5 {
        	position: relative;
		    top: -3px;
		    vertical-align: middle;
		    padding: 20.5px 0;
		    margin: -20.5px 0 -24px;
            font-size: 20px;
            width: 100%;
        }
        .black-text h5 small {
            font-size: 16px;
        }
        .card-reveal {
        	padding: 0 !important;
            background-color: #f1f2f7 !important;
        }
        .card-reveal .s12 {
        	padding: 0;
        }
        .card-header {
        	position: relative;
        	padding: 10px;
        	/*background-color: lightblue;*/
        }
        #map {
        	height: 200px;
            border-radius: 15px;
            margin-bottom: 30px;
        }

        #content-postmessages {
            background-color: #4384c5;
            height: 100%;
            overflow: auto;
            position: absolute;
            background-color: #4384c5;
            padding: 40px;
            width: 100%;
        }
        #content-postmessages h1, #content-postquestion h1 {
            font-size: 24px;
            color: #fff;
            text-align: center;
        }
        #center-loader {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            width: 50%;
            display: none;
            z-index: 9999;
        }
        .collapsible, .collapsible-header {
            border-radius: 15px;
        }
        .mb-20 {
            margin-bottom: 20px;
        }
        .mb-10 {
            margin-bottom: 10px;
        }
        .mt-3 {
            margin-top: 10px;
        }
	</style>
</head>
<body>

    <img src="{{url('loader2.gif')}}" id="center-loader" alt="">

	<header class="header danger-bg" id="errorLocation" style="display: none; text-align: center;">
        Geolocalizzazione non attiva. Per attivarla <a href="#" onclick="$('#explication').modal('open')">clicca qui</a> e successivamente ricarica la pagina
    </header>

	<div class="container">
		<div class="main-wrapper">
            <div style="padding: 20px 20px 0;" class="{{$status === 1 ? '' : 'hidden'}}">
                <header class="header white-bg">

                	<div class="row valign-wrapper" style="margin: 0">
            	        <div class="col s2" style="text-align: left;">
            	          <img src="{{url('ag/icono-'.strtolower($img).'.jpg')}}" class="responsive-img" style="height: auto; width: 40px; position: relative; top: 3px;">
            	        </div>
            	        <div class="col s10">
            	          <span class="black-text">
            	            <h5 style="margin: 0">{{$company}} <br> <SPAN>Sinistro Nº. <b style="color: #333">{{$sin->sin_number}}</b></SPAN></h5>
            	          </span>
            	        </div>
            	        {{-- <div class="col s2" style="text-align: right">
            	          <img src="{{url('ag/home.svg')}}" class="responsive-img" style="width: 28px; position: relative; top: 3px;">
            	        </div> --}}
            	    </div>
                    <!--logo end-->
                </header>
            </div>

            <div id="content-disclaimer" padding class="{{$status === 1 ? '' : 'hidden'}}">
                <h4 text-center>Benvenuto in <b>EXPRESS CLAIMS</b></h4>
                <p>Gentile Cliente, prima di accedere al Servizio Le chiediamo gentilmente di confermare che:</p>

                <div>
                  <div text-wrap>
                    <a class="link" [ngClass]="clicked" href="http://www.expressclaims.it/privacy" target="_blank">(clicchi qui se vuole rivedere le) <br>
                    CONDIZIONI GENERALI DI UTILIZZO E PRIVACY POLICY
                    </a>
                  </div>
                </div>

                <br>
                
                <div class="list">
                    <div class="list-item">
                        <p><label style="display: block">
                            <input type="checkbox" class="filled-in blue" checked="checked" id="q1" onclick="checkIfTrue()"/>
                            <span><span>Ho letto ed accetto integralmente le Condizioni Generali di Utilizzo e la Privacy Policy</span></span>
                        </label></p>
                    </div>

                    <div class="list-item">
                        <p><label style="display: block">
                            <input type="checkbox" class="filled-in blue" checked="checked" id="q2" onclick="checkIfTrue()"/>
                            <span><span>Comprendo ed accetto che avendo installato l’applicazione verrò geolocalizzato e condividerò la mia posizione con l’Operatore</span></span>
                        </label></p>
                    </div>

                    <div class="list-item">
                        <p><label style="display: block">
                            <input type="checkbox" class="filled-in blue" checked="checked" id="q3" onclick="checkIfTrue()"/>
                            <span><span>Comprendo ed accetto che tutte le fotografie che scatterò ed i documenti che allegherò potrebbero essere condivisi con la mia Compagnia di Assicurazione</span></span>
                        </label></p>
                    </div>
                </div>

                <br>

                <button id="accept-disclaimer" class="btn waves-effect waves-light blue darken-1" style="width: 100%;">ACCETTO E PROSEGUO</button>

                <br>
                <br>
            </div>

			<div id="content-webapp" class="hidden">

				<div class="col s12 m8 offset-m2 l6 offset-l3">

					<div class="card" style="position: unset;" id="step1">
					    <div class="card-content">
					      <div class="row valign-wrapper activator" style="margin:0">
				            <div class="col s2">
				              <img src="{{url('ag/i/imagenes.svg')}}" alt="" class="responsive-img" style="top: 3px;position: relative;"> <!-- notice the "circle" class -->
				            </div>
				            <div class="col s10">
				              <span class="black-text">
				                <h5 class="waves-effect waves-light activator">1) Scatta foto <img src="{{url('ag/i/aceptar.svg')}}" style="float: right; width: 24px; display: none;" alt=""></h5>
				              </span>
				            </div>
				          </div>
					    </div>
					    <div class="card-reveal row" style="margin: 0">
					      <div class="col s12">
					      	<span class="card-title hidden">Close</span>
						      <ul class="tabs" style="display: none">
							    <li class="tab col s3" id="i1"><a class="active" href="#images1">1</a></li>
							    <li class="tab col s3" id="i2"><a href="#images2">2</a></li>
							    <li class="tab col s3" id="i3"><a href="#images3">3</a></li>
							    <li class="tab col s3" id="i4"><a href="#images4">4</a></li>
							  </ul>
					      </div>
						  @include('templates.images')
					    </div>
					</div>

					<div class="card disabled-op" style="position: unset;" id="step2">
					    <div class="card-content">
					      <div class="row valign-wrapper " style="margin:0">
				            <div class="col s2">
				              <img src="{{url('ag/i/documentos.svg')}}" alt="" class="responsive-img " style="top: 3px;position: relative;"> <!-- notice the "circle" class -->
				            </div>
				            <div class="col s10">
				              <span class="black-text">
				                <h5 class="waves-effect waves-light">2) Giustificativi danno <img src="{{url('ag/i/aceptar.svg')}}" style="float: right; width: 24px; display: none;" alt=""></h5>
				              </span>
				            </div>
				          </div>
					    </div>
					    <div class="card-reveal row" style="margin: 0">
					      <span class="card-title hidden">Close</span>
						  @include('templates.document')
					    </div>
					</div>

					<div class="card disabled-op" style="position: unset;" id="step3">
					    <div class="card-content">
					      <div class="row valign-wrapper " style="margin:0">
				            <div class="col s2">
				              <img src="{{url('ag/i/informacion.svg')}}" alt="" class="responsive-img " style="top: 3px;position: relative;"> <!-- notice the "circle" class -->
				            </div>
				            <div class="col s10">
				              <span class="black-text">
				                <h5 class="waves-effect waves-light">3) Informazioni sinistro <img src="{{url('ag/i/aceptar.svg')}}" style="float: right; width: 24px; display: none;" alt=""></h5>
				              </span>
				            </div>
				          </div>
					    </div>
					    <div class="card-reveal row" style="margin: 0">
					      <div class="col s12">
					      	<span class="card-title hidden">Close</span>
						      <ul class="tabs2" style="display: none">
							    <li class="tab col s3" id="i1"><a class="active" href="#information1">1</a></li>
							    <li class="tab col s3" id="i2"><a href="#information2">2</a></li>
							  </ul>
					      </div>
					      @include('templates.information')
					    </div>
					</div>

			    </div>

			    <br> <br>


			    <img src="{{url('ajax-loader.gif')}}" id="finalize-loading" class="responsive-img" alt="" style="margin: auto; width: 150px; display: none;">

            </div>

            {{-- Scatta foto --}}

            <div id="content-postmessages" class="{{$status === 0 ? '' : 'hidden'}}">
                <div style="position: relative; top: 5%;">
                    <img src="{{url('ag/cameraw.svg')}}" style="width: 100px;display: block; margin:auto;" alt="">
                    <h1>Grazie per aver usato Self Claims, i dati sono inviati al nostro perito che provvederà a ricontattarla quanto prima per la definizione del sinistro</h1>
                </div>
            </div>
		</div>
	</div>

    <div id="explication" class="modal">
        <div class="modal-content">
        <h5 style="margin-top: 0">Attiva la Geolocalizzazione</h5>
        <ol>
            {{-- <li>Fai clic sull'icona a sinistra della barra degli indirizzi</li>
            <li>Fai clic su Impostazioni sito.</li>
            <li>Modifica impostazione di autorizzazione. Le modifiche verranno salvate automaticamente.</li> --}}

            <li>Fai clic sull'icona del lucchetto</li>
            <li>Fai clic su Impostazioni sito</li>
            <li>Fai clic sul triangolo in alto Posizione</li>
            <li>Attiva il pulsante geolocalizzazione</li>
        </ol>
        {{-- <p>Apizee team</p> --}}
        </div>
        <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" onclick="location.reload()">Ok</a>
        </div>
    </div>

    {{-- /**/ --}}

    <div id="alert1" class="modal" style="background-color: #fff">
        <div class="modal-content" style="padding: 10px 10px 30px; text-align: center;">
        	<p style="text-align: center; font-size: 18px; font-weight: bolder;">Clicca sull'icona <br> <img src="{{url('ag/i/tomar-foto.svg')}}" alt="" style="width: 60px;">
                <br> e scatta massimo 12 fotografie,  alcune con vista di insieme, alcune di dettaglio. <br> Poi schiacca il tasto <br> [PROSEGUI] <!-- <img src="{{url('ag/i/aceptar.svg')}}" alt="" style="width: 30px;"> --></p>
        	{{-- <p>Apizee team</p> --}}
        	<button class="btn blue darken-1 modal-action modal-close waves-effect waves-light">Vai ></button>
        </div>
    </div>

    <div id="alert2" class="modal">
        <div class="modal-content">
        <h5>Immagini confermate</h5>
        <span id="images-confirmed"></span>
        <span class="modal-action modal-close" style="color: crimson; text-decoration: underline;">Correggere</span>
        </div>
        <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat" id="accept-confirm">Continua comunque</a>
        </div>
    </div>

    <div id="alert3" class="modal" style="background-color: #fff">
        <div class="modal-content" style="padding: 10px 10px 30px; text-align: center;">
        	<p style="text-align: center; font-size: 18px; font-weight: bolder;">Grazie! <br> prosegui ora con il caricamento dei documenti</p>
        	{{-- <p>Apizee team</p> --}}
        	<button class="btn blue darken-1 modal-action modal-close waves-effect waves-light">Vai ></button>
        </div>
    </div>

    <div id="alert4" class="modal" style="background-color: #fff">
        <div class="modal-content" style="padding: 10px 10px 30px; text-align: center;">
        	<p style="text-align: center; font-size: 18px; font-weight: bolder;">Grazie! <br> prosegui ora con il caricamento delle informazioni sul sinistro</p>
        	{{-- <p>Apizee team</p> --}}
        	<button class="btn blue darken-1 modal-action modal-close waves-effect waves-light">Vai ></button>
        </div>
    </div>


    <div id="confirm1" class="modal" style="background-color: #fff">
        <div class="modal-content" style="padding: 10px 10px 30px; text-align: center;">
            <p style="text-align: center; font-size: 18px; font-weight: bolder;">Sei sicuro di voler proseguire senza caricare altre foto?</p>
            {{-- <p>Apizee team</p> --}}
            <button class="btn blue darken-1 modal-action modal-close waves-effect waves-light" id="btnConfirm">OK prosegui ></button>

            <button class="btn red modal-action modal-close waves-effect waves-light mt-3" onclick="$('#confirm1').close()">NO, rimani e carica altre foto</button>
        </div>
    </div>

    <div id="confirm2" class="modal" style="background-color: #fff">
        <div class="modal-content" style="padding: 10px 10px 30px; text-align: center;">
            <p style="text-align: center; font-size: 18px; font-weight: bolder;">Sei sicuro di voler proseguire senza caricare altri documenti?</p>
            {{-- <p>Apizee team</p> --}}
            <button class="btn blue darken-1 modal-action modal-close waves-effect waves-light" id="btnConfirm2">OK prosegui ></button>

            <button class="btn red modal-action modal-close waves-effect waves-light mt-3" onclick="$('#confirm2').close()">NO, rimani e carica altre documenti</button>
        </div>
    </div>

    <div id="confirm3-1" class="modal" style="background-color: #fff">
        <div class="modal-content" style="padding: 10px 10px 30px; text-align: center;">
            <p style="text-align: center; font-size: 18px; font-weight: bolder;">Sei sicuro di voler terminare l'AUTOPerizia?</p>
            {{-- <p>Apizee team</p> --}}
            {{-- <button class="btn blue darken-1 modal-action modal-close waves-effect waves-light" id="finalize-1">Vai ></button> --}}
            <button class="btn blue darken-1 modal-action modal-close waves-effect waves-light" id="finalize-1">OK prosegui ></button>

            <button class="btn red modal-action modal-close waves-effect waves-light mt-3" onclick="$('#confirm3-1').close()">No, modifica informazioni</button>
        </div>
    </div>

    <div id="confirm3" class="modal" style="background-color: #fff">
        <div class="modal-content" style="padding: 10px 10px 30px; text-align: center;">
            <p style="text-align: center; font-size: 18px; font-weight: bolder;">Sei sicuro di voler terminare l'AUTOPerizia?</p>
            {{-- <p>Apizee team</p> --}}
            {{-- <button class="btn blue darken-1 modal-action modal-close waves-effect waves-light" id="finalize-2">Vai ></button> --}}
            <button class="btn blue darken-1 modal-action modal-close waves-effect waves-light" id="finalize-2">OK prosegui ></button>

            <button class="btn red modal-action modal-close waves-effect waves-light mt-3" onclick="$('#confirm3').close()">No, modifica informazioni</button>
        </div>
    </div>


    {{-- /**/ --}}

	<footer class="site-footer">
      <div class="text-center">
          {{date('Y')}} © Renova
          <a href="#" class="go-top">
              <i class="fa fa-angle-up"></i>
          </a>
      </div>
  	</footer>

    <input type="file" accept="image/*" capture="camera" id="hdCam" style="display: none">
    <input type="file" accept="image/*" capture="camera" id="hdCam2" style="display: none">
    <input type="file" accept=".xlsx,.xls,image/*,.doc,.docx,.ppt,.pptx,.txt,.pdf" id="documents" style="display: none">
    <input type="file" accept="image/*" capture="camera" id="iban" style="display: none">

  	<script type="text/javascript" src="https://cloud.apizee.com/apiRTC/apiRTC-latest.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script src="{{ url('/js') }}/pnotify.custom.min.js"></script>
    <script src="{{ url('/js') }}/geo.js"></script>
    {{-- <script src="https://dev.apirtc.com/themes/apirtc/plugins/jquery-1.12.3.min.js"></script> --}}
	{{-- <script src="https://dev.apirtc.com/themes/apirtc/plugins/bootstrap/js/bootstrap.min.js"></script> --}}

<script>
    // if (navigator.connection.downlink < 1) {
        // alert('La tua velocità di connessione è inferiore a quella richiesta dal nostro server!');
        // window.open('https://google.com','_self');
    // }
    var options = {
        enableHighAccuracy: true,
        timeout: 60000,
        maximumAge: 0
    }

    // var outgoing = false;
        
    var lat, lng;
    var secs = 0;
    var lowspec = false;
    var interval = setInterval(()=>{
        secs+=0.1;
    },100)
    $.ajax({
        url: '{{url('ping')}}'
    })
    .done(function() {
        clearInterval(interval);
        console.log("success",secs);
        if (secs > 1.1) {
            lowspec = true;
            alert('La tua velocità di connessione è inferiore a quella richiesta dal nostro server!');
        }
    })
    .fail(function() {
        lowspec = true;
        alert('La tua velocità di connessione è inferiore a quella richiesta dal nostro server!');
        console.log("error");
    });

    var constraints = {audio: {echoCancellation:true}, video: {facingMode: 'environment', frameRate: { ideal: 60, max: 60 } } };

    localStorage.setItem('facingMode','environment');

    // videoSelect.onchange = selectMediaChange;

    apiRTC.init({
        apiKey : "c67e026888d764c51462554b272f3419",
        // apiKey : "5ea39d65d0fff6f5b486a18a11ac46c3", // webgest
        // apiKey : "819abef1fde1c833e0601ec6dd4a8226", // video
        apiCCId : "{{$call_id}}",
        onReady : sessionReadyHandler
    });

    function checkIfTrue()
    {
            if ($('#q1').is(':checked') && $('#q2').is(':checked') && $('#q3').is(':checked')) {
                $('#accept-disclaimer').attr('disabled',false);
            }else{
                $('#accept-disclaimer').attr('disabled',true);
            }
    }

    $('#accept-disclaimer').click(function(event) {

        setTimeout(()=>{
            // localStorage.setItem('disclaimer','1');
            $('#content-disclaimer').addClass('hidden');
            $('#content-webapp').removeClass('hidden');
        },100)

    });

    var images = [];
    var documents = [];
    var iban = [];

    function createElements()
    {
    	$('#noimages-message').addClass('hidden');
        let html = '';

        $.each(images, function(index, val) {

            html+='<ul class="collapsible">';

        	html+='<li id="image-'+index+'">\
			    <div class="collapsible-header">';
			      html+= 'Immagine '+(parseInt(index)+1);
			      if (val.confirm) {
			      	html+= '<span class="new- badge" style="">(Clicca per vedere foto)</span>';
			      }
			      html+= '</div>\
			    <div class="collapsible-body" style="text-align:center;">\
			    	<img src="'+val.url+'" style="width: 100px; max-width: 400px;" alt=""> <br>';
			    	
                    html += '<img src="{{url('ag/i/borrar.svg')}}" onclick="deleteElement('+index+')" class="waves-effect waves-light" style="width:30px;">';

			    	html+= '<div style="clear:both;"></div>\
			    </div>\
			  </li>';
            html+='</ul>';

        });

        $('#imagesList').html(html);

        $('.collapsible').collapsible();

        if (images.length >= 12) {
    		$('#btnhdCam').addClass('hidden');
    	}else{
    		$('#btnhdCam').removeClass('hidden');
    	}

    	if (images.length == 0) {
    		$('#imagesList').html("");
    		$('#noimages-message').removeClass('hidden');
    	}

    	checkConfirm();
    }

    function createElements2()
    {
    	$('#nodocument-message').addClass('hidden');
        let html = '';

        $.each(documents, function(index, val) {

            let type = ""

            if (val.type == 'documents') {type="Documento";}
            if (val.type == 'hdCam2') {type="Foto";}

            html+='<ul class="collapsible">';

            html+='<li id="document-'+index+'">\
                <div class="collapsible-header">';
                  html+= type+' '+(parseInt(index)+1);
                  if (val.confirm) {
                    html+= '<span class="new- badge" style="">(Clicca per vedere)</span>';
                  }
                  html+= '</div>\
                <div class="collapsible-body" style="text-align:center;">\
                <div class="row" style="margin: 0;">\
                <div class="col s6">';
                    if (val.real) {
                        html += '<a href="'+val.real+'" target="_blank"><img src="'+val.url+'" style="width: 100px; max-width: 400px;" alt=""></a> <br>';
                    }else{
                        html += '<img src="'+val.url+'" style="width: 100px; max-width: 400px;" alt=""> <br>';
                    }
                html += '</div>\
                <div class="col s6" style="text-align: right;">';
                    html += '<img src="{{url('ag/i/borrar.svg')}}" onclick="deleteElement2('+index+')" class="waves-effect waves-light" style="width:30px;top: 30px;">';
                html +=' </div>';
                    
                '</div>';

                    html+= '<div style="clear:both;"></div>\
                </div>\
              </li>';
            html+='</ul>';

        	// html+='<div class="card-panel grey lighten-5 z-depth-1" id="document-'+index+'" style="padding: 10px; border-radius:15px; position:relative;">\
			      //     <div class="row valign-wrapper" style="margin:0">\
			      //       <div class="col s2">\
			      //         <img src="{{url('file.png')}}" alt="" class="responsive-img"> <!-- notice the "circle" class -->\
			      //       </div>\
			      //       <div class="col s10">\
			      //         <span class="black-text"> '+type+' '+(parseInt(index)+1)+'</span> <span onclick="deleteElement2('+index+')" style="float: right;"><img src="{{url('ag/i/borrar.svg')}}" style="width: 30px; position: absolute; right: 10px; top: 16px;" alt=""></span>\
			      //       </div>\
			      //     </div>\
			      //   </div>';

        });

        $('#documentsList').html(html);

        $('.collapsible').collapsible();

        if (documents.length >= 5) {
    		$('#btnhdDocument').addClass('hidden');
    		$('#btnhdCamDoc').addClass('hidden');
    	}else{
    		$('#btnhdDocument').removeClass('hidden');
    		$('#btnhdCamDoc').removeClass('hidden');
    	}

    	if (documents.length == 0) {
    		$('#imagesList').html("");
    		$('#nodocument-message').removeClass('hidden');
    	}

    	checkConfirm2();
    }

	function deleteElement(i)
	{
		images.splice(i,1);
		createElements();
	}
	function deleteElement2(i)
	{
		documents.splice(i,1);
		createElements2();
	}
	function confirmImage(i)
	{
		images[i].confirm = true;
		createElements();
	}

	function checkConfirm()
	{
		var confAlert = 0;
		$.each(images, function(index, val) {
			if (val.confirm) {
				confAlert++;
			}
		});

		if (confAlert > 0) {
			$('#btnConfirm-modal').show();
		}else{
			$('#btnConfirm-modal').hide();
		}
	}

	function checkConfirm2()
	{
		var confAlert = documents.length;

		if (confAlert > 0) {
			$('#btnConfirm2-modal').show();
		}else{
			$('#btnConfirm2-modal').hide();
		}
	}

    $('#hdCam').change(function(event) {

    	if (!$(this).prop("files")[0]) {return false}

    	if (images.length >= 12) {
    		return false;
    	}

        $('#center-loader').show();

    	var formData = new FormData();
        formData.append('file',$(this).prop("files")[0]);
        formData.append('_token','{{csrf_token()}}');
        formData.append('lat',lat);
        formData.append('lng',lng);

        $('#btnhdCam').attr('disabled', 'disabled');

        $.ajax({
            url: '{{url('preUploadImage')}}',
            type: 'POST',
            processData:false,
            contentType: false,
            data: formData
        })
        .done(function(data) {
            images.push(data);
            createElements();
        })
        .fail(function() {
            $('#btnhdCam').removeAttr('disabled');
        })
        .always(function() {
            $('#btnhdCam').removeAttr('disabled');
            $('#center-loader').hide();
        });

    });

    $('#text_iban').keyup(function(event) {
    	if ($(this).val() == "") {
    		$('[for="iban"]').css('background-color', '#ffffff');
    		$('#iban').removeAttr('disabled');
    		$('#finalize-1-modal').attr('disabled','disabled');
            $('#finalize-2-modal').show();
    		iban = [];
    	}else{
    		$('[for="iban"]').css({'background-color':'#f5f5f5','background-image':'unset'});
    		$('#iban').attr('disabled','disabled');
    		$('#finalize-1-modal').removeAttr('disabled');
            $('#finalize-2-modal').hide();
    		iban = [{"url":null,"name":$(this).val()}];
    	}
    });

    $('#iban').change(function(event) {

    	if (!$(this).prop("files")[0]) {return false}

    	if (images.length >= 12) {
    		return false;
    	}

        $('#center-loader').show();

    	var formData = new FormData();
        formData.append('file',$(this).prop("files")[0]);
        formData.append('_token','{{csrf_token()}}');
        formData.append('lat',lat);
        formData.append('lng',lng);

        $('#text_iban').attr('disabled', 'disabled');

        $.ajax({
            url: '{{url('preUploadImage')}}',
            type: 'POST',
            processData:false,
            contentType: false,
            data: formData
        })
        .done(function(data) {
            iban = [data];
            $('[for="iban"]').hide();
            $('#afterphoto').show();
            $('#afterphoto > div').unbind('click');
            $('#afterphoto > div').css('background-image', 'url('+data.url+')').click(function(event) {
                window.open(data.url,'_blank');
            });;
            $('#finalize-1-modal').removeAttr('disabled');
            $('#finalize-2-modal').hide();
            // $('#text-placeholder').hide();
        })
        .fail(function() {
            $('#text_iban').removeAttr('disabled');
        })
        .always(function() {
            $('#center-loader').hide();
        });

    });

    function deleteIban()
    {
        $('#text_iban').prop('disabled', false);
        $('[for="iban"]').show();
        $('#afterphoto').hide();
        iban = [];
        $('#finalize-1-modal').removeAttr('disabled');
        $('#finalize-2-modal').hide();
    }

	$('#hdCam2,#documents').change(function(event) {
		if (!$(this).prop("files")[0]) {return false}

    	if (images.length >= 12) {
    		return false;
    	}

        let id = $(this).attr('id');

        $('#center-loader').show();

    	var formData = new FormData();
        formData.append('file',$(this).prop("files")[0]);
        formData.append('lat',lat);
        formData.append('lng',lng);
        // formData.append('_token','{{csrf_token()}}');

        $('#btnhdDocument').attr('disabled', 'disabled');
        $('#btnhdCamDoc').attr('disabled', 'disabled');

        $.ajax({
            url: '{{url('api/preUploadImage')}}',
            type: 'POST',
            processData:false,
            contentType: false,
            data: formData
        })
        .done(function(data) {
            data.type = id;
            documents.push(data);
            createElements2();
        })
        .fail(function() {
            $('#btnhdDocument').removeAttr('disabled');
            $('#btnhdCamDoc').removeAttr('disabled');
        })
        .always(function() {
            $('#btnhdDocument').removeAttr('disabled');
            $('#btnhdCamDoc').removeAttr('disabled');
            $('#center-loader').hide();
        });
	});

    function receiveIMMessageHandler(e) {

        if (e.detail.message == "ff754c36216281cf74abf11c93906ffcfaa1f484") {
            localStorage.setItem('operator_id',e.detail.senderId);
            reloadPosition();
        }
    }

    function reloadPosition() {
        navigator.geolocation.getCurrentPosition(showPosition,errPosition,options);
    }

    var timeout;

    function sessionReadyHandler(e) {
        localStorage.removeItem("videoSourceId_" + apiRTC.session.apiCCId);

        // var constraint = {};
        // constraint.video = {width: { ideal: 4096 },height: { ideal: 2160 } };
        // constraint.audio = {};

        // webRTCClient.setGetUserMediaConfig(constraint);

        apiRTC.addEventListener("receiveIMMessage", receiveIMMessageHandler);

        // apiRTC.addEventListener("remoteStreamAdded", function(){
        // });

        imClient = apiCC.session.createIMClient();
        imClient.nickname = '{{$name}}';

        /**/

        localStorage.setItem('operator_id','{{$o_id}}');

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition,errPosition,options);
        }

        if (lowspec) {
            imClient.sendMessage(localStorage.getItem('operator_id'),"La velocità di connessione dell'utente è inferiore a quella richiesta dal nostro server!");
        }

    }

    function errPosition(e) {
        lat=0;
        lng=0;
        @if ($status === 1)
	        $.post('{{url('saveAutoperiziaLocation')}}', {_token: '{{csrf_token()}}',lat:lat,lng:lng,id:'{{$id}}'}, function(data, textStatus, xhr) {
	          imClient.sendMessage(localStorage.getItem('operator_id'),"c39d8c95216d7fa04bed5befd831cecbf6291c72");
	        });
        @endif
        $('#errorLocation').show();
        initMap();
    }

    function showPosition(e) {
      lat=e.coords.latitude;
      lng=e.coords.longitude
      @if ($status === 1)
	      $.post('{{url('saveAutoperiziaLocation')}}', {_token: '{{csrf_token()}}',lat:e.coords.latitude,lng:e.coords.longitude,id:'{{$id}}'}, function(data, textStatus, xhr) {
	          imClient.sendMessage(localStorage.getItem('operator_id'),"c39d8c95216d7fa04bed5befd831cecbf6291c72");
	      });
      @endif
      var geocoder = new google.maps.Geocoder;
	  var latlng = {lat:e.coords.latitude,lng:e.coords.longitude};

	  geocoder.geocode({'location': latlng}, function(results, status) {
	    if (status === 'OK') {
		  if (results[0]) {
		  	$('#mapSearchInput').val(results[0].formatted_address);
		  } else {
		    window.alert('No results found');
		  }
		} else {
	      window.alert('Geocoder failed due to: ' + status);
	    }
	  });
      initMap();
    }

    $('#explication').modal();
    $('#alert1').modal();
    $('#alert2').modal();
    $('#alert3').modal();
    $('#alert4').modal();

    $('#confirm1').modal();
    $('#confirm2').modal();
    $('#confirm3-1').modal();
    $('#confirm3').modal();

</script>




<script>

	var map, marker;

	function initMap() {
		let myLatLng = {lat:lat,lng:lng};
		map = new google.maps.Map(document.getElementById('map'), {
	      zoom: 17,
	      disableDefaultUI: true,
	      center: myLatLng
	    });

	    marker = new google.maps.Marker(
		{
		    map:map,
		    draggable:true,
		    animation: google.maps.Animation.DROP,
		    position: map.getCenter()
		});

		google.maps.event.addListener(marker, 'dragend', function() 
		{
		    geocodePosition(marker.getPosition());
		});

		function geocodePosition(pos) 
		{
		   geocoder = new google.maps.Geocoder();
		   geocoder.geocode
		    ({
		        latLng: pos
		    }, 
		        function(results, status) 
		        {
		            if (status == google.maps.GeocoderStatus.OK) 
		            {
		                $("#mapSearchInput").val(results[0].formatted_address);
		                // $("#mapErrorMsg").hide(100);
		            } 
		            else 
		            {
		                // $("#mapErrorMsg").html('Cannot determine address at this location.'+status).show(100);
		            }
		        }
		    );
		}
		initAutocomplete();
		$('.goto2').prop('disabled',false);
	}

	// function getAddress(arr)
	// {
	// 	for (var i = 0; i < arr.length; i++) {
 //            var addressType = arr[i].types[0];
 //            if (addressType) {
 //                if (addressType == 'postal_code') {
 //            		console.log(arr[i].address_components[0].short_name);
 //            		$('#postal_code').val(arr[i].address_components[0].short_name);
 //            		$('#postal_code_here').text(arr[i].address_components[0].short_name);
 //                }
 //                if (addressType == 'country') {
 //            		console.log(arr[i].address_components[0].short_name);
 //            		$('#flag').attr('src','https://www.countryflags.io/'+arr[i].address_components[0].short_name+'/shiny/64.png').show();
 //                }
 //            }
 //        }
	// }

	function initAutocomplete()
	{
		var geocoder = new google.maps.Geocoder;
		
		var input = document.getElementById('mapSearchInput');
		var countryRestrict = {'country': 'es', 'country': 'it'};
		var options = {
		  types: ['geocode']
		};

		autocomplete = new google.maps.places.Autocomplete(input, options);

		autocomplete.setComponentRestrictions(
        {'country': ['es', 'it']});

		autocomplete.addListener('place_changed', fillInAddress);

		function fillInAddress() {
		  // Get the place details from the autocomplete object.
		  var arr = autocomplete.getPlace();

		  var latlng = {lat:arr.geometry.location.lat(),lng:arr.geometry.location.lng()};

		  marker.setMap(null);

		  marker = new google.maps.Marker(
		  {
		    map:map,
		    draggable:true,
		    animation: google.maps.Animation.DROP,
		    position: latlng
		  });

		}
	}

	var instance = M.Tabs.init($('.tabs'), {});
	var inst = M.Tabs.init($('.tabs2'), {});

	$('.goto2').click(function(event) {
		instance[0].select('images2');

		setTimeout(()=>{
			$('#alert1').modal('open')
		},300)
	});

	$('._goto2').click(function(event) {
		inst[0].select('information2');
	});

	$('#btnConfirm').click(function(event) {
		var confAlert = 0;
		$.each(images, function(index, val) {
			if (val.confirm) {
				confAlert++;
			}
		});

		console.log(confAlert,images.length);

		if (confAlert < images.length) {
			$('#images-confirmed').text("Hai scattato un totale di "+images.length+" foto ma ne hai confermate solo "+confAlert);
			$('#alert2').modal('open');
		}else{
			acceptConfirm();
		}
	});

	$('#btnConfirm2').click(function(event) {
		$('.card-title').trigger('click');

		$('#step2').addClass('disabled-op').find('.activator').removeClass('activator');
		$('#step2').find('img').show();
		$('#step3').removeClass('disabled-op').find('h5:first').addClass('activator');
		$('#step3').find('.valign-wrapper').addClass('activator');

		setTimeout(()=>{
			$('#alert4').modal('open');
		},300)
	});

	$('[name="typology"],[name="date"],[name="ammount"]').change(function(event) {
		if ($('[name="typology"]').val() != null && $('[name="date"]').val() != null && $('[name="ammount"]').val() != "") {
			$('._goto2').prop('disabled', false);
		}else{
			$('._goto2').prop('disabled', 'disabled')
		}
	});

	$('#finalize-1,#finalize-2').click(function(event) {
		$('.card-title').trigger('click');

		$('#step3').addClass('disabled-op').find('.activator').removeClass('activator');
		$('#step3').find('img').show();
		$('#finalize-loading').css("display","block");

		var typology = $('[name="typology"]').val();
		var date = $('[name="date"]').val();
		var ammount = $('[name="ammount"]').val();
        var address = $('#mapSearchInput').val();

		$.post('{{url('saveAutoperiziaData')}}', {_token: '{{csrf_token()}}',id: {{$id}}, images:images,documents:documents,iban:iban, typology:typology, date:date, ammount:ammount, address: address }, function(data, textStatus, xhr) {
			$('#content-webapp').addClass('hidden');
			$('#content-postmessages').removeClass('hidden');
            $('header:last').parent().addClass('hidden');
			console.log(images,documents,iban);
		});
	});

	function acceptConfirm(event) {
		$('.card-title').trigger('click');

		$('#step1').addClass('disabled-op').find('.activator').removeClass('activator');
		$('#step1').find('img').show();
		$('#step2').removeClass('disabled-op').find('h5:first').addClass('activator');
		$('#step2').find('.valign-wrapper').addClass('activator');

		setTimeout(()=>{
			$('#alert3').modal('open');
		},300)
	}

	$('#accept-confirm').click(acceptConfirm);

	$('select').formSelect();
	$('.datepicker').datepicker({format: 'dd-mm-yyyy',
        firstDay: 1,
        yearRange: [new Date().getFullYear(),new Date().getFullYear()],
        maxDate: new Date('{{Carbon\Carbon::today()}}'),
        i18n: {
            months: ["Gennaio", "Febbraio", "Marzo", "Aprile", "Maggio", "Giugno", "Luglio", "Agosto", "Settembre", "Ottobre", "Novembre", "Dicembre"],
            monthsShort: ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"],
            weekdays: ["Domenica", "Lunedi", "Martedì", "Mercoledì", "Giovedi", "Venerdì", "Sabato"],
            weekdaysShort: ["Dom","Lun", "Mar", "Mer", "Gio", "Ven", "Sab"],
            weekdaysAbbrev: ["D","L", "M", "M", "G", "V", "S"],

            cancel: 'Esci',
            clear: 'Cancella',
            done: 'Ok'
        },
    });

</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsj-gbtqTAsxtWNbcqrRmE8ExatChS_Ko&libraries=places"></script>



</body>
</html>