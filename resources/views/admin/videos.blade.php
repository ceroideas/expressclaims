@extends('admin.layout')

@section('title','EXPRESS CLAIMS')
@section('content')

<div class="row">
	<div class="col-sm-12">
		<div class="panel">
			<div class="panel-heading">Video del sinistro</div>
			<div class="panel-body">
				<div class="row">
					@foreach ($rc as $element)
						@if ($element->duration == "0:00")
	                        @php
	                            @unlink(public_path().'/uploads/videos/'.$element->name);
	                            $element->delete();
	                        @endphp
	                    @else
							@if (file_exists( public_path().'/uploads/videos/'.$element->name ) )
								<div class="col-sm-3" style="height: 350px;">
									<video id="video-{{$element->id}}" controls="" src="{{ url('uploads/videos',$element->name) }}" style="width:100% !important;height:200px !important; position: relative;"></video><br>
									<small id="controls-{{$element->id}}" style="margin-bottom: 10px;display:block; line-height: 16px">
									<b>Riferimento Interno:</b> {{ $res->sin_number }} <br>
									<b>Latitudine:</b> {{ $element->lat }} <br>
									<b>Longitudine:</b> {{ $element->lon }} <br>
									<b>Indirizzo:</b> {{ $element->address }} <br>
									<b>Data:</b> {{ $element->created_at->format('d-m-Y H:i:s') }} <br> 
									<b>Via:</b> Registrazione <br>

									<span id="links-{{$element->id}}" style="display: block; margin-top: 2px;">
										@if (strpos($element->name,'.mp4'))
											<a download class="btn btn-info btn-xs" href="{{ url('uploads/videos',$element->name) }}">Scaricare</a>
										@else
											<button data-id="{{$element->id}}" class="btn btn-info btn-xs convertMp4" href="{{ url('uploads/videos',$element->name) }}">Scaricare</button>
										@endif
									</span>
									</small>
								</div>
							@elseif($element->remote_url)
                                @php
                                    $dest = public_path().'/uploads/videos/' . $element->name;

                                    try{

                                        copy($element->remote_url, $dest);
                                        $element->remote_url = null;
                                        $element->save();

                                    }catch (Exception $e){

                                        echo "";

                                    }
                                @endphp
							@endif
						@endif
					@endforeach
					@foreach ($v as $element)
						{{-- @if (file_exists( public_path().'/uploads/users/'.$element->user_id.'/'.$res->sin_number.'/videos',$element->video ) )
							<div class="col-sm-3" style="height: 350px;">
								<video controls="" src="{{ url('uploads/users/'.$element->user_id.'/'.$res->sin_number.'/videos',$element->video) }}" style="width:100% !important;height:200px !important; position: relative;"></video><br>
								<small style="margin-bottom: 10px;display:block; line-height: 16px">
								<b>Riferimento Interno:</b> {{ $res->sin_number }} <br>
								<b>Latitudine:</b> {{ $element->lat }} <br>
								<b>Longitudine:</b> {{ $element->lon }} <br>
								<b>Indirizzo:</b> {{ $element->address }} <br>
								<b>Data:</b> {{ $element->created_at->format('d-m-Y H:i:s') }} <br> 
								<b>Via:</b> Chat <br>
								<a download class="btn btn-info btn-xs" href="{{ url('uploads/users/'.$element->user_id.'/'.$res->sin_number.'/videos',$element->video) }}">Scaricare</a></small>
							</div>
						@endif --}}
					@endforeach
				</div>
			</div>
		</div>
	</div>
</div>
@section('scripts')
<script>
	function convertMp4(event) {
        let id = $(this).data('id');
        $('#controls-'+id).block({message:'Converting video to MP4... please wait'});
        let video = $(this).data('href');
        $.post('{{url('api/convertMp4')}}', {id: id}, function(data, textStatus, xhr) {

            $('#links-'+id).html('<a download href="'+data[0]+'" target="_blank" class="btn btn-info btn-xs">Scaricare</a>');
            $('#video-'+id).attr('src',data[0]);

            window.open(data[0],'_blank');

            $('#controls-'+id).unblock();
        });
    }

    $('.convertMp4').click(convertMp4);
</script>
@endsection
@stop