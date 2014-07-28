<?php

	class Job_program extends Eloquent {

		public function recipient() {
			return $this->belongsTo('Recipient');

		}
	}