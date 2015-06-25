@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Fashion Entry</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div id="form-layouts" class="row">
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">{{ empty($data['entry']->entry_id) ? 'Add' : 'Edit' }} entry</div>
					<div class="panel-body pan">
						<form class="form-horizontal" method="post">
							@if ( !empty($data['entry']->entry_id) )
							<input type="hidden" name="entry_id" value="{{ $data['entry']->entry_id }}" />
							@endif
							<div class="form-body pal">
								
								<div class="form-group">
									<label for="inputUserGroup" class="col-md-3 control-label">User Group</label>
									<div class="col-md-9">
										<div class="input-group">
											<select id="inputUserGroup" class="form-control" name="entry_user_id">
											@foreach($data['users'] as $user)
											<option value="{{ $user->user_id }}" @if (isset($data['entry']->entry_user_id) && $user->user_id === $data['entry']->entry_user_id)selected="selected"@endif>{{ $user->user_display_name }}</option>
											@endforeach
											</select>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="inputUserGroup" class="col-md-3 control-label">Category</label>
									<div class="col-md-9">
										<div class="input-group">
											<select id="inputUserGroup" class="form-control" name="entry_category_id">
											@foreach($data['categories'] as $category)
											<option value="{{ $category->category_id }}" @if (isset($data['entry']->entry_category_id) && $category->category_id === $data['entry']->entry_category_id)selected="selected"@endif>{{ $category->category_name }}</option>
											@endforeach
											</select>
										</div>
									</div>
								</div>
								
								<div class="form-group">
									<label class="col-md-3 control-label">Deleted</label>
									<div class="col-md-9">
										<input type="hidden" name="entry_deleted" value="0" />
										<div data-on="info" data-off="success" data-on-label="Yes" data-off-label="No" class="make-switch"><input name="entry_deleted" value="1" type="checkbox" {{ isset($data['entry']) && $data['entry']->entry_deleted==1 ? ' checked="checked"' : '' }} class="switch"/></div>
									</div>
								</div>

								<div class="form-group">
									<label for="inputUserGroup" class="col-md-3 control-label">User Group</label>
									<div class="col-md-9">
										<div class="input-group">
											<select id="inputUserGroup" class="form-control" name="">
												
												<option value="video" @if (isset($data['entry']->entry_category_id) && 'video' === $data['entry']->entry_type)selected="selected"@endif>Video</option>
												<option value="image" @if (isset($data['entry']->entry_category_id) && 'image' === $data['entry']->entry_type)selected="selected"@endif>Image</option>
												<option value="audio" @if (isset($data['entry']->entry_category_id) && 'audio' === $data['entry']->entry_type)selected="selected"@endif>Audio</option>
											
											</select>
										</div>
									</div>
								</div>

								<div class="form-group">
									<label for="inputEntryName" class="col-md-3 control-label">Name <span class='require'>*</span></label>
									<div class="col-md-9">
										<input id="inputEntryName" name="entry_name" type="text" placeholder="Name" class="form-control" {{ isset($data['entry']->entry_name) ? 'value='.$data['entry']->entry_name.'' : '' }} />
									</div>
								</div>

								<div class="form-group">
									<label for="inputEntryDescription" class="col-md-3 control-label">Description</label>
									<div class="col-md-9">
										<textarea name="entry_description" id="inputEntryDescription" rows="3" class="form-control">{{ isset($data['entry']->entry_description) ? $data['entry']->entry_description : '' }}</textarea>
									</div>
								</div>

								<div class="form-group">
									<label for="inputEntryRank" class="col-md-3 control-label">Rank</label>
									<div class="col-md-9">
										<input id="inputEntryRank" name="entry_rank" type="text" placeholder="Rank" class="form-control" {{ isset($data['entry']->entry_rank) ? 'value='.$data['entry']->entry_rank.'' : '' }} />
									</div>
								</div>

								<div class="form-group">
									<label for="inputEntryLanguage" class="col-md-3 control-label">Language</label>
									<div class="col-md-9">
										<input id="inputEntryLanguage" name="entry_language" type="text" placeholder="Language" class="form-control" {{ isset($data['entry']->entry_language) ? 'value='.$data['entry']->entry_language.'' : '' }} />
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-3 control-label">Created date</label>
									<div class="col-md-9">
										<input type="text" class="form-control" readonly="readonly" {{ isset($data['entry']->entry_created_date) ? 'placeholder="'.$data['entry']->entry_created_date.'"' : '' }} />
									</div>
								</div>

								<div class="form-group mbn">
									<label class="col-md-3 control-label">Modified date</label>
									<div class="col-md-9">
										<input  type="text" class="form-control" readonly="readonly" {{ isset($data['entry']->entry_modified_date) ? 'placeholder="'.$data['entry']->entry_modified_date.'"' : '' }} />
									</div>
								</div>

							</div>

							<div class="form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn btn-primary">Save</button>&nbsp;<a href="../fashionEntries" role="button" class="btn btn-green">Cancel</a>
								</div>
							</div>

						</form>
					</div>
				</div>
			</div>

			@if (! $data['tags']->isEmpty() )
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">Tags</div>
					<div class="panel-body pan">
						<div class="form-body pal">

							<div class="list-group mbn">
							@foreach ($data['tags'] as $tag)
								<a href="/tag/{{ $tag->tag_id }}" class="list-group-item">
									<p class="list-group-item-text">{{ $tag->tag_name }}</p>
								</a>
							@endforeach
							</div>

						</div>
					</div>
				</div>
			</div>
			@endif

			@if (! $data['reports']->isEmpty() )
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">Reports</div>
					<div class="panel-body pan">
						<div class="form-body pal">

							<div class="list-group mbn">
							@foreach ($data['reports'] as $report)
								<a href="/report/{{ $report->entry_report_id }}" class="list-group-item">
									<p class="list-group-item-text">{{ $report->entry_report_report_reason }}</p>
								</a>
							@endforeach
							</div>

						</div>
					</div>
				</div>
			</div>
			@endif

		</div>
	</div>


@stop