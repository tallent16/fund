<?php 
namespace App\Http\Controllers;
use Request;
use	\App\models\BorrowerApplyLoanModel;
class BorrowerApplyLoanController extends MoneyMatchController {

	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->borrowerApplyLoanModel	=	new BorrowerApplyLoanModel;
	}

	public function index() {
		
		$submitted	=	false;
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			echo "<pre>",print_r($postArray),"</pre>";
			die;
			$result		=	$this->borrowerApplyLoanModel->processLoan($postArray);
			$submitted	=	true;
		}
		$loan_id	=	isset($postArray['loan_id'])?$postArray['loan_id']:0;
		$this->borrowerApplyLoanModel->getBorrowerLoanDetails($loan_id);
		
		return view('borrower.borrower-applyloan')
					->with("BorModLoan",$this->borrowerApplyLoanModel)
					->with("classname","fa fa-usd fa-fw user-icon"); 
	}
}
