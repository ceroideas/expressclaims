@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<style>
	.modal {
        overflow: auto;
    }
</style>

<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">Sinistri in gestione</div>
			<div class="panel-body">
				@isset ($all)
				<form action="{{url('admin/all-sinister')}}" method="GET">
				@else
				<form action="{{url('admin/sinister')}}" method="GET">
				@endisset
                    <div class="row">
                        <div class="col-xs-3" style="padding-right: 0">
                            <!-- <label>Ordina per</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <select name="order" class="form-control">
                                        <option value=""></option>
                                        <option {{@$_GET['order'] == "sin_number" ? "selected" : "" }} value="sin_number">Riferimento Interno</option>
                                        {{-- <option {{@$_GET['order'] == "society" ? "selected" : "" }} value="society">Società</option> --}}
                                        <option {{@$_GET['order'] == "users.name" ? "selected" : "" }} value="users.name">Operatore di strada</option>
                                        <option {{@$_GET['order'] == "name" ? "selected" : "" }} value="name">Nome assicurato</option>
                                        {{-- <option {{@$_GET['order'] == "status" ? "selected" : "" }} value="status">Status</option> --}}
                                        <option {{@$_GET['order'] == "created_at" ? "selected" : "" }} value="created_at">Data</option>
                                        {{-- <option {{@$_GET['order'] == "reassingned" ? "selected" : "" }} value="reassingned">Data restituzione</option> --}}
                                        {{-- <option {{@$_GET['order'] == "supervisor" ? "selected" : "" }} value="supervisor">Supervisor</option> --}}
                                    </select>
                                </div>
                                <div class="col-xs-6" style="padding-left: 0;">
                                    <select name="type" class="form-control" id="">
                                        <option value=""></option>
                                        <option {{@$_GET['type'] == "asc" ? "selected" : "" }} value="asc">Ascendente</option>
                                        <option {{@$_GET['type'] == "desc" ? "selected" : "" }} value="desc">Discendente</option>
                                    </select>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-xs-3">
                        </div>
                        <div class="col-xs-3">
                        </div>
                        <div class="col-xs-3">
                            <label for="">Filtro</label>
                            <div class="row">
                                <div class="col-xs-9" style="padding-right: 0">
                                    <input type="text" placeholder="Cerca" name="search" class="form-control" value="{{@$_GET['search']}}">
                                </div>
                                <div class="col-xs-3">
                                    <button class="btn btn-info btn-block">Go</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
				<table id="orderByDate_" class="table table-bordered table-striped table-responsive">
					<thead>
						<tr>
							<th style="display: none;"></th>
							<th>ID</th>
							<th>Riferimento Interno</th>
							<th>Call Id</th>
							<th>Nome</th>
							@if (Auth::user()->role_id == -1 || isset($all))
							<th>Operatore</th>
							@endif
							<th>Telefono</th>
							<th>Informazione</th>
							<th>Media</th>
							<th>Status</th>
							<th>Data di creazione</th>
							<th>Data di riapertura</th>
							{{-- <th>Assegna operatore di strada</th> --}}
							<th></th>
						</tr>
					</thead>
					<tbody>
						@php
	                    	if (!isset($all)) {
	                    		$all = NULL;

	                    		if (Auth::user()->role_id == -1){
	                    			$all = true;
	                    		}
	                    	}
	                    @endphp

						@php
							$claims = App\User::where(function($q) use($all){
					            $q->whereExists(function($q) use($all){
					            	if (Auth::user()->role_id == -1 || $all) {
						                $q->from('customers')
						                ->whereNotNull('customers.operator_id')
						                ->whereRaw('customers.user_id = users.id');
					            	}else{
						                $q->from('customers')
						                ->whereNotNull('customers.operator_id')
						                ->whereRaw('customers.user_id = users.id')
						                ->whereRaw('customers.operator_id = '.Auth::user()->id);
					            	}
					            	$q->whereExists(function($q){
					            		$q->from('reservations')
						                ->whereRaw('reservations.customer_id = users.id')
						                ->whereRaw('reservations.status = 0')->where(function($q){
						                	if (isset($_GET['search']) && $_GET['search'] != "") {
								                $q->where('reservations.sin_number','like','%'.$_GET['search'].'%');
								                $q->orWhere('users.name','like','%'.$_GET['search'].'%');
								                $q->orWhere('customers.phone','like','%'.$_GET['search'].'%');
								            }
						                });
					            	});
					            });
					        })->orWhere(function($q) use($all){
					            $q->whereExists(function($q){
					                $q->from('web_app_users')
					                ->whereRaw('web_app_users.status = 1')
					                ->whereRaw('web_app_users.user_id = users.id')

					                ->whereExists(function($q){
				                		$q->from('reservations')
						                ->whereRaw('reservations.customer_id = users.id')
						                ->whereRaw('reservations.status = 0')->where(function($q){

							                if (isset($_GET['search']) && $_GET['search'] != "") {
								                $q->where('reservations.sin_number','like','%'.$_GET['search'].'%');
								                $q->orWhere('users.name','like','%'.$_GET['search'].'%');
								                $q->orWhere('web_app_users.fullphone','like','%'.$_GET['search'].'%');
								            }
						                });
				                	});
					            })->where(function($q) use($all){
					                if (!$all) {
					                    $q->where('operator_call_id',Auth::user()->id);
					                }
					            });
					        })->orderBy('created_at','desc')->paginate(10);
						@endphp

	                    @foreach ($claims as $u)
                        	@if ($u->webapp)
                        		@include('admin.webappon')
                        	@else
                        		@include('admin.sinisteron')
                        	@endif
                        @endforeach
					</tbody>
				</table>
				@php
                    $claims->setPath('?search='.@$_GET['search'] )
                @endphp
                {{$claims->links()}}
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
			{{-- <div class="modal-footer"></div> --}}
		</div>
	</div>
