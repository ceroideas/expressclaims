@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<div class="row">
	<div class="col-sm-3">
		
		@isset ($typology)
		<form action="{{ url('admin/tipologia-di-danno',$typology->id) }}" method="post" class="panel send-form">
            <div class="panel-heading">Modificare tipologia</div>
		@else
		<form action="{{ url('admin/tipologia-di-danno') }}" method="post" class="panel send-form">
            <div class="panel-heading">Crea tipologia</div>
		@endisset
			{{ csrf_field() }}
			<div class="panel-body">
				<div class="form-group">
					<label>Name</label>
					<input type="text" name="name" class="form-control" value="{{ isset($typology) ? $typology->name : '' }}">
				</div>
				
				<div class="alert alert-danger hide" id="error"></div>
				
				<div class="alert alert-success hide" id="success">
                    Tipologia salvati...
                </div>

				<button class="btn btn-block btn-success">Salva</button>
			</div>
		</form>
	</div>

	<div class="col-sm-9">
		<div class="panel">
			<div class="panel-heading">Tipologie</div>
			<div class="panel-body">
				<table class="display table table-bordered table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
                        @foreach (App\Damage::all() as $c)
                            <tr>
                            	<td>{{ $c->id }}</td>
                            	<td>{{ $c->name }}</td>
                            	<td>
                            		<a href="{{ url('admin/tipologia-di-danno',$c->id) }}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
                            		<a href="{{ url('admin/tipologia-di-danno/delete',$c->id) }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
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