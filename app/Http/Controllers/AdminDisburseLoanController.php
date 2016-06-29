<?php 
namespace App\Http\Controllers;
use	\App\models\AdminDisburseLoanModel;
use Session;
class AdminDisburseLoanController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}	
	
	public function littleMoreInit() {
		$this->bidsModel	=	new AdminDisburseLoanModel;

	}	
	
	public function showDisburseLoanAction($loan_id) {
		$loan_id = base64_decode($loan_id);
		$this->bidsModel->getDisburseDetails($loan_id);
		// Computation will be based on today's date being the disbursal date
		$this->bidsModel->computeRepaySchedule($loan_id); 
		$this->bidsModel->getAllInvestorByLoan($loan_id);
	
		return view('admin.admin-disburseloan')->with(array("bidsModel" => $this->bidsModel,
													"classname"=>"fa fa-thumbs-up fa-fw"));	
		
	}
	
	public function saveDisburseLoanAction() {
		$this->bidsModel->saveDisburseLoan();
		Session::put("success",$this->bidsModel->successTxt);
		return redirect('admin/loanlisting');
	
	}	
	
	public function ajaxGetLoanRepaySchedAction() {
		$loanId =	$_REQUEST["loan_id"];
		$disburseDate = $_REQUEST["disburse_date"];
		$payByDay = $_REQUEST["monthly_pay_by_date"];
		$retval = $this->bidsModel->computeRepaySchedule($loanId, $disburseDate, $payByDay);
		return $retval;
	
	}
	
	public function ajaxGetInvestorRepaySchedAction() {
		$loanId		 	=	$_REQUEST["loan_id"];
		$investorId 	= 	$_REQUEST["investor_id"];
		$retval = $this->bidsModel->getInvestorRepay($loanId, $investorId);
		return $retval;
	
	}
	
	public function showViewLoanAction($loan_id) {
		$loan_id = base64_decode($loan_id);
		$this->bidsModel->getDisburseDetails($loan_id);
		
		$this->bidsModel->getAllInvestorByLoan($loan_id);
		$this->bidsModel->getBorrRepaySchd($loan_id);
		$this->bidsModel->getInvRepaySchd($loan_id);

		//echo "<pre>", print_r($this->bidsModel->repayment_schedule), "</pre>";
		//die;
		return view('admin.admin-disburseloan')->with(array("bidsModel" => $this->bidsModel,
													"classname"=>"fa fa-thumbs-up fa-fw"));	
		
	}
	
	public function saveReschedAction() {
		
		$this->bidsModel->prnt($_POST);
		return redirect('admin/loanlisting');
	}
	

}
