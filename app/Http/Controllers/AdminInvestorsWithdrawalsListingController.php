<?php 
namespace App\Http\Controllers;
use	\App\models\AdminInvestorsWithdrawalsListingModel;
use Request;
use Auth;
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
		
		//~ $filter_status 	=	'All';
		//~ $fromDate	=	date("d-m-Y", strtotime("-12 Months"));
		//~ $toDate		=	date("d-m-Y", strtotime("now"));
		
		//~ if (isset($_REQUEST["fromdate"])) {
			//~ $fromDate	=	$_REQUEST["fromdate"];
		//~ }
		
		//~ if (isset($_REQUEST["todate"])) {
			//~ $toDate 	=	$_REQUEST["todate"];
		//~ }
		
		//~ if (isset($_REQUEST["filter_transcations"])) {
			//~ $filter_status = $_REQUEST["filter_transcations"];
		//~ }	

		$this->adminInvestorWithdrawalList->processDropDowns();
		
		//~ $this->adminInvestorWithdrawalList->viewWithDrawalList($fromDate, $toDate, $filter_status);
			
		$withArry	=	array(	"adminInvWithDrawListMod" => $this->adminInvestorWithdrawalList, 
								//~ "fromDate" => $fromDate, 
								//~ "toDate" => $toDate,
								//~ "all_Trans" => $filter_status,
								"classname"=>"fa fa-cc fa-fw"); 
								
		return view('admin.admin-investorswithdrawalslisting')
				->with($withArry); 
	
	}
	public function ajaxInvWithdrawList(){	
		
		$filter_status 	=	'All';
		$fromDate	=	date("d-m-Y", strtotime("-12 Months"));
		$toDate		=	date("d-m-Y", strtotime("now"));
		
		if (isset($_REQUEST["fromdate"])) {
			$fromDate	=	$_REQUEST["fromdate"];
		}
		
		if (isset($_REQUEST["todate"])) {
			$toDate 	=	$_REQUEST["todate"];
		}
		
		if (isset($_REQUEST["filter_transcations"])) {
			$filter_status = $_REQUEST["filter_transcations"];
		}	
		
		$row = $this->adminInvestorWithdrawalList->viewWithDrawalList($fromDate, $toDate, $filter_status);
		
		return json_encode(array("data"=>$row));	
	}
	public function viewWithdrawalAction($payment_id,$investor_id){
		
		$investorId 	= base64_decode($investor_id);
		$investorId 	= ($investorId=="")?0:$investorId;
		
		$processtype 	= "view";	
		
		$paymentId 		= base64_decode($payment_id);
		$paymentId 		= ($paymentId=="")?0:$paymentId;
		$submitted		=	false;
		
		$this->adminInvestorWithdrawalList->getInvestorsWithDrawInfo($processtype,$investorId,$paymentId);
		
		$withArry	=	array(	"adminInvWithDrawListMod" => $this->adminInvestorWithdrawalList, 								
								"classname"=>"fa fa-cc fa-fw",
								"processtype"=>$processtype,
								"submitted"=>$submitted
								); 
								
		return view('admin.admin-investorswithdrawalsview')
				->with($withArry); 
		
	}
	public function addWithdrawalAction($payment_id,$investor_id){
		
		$investorId 	= base64_decode($investor_id);
		$investorId 	= ($investorId=="")?0:$investorId;
		
		$processtype 	= "add";		
		
		$paymentId 		= base64_decode($payment_id);
		$paymentId 		= ($paymentId=="")?0:$paymentId;
		
		$this->adminInvestorWithdrawalList->getInvestorsWithDrawInfo($processtype,$investorId,$paymentId);
		$submitted		=	false;	
		$withArry	=	array(	"adminInvWithDrawListMod" => $this->adminInvestorWithdrawalList, 								
								"classname"=>"fa fa-cc fa-fw",
								"processtype"=>$processtype,
								"submitted"=>$submitted
								); 
								
		return view('admin.admin-investorswithdrawalsview')
				->with($withArry); 
		
	}
	public function editWithdrawalAction($payment_id,$investor_id){
		
		$investorId 	= base64_decode($investor_id);
		$investorId 	= ($investorId=="")?0:$investorId;
		
		$processtype 	= "edit";		
		
		$paymentId 		= base64_decode($payment_id);
		$paymentId 		= ($paymentId=="")?0:$paymentId;
		
		$this->adminInvestorWithdrawalList->getInvestorsWithDrawInfo($processtype,$investorId,$paymentId);
		$submitted		=	false;
		$withArry	=	array(	"adminInvWithDrawListMod" => $this->adminInvestorWithdrawalList, 								
								"classname"=>"fa fa-cc fa-fw",
								"processtype"=>$processtype,
								"submitted"=>$submitted
								); 
								
		return view('admin.admin-investorswithdrawalsview')
				->with($withArry); 
		
	}
	
	public function saveWithdrawalAction(){
		
		$postArray		=	Request::all();
		$this->adminInvestorWithdrawalList->saveInvestorWithDraws($postArray);
		$processType	=	$postArray['tranType'];
		$payment_id		=	$postArray['payment_id'];
		$investor_id	=	$postArray['investor_id'];
		if($processType	==	"add") {
			
			if(Auth::user()->usertype	==	USER_TYPE_ADMIN) {
				$successTxt	=	$this->adminInvestorWithdrawalList->getSystemMessageBySlug("save_withdrawal_by_admin");
				return redirect()->to('admin/investorwithdrawallist')->with("success",$successTxt);
			}else{
				$successTxt	=	$this->adminInvestorWithdrawalList->getSystemMessageBySlug("investor_withdrawal_submit");
				return redirect()->to('investor/withdrawallist')->with("success",$successTxt);
			}
		}
		if(Auth::user()->usertype	==	USER_TYPE_ADMIN) {
			$successTxt	=	$this->adminInvestorWithdrawalList->getSystemMessageBySlug("save_withdrawal_by_admin");
			return redirect()->route('admin.investorwithdrawaledit', array(	'payment_id'=>base64_encode($payment_id),
																			'investor_id'=>base64_encode($investor_id)
																		)
								)->with('success',$successTxt);
		}else{
			$successTxt	=	$this->adminInvestorWithdrawalList->getSystemMessageBySlug("investor_withdrawal_submit");
			
			return redirect()->route('investor.investorwithdrawaledit', array(		'type'		=>	'edit',
																					'payment_id'=>base64_encode($payment_id)
																		)
								)->with('success',$successTxt);
			
		}
	}
	
	public function approveWithdrawalAction() {
		
		$postArray		=	Request::all();
		$this->adminInvestorWithdrawalList->saveInvestorWithDraws($postArray);
		$processType	=	$postArray['tranType'];
		$payment_id		=	$postArray['payment_id'];
		$investor_id	=	$postArray['investor_id'];
		$successTxt		=	$this->adminInvestorWithdrawalList->getSystemMessageBySlug("investor_withdrawal_approved");
		if($processType	==	"add") {
			return redirect()->to('admin/investorwithdrawallist')->with("success",$successTxt);
		}
		return redirect()->route('admin.investorwithdrawaledit', array(	'payment_id'=>base64_encode($payment_id),
																		'investor_id'=>base64_encode($investor_id)
																	)
							)->with('success',$successTxt);
	}
	
	public function unapproveWithdrawalAction() {
		
		$postArray		=	Request::all();
		$payment_id		=	$postArray['payment_id'];
		$investor_id	=	$postArray['investor_id'];
		$successTxt		=	$this->adminInvestorWithdrawalList->getSystemMessageBySlug("investor_withdrawal_unapproved");
		$this->adminInvestorWithdrawalList->unApproveWithDraw($postArray['trans_id']);
		return redirect()->route('admin.investorwithdrawaledit', array(	
																		'payment_id'=>base64_encode($payment_id),
																		'investor_id'=>base64_encode($investor_id)
																	)
							)->with('success',$successTxt);
	}
	public function bulkApproveWithdrawalAction(){		
		
		$postArray	=	Request::all();
		$this->adminInvestorWithdrawalList->bulkApproveWithDraw($postArray);
		$successTxt	=	$this->adminInvestorWithdrawalList->getSystemMessageBySlug("investor_withdrawal_approved");
		return redirect()->to('admin/investorwithdrawallist')
					->with('success',$successTxt);
	}
	
	public function bulkUnApproveWithdrawalAction(){		
		
		$postArray	=	Request::all();
		$this->adminInvestorWithdrawalList->bulkunApproveWithDraw($postArray);
		$successTxt	=	$this->adminInvestorWithdrawalList->getSystemMessageBySlug("investor_withdrawal_unapproved");
		return redirect()->to('admin/investorwithdrawallist')
				->with('success',$successTxt);
	}
		
	public function bulkDeleteWithdrawalAction(){		
		
		$postArray	=	Request::all();
		$this->adminInvestorWithdrawalList->bulkDeleteWithDraw($postArray);
		return redirect()->to('admin/investorwithdrawallist')
					->with('success','Bulk Withdrawal Deleted successfully');
	}
}
