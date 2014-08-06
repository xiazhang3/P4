@extends('_master')


@section('title')
Recipient
@stop


@section('content')

<div class = 'container'>
	<br>
	<br>
	<br>

@if(count($job_programs) == 0)
			<div class='message'>
				<p>No matches found</p>
			</div>
@endif


<table id='myTable' class='tablesorter table  table-hover table-striped'>
	<caption>
		Job Program List for {{$this_recipient_name}}
	</caption>
	<thead>
			<tr>
				<th>Job/Program Name</th>
				<th>Job/Program Description</th>
				<th>Due Date</th>
				<th>Alert Date</th>
				<th></th>
				<th></th>
				<th></th>
			</tr>
	</thead>
	<tbody>
		@foreach($job_programs as $job_program)
			<tr>
				<th>{{$job_program['job_program_name']}}</th>
				<th>{{$job_program['description']}}</th>
				<th>{{ $job_program['due_date'] }}</th>
				<th>{{ $job_program['alert_date'] }}</th>	
				<th>{{ Form::open(['method' => 'GET', 'url' => 'download_rl/'.$job_program['recipient_id'].'/'. $job_program['id'] ])  }}
    	     	<button type="submit" class="btn btn-info">Download RL</button>
{{ Form::close() }}</th>		
				<th>{{ Form::open(['method' => 'GET', 'url' => 'job_program_edit/'.$job_program['recipient_id'].'/'. $job_program['id'] ])  }}
    	     	<button type="submit" class="btn btn-warning">Edit</button>
{{ Form::close() }}</th>

				<th>{{ Form::open(['method' => 'DELETE', 'url' => 'job_program_delete/'.$job_program['recipient_id'].'/'. $job_program['id'] ]) }}
    <button type="submit" class="btn btn-danger">Delete</button>
{{ Form::close() }}</th>
			</tr>
				
		@endforeach
	</tbody>

</table>

</div><!--container-->

@stop





