@extends('_master')


@section('title')
Project 4: Application Organizer
@stop



@section('content')

<div class = 'container'>
	<div class='row'>
		<?php require(app_path().'/views/component/navTop.php') ?>


		<!--be careful with the path-->
		<?php require(app_path().'/views/component/carousel.blade.php') ?>


		<div class="info col-lg-6">
			<h3>Track Information</h3>
			<p>Keep track of information you collect on your recommendation letter recipient, job search, or university application.</p>
			<h3>Monitor Progress</h3>
			<p>Monitor your tasks from start through end with ease</p>
			<h3>Stay Informed</h3>
			<p>Receive updates automatically or as needed</p>
		</div><!--info-->

		<?php require(app_path().'/views/component/lefticon.php') ?>




	</div> <!--row-->
</div><!--container-->
@stop

	