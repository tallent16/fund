<?php 
namespace App\Http\Controllers;
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
		
		$this->adminchallengequestionModel->getSecurityQuestions();
		$withArry	=	array(	"adminchallqueModel" => $this->adminchallengequestionModel);
		return view('admin.admin-challengequestions')
					->with($withArry); 
		
	}
	
	
}
