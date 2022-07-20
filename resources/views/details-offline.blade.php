@extends('layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<style>
    .well {
        min-height: 20px;
        padding: 8px;
        margin-bottom: 2px;
        background-color: #f5f5f5;
        border: 1px solid #e3e3e3;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
        box-shadow: inset 0 1px 1px rgba(0,0,0,.05);
        color: #fff;
    }
    .date-me {
        font-size: 10px;
        margin-bottom: 6px;
        text-align: right;
    }
    .date-notme {
        font-size: 10px;
        margin-bottom: 6px;
    }
    .notme {
        float: left;
        margin-right: 16px;
        position: relative;
        border-radius: 0 4px 4px 4px;
        background-color: #f5a623;
    }
    .notme:after {
        content: " ";
        width: 0;
        height: 0;
        border-right: 8px solid #f5a623;
        border-top: 5px solid transparent;
        border-bottom: 5px solid transparent;
        position: absolute;
        left: -8px;
        top: 36%;
    }
    .me {
        float: right !important;
        margin-left: 16px;
        margin-right: 0;
        border-radius: 4px 0 4px 4px;
        background-color: #4990e2;
    }
    .me:after {
        content: " ";
        width: 0;
        height: 0;
        border-left: 8px solid #4990e2;
        border-top: 5px solid transparent;
        border-bottom: 5px solid transparent;
        position: absolute;
        right: -7px;
        top: 30%;
    }
    .contenedor {
        position: relative;
    }
    .contenedor:after {
        content: "";
        display: block;
        clear: both;
    }
    #send_my_message {
        color: #f5a623;
        background-color: transparent;
        border: none !important;
    }
    .btn-paperclip {
        color: #ccc;
        background-color: transparent;
        border: none !important;
    }
    #my_message {
        border: none;
        background-color: transparent;
    }
    #chat-input {
        border: 2px solid #aaa;
    }
    /* The switch - the box around the slider */
    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    .green {
        color: lightgreen;
    }
    #main-content {
    	margin: 0;
    }
    .rotate-inner {
        overflow: hidden;
    }
    .rotate-inner > a > div {
        transform: rotate(90deg);
        height: 300px !important;
        width: 300px !important;
    }
</style>

