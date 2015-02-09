@extends('layout')

@section('content')

<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Comments</div>
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="page-content">
		<div class="row">
			<div class="col-lg-12">
			@if(count($data['comment']) > 0)
				<div class="list-group">
					@foreach($data['comment'] as $comment)
					<div class="row" id="row-{{$comment->comment_id}}">
						<div class="col-lg-8 col-xs-8 col-mg-8">
							<h4 class="list-group-item-heading">{{ getusernamebyid($comment->comment_user_id) }}</h4>
							<p class="list-group-item-text" id="comment-{{$comment->comment_id}}">{{ $comment->comment_content }}</p>
							{{Form::text('comment_content',"$comment->comment_content",array('style'=>"display:none;","id"=>"text-$comment->comment_id","class"=>"form-control"))}}
						</div>
						<div class="col-lg-4 col-xs-4 col-mg-4">
							@if($comment->comment_deleted == 0)
							<span class="btn btn-success disable" data-id="{{$comment->comment_id}}" id="span-disable-{{$comment->comment_id}}">Disable</span>
							@else
							<span class="btn btn-warning enable" data-id="{{$comment->comment_id}}" id="span-enable-{{$comment->comment_id}}">Enable</span>
							@endif
							<span class="btn btn-info edit" data-id="{{$comment->comment_id}}" id="span-edit-{{$comment->comment_id}}">Edit</span>
							<span class="btn btn-info save" data-id="{{$comment->comment_id}}" id="span-save-{{$comment->comment_id}}" style="display:none">Save</span>
							<span class="btn btn-danger delete" data-id="{{$comment->comment_id}}" id="span-delete-{{$comment->comment_id}}">Delete</span>
						</div>
						<div class="clear"><p>&nbsp;</p></div>
					</div>	
					@endforeach
				</div>
				@else
					<span class="btn btn-warning">No Comment found for clicked entry.</span>
				@endif
			</div>
		</div>
	</div>

<script>
	$('.disable').click(function(){
		//alert('disable');
		var id = $(this).data('id');
			$.ajax({
				url:"../../comment/setstatus",
				type:"POST",
				data:{id:id},
				dataType: "json",
				success:function(data)
				{
					resp = $.parseJSON(JSON.stringify(data));
					//alert(resp.code);
					if(resp.code === "1")
					{
						$('#span-disable-'+id).removeClass('btn-success disable');
						$('#span-disable-'+id).addClass('btn-warning enable');
						$('#span-disable-'+id).html('Enable');
						$('#span-disable-'+id).attr('id','span-enable-'+id);
					}
					else
					{
						$('#span-enable-'+id).removeClass('btn-warning enable');
						$('#span-enable-'+id).addClass('btn-success disable');
						$('#span-enable-'+id).html('Disable');
						$('#span-enable-'+id).attr('id','span-disable-'+id);
					}
					
				},
				error:function(e)
				{
					console.log(e.message);
				}
			});

	});

	$('.enable').click(function(){
		//alert('enable');
		var id = $(this).data('id');
		$.ajax({
				url:"../../comment/setstatus",
				type:"POST",
				data:{id:id},
				dataType: "json",
				success:function(data)
				{
					resp = $.parseJSON(JSON.stringify(data));
					//alert(resp.code);
					if(resp.code === "0")
					{
						$('#span-enable-'+id).removeClass('btn-warning enable');
						$('#span-enable-'+id).addClass('btn-success disable');
						$('#span-enable-'+id).html('Disable');
						$('#span-enable-'+id).attr('id','span-disable-'+id);
					}
					else
					{
						$('#span-disable-'+id).removeClass('btn-success disable');
						$('#span-disable-'+id).addClass('btn-warning enable');
						$('#span-disable-'+id).html('Enable');
						$('#span-disable-'+id).attr('id','span-enable-'+id);
					}
					// $('#span-enable-'+id).removeClass('btn-warning enable');
					// $('#span-enable-'+id).addClass('btn-success disable');
					// $('#span-enable-'+id).html('Disable');
					// $('#span-enable-'+id).attr('id','span-disable-'+id);
					
				},
				error:function(e)
				{
					console.log(e.message);
				}
			});
		
	});

	$('.edit').click(function(){
		var id = $(this).data('id');
		$('#comment-'+id).hide();
		$('#text-'+id).show();
		$(this).hide();
		$(this).next().show();
	});

	$('.save').click(function(){

		var id = $(this).data('id');
		var comment = $('#text-'+id).val();
		var current = this;
	
		if(comment !='')
		{
			$.ajax({
				url:"../../comment/savecomment",
				type:"POST",
				data:{id:id,comment:comment},
				dataType: "json",
				success:function(data)
				{
					resp = $.parseJSON(JSON.stringify(data));
					//alert(resp.code);
					if(resp.code === "1")
					{
						$('#text-'+id).hide();
						$('#comment-'+id).html(comment).show();
						$(current).hide();
						$(current).prev().show();
					}
					
				},
				error:function(e)
				{
					console.log(e.message);
				}
			});
		}
		else
		{
			$('#text-'+id).hide();
			$('#comment-'+id).show();
			$(this).hide();
			$(this).prev().show();
		}	
		
	});

	$('.delete').click(function(){
		var id = $(this).data('id');
		if(confirm('Are you sure, you want to delete this comment ?'))
		{
			$.ajax({
					url:"../../comment/delete",
					type:"POST",
					data:{id:id},
					dataType: "json",
					success:function(data)
					{
						resp = $.parseJSON(JSON.stringify(data));
						if(resp.code === "1")
						{
							$( ".hello" ).remove();
							$('#row-'+id).remove();
						}
					},
					error:function(e)
					{
						console.log(e.message);
					}
			});
		}
		
	});
</script>

@stop
