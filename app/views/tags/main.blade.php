@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Tags</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div class="row">
			<div class="col-lg-8">
				<p><a href="/tag/add" role="button" class="btn btn-green">Add tag</a></p>
				<div class="list-group">

					@foreach($data['tags'] as $tag)
					<a href="/tag/{{ $tag->tag_id }}" class="list-group-item">
						<h4 class="list-group-item-heading">{{ $tag->tag_name }}</h4>
					</a>
					@endforeach
					
				</div>
				<?php echo (!isset($_GET['showAll'])) ? $data['tags']->links() : ""; ?>
			</div>
		</div>
	</div>

@stop