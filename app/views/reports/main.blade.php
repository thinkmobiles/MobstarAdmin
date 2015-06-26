@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Reports</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div class="row">
			<div class="col-lg-8">
				<p><a href="/report/add" role="button" class="btn btn-green">Add report</a></p>
				<div class="list-group">
					@foreach($data['reports'] as $report)
					<a href="/report/{{ $report->entry_report_id }}" class="list-group-item">
						<p class="list-group-item-text">{{ $report->entry_report_report_reason }}</p>
					</a>
					@endforeach
				</div>
				<?php echo (!isset($_GET['showAll'])) ? $data['reports']->links() : ""; ?>
			</div>
		</div>
	</div>

@stop