<?php 
namespace App\Http\Controllers;
use	\App\models\AdminDisburseLoanModel;

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
		
		return view('admin.admin-disburseloan')->with(array("bidsModel" => $this->bidsModel,
													"classname"=>"fa fa-thumbs-up fa-fw"));	
		
	}
	
	public function saveDisburseLoanAction() {
		$this->bidsModel->saveDisburseLoan();
		return redirect('admin/loanlisting');
	
	}	
	
	public function ajaxGetLoanRepaySchedAction() {
		$loanId =	$_REQUEST["loan_id"];
		$disburseDate = $_REQUEST["disburse_date"];
		$retval = $this->bidsModel->computeRepaySchedule($loanId, $disburseDate);
		return $retval;
	
	}
	

}
