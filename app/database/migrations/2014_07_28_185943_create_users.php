<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	

	public function up()
	{
		Schema::create('users', function($table) {

		    $table->increments('id');
		    $table->string('username', 32)->unique();
		    $table->string('lastname');
		    $table->string('firstname');
		    $table->string('email')->unique();
		    $table->boolean('remember_token');
		    $table->string('password', 60);
		    $table->string('ip_address', 45);
		    $table->timestamps();

		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('users');
	}

}
