<?php 
namespace App\Http\Controllers;
use Request;
use	\App\models\AdminChallengeQuestionsModel;

class AdminChallengeQuestionsController extends MoneyMatchController {
	
	public function __construct() {			
		
		$this->middleware('auth');
		$this->init();		
		
	}	
	
	public function littleMoreInit() {
		
		$this->adminchallengequestionModel	=	new AdminChallengeQuestionsModel;
		
	}
	
	public function indexAction() {
		
		$submitted	=	false;
		$this->adminchallengequestionModel->getSecurityQuestions();
	
		$withArry	=	array(	"adminchallqueModel" => $this->adminchallengequestionModel,
								"classname"=>"fa fa-cogs fa-fw",
								"submitted"=>$submitted 
							);
		return view('admin.admin-challengequestions')
					->with($withArry); 
		
	}
	
	public function saveAction() {
		
		$postArray	=	Request::all();
		$result		=	$this->adminchallengequestionModel->updateSecurityQuestions($postArray);
		$successTxt	=	$this->adminchallengequestionModel->getSystemMessageBySlug("update_challenge_question");
		if($result) {
			return redirect()->route('admin.challengequestions')
						->with('success',$successTxt);
		}else{
			return redirect()->route('admin.challengequestions')
						->with('failure','Something went wrong!');	
		}
	}
	
}
