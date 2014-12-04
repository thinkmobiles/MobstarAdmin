<!DOCTYPE html>
<html lang="en">
<head>

	<title>Mobstar Admin Area</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="expires" content="Thu, 19 Nov 1900 08:52:00 GMT">
	<link rel="shortcut icon" href="images/icons/favicon.ico">
	<link rel="apple-touch-icon" href="images/icons/favicon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="images/icons/favicon-72x72.png">
	<link rel="apple-touch-icon" sizes="114x114" href="images/icons/favicon-114x114.png">
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
	<!--Loading style vendors-->
	{{ HTML::style('vendors/animate.css/animate.css'); }}
	{{ HTML::style('vendors/iCheck/skins/all.css'); }}
	{{ HTML::style('vendors/jquery-notific8/jquery.notific8.min.css'); }}
	<!--Loading style-->
	{{ HTML::style('css/themes/style1/yellow-grey.css'); }}
	{{ HTML::style('css/style-responsive.css'); }}

</head>
<body id="signin-page">
	
<div class="page-form">
	<form action="/login" class="form" method="post">
		<div class="header-content"><h1>Log In</h1></div>
		<div class="body-content">
			<p>
			{{ $errors->first('admin_email') }}
			{{ $errors->first('admin_password') }}
			</p>
			<div class="form-group">
				<div class="input-icon right"><i class="fa fa-user"></i><input type="text" placeholder="Username" name="admin_email" class="form-control" value="{{ Input::old('admin_email') }}" /></div>
			</div>
			<div class="form-group">
				<div class="input-icon right"><i class="fa fa-key"></i><input type="password" placeholder="Password" name="admin_password" class="form-control" /></div>
			</div>
			<div class="form-group pull-left">
				<div class="checkbox-list"><label><input type="checkbox">&nbsp;
					Keep me signed in</label></div>
			</div>
			<div class="form-group pull-right">
				<button type="submit" class="btn btn-success">Log In
					&nbsp;<i class="fa fa-chevron-circle-right"></i></button>
			</div>
			<div class="clearfix"></div>
		</div>
	</form>
</div>

{{ HTML::script('js/jquery-1.10.2.min.js'); }}
{{ HTML::script('js/jquery-migrate-1.2.1.min.js'); }}
{{ HTML::script('js/jquery-ui.js'); }}
<!--loading bootstrap js-->
{{ HTML::script('vendors/bootstrap/js/bootstrap.min.js'); }}
{{ HTML::script('vendors/bootstrap-hover-dropdown/bootstrap-hover-dropdown.js'); }}
{{ HTML::script('js/html5shiv.js'); }}
{{ HTML::script('js/respond.min.js'); }}
{{ HTML::script('vendors/iCheck/icheck.min.js'); }}
{{ HTML::script('vendors/iCheck/custom.min.js'); }}

<script>
//BEGIN CHECKBOX & RADIO
$('input[type="checkbox"]').iCheck({
	checkboxClass: 'icheckbox_minimal-grey',
	increaseArea: '20%' // optional
});
$('input[type="radio"]').iCheck({
	radioClass: 'iradio_minimal-grey',
	increaseArea: '20%' // optional
});
//END CHECKBOX & RADIO
</script>
</body>
</html>