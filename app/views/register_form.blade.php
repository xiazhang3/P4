@extends('_master')


@section('title')
Project 4: Register
@stop

@section('script')

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	var validation = $("#register_form").validate({
		rules: {
			lastName: { required: true,  minlength: 2},
			firstName: { required: true,  minlength: 2},
			userName: { required: true,  minlength: 2},
			inputEmail3: { required: true, email: true},
			inputPassword3: { required: true,  minlength: 6},
			inputPassword3_confirmation: { equalTo: "#inputPassword3"}
		}
	});
});

</script>
@stop


@section('content')

<div class = 'container'>
	<br>
	<br>
	<br>

	{{ Form::open(array('url' => 'registerForm', 'id' => 'register_form', 'role' => 'form', 'class' => 'form-horizontal')) }}

	  <div class="form-group">
	    <label for="lastName" class="col-sm-2 control-label">Last Name</label>
	    <div class="col-sm-8">
	      <input type="text" class="form-control" name = "lastName" placeholder="Smith">
	    </div>
	    <span class="help-block errors"> {{ $errors->first('lastName') }} </span>
	  
	  </div>

	  <div class="form-group">
	    <label for="firstName" class="col-sm-2 control-label">First Name</label>
	    <div class="col-sm-8">
	      <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Amy">
	    </div>
	   	<span class="help-block errors"> {{ $errors->first('firstName') }} </span>

	  </div>

	   <div class="form-group">
	    <label for="userName" class="col-sm-2 control-label">Username</label>
	    <div class="col-sm-8">
	      <input type="text" class="form-control" id="userName" name="userName" placeholder="Amy123Smith">
	    </div>
	    <span class="help-block errors"> {{ $errors->first('userName') }} </span>

	  </div>

	  <div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
	    <div class="col-sm-8">
	      <input type="email" class="form-control" id="inputEmail3" name = "inputEmail3"placeholder="example@example.com">	
	    </div>
	    <span class="help-block errors"> {{ $errors->first('inputEmail3') }} </span>

	  </div>


	  <div class="form-group">
	    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
	    <div class="col-sm-8">
	      <input type="password" class="form-control" id="inputPassword3" name="inputPassword3" placeholder="Password">
	    </div>
	    <span class="help-block errors"> {{ $errors->first('inputPassword3') }} </span>
	  </div>
	    <div class="form-group">
	    <label for="inputPassword3conf" class="col-sm-2 control-label">Verify Password</label>
	    <div class="col-sm-8">
	      <input type="password" class="form-control" id="inputPassword3_confirmation" name="inputPassword3_confirmation" placeholder="Password">
	    </div>
	    <span class="help-block errors"> {{ $errors->first('inputPassword3_confirmation') }} </span>

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
	      <div class="checkbox">
	        <label>
	          <input type="checkbox" id='terms' name='terms'> I have read the <a href = "#">Subscriber Agreement &amp; Terms of Use</a>
	        </label>
	      </div>
	      <span class="help-block errors"> {{ $errors->first('terms') }} </span>
	    </div>
	  </div>

	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <button type="submit" class="btn btn-primary">Sign up</button>
	    </div>
	  </div>



	{{ Form:: close() }}

</div><!--container-->

	

		
@stop