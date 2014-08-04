@extends('_master')


@section('title')
Edit Recipient
@stop

@section('content')

<div class = 'container'>
	<br>
	<br>
	<br>


	{{ Form::open(array('url' => 'edit_recipient/'.$recipient['id'], 'id' => 'recipient_edit', 'role' => 'form', 'class' => 'form-horizontal', 'files' => true)) }}

	<div class="form-group">
		{{Form::label('recipient_lastname', "Recipient's Last Name", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::text('recipient_lastname', $recipient['lastname'], array('class' => 'form-control', 'placeholder'=>'Amy')) }}
	    </div>
	    <span class="col-sm-offset-2 col-sm-10  help-block errors"> {{ $errors->first('recipient_lastname') }} </span>
	</div>

	<div class="form-group">
	    {{Form::label('recipient_firstname', "Recipient's First Name", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::text('recipient_firstname', $recipient['firstname'], array('class' => 'form-control', 'placeholder'=>'Smith')) }}	
	    </div>
	    <span class="col-sm-offset-2 col-sm-10  help-block errors"> {{ $errors->first('recipient_firstname') }} </span>
	</div>

	  <div class="form-group">
	    {{Form::label('inputEmail3', "Recipient's Email", array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::email('inputEmail3', $recipient['email'], array('class' => 'form-control', 'placeholder'=>'example@example.com')) }}
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
	    {{ Form::textarea('info', $recipient['info'], array('class' => 'form-control', 'placeholder'=>'A quick learner', 'rows'=> '5')) }}
	    </div>
	</div>

	<div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <button type="submit" class="btn btn-success">Save</button>
	    </div>
	</div>

	{{ Form:: close() }}

</div><!--container-->

@stop