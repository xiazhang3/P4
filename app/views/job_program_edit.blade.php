@extends('_master')


@section('title')
Edit Job/Program 
@stop

@section('content')

<div class = 'container'>
	<br>
	<br>
	<br>

	{{ Form::open(array('url' => 'job_program_edit/'.$job_program['recipient_id'].'/'.$job_program['id'], 'id' => 'job_program_edit', 'role' => 'form', 'class' => 'form-horizontal', 'files' => true)) }}

	<div class="form-group">
		{{Form::label('job_program', "Job/Program Name", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::text('job_program', $job_program['job_program_name'], array('class' => 'form-control', 'placeholder'=>'Job or Program Name')) }}
	    </div>
	    <span class="col-sm-offset-2 col-sm-10 help-block errors"> {{ $errors->first('job_program') }} </span>
	</div>

	<div class="form-group">
		{{Form::label('description', "Job/Program Description", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::textarea('description', $job_program['description'], array('class' => 'form-control', 'placeholder'=>'Job or Program Description', 'rows'=>'5')) }}
	    </div>
	    <span class="col-sm-offset-2 col-sm-10 help-block errors"> {{ $errors->first('description') }} </span>	
	</div>

		<!--dueDate -->
	<div class="form-group">
		{{Form::label('dueDate', "Application Due Date", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::text('dueDate', $job_program['due_date'], array('class' => 'form-control', 'placeholder'=>'YYYY/MM/DD')) }}
	    </div>
	    <span class="col-sm-offset-2 col-sm-10 help-block errors"> {{ $errors->first('dueDate') }} </span>
	</div>
		

		<!--alertDays -->

	<div class="form-group">
		{{Form::label('alertDate', "Alert Me On", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::text('alertDate', $job_program['alert_date'], array('class' => 'form-control', 'placeholder'=>'YYYY/MM/DD')) }}
	    </div>
	    <span class="col-sm-offset-2 col-sm-10 help-block errors"> {{ $errors->first('alertDate') }} </span>
	</div>

		<div class="form-group">
		{{Form::label('recommendation_letter', "Recommendation Letter", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
    	 {{ Form::file('recommendation_letter', '', array('class' => 'form-control', 'accept'=>"application/pdf,application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document")) }}
	    </div>
	    <span class="col-sm-offset-2 col-sm-10 help-block errors"> {{ $errors->first('recommendation_letter') }} </span>
	</div>

	<div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <button type="submit" class="btn btn-success">Save</button>
	    </div>
	</div>


	{{ Form:: close() }}

</div><!--container-->

@stop