<!DOCTYPE html>
<html lang="en">
<head>

	<title>Mobstar Admin Area</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="Thu, 19 Nov 1900 08:52:00 GMT">
	<link rel="shortcut icon" href="/images/icons/favicon.ico">
	<link rel="apple-touch-icon" href="/images/icons/favicon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/images/icons/favicon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/images/icons/favicon-114x114.png">

    {{ HTML::script('js/jquery-1.10.2.min.js'); }}
    {{ HTML::script('js/jquery-migrate-1.2.1.min.js'); }}
    {{ HTML::script('js/jquery-ui.js'); }}

	<!--Loading bootstrap css-->
	{{ HTML::style('http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700'); }}
	{{ HTML::style('http://fonts.googleapis.com/css?family=Oswald:400,700,300'); }}
	{{ HTML::style('vendors/jquery-ui-1.10.4.custom/css/ui-lightness/jquery-ui-1.10.4.custom.min.css'); }}
	{{ HTML::style('vendors/font-awesome/css/font-awesome.min.css'); }}
	{{ HTML::style('vendors/bootstrap/css/bootstrap.min.css'); }}
	{{ HTML::style('vendors/bootstrap-switch/css/bootstrap-switch.css'); }}


	<!--LOADING STYLESHEET FOR PAGE-->
	{{ HTML::style('vendors/calendar/zabuto_calendar.min.css'); }}
	{{ HTML::style('vendors/sco.message/sco.message.css'); }}
	{{ HTML::style('vendors/intro.js/introjs.css'); }}
	{{ HTML::style('vendors/jplist/html/css/jplist-custom.css'); }}

	{{ HTML::style('vendors/bootstrap-datepicker/css/datepicker.css'); }}
	{{ HTML::style('vendors/bootstrap-daterangepicker/daterangepicker-bs3.css'); }}
	{{ HTML::style('vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css'); }}
	{{ HTML::style('vendors/bootstrap-timepicker/css/bootstrap-timepicker.min.css'); }}

	<!--Loading style vendors-->

	{{ HTML::style('vendors/animate.css/animate.css'); }}
	{{ HTML::style('vendors/iCheck/skins/all.css'); }}
	{{ HTML::style('vendors/jquery-notific8/jquery.notific8.min.css'); }}
	<!--Loading style-->
	{{ HTML::style('css/themes/style1/yellow-grey.css'); }}
	{{ HTML::style('css/style-responsive.css'); }}

</head>
<body>

