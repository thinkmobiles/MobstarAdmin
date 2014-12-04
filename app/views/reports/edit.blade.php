@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Report</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div id="form-layouts" class="row">
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">{{ empty($data['report']->entry_report_id) ? 'Add' : 'Edit' }} report</div>
					<div class="panel-body pan">
						<form class="form-horizontal" method="post">
							@if ( !empty($data['report']->entry_report_id) )
							<input type="hidden" name="entry_report_id" value="{{ $data['report']->entry_report_id }}" />
							@endif
							<div class="form-body pal">
								<div class="form-group mbn">
									<label for="inputEntryReportReportReason" class="col-md-3 control-label">Bio</label>
									<div class="col-md-9">
										<textarea name="entry_report_report_reason" id="inputEntryReportReportReason" rows="3" class="form-control">{{ isset($data['report']->entry_report_report_reason) ? $data['report']->entry_report_report_reason : '' }}</textarea>
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn btn-primary">Save</button>&nbsp;<a href="/reports" role="button" class="btn btn-green">Cancel</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@stop