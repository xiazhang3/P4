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


Route::get('rec-lett-org', 'RecLettOrgController@getCreateRecipient');
Route::post('rec-lett-org', 'RecLettOrgController@postCreateRecipient');

Route::get('recipient/{id?}', 'RecLettOrgController@getRecipient');
Route::get('recipient_info/{id?}','RecLettOrgController@showRecipientInfo');

Route::delete('recipient_delete/{id}', 'RecLettOrgController@destroyRecipient');


Route::get('job_program/{id}', 'JobProgramController@getJobProgram');
Route::post('job_program/{id}', 'JobProgramController@postJobProgram');
Route::get('show_job_program/{recipient_id}/{job_id?}', 'JobProgramController@showJobProgram');
Route::delete('job_program_delete/{recipient_id}/{job_id}', 'JobProgramController@destroyJobProgram');
Route::get('job_program_edit/{id}', 'JobProgramController@getEditJobProgram');
Route::post('job_program_edit/{id}', 'JobProgramController@postEditJobProgram');




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