<div>
	<!--BEGIN BACK TO TOP--><a id="totop" href="#"><i class="fa fa-angle-up"></i></a><!--END BACK TO TOP-->
	<!--BEGIN TOPBAR-->
	<div id="header-topbar-option-demo" class="page-header-topbar">
		<nav id="topbar" role="navigation" style="margin-bottom: 0; z-index: 2;" class="navbar navbar-default navbar-static-top">
			<div class="navbar-header">
				<button type="button" data-toggle="collapse" data-target=".sidebar-collapse" class="navbar-toggle"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>

			</div>
			<div class="topbar-main"><a id="menu-toggle" href="#" class="hidden-xs"><i class="fa fa-bars"></i></a>
				<ul class="nav navbar navbar-top-links navbar-right mbn">
					<li class="dropdown topbar-user">
						<a data-hover="dropdown" href="/user/{{ $data['this_user']->user_id }}" class="dropdown-toggle"><img src="/images/logo.png" alt=""/>&nbsp;<span class="hidden-xs">{{ $data['this_user']->user_display_name }}</span>&nbsp;<span class="caret"></span></a>
						<ul class="dropdown-menu dropdown-user pull-right">
							<li><a href="/logout"><i class="fa fa-key"></i>Log Out</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
	</div>
	<!--END TOPBAR-->
	<div id="wrapper">
		<!--BEGIN SIDEBAR MENU-->
		<nav id="sidebar" role="navigation" class="navbar-default navbar-static-side">
			<div class="sidebar-collapse menu-scroll">
				<ul id="side-menu" class="nav">
					<li class="user-panel">
						<div class="thumb"><img src="/images/icon.png" alt="" class="img-circle"/></div>
						<div class="info"><p>{{ $data['this_user']->user_display_name }}</p>
							<ul class="list-inline list-unstyled">
								<li><a href="/logout" data-hover="tooltip" title="Logout"><i class="fa fa-sign-out"></i></a></li>
							</ul>
						</div>
						<div class="clearfix"></div>
					</li>

					@foreach($data['sidenav'] as $nav)
					<li {{ $nav['page_selected'] == 1 ? " class=\"active\"" : "" }}>
						<a href="/{{ $nav['page_url'] }}">
							<i class="fa fa-{{ $nav['page_icon'] }} fa-fw">
								<div class="icon-bg bg-orange"></div>
							</i>
							<span class="menu-title">{{ $nav['page_title'] }}</span>
							@if ( isset($nav['page_subpages']) )
							<span class='fa arrow'></span>
							@endif 
							@if ( isset($nav['page_counter']) )
							<span class="label label-yellow">{{ $nav['page_counter'] }}</span> 
							@endif 
						</a>
						@if ( isset($nav['page_subpages']) )
						<ul class="nav nav-second-level">
							@foreach($nav['page_subpages'] as $subnav)
							<li><a href="/{{ $subnav['page_url'] }}"><i class="fa fa-{{ $subnav['page_icon'] }}"></i><span class="submenu-title">{{ $subnav['page_title'] }}</span></a></li>
							@endforeach
						</ul>
						@endif
					</li>
					@endforeach
				</ul>
			</div>
		</nav>
		<!--END SIDEBAR MENU-->
		<!--BEGIN PAGE WRAPPER-->
		<div id="page-wrapper">
			
			@yield('content')

		</div>
</div>

<!--loading bootstrap js-->
{{ HTML::script('vendors/bootstrap/js/bootstrap.min.js'); }}
{{ HTML::script('vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js'); }}
{{ HTML::script('js/html5shiv.js'); }}
{{ HTML::script('js/respond.min.js'); }}
{{ HTML::script('vendors/metisMenu/jquery.metisMenu.js'); }}
{{ HTML::script('vendors/slimScroll/jquery.slimscroll.js'); }}
{{ HTML::script('vendors/jquery-cookie/jquery.cookie.js'); }}
{{ HTML::script('vendors/iCheck/icheck.min.js'); }}
{{ HTML::script('vendors/iCheck/custom.min.js'); }}
{{ HTML::script('vendors/jquery-notific8/jquery.notific8.min.js'); }}
{{ HTML::script('vendors/jquery-highcharts/highcharts.js'); }}
{{ HTML::script('js/jquery.menu.js'); }}
{{ HTML::script('vendors/holder/holder.js'); }}
{{ HTML::script('vendors/responsive-tabs/responsive-tabs.js'); }}
{{ HTML::script('vendors/jquery-news-ticker/jquery.newsTicker.min.js'); }}

<!--CORE JAVASCRIPT-->
{{ HTML::script('js/main.js'); }}

<!--LOADING SCRIPTS FOR PAGE-->

{{ HTML::script('vendors/bootstrap-switch/js/bootstrap-switch.min.js'); }}
{{ HTML::script('vendors/calendar/zabuto_calendar.min.js'); }}
{{ HTML::script('vendors/sco.message/sco.message.js'); }}

{{ HTML::script('vendors/jplist/html/js/jplist.min.js'); }}
{{ HTML::script('js/jplist.js'); }}

{{ HTML::script('vendors/bootstrap-datepicker/js/bootstrap-datepicker.js'); }}
{{ HTML::script('vendors/bootstrap-daterangepicker/daterangepicker.js'); }}
{{ HTML::script('vendors/moment/moment.js'); }}
{{ HTML::script('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); }}

{{ HTML::script('vendors/intro.js/intro.js'); }}
{{ HTML::script('js/index.js'); }}

@yield('pagefoot')

</body>
</html>