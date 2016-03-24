<?php namespace App\Http\Controllers;
use	\App\models\BorrowerMyLoanInfoModel;
use Request;
class BorrowerMyLoanInfoController extends MoneyMatchController {

	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->borrowerMyLoanInfoModel	=	new BorrowerMyLoanInfoModel;
	}
	
	public function indexAction() {
		$withArry	=	array(	"BorModMyLoanInfo"=>$this->borrowerMyLoanInfoModel,
								"classname"=>"fa fa-usd fa-fw user-icon"
							);	
		$this->borrowerMyLoanInfoModel->getBorrowerAllLoanDetails();	
		return view('borrower.borrower-myloaninfo')
			->with($withArry);
	}
	
	public function  cancelAction($loan_id) {
		
		$sourceID	=	base64_decode($loan_id);
		$loanStatus	=	$this->borrowerMyLoanInfoModel->getLoanStatus($sourceID);
		switch($loanStatus)	{
			case LOAN_STATUS_NEW:
			case LOAN_STATUS_SUBMITTED_FOR_APPROVAL:
			case LOAN_STATUS_APPROVED:
			case LOAN_STATUS_PENDING_COMMENTS:
			case LOAN_STATUS_CLOSED_FOR_BIDS:
				$this->borrowerMyLoanInfoModel->updateLoanStatus($sourceID);
			break;
		}
		return redirect()->to('borrower/myloaninfo');
	}
	
	public function ajaxRepayScheduleAction() {
		$loan_id 		= 	Request::get('loan_id');
		$response_data 	= 	$this->borrowerMyLoanInfoModel->getBorrowerRepaymentSchedule($loan_id);
		return json_encode(array("rows"=>$response_data));
	}
	
}
