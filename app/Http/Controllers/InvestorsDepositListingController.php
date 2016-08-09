<?php 
namespace App\Http\Controllers;
use	\App\models\AdminInvestorsDepositListingModel;
use	Request;
class InvestorsDepositListingController extends MoneyMatchController {
	
	public $adminInvestorDeposit;
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->investorsDeposit = new AdminInvestorsDepositListingModel();
	}
		
	public function indexAction(){	
		
		$filter_status 	=	'3';
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

		$this->investorsDeposit->processDropDowns();
		
		$this->investorsDeposit->getInvestorAllDeposits($fromDate, $toDate, $filter_status);	
		
		$withArry	=	array(	"InvDepListMod" => $this->investorsDeposit, 
								"fromDate" => $fromDate, 
								"toDate" => $toDate,
								"all_Trans" => $filter_status,								
								"classname"=>"fa fa-cc fa-fw"); 
								
		return view('investor.investorsdepositlisting')
				->with($withArry); 
	
	}
	
	public function viewDepositAction($type,$payment_id){
		
		$processtype 	= $type;		
		
		$paymentId 		= base64_decode($payment_id);
		$paymentId 		= ($paymentId=="")?0:$paymentId;
		
		$submitted		=	false;
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			$this->investorsDeposit->saveInvestorDeposits($postArray);
			$submitted		=	true;
			if($processtype	==	"add") {
				return redirect()->to('investor/depositlist');
			}
		}
		$this->investorsDeposit->getCurrentInvestorDepositInfo($processtype,$paymentId);
	
		$withArry	=	array(	"adminInvDepViewMod" => $this->investorsDeposit, 								
								"classname"=>"fa fa-cc fa-fw",
								"processtype"=>$processtype,
								"submitted"=>$submitted
								
								); 
								
		return view('admin.admin-investorsdepositview')
				->with($withArry); 
		
	}
	
}
