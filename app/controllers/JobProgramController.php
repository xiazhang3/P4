<?php
 
class JobProgramController extends BaseController {
	
	public function __construct() {

		$this->beforeFilter('auth');

    }


    //simiar to getRecipient()
    public function showJobPRogram($recipient_id, $job_id = NULL) {

    	//check whether user has access to this recipient
		$user_id = Auth::user()->id;

		//use class AccessValiate
		$access = New AccessValidate($recipient_id);
		$access_result = $access->isAccessAllowed($recipient_id);

	    if ($access_result == "false") {
	    		return Redirect::to('recipient')->with('flash_message', 'Access denied!');
	    } 


		//no need to check recipient has access to the job because of where
			if ($job_id != NULL) {
		$job_programs = Job_program::where('recipient_id', '=', "$recipient_id")->where('id', '=', "$job_id")->get();

	    } else {

		   $job_programs = Job_program::where('recipient_id', '=', "$recipient_id")->get();

	    }

		return View::make('show_job_program')->with('job_programs', $job_programs)->with('this_recipient_name', $access_result);
    }

    public function getJobProgram($recipient_id) {

    	//check if this belongs to the user
    	$this_recipient=Recipient::where('id', '=', "$recipient_id")->get()->toArray();

    	if(count($this_recipient) > 0) {
    		$user_id=$this_recipient[0]['user_id'];
    	} else {
    		$user_id = -1; //flag for nonavailable id 
    	}

    	if ($user_id == Auth::user()->id) {
    		return View::make('job_program')->with('recipient_id', $recipient_id);

    	} else {
    		//add with to show consistency with getRecipient functioin
    		return View::make('recipient')->with('flash_message', "Access denied")->with('recipients', $this_recipient);
    	}
    }

    public function postJobProgram($recipient_id) {

		$input = Input::all();

		$jobProgramData = array_map('trim', $input);

		$rules = array(
			'job_program' => array('required'),
			'description' => array('required'),
			'dueDate' => 'date_format:Y/m/d|date',
			'alertDate' => 'date_format:Y/m/d|date',
			'recommendation_letter' => 'max:300000|required'
		);

		$message = array(
			'email' => 'Please provide valid email address',
		);

		$validator = Validator::make($jobProgramData, $rules, $message);

		if ($validator->fails() ) {
			//withInput need to work with blade forms
			return Redirect::to('job_program/'.$recipient_id)->withInput()->withErrors($validator);

		}

	

		$fileRL = Input::file('recommendation_letter');
		$filetypeRL = $fileRL->getMimeType();

		if(!$fileRL->isValid()){
			return Redirect::to('job_program/'.$recipient_id)->withInput()->with('flash_message', 'Files not valid');
		}else if ($filetypeRL!="application/pdf"&&$filetypeRL!="application/msword"&&$filetypeRL!="application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
				return Redirect::to('job_program/'.$recipient_id)->withInput()->with('flash_message', 'The input recommendation letter should be in pdf, doc, docx format');
		} else if (filesize(Input::file('recommendation_letter')) >300000){
			return Redirect::to('job_program/'.$recipient_id)->withInput()->with('flash_message', 'RL file too large');
		}


//////////////////////////////////////////////////////////////
        //save to database --- job_programs

        $fileRLOriName = str_replace(' ', '_', $fileRL->getClientOriginalName());

        $fileNameRL=uniqid().$fileRLOriName;
		

		$job_program = new Job_program();
		$job_program->recipient_id=$recipient_id; 
		$job_program->job_program_name = $input['job_program'];
		$job_program->description = $input['description'];
		//need to convert string to date
		$job_program->due_date=date('Y-m-d', strtotime($input['dueDate']));
		$job_program->alert_date=date('Y-m-d',strtotime($input['alertDate']));
		$job_program->rl_id=$fileNameRL;
		$job_program->rl_name=$fileRL->getClientOriginalName();
		$job_program->rl_size=$fileRL->getSize();
		$job_program->rl_type=$filetypeRL;
		//move files
		$destinationPathRL=storage_path().'/files/RL';
		$fileRL->move($destinationPathRL, $fileNameRL);
		$job_program->rl_path=$destinationPathRL;




            
		
		try {

			$job_program->save();

           //send email
            $user=User::find(Auth::user()->id);

            $laterSec = strtotime($job_program->alert_date)-time();

	    	Mail::later($laterSec, 'emails.alert', array('due_date' => $job_program->due_date), function($message) use ($user){
			    $message->to($user->email, $user->firstname." ".$user->lastname);
			    $message->from('noreply@applicationorganizer.pagodabox.com', 'Do Not Reply');
			    $message->subject('Alert! Due date is coming.');
			});
           
 			$job_id=$job_program->id;
            return Redirect::to('show_job_program/'.$recipient_id.'/'.$job_id);

        }
        # Fail
        catch (Exception $e) {
            return Redirect::to('job_program/'.$recipient_id)->withInput()->with('flash_message', 'Unable to save your job program input');
        }

	}


