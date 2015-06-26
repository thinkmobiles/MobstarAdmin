@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Message</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div id="form-layouts" class="row">
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">{{ empty($data['message']->message_id) ? 'Add' : 'Edit' }} message</div>
					<div class="panel-body pan">
						<form class="form-horizontal" method="post">
							@if ( !empty($data['message']->message_id) )
							<input type="hidden" name="message_id" value="{{ $data['message']->message_id }}" />
							@endif
							<div class="form-body pal">
								<div class="form-group mbn">
									<label for="inputMessageBody" class="col-md-3 control-label">Message</label>
									<div class="col-md-9">
										<textarea name="message_body" id="inputMessageBody" rows="3" class="form-control">{{ isset($data['message']->message_body) ? $data['message']->message_body : '' }}</textarea>
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn btn-primary">Save</button>&nbsp;<a href="/messages" role="button" class="btn btn-green">Cancel</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@stop