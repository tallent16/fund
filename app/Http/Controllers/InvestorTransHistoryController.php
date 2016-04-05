<?php 
namespace App\Http\Controllers;
use	\App\models\InvestorTransHistoryModel;
use Request;
class InvestorTransHistoryController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->tranModel = new InvestorTransHistoryModel();
	}	

	//render the Investor Transcation History
	public function indexAction() {		
		
		$this->tranModel->getInvestorTransList();
		$withArry	=	array(	"tranModel" => $this->tranModel,
								"classname"=>"fa fa-credit-card fa-fw user-icon");
		return view('investor.investor-transcationhistory')					
					->with($withArry); 
	}
	
}
