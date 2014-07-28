<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecipients extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('recipients', function($table) {

		    $table->increments('id');
		    $table->integer('user_id')->unsigned(); 
		    $table->string('lastname');
		    $table->string('firstname');
		    $table->string('email');
		    $table->text('info');
		    $table->string('cv');

		    $table->timestamps();

		    $table->foreign('user_id')->references('id')->on('users');

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
		Schema::drop('recipients');
	}

}
