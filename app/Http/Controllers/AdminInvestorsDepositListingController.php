<?php 
namespace App\Http\Controllers;
use	\App\models\AdminInvestorsDepositListingModel;
use	Request;
use Auth;
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
	
	public function viewDepositAction($payment_id,$investor_id){
		
		$investorId 	= base64_decode($investor_id);
		$investorId 	= ($investorId=="")?0:$investorId;
		
		$processtype 	= "view";		
		
		$paymentId 		= base64_decode($payment_id);
		$paymentId 		= ($paymentId=="")?0:$paymentId;
		
		$this->adminInvestorsDeposit->getInvestorsDepositInfo($processtype,$investorId,$paymentId);
		$submitted		=	false;
		$withArry	=	array(	"adminInvDepViewMod" => $this->adminInvestorsDeposit, 								
								"classname"=>"fa fa-cc fa-fw",
								"processtype"=>$processtype,
								"submitted"=>$submitted
								
								); 
								
		return view('admin.admin-investorsdepositview')
				->with($withArry); 
		
	}
	
	public function addDepositAction($payment_id,$investor_id){
		
		$investorId 	= base64_decode($investor_id);
		$investorId 	= ($investorId=="")?0:$investorId;
		
		$processtype 	= "add";		
		
		$paymentId 		= base64_decode($payment_id);
		$paymentId 		= ($paymentId=="")?0:$paymentId;
		
		$this->adminInvestorsDeposit->getInvestorsDepositInfo($processtype,$investorId,$paymentId);
		$submitted		=	false;
		$withArry	=	array(	"adminInvDepViewMod" => $this->adminInvestorsDeposit, 								
								"classname"=>"fa fa-cc fa-fw",
								"processtype"=>$processtype,
								"submitted"=>$submitted
								
								); 
								
		return view('admin.admin-investorsdepositview')
				->with($withArry); 
		
	}
	public function editDepositAction($payment_id,$investor_id){
		
		$investorId 	= base64_decode($investor_id);
		$investorId 	= ($investorId=="")?0:$investorId;
		
		$processtype 	= "edit";		
		
		$paymentId 		= base64_decode($payment_id);
		$paymentId 		= ($paymentId=="")?0:$paymentId;
		
		$this->adminInvestorsDeposit->getInvestorsDepositInfo($processtype,$investorId,$paymentId);
		$submitted		=	false;
		$withArry	=	array(	"adminInvDepViewMod" => $this->adminInvestorsDeposit, 								
								"classname"=>"fa fa-cc fa-fw",
								"processtype"=>$processtype,
								"submitted"=>$submitted
								
								); 
								
		return view('admin.admin-investorsdepositview')
				->with($withArry); 
		
	}
	
	public function saveDepositAction(){
		
		$postArray		=	Request::all();
		$this->adminInvestorsDeposit->saveInvestorDeposits($postArray);
		$processType	=	$postArray['tranType'];
		$payment_id		=	$postArray['payment_id'];
		$investor_id	=	$postArray['investor_id'];
		if($processType	==	"add") {
			if(Auth::user()->usertype	==	USER_TYPE_ADMIN) {
				$successTxt	=	$this->adminInvestorsDeposit->getSystemMessageBySlug("save_deposit_by_admin");
				return redirect()->to('admin/investordepositlist')->with("success",$successTxt);
			}else{
				$successTxt	=	$this->adminInvestorsDeposit->getSystemMessageBySlug("investor_deposit_submit");
				return redirect()->to('investor/depositlist')->with("success",$successTxt);
			}
		}
		if(Auth::user()->usertype	==	USER_TYPE_ADMIN) {
			$successTxt	=	$this->adminInvestorsDeposit->getSystemMessageBySlug("save_deposit_by_admin");
			return redirect()->route('admin.investordepositedit', array(	'payment_id'=>base64_encode($payment_id),
																			'investor_id'=>base64_encode($investor_id)
																		)
								)->with('success',$successTxt);
		}else{
			$successTxt	=	$this->adminInvestorsDeposit->getSystemMessageBySlug("investor_deposit_submit");
			return redirect()->route('investor.investordepositedit', array(		'type'		=>	'edit',
																				'payment_id'=>base64_encode($payment_id)
																		)
								)->with('success',$successTxt);
			
		}
	}
	
	public function approveDepositAction() {
		
		$postArray		=	Request::all();
		$this->adminInvestorsDeposit->saveInvestorDeposits($postArray);
		$processType	=	$postArray['tranType'];
		$payment_id		=	$postArray['payment_id'];
		$investor_id	=	$postArray['investor_id'];
		$successTxt	=	$this->adminInvestorsDeposit->getSystemMessageBySlug("investor_deposit_approved");
		if($processType	==	"add") {
			return redirect()->to('admin/investordepositlist')->with("success",$successTxt);
		}
		return redirect()->route('admin.investordepositedit', array(	'payment_id'=>base64_encode($payment_id),
																		'investor_id'=>base64_encode($investor_id)
																	)
							)->with('success',$successTxt);
	}
	
	public function unapproveDepositAction() {
		
		$postArray		=	Request::all();
		$payment_id		=	$postArray['payment_id'];
		$investor_id	=	$postArray['investor_id'];
		
		$this->adminInvestorsDeposit->unApproveDeposit($postArray['trans_id']);
		$successTxt	=	$this->adminInvestorsDeposit->getSystemMessageBySlug("investor_deposit_unapproved");
		return redirect()->route('admin.investordepositedit', array(	
																		'payment_id'=>base64_encode($payment_id),
																		'investor_id'=>base64_encode($investor_id)
																	)
							)->with('success',$successTxt);
	}
	
	public function bulkApproveDepositAction(){		
		
		$postArray	=	Request::all();
		$this->adminInvestorsDeposit->bulkApproveDeposit($postArray);
		$successTxt	=	$this->adminInvestorsDeposit->getSystemMessageBySlug("investor_deposit_approved");
		return redirect()->to('admin/investordepositlist')
					->with('success',$successTxt);
	}
		
	
	public function bulkUnApproveDepositAction(){		
		
		$postArray	=	Request::all();
		$this->adminInvestorsDeposit->bulkUnApproveDeposit($postArray);
		$successTxt	=	$this->adminInvestorsDeposit->getSystemMessageBySlug("investor_deposit_unapproved");
		return redirect()->to('admin/investordepositlist')
					->with('success',$successTxt);
	}
		
	public function bulkDeleteDepositAction(){		
		
		$postArray	=	Request::all();
		$this->adminInvestorsDeposit->bulkDeleteDeposit($postArray);
		
		return redirect()->to('admin/investordepositlist')
					->with('success','Bulk Deposit Deleted successfully');
	}
}
