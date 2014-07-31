<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'OrgController@showIndex');
Route::get('register_form', 'RegisterFormController@getRegisterForm');
Route::post('register_form', 'RegisterFormController@postRegisterForm');

Route::get('login', 'LoginController@getLogin');
Route::post('login', 'LoginController@postLogin');

Route::get('logout', 'LoginController@anyLogout');


Route::get('rec-lett-org', 'RecLettOrgController@getRecLettOrg');
Route::post('rec-lett-org', 'RecLettOrgController@postRecLettOrg');

Route::get('recipient', 'RecLettOrgController@getRecipient');



//for debug, will comment out for production
Route::get('debug', 'DebugController@debug');

Route::get('crud', function() {

	# Instantiate the book model
	$user = new User();
        $user->lastName    = 'a';
        $user->firstName    = 'b';
        $user->username    = 'd';
        $user->email    = 'x@12.com';
        $user->password = Hash::make('123456');
        $user->ip_address	='127.0.0.0';

	# Magic: Eloquent
	$user->save();

	return "Added a new row";

});


