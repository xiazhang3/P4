<?php

class LoginController extends BaseController {

	
	public function __construct() {

        $this->beforeFilter('guest', array('only' =>
                            array('getLogin')));//add filter to register form
   
		$this->beforeFilter('csrf', array('only' =>
                            array('postLogin')));


    }

    	public function getLogin() {
		return View::make('login');
	}

	public function postLogin(){

		//note that the database names and form names are different
		$EmailCredential = Input::get('inputEmail3');
		$passWordCredential = Input::get('inputPassword3');

		//handle remember me
		if (Input::has('remember_me')){
			$remember = true;
		} else {
			$remember = false;
		}


        if (Auth::attempt(array('email' => $EmailCredential, 'password' => $passWordCredential) , $remember)) {
            return Redirect::intended('/')->with('flash_message', 'Welcome Back!');
        }
        else {
            return Redirect::to('login')->withInput(Input::except('inputPassword3'))->with('flash_message', 'Login failed!');
        }

	}


	public function anyLogout() {

		Auth::logout();

    	# Send them to the homepage
    	return Redirect::to('/');
	}




}