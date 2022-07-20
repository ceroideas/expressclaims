@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<div class="row">
	<div class="col-sm-3">
		
		@isset ($policy)
		<form action="{{ url('admin/modello-di-polizza',$policy->id) }}" method="post" class="panel send-form">
            <div class="panel-heading">Modificare modello di polizza</div>
		@else
		<form action="{{ url('admin/modello-di-polizza') }}" method="post" class="panel send-form">
            <div class="panel-heading">Crea modello di polizza</div>
		@endisset
			{{ csrf_field() }}
			<div class="panel-body">
				<div class="form-group">
					<label>Name</label>
					<input type="text" name="name" class="form-control" value="{{ isset($policy) ? $policy->name : '' }}">
				</div>

				<div class="form-group">
					<label>Compagnia</label>
					<select name="company_id" id="" class="form-control">
							<option value="" selected disabled=""></option>
						@foreach (App\Company::all() as $cm)
							<option {{ isset($policy) ? ($policy->company_id == $cm->id ? 'selected' : '') : '' }} value="{{ $cm->id }}">{{ $cm->name }}</option>
						@endforeach
					</select>
				</div>
				
				<div class="alert alert-danger hide" id="error"></div>
				
				<div class="alert alert-success hide" id="success">
                    Modello salvati...
                </div>

				<button class="btn btn-block btn-success">Salva</button>
			</div>
		</form>
	</div>

	<div class="col-sm-9">
		<div class="panel">
			<div class="panel-heading">Modelli</div>
			<div class="panel-body">
				<table class="display table table-bordered table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>Nome</th>
							<th>Compagnia</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
                        @foreach (App\PolicyModel::all() as $c)
                            <tr>
                            	<td>{{ $c->id }}</td>
                            	<td>{{ $c->name }}</td>
                            	<td>{{ App\Company::find($c->company_id) ? App\Company::find($c->company_id)->name : '' }}</td>
                            	<td>
                            		<a href="{{ url('admin/modello-di-polizza',$c->id) }}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
                            		<a href="{{ url('admin/modello-di-polizza/delete',$c->id) }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
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