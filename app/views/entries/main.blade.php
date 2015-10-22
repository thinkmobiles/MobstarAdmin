@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Entries</div>
		</div>
		<div class="clearfix"></div>
	</div>

<!-- <p><a href="/entry/add" role="button" class="btn btn-green">Add entry</a></p> -->

<?php //echo $data['entries']->links(); ?>

<?php
$categoryById = array(
    0 => 'No category',
);
foreach( $data['categories'] as $category )
{
    $categoryById[ $category->category_id ] = $category->category_name;
}
?>

<style type='text/css'>
.flex-container > .flex-child {
    height: auto;
}
</style>

<div class="page-content">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel">
							<div class="panel-body">

							    <div class="panel panel-green">

                                    <div class="panel-heading">Filter Entries</div>


							       <form method="get" action="/entries">
							        <?php
							            if(isset($_GET['orderBy']))
							                $selected = $_GET['orderBy'];
							            else
							                $selected = 'latest';
							        ?>

                                        <div class="form-group">
                                            <label for="orderBy" class="col-md-2 control-label">Sort</label>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                <select id="orderBy" class="form-control"  name="orderBy">
                                                    <option value="latest" <?php echo ($selected == 'latest') ? "selected" : "" ?>>Latest</option>
                                                    <option value="popular" <?php echo ($selected == 'popular') ? "selected" : "" ?>>Most Popular</option>
                                                </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="cat" class="col-md-2 control-label">Category</label>
                                            <div class="col-md-2">
                                                <div class="input-group">
                                                <select id="cat" class="form-control" name="category">
                                                    <?php
                                                        if(isset($_GET['category']))
                                                            $selected = $_GET['category'];
                                                        else
                                                            $selected = 'latest';
                                                    ?>
                                                    <!--  <option></option> -->
                                                    <option value="All" <?php echo ($selected == 'All') ? 'selected' : '' ?>>All</option>
                                                    @foreach($data['categories'] as $category)
                                                        <option value="{{$category->category_id}}" <?php echo ($selected == $category->category_id) ? "selected" : "" ?>>{{$category->category_name}}</option>
                                                    @endforeach

                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                                <label for="deleted" class="col-md-2 control-label">Status</label>
                                                <div class="col-md-2">
                                                    <div class="input-group">
                                                        <select id="deleted" class="form-control" name="deleted">
                                                        <?php
                                                            if(isset($_GET['deleted']))
                                                                $selected = $_GET['deleted'];
                                                            else
                                                                $selected = 0;
                                                        ?>
                                                            <option value="0" <?php echo ($selected == 0) ? "selected" : "" ?>>All</option>
                                                            <option value="1" <?php echo ($selected == 1) ? "selected" : "" ?>>Enabled</option>
                                                            <option value="2" <?php echo ($selected == 2) ? "selected" : "" ?>>Disabled</option>
                                                        </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                        <div class="col-md-2">
							                <input type="submit" class="btn btn-default" value="Filter">
                                        </div>
                                        </div>
							       </form>
							    </div>



									<div class="flex-container">

										@foreach($data['entries'] as $entry)
											<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 flex-child"><!--<img/>-->
													@if($entry['entry_type'] !='image')
													<div class = "media-thumb">
														<video class="video-js vjs-default-skin" controls preload="metadata" poster="{{$entry['entry_image']}}" >
															<source src="{{$entry['entry_file']}}" type="video/mp4">
															Your browser does not support the video tag.
														</video>
													</div>
													@else
													<div class = "media-thumb">
														<img src="{{$entry['entry_file']}}" />
													</div>
													@endif
												<!--<data></data>-->
													<p class="date">{{date('d-m-Y H:i:s', strtotime($entry['entry_date']))}}</p>
												<!--	<p class="title"><a href='/entry/{{$entry['entry_id']}}'>{{$entry['entry_name']}} - {{$entry['entry_description']}}</a></p> -->
													<p class="title"><a href='/entry/{{$entry['entry_id']}}'><?php echo App::make("EntriesController")->ellipsis($entry['entry_name'].'-'.$entry['entry_description'],22); ?></a></p>
													<p class="like">{{$entry['entry_up_votes']}} Up votes - {{$entry['entry_down_votes']}} Down votes</p>
													<p class="like">{{$entry['entry_views_total']}} total views ({{$entry['entry_views']}} real, {{$entry['entry_views_added']}} added)</p>
													<!--@if($entry['entry_uploaded_on_youtube'] != 0)
														<a class="delete btn btn-warning toggle" id="{{$entry['entry_id']}}">Delete Youtube Entry</a>
													@else
														<a class="upload btn btn-success toggle" id="{{$entry['entry_id']}}">Upload Youtube Entry</a>
													@endif -->
													@if ( $entry['entry_category_id'] == 7 )
													<p class="like">Profile category - {{isset( $categoryById[$entry['entry_profile_category_id']]) ? $categoryById[$entry['entry_profile_category_id']] : 'unknown'}}
													@endif
													@if($entry['entry_type'] =='video' && $entry['entry_category_id'] != 7 && $entry['entry_category_id'] != 8 )
														@if($entry['entry_uploaded_on_youtube'] != 0)
															<p><a class="deleteVideo twice" id="{{$entry['entry_id']}}"><img class="actionIcon" src="images/delete_icon.png" style=" width: auto!important;">Delete Youtube Entry</a></p>
														<!--	<a class="delete btn btn-warning toggle" id="{{$entry['entry_id']}}">Delete Youtube Entry</a> -->
														@else
															<p><a class="uploadVideo twice" id="{{$entry['entry_id']}}"><img class="actionIcon" src="images/upload_icon.png" style=" width: auto!important;">Upload Youtube Entry</a></p>
														<!--	<a class="upload btn btn-success toggle" id="{{$entry['entry_id']}}">Upload Youtube Entry</a> -->
														@endif
													@endif
													<a class="btn btn-info" id="{{$entry['entry_id']}}" href="comment/entry/{{$entry['entry_id']}}">View Comments</a>

                                                    @if($entry['entry_deleted'] == 0)
                                                        <a class="disable btn btn-warning toggle" id="{{$entry['entry_id']}}">Disable</a>
                                                    @else
                                                        <a class="restore btn btn-success toggle" id="{{$entry['entry_id']}}">Enable</a>
                                                    @endif
                                                    <a class="deletebtn btn btn-danger" id="{{$entry['entry_id']}}">Delete</a>
                                                    @if($entry['entry_hide_on_feed'] == 0)
                                                        <a class="hide-on-feed btn btn-warning" id="{{$entry['entry_id']}}">Hide on feed</a>
                                                    @else
                                                        <a class="show-on-feed btn btn-success" id="{{$entry['entry_id']}}">Show on feed</a>
                                                    @endif
											</div>
										@endforeach

									</div>

									{{$data['pages']}}
							</div>
						</div>
					</div>
				</div>
			</div>

			<script>
            $('.toggle').click(function(){
            var id = $(this).attr('id');

            if($(this).hasClass("disable"))
            {

                $.ajax({
                    url: '/delete/'+id,
                    type: 'GET'
                }
                ).done(function(){
                $('a#'+id+'.disable').removeClass('disable btn-warning').addClass('restore btn-success').text("Enable Entry");
                });
            }
            else if($(this).hasClass("restore"))
            {

            $.ajax({
                url: '/restoreentry/'+id,
                type: 'GET'
            }
            ).done(function(){
            $('a#'+id+'.restore').removeClass('restore btn-success').addClass('disable btn-warning').text("Disable Entry");
            });


            }
            });

            (function() {

                var noHandler = function(e) {
                    e.preventDefault();
                }


                var enable = function( el, whatToShow ) {
                    el.removeClass( 'disabled' );
                    if( whatToShow == 'show' ) {
                        el.removeClass('hide-on-feed btn-warning')
                            .addClass('show-on-feed btn-success')
                            .text('Show on feed')
                            .off( 'click', noHandler )
                            .on( 'click', showHandler );
                    } else {
                        el.removeClass('show-on-feed btn-success')
                            .addClass('hide-on-feed btn-warning')
                            .text('Hide on feed')
                            .off( 'click', noHandler )
                            .on( 'click', hideHandler );
                    }
                }


                var disable = function( el ) {
                    el.addClass('disabled')
                        .off( 'click', hideHandler )
                        .off( 'click', showHandler )
                        .on( 'click', noHandler );
                }


                var hideHandler = function() {

                    var self = $(this);

                    var entryId = self.attr('id');

                    disable( self );

                    $.ajax({
                        url: 'entry/'+entryId+'/hide_on_feed',
                        type: 'POST'
                    })
                    .done( enable.bind( null, self, 'show' ) )
                    .error( enable.bind( null, self, 'hide' ) );
                };


                var showHandler = function() {

                    var self = $(this);

                    var entryId = self.attr('id');

                    disable( self );

                    $.ajax({
                        url: 'entry/'+entryId+'/show_on_feed',
                        type: 'POST'
                    })
                    .done( enable.bind( null, self, 'hide' ) )
                    .error( enable.bind( null, self, 'show' ) );
                };

                $('.hide-on-feed').click( hideHandler );
                $('.show-on-feed').click( showHandler );
            })();



            $('.deletebtn').click(function(){
                var id = $(this).attr('id');
                if(confirm('Are you sure, you want to delete this feed ? Also necessary feed related things also get deleted.'))
                {
                    var t = $(this);
                    $.ajax({
                    url: 'entry/delete/'+id,
                    type: 'POST'
                    }
                    ).done(function(){
                        t.parent().remove();
                    });
                }
                else
                {
                    return false;
                }
            });
			//Youtube upload
			$('.twice').click(function(){
				var id = $(this).attr('id');

				if($(this).hasClass("deleteVideo"))
				{
					if(confirm("Are you sure you want to delete this entry from youtube ?"))
					{
						alert('perform delete action');
						//var id = $('.onyoutube').val();
						$.ajax({
							url: 'entry/youtubedelete/'+id,
							type:'POST'
						}).done(function(eId){
							alert('Video deleted successfully from youtube');
							//$('a#'+id+'.delete').removeClass('delete btn-warning').addClass('upload btn-success').text("Upload Youtube Entry");
							$('a#'+id+'.deleteVideo').removeClass('deleteVideo').addClass('uploadVideo').html("<img class='actionIcon' src='images/upload_icon.png' style=' width: auto!important;'>Upload Youtube Entry");
							//alert('Video uploaded successfully.');
						});
					}
					else
					{
						return false;
					}
				}
				else if($(this).hasClass("uploadVideo"))
				{
					if(confirm("Are you sure you want to Upload this entry on youtube ?"))
					{
						alert('perform upload action');
						$.ajax({
							url: 'entry/youtubeupload/'+id,
							type: 'POST'
						}).done(function(eId){
							alert('Video uploaded successfully on youtube');
							//$('a#'+id+'.upload').removeClass('upload btn-success').addClass('delete btn-warning').text("Delete Youtube Entry");
							$('a#'+id+'.uploadVideo').removeClass('uploadVideo').addClass('deleteVideo').html("<img class='actionIcon' src='images/delete_icon.png' style=' width: auto!important;'>Delete Youtube Entry");
						});
					}
					else
					{
						return false;
					}
				}
			});
            </script>

@stop