</div>
@section('scripts')
	<script>
		$('.assign-street').change(function(event) {
			var id = $(this).val();
			$.post($(this).data('url'), {sin_number: $(this).data('sinister'), id: id}, function(data, textStatus, xhr) {
				imClient.sendMessage(id,'RECARGAR_LISTA_DE_SINIESTROS')
				alert('Sinister assigned to street operator!');
			});
		});
		$('[href="#open-information"]').click(function(event) {
			$('#info-name').html('<b>Nome: </b>'+$(this).data('username'));
	        $('#info-phone').html('<b>Telefono: </b>'+$(this).data('phone'));
	        $('#info-sinister').html('<b>Riferimento Interno: </b>'+$(this).data('sin_number'));
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

		$('.share-btn').click(function(event) {
            var email = $(this).parent().prev().find('input').val(),
            url = '{{ url('utente') }}/'+$(this).data('id')+'/'+$(this).data('op')+'/'+$(this).data('res')+'/'+$(this).data('sha1');

            if (email == "") {
                return alert('Scrivi una mail per condividere')
            }
            $.post('{{ url('admin/share') }}', {url: url, email: email, name: $(this).data('name'), _token: '{{ csrf_token() }}'}, function(data, textStatus, xhr) {
                $('[id*="share-').modal('hide')
                (new PNotify({
                    title: 'Condivisione',
                    text: "Il collegamento con l'utente è stato condiviso",
                    type: 'success',
                    desktop: {
                        desktop: false
                    }
                })).get().click(function(e) {
                    // if ($('.ui-pnotify-closer, .ui-pnotify-sticker, .ui-pnotify-closer *, .ui-pnotify-sticker *').is(e.target)) return;
                    // alert('Hey! You clicked the desktop notification!');
                });
            });
        });
	</script>
	<script>
	    $('#btn-print').click(function(event) {
	        $(".printArea").printArea();
	    });
	</script>
@endsection
@stop