	public function getEditJobProgram($recipient_id, $job_id) {

			$user_id = Auth::user()->id;


			//check access
			//need "" for $recipient_id otherwise, like a string '$recipient_di'
			$this_recipient = Recipient::where('id', '=', "$recipient_id")->get()->toArray();

			if(count($this_recipient) > 0) {
	    		$user_id=$this_recipient[0]['user_id'];
	    	} else {
	    		$user_id = -1; //flag for nonavailable id 
	    	}

	    	if ($user_id != Auth::user()->id) {
	    		return Redirect::to('show_job_program/'.$recipient_id)->with('flash_message', 'Access denied!');
	    	} 
			
			/////////////////////////////
			try{
				$job_program= Job_program::where('recipient_id', '=', "$recipient_id")->findOrFail($job_id);
			} catch(Exception $e) {
				return Redirect::to('show_job_program/'.$recipient_id)->with('flash_message', 'unable to find this job/program');
			}

			return View::make('job_program_edit')
			->with('job_program', $job_program);//'job_program' corresponds $job_program in View// consistant with show_job_program

	}

	public function postEditJobProgram($recipient_id, $job_id) {

		$input = Input::all();

		$jobProgramData = array_map('trim', $input);

		$rules = array(
			'job_program' => array('required'),
			'description' => array('required'),
			'dueDate' => 'date_format:Y-m-d|date',
			'alertDate' => 'date_format:Y-m-d|date',
			'recommendation_letter' => 'max:30000|required'
		);

		$message = array(
			'email' => 'Please provide valid email address',
		);

		$validator = Validator::make($jobProgramData, $rules, $message);

		if ($validator->fails() ) {
			//withInput need to work with blade forms
			return Redirect::to('job_program_edit/'.$recipient_id.'/'.$job_id)->withInput()->withErrors($validator);

		}
	
		$fileRL = Input::file('recommendation_letter');
		$filetypeRL = $fileRL->getMimeType();

		if(!$fileRL->isValid()){
			return Redirect::to('job_program/'.$recipient_id.'/'.$job_id)->withInput()->with('flash_message', 'Files not valid');
		}else if ($filetypeRL!="application/pdf"&&$filetypeRL!="application/msword"&&$filetypeRL!="application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
				return Redirect::to('job_program/'.$recipient_id.'/'.$job_id)->withInput()->with('flash_message', 'The input recommendation letter should be in pdf, doc, docx format');
		} else if (filesize(Input::file('recommendation_letter')) > 30000){
			return Redirect::to('job_program/'.$recipient_id.'/'.$job_id)->withInput()->with('flash_message', 'RL file too large');
		}

//////////////////////////////////////////////////////////////

        //save to database --- job_programs

        //need to check user_id here???



        
        //delete previous uploaded file
		//has to use first(), otherwise an array will not save()
		$job_program = Job_program::where('id', '=', "$job_id")->where('recipient_id', '=', "$recipient_id")->first();

		//Note this is a nested array need $RLfile[0] to get the next level!!!!
		if (count($job_program) > 0 ) {
			$preRLpath = $job_program->rl_path.'/'.$job_program->rl_id;
		} else {
			return Redirect::to('job_program_edit/'.$recipient_id.'/'.$job_id)->with('flash_message','Unable to find previous RL');
		}


		try{
					if (File::exists($preRLpath)) {
						File::delete($preRLpath);
					}
		} catch (Exception $e) {
					return Redirect::to('job_program_edit/'.$recipient_id.'/'.$job_id)->with('flash_message', 'Unable to delete previous RL files');
		}

		///////////////////////////////////////////////////////

        $fileRLOriName = str_replace(' ', '_', $fileRL->getClientOriginalName());

        $fileNameRL=uniqid().$fileRLOriName;
		

		$job_program->recipient_id=$recipient_id; 
		$job_program->job_program_name = $input['job_program'];
		$job_program->description = $input['description'];
		//need to convert string to date
		$job_program->due_date=date('Y-m-d', strtotime($input['dueDate']));
		$job_program->alert_date=date('Y-m-d',strtotime($input['alertDate']));
		$job_program->rl_id=$fileNameRL;
		$job_program->rl_name=$fileRL->getClientOriginalName();
		$job_program->rl_size=$fileRL->getSize();
		$job_program->rl_type=$filetypeRL;
		//move files
		$destinationPathRL=storage_path().'/files/RL';
		$fileRL->move($destinationPathRL, $fileNameRL);
		$job_program->rl_path=$destinationPathRL;


		
		try {
            $job_program->save();


            //send alert email
            $user=User::find(Auth::user()->id);

            $laterSec = strtotime($job_program->alert_date)-time();

	    	Mail::later($laterSec, 'emails.alert', array('due_date' => $job_program->due_date), function($message) use ($user){
			    $message->to($user->email, $user->firstname." ".$user->lastname);
			    $message->from('noreply@applicationorganizer.pagodabox.com', 'Do Not Reply');
			    $message->subject('Alert! Due date is coming.');
			});

			
           
 			$job_id=$job_program->id;
            return Redirect::to('show_job_program/'.$recipient_id.'/'.$job_id);
        }
        # Fail
        catch (Exception $e) {
            return Redirect::to('job_program_edit/'.$recipient_id.'/'.$job_id)->withInput()->with('flash_message', 'Unable to save your job program input');
        }




	}


