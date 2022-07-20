@extends('admin.layout')

@section('content')

<div class="row">
	<div class="col-sm-3">
		<form action="{{ isset($e_t) ? url('admin/add',$e_t->id) : url('admin/add') }}" method="post" class="panel send-form">
			{{ csrf_field() }}
			@if(isset($e_t))
	            <div class="panel-heading">Modifica Tipologia</div>
	            <input type="hidden" name="id" value="{{ $e_t->id }}">
				
            @else
            	<div class="panel-heading">Nuova Tipologia</div>
            @endif
			<div class="panel-body">
				<div class="form-group">
					<label>Tipologia</label>
					<input type="text" name="long_name" value="{{ isset($e_t) ? $e_t->long_name : '' }}" class="form-control">
				</div>

				<div class="form-group">
					<label>Abbreviazione</label>
					<input type="text" name="short_name" value="{{ isset($e_t) ? $e_t->short_name : '' }}" class="form-control">
				</div>

				<div class="form-group">
					<label>Key</label>
					<input type="text" name="key" value="{{ isset($e_t) ? $e_t->key : '' }}" class="form-control">
				</div>
				
				<div class="alert alert-danger hide" id="error"></div>
				
				<div class="alert alert-success hide" id="success">
                    {{ isset($e_t) ? 'Tipologia aggiornata...' : 'Tipologia aggiunta...' }}
                </div>

				<button class="btn btn-block btn-success">Ok</button>
			</div>
		</form>
	</div>

	<div class="col-sm-9">
		<div class="panel">
			<div class="panel-heading">Tipologie
            </div>
			<div class="panel-body">
				<table class="display-1 table table-bordered table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nome lungo</th>
							<th>Abbreviazione</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
                        @foreach ($typologies as $t)
                            <tr>
                            	<td>TP{{ str_pad($t->id,5,0,STR_PAD_LEFT) }}</td>
                            	<td>{{$t->long_name}}</td>
                            	<td>{{$t->short_name}}</td>
                            	<td>
                            		<a href="{{ url('admin/tipologie',$t->id) }}" class="btn btn-xs btn-info">Modifica</a>

                            		<a href="{{ url('admin/tipologie/sezioni',$t->id) }}" class="btn btn-xs btn-warning">Sezioni</a>

                            		<a href="#delete-modal-{{$t->id}}" data-toggle="modal" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>

                            		<div class="modal fade" id="delete-modal-{{$t->id}}">
					                    <div class="modal-dialog modal-sm">
					                        <div class="modal-content">
					                            <div class="modal-header">Vuoi eliminare la tipologia selezionata?</div>
					                            <div class="modal-footer">
					                                <a type="button" href="{{url('admin/deleteTypology',$t->id)}}" class="btn btn-xs btn-success">
					                                    Si
					                                </a>
					                                <button type="button" data-dismiss="modal" class="btn btn-xs btn-danger">
					                                    No
					                                </button>
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

@stop