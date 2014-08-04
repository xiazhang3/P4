<!doctype html>
<html>
<head>

	<title>@yield('title')</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
	<meta name="description" content="Project 4">
	<meta name="author" content="Xia Zhang">
	<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>	
	<link rel="stylesheet" type="text/css" href="/css/p4.css"  media="screen">

	@yield('script')

</head>

<body>
			

			<?php require(app_path().'/views/_navTop.blade.php') ?>


			@yield('content')

				@if(Session::get('flash_message'))
				    <div class='flash-message'><p>{{ Session::get('flash_message') }} </p></div>
			    @endif



	
		


</body>

</html>