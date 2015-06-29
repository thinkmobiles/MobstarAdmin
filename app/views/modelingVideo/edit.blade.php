@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Modeling Video</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div id="form-layouts" class="row">
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">{{ empty($data['modelingVideo']->iModelingVideoId) ? 'Add' : 'Edit' }} Modeling Video</div>
					<div class="panel-body pan">
						<form class="form-horizontal" method="post" enctype="multipart/form-data">
							@if ( !empty($data['modelingVideo']->iModelingVideoId) )
							<input type="hidden" name="iModelingVideoId" value="{{ $data['modelingVideo']->iModelingVideoId }}" />
							@endif
							<div class="form-body pal">

								<div class="form-group">
									<label for="inputVideo" class="col-md-3 control-label">Video URL</label>
									<div class="col-md-9">
										<input id="inputVideo" name="vModelingVideoURL" type="file" class="form-control" {{ isset($data['modelingVideo']->vModelingVideoURL) ? "value=\"".$data['modelingVideo']->vModelingVideoURL."\"" : '' }} />
									</div>
								</div>

								<div class="form-group mbn">
									<label for="txDescription" class="col-md-3 control-label">Guideline Text <span class='require'>*</span></label>
									<div class="col-md-9">
										<textarea name="txDescription" id="inputDescription" rows="3" class="form-control">{{ isset($data['modelingVideo']->txDescription) ? $data['modelingVideo']->txDescription : '' }}</textarea>
										@if (isset($data['errors']))
											<p style="color: red;">{{ $data['errors']->getMessages()['txDescription']['0'] }}</p>
										@endif
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn btn-primary">Save</button>&nbsp;<a href="modelingVideo" role="button" class="btn btn-green">Cancel</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		@if ( !empty($data['mentor']->mentor_id) )
		
		<div id="form-layouts" class="row">
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">Actions</div>
					<div class="panel-body pan">
						<form class="form-horizontal" method="post">
							<div class="form-actions">
								<div class="col-md-3">

								</div>
								<div class="col-md-9">
									<button type="button" data-target="#modal-delete" data-toggle="modal" class="btn btn-red">Delete</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!--Modal Default-->
		<div id="modal-delete" tabindex="-1" role="dialog" aria-labelledby="modal-default-label" aria-hidden="true" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
						<h4 id="modal-default-label" class="modal-title">Delete mentor</h4></div>
					<div class="modal-body">You are about to permanently delete this mentor.</div>
					<div class="modal-footer">
						<button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
						<button type="button" id="delete_item" class="btn btn-primary">Delete</button>
					</div>
				</div>
			</div>
		</div>

		@endif
	</div>

@stop


@section('pagefoot')

@if ( !empty($data['mentor']->mentor_id) )
<script type="text/javascript">

	$('#delete_item').click(function(){

		var post = {id:"{{ $data['mentor']->mentor_id }}"};
		// alert('red');
		$.post('/mentor/delete', post, function(data)
		{
			window.location.replace('/mentors');
		});
		return false;

	});

</script>
@endif

@stop