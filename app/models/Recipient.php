<?php

class Recipient extends Eloquent {
	
	public function user() {
		return $this->belongsTo('User');
	}

	public function job_program() {
		return $this->hasMany('Job_program');
	}
}

