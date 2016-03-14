<?php namespace App\Http\Controllers;
use Request;
use	\App\models\LoanDetailsModel;
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
		$this->loanDetailsModel->getLoanDetails($sourceId[0]);
		return view('borrower.borrower-myloans')
			->with("classname","fa fa-money fa-fw user-icon")
			->with("loan_id",$loan_id)
			->with("LoanDetMod",$this->loanDetailsModel);
	}

}