<input type="hidden" id="nameToUse" value="{{ $u->name }}">
<div class="row">

    <div class="col-sm-6">
    	<div class="row">
    		<div class="col-xs-12 col-sm-12">
		        <h3>{{ $u->name }}</h3>
		        <h5>Numero di Telefono: <b>{{ $u->customer ? '+'.$u->customer->phone : $u->webapp->code.$u->webapp->phone }}</b></h5>
		        <h5>Ultima data di Contatto: <b>{{ $res->updated_at->format('d-m-Y H:i:s') }}</b></h5>

                <h5>
                <div class="form-group">
                    <label for="">Riferimento interno: </label>
                    @if ($res)
                    {{ $res->sin_number }}
                    @endif
                </div>
                </h5>
                @if ($u->customer)
                <h5 class="">
                    <label for="">Informazioni:</label>
                    <a href="#modal-view-info"><i class="fa fa-eye"></i></a>
                </h5>
                @endif

            <style>
                /*#modal-edit-info {
                  position: relative;
                }*/

                /*#modal-edit-info .modal-dialog {
                  position: fixed;
                  margin: 0;
                  padding: 10px;
                }*/
                #modal-view-info .modal-dialog .modal-content {
                    box-shadow: 0px 0px 5px silver;
                }
            </style>

            @if ($u->customer)

                <div class="modal fade" id="modal-view-info">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">Vedere le informazioni <button class="btn btn-xs btn-info" id="btn-print-info">Export</button></div>
                            <div class="modal-body printAreaInfo">
                                <img src="{{ url('renova.png') }}" alt="" width="100px">
                                @php
                                    $info = App\Detail::where('user_id',$u->id)->first();
                                @endphp
                                <h5><b>Nome: </b>{{$u->name}}</h5>
                                <h5><b>Telefono: </b>{{$u->customer->phone}}</h5>
                                <hr>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b for="">Riferimento Interno:</b> <br>
                                            - {{ $res ? $res->sin_number : '' }}
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b for="">Compagnia:</b> <br>
                                            - {{ $info ? $info->company : '' }}
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b for="">Numero di polizza:</b> <br>
                                            - {{ $info ? $info->policy : '' }}
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b for="">Modello di polizza:</b> <br>
                                            - {{ $info ? $info->policy_model : '' }}
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b for="">Tipologia di danno:</b> <br>
                                            - {{ $info ? $info->damage : '' }}
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b for="">Tipologia di assicurazione:</b> <br>
                                            - {{ $info ? $info->insurance : '' }}
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b for="">Franchigia / Scoperto:</b> <br>
                                            - {{ $info ? $info->franchise : '' }}
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b for="">Limite di indennizzo:</b> <br>
                                            - {{ $info ? $info->limit : '' }}
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b for="">Quantificazione di danno proposta:</b> <br>
                                            - {{ $info ? $info->quantification1 : '' }}
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <b for="">Quantificazione di danno definita:</b> <br>
                                            - {{ $info ? $info->quantification2 : '' }}
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <b for="">Note:</b> <br>
                                            {{ $info ? $info->notes : '' }}
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-danger" data-dismiss="modal">CHIUDERE DETTAGLIO</button>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
		    </div>
			<div class="col-md-12 ">
		        <div class="row">
		            <div class="col-xs-12">
		                <span class="hide" id="myCallId"></span>
		                <input type="hidden" id="number" value="{{  $u->customer ? $u->customer->call_id : $u->id }}">
		                <input type="hidden" id="user_id" value="{{ $u->id}}">
		                <div class="panel">
		                    <div class="panel-heading">Chiamate Registrate</div>
		                    <div class="panel-body" id="panel1" style="position: relative;">
		                        <div class="row" style="position: relative;">
		                            <div class="col-xs-12 clients table-responsive" style="height: 100%; position: relative;">

		                                <table class="table display table-hover table-condensed">
		                                    <thead>
		                                        <tr>
		                                            <th>ID</th>
		                                            <th>Clienti</th>
		                                            <th>Indirizzo</th>
		                                            <th>Data</th>
		                                            <th>Durata</th>
		                                            <th></th>
		                                        </tr>
		                                    </thead>
		                                    <tbody>
		                                        @foreach (App\Record::where(['user_id'=>$u->id,'reservation_id'=>$res->id])->get() as $v)
		                                            <tr>
		                                                <td>{{ $v->id }}</td>
		                                                <td>{{ $v->user->name }}</td>
		                                                <td>{{ $v->address }}</td>
		                                                <td>{{ $v->created_at->format('d-m-Y H:i:s') }}</td>
		                                                <td>{{ $v->duration }}</td>
		                                                <td>
		                                                    <a target="_blank" href="{{ url('uploads/videos',$v->name) }}" class="btn btn-info btn-xs">View</a>
		                                                    <a target='_blank' download href="{{ url('uploads/videos',$v->name) }}" class="btn btn-info btn-xs">Download</a>
		                                                </td>
		                                            </tr>
		                                        @endforeach
		                                    </tbody>
		                                </table>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="col-xs-12 table-responsive" style="height: 100%; position: relative; overflow: auto">
                        <div class="panel">
                            <div class="panel-body">
                                
        		                <table class="table table-bordered table-condensed table-striped">
        		                    <thead>
        		                        <tr>
        		                            <th>Information</th>
        		                            <th>Media</th>
        		                            <th>Status</th>
        		                            <th>Data</th>
        		                            <th width="20%">Numero sinistro</th>
        		                        </tr>
        		                    </thead>
        		                    <tbody>
        		                        <tr>
        		                            <td>
        		                                @if ($res->message != trim(""))
        		                                    @php
        		                                        $info = json_decode($res->message,true);
        		                                    @endphp
        		                                    <a href="#open-information" data-toggle="modal" class="btn btn-info btn-xs"
        		                                        data-username="{{$res->user->name}}";
        		                                        data-phone="{{$res->user->customer->phone}}";
        		                                        data-sin_number="{{$res->sin_number}}";
        		                                        data-lastname="{{$info['lastname']}}";
        		                                        data-name="{{$info['name']}}";
        		                                        data-bdate="{{$info['bdate']}}";
        		                                        data-sdata="{{$info['sdata']}}";
        		                                        data-quality="{{$info['quality']}}";
        		                                        data-typology="{{$info['typology']}}";
        		                                        data-goods="{{$info['goods']}}";
        		                                        data-unity="{{$info['unity']}}";
        		                                        data-cond="{{$info['cond']}}";
        		                                        data-cdenomination="{{$info['cdenomination']}}";
        		                                        data-cphone="{{$info['cphone']}}";
        		                                        data-cemail="{{$info['cemail']}}";
        		                                        data-surface="{{$info['surface']}}";
        		                                        data-title="{{$info['title']}}";
        		                                        data-damage="{{$info['damage']}}";
        		                                        data-residue="{{$info['residue']}}";
        		                                        data-other="{{$info['other']}}";
        		                                        data-third="{{$info['third']}}";
        		                                        data-thirddamage="{{$info['thirddamage']}}";
        		                                        data-import="{{$info['import']}}";
        		                                        data-iban="{{$info['iban']}}";
        		                                    >Info sinistro</a>
        		                                @endif
        		                            </td>
        		                            <td>
        		                                <a href="{{ url('videos/'.sha1($res->id.$u->email),$res->id) }}" target="_blank" class="btn btn-info btn-xs">Video</a>
        		                                <a href="{{ url('images/'.sha1($res->id.$u->email),$res->id) }}" target="_blank" class="btn btn-info btn-xs">Images</a>
        		                            </td>
        		                            <td>{{ $res->status == 1 ? 'Closed' : 'Open' }}</td>
        		                            <td>{{ $res->created_at->format('d-m-Y H:i:s') }}</td>
        		                            <td>
        		                                @if ($res->sin_number)
        		                                    {{ $res->sin_number }}		                                    
        		                                @endif
        		                            </td>
        		                        </tr>
        		                    </tbody>
        		                </table>
                            </div>
                        </div>
		            </div>

		        </div>
			</div>
	    </div>
    </div>

    <div class="col-sm-6">
    	<div class="row">
		    <div class="col-xs-12 col-md-12">
		        <div class="row">
		            <div class="col-md-12 div_messages">
		                <div class="panel">
		                    <div class="panel-heading">Immagini</div>
		                    <div class="panel-body call-panel" id="panel-imagenes" style="position: relative; height: 170px;">
		                        <div id='img-carousel'>
		                        
		                        </div>
		                    </div>
		                    <div class="panel-heading">Chat</div>
		                    <div class="panel-body call-panel" id="panel4" style="position: relative; height: calc(42vh - 60px);">
		                        <div class="row" style="position: relative; height: 100%;">
		                            <div class="col-xs-12 messages" style="height: 100%; position: relative; overflow: auto">
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
    </div>
