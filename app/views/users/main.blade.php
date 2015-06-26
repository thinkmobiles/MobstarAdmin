@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Users</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div class="row">
			<div class="col-lg-8">
				<p><a href="/user/add" role="button" class="btn btn-green">Add user</a>
				<!--<a href="/users?showAll=1" role="button" class="btn btn-green">Show All</a></p>-->
				<div class="list-group">

					@foreach($data['users'] as $user)
					<a href="/user/{{ $user->user_id }}" class="list-group-item">
						<h4 class="list-group-item-heading">{{ $user->user_display_name }}</h4>
						<p class="list-group-item-text">{{ $user->user_bio }}</p>
					</a>
					@endforeach

				</div>
				<?php echo (!isset($_GET['showAll'])) ? $data['users']->links() : ""; ?>
			</div>
		</div>
	</div>
	
@stop