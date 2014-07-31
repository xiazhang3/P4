<?php
 
class RecLettOrgController extends BaseController {
	
	public function __construct() {

		$this->beforeFilter('auth');

    }

    public function getRecLettOrg(){
		return View::make('recLett');
	}

	public function postRecLettOrg() {

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
			'job_program' => array('alpha', 'required'),
			'description' => array('alpha_num', 'required'),
			'dueDate' => 'date_format:Y/m/d|date',
			'alertDate' => 'date_format:Y/m/d|date',
			'recommendation_letter' => 'max:300000|required'
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

		$fileRL = Input::file('recommendation_letter');
		$filetypeRL = $fileRL->getMimeType();

		if(!$fileRL->isValid()){
			return Redirect::to('rec-lett-org')->withInput()->with('flash_message', 'Files not valid');
		}else if ($filetypeRL!="application/pdf"&&$filetypeRL!="application/msword"&&$filetypeRL!="application/vnd.openxmlformats-officedocument.wordprocessingml.document") {
				return Redirect::to('rec-lett-org')->withInput()->with('flash_message', 'The input recommendation letter should be in pdf, doc, docx format');
		} else if (filesize(Input::file('recommendation_letter')) >300000){
			return Redirect::to('rec-lett-org')->withInput()->with('flash_message', 'RL file too large');
		}



//////////////////////////////////////////////////////////////
		//save to the database
		//recipient_database
		$fileNameCV=uniqid().$fileCV->getClientOriginalName();
		

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
        }
        # Fail
        catch (Exception $e) {
            return Redirect::to('/rec-lett-org')->withInput()->with('flash_message', 'Unable to save your input');
        }

//////////////////////////////////////////////////////////////
        //save to database --- job_programs

        $fileNameRL=uniqid().$fileRL->getClientOriginalName();
		

		$job_program = new Job_program();
		$job_program->recipient()->associate($recipient); 
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
        }
        # Fail
        catch (Exception $e) {
            return Redirect::to('/rec-lett-org')->withInput()->with('flash_message', 'Unable to save your job program input');
        }

	}	

////////////////////////////////////////////////////////////////
		public function getRecipient() {
			$user_id = Auth::user()->id;
			$recipients = Recipient::with('user')->whereHas('user', function($q) use($user_id) {
				$q->where('id', '=', "$user_id");
			})->orderBy('lastname')->orderBy('firstname')->get();

			return View::make('recipient')->with('recipients', $recipients);
		}


}




