@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Default Notification</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div class="row">
			<div class="col-lg-8">
				<div class="list-group">
					@foreach($data['defaultNotification'] as $default)
					<a href="defaultNotification/{{ $default->iDefaultNotificationId }}" class="list-group-item">
						<h4 class="list-group-item-heading">{{ $default->vDefaultNotificationTitle }}</h4>
						<p class="list-group-item-text">{{ $default->txDescription }}</p>
					</a>
					@endforeach
				</div>
			</div>
		</div>
	</div>

@stop