@extends('_master')


@section('title')
Project 4: Application Organizer
@stop



@section('content')

<div class = 'container'>
	<div class = 'row'>

		<!--be careful with the path-->
		<?php require(app_path().'/views/_carousel.blade.php') ?>

		<!--somehow the col-lg-6 does not work for safari-->
		<div class='info col-md-6'>
			<h3>Track Information</h3>
			<p>Keep track of information you collect on your recommendation letter recipient, job search, or university application.</p>
			<h3>Monitor Progress</h3>
			<p>Monitor your tasks from start through end with ease</p>
			<!--<h3>Stay Informed</h3>
			<p>Receive updates automatically or as needed</p>
			-->
		</div><!--info-->

		<?php require(app_path().'/views/_lefticon.php') ?>
	</div> <!--row-->
</div><!--container-->
@stop

	