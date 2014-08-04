<?php
 
class RecLettOrgController extends BaseController {
	
	public function __construct() {

		$this->beforeFilter('auth');

    }

    ////////////////////////////////////////////////////////////////
    /////need to set the defult to be null///
    //@id are from postCreateRecipient
	public function getRecipient($id = NULL) {

		//no need to check access, because where user_id
		$user_id = Auth::user()->id;
		if ($id != NULL) {
		$recipients = Recipient::with('user')->where('id', '=', "$id")->whereHas('user', function($q) use($user_id) {
			$q->where('id', '=', "$user_id");
		})->orderBy('lastname')->orderBy('firstname')->get();

	    } else {

		    $recipients = Recipient::with('user')->whereHas('user', function($q) use($user_id) {
				$q->where('id', '=', "$user_id");
			})->orderBy('lastname')->orderBy('firstname')->get();

	    }



		return View::make('recipient')->with('recipients', $recipients);
	}


    public function getCreateRecipient(){
		return View::make('recLett');
	}

	public function postCreateRecipient() {

		$input = Input::all();

		$registerData = array_map('trim', $input);

		//Debug Section /////////////////////////

		//$dd = Input::file('inputCV')->getMimeType();

	    //dd($dd);

		//dd(Config::get('mimes'));
		//mimes:pdf,doc,docx does not work, always failed, max seem not working 

		//no variable is allowed in the rules?? $today = date(); not work

		$rules = array(
			'recipient_lastname' => array('alpha', 'required'),
			'recipient_firstname' => array('alpha', 'required'),
			'inputEmail3' => array('email', 'required'),
			'inputCV' => array('max:300000', 'required'),
			'info' => array('alpha_num', 'required'),
		);

		$message = array(
			'email' => 'Please provide valid email address',
		);

		$validator = Validator::make($registerData, $rules, $message);

		if ($validator->fails() ) {
			//withInput does not work
			return Redirect::to('rec-lett-org')->withInput()->withErrors($validator);

		}

		//handle the file upload 
		//file type
		$fileCV = Input::file('inputCV');
		

		$filetypeCV = $fileCV->getMimeType();
	

		//check file type and size
		if(!$fileCV->isValid()){
			return Redirect::to('rec-lett-org')->withInput()->with('flash_message', 'Files not valid');
		}else if ($filetypeCV!="application/pdf"&&$filetypeCV!="application/msword"&&$filetypeCV!="application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
				return Redirect::to('rec-lett-org')->withInput()->with('flash_message', 'The input CV file should be in pdf, doc, docx format');
		} else if (filesize(Input::file('inputCV')) >300000){
			return Redirect::to('rec-lett-org')->withInput()->with('flash_message', 'CV file too large');
		}


//////////////////////////////////////////////////////////////
		//save to the database
		//recipient_database
		//replace " " with _ for file name
		$fileCVOriName = str_replace(' ', '_', $fileCV->getClientOriginalName());
		$fileNameCV=uniqid().$fileCVOriName;
		

		$recipient = new Recipient();
		$recipient->user()->associate(Auth::user()); 
		$recipient->lastname = $input['recipient_lastname'];
		$recipient->firstname = $input['recipient_firstname'];
		$recipient->email=$input['inputEmail3'];
		$recipient->info=$input['info'];
		$recipient->cv_id=$fileNameCV;
		$recipient->cv_name=$fileCV->getClientOriginalName();
		$recipient->cv_size=$fileCV->getSize();
		$recipient->cv_type=$filetypeCV;
		//move files
		$destinationPath=storage_path().'/files/CV';
		$fileCV->move($destinationPath, $fileNameCV);
		$recipient->cv_path=$destinationPath;

		
		try {
            $recipient->save();
            $recipient_id = $recipient->id;

            //need to check!!///////////
            ///////////////////////////
            ///// change route to display info ()
            return Redirect::to('recipient/'.$recipient_id);
        }
        # Fail
        catch (Exception $e) {
            return Redirect::to('rec-lett-org')->withInput()->with('flash_message', 'Unable to save your input');
        }
	
    }
///////////////////////edit 

///////////////////////////////////////////////////////////////////////////////
		public function destroyRecipient($recipient_id) {


			try {
				$recipient = Recipient::findOrFail($recipient_id);
			}
			catch(Exception $e) {
				return Redirect::to('recipient')->with('flash_message', 'Recipient not found');
			}

			//need to check access
			$user_id = Auth::user()->id;
			//need "" for $recipient_id otherwise, like a string '$recipient_di'
			$this_recipient = Recipient::where('id', '=', "$recipient_id")->get()->toArray();

			if(count($this_recipient) > 0) {
	    		$user_id=$this_recipient[0]['user_id'];
	    	} else {
	    		$user_id = -1; //flag for nonavailable id 
	    	}

	    	if ($user_id != Auth::user()->id) {
	    		return Redirect::to('recipient')->with('flash_message', 'Access denied!');
	    	} 

			//associated files need to be deleted
			//////////////////////////////////////////////////////////
			//------------------Handling RL files----------------------
			$RLfiles = Job_program::where('recipient_id', '=', "$recipient_id")->get()->toArray();
			//Note this is a nested array need $RLfile[0] to get the next level!!!!
			//dd($RLfile[0]["rl_path"]);
			if (count($RLfiles) > 0 ) {
				foreach ($RLfiles as $id => $RLfile) {
				$RLpaths[$id] = $RLfile["rl_path"].'/'.$RLfile["rl_id"];
			}

			} else {
				Recipient::destroy($recipient_id);
				return Redirect::to('recipient')->with('flash_message','Your recipient has been deleted. This recipient does not have any job/program info');
			}


			try{
				foreach($RLpaths as $RLpath) {
					if (File::exists($RLpath)) {
						File::delete($RLpath);
					}
				}	
			}
			catch (Exception $e) {
				return Redirect::to('recipient')->with('flash_message', 'Unable to delete RL files');
			}


			//------------------Handling CV files----------------------
			$CVfile = Recipient::where('id', '=', "$recipient_id")->get()->toArray();
			//Note this is a nested array need $RLfile[0] to get the next level!!!!
			if (count($CVfile) > 0 ) {
				$CVpath = $CVfile[0]["cv_path"].'/'.$CVfile[0]["cv_id"];
			} else {
				return Redirect::to('recipient')->with('flash_message','Unable to find CV');
			}


			try{
				if (File::exists($CVpath)) {
					File::delete($CVpath);
				}
			}
			catch (Exception $e) {
				return Redirect::to('recipient')->with('flash_message', 'Unable to delete CV files');
			}
			# Note there's a `deleting` Model event which makes sure associated job_programs entries are also destroyed
			Recipient::destroy($recipient_id);

			return Redirect::to('recipient')->with('flash_message','Your recipient has been deleted.');


		}


