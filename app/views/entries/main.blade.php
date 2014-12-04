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

<div class="page-content">
				<div class="row">
					<div class="col-lg-12">
						<div class="panel">
							<div class="panel-body">
								<div id="grid-layout-ul-li" class="box jplist">
									<div class="jplist-ios-button"><i class="fa fa-sort"></i>jPList Actions</div>
									<div class="jplist-panel box panel-top">
										<button type="button" data-control-type="reset" data-control-name="reset" data-control-action="reset" class="jplist-reset-btn btn btn-default">Reset<i class="fa fa-share mls"></i></button>
										<div data-control-type="drop-down" data-control-name="paging" data-control-action="paging" class="jplist-drop-down form-control">
											<ul class="dropdown-menu">
												<li><span data-number="3"> 3 per page</span></li>
												<li><span data-number="5"> 5 per page</span></li>
												<li><span data-number="10" data-default="true"> 10 per page</span></li>
												<li><span data-number="all"> view all</span></li>
											</ul>
										</div>
										<div data-control-type="drop-down" data-control-name="sort" data-control-action="sort" data-datetime-format="{month}/{day}/{year}" class="jplist-drop-down form-control">
											<ul class="dropdown-menu">
												<li><span data-path="default">Sort by</span></li>
												<li><span data-path=".title" data-order="asc" data-type="text">Title A-Z</span></li>
												<li><span data-path=".title" data-order="desc" data-type="text">Title Z-A</span></li>
												<li><span data-path=".desc" data-order="asc" data-type="text">Description A-Z</span></li>
												<li><span data-path=".desc" data-order="desc" data-type="text">Description Z-A</span></li>
												<li><span data-path=".like" data-order="asc" data-type="number" data-default="true">Likes asc</span></li>
												<li><span data-path=".like" data-order="desc" data-type="number">Likes desc</span></li>
												<li><span data-path=".date" data-order="asc" data-type="datetime">Date asc</span></li>
												<li><span data-path=".date" data-order="desc" data-type="datetime">Date desc</span></li>
											</ul>
										</div>
										<div class="text-filter-box">
											<div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input data-path=".title" type="text" value="" placeholder="Filter by Title" data-control-type="textbox" data-control-name="title-filter" data-control-action="filter" class="form-control"/></div>
										</div>
										<div class="text-filter-box">
											<div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input data-path=".desc" type="text" value="" placeholder="Filter by Description" data-control-type="textbox" data-control-name="desc-filter" data-control-action="filter" class="form-control input-medium"/></div>
										</div>
										<div data-control-type="views" data-control-name="views" data-control-action="views" data-default="jplist-grid-view" class="jplist-views">
											<button type="button" data-type="jplist-list-view" class="jplist-view jplist-list-view btn btn-default"><i class="fa fa-th-list"></i></button>
											<button type="button" data-type="jplist-grid-view" class="jplist-view jplist-grid-view btn btn-default"><i class="fa fa-th"></i></button>
											<button type="button" data-type="jplist-thumbs-view" class="jplist-view jplist-thumbs-view btn btn-default"><i class="fa fa-reorder"></i></button>
										</div>
										<div data-type="Page {current} of {pages}" data-control-type="pagination-info" data-control-name="paging" data-control-action="paging" class="jplist-label btn btn-default"></div>
										<div data-control-type="pagination" data-control-name="paging" data-control-action="paging" class="jplist-pagination"></div>
									</div>
									<ul class="box text-shadow ul-li-list">

										@foreach($data['entries'] as $entry)
										<li id="list-item-{{ $entry->entry_id }}" class="list-item">
											<div class="list-box"><!--<img/>-->
												<div class="img">
													<video style="width:100%; height:auto" class="video-js vjs-default-skin" controls preload="metadata" poster="https://mobstar-1.s3.amazonaws.com/thumbs/wcYbWuXfC5Pq-thumb.jpg?AWSAccessKeyId=AKIAIE4TLASFISDQDHPA">
														<source src="https://mobstar-1.s3.amazonaws.com/wcYbWuXfC5Pq.mp4?AWSAccessKeyId=AKIAIE4TLASFISDQDHPA&Expires=1417620862&Signature=ySaiLetqXKKiB0Oo%2FZWzxFRXGuk%3D" type="video/mp4">
														Your browser does not support the video tag.
													</video>
												</div>
												<!--<data></data>-->
												<div class="block">
													<p class="date">03/15/2012</p>
													<p class="title">{{ $entry->entry_name }}</p>
													<p class="desc">{{ $entry->entry_description }}</p>
													<p class="like">5 Likes</p>
												</div>
											</div>
										</li>
										@endforeach
										
									</ul>
									<div class="jplist-ios-button"><i class="fa fa-sort"></i>jPList Actions</div>
									<div class="jplist-panel box panel-bottom">
										<div data-control-type="drop-down" data-control-name="paging" data-control-action="paging" data-control-animate-to-top="true" class="jplist-drop-down form-control">
											<ul class="dropdown-menu">
												<li><span data-number="3"> 3 per page</span></li>
												<li><span data-number="5"> 5 per page</span></li>
												<li><span data-number="10" data-default="true"> 10 per page</span></li>
												<li><span data-number="all"> view all</span></li>
											</ul>
										</div>
										<div data-control-type="drop-down" data-control-name="sort" data-control-action="sort" data-control-animate-to-top="true" data-datetime-format="{month}/{day}/{year}" class="jplist-drop-down form-control">
											<ul class="dropdown-menu">
												<li><span data-path="default">Sort by</span></li>
												<li><span data-path=".title" data-order="asc" data-type="text">Title A-Z</span></li>
												<li><span data-path=".title" data-order="desc" data-type="text">Title Z-A</span></li>
												<li><span data-path=".desc" data-order="asc" data-type="text">Description A-Z</span></li>
												<li><span data-path=".desc" data-order="desc" data-type="text">Description Z-A</span></li>
												<li><span data-path=".like" data-order="asc" data-type="number" data-default="true">Likes asc</span></li>
												<li><span data-path=".like" data-order="desc" data-type="number">Likes desc</span></li>
												<li><span data-path=".date" data-order="asc" data-type="datetime">Date asc</span></li>
												<li><span data-path=".date" data-order="desc" data-type="datetime">Date desc</span></li>
											</ul>
										</div>
										<div data-type="{start} - {end} of {all}" data-control-type="pagination-info" data-control-name="paging" data-control-action="paging" class="jplist-label btn btn-default"></div>
										<div data-control-type="pagination" data-control-name="paging" data-control-action="paging" data-control-animate-to-top="true" class="jplist-pagination"></div>
									</div>
									<div class="box jplist-no-results text-shadow align-center"><p>No results found</p></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

@stop