<?php namespace App\Http\Controllers;
use	\App\models\BorrowerRepayLoansModel;

use Request;
class BorrowerRepayLoansController extends MoneyMatchController {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{	
		$this->middleware('auth');
		$this->init();		
	}

	public function littleMoreInit() {
		$this->repayloanmodel= new BorrowerRepayLoansModel();
	}

	/**
	 * Show the application repay loans to the user.
	 *
	 * @return Response
	 */
	public function indexAction()
	{
		$this->repayloanmodel->getUnpaidLoans();	
		$withArry	=	array("modelrepayloan"=>$this->repayloanmodel,
								"classname" => "fa fa-credit-card fa-fw user-icon"
								);								
		return view('borrower.borrower-repayloans')			
				->with($withArry); 
	}
	
	public function paymentAction($repayment_id,$loan_id)
	{
		$repaymentId = base64_decode($repayment_id);	
		$loanid	= 	base64_decode($loan_id);
	
		$submitted		=	false;
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			$result		=	$this->repayloanmodel->saveRepayment($postArray);
			$submitted		=	true;
		}
		$this->repayloanmodel->getRepaymentDetails($repaymentId,$loanid);
	
		$withArry	=	array(	"adminBorRepayViewMod" => $this->repayloanmodel, 								
								"classname"=>"fa fa-cc fa-fw",
								"submitted"=>$submitted,
								"type"=>"edit"); 
								
		return view('admin.admin-borrowersrepaymentview')
				->with($withArry); 
							
	}
	
	public function recalculatePenalityAction(){		

		$postArray	=	Request::all();
		$result	=	$this->repayloanmodel->recalculatePenality($postArray);
		return	json_encode($result);
	}

}
