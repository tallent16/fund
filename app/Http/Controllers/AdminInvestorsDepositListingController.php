<?php 
namespace App\Http\Controllers;
use	\App\models\AdminInvestorsDepositListingModel;
class AdminInvestorsDepositListingController extends MoneyMatchController {
	
	public $adminInvestorDepositList;
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminInvestorsDepositList = new AdminInvestorsDepositListingModel();
	}
		
	public function indexAction(){	
		
		$filter_status 	=	'All';
		$fromDate	=	date("d-m-Y", strtotime("-12 Months"));
		$toDate		=	date("d-m-Y", strtotime("now"));
		
		if (isset($_REQUEST["fromdate"])) {
			$fromDate	=	$_REQUEST["fromdate"];
		}
		
		if (isset($_REQUEST["todate"])) {
			$toDate 	=	$_REQUEST["todate"];
		}
		
		if (isset($_REQUEST["filter_status"])) {
			$filter_status = $_REQUEST["filter_status"];
		}	

		$this->adminInvestorsDepositList->processDropDowns();
		
		$this->adminInvestorsDepositList->viewDepositList($fromDate, $toDate, $filter_status);	
		
		$withArry	=	array(	"adminInvDepListMod" => $this->adminInvestorsDepositList, 
								"fromDate" => $fromDate, 
								"toDate" => $toDate,
								"all_Trans" => $filter_status,								
								"classname"=>"fa fa-cc fa-fw"); 
								
		return view('admin.admin-investorsdepositlisting')
				->with($withArry); 
	
	}
}
