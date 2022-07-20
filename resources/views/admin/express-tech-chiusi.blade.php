@extends('admin.layout')

@section('title','EXPRESS TECH')
@section('content')

@php
    if (Auth::user()->role_id == 2 || (Auth::user()->role_id == 1 && Auth::user()->supervisor == 1)){

        $_claims = App\Claim::where('claims.status','>',0)->where('claim_id',-1)->join('users','claims.user_id','=','users.id')
        ->select('claims.*','users.name','claims.name as asegurado')
        ->where(function($q){
            if (isset($_GET['search'])) {
                $q->where('sin_number','like','%'.$_GET['search'].'%')
                  ->orWhere('society','like','%'.$_GET['search'].'%')
                  ->orWhere('claims.name','like','%'.$_GET['search'].'%')
                  ->orWhere('claims.status','like','%'.$_GET['search'].'%')
                  ->orWhere('claims.created_at','like','%'.$_GET['search'].'%')
                  ->orWhere('reassingned','like','%'.$_GET['search'].'%')
                    ->orWhereExists(function($q){
                        $q->from('users')
                          ->whereRaw('users.id = claims.user_id')
                          ->where('users.name','like', '%'.$_GET['search'].'%');
                    })
                  ;
            }
        })->orderBy(isset($_GET['order']) && $_GET['order'] != "" ? $_GET['order'] : 'id',isset($_GET['type']) && $_GET['type'] != "" ? $_GET['type'] : 'desc')
        // ->where('user_id',Auth::user()->id)
        ->paginate(isset($_GET['count']) ? $_GET['count'] : 10);
    }else{
        $_claims = App\Claim::where('claims.status','>',0)->where('claim_id',-1)->join('users','claims.user_id','=','users.id')
        ->select('claims.*','users.name','claims.name as asegurado')
        ->where(function($q){
            if (isset($_GET['search'])) {
                $q->where('sin_number','like','%'.$_GET['search'].'%')
                  ->orWhere('society','like','%'.$_GET['search'].'%')
                  ->orWhere('claims.name','like','%'.$_GET['search'].'%')
                  ->orWhere('claims.status','like','%'.$_GET['search'].'%')
                  ->orWhere('claims.created_at','like','%'.$_GET['search'].'%')
                  ->orWhere('reassingned','like','%'.$_GET['search'].'%')
                    ->orWhereExists(function($q){
                        $q->from('users')
                          ->whereRaw('users.id = claims.user_id')
                          ->where('users.name','like', '%'.$_GET['search'].'%');
                    })
                  ;
            }
        })->orderBy(isset($_GET['order']) && $_GET['order'] != "" ? $_GET['order'] : 'id',isset($_GET['type']) && $_GET['type'] != "" ? $_GET['type'] : 'desc')
        ->paginate(isset($_GET['count']) ? $_GET['count'] : 10);
    }
@endphp

