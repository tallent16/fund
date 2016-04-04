<?php 
namespace App\Http\Controllers;
use	\App\models\InvestorDepositModel;
use Request;
class InvestorDepositController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->depositmodel= new InvestorDepositModel();
	}
	
	//render the investor withdraw page
	public function indexAction() {	
		$submitted	=	false;
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			$result		=	$this->depositmodel->getdepositdetails($postArray);
			$submitted	=	true;
		}		
		
		$withArry	=	array("modeldeposit"=>$this->depositmodel,
								"classname" => "fa fa-credit-card fa-fw user-icon",
								"submitted" =>$submitted);
		return view('investor.investor-deposit')
					->with($withArry);  
	}

}
