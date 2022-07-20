
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>EXPRESS CLAIMS - WEB APP</title>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<meta name="theme-color" content="#5b6e84" />
	<link rel="shortcut icon" href="{{ url('favicon.ico') }}">
    <link href="https://materializecss.com/css/ghpages-materialize.css" type="text/css" rel="stylesheet" media="screen,projection">

    <link href="{{ url('/js') }}/pnotify.custom.min.css" rel="stylesheet" />
	{{-- <link href="https://dev.apirtc.com/themes/apirtc/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet"> --}}
    <audio loop src="{{ url('tone.mp3') }}" id="new-call" ></audio>

	<style>
		body {
			background: #f1f2f7;
		}
		.site-footer {
		    background: #5b6e84;
		    color: #fff;
		    padding: 6px 0;
            text-align: center;
		}
		.main-wrapper {
			height: calc(100vh - 40px - 62px);
			overflow: auto;
			position: relative;
		}
		header {
			background-color: #fff;
			padding: 10px;
			text-align: center;
			box-shadow: 0 0 5px 1px rgba(0,0,0,.2);
		}
        .hidden {
            display: none !important;
        }

		/**/

        #myRemoteVideo video {
            height: 20vw;
        }

        #content-videocall {
            /*display: table-cell;
            vertical-align: middle;
            text-align: center;*/
        }
        #icon-camera img {
            width: 40%;
            filter: opacity(.2);
        }
        #icon-camera {
            width: 100%;
            position: absolute;
            top: 18%;
            text-align: center;
        }

        #icon-only-camera img {
            width: 40%;
            filter: opacity(.2);
        }
        #icon-only-camera {
            width: 100%;
            position: absolute;
            top: 27%;
            text-align: center;
        }

		.fullScreen {
			background-color: #4384c5 !important;
		    height: 100% !important;
		    width: 100%;
		    position: absolute !important;
		    overflow: hidden;
		    z-index: -1 !important;
		}
		.fullScreen video {
			background-color: transparent !important;
			min-width: 100% !important;
		    min-height: 100vh !important;
		    width: auto !important;
		    height: auto !important;
		    position: relative !important;
		    top: 50% !important;
		    left: 50% !important;
		    -webkit-transform: translateX(-50%) translateY(-50%) !important;
		    transform: translateX(-50%) translateY(-50%) !important;
		    overflow: hidden !important;
		    transform: rotate(90deg);
		    z-index: -2 !important;
		}
        #content-disclaimer {
            text-align: center;
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
        .rate-img-1.selected {
            box-shadow: 0 0 10px #0ed145, inset 0 0 10px #0ed145;
        }
        .rate-img-2.selected {
            box-shadow: 0 0 10px #ffd21f, inset 0 0 10px #ffd21f;
        }
        .rate-img-3.selected {
            box-shadow: 0 0 10px #c1272d, inset 0 0 10px #c1272d;
        }
        #content-poll, #content-postmessages, #content-postquestion {
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
        #content-postmessages img, #content-postquestion img {
            widows: ;
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
	</style>
