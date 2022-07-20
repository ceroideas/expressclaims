@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<div class="row">
	<div class="col-sm-12">
		<div class="ajax-calendar">
			@include('admin.include_calendar')
		</div>
	</div>
</div>

@stop