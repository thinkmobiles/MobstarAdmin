@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Blogs</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div class="row">
			<div class="col-lg-8">
				<p><a href="blog/add" role="button" class="btn btn-green">Add blog</a></p>
				<div class="list-group">
					@foreach($data['blogs'] as $blog)
					<a href="blog/{{ $blog->iBlogId }}" class="list-group-item">
						<img src="{{ $blog->vBlogImage }}" width="9%">
						<p class="list-group-item-text">{{ date('d/m/Y',strtotime($blog->tsCreatedAt)) }}</p>
						<h4 class="list-group-item-heading">{{ $blog->vBlogHeader }}</h4>
						
					</a>
					@endforeach
				</div>
			</div>
		</div>
	</div>

@stop