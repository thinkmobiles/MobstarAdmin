@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Tag</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div id="form-layouts" class="row">
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">{{ empty($data['tag']->tag_id) ? 'Add' : 'Edit' }} tag</div>
					<div class="panel-body pan">
						<form class="form-horizontal" method="post">
							@if ( !empty($data['tag']->tag_id) )
							<input type="hidden" name="tag_id" value="{{ $data['tag']->tag_id }}" />
							@endif
							<div class="form-body pal">
								
								<div class="form-group mbn">
									<label for="inputName" class="col-md-3 control-label">Tag <span class='require'>*</span></label>
									<div class="col-md-9">
										<input id="inputName" name="tag_name" type="text" placeholder="Tag" class="form-control" {{ isset($data['tag']->tag_name) ? "value=\"".$data['tag']->tag_name."\"" : '' }} />
									</div>
								</div>

							</div>
							<div class="form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn btn-primary">Save</button>&nbsp;<a href="/tags" role="button" class="btn btn-green">Cancel</a>&nbsp;
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		@if ( !empty($data['tag']->tag_id) )
		<div id="form-layouts" class="row">
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">Actions</div>
					<div class="panel-body pan">
						<form class="form-horizontal" method="post">
							<div class="form-actions">
								<div class="col-md-offset-3 col-md-9">
									<!--<button type="button" data-target="#modal-combine" data-toggle="modal" class="btn btn-blue">Combine</button>&nbsp;--><button type="button" data-target="#modal-delete" data-toggle="modal" class="btn btn-red">Delete</button>
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
						<h4 id="modal-default-label" class="modal-title">Delete tag</h4></div>
					<div class="modal-body">Deleting this tag will remove it from all entries tagged with it.</div>
					<div class="modal-footer">
						<button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
						<button type="button" id="delete_item" class="btn btn-primary">Delete</button>
					</div>
				</div>
			</div>
		</div>

		<div id="modal-combine" tabindex="-1" role="dialog" aria-labelledby="modal-prompt-label" aria-hidden="true" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" data-dismiss="modal" aria-hidden="true" class="close">&times;</button>
						<h4 id="modal-prompt-label" class="modal-title">Combine tag</h4></div>
					<div class="modal-body">
						<p>Select the tag which you want this tag to be combined with.</p>
						<select name="combine_tags" class="form-control">
							<option value="none">Select a tag</option>
							@foreach($data['tags'] as $tag)
							<option value="{{ $tag->tag_id }}">{{ $tag->tag_name }}</option>
							@endforeach
						</select>

					</div>
					<div class="modal-footer">
						<button type="button" data-dismiss="modal" class="btn btn-default">Close</button>
						<button type="button" id="combine_item" class="btn btn-primary">OK</button>
					</div>
				</div>
			</div>
		</div>
		@endif


	</div>
@stop

@section('pagefoot')

@if ( !empty($data['tag']->tag_id) )
<script type="text/javascript">

	$('#delete_item').click(function(){

		var post = {id:"{{ $data['tag']->tag_id }}"};
		// alert('red');
		$.post('/tag/delete', post, function(data)
		{
			window.location.replace('/tags');
		});
		return false;

	});

	$('#combine_item').click(function(){

		var new_id_var = $("select[name='combine_tags']").val()
		var post = {id:"{{ $data['tag']->tag_id }}", new_id: new_id_var};
		// alert('red');
		$.post('/tag/combine', post, function(data)
		{
			window.location.replace('/tag/'+new_id_var);
		});
		return false;

	});

</script>
@endif

@stop