@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<div class="row">
	<div class="col-sm-3">
		
		@isset ($pred)
		<form action="{{ url('admin/sms/update',$pred->id) }}" method="post" class="panel send-form">
            <div class="panel-heading">Modificare sms predefinito</div>
		@else
		<form action="{{ url('admin/sms/create') }}" method="post" class="panel send-form">
            <div class="panel-heading">Crea sms predefinito</div>
		@endisset
			{{ csrf_field() }}
			<div class="panel-body">
				<div class="form-group">
					<label>Titolo</label>
					<input type="text" name="title" class="form-control" value="{{ isset($pred) ? $pred->title : '' }}">
				</div>
				<div class="form-group">
					<label>Messaggio</label>
					<textarea name="message" class="form-control" rows="4">{{ isset($pred) ? $pred->message : '' }}</textarea>
				</div>
				
				<div class="alert alert-danger hide" id="error"></div>
				
				<div class="alert alert-success hide" id="success">
                    SMS predefiniti salvati...
                </div>

				<button class="btn btn-block btn-success">Salva</button>
			</div>
		</form>
	</div>

	<div class="col-sm-9">
		<div class="panel">
			<div class="panel-heading">SMS Inviati</div>
			<div class="panel-body">
				<table class="display table table-bordered table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th>Titolo</th>
							<th>Messaggio</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
                        @foreach (App\Predefined::all() as $sms)
                            <tr>
                            	<td>{{ $sms->id }}</td>
                            	<td>{{ $sms->title }}</td>
                            	<td>{{ $sms->message }}</td>
                            	<td>
                            		<a href="{{ url('admin/predefiniti',$sms->id) }}" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i></a>
                            		<a href="{{ url('admin/predefiniti/delete',$sms->id) }}" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>
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
	$('#predefined').change(function(event) {
		$('[name="message"]').html($('#predefined option:selected').data('messge'));
	});
</script>
@endsection

@stop