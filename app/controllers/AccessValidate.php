<?php

//only used in showJobProgram now
class AccessValidate {

	private $recipient_id;

	public function __construct($recipient_id) {
		$this->$recipient_id = $recipient_id;	
	}

    public function isAccessAllowed($recipient_id) {

    	//check whether user has access to this recipient
		$this_recipient = Recipient::where('id', '=', "$recipient_id")->get()->toArray();

		if(count($this_recipient) > 0) {
	    	$user_id=$this_recipient[0]['user_id'];
	    	$this_recipient_name = $this_recipient[0]['firstname']." ".$this_recipient[0]['lastname'];

	    	} else {
	    		$user_id = -1; //flag for nonavailable id 
	    	}

	    if($user_id == Auth::user()->id) {
	    	return $this_recipient_name;
	    } else {
	    	return "false";
	    }
     
    }
}