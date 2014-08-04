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
Route::get('edit_recipient/{recipient_id}', 'RecLettOrgController@getEditRecipient');
Route::post('edit_recipient/{recipient_id}', 'RecLettOrgController@postEditRecipient');

Route::delete('recipient_delete/{id}', 'RecLettOrgController@destroyRecipient');


Route::get('job_program/{id}', 'JobProgramController@getJobProgram');
Route::post('job_program/{id}', 'JobProgramController@postJobProgram');
Route::get('show_job_program/{recipient_id}/{job_id?}', 'JobProgramController@showJobProgram');
Route::delete('job_program_delete/{recipient_id}/{job_id}', 'JobProgramController@destroyJobProgram');
Route::get('job_program_edit/{recipient_id}/{job_id}', 'JobProgramController@getEditJobProgram');
Route::post('job_program_edit/{recipient_id}/{job_id}', 'JobProgramController@postEditJobProgram');



///////////////
Not Allow the following in production 
//for debug, will comment out for production
Route::get('debug', 'DebugController@debug');
Route::get('/truncate', function() {

    # Clear the tables to a blank slate
    DB::statement('SET FOREIGN_KEY_CHECKS=0'); # Disable FK constraints so that all rows can be deleted, even if there's an associated FK
    DB::statement('TRUNCATE job_programs');
    DB::statement('TRUNCATE recipients');
    DB::statement('TRUNCATE users');
}

Route::get('crud', function() {

	# Instantiate the book model
	$user = new User();
        $user->lastName    = 'a';
        $user->firstName    = 'b';
        $user->username    = 'd';
        $user->email    = 'x@12.com';
        $user->password = Hash::make('123456');
        $user->ip_address	='127.0.0.0';

        $user->save();


        $user = new User();
        $user->lastName    = 'z';
        $user->firstName    = 'x';
        $user->username    = 'y';
        $user->email    = 'x@122.com';
        $user->password = Hash::make('123456');
        $user->ip_address       ='127.0.0.0';

	# Magic: Eloquent
	$user->save();

	return "Added two new rows";

});


