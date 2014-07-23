@extends('_master')


@section('title')
Project 3: Random Paragraph and User Generator
@stop



@section('content')

	<div class='row'>
		<div class="paragraph col-lg-6 ">
			<h3>What is Lorem Ipsum?</h3>
			<p>Lorem Ipsum is a dummy type of text used in the printing and typesetting industry. It has been the standard dummy text ever since the 1500s. It has survived not only five centuries, but also the leap into electronic typesetting.
			</p>

			<p><a href="http://www.lipsum.com">Learn more &raquo;</a></p>

			<h4>This tool generates dummy text using Lorem Ipsum.
			</h4>

			



			<a href='/paragraph' class="btn btn-primary btn-lg" role="button" >paragraph generator</a> 

		</div><!--paragraph-->

		<div class="user col-lg-6">

			<h4>This tool generates random user data. 			Like Lorem Ipsum, but for people.
			</h4>

			<a href='/user' class="btn btn-primary btn-lg" role="button" >user generator</a>
		</div> <!--user-->

	</div> <!--row-->
	@stop

	@section('returnHome')
	@stop