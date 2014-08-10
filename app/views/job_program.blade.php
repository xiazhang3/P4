@extends('_master')


@section('title')
Job/Program Register
@stop

@section('content')

<div class = 'container'>
	<br>
	<br>
	<br>

	<div class="formInstruction">
		<p> Add job/program related information for your recommendation letter recipient using the following form</p>
	</div>

	{{ Form::open(array('url' => 'job_program/'.$recipient_id, 'id' => 'job_program', 'role' => 'form', 'class' => 'form-horizontal', 'files' => true)) }}

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
		{{Form::label('alertDate', "Alert Me On", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::text('alertDate', '', array('class' => 'form-control', 'placeholder'=>'YYYY/MM/DD')) }}
	    </div>
	    <span class="col-sm-offset-2 col-sm-10 help-block errors"> {{ $errors->first('alertDate') }} </span>
	</div>

		<div class="form-group">
		{{Form::label('recommendation_letter', "Recommendation Letter", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8 fileUpload">
	    <p>Please upload a file in .doc, .docx, or .pdf format. File size should not exceed 30000 bytes.</p>

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