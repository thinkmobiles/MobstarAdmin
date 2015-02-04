@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Mentor</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div id="form-layouts" class="row">
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">{{ empty($data['mentor']->mentor_id) ? 'Add' : 'Edit' }} mentor</div>
					<div class="panel-body pan">
						<form class="form-horizontal" method="post" enctype="multipart/form-data">
							@if ( !empty($data['mentor']->mentor_id) )
							<input type="hidden" name="mentor_id" value="{{ $data['mentor']->mentor_id }}" />
							@endif
							<div class="form-body pal">
								<div class="form-group">
									<div class="col-md-3">
									</div>
									<div class="col-md-9">
										@if ( !file_exists(($data['mentor']->mentor_profile_picture)) )
											<img src="http://api.mobstar.com/{{ $data['mentor']->mentor_profile_picture }}" width="100%" />
										@else
											<img src="http://admin.mobstar.com/{{ $data['mentor']->mentor_profile_picture }}" width="100%" />
										@endif
										
										<input type="file" name="mentor_profile_picture" />
									</div>
								</div>

								<div class="form-group">
									<label for="inputMentorName" class="col-md-3 control-label">Display name <span class='require'>*</span></label>
									<div class="col-md-9">
										<input id="inputMentorName" name="mentor_display_name" type="text" placeholder="Display name" class="form-control" {{ isset($data['mentor']->mentor_display_name) ? "value=\"".$data['mentor']->mentor_display_name."\"" : '' }} />
									</div>
								</div>
								<div class="form-group">
									<label for="inputFirstName" class="col-md-3 control-label">First name</label>
									<div class="col-md-9">
										<input id="inputFirstName" name="mentor_first_name" type="text" placeholder="First name" class="form-control" {{ isset($data['mentor']->mentor_first_name) ? "value=\"".$data['mentor']->mentor_first_name."\"" : '' }} />
									</div>
								</div>
								<div class="form-group">
									<label for="inputSurname" class="col-md-3 control-label">Surname</label>
									<div class="col-md-9">
										<input id="inputSurname" name="mentor_surname" type="text" placeholder="Surname" class="form-control" {{ isset($data['mentor']->mentor_surname) ? "value=\"".$data['mentor']->mentor_surname."\"" : '' }} />
									</div>
								</div>
								

								<div class="form-group">
									<label for="inputVideo" class="col-md-3 control-label">Video</label>
									<div class="col-md-9">
										<input id="inputVideo" name="mentor_video" type="text" class="form-control" {{ isset($data['mentor']->mentor_video) ? "value=\"".$data['mentor']->mentor_video."\"" : '' }} />
									</div>
								</div>
								<div class="form-group mbn">
									<label for="inputMentorBio" class="col-md-3 control-label">Bio</label>
									<div class="col-md-9">
										<textarea name="mentor_bio" id="inputMentorBio" rows="3" class="form-control">{{ isset($data['mentor']->mentor_bio) ? $data['mentor']->mentor_bio : '' }}</textarea>
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn btn-primary">Save</button>&nbsp;<a href="/mentors" role="button" class="btn btn-green">Cancel</a>
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