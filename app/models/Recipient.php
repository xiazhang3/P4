<?php

class Recipient extends Eloquent {
	
	public function user() {
		return $this->belongsTo('User');
	}

	public function job_program() {
		return $this->hasMany('Job_program');
	}

	# Model events...
	# http://laravel.com/docs/eloquent#model-events
	public static function boot() {
        
        parent::boot();

        static::deleting(function($recipient) {
        	
            DB::statement('DELETE FROM job_programs WHERE recipient_id = ?', array($recipient->id));	 
        });

	}
}

