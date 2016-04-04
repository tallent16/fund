<?php 
namespace App\Http\Controllers;
use	\App\models\InvestorWithdrawModel;
use Request;
class InvestorWithdrawController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->withdrawmodel= new InvestorWithdrawModel();
	}
	
	//render the investor withdraw page
	public function indexAction() {	
			
		$withArry	=	array("modelwithdraw"=>$this->withdrawmodel,
								"classname" => "fa fa-credit-card fa-fw user-icon"
								);	
		return view('investor.investor-withdraw')					
					->with("classname","fa fa-university fa-fw user-icon"); 
	}

}
