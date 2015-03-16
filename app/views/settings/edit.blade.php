@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Setting</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div id="form-layouts" class="row">
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">{{ empty($data['settings']->iSettingId) ? 'Add' : 'Edit' }} settings</div>
					<div class="panel-body pan">
						<form class="form-horizontal" method="post" enctype="multipart/form-data">
							@if ( !empty($data['settings']->iSettingId) )
							<input type="hidden" name="iSettingId" value="{{ $data['settings']->iSettingId }}" />
							@endif
							<div class="form-body pal">
								<div class="form-group">
									<label for="inputTitle" class="col-md-3 control-label">Title <span class='require'>*</span></label>
									<div class="col-md-9">
										<input id="inputTitle" name="vTitle" type="text" placeholder="Title" class="form-control" {{ isset($data['settings']->vTitle) ? "value=\"".$data['settings']->vTitle."\"" : '' }} />
									</div>
								</div>
								<div class="form-group">
									<label for="inputUniqueName" class="col-md-3 control-label">Unique Name <span class='require'>*</span></label>
									<div class="col-md-9">
										<input id="inputUniqueName" name="vUniqueName" type="text" placeholder="Unique Name" class="form-control" {{ isset($data['settings']->vUniqueName) ? "value=\"".$data['settings']->vUniqueName."\"" : '' }} />
									</div>
								</div>		
								<div class="form-group mbn">
									<label for="inputSettingValue" class="col-md-3 control-label">Setting Value</label>
									<div class="col-md-9">
										<textarea name="vSettingValue" id="inputSettingValue" rows="3" class="form-control">{{ isset($data['settings']->vSettingValue) ? $data['settings']->vSettingValue : '' }}</textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="SettingType" class="col-md-3 control-label">Setting Type</label>
									<div class="col-md-9">
										<select id="eSettingType" class="form-control" name="eSettingType">
											<option value="1" {{ isset($data['settings']) && $data['settings']->eSettingType=='Appearance' ? 'selected' : '' }}>Appearance</option>
											<option value="2" {{ isset($data['settings']) && $data['settings']->eSettingType=='API Setting' ? 'selected' : '' }}>API Setting</option>
						
										</select>
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Status</label>
									<div class="col-md-9">
										<input type="hidden" name="eStatus" value="0" />
										<div data-on="info" data-off="success" class="make-switch"><input name="eStatus" value="1" type="checkbox" {{ isset($data['settings']) && $data['settings']->eStatus=='Active' ? ' checked="checked"' : '' }} class="switch"/></div>
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn btn-primary">Save</button>&nbsp;<a href="../settings" role="button" class="btn btn-green">Cancel</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@stop