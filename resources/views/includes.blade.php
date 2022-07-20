@if(Session::get('message'))
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-success alert-bordered">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
				<span class="text-semibold">{{session('message')}}</span>
		    </div>
		</div>
	</div>
	
@endif

@if(Session::get('warning'))
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-warning warning-bordered">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>
				<span class="text-semibold">{{session('warning')}}</span>
		    </div>
		</div>
	</div>
	
@endif

@if(count($errors))
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-danger alert-bordered">
				<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>				
				<span><i class="icon-minus3"></i>{{ $errors->first() }}</span>
		    </div>
	    </div>
	</div>
@endif