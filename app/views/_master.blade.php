<!doctype html>
<html>
<head>

	<title>@yield('title')</title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" >
	<meta name="description" content="Project 1: A simple introduction">
	<meta name="author" content="Xia Zhang">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	
	
	<link rel="stylesheet" href="css/p3.css" type="text/css">

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>	
	@yield('script')

</head>

<body>
	<div class='container'>
		<div class="jumbotron">
			<h1>Welcome to My Project 3</h1>
			<h2>Random Paragraph and User Generator</h2>
		</div>

			@yield('content')

			<!--show return home btn in pages except the homepage-->
			@section('returnHome')
			<br>
			<a href='{{ url("/") }}' class="btn btn-primary btn-sm" role="button">Return to Homepage</a>
			@show

	</div>




</body>

</html>