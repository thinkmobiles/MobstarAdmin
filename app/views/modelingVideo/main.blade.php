@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Modeling Videos</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div class="row">
			<div class="col-lg-8">
				<div class="list-group">
					@foreach($data['modelingVideo'] as $video)
						@if($video['vModelingVideoURL'] !='')
							<video class="video-js vjs-default-skin" controls preload="metadata" height="200px" width = "200px">
								<source src="uploads/modelingVideo/{{$video['iModelingVideoId']}}/{{$video['vModelingVideoURL']}}" type="video/mp4">
								Your browser does not support the video tag.
							</video>
						@else
                            <img src="uploads/modelingVideo/{{$video['iModelingVideoId']}}/{{$video['vModelingVideoURL']}}" height="200px" width = "200px" />
		                @endif
					<a href="video/{{ $video->iModelingVideoId }}" class="list-group-item">
						<h4 class="list-group-item-heading">{{ $video->vModelingVideoURL }}</h4>
						<p class="list-group-item-text">{{ $video->txDescription }}</p>
					</a>
					@endforeach
				</div>
			</div>
		</div>
	</div>

@stop