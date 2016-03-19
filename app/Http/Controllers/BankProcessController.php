<?php namespace App\Http\Controllers;
use	\App\models\BankProcessModel;
use Request;
class BankProcessController extends MoneyMatchController {


	/*------------------------------------------------------------
	 *  Bank Details is common to both Investors' and Borrowers' modules
	 *  
	 * */
	

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
		
		$this->bankProcessModel	=	new BankProcessModel;
	}
	/**
	 * Show the application bank details to the user.
	 *
	 * @return Response
	 */
	public function indexAction()
	{
		
		$submitted	=	false;
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			$result		=	$this->bankProcessModel->processBankDetails($postArray);
			$submitted	=	true;
		}
		
		
		$this->bankProcessModel->getBanksList();
		
		$withArry		=	array(		"modelbankdet"=>$this->bankProcessModel
									,"fa fa-university fa-fw user-icon"	);
									
		return view('common.bankdetails') 
					->with($withArry); 
	}

}
