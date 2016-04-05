<?php 
namespace App\Http\Controllers;
use	\App\models\InvestorBankModel;
use Request;
class InvestorBankController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->depositmodel= new InvestorBankModel();
	}
	
	//render the investor deposit
	public function indexAction() {	
		
		
		$submitted	=	false;
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			$result		=	$this->depositmodel->newdeposit($postArray);
			$submitted	=	true;
		}		
		$this->depositmodel->getprocessdeposit();
		$withArry	=	array("modeldeposit"=>$this->depositmodel,
								"classname" => "fa fa-credit-card fa-fw user-icon",
								"submitted" =>$submitted);
		return view('investor.investor-deposit')
					->with($withArry);  
	}
	//render the investor withdraw
	public function withdrawAction() {	
		
		
		$submitted	=	false;
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			$result		=	$this->depositmodel->newwithdraw($postArray);
			$submitted	=	true;
		}		
		$this->depositmodel->getprocessdeposit();
		$withaArry	=	array("modelwithdraw"=>$this->depositmodel,
								"classname" => "fa fa-cc fa-fw user-icon",
								"submitted"=>$submitted);
		return view('investor.investor-withdraw')
				->with($withaArry);		
	}

}
