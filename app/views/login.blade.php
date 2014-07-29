@extends('_master')


@section('title')
Project 4: Login
@stop

@section('content')

<div class = 'container'>
	<br>
	<br>
	<br>


	{{ Form::open(array('url' => 'login', 'id' => 'login', 'role' => 'form', 'class' => 'form-horizontal')) }}

	<div class="form-group">
	    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
	    <div class="col-sm-8">
	      <input type="email" class="form-control" id="inputEmail3" name = "inputEmail3"placeholder="example@example.com">	
	    </div>
	</div>
	<div class="form-group">
	    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
	    <div class="col-sm-8">
	      <input type="password" class="form-control" id="inputPassword3" name="inputPassword3" placeholder="Password">
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