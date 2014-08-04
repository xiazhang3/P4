@extends('_master')


@section('title')
Recipient
@stop


@section('script')
<!--
format very ugly now !!
<link rel='stylesheet' type='text/css' href='tablesorter/themes/green/style.css'>

<script type="text/javascript" src="tablesorter/jquery.tablesorter.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	$("#myTable").tablesorter({widgets:['zebra']});
});

</script>
-->
@stop



@section('content')

<div class = 'container'>
	<br>
	<br>
	<br>

@if(count($recipients) == 0)
			<div class='message'>
				<p>No matches found</p>
			</div>
@endif

		@foreach($recipients as $recipient)
		<ul class='recipient_info'>
			<li>Recipient's name: {{$recipient['firstname']}} {{$recipient['lastname']}}</li>
			<li>Recipient's email: {{$recipient['email']}}</li>
			<li>Recipient's basic information: {{$recipient['info']}}</li>
			<li>Recipient's CV file name: {{$recipient['cv_name']}}</li>

		</ul>		
				
		@endforeach




</div><!--container-->

@stop





