<?php

class RegisterFormController extends BaseController {

	
	public function __construct() {

        $this->beforeFilter('guest', array('only' =>
                            array('getRegisterForm')));//add filter to register form
   
		$this->beforeFilter('csrf', array('only' =>
                            array('postRegisterForm')));

    }


	public function getRegisterForm() {
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
			return Redirect::to('register_form')->withInput(Input::except('inputPassword3'))->withErrors($validator);

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
            return Redirect::to('/register_form')->withInput()->with('flash_message', 'Sign up failed; please try again.');
        }

        # Log the user in
        Auth::login($user);

        return Redirect::to('/')->with('flash_message', 'Welcome!');
	}
}//end of class