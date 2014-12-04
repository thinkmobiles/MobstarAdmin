@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Mentors</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div class="row">
			<div class="col-lg-8">
				<p><a href="/mentor/add" role="button" class="btn btn-green">Add mentor</a></p>
				<div class="list-group">
					@foreach($data['mentors'] as $mentor)
					<a href="/mentor/{{ $mentor->mentor_id }}" class="list-group-item">
						<h4 class="list-group-item-heading">{{ $mentor->mentor_display_name }}</h4>
						<p class="list-group-item-text">{{ $mentor->mentor_bio }}</p>
					</a>
					@endforeach
				</div>
			</div>
		</div>
	</div>

@stop