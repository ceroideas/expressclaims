@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<style>
	.modal {
        overflow: auto;
    }
	.form-group {
	    margin-bottom: 15px !important;
	}
</style>

<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">Autoperizia</div>
			<div class="panel-body">
				<form action="{{url('admin/self-management')}}" method="GET">
                    <div class="row">
                        <div class="col-xs-3" style="padding-right: 0">
                            
                        </div>
                        <div class="col-xs-3">
                        </div>
                        <div class="col-xs-3">
                        </div>
                        <div class="col-xs-3">
                            <label for="">Filtro</label>
                            <div class="row">
                                <div class="col-xs-9" style="padding-right: 0">
                                    <input type="text" placeholder="Cerca" name="search" class="form-control" value="{{@$_GET['search']}}">
                                </div>
                                <div class="col-xs-3">
                                    <button class="btn btn-info btn-block">Go</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <br>
				<table id="orderByDate_" class="table table-bordered table-striped table-responsive">
					<thead>
						<tr>
							<th style="display: none;"></th>
							<th>Riferimento Interno</th>
							<th>Nome</th>
							<th>Telefono</th>
							<th>Società</th>
							{{-- <th>Status</th> --}}
							<th>Data di creazione</th>
							{{-- <th>Data di compilazione</th> --}}
                            <th>Data reminder</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@php
							$claims = App\User::where(function($q){
					            $q->whereExists(function($q){
					                $q->from('self_managements')
					                ->whereRaw('self_managements.user_id = users.id')
                                    ->whereRaw('self_managements.status = 1')
					                ->whereExists(function($q){
				                		$q->from('reservations')
						                ->whereRaw('reservations.customer_id = users.id')
						                // ->whereRaw('reservations.status = 0')
                                        ->whereExists(function($q){

							                if (isset($_GET['search']) && $_GET['search'] != "") {
								                $q->where('reservations.sin_number','like','%'.$_GET['search'].'%');
								                $q->orWhere('users.name','like','%'.$_GET['search'].'%');
								                $q->orWhere('self_managements.fullphone','like','%'.$_GET['search'].'%');
								            }
						                });
				                	});
					            });
					        })->orderBy('created_at','desc')->paginate(10);
                            $save_data = true;
						@endphp

	                    @foreach ($claims as $u)
                        	<tr>
                        		<td style="display: none;">{{ @strtotime($u->lastSinisterAmb()->created_at) }}</td>
                        		<td>{{$u->lastSinisterAmb()->sin_number}}</td>
                        		<td>{{$u->name}}</td>
                        		<td>{{$u->selfmanagement->fullphone}}</td>
                        		<td>{{$u->selfmanagement->society}}</td>
                        		{{-- <td>{{$u->selfmanagement->status}}</td> --}}
                        		<td>{{$u->created_at->format('d-m-Y H:i:s')}}</td>
                        		{{-- <td>{{$u->selfmanagement->status == 0 ? $u->selfmanagement->updated_at->format('d-m-Y H:i:s') : ''}}</td> --}}
                                <td>{{$u->selfmanagement->data_reminder}}</td>
                        		<td>
                        			<a target="_blank" href="{{url('admin/self-management-data',$u->id)}}" class="btn btn-info btn-xs">Vedi la pagina</a>
                        			<a target="_blank" data-toggle="modal" href="#get-sms{{$u->id}}" class="btn btn-warning btn-xs">Rimanda sms</a>
                                    @if ($u->selfmanagement->status == 1)
                                        <a target="_blank" data-toggle="modal" href="#get-link{{$u->id}}" class="btn btn-success btn-xs">Gestito</a>

                                        <div class="modal fade in" id="get-link{{$u->id}}">
                                            <div class="modal-dialog modal-sm">
                                                <div class="modal-content">
                                                    <div class="modal-header">Chiudere autoperizia?</div>
                                                    <div class="modal-footer">
                                                        <a href="{{url('admin/close-self-management',$u->selfmanagement->id)}}" class="btn btn-success btn-xs">Ok</a>
                                                        <button class="btn btn-warning btn-xs" data-dismiss="modal">Cancella</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                        			<div class="modal fade in" id="get-sms{{$u->id}}">
                            			<div class="modal-dialog modal-sm">
                            				<div class="modal-content">
                            					<div class="modal-header">Condividere Link</div>
                            					<div class="modal-body">

                            						@php
                            							$m = $u->selfmanagement;
                            						@endphp
                            		
                            						@include('admin.sms_selfmanagement')
                            					</div>
                            				</div>
                            			</div>
                            		</div>
                        		</td>
                        	</tr>
                        @endforeach
					</tbody>
				</table>
				@php
                    $claims->setPath('?search='.@$_GET['search'] )
                @endphp
                {{$claims->links()}}
			</div>
		</div>
	</div>
</div>
@section('scripts')
	<script>
		
	</script>
@endsection
@stop