<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">Sinistri Chiusi</div>
			<div class="panel-body">
                <form action="{{url('admin/express-tech/chiusi')}}" id="filter" method="GET">
                    <div class="row">
                        <div class="col-xs-3" style="padding-right: 0">
                            <label>Ordina per</label>
                            <div class="row">
                                <div class="col-xs-6">
                                    <select name="order" class="form-control">
                                        <option value=""></option>
                                        <option {{@$_GET['order'] == "sin_number" ? "selected" : "" }} value="sin_number">Riferimento Interno</option>
                                        <option {{@$_GET['order'] == "society" ? "selected" : "" }} value="society">Società</option>
                                        <option {{@$_GET['order'] == "users.name" ? "selected" : "" }} value="users.name">Sopralluoghista</option>
                                        <option {{@$_GET['order'] == "name" ? "selected" : "" }} value="name">Nome assicurato</option>
                                        <option {{@$_GET['order'] == "status" ? "selected" : "" }} value="status">Status</option>
                                        <option {{@$_GET['order'] == "created_at" ? "selected" : "" }} value="created_at">Data</option>
                                        <option {{@$_GET['order'] == "reassingned" ? "selected" : "" }} value="reassingned">Data restituzione</option>
                                    </select>
                                </div>
                                <div class="col-xs-6" style="padding-left: 0;">
                                    <select name="type" class="form-control" id="">
                                        <option value=""></option>
                                        <option {{@$_GET['type'] == "asc" ? "selected" : "" }} value="asc">Ascendente</option>
                                        <option {{@$_GET['type'] == "desc" ? "selected" : "" }} value="desc">Discendente</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-3">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>records per page</label>
                                    <select name="count" class="form-control" id="">
                                        <option {{isset($_GET['count']) ? ($_GET['count'] == 10 ? 'selected' : '') : '' }} >10</option>
                                        <option {{isset($_GET['count']) ? ($_GET['count'] == 25 ? 'selected' : '') : '' }} >25</option>
                                        <option {{isset($_GET['count']) ? ($_GET['count'] == 50 ? 'selected' : '') : '' }} >50</option>
                                        <option {{isset($_GET['count']) ? ($_GET['count'] == 100 ? 'selected' : '') : '' }} >100</option>
                                    </select>
                                </div>
                            </div>
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
                <div id="search-results">
    				<table class="display- table table-bordered table-striped table-responsive">
    					<thead>
    						<tr>
    							<th>ID</th>
    							<th>Riferimento Interno</th>
                                <th>Società</th>
                                <th>Sopralluoghista</th>
                                <th>Nome assicurato</th>
                                <th>Partite di danno</th>
                                <th>Status</th>
                                <th>Data</th>
                                <th>Data restituzione</th>
                                <th>Perito</th>
                                <th>Archivos</th>
    							<th></th>
    						</tr>
    					</thead>
    					<tbody>
                            @foreach ($_claims as $s)
                            {{-- @foreach (App\Claim::where('user_id',Auth::user()->id)->get() as $s) --}}
                                <tr>
                                	{{-- <td>{{ $s->id }}</td> --}}
                                    <td>ET{{ str_pad($s->id,5,0,STR_PAD_LEFT) }}</td>
                                    <td>{{ $s->sin_number }}</td>
                                	<td>{{ $s->society }}</td>
                                	<td>{{ App\User::find($s->user_id) ? App\User::find($s->user_id)->fullname() : '' }}</td>
                                	<td>{{ $s->asegurado }}</td>
                                	{{-- <td>
                                		<button type="button" class="btn btn-info btn-xs" data-toggle="modal" data-target="#info-tech-{{ $s->id }}">Informazione</button>
                                		<div class="hidden">
                                			@php
    											$info_text = json_decode($s->information,true);
    											$s->information;
    										@endphp
                                			<div id="text-{{$s->id}}">@include('admin.tech-text')</div>
                                		</div>
                                		<div class="modal fade" id="info-tech-{{ $s->id }}">
                                			<div class="modal-dialog">
                                				<div class="modal-content">
                                					<div class="modal-header">Informazione 
                                						<button class="btn btn-info btn-xs txt" data-id="{{ $s->id }}">Esportare come testo</button>
                                						<button class="btn btn-info btn-xs btn-print" data-id="{{ $s->id }}">Esportare</button></div>
                                					<div class="modal-body" id="print-{{ $s->id }}">
                                						@include('admin.tech-information')
                                					</div>
                                				</div>
                                			</div>
                                		</div>
                                	</td> --}}
                                	<td>
                                        @if ($s->claims->count() > 0)
                                            <button class=" btn btn-xs btn-success" data-target="#sub-{{$s->id}}" data-toggle="modal">{{ $s->claims->count() }}</button>

                                            <div class="modal fade" id="sub-{{$s->id}}">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            Partite di danno {{$s->sin_number}}
                                                        </div>

                                                        <div class="modal-body table-responsive">
                                                            <table class="display table table-bordered table-striped">

                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>Partita di danno</th>
                                                                        <th>Società</th>
                                                                        <th>Informazione</th>
                                                                        <th>Data</th>
                                                                        <th>Riferimento Interno</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    @foreach ($s->claims as $c)
                                                                        <tr>
                                                                            <td>{{ $c->id }}</td>
                                                                            <td>
                                                                                <input type="text" class="editTypology" data-id="{{$c->id}}" value="{{ json_decode($c->information,true)['typology'] }}" size="10">
                                                                            </td>
                                                                            <td>{{ $c->society }}</td>
                                                                            <td>
                                                                                <button type="button" class="btn btn-info btn-xs" data-id="{{$c->id}}" data-target="#info-sub-{{ $c->id }}">Informazione</button>
                                                                                <div class="hidden">
                                                                                    @php
                                                                                        $info_text = json_decode($c->information,true);
                                                                                        $c->information;
                                                                                    @endphp
                                                                                    <div id="text-{{$c->id}}">@include('admin.tech-text')</div>
                                                                                </div>
                                                                            </td>
                                                                            <td>{{ $c->created_at->format('d-m-Y H:i:s') }}</td>
                                                                            <td>{{ $c->sin_number }}</td>
                                                                            <td><a target="_blank" href="{{ url('admin/express-tech/media',$c->sin_number) }}" class="btn btn-xs btn-info">Vedi</a></td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <button class=" btn btn-xs btn-danger" disabled="">{{ $s->claims->count() }}</button>
                                        @endif
                                    </td>
                                	<td>{{ $s->status == 2 ? 'Closed' : 'Open' }}</td>
                                    <td>{{ $s->created_at->format('d-m-Y H:i:s') }}</td>
                                	<td>{{ $s->reassingned ? Carbon\Carbon::parse($s->reassingned)->format('d-m-Y H:i:s') : '' }}</td>
                                	<td>{{ $s->supervisor ? $s->_supervisor->fullname() : '' }}</td>
                                    <td>@foreach (App\MailFile::where('claim_id',$s->id)->get() as $file)
                                        <li><a download href="{{$file->file}}">{{explode('attachments/',$file->file)[1]}}</a></li>
                                    @endforeach</td>
                                	<td><a target="_blank" href="{{ url('admin/express-tech/media',$s->sin_number) }}" class="btn btn-xs btn-info">Vedi</a>
                                        <button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#reasign-{{$s->id}}">Riassegnare</button>
                                		@if (Auth::user()->role_id == -1)
                                		<a href="#delete-sinister-{{$s->id}}" data-toggle="modal" class="btn btn-xs btn-danger">Delete</a>
                                		@endif
                                	</td>
                                </tr>
                            @endforeach
    					</tbody>
    				</table>
                </div>
                @php
                    $_claims->setPath('?order='.@$_GET['order'].'&type='.@$_GET['type'].'&search='.@$_GET['search'] )
                @endphp
                {{$_claims->links()}}
			</div>
		</div>
	</div>
