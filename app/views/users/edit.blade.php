@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">User</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div id="form-layouts" class="row">
			


			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">{{ empty($data['user']->user_id) ? 'Add' : 'Edit' }} user</div>
					<div class="panel-body pan">
						<form class="form-horizontal" method="post">
							@if ( !empty($data['user']->user_id) )
							<input type="hidden" name="user_id" value="{{ $data['user']->user_id }}" />
							@endif
							<div class="form-body pal">
								<div class="form-group">
									<label for="inputDisplayName" class="col-md-3 control-label">Display name <span class='require'>*</span></label>
									<div class="col-md-9">
										<input id="inputDisplayName" name="user_display_name" type="text" placeholder="Display name" class="form-control" {{ isset($data['user']->user_display_name) ? "value=\"".$data['user']->user_display_name."\"" : '' }} />
									</div>
								</div>

								<div class="form-group">
									<label for="inputName" class="col-md-3 control-label">Name</label>
									<div class="col-md-9">
										<input id="inputName" name="user_name" type="text" placeholder="Name" class="form-control" {{ isset($data['user']->user_name) ? "value=\"".$data['user']->user_name."\"" : '' }} />
									</div>
								</div>

								<div class="form-group">
									<label for="inputEmail" class="col-md-3 control-label">Email<span class='require'>*</span></label>
									<div class="col-md-9">
										<input id="inputEmail" name="user_email" type="text" placeholder="Email" class="form-control" {{ isset($data['user']->user_email) ? "value=\"".$data['user']->user_email."\"" : '' }} />
									</div>
								</div>

								<div class="form-group">
									<label for="inputFullName" class="col-md-3 control-label">Full name</label>
									<div class="col-md-9">
										<input id="inputFullName" name="user_full_name" type="text" placeholder="Full name" class="form-control" {{ isset($data['user']->user_full_name) ? "value=\"".$data['user']->user_full_name."\"" : '' }} />
									</div>
								</div>

								<div class="form-group">
									<label for="inputTagline" class="col-md-3 control-label">Tagline</label>
									<div class="col-md-9">
										<input id="inputTagline" name="user_tagline" type="text" placeholder="Tagline" class="form-control" {{ isset($data['user']->user_tagline) ? "value=\"".$data['user']->user_tagline."\"" : '' }} />
									</div>
								</div>

								<div class="form-group">
									<label for="inputDOB" class="col-md-3 control-label">DOB</label>
									<div class="col-md-9">
										<div class="input-group">
											<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
											<input name="user_dob" id="inputDOB" type="text" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" class="datepicker-default form-control"{{ isset($data['user']->user_dob) && !empty($data['user']->user_dob) ? "value=\"".date('d/m/Y',strtotime($data['user']->user_dob))."\"" : '' }} />
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="inputUserGroup" class="col-md-3 control-label">User Group</label>
									<div class="col-md-9">
										<div class="input-group">
											<select id="inputUserGroup" class="form-control" name="user_user_group">
											@foreach($data['usergroups'] as $usergroup)
											<option value="{{ $usergroup->user_group_id }}" @if (isset($data['user']->user_user_group) && $usergroup->user_group_id === $data['user']->user_user_group)selected="selected"@endif>{{ $usergroup->user_group_name }}</option>
											@endforeach
											</select>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Activated</label>
									<div class="col-md-9">
										<input type="hidden" name="user_activated" value="0" />
										<div data-on="info" data-off="success" class="make-switch"><input name="user_activated" value="1" type="checkbox" {{ isset($data['user']->user_activated) && $data['user']->user_activated==1 ? ' checked="checked"' : '' }} class="switch"/></div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Policy seen</label>
									<div class="col-md-9">
										<input type="hidden" name="user_policy_seen" value="0" />
										<div data-on="info" data-off="success" class="make-switch"><input name="user_policy_seen" value="1" type="checkbox" {{ isset($data['user']->user_policy_seen) && $data['user']->user_policy_seen==1 ? ' checked="checked"' : '' }} class="switch"/></div>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Policy accepted</label>
									<div class="col-md-9">
										<input type="hidden" name="user_policy_accepted" value="0" />
										<div data-on="info" data-off="success" class="make-switch"><input name="user_policy_accepted" value="1" type="checkbox" {{ isset($data['user']->user_policy_accepted) && $data['user']->user_policy_accepted==1 ? ' checked="checked"' : '' }} class="switch"/></div>
									</div>
								</div>

								@if ( !empty($data['user']->user_id) )
								<div class="form-group">
									<label class="col-md-3 control-label">Created date</label>
									<div class="col-md-9">
										<input type="text" class="form-control" readonly="readonly" {{ isset($data['user']->created_at) ? 'placeholder="'.$data['user']->created_at.'"' : '' }} />
									</div>
								</div>

								<div class="form-group mbn">
									<label class="col-md-3 control-label">Updated date</label>
									<div class="col-md-9">
										<input  type="text" class="form-control" readonly="readonly" {{ isset($data['user']->updated_at) ? 'placeholder="'.$data['user']->updated_at.'"' : '' }} />
									</div>
								</div>
								@endif
								
							</div>
							<div class="form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn btn-primary">Save</button>&nbsp;<a href="/users" role="button" class="btn btn-green">Cancel</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">Images</div>
					<div class="panel-body pan">
						<form class="form-horizontal" method="post">
							<div class="form-body pal">
								<div class="form-group">
									<div class="col-md-3">
										<img src="http://api.mobstar.com/{{ $data['user']->user_profile_image }}" width="100%" />
									</div>
									<div class="col-md-9">
										<input type="file" />
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-3">
										<img src="http://api.mobstar.com/{{ $data['user']->user_cover_image }}" width="100%" />
									</div>
									<div class="col-md-9">
										<input type="file" />
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn btn-primary">Save</button>&nbsp;<a href="/users" role="button" class="btn btn-green">Cancel</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">Social</div>
					<div class="panel-body pan">
						<form class="form-horizontal" method="post">
							<div class="form-body pal">
								<div class="form-group">
									<label class="col-md-3 control-label">Google</label>
									<div class="col-md-9">
										@if (isset($data['user']->user_google_id) && !empty($data['user']->user_google_id))
											<button class="btn btn-primary">Clear connection</button>
										@else
											<input type="text" class="form-control" readonly="readonly" value="Not activated" />
										@endif
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Facebook</label>
									<div class="col-md-9">
										@if (isset($data['user']->user_facebook_id) && !empty($data['user']->user_facebook_id))
											<button class="btn btn-primary">Clear connection</button>
										@else
											<input type="text" class="form-control" readonly="readonly" value="Not activated" />
										@endif
									</div>
								</div>
								<div class="form-group">
									<label class="col-md-3 control-label">Twitter</label>
									<div class="col-md-9">
										@if (isset($data['user']->user_twitter_id) && !empty($data['user']->user_twitter_id))
											<button class="btn btn-primary">Clear connection</button>
										@else
											<input type="text" class="form-control" readonly="readonly" value="Not activated" />
										@endif
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			@if ( isset($data['stars']) && ! $data['stars']->isEmpty() )
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">Stars</div>
					<div class="panel-body pan">
						<div class="form-body pal">

							<div class="list-group mbn">
							@foreach ($data['stars'] as $star)
								<a href="/user/{{ $star->user_id }}" class="list-group-item">
									<p class="list-group-item-text">{{ /*$star->user_display_name*/ getusernamebyid($star->user_id) }}</p>
								</a>
							@endforeach
							</div>

						</div>
					</div>
				</div>
			</div>
			@endif

			
			@if ( isset($data['entries']) && ! $data['entries']->isEmpty() )				
			<div class="col-lg-12">
				<div class="panel panel-green">
					<div class="panel-heading">Entries</div>
					<div class="panel-body">
						<div class="row">
							
							@foreach($data['entries'] as $entry)
							<div class="col-lg-3">
								<div><img src="http://lorempixel.com/640/480/business/1/" class="img-responsive"/>
									<h3>{{ $entry->entry_name }}</h3>
									<p>{{ $entry->entry_description }}</p>
									<a href="/entry/{{ $entry->entry_id }}" role="button" class="btn btn-green">Go to</a>
								</div>
							</div>
							@endforeach

						</div>
					</div>
				</div>
			</div>
			@endif

		</div>
	</div>

@stop