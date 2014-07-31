<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobPrograms extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
			Schema::create('job_programs', function($table) {

    			$table->increments('id');
    			//forgein key in "many" not in "one"
    			$table->integer('recipient_id')->unsigned(); 
    		    $table->string('job_program_name');
    		    $table->text('description');
    		    $table->date('due_date');
    		    $table->date('alert_date');

    		    //file related
    		    $table->string('rl_id');
    		    $table->string('rl_name');
    		    $table->string('rl_size');
    		    $table->string('rl_type');
    		    $table->string('rl_path');

    		    $table->timestamps();

    		    $table->foreign('recipient_id')->references('id')->on('recipients');

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
		Schema::drop('job_programs');
	}

}