</div>

{{-- @foreach (App\Claim::where('status','<',2)->where('claim_id','!=',-1)->get() as $s)
    <div class="modal fade" id="info-sub-{{ $s->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">Informazione Partita di danno
                    <button class="btn btn-info btn-xs txt" data-sin_number="{{$s->sin_number}}" data-id="{{ $s->id }}">Esportare come testo</button>
                    <button class="btn btn-info btn-xs btn-print" data-id="{{ $s->id }}">Esportare</button>
                </div>
                <div class="modal-body" id="print-{{ $s->id }}">
                    @include('admin.tech-information')
                </div>
            </div>
        </div>
    </div>

@endforeach --}}

@foreach ($_claims as $s)
    <div class="modal fade" id="delete-sinister-{{ $s->id }}">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">Vuoi eliminare il sinistro selezionato? - {{$s->sin_number}}
                </div>
                <div class="modal-footer">
                    <a href="{{ url('api/deleteBack',$s->id) }}" class="btn btn-xs btn-success">Accettare</a>
                    <button type="button" data-dismiss="modal" class="btn btn-xs btn-danger">Annullare</button>
                </div>
            </div>
        </div>
    </div>
	<div class="modal fade" id="reasign-{{ $s->id }}">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">Riassegnare Sinistro</div>
				<div class="modal-body">
					<form action="{{ url('api/checkBackReasign') }}" method="POST" class="reassign-street">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="sin_number" value="{{$s->sin_number}}">
                                <div class="form-group">
                                    <label for="">Nome assicurato</label>
                                    <input type="text" name="name" class="form-control" value="{{$s->asegurado}}">
                                </div>
                                <div class="form-group" style="position: relative;">
                                    <label for="">Sopralluoghista</label>
                                    <select name="id" id="" class="select2example form-control selected-street-operator">
                                      @foreach (App\User::where('role_id',2)->orWhere(['role_id'=>1,'supervisor'=>1])->get() as $op)
                                        <option {{$op->id == $s->user_id ? 'selected' : ''}} value="{{$op->id}}">{{$op->id}} - {{$op->fullname()}}</option>
                                      @endforeach
                                    </select>
                                    {{-- <div class="form-group" style="position: relative;">
                                        <label for="">Sopralluoghista</label>
                                        <input type="text" class="form-control street-operator-reasign">
                                        <input type="hidden" name="id" class="selected-street-operator">

                                        <div class="street-results" style="  position: absolute;
                                                                          border: 1px solid silver;
                                                                          width: 100%;
                                                                          max-height: 200px;
                                                                          z-index: 9999;
                                                                          display: block;
                                                                          background-color: #fff;
                                                                          overflow: auto;
                                                                          display: none;
                                        ">
                                              
                                        </div>
                                    </div> --}}
                                  </div>
                                  
                                <div class="form-group">
                                    <label for="">Società</label>
                                    <select class="form-control" name="society" id="">
                                      <option {{ $s->society == "Renova" ? 'selected' : '' }}>Renova</option>
                                      <option {{ $s->society == "Studio Zappa" ? 'selected' : '' }}>Studio Zappa</option>
                                      <option {{ $s->society == "Gespea" ? 'selected' : '' }}>Gespea</option>
                                    </select>
                                </div>
                                <div class="form-group" style="position: relative;">
                                    <label for="">Perito</label>
                                    <select name="supervisor" class="select2example form-control">
                                      <option value="" selected disabled></option>
                                      @foreach (App\User::where(['supervisor'=>1])->get() as $op)
                                        <option {{$op->id == $s->supervisor ? 'selected' : ''}} value="{{$op->id}}">{{$op->id}} - {{$op->fullname()}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                  <div class="form-group">
                                    <label for="">Email da notificare 1</label>
                                    <input type="text" name="email1" class="form-control" value="{{$s->email1}}">
                                    {{-- <input type="text" name="email2" class="form-control" value="{{$s->email1}}" value="expresstech@studiozappa.com"> --}}
                                  </div>
                            </div>
                            <div class="col-md-6">
                              <h5>Allegati</h5>
                              <input type="file" name="attachments[]" class="form-control">
                              <input type="file" name="attachments[]" class="form-control">
                              <input type="file" name="attachments[]" class="form-control">
                              <input type="file" name="attachments[]" class="form-control">
                              <input type="file" name="attachments[]" class="form-control">
                              <hr style="margin: 11px 0">

                              <div class="form-group" style="position: relative;">
                                <label for="">Tipologia</label>
                                <select name="typology" id="selected-perito" class="select2example form-control">
                                  @foreach (App\Typology::get() as $tp)
                                    <option {{$tp->id == $s->json_information ? 'selected' : ''}} value="{{$tp->id}}">{{$tp->short_name}} - {{$tp->long_name}}</option>
                                  @endforeach
                                </select>
                              </div>

                              <div class="form-group" style="position: relative;">
                                <label for="">Email da notificare 2</label>
                                <input type="text" name="email1" class="form-control">
                              </div>
                            </div>

                            <div class="col-md-12">
                              <div class="form-group">
                                <label>Email predefiniti</label>
                                <select class="form-control predefined-edit" data-id="#_predefined-{{$s->id}}">
                                  <option value="" selected disabled></option>
                                  @foreach (App\PredefinedMail::where('status',1)->get() as $mm)
                                    <option value="{{$mm->predefined}}">{{$mm->title}}</option>
                                  @endforeach
                                </select>
                              </div>

                              <div class="form-group">
                                <textarea id="_predefined-{{$s->id}}" class="form-control" rows="4">{{$s->mail_text}}</textarea>
                              </div>
                            </div>
                        </div>
                        
                        <button class="btn btn-success">SALVA</button>
                    </form>
				</div>
			</div>
		</div>
	</div>

    @foreach ($s->claims as $c)
        <div class="modal fade" id="info-sub-{{ $c->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">Informazione Partita di danno
                        <button class="btn btn-info btn-xs txt" data-sin_number="{{ $c->sin_number }}" data-id="{{ $c->id }}">Esportare come testo</button>
                        <button class="btn btn-info btn-xs btn-print" data-id="{{ $c->id }}">Esportare</button>
                    </div>
                    <div class="modal-body" id="print-{{ $c->id }}">
                        @include('admin.tech-information')
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endforeach

@section('scripts')
	<script>

		var actual;

        $('[data-target*="#info-sub-"]').click(function(event) {
            actual = $('.modal.fade.in').attr('id');
            $('.modal#info-sub-'+($(this).data('id'))).modal("show");
            $('.modal.fade.in').modal('hide');
        });

        $('[id*="info-sub"]').on('hidden.bs.modal', function(event) {
            if (actual) {
                $('#'+actual).modal('show');
            }
            actual = null;
        });

		$('.btn-print').click(function(event) {
			var id = $(this).data('id');
	        $("#print-"+id).printArea();
	    });

        $('[name="count"]').on('change', function(event) {
            console.log('hola');
            $('#filter').submit();
        })

	    $('.txt').click(function(event) {
			var id = $(this).data('id');
			var elem = $("#text-"+id+' span');

			var text = "";

			$.each(elem, function(index, val) {
				text+=$(this).text().trim()+"|";
			});

			var a = document.createElement("a");

			var blob = new Blob([text.trim()], {type: "text/plain;charset=utf-8"});
			var link = window.URL.createObjectURL(blob);

			a.href = link;
	        a.download = ($(this).data('sin_number'))+".txt";
	        a.click();
	        URL.revokeObjectURL(link);

	    });
	</script>
@endsection
@stop