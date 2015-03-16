@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Settings</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div class="row">
			<div class="col-lg-8">
				<!-- <p><a href="setting/edit" role="button" class="btn btn-green">Edit Settings</a></p> -->
				<div class="list-group">
					@foreach($data['settings'] as $setting)
					<a href="setting/{{ $setting->iSettingId }}" class="list-group-item">
						<h4 class="list-group-item-heading">{{ $setting->vTitle }}</h4>
						<p class="list-group-item-text">Setting value = {{ $setting->vSettingValue }}</p>
					</a>
					@endforeach
				</div>
			</div>
		</div>
	</div>

@stop