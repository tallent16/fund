<?php 
namespace App\Http\Controllers;
use	\App\models\AdminInvestorsDepositListingModel;
use	Request;
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
		$investorId 	= ($investorId=="")?0:$investorId;
		
		$processtype 	= $type;		
		
		$paymentId 		= base64_decode($payment_id);
		$paymentId 		= ($paymentId=="")?0:$paymentId;
		
		$submitted		=	false;
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			if($postArray['submitType']	==	"approve" || $postArray['submitType']	==	"save"){
				$this->adminInvestorsDeposit->saveInvestorDeposits($postArray);
			}else{
				$this->adminInvestorsDeposit->unApproveDeposit($postArray['trans_id']);
			}
			$submitted		=	true;
			if($processtype	==	"add") {
				return redirect()->to('admin/investordepositlist');
			}
		}
		$this->adminInvestorsDeposit->getInvestorsDepositInfo($processtype,$investorId,($paymentId=="")?0:$paymentId);
	
		$withArry	=	array(	"adminInvDepViewMod" => $this->adminInvestorsDeposit, 								
								"classname"=>"fa fa-cc fa-fw",
								"processtype"=>$processtype,
								"submitted"=>$submitted
								
								); 
								
		return view('admin.admin-investorsdepositview')
				->with($withArry); 
		
	}
	
	public function InvestorDepositListBulkAction(){
		
		$processtype 	=	Request::get('processType');
		switch($processtype) {
			case	'approve':
				$this->bulkApproveDepositAction();
				break;
			case	'unapprove':
				$this->bulkUnApproveDepositAction();
				break;
			case	'delete':
				$this->bulkDeleteDepositAction();
				break;
		}		
		return redirect()->to('admin/investordepositlist');
	}
	
	public function bulkApproveDepositAction(){		
		
		$postArray	=	Request::all();
		$this->adminInvestorsDeposit->bulkApproveDeposit($postArray);
	}
		
	
	public function bulkUnApproveDepositAction(){		
		
		$postArray	=	Request::all();
		$this->adminInvestorsDeposit->bulkUnApproveDeposit($postArray);
	}
		
	public function bulkDeleteDepositAction(){		
		
		$postArray	=	Request::all();
		$this->adminInvestorsDeposit->bulkDeleteDeposit($postArray);
	}
}
