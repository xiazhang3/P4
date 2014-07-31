@extends('_master')


@section('title')
Recommendation Letter Organizer
@stop

@section('content')

<div class = 'container'>
	<br>
	<br>
	<br>

	{{ Form::open(array('url' => 'rec-lett-org', 'id' => 'recLett', 'role' => 'form', 'class' => 'form-horizontal', 'files' => true)) }}

	<div class="form-group">
		{{Form::label('recipient_lastname', "Recipient's Last Name", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::text('recipient_lastname', '', array('class' => 'form-control', 'placeholder'=>'Amy')) }}
	    </div>
	    <span class="col-sm-offset-2 col-sm-10  help-block errors"> {{ $errors->first('recipient_lastname') }} </span>
	</div>

	<div class="form-group">
	    {{Form::label('recipient_firstname', "Recipient's First Name", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::text('recipient_firstname', '', array('class' => 'form-control', 'placeholder'=>'Smith')) }}	
	    </div>
	    <span class="col-sm-offset-2 col-sm-10  help-block errors"> {{ $errors->first('recipient_firstname') }} </span>
	</div>

	  <div class="form-group">
	    {{Form::label('inputEmail3', "Recipient's Email", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::email('inputEmail3', '', array('class' => 'form-control', 'placeholder'=>'example@example.com')) }}
	    </div>
	    <span class="col-sm-offset-2 col-sm-10 help-block errors"> {{ $errors->first('inputEmail3') }} </span>

	  </div>


	<!---mimes type for files-->
	<div class="form-group">
		{{Form::label('inputCV', "Recipient's CV", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	        {{ Form::file('inputCV', '', array('class' => 'form-control', 'accept'=>"application/pdf,application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document")) }}
	    </div>
	    <span class="col-sm-offset-2 col-sm-10 help-block errors"> {{ $errors->first('inputCV') }} </span>
	</div>

	<div class="form-group">
		{{Form::label('info', "Recipient's Info", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::textarea('info', '', array('class' => 'form-control', 'placeholder'=>'A quick learner', 'rows'=> '5')) }}
	    </div>
	</div>

	<div class="form-group">
		{{Form::label('job_program', "Job/Program Name", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::text('job_program', '', array('class' => 'form-control', 'placeholder'=>'Job or Program Name')) }}
	    </div>
	    <span class="col-sm-offset-2 col-sm-10 help-block errors"> {{ $errors->first('job_program') }} </span>
	</div>

	<div class="form-group">
		{{Form::label('description', "Job/Program Description", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::textarea('description', '', array('class' => 'form-control', 'placeholder'=>'Job or Program Description', 'rows'=>'5')) }}
	    </div>
	    <span class="col-sm-offset-2 col-sm-10 help-block errors"> {{ $errors->first('description') }} </span>	
	</div>

		<!--dueDate -->
	<div class="form-group">
		{{Form::label('dueDate', "Application Due Date", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::text('dueDate', '', array('class' => 'form-control', 'placeholder'=>'YYYY/MM/DD')) }}
	    </div>
	    <span class="col-sm-offset-2 col-sm-10 help-block errors"> {{ $errors->first('dueDate') }} </span>
	</div>
		

		<!--alertDays -->

	<div class="form-group">
		{{Form::label('alertDate', "Aler Me On", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::text('alertDate', '', array('class' => 'form-control', 'placeholder'=>'YYYY/MM/DD')) }}
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