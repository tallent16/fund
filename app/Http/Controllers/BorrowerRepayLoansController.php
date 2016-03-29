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
								"classname" => "fa fa-university fa-fw user-icon"
								);
								
		return view('borrower.borrower-repayloans')			
				->with($withArry); 
	}

}