	////////////////////////////
	///////////////////////////
	///////////////////////////

	public function destroyJobProgram($recipient_id, $job_id) {


		//check user_id
		$this_recipient=Recipient::where('id', '=', "$recipient_id")->get()->toArray();

    	if(count($this_recipient) > 0) {
    		$user_id=$this_recipient[0]['user_id'];

    	} else {
    		$user_id = -1; //flag for nonavailable id 
    	}

    	if ($user_id != Auth::user()->id) {
    		return Redirect::to('show_job_program/'.$recipient_id)->with('flash_message', "Access denied.");
    	} 

    	///////////////////////////////////////////////////////////////

		try {
				//"" for "$recipient_id"
				$job_program = Job_program::where('recipient_id', '=', "$recipient_id")->findOrFail($job_id);
		} catch(Exception $e) {
				return Redirect::to('show_job_program/'.$recipient_id)->with('flash_message', 'JOb/Program not found');
		}
	
			//associated files need to be deleted
			//////////////////////////////////////////////////////////
			//------------------Handling RL files----------------------
	
		
			foreach ($job_program as $id => $RLfile) {
				$RLpaths[$id] = $RLfile["rl_path"].'/'.$RLfile["rl_id"];
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

			
			# Note there's a `deleting` Model event which makes sure associated job_programs entries are also destroyed
			Job_program::destroy($job_id);

			return Redirect::to('show_job_program/'.$recipient_id)->with('flash_message','Your job/program has been deleted.');

	}


			public function getDownloadRL($recipient_id, $job_id) {


				$user_id = Auth::user()->id;

				//check access
				//need "" for $recipient_id otherwise, like a string '$recipient_di'
				$this_recipient = Recipient::where('id', '=', "$recipient_id")->get()->toArray();

				if(count($this_recipient) > 0) {
		    		$user_id=$this_recipient[0]['user_id'];
		    	} else {
		    		$user_id = -1; //flag for nonavailable id 
		    	}

		    	if ($user_id != Auth::user()->id) {
		    		return Redirect::to('show_job_program/'.$recipient_id)->with('flash_message', 'Access denied!');
		    	} 



				$RLfile=Job_program::where('id', '=', "$job_id")->where('recipient_id', '=', "$recipient_id")->get()->toArray();

				//Note this is a nested array need $RLfile[0] to get the next level!!!!
				if (count($RLfile) > 0 ) {
					$RLpath = $RLfile[0]["rl_path"].'/'.$RLfile[0]["rl_id"];
				} else {
					return Redirect::to('show_job_program/'.$recipient_id)->with('flash_message','Unable to find RL');
				}


				try{
					return Response::download($RLpath);
				}
				catch (Exception $e) {
					return Redirect::to('show_job_program/'.$recipient_id)->with('flash_message', 'Unable to download RL files');
				}


			} 

}