</head>
<body>

	<header class="header danger-bg" id="errorLocation" style="display: none">
        Geolocalizzazione non attiva. Per attivarla <a href="#" onclick="$('#explication').modal('open')">clicca qui</a> e successivamente ricarica la pagina
    </header>
    <header class="header white-bg">
        <a href="#" class="logo">
          <img src="{{url('renova.png')}}" alt="" height="44px" style="position:relative;">
        </a>
        <!--logo end-->
    </header>

	<div class="container">
		<div class="main-wrapper">

            <div id="content-disclaimer" padding>
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
                            <span><span>Comprendo ed accetto che tutte le video conferenze che avrò con l’Operatore saranno videoregistrate e potrebbero essere condivise con la mia Compagnia di Assicurazione</span></span>
                        </label></p>
                    </div>

                    <div class="list-item">
                        <p><label style="display: block">
                            <input type="checkbox" class="filled-in blue" checked="checked" id="q4" onclick="checkIfTrue()"/>
                            <span><span>Comprendo che premendo il tasto ACCETTO ED AVVIO avvierò la videochiamata</span></span>
                        </label></p>
                    </div>
                </div>

                <br>

                <button id="accept-disclaimer" class="btn waves-effect waves-light blue darken-1" style="width: 100%;">ACCETTO ED AVVIO</button>

                <br>
                <br>
            </div>

			<div id="content-videocall" class="hidden">
                <div id="icon-camera" class="hidden">
                {{-- <div id="icon-camera"> --}}
                    <span style="color: #fff;">
                        <b>COMPAGNIA: </b> {{$company ? $company : '--'}} <br>
                        <b>RIFERIMENTO INTERNO: </b> {{$sin ? $sin->sin_number : '--'}}
                        <br>
                        <br>
                    </span>
                    <img src="{{url('261871.svg')}}" alt="" style="max-width: 300px">
                    <h4 style="font-size: 16px;color: #fff;margin: 28px;">
                        LA PREGHIAMO DI ATTENDERE SULLA PRESENTE PAGINA, FRA POCHI SECONDI RICEVERA’ UNA VIDEOCHIAMATA DAL NOSTRO PERITO<br>
                    </h4>
                </div>

                {{-- <div id="icon-only-camera">
                    <img src="{{url('261871.svg')}}" alt="" style="max-width: 300px">
                </div> --}}
                {{-- /**/ --}}

                <div id="content-poll" class="hidden">

                    @php
                        $w = App\WebAppUser::find($id);
                        $q = App\Question::where('user_id',$w->user_id)->first();
                    @endphp

                    @if ($q)
                        <h5 text-center style="margin-top: 15%; color: #fff;"><b>Hai già fatto il sondaggio prima. <br> La tua risposta è mostrata sotto.</b></h5>

                        <br>

                        <img src="{{url('assets/icono-0'.$q->rate.'-b.png')}}" class="responsive-img" width="80px" style="display: block; margin: auto;">
                    @else
                        <div>
                            <h5 text-center style="margin-top: 15%; color: #fff;"><b>Come valuti il servizio che l'operatore ha fornito?</b></h5>
                            <br>
                            <form method="POST" action="{{url('sendPoll',$id)}}" id="sendPoll">
                                {{csrf_field()}}
                                <div class="row">
                                    {{-- <div class="col s3" text-center>
                                        <label><img src="{{url('assets/icono-01-a.png')}}" class="responsive-img" alt="" data-off="{{url('assets/icono-01-a.png')}}" data-on="{{url('assets/icono-01-b.png')}}" data-service="Molto buono">
                                            <input type="radio" name="rate" value="1">
                                            <img src="{{url('assets/icono-01-b.png')}}" class="hidden">
                                        </label>
                                    </div> --}}
                                    <div class="col s4" text-center>
                                        <label><img src="{{url('assets/icono-02-b.png')}}" class="rate-img-1 responsive-img" alt="" data-service="Buono">
                                            <input type="radio" name="rate" value="2">
                                        </label>
                                    </div>
                                    <div class="col s4" text-center>
                                        <label><img src="{{url('assets/icono-03-b.png')}}" class="rate-img-2 responsive-img" alt="" data-service="Giusto">
                                            <input type="radio" name="rate" value="3">
                                        </label>
                                    </div>
                                    <div class="col s4" text-center>
                                        <label><img src="{{url('assets/icono-04-b.png')}}" class="rate-img-3 responsive-img" alt="" data-service="Cattivo">
                                            <input type="radio" name="rate" value="4">
                                        </label>
                                    </div>
                                </div>

                                <h6 text-center style="text-decoration:underline; color: #fff;" id="rate-text"></h6>

                                {{-- <h5><small>Vuoi lasciarci un commento?</small></h5>

                                <div class="input-field">
                                  <input placeholder="Inserisci la tua email" name="email" type="text" class="validate">
                                  <label>Email</label>
                                </div>

                                <div class="input-field">
                                  <textarea placeholder="Il tuo commento" name="comment" class="materialize-textarea" row="4"></textarea>
                                  <label>Commento</label>
                                </div> --}}

                                <button type="submit" class="waves-effect waves-light btn" style="width: 100%; margin-top: 14px;">Inviare</button>
                                <img src="{{url('ajax-loader.gif')}}" alt="" style="width: 50px" class="hidden" id="loader">
                            </form>
                        </div>
                    @endif

                </div>

                <div id="content-postmessages" class="hidden">
                    <div style="position: relative; top: 5%;">
                        <img src="{{url('phone-call.png')}}" style="width: 120px;display: block; margin:auto;" alt="">
                        <h1>Grazie per aver usato Express Claims, se ci ha autorizzato, Le verrà ora richiesto di esprimere un giudizio sul servizio, attenda per cortesia</h1>
                    </div>
                </div>

                <div id="content-postquestion" class="hidden">
                    <div style="position: relative; top: 10%;">
                        <img src="{{url('like.png')}}" style="width: 120px;display: block; margin:auto;" alt="">
                        <h1>Grazie!!</h1>
                    </div>
                </div>
                {{-- /**/ --}}
              <div id="mini" class="fullScreen"></div>
              <div id="controls" style="position: absolute;z-index: 9999;"></div>
              
              <label for="hdCam"><img src="{{ url('hd.png') }}" alt="" class="hidden takeSnapshot" id="hdImg" width="50px"
              style="position: absolute; left: 10px; bottom: 82px;z-index: 9999; cursor: pointer; background-color: lightsalmon; border-radius: 50px; padding: 8px;"></label>

              <img src="{{ url('camera.png') }}" alt="" class="hidden takeSnapshot" width="50px" id="takeSnapshot" style="position: absolute; left: 10px; bottom: 22px;z-index: 9999; cursor: pointer;">
              <img src="{{ url('rotate.png') }}" alt="" class="hidden" width="50px" id="changeCamera" style="position: absolute; right: 10px; bottom: 10px;z-index: 9999; cursor: pointer;">
              <img src="{{url('incoming.png')}}" alt="" class="hidden" id="answerCall" style="position: absolute;bottom: 3%;left: 10%;width: 60px;">
              <img src="{{url('refuse.png')}}" alt="" class="hidden" id="refuseCall" style="position: absolute;bottom: 3%;right: 10%;width: 60px;">

              <button class="btn red darken-3 hidden" id="hangupCall" style="position: absolute; bottom: 10px; left:0; right: 0; margin: auto; width: 135px; font-size: 12px;">Riattacca</button>
              {{-- Please, change the camera [FRONT] [REAR] --}}
              <div id="stage">
                  <div id="myRemoteVideo">
                  </div>
              </div>
              {{-- <select class="browser-default hidden" id='videoSource'>
              </select> --}}
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

    <div id="modal1" class="modal">
        <div class="modal-content">
        <h5 style="margin-top: 0">iOS autoplay prevented detected</h5>
        <p>Simply touch screen to activate the media play.</p>
        {{-- <p>Apizee team</p> --}}
        </div>
        <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Ok</a>
        </div>
    </div>

	<footer class="site-footer">
      <div class="text-center">
          {{date('Y')}} © Renova
          <a href="#" class="go-top">
              <i class="fa fa-angle-up"></i>
          </a>
      </div>
  	</footer>

    <input type="file" accept="image/*" capture="camera" id="hdCam" style="display: none">

  	<script type="text/javascript" src="https://cloud.apizee.com/apiRTC/apiRTC-latest.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
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

    var outgoing = false;
        
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
    

    document.addEventListener('touchstart', function () {
        document.getElementsByTagName('audio')[0].play();
        document.getElementsByTagName('audio')[0].pause();
    });

    var incomingCallId,videoSelect = document.querySelector("select#videoSource");
    var constraints = {audio: {echoCancellation:true}, video: {facingMode: 'environment', frameRate: { ideal: 60, max: 60 } } };

    localStorage.setItem('facingMode','environment');

    // videoSelect.onchange = selectMediaChange;

    apiRTC.init({
        apiKey : "c67e026888d764c51462554b272f3419",
        // apiKey : "5ea39d65d0fff6f5b486a18a11ac46c3",
        // apiKey : "819abef1fde1c833e0601ec6dd4a8226",
        apiCCId : "{{$call_id}}",
        onReady : sessionReadyHandler
    });

    function checkIfTrue()
    {
        if ($('#q1').is(':checked') && $('#q2').is(':checked') && $('#q3').is(':checked') && $('#q4').is(':checked')) {
            $('#accept-disclaimer').attr('disabled',false);
        }else{
            $('#accept-disclaimer').attr('disabled',true);
        }
    }

    $('#accept-disclaimer').click(function(event) {

        if (webRTCClient) {
            localStorage.setItem('disclaimer','1');
            $('#content-disclaimer').addClass('hidden');
            $('#content-videocall').removeClass('hidden');

            setTimeout(function(){
                if (apiRTC.session.isConnectedUser(localStorage.getItem('operator_id'))) {

                    // webRTCClient.setUserAcceptOnIncomingCallBeforeGetUserMedia(false);
                    // webRTCClient.setUserAcceptOnIncomingCall(false);

                    // outgoing = true;

                    // imClient.sendMessage(localStorage.getItem('operator_id'), 'Incoming call from a customer - CODE 0001');

                    incomingCallId = webRTCClient.call(localStorage.getItem('operator_id'),{},{record:true,mode:"efficient"});

                    $('#icon-only-camera').addClass('hidden');

                    /*timeout = setTimeout(()=>{

                        // outgoing = false;

                        $('#icon-only-camera').addClass('hidden');
                        $('#icon-camera').removeClass('hidden');

                    },25000)*/
                }else{

                    // outgoing = false;

                    $('#icon-only-camera').addClass('hidden');
                    $('#icon-camera').removeClass('hidden');

                }
            },1000)
        }

    });

    // function selectMediaChange() {
    //     console.log('selectMediaChange');
    //     //webRTCClient.setAudioSourceId(audioSelect.value);
    //     // localStorage.setItem("audioSourceId_" + apiRTC.session.apiCCId, audioSelect.value);
    //     webRTCClient.setVideoSourceId(videoSelect.value);
    //     //Storing videoSourceId in localStorage
    //     localStorage.setItem("videoSourceId_" + apiRTC.session.apiCCId, videoSelect.value);
    //     webRTCClient.updateMediaDeviceOnCall(incomingCallId);
    // }

    function addStreamInDiv(stream, callType, divId, mediaEltId, style, muted) {
        var mediaElt = null,
            divElement = null,
            funcFixIoS = null,
            promise = null;
        if (callType === 'audio') {
            mediaElt = document.createElement("audio");
        } else {
            mediaElt = document.createElement("video");
        }
        mediaElt.id = mediaEltId;
        mediaElt.autoplay = true;
        mediaElt.muted = muted;
        mediaElt.style.width = style.width;
        mediaElt.style.height = style.height;
        funcFixIoS = function () {
            var promise = mediaElt.play();
            console.log('funcFixIoS');
            if (promise !== undefined) {
                promise.then(function () {
                    // Autoplay started!
                    mediaElt.srcObject.getVideoTracks()[0].applyConstraints(constraints).catch(e => console.log('errorApplyConstraints',e));
                    console.log('Autoplay started');
                    console.error('Audio is now activated');
                    document.removeEventListener('touchstart', funcFixIoS);
                    $('#modal1').modal('close');
                }).catch(function (error) {
                    // Autoplay was prevented.
                    console.error('Autoplay was prevented');
                });
            }
        };
        console.log('apiRTC.browser :', apiRTC.browser);
        console.log('apiRTC.browser_major_version :', apiRTC.browser_major_version);
        console.log('apiRTC.osName :', apiRTC.osName);
        //Patch for ticket on Chrome 61 Android : https://bugs.chromium.org/p/chromium/issues/detail?id=769148
        if (apiRTC.browser === 'Chrome' && apiRTC.browser_major_version === '61' && apiRTC.osName === "Android") {
            mediaElt.style.borderRadius = "1px";
            console.log('Patch for video display on Chrome 61 Android');
        }
        webRTCClient.attachMediaStream(mediaElt, stream);
        divElement = document.getElementById(divId);
        divElement.appendChild(mediaElt);
        promise = mediaElt.play();
        if (promise !== undefined) {
            promise.then(function () {
                mediaElt.srcObject.getVideoTracks()[0].applyConstraints(constraints).catch(e => console.log('errorApplyConstraints',e));
                // Autoplay started!
                console.log('Autoplay started');
            }).catch(function (error) {
                // Autoplay was prevented.
                if (apiRTC.osName === "iOS") {
                    console.info('iOS : Autoplay was prevented, activating touch event to start media play');
                    //Show a UI element to let the user manually start playback
                    //In our sample, we display a modal to inform user and use touchstart event to launch "play()"
                    document.addEventListener('touchstart',  funcFixIoS);
                    console.error('WARNING : Audio autoplay was prevented by iOS, touch screen to activate audio');
                    $('#modal1').modal('open');
                } else {
                    console.error('Autoplay was prevented');
                }
            });
        }
    }

    $("#hangupCall").click(function () {
        webRTCClient.hangUp();
    });

    $('#takeSnapshot').click(function(event) {
        imClient.sendMessage(localStorage.getItem('operator_id'),"Richiesta istantanea inviata - ExpressClaims");
    })

    $('#hdCam').change(function(event) {
        var formData = new FormData();
        formData.append('id',"{{$call_id}}");
        formData.append('lat',lat);
        formData.append('lng',lng);
        formData.append('address',"---");
        formData.append('type',4);
        formData.append('file',$(this).prop("files")[0]);

        $('#hdImg').attr('src', '{{url('ajax-loader.gif')}}');
        $('#hdCam').attr('disabled', 'disabled');

        $.ajax({
            url: '{{url('api/uploadFile')}}',
            type: 'POST',
            processData:false,
            contentType: false,
            data: formData
        })
        .done(function(data) {

            $.get('{{url('addInfoClaimsUser',$call_id)}}'.val(), function(data) {
                console.log('ok');
            });

            let msg = '<a href="#" data-img="'+data[0]+'"><div style="background-size:cover;background-position:center; background-image:url('+data[0]+');width:300px;height:200px"></div></a>';
            $('#hdImg').attr('src', '{{url('hd.png')}}');
            $('#hdCam').removeAttr('disabled');
            $.ajax({
                url: '{{url('api/saveMessage')}}',
                type: 'POST',
                data: {message:msg, call_id: "{{$o_id}}", id: "{{$call_id}}"},
            })
            .done(function() {
                console.log('success');
            })
            .fail(function(e) {
                console.log(e)
            });
            
            imClient.sendMessage(localStorage.getItem('operator_id'),msg);
        })
        .fail(function() {
            $('#hdImg').attr('src', '{{url('hd.png')}}');
            $('#hdCam').removeAttr('disabled');
        })
        .always(function() {
            $('#hdImg').attr('src', '{{url('hd.png')}}');
            $('#hdCam').removeAttr('disabled');
        });
        
    });

    $('#changeCamera').click(function(event) {

        // document.getElementById('mini').getElementsByTagName('video')[0].srcObject.getVideoTracks()[0].stop();

        // let sel = document.querySelector('#videoSource');
        // sel.selectedIndex+=1;
        // if(sel.selectedIndex == -1){
        //   sel.selectedIndex=0;
        // }
        // if (apiRTC.osName === 'iOS') {
            let facingMode = localStorage.getItem('facingMode');
            webRTCClient.setVideoFacingMode(facingMode);
            webRTCClient.updateMediaDeviceOnCall(incomingCallId);
            localStorage.setItem('facingMode',facingMode == 'user' ? 'environment' : 'user');
        // }else{
            // $('#videoSource').change();
        // }
    });

    function answerCall() {
        $("#answerCall").addClass('hidden');
        $("#refuseCall").addClass('hidden');
        $('#icon-camera').addClass('hidden');

        $('#content-postmessages').addClass('hidden');
        $('#content-poll').addClass('hidden');

        webRTCClient.acceptCall(incomingCallId);

        document.getElementById('new-call').pause();
        $('#new-call').attr("src","");
    }

    $('#answerCall').click(answerCall);

    $('#refuseCall').click(function() {
       $("#answerCall").addClass('hidden');
       $("#refuseCall").addClass('hidden');
       webRTCClient.refuseCall(incomingCallId); 

       document.getElementById('new-call').pause();
       $('#new-call').attr("src","");
    });

	function userMediaErrorHandler(e) {
        $("#answerCall").addClass('hidden');
        $("#refuseCall").addClass('hidden');
    }
    function remoteHangupHandler(e) {
        if (e.detail.lastEstablishedCall === true) {
            $("#answerCall").addClass('hidden');
            $("#refuseCall").addClass('hidden');

            document.getElementById('new-call').pause();
            $('#new-call').attr("src","");
        }
    }
    function hangUpHandler(e) {
        $(".takeSnapshot").addClass("hidden");
        $("#changeCamera").addClass("hidden");
        $("#hangupCall").addClass("hidden");
        $('#icon-camera').removeClass('hidden');
        $('#icon-camera').addClass('hidden');
        $('#content-postmessages').removeClass('hidden');
        $('#new-call').remove();

        webRTCClient.removeElementFromDiv('myRemoteVideo', 'remoteElt-' + e.detail.callId);
    }

    function userMediaSuccessHandler(e) {
        console.log("userMediaSuccessHandler e.detail.callId :" + e.detail.callId);
        console.log("userMediaSuccessHandler e.detail.callType :" + e.detail.callType);
        console.log("userMediaSuccessHandler e.detail.remoteId :" + e.detail.remoteId);
        //Adding local Stream in Div. Video is muted
        addStreamInDiv(e.detail.stream, e.detail.callType, "mini", 'miniElt-' + e.detail.callId,
                       {width : "640px", height : "480px"}, true);
        // webRTCClient.addStreamInDiv(e.detail.stream, e.detail.callType, "mini", 'miniElt-' + e.detail.callId,
        //             {width: "1280px", height: "720px"}, true);
    }
    function remoteStreamAddedHandler(e) {
        $(".takeSnapshot").removeClass("hidden");
        $("#changeCamera").removeClass("hidden");
        $("#hangupCall").removeClass("hidden");

        console.log("remoteStreamAddedHandler, e.detail.callId :" + e.detail.callId);
        console.log("remoteStreamAddedHandler, e.detail.callType :" + e.detail.callType);
        console.log("userMediaSuccessHandler e.detail.remoteId :" + e.detail.remoteId);
        //Adding Remote Stream in Div. Video is not muted
        addStreamInDiv(e.detail.stream, e.detail.callType, "myRemoteVideo", 'remoteElt-' + e.detail.callId,
                       {width : "160px", height : "120px"}, false);
        // webRTCClient.addStreamInDiv(e.detail.stream, e.detail.callType, "myRemoteVideo", 'remoteElt-' + e.detail.callId,
        //             {width: "160px", height: "120px"}, false);
    }
    function incomingCallHandler(e) {

        clearTimeout(timeout);

        apiRTC.addEventListener("remoteHangup", remoteHangupHandler);

        localStorage.setItem('operator_id',e.detail.callerId);

        incomingCallId = e.detail.callId;

        // if (!outgoing) {

            $("#answerCall").removeClass('hidden');
            $("#refuseCall").removeClass('hidden');

           $('#new-call').attr("src","{{ url('tone.mp3') }}");
            document.getElementById('new-call').play();
        // }

        // outgoing = false;
    }

    function remoteStreamRemovedHandler(e) {
        console.log('remoteElt remove')
        $('#callId_' + e.detail.callId + '-' + e.detail.remoteId).remove();
    }

    function userMediaStopHandler(e) {
        webRTCClient.removeElementFromDiv('mini', 'miniElt-' + e.detail.callId);
    }

    function receiveIMMessageHandler(e) {
        console.log(e);

        if (e.detail.message == "AUTOANSWER") {
            answerCall();
        }
        if (e.detail.message == "Can you answer the following questionnaire?") {
          $('#icon-camera').addClass('hidden');
          $('#content-postmessages').addClass('hidden');
          $('#content-poll').removeClass('hidden');
        }
        if (e.detail.message == "Please, change the camera [FRONT] [REAR]") {
          $('#changeCamera').trigger('click');
          return false
        }
        if (e.detail.message == "Snapshot Taken CODE 0004") {
          return (new PNotify({
            text: "L'immagine è stata inviata!",
            type: 'success',
            delay: 1000,
            desktop: {
                desktop: false
            }
          })).get().click(function(e) {
          });
          return false
        }
        if (e.detail.message == "ff754c36216281cf74abf11c93906ffcfaa1f484") {
            localStorage.setItem('operator_id',e.detail.senderId);
            navigator.geolocation.getCurrentPosition(showPosition,errPosition,options);
        }
    }

    var timeout;

    function sessionReadyHandler(e) {
        webRTCClient = apiCC.session.createWebRTCClient({
            // localVideo : "myLocalVideo",
            // minilocalVideo : "myMiniVideo",
            // remoteVideo : "myRemoteVideo"
            // status : "status"
        });

        localStorage.removeItem("videoSourceId_" + apiRTC.session.apiCCId);
        
        webRTCClient.setMCUConnector('mcu4.apizee.com');
        webRTCClient.setVideoBandwidth(1000);
        webRTCClient.setAllowMultipleCalls(true);

        webRTCClient.setUserAcceptOnIncomingCallBeforeGetUserMedia(true);

        // var constraint = {};
        // constraint.video = {width: { ideal: 4096 },height: { ideal: 2160 } };
        // constraint.audio = {};

        // webRTCClient.setGetUserMediaConfig(constraint);

        apiRTC.addEventListener("incomingCall", incomingCallHandler);
        apiRTC.addEventListener("userMediaError", userMediaErrorHandler);

        apiRTC.addEventListener("remoteStreamAdded", remoteStreamAddedHandler);
        apiRTC.addEventListener("userMediaSuccess", userMediaSuccessHandler);
        apiRTC.addEventListener("userMediaStop", userMediaStopHandler);
        apiRTC.addEventListener("remoteStreamRemoved", remoteStreamRemovedHandler);
        apiRTC.addEventListener("receiveIMMessage", receiveIMMessageHandler);
        apiRTC.addEventListener("hangup",hangUpHandler);

        // apiRTC.addEventListener("remoteStreamAdded", function(){
        // });

        apiRTC.addEventListener("MCURecordingStarted",function(e){
            console.log('url',e.detail)
            // if (!control) {
            //     control = setInterval(cronometro,1000);
            // }
            startRecording(e.detail.mediaURL);

            // (new PNotify({
            //     title: "Videochiamata",
            //     text: "Il video si sta caricando in background",
            //     type: 'success',
            //     desktop: {
            //         desktop: false
            //     }
            // })).get().click(function(e) {
            //     // if ($('.ui-pnotify-closer, .ui-pnotify-sticker, .ui-pnotify-closer *, .ui-pnotify-sticker *').is(e.target)) return;
            //     // alert('Hey! You clicked the desktop notification!');
            // });

            /**/
        });

        function startRecording(remote_url) {

            recordId = null;

            var formData = new FormData();
            var user_id = localStorage.getItem('to_record');
            if (!user_id) {
                user_id = $('#user_id').val();
            }
            if (!user_id) {
                user_id = localStorage.getItem('to_record');
            }

            formData.append('remote_url', remote_url);
            formData.append('address', "--");
            formData.append('lat', lat);
            formData.append('lon', lng);
            formData.append('user_id', "{{$id}}");

            $.ajax({
                url: '{{ url('api/adminUploadVideo') }}',
                type: 'POST',
                contentType: false,
                processData: false,
                data: formData,
            })
            .done(function(data) {

                console.log("predata record",data)
                recordId = data.id;

                imClient.sendMessage(localStorage.getItem('operator_id'),"recording|"+recordId);

            })
            .fail(function() {
                console.log("error");
            })
            .always(function() {
                console.log("complete");
            });
        }

        apiRTC.addEventListener('connectedUsersListUpdate',(e)=>{
            if (e.detail.usersList) {
                $.each(e.detail.usersList, function(index, val) {
                    if (val == "{{$o_id}}") {
                        if (e.detail.status == 'online') {
                            if (lowspec) {
                                imClient.sendMessage(localStorage.getItem('operator_id'),"La velocità di connessione dell'utente è inferiore a quella richiesta dal nostro server!-"+secs);
                            }
                        }
                    }
                });
            }
        })

        imClient = apiCC.session.createIMClient();
        imClient.nickname = '{{$name}}';

        navigator.getUserMedia = ((navigator).getUserMedia || (navigator).webkitGetUserMedia || (navigator).mozGetUserMedia || (navigator).msGetUserMedia);

        function updateMediaDevices() {
          var returnedPromise;
          returnedPromise = navigator.mediaDevices.enumerateDevices()

          returnedPromise.then((devices)=>{
            return devices.map((d)=> {
              console.log('app device',d.label, d.kind, d.deviceId, d.groupId)
              return JSON.stringify(d);
            });
          });
        }
        updateMediaDevices();

        if (apiRTC.osName === "iOS") {
            navigator.mediaDevices.getUserMedia({
            audio: {echoCancellation:true},
            video: {
              deviceId: 'com.apple.avfoundation.avcapturedevice.built-in_video:1',
              width: {
                min: 320,
                max: 640
              },
              frameRate: {
                min: 30.0,
                max: 60.0
              }
            }
          })
        }

        // if ((apiRTC.browser === 'IE') && (apiRTC.browser_version > 8.0)) {
        //     apiRTC.getMediaDevicesWithCB(gotSources);
        // } else {
        //         apiRTC.getMediaDevices()
        //             .then(function (sources) {
        //                 console.log("getMediaDevices(), sources :", sources);
        //                 gotSources(sources);
        //             })
        //             .catch(function (err) {
        //                 console.log("getMediaDevices(), error :", err);
        //             });
        // }

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
        $.post('{{url('saveWebappUserLocation')}}', {_token: '{{csrf_token()}}',lat:lat,lng:lng,id:'{{$id}}'}, function(data, textStatus, xhr) {
          imClient.sendMessage(localStorage.getItem('operator_id'),"c39d8c95216d7fa04bed5befd831cecbf6291c72");
        });
        // alert('La geolocalizzazione non é attiva. La chiamata inizierà comunque.');
        $('#errorLocation').show();
        console.log(e)
        // return location.reload();
    }

    function showPosition(position) {

      lat=position.coords.latitude;
      lng=position.coords.longitude

      $.post('{{url('saveWebappUserLocation')}}', {_token: '{{csrf_token()}}',lat:position.coords.latitude,lng:position.coords.longitude,id:'{{$id}}'}, function(data, textStatus, xhr) {
          imClient.sendMessage(localStorage.getItem('operator_id'),"c39d8c95216d7fa04bed5befd831cecbf6291c72");
      });

    }

    var hdCam = document.getElementById('hdCam')

    hdCam.onclick = detectEmpty

    function detectEmpty()
    {
        document.body.onfocus = reloadVideo
        console.log('chargin')
    }
        
    function reloadVideo()
    {
        if(hdCam.value.length) {console.log('Files'); webRTCClient.updateMediaDeviceOnCall(incomingCallId);}
        else {console.log('*empty*'); webRTCClient.updateMediaDeviceOnCall(incomingCallId);}
        document.body.onfocus = null
        console.log('depleted')
    }

    $('[name="rate"]').click(function(event) {
        $.each($('[name="rate"]'), function(index, val) {
            $(this).prev().removeClass('selected');
        });
        if ($(this).is(':checked')) {
            $(this).prev().addClass('selected');
            $('#rate-text').text($(this).prev().data('service'));
        }
    });

    $('#sendPoll').submit(function(event) {
        event.preventDefault();
        if (!$(this).serializeArray().find(x => x.name == "rate")) {
            return (new PNotify({
                text: "Devi selezionare una qualifica per la chiamata",
                type: 'warning',
                delay: 2000,
                desktop: {
                    desktop: false
                }
              })).get().click(function(e) {
              });
              return false
        }

        var el = $(this);

        el.find('[type="submit"]').addClass('hidden');
        el.find('#loader').removeClass('hidden');

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serializeArray(),
        })
        .done(function() {
            el.find('[type="submit"]').removeClass('hidden');
            el.find('#loader').addClass('hidden');
            console.log("success");
            $('#content-disclaimer').addClass('hidden');
            $('#content-poll').addClass('hidden');
            // $('#content-videocall').removeClass('hidden');
            $('#content-postquestion').removeClass('hidden');
            return (new PNotify({
                text: "Grazie per la tua opinione",
                type: 'success',
                delay: 3000,
                desktop: {
                    desktop: false
                }
              })).get().click(function(e) {
              });

        })
        .fail(function() {
            el.find('[type="submit"]').removeClass('hidden');
            el.find('#loader').addClass('hidden');
            console.log("error");
        });
        
    });

    $('#modal1').modal()
    $('#explication').modal()

</script>
</body>
</html>