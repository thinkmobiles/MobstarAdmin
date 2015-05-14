@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Send Message</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div id="form-layouts" class="row">
			<div class="col-lg-9">
				<div class="panel panel-green">
					<div class="panel-heading">Send Message</div>
					<div class="panel-body pan">
					@if(Session::has('message'))
						<div class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</div>
					@endif
						{{ Form::open(array('url' => 'users/sendpushmessage','class'=>'form-horizontal')) }}
						<div class="form-body pal">
							<div class="form-group">
								{{ Form::label('message', 'Send Message', array('class' => 'col-md-3 control-label')) }}
								<div class="col-md-9">
									{{ Form::textarea('message', '',array('class'=>'form-control','placeholder'=>'Message')) }}
								</div>
							</div>

							<div class="form-actions">
								<div class="col-md-offset-3 col-md-9">
									{{ Form::submit('Send',array('class'=>'btn btn-primary')) }}
								</div>
							</div>							
						</div>
    					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
<div>
@stop