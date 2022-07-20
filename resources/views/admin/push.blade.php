@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<div class="row">
	<div class="col-sm-3">
		<form action="{{ url('admin/push') }}" method="post" class="panel send-form">
			{{ csrf_field() }}
            <div class="panel-heading">New Push Notification</div>
			<div class="panel-body">
				<div class="form-group">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#send-to-modal">Users</button>
				</div>
				<div class="form-group">
					<label>Title</label>
					<input type="text" name="title" class="form-control">
				</div>
				<div class="form-group">
					<label>Message</label>
					<textarea name="message" class="form-control" rows="4"></textarea>
				</div>
				
				<div class="alert alert-danger hide" id="error"></div>
				
				<div class="alert alert-success hide" id="success">
                    Notification sent...
                </div>

				<button class="btn btn-block btn-success">Submit</button>
			</div>
			<div class="modal fade" id="send-to-modal">
				<div class="modal-dialog modal-sm">
					<div class="modal-content">
						<div class="modal-header">
							Send To
						</div>
						<div class="modal-body">

							<div class="checkbox">
								<label><input type="checkbox" name="all" checked> All</label>
							</div>

							@foreach (App\Customer::all() as $c)

							<div class="checkbox">
								<label><input type="checkbox" name="send[]" class="send" value="{{ $c->id }}" checked> {{ $c->user->name }}</label>
							</div>
							@endforeach
						</div>
						<div class="modal-footer"></div>
					</div>
				</div>
			</div>
		</form>
	</div>

	<div class="col-sm-9">
		<div class="panel">
			<div class="panel-heading">Notifications Sent</div>
			<div class="panel-body">
				<table class="display table table-bordered table-striped">
					<thead>
						<tr>
							<th>ID</th>
							<th width="20%">Title</th>
							<th>Message</th>
							<th>Send to</th>
							<th width="20%">Date</th>
						</tr>
					</thead>
					<tbody>
                        @foreach (App\Push::all() as $p)
                            <tr>
                            	<td>{{ $p->id }}</td>
                            	<td>{{ $p->title }}</td>
                            	<td>{{ $p->message }}</td>
                            	<td>@foreach (json_decode($p->to,true) as $element)
                            		<li>{{ $element }}</li>
                            	@endforeach</td>
                            	<td>{{ Carbon\Carbon::parse($p->created_at)->format('d-m-Y h:i:s') }}</td>
                            </tr>
                        @endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@stop