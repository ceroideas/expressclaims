@extends('admin.layout')

@section('content')

<div class="row">
	<div class="col-sm-3">
		<form action="{{ isset($e_c) ? url('admin/accertatore',$e_c->id) : url('admin/accertatore') }}" method="post" class="panel send-form">
			{{ csrf_field() }}
			@if(isset($e_c))
	            <div class="panel-heading">Modifica Accertatore</div>
	            <input type="hidden" name="id" value="{{ $e_c->id }}">
				{{ method_field('PUT') }}
            @else
            	<div class="panel-heading">Nuovo Accertatore</div>
            @endif
			<div class="panel-body">
				<div class="form-group">
					<label>Email</label>
					<input type="text" name="email" value="{{ isset($e_c) ? $e_c->email : '' }}" class="form-control">
				</div>
                <div class="form-group">
                    <label>Email google calendar</label>
                    <input type="text" name="google_calendar_email" value="{{ isset($e_c) ? $e_c->google_calendar_email : '' }}" class="form-control">
                </div>
				<div class="form-group">
					<label>Nome</label>
					<input type="text" name="name" value="{{ isset($e_c) ? $e_c->name() : '' }}" class="form-control">
				</div>

                <div class="form-group">
                    <label>Cognome</label>
                    <input type="text" name="lastname" value="{{ isset($e_c) ? $e_c->lastname() : '' }}" class="form-control">
                </div>

                <div class="form-group">
                    <label>Telefono</label>
                    <input type="text" name="street_phone" value="{{ isset($e_c) ? $e_c->street_phone : '' }}" class="form-control">
                </div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" name="password" class="form-control">
				</div>

                {{-- <div class="form-group">
                    <div class="checkbox">
                        <input id="supervisor" type="checkbox" name="supervisor" value="1" {{ isset($e_c) ? ($e_c->supervisor == 1 ? 'checked' : '') : '' }}>
                        <label for="supervisor">Supervisore</label>
                    </div>
                </div> --}}

                <div class="form-group" style="display: none">

                    <label>Permessi</label>

                    <div class="checkbox">
                        <label> <input type="checkbox" {{ isset($e_c) ? (@$e_c->operator->ec == 1 ? 'checked' : '') : '' }} name="ec" value="1"> Vedi Express Claims</label>
                    </div>
                    <div class="checkbox">
                        <label> <input type="checkbox" {{ isset($e_c) ? (@$e_c->operator->et == 1 ? 'checked' : '') : '' }} name="et" value="1"> Vedi Express Tech</label>

                    </div>
                        <div class="checkbox" style="padding-left: 20px">
                            <label> <input id="supervisor" type="checkbox" name="supervisor" value="1" {{ isset($e_c) ? ($e_c->supervisor == 1 ? 'checked' : '') : '' }}> Perito</label>
                        </div>
                    <div class="checkbox">
                        <label> <input type="checkbox" {{ isset($e_c) ? (@$e_c->operator->mp == 1 ? 'checked' : '') : '' }} name="mp" value="1"> Vedi Mappa</label>
                    </div>
                    <div class="checkbox">
                        <label> <input type="checkbox" {{ isset($e_c) ? (@$e_c->operator->ap == 1 ? 'checked' : '') : '' }} name="ap" value="1"> Auto Perizia</label>
                    </div>

                    {{-- <label>Mappa</label>
                    <div class="checkbox">
                        <label style="padding: 0">
                            Vedi solo la mappa
                            <input type="checkbox" name="map" value="1" {{ isset($e_c) ? ($e_c->user->role_id == 3 ? 'checked' : '') : '' }}>
                        </label>
                    </div> --}}
                </div>
				
				<div class="alert alert-danger hide" id="error"></div>
				
				<div class="alert alert-success hide" id="success">
                    {{ isset($e_c) ? 'Accertatori aggiornato...' : 'Accertatori aggiunto...' }}
                </div>

				<button class="btn btn-block btn-success">Ok</button>
			</div>
		</form>
	</div>

	<div class="col-sm-9">
		<div class="panel">
			<div class="panel-heading">Accertatori
                <a href="{{url('admin/exportOperators',0)}}" class="btn btn-xs btn-info pull-right">Esporta Inattivi</a>
                <a href="{{url('admin/exportOperators',1)}}" class="btn btn-xs btn-info pull-right" style="margin-right:10px;">Esporta Attivi</a>
            </div>
			<div class="panel-body">

                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#active" aria-controls="active" role="tab" data-toggle="tab">Attivi</a></li>
                    <li role="presentation"><a href="#inactive" aria-controls="inactive" role="tab" data-toggle="tab">Inattivi</a></li>
                </ul>

                <div class="tabbable">
                    <div class="tab-content">
                        <div class="tab-pane table-responsive active fade in" id="active" style="margin-top: 10px">
            				<table class="display-1 table table-bordered table-striped">
            					<thead>
            						<tr>
            							<th>ID</th>
                                        <th>Telefono</th>
                                        <th>Nome</th>
                                        <th>EXPclaims</th>
                                        <th>EXPtech</th>
                                        <th>Perito</th>
                                        <th>Mappa</th>
                                        <th>Autoperizia</th>
            							<th>E-mail</th>
                                        {{-- <th>E-mail google calendar</th> --}}
                                        <th>Password</th>
            							<th></th>
            						</tr>
            					</thead>
            					<tbody>
                                    @php
                                        $n = App\User::where('role_id','!=',-1)->where('role_id','!=',0)->where('status',1)->whereExists(function($q){
                                        $q->from('operators')
                                          ->whereRaw('operators.user_id = users.id');
                                    })->get();

                                        for($i=1;$i<$n->count();$i++)
                                        {
                                            for($j=0;$j<$n->count()-$i;$j++)
                                            {
                                                if($n[$j]->lastname() > $n[$j+1]->lastname())
                                                {
                                                    $k=$n[$j+1];
                                                    $n[$j+1]=$n[$j];
                                                    $n[$j]=$k;
                                                }
                                            }
                                        }
                                    @endphp
                                    @foreach ($n as $o)
                                        <tr>
                                        	<td>OP{{ str_pad($o->id,5,0,STR_PAD_LEFT) }}</td>
                                            <td>{{ $o->street_phone }}</td>
                                            <td>{{ $o->lastname().' '.$o->name() }}</td>

                                            <td class="ec-{{$o->id}}">
                                                {!! @$o->operator->ec == 1 ? 
                                                '<label onclick="changeParameter(\'ec\','.$o->id.')" class="label label-success">Si</label>' :
                                                '<label onclick="changeParameter(\'ec\','.$o->id.')" class="label label-danger">No</label>' !!}
                                            </td>
                                            <td class="et-{{$o->id}}">
                                                {!! @$o->operator->et == 1 ? 
                                                '<label onclick="changeParameter(\'et\','.$o->id.')" class="label label-success">Si</label>' :
                                                '<label onclick="changeParameter(\'et\','.$o->id.')" class="label label-danger">No</label>' !!}
                                            </td>
                                            <td class="sp-{{$o->id}}">
                                                {!! @$o->supervisor == 1 ? 
                                                '<label onclick="changeParameter(\'sp\','.$o->id.')" class="label label-success">Si</label>' :
                                                '<label onclick="changeParameter(\'sp\','.$o->id.')" class="label label-danger">No</label>' !!}
                                            </td>
                                            <td class="mp-{{$o->id}}">
                                                {!! @$o->operator->mp == 1 ? 
                                                '<label onclick="changeParameter(\'mp\','.$o->id.')" class="label label-success">Si</label>' :
                                                '<label onclick="changeParameter(\'mp\','.$o->id.')" class="label label-danger">No</label>' !!}
                                            </td>
                                            <td class="ap-{{$o->id}}">
                                                {!! @$o->operator->ap == 1 ? 
                                                '<label onclick="changeParameter(\'ap\','.$o->id.')" class="label label-success">Si</label>' :
                                                '<label onclick="changeParameter(\'ap\','.$o->id.')" class="label label-danger">No</label>' !!}
                                            </td>

                                        	<td>{{ $o->email }}</td>
                                            {{-- <td>{{ $o->google_calendar_email }}</td> --}}
                                            <td class="hover-to-show-"><span>{{ $o->visualPassword }}</span></td>
                                            <td>
                                                <a href="{{ url('admin/accertatore',$o->id) }}/edit" class="btn btn-xs btn-info edit_feature"
                                                >Modifica</a>
                                                {{-- <a data-toggle="modal" href="#modal-delete-{{ $o->id }}" class="btn btn-xs btn-danger">Rimuovere</a> --}}
                                                @if ($o->status == 1)
                                                    <a data-toggle="modal" href="#modal-disable-{{ $o->id }}" class="btn btn-xs btn-warning">Disattivare</a>
                                                    <div class="modal fade" id="modal-disable-{{ $o->id }}">
                                                    	<div class="modal-dialog modal-sm">
                                                    		<div class="modal-content">
                                                    			<div class="modal-header">Vuoi disattivare l'accertatore {{ $o->name }}?</div>
                                                    			<div class="modal-footer">
                                                    				<button type="button" data-dismiss="modal" class="btn btn-warning btn-xs">Annullare</button>
                                                    				<a href="javascript:;" data-href="{{ url('admin/accertatore/disable',$o->id) }}" data-id="{{ $o->id }}" class="btn btn-success btn-xs disable-street">Accettare</a>
                                                    			</div>
                                                    		</div>
                                                    	</div>
                                                    </div>
                                                @else
                                                    <a data-toggle="modal" href="#modal-enable-{{ $o->id }}" class="btn btn-xs btn-success">Riattivare</a>
                                                    <div class="modal fade" id="modal-enable-{{ $o->id }}">
                                                    	<div class="modal-dialog modal-sm">
                                                    		<div class="modal-content">
                                                    			<div class="modal-header">Vuoi riattivare l'accertatore {{ $o->name }}?</div>
                                                    			<div class="modal-footer">
                                                    				<button type="button" data-dismiss="modal" class="btn btn-warning btn-xs">Annullare</button>
                                                    				<a href="javascript:;" data-href="{{ url('admin/accertatore/disable',$o->id) }}" data-id="{{ $o->id }}" class="btn btn-success btn-xs enable-street">Accettare</a>
                                                    			</div>
                                                    		</div>
                                                    	</div>
                                                    </div>
                                                @endif

                                                <div class="modal fade" id="modal-delete-{{ $o->id }}">
                                                	<div class="modal-dialog">
                                                		<div class="modal-content">
                                                			<div class="modal-header">Vuoi rimuovere l'accertatore {{ $o->name }}?</div>
                                                			<div class="modal-body">Tutti i dati dell'accertatore saranno cancellati, questa azione non può essere annullata</div>
                                                			<div class="modal-footer">
                                                				<button type="button" data-dismiss="modal" class="btn btn-warning btn-xs">Annullare</button>
                                                				<a href="{{ url('admin/accertatore/delete',$o->id) }}" class="btn btn-success btn-xs">Accettare</a>
                                                			</div>
                                                		</div>
                                                	</div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
            					</tbody>
            				</table>
                        </div>

                        <div class="tab-pane table-responsive fade" id="inactive" style="margin-top: 10px">
                            <table class="display table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Telefono</th>
                                        <th>Nome</th>
                                        <th>EXPclaims</th>
                                        <th>EXPtech</th>
                                        <th>Supervisore</th>
                                        <th>Mappa</th>
                                        <th>Autoperizia</th>
                                        <th>E-mail</th>
                                        <th>Password</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach (App\User::where('role_id','!=',-1)->where('role_id','!=',0)->where('status',0)->whereExists(function($q){
                                        $q->from('operators')
                                          ->whereRaw('operators.user_id = users.id');
                                    })->get() as $o)
                                        <tr>
                                            <td>OP{{ str_pad($o->id,5,0,STR_PAD_LEFT) }}</td>
                                            <td>{{ $o->street_phone }}</td>
                                            <td>{{ $o->fullname() }}</td>

                                            <td class="ec-{{$o->id}}">
                                                {!! @$o->operator->ec == 1 ? 
                                                '<label onclick="changeParameter(\'ec\','.$o->id.')" class="label label-success">Si</label>' :
                                                '<label onclick="changeParameter(\'ec\','.$o->id.')" class="label label-danger">No</label>' !!}
                                            </td>
                                            <td class="et-{{$o->id}}">
                                                {!! @$o->operator->et == 1 ? 
                                                '<label onclick="changeParameter(\'et\','.$o->id.')" class="label label-success">Si</label>' :
                                                '<label onclick="changeParameter(\'et\','.$o->id.')" class="label label-danger">No</label>' !!}
                                            </td>
                                            <td class="sp-{{$o->id}}">
                                                {!! @$o->supervisor == 1 ? 
                                                '<label onclick="changeParameter(\'sp\','.$o->id.')" class="label label-success">Si</label>' :
                                                '<label onclick="changeParameter(\'sp\','.$o->id.')" class="label label-danger">No</label>' !!}
                                            </td>
                                            <td class="mp-{{$o->id}}">
                                                {!! @$o->operator->mp == 1 ? 
                                                '<label onclick="changeParameter(\'mp\','.$o->id.')" class="label label-success">Si</label>' :
                                                '<label onclick="changeParameter(\'mp\','.$o->id.')" class="label label-danger">No</label>' !!}
                                            </td>

                                            <td class="ap-{{$o->id}}">
                                                {!! @$o->operator->ap == 1 ? 
                                                '<label onclick="changeParameter(\'ap\','.$o->id.')" class="label label-success">Si</label>' :
                                                '<label onclick="changeParameter(\'ap\','.$o->id.')" class="label label-danger">No</label>' !!}
                                            </td>

                                            <td>{{ $o->email }}</td>
                                            <td class="hover-to-show-"><span>{{ $o->visualPassword }}</span></td>
                                            <td>
                                                <a href="{{ url('admin/accertatore',$o->id) }}/edit" class="btn btn-xs btn-info edit_feature"
                                                >Modifica</a>
                                                {{-- <a data-toggle="modal" href="#modal-delete-{{ $o->id }}" class="btn btn-xs btn-danger">Rimuovere</a> --}}
                                                @if ($o->status == 1)
                                                    <a data-toggle="modal" href="#modal-disable-{{ $o->id }}" class="btn btn-xs btn-warning">Disattivare</a>
                                                    <div class="modal fade" id="modal-disable-{{ $o->id }}">
                                                        <div class="modal-dialog modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">Vuoi disattivare l'accertatore {{ $o->name }}?</div>
                                                                <div class="modal-footer">
                                                                    <button type="button" data-dismiss="modal" class="btn btn-warning btn-xs">Annullare</button>
                                                                    <a href="javascript:;" data-href="{{ url('admin/accertatore/disable',$o->id) }}" data-id="{{ $o->id }}" class="btn btn-success btn-xs disable-street">Accettare</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <a data-toggle="modal" href="#modal-enable-{{ $o->id }}" class="btn btn-xs btn-success">Riattivare</a>
                                                    <div class="modal fade" id="modal-enable-{{ $o->id }}">
                                                        <div class="modal-dialog modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">Vuoi riattivare l'accertatore {{ $o->name }}?</div>
                                                                <div class="modal-footer">
                                                                    <button type="button" data-dismiss="modal" class="btn btn-warning btn-xs">Annullare</button>
                                                                    <a href="javascript:;" data-href="{{ url('admin/accertatore/disable',$o->id) }}" data-id="{{ $o->id }}" class="btn btn-success btn-xs enable-street">Accettare</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="modal fade" id="modal-delete-{{ $o->id }}">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">Vuoi rimuovere l'accertatore {{ $o->name }}?</div>
                                                            <div class="modal-body">Tutti i dati dell'accertatore saranno cancellati, questa azione non può essere annullata</div>
                                                            <div class="modal-footer">
                                                                <button type="button" data-dismiss="modal" class="btn btn-warning btn-xs">Annullare</button>
                                                                <a href="{{ url('admin/accertatore/delete',$o->id) }}" class="btn btn-success btn-xs">Accettare</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
	</div>
