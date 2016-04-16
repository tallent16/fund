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
		
		$this->bidsModel->getDisburseDetails($loan_id);
		
		return view('admin.admin-disburseloan')->with(["bidsModel" => $this->bidsModel]);
		
	}

}
