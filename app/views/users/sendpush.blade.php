@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Send Notification</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div id="form-layouts" class="row">
			<div class="col-lg-9">
				<div class="panel panel-green">
					<div class="panel-heading">Send Push Message</div>
					<div class="panel-body pan">
					@if(Session::has('message'))
						<div class="alert {{ Session::get('alert-class') }}">{{ Session::get('message') }}</div>
					@endif
						{{ Form::open(array('url' => 'users/sendpushmessage','class'=>'form-horizontal')) }}
						<div class="form-body pal">
							<div class="form-group">
								<!--<div><h4><input type='checkbox' id='selectall' name="selectall" />  Select All</h4></div>-->
								<div><h4><input type='checkbox' id='2' name="selectModerator" />  Moderator</h4></div>
								<div><h4><input type='checkbox' id='3' name="selectUser" />  User</h4></div>
								<div><h4><input type='checkbox' id='4' name="selectTeam" />  Team</h4></div>
								<div><h4><input type='checkbox' id='5' name="selectMentor" />  Mentor</h4></div>
							</div>
							<div class="form-group">
								{{ Form::label('message', 'Send Push Notification Message', array('class' => 'col-md-3 control-label')) }}
								<div class="col-md-9">
									{{ Form::textarea('message', '',array('class'=>'form-control','placeholder'=>'Push Notification Message')) }}
								</div>
							</div>

							<div class="form-actions">
								<div class="col-md-offset-3 col-md-9">
									{{ Form::submit('Send',array('class'=>'btn btn-primary')) }}
								</div>
							</div>
							<!--<div class="form-group">
								<h4><input type='checkbox' id='selectall' name="selectall" />  Select All</h4>
								<div class="list-group">
									@foreach($data['users'] as $user)

										<h4 class="list-group-item">
										<input type='checkbox' class='case' id="{{ $user->user_id }}" name='checkbox[]' value='{{ $user->user_id }}'>
											{{ $user->user_display_name }}</h4>

									@endforeach
								</div>	
								<?php //echo (!isset($_GET['showAll'])) ? $data['users']->links() : ""; ?>
								</div>-->
						</div>
    					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
<script type="text/javascript">

// var $a = $.noConflict();
 	$('document').ready(function () 
 	{	
 		$('#selectall').on('ifChecked ifUnchecked', function(event) {
	        if (event.type == 'ifChecked') {
	            $('.list-group input[type="checkbox"]').iCheck('check');
	            //$('.case').iCheck('check');
	        } else {
	            $('.list-group input[type="checkbox"]').iCheck('uncheck');
	        }
    	});
    	$('#selectModerator').on('ifChecked ifUnchecked', function(event) {
	        if (event.type == 'ifChecked') {
	            $('.list-group input[class="case2"]').iCheck('check');
	        } else {
	            $('.list-group input[class="case2"]').iCheck('uncheck');
	        }
    	});
    	$('#selectUser').on('ifChecked ifUnchecked', function(event) {
	        if (event.type == 'ifChecked') {
	            $('.list-group input[class="case3"]').iCheck('check');
	        } else {
	            $('.list-group input[class="case3"]').iCheck('uncheck');
	        }
    	});
    	$('#selectTeam').on('ifChecked ifUnchecked', function(event) {
	        if (event.type == 'ifChecked') {
	            $('.list-group input[class="case4"]').iCheck('check');
	        } else {
	            $('.list-group input[class="case4"]').iCheck('uncheck');
	        }
    	});
    	$('#selectMentor').on('ifChecked ifUnchecked', function(event) {
	        if (event.type == 'ifChecked') {
	            $('.list-group input[class="case5"]').iCheck('check');
	        } else {
	            $('.list-group input[class="case5"]').iCheck('uncheck');
	        }
    	});

});

</script>
@stop