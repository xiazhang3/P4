<?php

class OrgController extends BaseController {

	public function __construct() {

        $this->beforeFilter('guest', array('only' =>
                            array('getRegisterForm')));//add filter to register form
   
		$this->beforeFilter('csrf', array('only' =>
                            array('postRegisterForm')));

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
		$registerData = array_map('trim', Input::all());

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
			return Redirect::to('registerForm')->withInput()->withErrors($validator);

		}
		

		/////////////////////////////////////////////////////////////////
		//dealing with remeber me


		//store in database

	    $user = new User();
        $user->lastName    = $registerData['lastName'];
        $user->firstName    = $registerData['firstName'];
        $user->username    = $registerData['userName'];
        $user->email    = $registerData['inputEmail3'];
        $user->password = Hash::make($registerData['inputPassword3']);
        $user->ip_address	=Request::getClientIP();



        # Try to add the user 
        try {
            $user->save();
        }
        # Fail
        catch (Exception $e) {
            return Redirect::to('/registerForm')->with('flash_message', 'Sign up failed; please try again.')->withInput();
        }

        # Log the user in
        Auth::login($user);

        return Redirect::to('/')->with('flash_message', 'Welcome!');
	}


	public function debug() {

		return View::make('debug');
	}

}



