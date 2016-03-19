<?php 
namespace App\Http\Controllers;
use	\App\models\InvestorMyLoanInfoModel;
use Request;
class InvestorMyLoanInfoController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->investorMyLoanInfoModel	=	new InvestorMyLoanInfoModel;
	}
	
	public function indexAction() {
		
		$filterLoanStatus_filter 	= 'all';
		
		if (isset($_REQUEST["loanstatus_filter"])) 
			$filterLoanStatus_filter 	= $_REQUEST["loanstatus_filter"];
			
		$withArry	=	array(	"InvModMyLoanInfo"=>$this->investorMyLoanInfoModel,
								"classname"=>"fa fa-usd fa-fw user-icon"
							);	
		$this->investorMyLoanInfoModel->getInvestorAllLoanDetails($filterLoanStatus_filter);	
		return view('investor.investor-myloaninfo')
			->with($withArry);
	}
}
