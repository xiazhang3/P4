<?php
 
class JobProgramController extends BaseController {
	
	public function __construct() {

		$this->beforeFilter('auth');

    }


    //simiar to getRecipient()
    public function showJobPRogram($recipient_id, $job_id = NULL) {

    	//check whether user has access to this recipient
		$user_id = Auth::user()->id;

		$this_recipient = Recipient::where('id', '=', "$recipient_id")->get()->toArray();

		if(count($this_recipient) > 0) {
	    	$user_id=$this_recipient[0]['user_id'];
	    	$this_recipient_name = $this_recipient[0]['firstname']." ".$this_recipient[0]['lastname'];

	    	} else {
	    		$user_id = -1; //flag for nonavailable id 
	    	}

	    	if ($user_id != Auth::user()->id) {
	    		return Redirect::to('recipient')->with('flash_message', 'Access denied!');
	    } 


		//no need to check recipient has access to the job because of where
			if ($job_id != NULL) {
		$job_programs = Job_program::where('recipient_id', '=', "$recipient_id")->where('id', '=', "$job_id")->get();

	    } else {

		   $job_programs = Job_program::where('recipient_id', '=', "$recipient_id")->get();

	    }

		return View::make('show_job_program')->with('job_programs', $job_programs)->with('this_recipient_name', $this_recipient_name);
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

        $fileNameRL=uniqid().$fileRL->getClientOriginalName();
		

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
           
 			$job_id=$job_program->id;
            return Redirect::to('show_job_program/'.$recipient_id.'/'.$job_id);
        }
        # Fail
        catch (Exception $e) {
            return Redirect::to('job_program/'.$recipient_id)->withInput()->with('flash_message', 'Unable to save your job program input');
        }

	}


	public function getEditJobProgram($job_id) {

	}

	public function postEditJobProgram($job_id) {

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

}