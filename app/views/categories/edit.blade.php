@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Category</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div id="form-layouts" class="row">
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">{{ empty($data['category']->category_id) ? 'Add' : 'Edit' }} category</div>
					<div class="panel-body pan">
						<form class="form-horizontal" method="post" enctype="multipart/form-data">
							@if ( !empty($data['category']->category_id) )
							<input type="hidden" name="category_id" value="{{ $data['category']->category_id }}" />
							@endif
							<div class="form-body pal">
								<div class="form-group">
									<label for="inputCategoryName" class="col-md-3 control-label">Name <span class='require'>*</span></label>
									<div class="col-md-9">
										<input id="inputCategoryName" name="category_name" type="text" placeholder="Name" class="form-control" {{ isset($data['category']->category_name) ? "value=\"".$data['category']->category_name."\"" : '' }} />
										@if (isset($data['errors']))
											<p style="color: red;">{{ $data['errors']->getMessages()['category_name']['0'] }}</p>
										@endif
									</div>
								</div>
								@if ( !empty($data['category']->category_id) && !in_array($data['category']->category_id,array(7,8)) )
								<div class="form-group">
									<label class="col-md-3 control-label">Status</label>
									<div class="col-md-9">
										<input type="hidden" name="category_active" value="0" />
										<div data-on="info" data-off="success" class="make-switch"><input name="category_active" value="1" type="checkbox" {{ isset($data['category']) && $data['category']->category_active==1 ? ' checked="checked"' : '' }} class="switch"/></div>
									</div>
								</div>
								@endif
								<div class="form-group mbn">
									<label for="inputCategoryDescription" class="col-md-3 control-label">Description</label>
									<div class="col-md-9">
										<textarea name="category_description" id="inputCategoryDescription" rows="3" class="form-control">{{ isset($data['category']->category_description) ? $data['category']->category_description : '' }}</textarea>
									</div>
								</div>
								<div class="form-group">
									<label for="inputCategoryIcon" class="col-md-3 control-label">Icon</label>
									<div class="col-md-9">
									@if (!empty($data['category']->category_icon))
										<div class="colorbg">
											<img src="../../{{ $data['category']->category_icon }}" width="100%" />
										</div>	
									@endif
									<input type="file" name="category_icon"/>
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn btn-primary">Save</button>&nbsp;<a href="/categories" role="button" class="btn btn-green">Cancel</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		@if ( !empty($data['category']->category_id) && !in_array($data['category']->category_id,array(7,8)) )
		
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
									@if (!isset($data['entries_count']) || $data['entries_count']== 0)
									<button type="button" data-target="#modal-delete" data-toggle="modal" class="btn btn-red">Delete</button>
									@else
									<p>Categories need to be empty before you can delete them.</p>
									@endif
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
						<h4 id="modal-default-label" class="modal-title">Delete category</h4></div>
					<div class="modal-body">You are about to permanently delete this category.</div>
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

@if ( !empty($data['category']->category_id) )
<script type="text/javascript">

	$('#delete_item').click(function(){

		var post = {id:"{{ $data['category']->category_id }}"};
		// alert('red');
		$.post('/category/delete', post, function(data)
		{
			window.location.replace('/categories');
		});
		return false;

	});

</script>
@endif

@stop