@extends('_master')


@section('title')
Register
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

	{{ Form::open(array('url' => 'register_form', 'id' => 'register_form', 'role' => 'form', 'class' => 'form-horizontal')) }}

	  <div class="form-group">
	  	{{Form::label('lastName', 'Last Name', array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::text('lastName', '', array('class' => 'form-control', 'placeholder'=>'Smith')) }}
	    </div>
	    <span class="help-block errors"> {{ $errors->first('lastName') }} </span>
	  
	  </div>

	  <div class="form-group">
	    {{Form::label('fisrtName', 'First Name', array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::text('firstName', '', array('class' => 'form-control', 'placeholder'=>'Amy')) }}
	    </div>
	   	<span class="help-block errors"> {{ $errors->first('firstName') }} </span>

	  </div>

	   <div class="form-group">
	   	{{Form::label('userName', 'Username', array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::text('userName', '', array('class' => 'form-control', 'placeholder'=>'Amy123Smith')) }}
	    </div>
	    <span class="help-block errors"> {{ $errors->first('userName') }} </span>

	  </div>

	  <div class="form-group">
	    {{Form::label('inputEmail3', 'Email', array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::email('inputEmail3', '', array('class' => 'form-control', 'placeholder'=>'example@example.com')) }}
	    </div>
	    <span class="help-block errors"> {{ $errors->first('inputEmail3') }} </span>

	  </div>


	  <div class="form-group">
	    {{Form::label('inputPassword3', 'Password', array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	      <input type="password" class="form-control" id="inputPassword3" name="inputPassword3" placeholder="at least 6 characters or digits">
	    </div>
	    <span class="help-block errors"> {{ $errors->first('inputPassword3') }} </span>
	  </div>
	    <div class="form-group">
	    {{Form::label('inputPassword3_confirmation', 'Verify Password', array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	      <input type="password" class="form-control" id="inputPassword3_confirmation" name="inputPassword3_confirmation" placeholder="Put the same Password">
	    </div>
	    <span class="help-block errors"> {{ $errors->first('inputPassword3_confirmation') }} </span>

	  </div>

	<div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <div class="checkbox">
	        <label>
	           {{ Form::checkbox('remember_me', '1', true) }} Remember me
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
	      <button type="submit" class="btn btn-info">Sign up</button>
	    </div>
	  </div>



	{{ Form:: close() }}

</div><!--container-->
		
@stop