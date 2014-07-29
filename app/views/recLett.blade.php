@extends('_master')


@section('title')
Project 4: Recommendation Letter Organizer
@stop

@section('content')

<div class = 'container'>
	<br>
	<br>
	<br>


	{{ Form::open(array('url' => 'recLett', 'id' => 'recLett', 'role' => 'form', 'class' => 'form-horizontal', 'enctype'=>'multipart/form-data')) }}

	<div class="form-group">
	    <label for="recipient_fistname" class="col-sm-2 control-label">Recipient's First Name</label>
	    <div class="col-sm-8">
	      <input type="text" class="form-control" id="recipient_firstname" name = "recipient_firstname" placeholder="Amy">	
	    </div>
	</div>
	<div class="form-group">
	    <label for="recipient_lastname" class="col-sm-2 control-label">Recipient's Last Name</label>
	    <div class="col-sm-8">
	      <input type="text" class="form-control" id="recipient_lastname" name = "recipient_lastname" placeholder="Smith">	
	    </div>
	</div>

	<div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label">Recipient's Email</label>
	    <div class="col-sm-8">
	      <input type="email" class="form-control" id="inputEmail3" name="inputEmail3" placeholder="example@example.com">
	    </div>
	</div>


	<!---mimes type for files-->
	<div class="form-group">
	    <label for="inputFile" class="col-sm-2 control-label">Recipient's Email</label>
	    <div class="col-sm-8">
	      <input type="file" class="form-control" id="inputFile" name="inputFile" accept="application/pdf,application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document">
	    </div>
	</div>

	<div class="form-group">
	    <label for="info" class="col-sm-2 control-label">Recipient's Info</label>
	    <div class="col-sm-8">
	      <textarea rows="5" class="form-control" id="info" name="info" placeholder="A quick learner"></textarea>
	    </div>
	</div>



	<div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <div class="checkbox">
	        <label>
	          <input id='remember_me' name='remember_me' type="checkbox"> Remember me
	        </label>
	      </div>
	    </div>
	  </div>

	<div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <button type="submit" class="btn btn-success">Login</button>
	    </div>
	</div>

	{{ Form:: close() }}

</div><!--container-->

@stop