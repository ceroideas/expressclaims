@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<div class="row">
	<div class="col-sm-4">
		@isset ($pr)
		<form action="{{ url('admin/express-tech/update-emails') }}" method="post" class="panel send-form">
			<input type="hidden" name="id" value="{{$pr->id}}">
            <div class="panel-heading">Modifica email</div>
		@else
		<form action="{{ url('admin/express-tech/emails') }}" method="post" class="panel send-form">
            <div class="panel-heading">Nuovo email</div>
		@endisset
			{{ csrf_field() }}
			<div class="panel-body">
				
				<div class="form-group">
					
				</div>
				<div class="form-group">
					<label>Titolo</label>
					<input type="text" class="form-control" name="title" value="{{isset($pr) ? ($pr->title) : ''}}">
				</div>

				<div class="form-group">
					<label>E-mail text</label>
					<textarea id="_predefined-0" class="form-control" rows="4">{{isset($pr) ? ($pr->predefined) : ''}}</textarea>
				</div>

				<div class="form-group">
					<div class="checkbox">
						<input type="checkbox" name="status" id="status" {{isset($pr) ? ($pr->status == 1 ? 'checked' : '') : ''}}>
						<label for="status">Mostra nel selettore</label>
					</div>
				</div>

				
				<div class="alert alert-danger hide" id="error"></div>
				
				<div class="alert alert-success hide" id="success">
                    Saved...
                </div>

				<button class="btn btn-block btn-success">Salva</button>
			</div>
		</form>
	</div>

	<div class="col-sm-8">
		<div class="panel">
			<div class="panel-heading">Emails create</div>
			<div class="panel-body">
				<table class="display table table-bordered table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>Titolo</th>
							<th>Text</th>
							<th>Mostra nel selettore</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
                        @foreach (App\PredefinedMail::all() as $p)
                            <tr>
                            	<td>{{ $p->id }}</td>
                            	<td>{{ $p->title }}</td>
                            	<td>{{ strip_tags($p->predefined) }}</td>
                            	<td>{{ $p->status == 1 ? 'ON' : 'OFF' }}</td>
                            	<td>
                            		<a href="{{ url('admin/express-tech/edit-mail',$p->id) }}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
                            		<a href="{{ url('admin/express-tech/delete-mail',$p->id) }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
                            	</td>
                            </tr>
                        @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@section('scripts')
<script>
	// $('#predefined').change(function(event) {
	// 	$('[name="message"]').html($('#predefined option:selected').data('messge'));
	// });
</script>
@endsection

@stop