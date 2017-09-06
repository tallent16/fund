<?php namespace App\Http\Controllers;
use Request;
use	\App\models\LoanDetailsModel;
use	\App\models\BorrowerApplyLoanModel;
use Auth;
use Session;
use DB;
class LoanDetailsController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}

	//Additional initiate model
	public function littleMoreInit() {
		$this->loanDetailsModel	=	new LoanDetailsModel;
		$this->borrowerApplyLoanModel	=	new BorrowerApplyLoanModel;
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
			$result		=	$this->loanDetailsModel->processBid($postArray);
			if($result) {
				$submitted	=	true;
				Session::put("success",$this->loanDetailsModel->successTxt);
			}
			$subType	=	$postArray['isCancelButton'];			
		}
		
		$this->loanDetailsModel->getLoanDetails($sourceId[0]);
		$this->borrowerApplyLoanModel->getBorrowerLoanDetails($sourceId[0]);
		if(!empty($this->borrowerApplyLoanModel->loan_video_url)) {
			$this->borrowerApplyLoanModel->loan_video_url = $this->borrowerApplyLoanModel->convertVideoUrlToEmbedeUrl($this->borrowerApplyLoanModel->loan_video_url);
			
		}
		switch($this->loanDetailsModel->userType) {
				case USER_TYPE_BORROWER:
				case USER_TYPE_ADMIN:
					$viewTemplate	=	"borrower.borrower-myloans";
					break;
				case USER_TYPE_INVESTOR:
					$viewTemplate	=	"investor.investor-myloans";
					break;
		}	
		
		$detailArray = DB::table('loan_updates')
				->where('loan_id','=',$sourceId[0])
				->get();
		$withArry	=	array(	"LoanDetMod"=>$this->loanDetailsModel,
								"classname"=>"fa fa-file-text fa-fw",
								"loan_id"=>$loan_id,
								"submitted"=>$submitted,
								"subType"=>$subType,
								"BorModLoan"=>$this->borrowerApplyLoanModel,
								"adminLoanApprMod"=>$this->borrowerApplyLoanModel,
								"updateDetailArray"=>$detailArray
								);
		//print_r($withArry); die;
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
	
	public function ajaxAvailableBalanceAction() {
		$availableBalance		=	$this->loanDetailsModel->getInvestorAvailablBalance();
		return $availableBalance;
	}
	
	
	public function UpdateProjectAction($loan_id) {
		
		if(	$this->loanDetailsModel->userType	==	USER_TYPE_BORROWER) {
			$url		=	"creator/myprojects/".$loan_id;
		}else{
			$url		=	"admin/manageprojects/".$loan_id;
		}
		$postArray	=	Request::all();
		$result		=	$this->loanDetailsModel->saveProjectUpdates(base64_decode($loan_id),$postArray);
		$result		=	true;
		if($result) {
			$withArray	=	array("success"=>"Successfully Project Updated");
		}else{
			$withArray	=	array("failure"=>"nothing updated");
		}
		
		return redirect()->to($url)->with($withArray);
	}


	public function edit_update(){
		$postArray	=	Request::all();
		print_r($postArray);
	}
	
}
