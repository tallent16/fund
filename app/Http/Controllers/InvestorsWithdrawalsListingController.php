<?php 
namespace App\Http\Controllers;
use	\App\models\AdminInvestorsWithdrawalsListingModel;
use Request;
class	InvestorsWithdrawalsListingController extends MoneyMatchController {
	
	public $adminInvestorWithdrawalList;
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->investorWithdrawalList = new AdminInvestorsWithdrawalsListingModel();
	}
		
	public function indexAction(){			
		
		
		$filter_status 	=	'all';
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

		$this->investorWithdrawalList->processDropDowns();
		
		$this->investorWithdrawalList->getInvestorAllWithDrawals($fromDate, $toDate, $filter_status);
			
		$withArry	=	array(	"InvWithDrawListMod" => $this->investorWithdrawalList, 
								"fromDate" => $fromDate, 
								"toDate" => $toDate,
								"all_Trans" => $filter_status,
								"classname"=>"fa fa-cc fa-fw"); 
								
		return view('investor.investorswithdrawalslisting')
				->with($withArry); 
	
	}
	
	public function viewWithDrawAction($type,$payment_id) {
		
		$processtype 	= $type;		
		
		$paymentId 		= base64_decode($payment_id);
		$paymentId 		= ($paymentId=="")?0:$paymentId;
		$submitted		=	false;
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			
			$this->investorWithdrawalList->saveInvestorWithDraws($postArray);
			$submitted		=	true;
			if($processtype	==	"add") {
				die;
				return redirect()->to('backer/withdrawallist'); 
			}
		}
		
		$this->investorWithdrawalList->getCurrentInvestorWithDrawInfo($processtype,$paymentId);
		
		$withArry	=	array(	"adminInvWithDrawListMod" => $this->investorWithdrawalList, 								
								"classname"=>"fa fa-cc fa-fw",
								"processtype"=>$processtype,
								"submitted"=>$submitted
								); 
								
		return view('admin.admin-investorswithdrawalsview')
				->with($withArry); 
		
	}
	
}
