@extends('_master')


@section('title')
Login
@stop

@section('content')

<div class = 'container'>
	<br>
	<br>
	<br>

<!--need to use Form::email to allow withInput() work -->
	{{ Form::open(array('url' => 'login', 'id' => 'login', 'role' => 'form', 'class' => 'form-horizontal')) }}

	<div class="form-group">
		{{Form::label('inputEmail3', 'Email', array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	    {{ Form::email('inputEmail3', '', array('class' => 'form-control', 'placeholder'=>'example@example.com')) }}
	    </div>
	</div>
	<div class="form-group">
		{{Form::label('inputPassword3', 'Password', array('class'=> 'col-sm-2 control-label')) }}
	    <div class="col-sm-8">
	     <!-- use this form, the format will change. {{ Form::password('inputPassword3', '', array('class' => 'form-control', 'placeholder'=>'')) }} -->
	      <input type="password" class="form-control" id="inputPassword3" name="inputPassword3" placeholder="at least 6 characters or digits">
	    </div>
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
	      <button type="submit" class="btn btn-success">Login</button>
	    </div>
	</div>


	{{ Form:: close() }}

</div><!--container-->

@stop