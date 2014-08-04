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

		    //file related
	        $table->string('cv_id');
	        $table->string('cv_name');
		    $table->string('cv_size');
		    $table->string('cv_type');
		    $table->string('cv_path');

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

		Schema::table('recipients', function($table) {
			$table->dropForeign('recipients_user_id_foreign'); # table_fields_foreign
		});
		
		Schema::drop('recipients');
	}

}