</div>
@section('scripts')
<script>
    $('.disable-street').click(function(event) {
        var url = $(this).data('href');
        var id = $(this).data('id');
        imClient.sendMessage(id,'STREET_OPERATOR_NOW_INACTIVE');
        window.open(url,'_self');
    });
    $('.enable-street').click(function(event) {
        var url = $(this).data('href');
        var id = $(this).data('id');
        imClient.sendMessage(id,'STREET_OPERATOR_NOW_ACTIVE');
        window.open(url,'_self');
    });

    function changeParameter(parameter,id)
    {
        $.get('{{url('admin/changeParameter')}}/'+id+'/'+parameter, function(data) {
            $('.'+parameter+'-'+id).html(data);
        });
    }

    $('.display-1').dataTable({
      "aaSorting": [[ 2, "asc" ]]
    });

    // $('.chn-ec label').click(function(event) {
    //     changeParameter('ec',$(this).parent().data('id'),$(this));
    // });
    // $('.chn-et label').click(function(event) {
    //     changeParameter('et',$(this).parent().data('id'),$(this));
    // });
    // $('.chn-mp label').click(function(event) {
    //     changeParameter('mp',$(this).parent().data('id'),$(this));
    // });
    // $('.chn-sp label').click(function(event) {
    //     changeParameter('sp',$(this).parent().data('id'),$(this));
    // });
</script>
@endsection
@stop