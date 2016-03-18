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
		$this->bankProcessModel->getBanksList();
		$withArry		=	array(	"modelbankdet"=>$this->bankProcessModel);
		return view('common.bankdetails') 
					->with("classname","fa fa-university fa-fw user-icon"); 
	}

}
