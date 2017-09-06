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
		$transType 	=	'All';
		$fromDate	=	date("d-m-Y", strtotime("-1 Months"));
		$toDate		=	date("d-m-Y", strtotime("now"));

		
		if (isset($_REQUEST["fromdate"])) {
			$fromDate	=	$_REQUEST["fromdate"];
		}
		
		if (isset($_REQUEST["todate"])) {
			$toDate 	=	$_REQUEST["todate"];
		}
		
		if (isset($_REQUEST["transtype"])) {
			$transType = $_REQUEST["transtype"];
		}	
		$this->tranModel->getInvestorActivityReportInfo($transType, $fromDate, $toDate);		
		$withArry	=	array(	"tranModel" => $this->tranModel,
								"fromDate" 	=> $fromDate, 
								"toDate" 	=> $toDate,
								"tranType" 	=> $transType,
								"classname"	=>"fa fa-list-ul fa-fw");
		return view('investor.investor-transcationhistory')					
					->with($withArry); 
	}
	
}
