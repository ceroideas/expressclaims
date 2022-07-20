@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<div class="row">
	<div class="col-sm-3">
		
		@isset ($company)
		<form action="{{ url('admin/compagnia',$company->id) }}" method="post" class="panel send-form">
            <div class="panel-heading">Modificare compagnia</div>
		@else
		<form action="{{ url('admin/compagnia') }}" method="post" class="panel send-form">
            <div class="panel-heading">Crea compagnia</div>
		@endisset
			{{ csrf_field() }}
			<div class="panel-body">
				<div class="form-group">
					<label>Name</label>
					<input type="text" name="name" class="form-control" value="{{ isset($company) ? $company->name : '' }}">
				</div>
				
				<div class="alert alert-danger hide" id="error"></div>
				
				<div class="alert alert-success hide" id="success">
                    Compagnia salvati...
                </div>

				<button class="btn btn-block btn-success">Salva</button>
			</div>
		</form>
	</div>

	<div class="col-sm-9">
		<div class="panel">
			<div class="panel-heading">Compagnie</div>
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
                        @foreach (App\Company::all() as $c)
                            <tr>
                            	<td>{{ $c->id }}</td>
                            	<td>{{ $c->name }}</td>
                            	<td>
                            		<a href="{{ url('admin/compagnia',$c->id) }}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
                            		<a href="{{ url('admin/compagnia/delete',$c->id) }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
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