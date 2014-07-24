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
Route::get('paragraph', 'OrgController@getCreateParagraph');
Route::post('paragraph', 'OrgController@postCreateParagraph');

Route::get('user', 'OrgController@getCreateUser');
Route::post('user', 'OrgController@postCreateUser');


