@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Messages</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div class="row">
			<div class="col-lg-12">
				<!--<p><a href="/message/add" role="button" class="btn btn-green">Add message</a></p>-->

				<div class="list-group mail-box">
					
					@foreach($data['messages'] as $message)
					<a href="/message/{{ $message->message_id }}" class="list-group-item">
						<!--<input type="checkbox"/>-->
						<span class="fa fa-star-o mrm mlm"></span>
						<span style="min-width: 120px; display: inline-block;" class="name">{{ $message->user_display_name }}</span>
						<span>{{ str_limit($message->message_body, $limit = 40, $end = '...') }}</span>
						<span class="time-badge"><?php echo date('H:i:s d/m/Y', strtotime($message->message_created_date)); ?></span>
					</a>
					@endforeach

				</div>
				<?php echo (!isset($_GET['showAll'])) ? $data['messages']->links() : ""; ?>
			</div>
		</div>
	</div>

@stop