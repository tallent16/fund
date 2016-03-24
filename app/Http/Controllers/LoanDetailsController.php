<?php namespace App\Http\Controllers;
use Request;
use	\App\models\LoanDetailsModel;
use Auth;
class LoanDetailsController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}

	//Additional initiate model
	public function littleMoreInit() {
		$this->loanDetailsModel	=	new LoanDetailsModel;
	}
	
	public function indexAction($loan_id) {
		
		$sourceId	=	explode("_",base64_decode($loan_id));
		if($this->loanDetailsModel->userType	==	USER_TYPE_BORROWER)	{
			$loanStatus		=	$this->loanDetailsModel->getLoanStatus($sourceId[0]);
			if($loanStatus	==	LOAN_STATUS_CANCELLED) {
				return redirect()->to('borrower/myloaninfo');
			}
		}
		$submitted	=	false;
		$subType	=	"";
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			$this->loanDetailsModel->processBid($postArray);
			$submitted	=	true;
			$subType	=	$postArray['isCancelButton'];
			
		}
		
		$this->loanDetailsModel->getLoanDetails($sourceId[0]);
		
		switch($this->loanDetailsModel->userType) {
				case USER_TYPE_BORROWER:
					$viewTemplate	=	"borrower.borrower-myloans";
					break;
				case USER_TYPE_INVESTOR:
					$viewTemplate	=	"investor.investor-myloans";
					break;
		}	
		$withArry	=	array(	"LoanDetMod"=>$this->loanDetailsModel,
								"classname"=>"fa fa-money fa-fw user-icon",
								"loan_id"=>$loan_id,
								"submitted"=>$submitted,
								"subType"=>$subType
								);
		return view($viewTemplate)
			->with($withArry);
	}
	
	public function ajaxSubmitCommentAction() {
		$postArray	=	Request::all();
		$result		=	$this->loanDetailsModel->insertComment($postArray);
		if($result) {
			return json_encode(array("status"=>"success","comment_id"=>$result));
		}else{
			return json_encode(array("status"=>"failed","comment_id"=>""));
		}
	}
	
	public function ajaxSubmitReplyAction() {
		$postArray	=	Request::all();
		$result		=	$this->loanDetailsModel->updateCommentReply($postArray);
		if($result) {
			return json_encode(array("status"=>"success"));
		}else{
			return json_encode(array("status"=>"failed"));
		}
	}

}
