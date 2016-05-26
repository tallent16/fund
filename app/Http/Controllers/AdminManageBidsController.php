<?php 
namespace App\Http\Controllers;
use	\App\models\AdminManageBidsModel;
use Auth;
class AdminManageBidsController extends MoneyMatchController {
	
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}	

	public function littleMoreInit() {
		$this->bidsModel	=	new AdminManageBidsModel;
	}

	public function getLoanDetailsAction($loan_id) {
		$this->bidsModel->getLoanBids($loan_id);
		
		return view('admin.admin-managebids')->with(array("bidsModel" => $this->bidsModel,
														"classname"=>"fa fa-gavel fa-fw"));
		
	}
		
	public function bidCloseAction() {
		$loan_id = $_REQUEST['loan_id'];

		$this->bidsModel->closeBids($loan_id);
		$this->bidsModel->getLoanBids($loan_id);
		return view('admin.admin-managebids')->with(["bidsModel" => $this->bidsModel]);

	}
	
	public function acceptBidsAction() {
		$loan_id = $_REQUEST['loan_id'];

		$retval = $this->bidsModel->acceptBids($loan_id);
		
		$this->bidsModel->getLoanBids($loan_id);
		return view('admin.admin-managebids')->with(["bidsModel" => $this->bidsModel]);

		
	}
	
	public function loanCancelAction() {
		
		$userType			=	Auth::user()->usertype;
		if($userType	==	USER_TYPE_ADMIN) {
			return redirect('admin/loanlisting');
		}else{
			return redirect('borrower/myloaninfo');
		}
	}
	
/*	public function indexAction(){
		$this->bidsModel->getLoanBids(6);
		return view('admin.admin-managebids')->with(["bidsModel" => $this->bidsModel]);

	}
	*/
	
}
