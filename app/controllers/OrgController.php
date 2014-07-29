<?php

class OrgController extends BaseController {

	public function __construct() {

        $this->beforeFilter('guest', array('only' =>
                            array('getCreateRegisterForm', 'getCreateLogin')));//add filter to register form
   
		$this->beforeFilter('csrf', array('only' =>
                            array('postRegisterForm', 'postLogin')));

		$this->beforeFilter('auth', array('only' =>
                            array('getRecLettOrg')));

    }


	public function showIndex(){
		return View::make('index');
	}

	public function getCreateRegisterForm() {
		return View::make('register_form');
	}



	public function postRegisterForm() {

		//validate inputs
		//remove white space of the inputs
		$input = Input::all();

		$registerData = array_map('trim', $input);

		//careful no space should be between 'unique:users,email' otherwise column not found
		$rules = array(
			'lastName' => array('alpha', 'required'),
			'firstName' => array('alpha', 'required'),
			'userName' => array('alpha_num', 'required', 'unique:users,username'),
			'inputEmail3' => array('email', 'required', 'unique:users,email' ),
			'inputPassword3' => array('required', 'min:6'),
			'inputPassword3_confirmation' => array('required', 'min:6', 'same:inputPassword3'),
			'terms'=>'accepted' 
		);

		$message = array(
			'alpha' => 'Please enter alphabetical characters.',
			'required' => 'This field is required.',
			'min' => 'The length is at least 6.',
			'email' => 'Please provide valid email address',
			'unique' => 'Already exsits, choose another one',
			'same' => 'Please verify your password.',
		);

		$validator = Validator::make($registerData, $rules, $message);

		if ($validator->fails() ) {
			//withInput does not work
			return Redirect::to('registerForm')->withInput(Input::except('inputPassword3'))->withErrors($validator);

		}
		

		/////////////////////////////////////////////////////////////////
		


		//store in database

	    $user = new User();
        $user->lastName    = $registerData['lastName'];
        $user->firstName    = $registerData['firstName'];
        $user->username    = $registerData['userName'];
        $user->email    = $registerData['inputEmail3'];
        $user->password = Hash::make($registerData['inputPassword3']);
        $user->ip_address	=Request::getClientIP();
        
        //dealing with remeber me
        /*
        if(array_key_exists('remember_me', $registerData)) {
	        $user->remember_token = '1';
	    } else {
	        $user->remember_token = '0';

	    }
		*/

        # Try to add the user 
        try {
            $user->save();
        }
        # Fail
        catch (Exception $e) {
            return Redirect::to('/registerForm')->withInput(Input::except('inputPassword3'))->with('flash_message', 'Sign up failed; please try again.');
        }

        # Log the user in
        Auth::login($user);

        return Redirect::to('/')->with('flash_message', 'Welcome!');
	}


	public function getCreateLogin() {
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
            return Redirect::to('login')->withInput(Input::except('inputPassword3'))->with('flash_message', 'Log in failed; please try again.');
        }

	}


	public function getLogout() {

		Auth::logout();

    	# Send them to the homepage
    	return Redirect::to('/');
	}


	public function getRecLettOrg(){
		return View::make('recLett');
	}

	public function postRecLettOrg() {
		//handle the form
	}


	public function debug() {

		return View::make('debug');
	}

}






