<?php namespace App\Http\Controllers;
use	\App\models\BankProcessModel;
use Request;
use Session;
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
		$tranType	=	"edit";
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			$result		=	$this->bankProcessModel->processBankDetails($postArray);
			$tranType	=	$postArray['transtype'];
			Session::put("success",$this->bankProcessModel->successTxt);
		}
		
		$this->bankProcessModel->getBanksList();
		
		$withArry		=	array(	"modelbankdet"=>$this->bankProcessModel,
									"classname"=>"fa fa-university fa-fw user-icon",
									"submitted"=>$submitted,
									"tranType"=>$tranType	);
									
		return view('common.bankdetails') 
					->with($withArry); 
	}

}
