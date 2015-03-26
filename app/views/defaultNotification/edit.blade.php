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
		<div id="form-layouts" class="row">
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">{{ empty($data['defaultNotification']->iDefaultNotificationId) ? 'Add' : 'Edit' }} Default Notification</div>
					<div class="panel-body pan">
						<form class="form-horizontal" method="post" enctype="multipart/form-data">
							@if ( !empty($data['defaultNotification']->iDefaultNotificationId) )
							<input type="hidden" name="iDefaultNotificationId" value="{{ $data['defaultNotification']->iDefaultNotificationId }}" />
							@endif
							<div class="form-body pal">
								<div class="form-group">
									<label for="inputTitle" class="col-md-3 control-label">Title <span class='require'>*</span></label>
									<div class="col-md-9">
										<input id="inputTitle" name="vDefaultNotificationTitle" type="text" placeholder="Title" class="form-control" {{ isset($data['defaultNotification']->vDefaultNotificationTitle) ? "value=\"".$data['defaultNotification']->vDefaultNotificationTitle."\"" : '' }} />
									</div>
								</div>
								<!-- <div class="form-group">
									<label class="col-md-3 control-label">Status</label>
									<div class="col-md-9">
										<input type="hidden" name="category_active" value="0" />
										<div data-on="info" data-off="success" class="make-switch"><input name="category_active" value="1" type="checkbox" {{ isset($data['category']) && $data['category']->category_active==1 ? ' checked="checked"' : '' }} class="switch"/></div>
									</div>
								</div> -->
								<div class="form-group">
									<label for="inputImage" class="col-md-3 control-label">Image</label>
									<div class="col-md-9">
									@if (!empty($data['defaultNotification']->vDefaultNotificationImage))
										<div class="colorbg">
											<img src="../{{ $data['defaultNotification']->vDefaultNotificationImage }}" width="100%" />
										</div>
									@endif
									<input type="file" name="vDefaultNotificationImage"/>
									</div>
								</div>
								<div class="form-group mbn">
									<label for="inputDescription" class="col-md-3 control-label">Description</label>
									<div class="col-md-9">
										<textarea name="txDescription" id="inputDescription" rows="3" class="form-control">{{ isset($data['defaultNotification']->txDescription) ? $data['defaultNotification']->txDescription : '' }}</textarea>
									</div>
								</div>
								
							</div>
							<div class="form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn btn-primary">Save</button>&nbsp;<a href="../defaultNotification" role="button" class="btn btn-green">Cancel</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@stop