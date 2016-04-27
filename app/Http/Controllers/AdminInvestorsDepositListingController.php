<?php 
namespace App\Http\Controllers;
use	\App\models\AdminInvestorsDepositListingModel;
class AdminInvestorsDepositListingController extends MoneyMatchController {
	
	public $adminInvestorDeposit;
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminInvestorsDeposit = new AdminInvestorsDepositListingModel();
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

		$this->adminInvestorsDeposit->processDropDowns();
		
		$this->adminInvestorsDeposit->viewDepositList($fromDate, $toDate, $filter_status);	
		
		$withArry	=	array(	"adminInvDepListMod" => $this->adminInvestorsDeposit, 
								"fromDate" => $fromDate, 
								"toDate" => $toDate,
								"all_Trans" => $filter_status,								
								"classname"=>"fa fa-cc fa-fw"); 
								
		return view('admin.admin-investorsdepositlisting')
				->with($withArry); 
	
	}
	public function viewDepositAction($type,$payment_id,$investor_id){
		
		$investorId 	= base64_decode($investor_id);
		$processtype 	= $type;		
		$paymentId 		= base64_decode($payment_id);
		$this->adminInvestorsDeposit->getInvestorsDepositInfo($processtype,$investorId,
													($paymentId)==""?0:$paymentId);		
		/* $submitted		= false;
		 * if (Request::isMethod('post')) {
			$postArray	=	Request::all();
		//	$this->adminInvestorsDeposit->processInvestorDropDowns($investorId);
			$submitted	=	true;
		}*/
		
		
		$withArry	=	array(	"adminInvDepViewMod" => $this->adminInvestorsDeposit, 								
								"classname"=>"fa fa-cc fa-fw",
								); 
								
		return view('admin.admin-investorsdepositview')
				->with($withArry); 
		
	}
}
