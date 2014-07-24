<?php

class OrgController extends BaseController {
	public function showIndex(){
		return View::make('index');
	}

	public function getCreateParagraph() {
		return View::make('paragraph');
	}


	public function getCreateUser() {
		return View::make('user');
	}

	//This function requires "badcow/lorem-ipsum": "dev-master"
	public function postCreateParagraph(){
		$paraData = Input::all();
		$paraNum = (int)Input::get('num_paragraph');

		//This is the validation section////////////////////
		//alpha_num does not work, treat num_paragraph as string, max is then the string length
		$rules = array(
			'num_paragraph' => array('numeric', 'required', 'min:1', 'max:20')
		);

		$message = array(
			'numeric' => 'Please enter a number.',
			'required' => 'This field is required',
			'min' => 'Please enter a number larger than or equal to 1',
			'max' => 'Please enter a numbe less than or equal to 20'
		);

		$validator = Validator::make($paraData, $rules, $message);

		if ($validator->fails() ) {
			return Redirect::to('paragraph')->withInput()->withErrors($validator);

		}

		//////////////////////////////////////////////////////////////



		$generator = new Badcow\LoremIpsum\Generator();
		$paragraphs = $generator->getParagraphs($paraNum);

		//modify the usage accordingly
		echo '<p>'.implode('</p><p>', $paragraphs).'</p>';

	}

	//This function requires "fzaninotto/faker": "1.5.*@dev"
	public function postCreateUser() {
		$userData = Input::all();
		$userNum = (int)Input::get('num_user');
		$userEmail = Input::get('add_email');
		$userAddress = Input::get('add_address');

		//This is the validation section////////////////////
		//if use alpha_num does not work, treat num_user as string, max is then the string length
		$rules = array(
			'num_user' => array('numeric', 'required', 'min:1', 'max:100')
		);

		$message = array(
			'numeric' => 'Please enter a number.',
			'required' => 'This field is required',
			'min' => 'Please enter a number larger than or equal to 1',
			'max' => 'Please enter a numbe less than or equal to 100'
		);

		$validator = Validator::make($userData, $rules, $message);

		if ($validator->fails() ) {
			return Redirect::to('user')->withInput()->withErrors($validator);

		}

		//////////////////////////////////////////////////////////////


		// use the factory to create a Faker\Generator instance
		$faker = Faker\Factory::create();
		

		for($i = 0; $i < $userNum; $i++) {
		    echo '<p>'.$faker->name.'</p>';  
		    if (($userEmail)!=NULL){
		      	echo '<p>'.$faker->email.'</p>'; 
		    }
			if (($userAddress)!=NULL){
		      	echo '<p>'.$faker->address.'</p>'; 
		    }		   
		    echo '<br>';
		}

	}


}