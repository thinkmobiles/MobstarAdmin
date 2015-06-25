@extends('layout')

@section('content')

	<!--BEGIN TITLE & BREADCRUMB PAGE-->
	<div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
		<div class="page-header pull-left">
			<div class="page-title">Fashion Entries</div>
		</div>
		<div class="clearfix"></div>
	</div>

<!-- <p><a href="/entry/add" role="button" class="btn btn-green">Add entry</a></p> -->
					
<?php //echo $data['entries']->links(); ?> 

<div class="page-content">
	<div class="row">
		<div class="col-lg-12">
			<div class="panel">

				<div class="panel-body">
                    
				    <div class="panel panel-green">
                        <div class="panel-heading">Filter Entries</div>


				       <form method="get" action="fashionEntries">
                         <?php
                            if(isset($_GET['pageList']))
                                $selected = $_GET['pageList'];
                            else
                               // $selected = $_COOKIE['cookie_pageList'];
                               $selected = (isset($_COOKIE['cookie_pageList']) && !empty($_COOKIE['cookie_pageList'])) ? $_COOKIE['cookie_pageList'] : '20';

                            // if(isset($_GET['pageList']) && !empty($_GET['pageList']))
                            //     $selected = $_GET['pageList'];
                            // else
                            //     $selected = (isset($_COOKIE['cookie_pageList']) && !empty($_COOKIE['cookie_pageList'])) ? $_COOKIE['cookie_pageList'] : '20';
                        ?>
                        <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
                            <label for="pageList" class="control-label">Records per page :</label>
                            <select id="pageList" class="form-control"  name="pageList">
                                <option value="10" <?php echo ($selected == '10') ? "selected" : "" ?>>10</option>
                                <option value="20" <?php echo ($selected == '20') ? "selected" : "" ?>>20</option>
                                <option value="50" <?php echo ($selected == '50') ? "selected" : "" ?>>50</option> 
                                <option value="100" <?php echo ($selected == '100') ? "selected" : "" ?>>100</option> 
                            </select>
                        </div>
                                    

				        <?php
				            if(isset($_GET['orderBy']))
				                $selected = $_GET['orderBy'];
				            else
				                $selected = 'latest';
				        ?>

                            <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <label for="orderBy" class="control-label">Sort</label>
                                <select id="orderBy" class="form-control"  name="orderBy">
                                    <option value="latest" <?php echo ($selected == 'latest') ? "selected" : "" ?>>Latest</option>
                                    <option value="popular" <?php echo ($selected == 'popular') ? "selected" : "" ?>>Most Popular</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <label for="cat" class="control-label">Sub Category</label>
                                
                                <select id="cat" class="form-control" name="subCategory">
                                    <?php
                                        if(isset($_GET['subCategory']))
                                            $selected = $_GET['subCategory'];
                                        else
                                            $selected = 'All';
                                    ?>
                                   <!--  <option></option> -->
                                    <option value="All" <?php echo ($selected == 'All') ? 'selected' : '' ?>>All</option>
                                    <option value="Male" <?php echo ($selected == 'Male') ? 'selected' : '' ?>>Male</option>
                                    <option value="Female" <?php echo ($selected == 'Female') ? 'selected' : '' ?>>Female</option>
                                    <option value="Curve" <?php echo ($selected == 'Curve') ? 'selected' : '' ?>>Curve</option>
                                   <!--  @foreach($data['subCategories'] as $category)
                                    	@if(!empty($category->entry_subcategory))
                                        	<option value="{{$category->entry_subcategory}}" <?php //echo ($selected == $category->entry_subcategory) ? "selected" : "" ?>>{{$category->entry_subcategory}}</option>
                                        @endif	
                                    @endforeach -->

                                </select>
                            </div>
                            
                            <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                    <label for="deleted" class="control-label">Status</label>
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
                            
                            <?php
                            if(isset($_GET['age']))
                                $selected = $_GET['age'];
                            else
                                $selected = 'all';
                        ?>

                            <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <label for="age" class="control-label">Age</label>
                                
                                <select id="age" class="form-control"  name="age">
                                    <option value="all" <?php echo ($selected == 'all') ? "selected" : "" ?>>All</option>
                                    <option value="18-28" <?php echo ($selected == '18-28') ? "selected" : "" ?>>18-28</option>
                                    <option value="29-38" <?php echo ($selected == '29-38') ? "selected" : "" ?>>29-38</option>
                                    <option value="39-48" <?php echo ($selected == '39-48') ? "selected" : "" ?>>39-48</option>
                                    <option value="49-58" <?php echo ($selected == '49-58') ? "selected" : "" ?>>49-58</option>
                                    <option value="59-68" <?php echo ($selected == '59-68') ? "selected" : "" ?>>59-68</option>
                                    <option value="69-150" <?php echo ($selected == '69-150') ? "selected" : "" ?>>Above 68</option>
                                </select>
                                    
                            </div>
                            
                            <?php
                            if(isset($_GET['height']))
                                $selected = $_GET['height'];
                            else
                                $selected = 'all';
                        ?>

                            <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <label for="height" class="control-label">Height (in cm.)</label>
                                
                                <select id="height" class="form-control"  name="height">
                                    <option value="all" <?php echo ($selected == 'all') ? "selected" : "" ?>>All</option>
                                    <option value="101-125" <?php echo ($selected == '101-125') ? "selected" : "" ?>>101-125</option>
                                    <option value="126-150" <?php echo ($selected == '126-150') ? "selected" : "" ?>>126-150</option>
                                    <option value="151-175" <?php echo ($selected == '151-175') ? "selected" : "" ?>>151-175</option>
                                    <option value="176-200" <?php echo ($selected == '176-200') ? "selected" : "" ?>>176-200</option>
                                    <option value="201-225" <?php echo ($selected == '201-225') ? "selected" : "" ?>>201-225</option>
                                    <option value="226-250" <?php echo ($selected == '226-250') ? "selected" : "" ?>>226-250</option>
                                </select>
                                    
                            </div>
                            
                            <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <label for="name" class="control-label">Name</label>
                                <input type="text" class="form-control" id = "name" name="name">
                            </div>
                            
                            <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12">
                                <label for="orderBy" class="control-label">Date</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control" id="datepicker" name="datepicker">
                                </div>
                            </div>
                            
                            <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                                <p>
                                  <label for="entryRange">Votes range:</label>
                                  <input type="text" name="entryRange" id="entryRange" readonly style="border:0; color:#f6931f; font-weight:bold; background:none;">
                                </p>
                                <div id="slider-range"></div>                                               
                            </div>

                            <div class="form-group col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                <label for="view">Choose View</label>
                                <div class="col-lg-12 row">                                                
                                    <a href="#" class="view1"><img src="images/grid_view_icn.png"></a>
                                    <a href="#" class="view2"><img src="images/list_view_icn.png"></a>
                                </div>
                            </div>


                            <div class="form-actions">
                            <div class="col-lg-12">
				                <input type="submit" class="btn btn-default" value="Filter">
                                <?php  if(isset($data['errors']) && !empty($data['errors']))
                                        {
                                            echo "<font color='red'>Entries not found.</font>";
                                        }?>
                            </div>
                            </div>
				       </form>
				    </div>
		
				<?php
        if(isset($_COOKIE['myCookie']) && $_COOKIE['myCookie']=='listView')
        {
           
       ?>
                    <!-- LIST VIEW START -->

                    <div class="flex-container1">

                        @foreach($data['entries'] as $entry)
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 flex-child bt-brd"><!--<img/>-->
                            @if($entry['entry_type'] !='image')
                                    <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
                                        <video class="video-js vjs-default-skin" controls preload="metadata" poster="{{$entry['entry_image']}}" >
                                            <source src="{{$entry['entry_file']}}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                            @else
								<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 media-thumb-list">
									<img src="{{$entry['entry_file']}}" />
								</div>
                            @endif
                                <!--<data></data>-->
                                    <div class="col-lg-10 col-md-9 col-sm-8 col-xs-12 text-left">
                                        <p class="date">{{date('d-m-Y H:i:s', strtotime($entry['entry_date']))}}</p>
                                        <p class="title"><a href='entry/{{$entry['entry_id']}}'><?php echo App::make("EntriesController")->ellipsis($entry['entry_name'].'-'.$entry['entry_description'],22); ?></a></p>
                                        <p class="like">{{$entry['entry_up_votes']}} Up votes - {{$entry['entry_down_votes']}} Down votes <a href="entryNote/{{$entry['entry_id']}}" class="view"><img style="width:18px!important; height:23px;" src="images/notes.png"></a></p>
                                        <a class="btn btn-info" id="{{$entry['entry_id']}}" href="comment/entry/{{$entry['entry_id']}}">View Comments</a>
                                        @if($entry['entry_deleted'] == 0)
                                            <a class="disable btn btn-warning toggle" id="{{$entry['entry_id']}}">Disable Entry</a>
                                        @else
                                            <a class="restore btn btn-success toggle" id="{{$entry['entry_id']}}">Enable Entry</a>
                                        @endif
                                        <a class="deletebtn btn btn-danger" id="{{$entry['entry_id']}}">Delete</a>
                                    </div>
                            </div>
                        @endforeach

                    </div>
                    
                    <!-- LIST VIEW END -->
				<?php      }else { ?>
				<div class="flex-container2">

					@foreach($data['entries'] as $entry)
						<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 flex-child"><!--<img/>-->
						@if($entry['entry_type'] !='image')
								<div class="media-thumb">
									<video class="video-js vjs-default-skin" controls preload="metadata" poster="{{$entry['entry_image']}}" >
										<source src="{{$entry['entry_file']}}" type="video/mp4">
										Your browser does not support the video tag.
									</video>
								</div>
						@else
							<div class="media-thumb">
								<img src="{{$entry['entry_file']}}" />
							</div>
						@endif
							<!--<data></data>-->
								<p class="date">{{date('d-m-Y H:i:s', strtotime($entry['entry_date']))}}</p>

								<p class="title"><a href='entry/{{$entry['entry_id']}}'><?php echo App::make("EntriesController")->ellipsis($entry['entry_name'].'-'.$entry['entry_description'],22); ?></a></p>
								<p class="like">{{$entry['entry_up_votes']}} Up votes - {{$entry['entry_down_votes']}} Down votes <a href="entryNote/{{$entry['entry_id']}}" class="view"><img style="width:18px!important; height:23px;" src="images/notes.png"></a></p>
								<a class="btn btn-info" id="{{$entry['entry_id']}}" href="comment/entry/{{$entry['entry_id']}}">View Comments</a>
								@if($entry['entry_deleted'] == 0)
									<a class="disable btn btn-warning toggle" id="{{$entry['entry_id']}}">Disable Entry</a>
								@else
									<a class="restore btn btn-success toggle" id="{{$entry['entry_id']}}">Enable Entry</a>
								@endif
								<a class="deletebtn btn btn-danger" id="{{$entry['entry_id']}}">Delete</a>
						</div>
					@endforeach

				</div>
		<?php }
        ?> 
				</div>
                {{$data['pages']}}
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
                    url: 'delete/'+id,
                    type: 'GET'
                }
                ).done(function(){
                $('a#'+id+'.disable').removeClass('disable btn-warning').addClass('restore btn-success').text("Enable Entry");
                });
            }
            else if($(this).hasClass("restore"))
            {

            $.ajax({
                url: 'restoreentry/'+id,
                type: 'GET'
            }
            ).done(function(){
            $('a#'+id+'.restore').removeClass('restore btn-success').addClass('disable btn-warning').text("Disable Entry");
            });


            }
            });

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
                        $('.view1').click(function(){
                $.cookie('myCookie','gridView');
                location.reload();
                // $('.flex-container2').show();
                // $('.flex-container1').hide();
            });
            $('.view2').click(function(){
                $.cookie('myCookie','listView');
                location.reload();
                // $('.flex-container2').hide();
                // $('.flex-container1').show();
            });

            $(function() {
                $( "#datepicker" ).datepicker({  maxDate: new Date() });
            });
			$(function() {
			$( "#slider-range" ).slider({
			  range: true,
			  min: 0,
			  max: 500,
			  values: [ <?php echo $first;?>, <?php echo $last;?> ],
			  slide: function( event, ui ) {
				$( "#entryRange" ).val( "" + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
			  }
			});
			$( "#entryRange" ).val( "" + $( "#slider-range" ).slider( "values", 0 ) +
			  " - " + $( "#slider-range" ).slider( "values", 1 ) );
			});
        
        </script>

@stop