</div>
<div class="modal fade" id="open-information">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">Information <button class="btn btn-info btn-xs" id="btn-print">Export</button></div>
            <div class="modal-body printArea">
                <h5 id="info-name"></h5>
                <h5 id="info-phone"></h5>
                <h5 id="info-sinister"></h5>
                <hr>
                <li><b>1 - Per cortesia, la invitiamo ad identificarsi: </b>
                    <ul id="info-1"></ul></li>
                <li><b>2 - Data di accadimento del sinistro: </b>
                    <ul id="info-2"></ul></li>
                <li><b>3 - Lei interviene nella definizione de sinistro in qualità di: </b>
                    <ul id="info-3"></ul></li>
                <li><b>4 - Che tipologia di danno ha subito ? </b>
                    <ul id="info-4"></ul></li>
                <li><b>5 - Quali beni hanno subito danni ? </b>
                    <ul id="info-5"></ul></li>
                <li><b>6 - L'unita immobiliare assicurata è: </b>
                    <ul id="info-6"></ul></li>
                <li><b>7 - Qualora l'unità immobiliare assicurata faccia parte di un condominio, a che piano è ubicata ? (se non è in condominio scriva semplicemente NO) </b>
                    <ul id="info-7"></ul></li>
                <li><b>8 - Qualora l'unità immobiliare assicurata faccia parte di un condominio, ci indichi i riferimenti dell'amministratore condominiale (se non è in condominio scriva semplicemente NO alle tre successive domande) </b>
                    <ul id="info-8"></ul></li>
                <li><b>9 - Qual è la superficie complessiva dell'unità immobiliare assicurata? (dati in mq. senza considerare balconi, terrazze e gairdini) </b>
                    <ul id="info-9"></ul></li>
                <li><b>10 - In forza di quale titolo conduce l'appartamento ? </b>
                    <ul id="info-10"></ul></li>
                <li><b>11 - I riprisinti del danno sono già stati effettuati ? </b>
                    <ul id="info-11"></ul></li>
                <li><b>12 - I residui del sinistro sono visibili ? </b>
                    <ul id="info-12"></ul></li>
                <li><b>13 - Lei ha contratto altre assicurazioni a copertura del medesimo rischio colpito dal presente sinistro ? qualora ne disponga la invitiamo ad inviare foto / pdf del frontespizio di polizza tramite la successiva schermata </b>
                    <ul id="info-13"></ul></li>
                <li><b>14 - E' a conoscenza se vi sono altre polizza assicurative contratte da terzi a copertura del presente rischio (ad esempio polizza del condominio o della proprietà) ? </b>
                    <ul id="info-14"></ul></li>
                <li><b>15 - E' a conoscenza se vi sono terzi danneggiati in conseguenza al sinistro in oggetto ? </b>
                    <ul id="info-15"></ul></li>
                <li><b>16 - Ammontare approssimativo del danno subito </b>
                    <ul id="info-16"></ul></li>
                <li><b>17 - Per favore ci fornisca di seguito il suo IBAN: si precisa che tale richiesta avanzata in sede di istruttoria della posizione non implica che il suo sinistro sia indennizzabile </b>
                    <ul id="info-17"></ul></li>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
	function urlify(text) {
        if (text.indexOf('<a href="#" data-url') != -1) {
            return text.replace('href="#" data-url','target="_blank" href');
        }
        if (text.indexOf('<a href="#" data-img') != -1) {
            return text.replace('href="#" data-img','target="_blank" href');
        }
        var urlRegex = /(https?:\/\/[^\s]+)/g;
        return text.replace(urlRegex, function(url) {
            return '<a href="' + url + '" target="_blank">' + url + '</a>';
        })
    }
    $('[href="#open-information"]').click(function(event) {
        $('#info-name').html('<b>Nome: </b>'+$(this).data('username'));
        $('#info-phone').html('<b>Telefono: </b>'+$(this).data('phone'));
        $('#info-sinister').html('<b>Numero sinistro: </b>'+$(this).data('sin_number'));

        $('#info-1').html(
            "<li> <b>- Cognome: </b>"+$(this).data('lastname')+"</li>\
            <li> <b>- Nome: </b>"+$(this).data('name')+"</li>\
            <li> <b>- Data di nascita: </b>"+$(this).data('bdate')+"</li>"
        );

        $('#info-2').html(
            "<li>"+$(this).data('sdata')+"</li>"
        );

        $('#info-3').html(
            "<li>"+$(this).data('quality')+"</li>"
        );
        var resp;
        if ($(this).data('typology') == 1) {resp = "Danno d'acqua condotta";}
        if ($(this).data('typology') == 2) {resp = "Fenomeno elettrico";}
        if ($(this).data('typology') == 3) {resp = "Evento atmosferico";}
        if ($(this).data('typology') == 4) {resp = "Guasti ladri";}
        if ($(this).data('typology') == 5) {resp = "Atti vandalici";}
        if ($(this).data('typology') == 6) {resp = "Incendio";}
        if ($(this).data('typology') == 7) {resp = "Furto";}
        if ($(this).data('typology') == 8) {resp = "Altro";}

        $('#info-4').html(
            "<li>"+resp+"</li>"
        );

        $('#info-5').html(
            "<li>"+$(this).data('goods')+"</li>"
        );

        $('#info-6').html(
            "<li>"+$(this).data('unity')+"</li>"
        );

        $('#info-7').html(
            "<li>"+$(this).data('cond')+"</li>"
        );

        $('#info-8').html(
            "<li> <b>- Denominazione: </b>"+$(this).data('cdenomination')+"</li>\
            <li> <b>- Telefono: </b>"+$(this).data('cphone')+"</li>\
            <li> <b>- E-mail: </b>"+$(this).data('cemail')+"</li>"
        );

        $('#info-9').html(
            "<li>"+$(this).data('surface')+"</li>"
        );

        $('#info-10').html(
            "<li>"+$(this).data('title')+"</li>"
        );

        $('#info-11').html(
            "<li>"+$(this).data('damage')+"</li>"
        );

        $('#info-12').html(
            "<li>"+$(this).data('residue')+"</li>"
        );

        $('#info-13').html(
            "<li>"+$(this).data('other')+"</li>"
        );

        $('#info-14').html(
            "<li>"+$(this).data('third')+"</li>"
        );

        $('#info-15').html(
            "<li>"+$(this).data('thirddamage')+"</li>"
        );

        $('#info-16').html(
            "<li>"+$(this).data('import')+"</li>"
        );

        $('#info-17').html(
            "<li>"+$(this).data('iban')+"</li>"
        );
    });
    $('#img-carousel').owlCarousel({
        items: 5,
        itemsDesktop: [1199,4],
        itemsDesktopSmall: [979,3],
        itemsTablet: [768,3],
        pagination: true
    });

    $('div.div_messages').block({ message: 'Loading Messages from {{ $u->name }}... Please wait...' });

    $.post('{{ url('admin/loadMessages') }}', { to_id: {{ $u->id }}, from_id: {{ $o->id }}, _token: '{{ csrf_token() }}', res: {{ $res->id }} }, function(data, textStatus, xhr) {
        // var html = "";
        // $.each(data[0], function(index, val) {
        //     if (val.from.name == '{{ $u->name }}') {
        //         html += '<div class="contenedor"><div class="well me"><span class="label label-success">'+val.from.name+':</span> '+urlify(val.message)+' </div></div><div class="date-me">'+val.created+'</div>';
        //     }else{
        //         html += '<div class="contenedor"><div class="well notme"><span class="label label-danger">'+val.from.name+':</span> '+urlify(val.message)+' </div></div><div class="date-notme">'+val.created+'</div>';
        //     }
        // });

        // $('.messages').html(html);
        // $(".messages").scrollTop(document.getElementsByClassName('messages')[0].scrollHeight);

        // var imagenes = "<div id='img-carousel'>";
        // $.each(data[1], function(index, val) {
        //     imagenes += "<div style='padding: 0 6px;'>\
        //             <div style='position:relative;'>\
        //                 <a href='"+val.imagen+"' download class='btn btn-info btn-xs'><i class='fa fa-download'></i> SALVA</a>\
        //             </div>\
        //             <div style='background-image: url("+val.imagen+"); background-size: cover; background-position: center; height: 80px;'>\
        //             </div>\
        //         </div>";
        // });
        // imagenes += "</div>";

        // $('#panel-imagenes').html(imagenes);

        // $('#img-carousel').owlCarousel({
        //     items: 5,
        //     itemsDesktop: [1199,4],
        //     itemsDesktopSmall: [979,3],
        //     itemsTablet: [768,3],
        //     pagination: true
        // });
        // if (data[2] == 1) {
        //     $('#can_call').val('1');
        // }else{
        //     $('#can_call').val('1');
        // }
        // $('div.div_messages').unblock();

        var imagenes = "<div id='img-carousel'>";
            $.each(data[1], function(index, val) {

                imagenes += "<div style='padding: 0 6px; border-radius: 3px'>\
                        <div style='position:relative;'><button style='position:absolute; right: -5px; top: 15px;' class='btn badge label-danger delete-this' data-id='"+val.id+"'><i class='fa fa-times'></i></button>\
                            <a href='"+val.imagen+"' download class='btn btn-info btn-xs'><i class='fa fa-download'></i> SALVA</a>   \
                        </div>\
                        <div style='background-image: url("+val.imagen_+"); background-size: cover; background-position: center; height: 100px;'>\
                            <img class='image-to-check' src="+val.imagen+" style='width:100%;transform: translateX(-50%) translateY(-50%);position: relative;top: 50% !important;left: 50% !important;z-index: -2;'>\
                        </div>\
                    </div>";

            });
            imagenes += "</div>";

            $('#panel-imagenes').html(imagenes);

            $('#img-carousel').owlCarousel({
                items: 5,
                itemsDesktop: [1199,4],
                itemsDesktopSmall: [979,3],
                itemsTablet: [768,3],
                pagination: true
            });
            $('.delete-this').click(deleteThis);
            if (data[2] == 1) {
                $('#can_call').val('1');
            }else{
                $('#can_call').val('1');
            }

            var to_fix = [];

            $.each($('.image-to-check'), function(index, val) {

                let img = $(this);
                let h = val.parentElement.offsetWidth;
                console.log(img,h);

                val.addEventListener('load',function (e) {
                
                    var canvas = document.createElement("canvas");
                    context = canvas.getContext('2d');


                    base_image = new Image();
                    base_image.src = img.attr('src');

                    if ((base_image.naturalWidth || base_image.width) > (base_image.naturalHeight || base_image.height)) {
                        to_fix.push(img.attr('src'));
                        img.css({'transform':'translateX(-50%) translateY(-50%) rotate(90deg)','height':h+'px'});
                    }
                });
            });

            /**/

            setTimeout(()=>{
                var html = "";
                $.each(data[0], function(index, val) {

                    let coincide = 0;

                    for (var i = 0; i < to_fix.length; i++) {

                        if (val.message.indexOf(to_fix[i]) != -1) {
                            coincide = 1;
                        }
                    }

                    if (val.from.name == '{{ $u->name }}') {
                        html += '<div class="contenedor"><div class="well me"><span class="label label-success">Io:</span> <div '+(coincide == 1 ? 'class="rotate-inner"' : '')+'>'+urlify(val.message)+'</div> </div></div><div class="date-me">'+val.created+'</div>';
                    }else{
                        html += '<div class="contenedor"><div class="well notme"><span class="label label-danger">'+val.from.name+':</span> <div '+(coincide == 1 ? 'class="rotate-inner"' : '')+'>'+urlify(val.message)+'</div> </div></div><div class="date-notme">'+val.created+'</div>';
                    }
                });

                $('.messages').html(html);
                $(".messages").scrollTop(document.getElementsByClassName('messages')[0].scrollHeight);

                $('div.div_messages').unblock();
            },100)
    });


$('[href="#modal-view-info"]').click(function() {
    $('body').css('overflow', 'auto');
  // reset modal if it isn't visible
  if (!($('.modal.in').length)) {
    $('.modal-dialog').css({
      top: 0,
      left: 0
    });
  }
  $('#modal-view-info').modal({
    backdrop: false,
    show: true
  });

  $('#modal-view-info .modal-dialog').draggable({
    handle: ".modal-header"
  });
});
</script>
@endsection

@stop