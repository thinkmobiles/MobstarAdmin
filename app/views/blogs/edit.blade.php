@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Blog</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div id="form-layouts" class="row">
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">{{ empty($data['blogs']->iBlogId) ? 'Add' : 'Edit' }} blog</div>
					<div class="panel-body pan">
						<form class="form-horizontal" method="post" enctype="multipart/form-data">
							@if ( !empty($data['blogs']->iBlogId) )
							<input type="hidden" name="iBlogId" value="{{ $data['blogs']->iBlogId }}" />
							@endif
							<div class="form-body pal">

								<div class="form-group">
									<label for="inputBlogTitle" class="col-md-3 control-label">Title<span class='require'>*</span></label>
									<div class="col-md-9">
										<input id="inputBlogTitle" name="vBlogTitle" type="text" placeholder="Blog Title" class="form-control" {{ isset($data['blogs']->vBlogTitle) ? "value=\"".$data['blogs']->vBlogTitle."\"" : '' }} />
									</div>
								</div>
								
								<div class="form-group">
									<label for="inputBlogImage" class="col-md-3 control-label">Image</label>
									<div class="col-md-9">
									
									@if (!empty($data['blogs']->vBlogImage))
										<div class="colorbg">
											<img src="../{{ $data['blogs']->vBlogImage }}" width="100%"/>
										</div>
									@endif
									<input type="file" name="vBlogImage"/>
									</div>
								</div>
								<div class="form-group">
									<label for="inputBlogHeader" class="col-md-3 control-label">Header</label>
									<div class="col-md-9">
										<input id="inputBlogHeader" name="vBlogHeader" type="text" placeholder="Blog Header" class="form-control" {{ isset($data['blogs']->vBlogHeader) ? "value=\"".$data['blogs']->vBlogHeader."\"" : '' }} />
									</div>
								</div>
								<div class="form-group mbn">
									<label for="inputBlogText" class="col-md-3 control-label">Description</label>
									<div class="col-md-9">
										<textarea name="txDescription" id="inputBlogText" rows="3" class="form-control">{{ isset($data['blogs']->txDescription) ? $data['blogs']->txDescription : '' }}</textarea>
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="col-md-offset-3 col-md-9">
									<button type="submit" class="btn btn-primary">Save</button>&nbsp;<a href="blogs" role="button" class="btn btn-green">Cancel</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		
	</div>
@stop 