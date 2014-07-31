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
			<p>No matches found</p>
@endif


<table id='myTable' class='tablesorter table  table-hover table-striped'>
	<caption>
		Recommendation Letter Recipients
	</caption>
	<thead>
			<tr>
				<th>Recipient's Name</th>
				<th>Job/Program Name</th>
				<th>Create Date</th>
				<th>Actions</th>
	</thead>
	<tbody>
		@foreach($recipients as $recipient)
			<tr>
				<th><a href={{'recipient/'.$recipient['id']}}>{{$recipient['firstname']}} {{$recipient['lastname']}}</th>
				<th>{{ $recipient['created_at'] }}</th>
				<th><a href='#'>delete</a> <a href="#">edit</a></th>
				
		@endforeach
	</tbody>

</table>

</div><!--container-->

@stop





