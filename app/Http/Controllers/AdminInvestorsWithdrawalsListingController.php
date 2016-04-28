<?php 
namespace App\Http\Controllers;
use	\App\models\AdminInvestorsWithdrawalsListingModel;
class AdminInvestorsWithdrawalsListingController extends MoneyMatchController {
	
	public $adminInvestorWithdrawalList;
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminInvestorWithdrawalList = new AdminInvestorsWithdrawalsListingModel();
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

		$this->adminInvestorWithdrawalList->processDropDowns();
		
		$this->adminInvestorWithdrawalList->viewWithDrawalList($fromDate, $toDate, $filter_status);
			
		$withArry	=	array(	"adminInvWithDrawListMod" => $this->adminInvestorWithdrawalList, 
								"fromDate" => $fromDate, 
								"toDate" => $toDate,
								"all_Trans" => $filter_status,
								"classname"=>"fa fa-cc fa-fw"); 
								
		return view('admin.admin-investorswithdrawalslisting')
				->with($withArry); 
	
	}
	
	public function viewWithDrawAction($type,$payment_id,$investor_id){
		
		$investorId 	= base64_decode($investor_id);
		$processtype 	= $type;		
		$paymentId 		= base64_decode($payment_id);
		$this->adminInvWithDrawListMod->getInvestorsWithDrawInfo($processtype,$investorId,$paymentId);
	
		$withArry	=	array(	"adminInvWithDrawListMod" => $this->adminInvestorWithdrawalList, 								
								"classname"=>"fa fa-cc fa-fw",
								); 
								
		return view('admin.admin-investorwithdrawalview')
				->with($withArry); 
		
	}
	
	public function InvestorWithDrawListBulkAction(){
		
		$processtype 	=	Request::get('processType');
		switch($processtype) {
			case	'approve':
				$this->bulkApproveWithDrawAction();
				break;
			case	'unapprove':
				$this->bulkUnApproveWithDrawAction();
				break;
			case	'delete':
				$this->bulkDeleteWithDrawAction();
				break;
		}		
		return redirect()->to('admin/investorswithdrawalslisting');
	}
	


	public function bulkApproveWithDrawAction(){		
		
		$postArray	=	Request::all();
		$this->adminInvWithDrawListMod->bulkApproveWithDraw($postArray);
	}
		
	public function bulkUnApproveWithDrawAction(){		
		
		$postArray	=	Request::all();
		$this->adminInvWithDrawListMod->bulkUnApproveWithDraw($postArray);
	}
		
	public function bulkDeleteWithDrawAction(){		
		
		$postArray	=	Request::all();
		$this->adminInvWithDrawListMod->bulkDeleteWithDraw($postArray);
	}
}
