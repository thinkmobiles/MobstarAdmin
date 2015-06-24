@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Entry Note</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div id="form-layouts" class="row">
			<div class="col-lg-6">
				<div class="panel panel-green">
					<div class="panel-heading">{{ empty($data['entry']->entry_note) ? 'Add' : 'Edit' }} Entry Note</div>
					<div class="panel-body pan">
						<form class="form-horizontal" method="post" enctype="multipart/form-data">
							@if ( !empty($data['entry']->entry_id) )
							<input type="hidden" name="entry_id" value="{{ $data['entry']->entry_id }}" />
							@endif
							<div class="form-body pal">
								<div class="form-group">
									<label for="entryNote" class="col-md-3 control-label">Entry Note</label>
									<div class="col-md-9">
										<textarea name="entryNote" id="entryNote" rows="3" class="form-control">{{ isset($data['entry']->entry_id) ? $data['entry']->entry_note : '' }}</textarea>
									</div>
								</div>
								
								<!-- 
								<div class="form-group mbn">
									<label for="inputDescription" class="col-md-3 control-label">Description</label>
									<div class="col-md-9">
										<textarea name="txDescription" id="inputDescription" rows="3" class="form-control">{{ isset($data['defaultNotification']->txDescription) ? $data['defaultNotification']->txDescription : '' }}</textarea>
									</div>
								</div> -->
								
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
		</div>
	</div>

@stop