		public function getEditRecipient($recipient_id) {
			$user_id = Auth::user()->id;
			try{
				$recipient = Recipient::where('user_id', '=', "$user_id")->findOrFail($recipient_id);
			} catch(Exception $e) {
				return Redirect::to('recipient')->with('flash_message', 'unable to find this recipient');
			}

			return View::make('recipient_edit')
			->with('recipient', $recipient);
		}

		public function postEditRecipient($recipient_id) {

				$input = Input::all();

				$registerData = array_map('trim', $input);

				$rules = array(
					'recipient_lastname' => array('alpha', 'required'),
					'recipient_firstname' => array('alpha', 'required'),
					'inputEmail3' => array('email', 'required'),
					'inputCV' => array('max:30000', 'required'),
					'info' => array('alpha_num', 'required'),
				);

				$message = array(
					'email' => 'Please provide valid email address',
				);

				$validator = Validator::make($registerData, $rules, $message);

				if ($validator->fails() ) {
					//withInput does not work
					return Redirect::to('edit_recipient/'.$recipient_id)->withInput()->withErrors($validator);

				}


				$fileCV = Input::file('inputCV');
				

				$filetypeCV = $fileCV->getMimeType();
			

				//check file type and size
				if(!$fileCV->isValid()){
					return Redirect::to('edit_recipient/'.$recipient_id)->withInput()->with('flash_message', 'Files not valid');
				}else if ($filetypeCV!="application/pdf"&&$filetypeCV!="application/msword"&&$filetypeCV!="application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
						return Redirect::to('edit_recipient/'.$recipient_id)->withInput()->with('flash_message', 'The input CV file should be in pdf, doc, docx format');
				} else if (filesize(Input::file('inputCV')) >30000){
					return Redirect::to('edit_recipient/'.$recipient_id)->withInput()->with('flash_message', 'CV file too large');
				}


		//////////////////////////////////////////////////////////////
				//delete previous uploaded file
				$user_id = Auth::user()->id;//check access
				//has to use first(), otherwise an array will not save()
				$recipient = Recipient::where('id', '=', "$recipient_id")->where('user_id', '=', "$user_id")->first();

				//Note this is a nested array need $RLfile[0] to get the next level!!!!
				if (count($recipient) > 0 ) {
					$preCVpath = $recipient->cv_path.'/'.$recipient->cv_id;
				} else {
					return Redirect::to('edit_recipient/'.$recipient_id)->with('flash_message','Unable to find previous CV');
				}


				try{
					if (File::exists($preCVpath)) {
						File::delete($preCVpath);
					}
				}
				catch (Exception $e) {
					return Redirect::to('edit_recipient/'.$recipient_id)->with('flash_message', 'Unable to delete previous CV files');
				}


				//save to the database
				//recipient_database
				//replace " " with _ for file name
				$fileCVOriName = str_replace(' ', '_', $fileCV->getClientOriginalName());
				$fileNameCV=uniqid().$fileCVOriName;
				
				$recipient->user_id=$user_id; 
				$recipient->lastname = $input['recipient_lastname'];
				$recipient->firstname = $input['recipient_firstname'];
				$recipient->email=$input['inputEmail3'];
				$recipient->info=$input['info'];
				$recipient->cv_id=$fileNameCV;
				$recipient->cv_name=$fileCV->getClientOriginalName();
				$recipient->cv_size=$fileCV->getSize();
				$recipient->cv_type=$filetypeCV;
				//move files
				$destinationPath=storage_path().'/files/CV';
				$fileCV->move($destinationPath, $fileNameCV);
				$recipient->cv_path=$destinationPath;

				
				try {
		            $recipient->save();

		            //need to check!!///////////
		            ///////////////////////////
		            ///// change route to display info ()
		            return Redirect::to('recipient')->with('flash_message', 'Success');
		        }
		        # Fail
		        catch (Exception $e) {
		            return Redirect::to('edit_recipient/'.$recipient_id)->withInput()->with('flash_message', 'Unable to save your input');
		        }

        }



		public function showRecipientInfo($recipient_id=NULL) {

			//no need for check access due to where user_id 
			$user_id = Auth::user()->id;
			if ($recipient_id !=NULL) {
				$recipients=Recipient::with('user')->where('id', '=', "$recipient_id")->whereHas('user', function($q) use($user_id) {
			$q->where('id', '=', "$user_id");})->get();
			} else {
				$recipients=Recipient::with('user')->whereHas('user', function($q) use($user_id) { $q->where('id', '=', "$user_id");})->get();
			}
			
			//Access is checked when denied; count($recipients) == 0, //nothing will be displayed.

			return View::make('recipient_info')->with('recipients', $recipients);

		}

	


}




