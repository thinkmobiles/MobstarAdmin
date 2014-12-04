@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Categories</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div class="row">
			<div class="col-lg-8">
				<p><a href="/category/add" role="button" class="btn btn-green">Add category</a></p>
				<div class="list-group">
					@foreach($data['categories'] as $category)
					<a href="/category/{{ $category->category_id }}" class="list-group-item">
						<h4 class="list-group-item-heading">{{ $category->category_name }}</h4>
						<p class="list-group-item-text">{{ $category->category_description }}</p>
					</a>
					@endforeach
				</div>
			</div>
		</div>
	</div>

@stop