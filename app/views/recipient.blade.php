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


<table id='myTable' class='tablesorter table  table-hover table-striped'>
	<caption>
		Recommendation Letter Recipients
	</caption>
	<thead>
			<tr>
				<th>Recipient's Name</th>
				<th>Create Date</th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
	</thead>
	<tbody>
		@foreach($recipients as $recipient)
			<tr>
				<th><a href={{url('recipient_info/'.$recipient['id'])}}>{{$recipient['firstname']}} {{$recipient['lastname']}}</a></th>
				<th>{{ $recipient['created_at'] }}</th>

				<th>{{ Form::open(['method' => 'GET', 'action' => ['RecLettOrgController@showRecipientInfo', $recipient['id']]]) }}
    	      <button type="submit" class="btn btn-default">Detailed Info</button>
{{ Form::close() }}</th>

				<th>{{ Form::open(['method' => 'GET', 'action' => ['RecLettOrgController@downloadCV', $recipient['id']]]) }}
    	      <button type="submit" class="btn btn-info">Download CV</button>
{{ Form::close() }}</th>

				<th>{{ Form::open(['method' => 'GET', 'action' => ['JobProgramController@showJobProgram', $recipient['id']]]) }}
    	      <button type="submit" class="btn btn-primary">Show Job/Program</button>
{{ Form::close() }}</th>
				
				<th>{{ Form::open(['method' => 'GET', 'action' => ['JobProgramController@getJobProgram', $recipient['id']]]) }}
    	      <button type="submit" class="btn btn-warning">Add Job/Program</button>
{{ Form::close() }}</th>
				<th>{{ Form::open(['method' => 'GET', 'action' => ['RecLettOrgController@getEditRecipient', $recipient['id']]]) }}
    	      <button type="submit" class="btn btn-success">Edit</button>
{{ Form::close() }}</th>
				<th>{{ Form::open(['method' => 'DELETE', 'action' => ['RecLettOrgController@destroyRecipient', $recipient['id']]]) }}
    <button type="submit" class="btn btn-danger">Delete</button>
{{ Form::close() }}</th>
				
				</tr>


				
		@endforeach
	</tbody>

</table>

</div><!--container-->

@stop





