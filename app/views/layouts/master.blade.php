<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>{{ $title }}</title>
	 
	<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<!--[if lte IE 7]>
		<script src="js/IE8.js" type="text/javascript"></script><![endif]-->
	<!--[if lt IE 7]>
	 
		<link rel="stylesheet" type="text/css" media="all" href="css/ie6.css"/><![endif]-->

	<link rel="stylesheet" href="{{ URL::asset('css/bootstrap.css') }}"/>
	<link rel="stylesheet" href="{{ URL::asset('css/bootstrap-glyphicons.css') }}"/>
	<link rel="stylesheet" href="{{ URL::asset('css/status.css') }}"/>

	<script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/bootstrap.js') }}"></script>
	<script type="text/javascript" src="{{ URL::asset('js/scripts.js') }}"></script>

</head>
 
<body id="index" class="home">
	<div class="wrapper">
		<div class="container">
			<div class="header">
				<ul class="nav nav-pills pull-right">
					<li><a href="http://wikia.com">Wikia Home</a></li>
					<li><a href="#" id="nagios">Nagios</a></li>
					<li><a href="#" id="pingdom">Pingdom</a></li>
					@if ( Auth::check() === true)
						<li>{{ HTML::linkRoute('logout', 'Logout') }}</li>
					@endif
				</ul>
				<a href="{{ route('home') }}"><img src="http://upload.wikimedia.org/wikipedia/commons/1/17/Wikia_Logo.svg" id="logo" alt="icon" /></a>
				<div style="height: 1px; clear: both;"></div>
			</div>
			<div class="content">
				@yield('content');
			</div>
			<div class="footer">

			</div>
		</div>
	</div>
</body>
</html>