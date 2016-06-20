<?php 
namespace App\Http\Controllers;
use Request;
use	\App\models\AdminManageInvestorsModel;
use	\App\models\InvestorProfileModel;
class AdminManageInvestorsController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->admininvModel		=	new AdminManageInvestorsModel;
		$this->investorProfileModel	=	new InvestorProfileModel;
	}
	
	public function indexAction(){
		
		$filterInvestorStatus_filter 	= 'all';
		
		if (isset($_REQUEST["investorstatus_filter"])) 
			$filterInvestorStatus_filter 	= $_REQUEST["investorstatus_filter"];
		$this->admininvModel->getManageInvestorDetails($filterInvestorStatus_filter);				
		$withArry	=	array(		"InvPrfMod"=>$this->investorProfileModel,
									"admininvModel"=>$this->admininvModel,
									"classname"=>"fa fa-reply fa-fw user-icon"
								);	
		return view('admin.admin-manageinvestors')
				->with($withArry);
		
	}
	
	public function viewProfileAction($inv_id){
		
		$submitted	=	false;
		$inv_id		=	base64_decode($inv_id);
		
		 if(!$this->investorProfileModel->CheckInvestorExists($inv_id)){
			return redirect()->to('admin/manageinvestors');
		}
		$this->investorProfileModel->getInvestorDetails($inv_id);
		$withArry	=	array(		"InvPrfMod"=>$this->investorProfileModel,
									"InvBorPrf"=>$this->investorProfileModel,
									"classname"=>"fa fa-reply fa-fw user-icon",
									"submitted"=>$submitted
								);	
		return view('investor.investor-profile')
				->with($withArry);
		
	}
	
	
	public function saveCommentProfileAction(){
		
		$postArray	=	Request::all();
		echo "<pre>",print_r($postArray),"</pre>";
		
		$inv_id		=	$postArray['investor_id'];
		
		$result		=	$this->investorProfileModel->saveComments($postArray['comment_row'],$inv_id);
		
		if($result) {
			$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("investor_profile_comments_saved");
			return redirect()->route('admin.investorprofile', array('inv_id' => base64_encode($inv_id)	))
						->with('success',$successMsg);
		}else{
			return redirect()->route('admin.investorprofile', array('inv_id' => base64_encode($inv_id) ))
						->with('failure','Investor Profile comments saved Failed');	
		}	
	}
	
	public function returnInvestorProfileAction(){
		
		$postArray	=	Request::all();
		$inv_id		=	$postArray['investor_id'];
		$dataArray 	= 	array(	'status' 	=>	INVESTOR_STATUS_COMMENTS_ON_ADMIN );
		$this->investorProfileModel->saveComments($postArray['comment_row'],$inv_id);
		$result		=	$this->investorProfileModel->updateInvestorStatus($dataArray,$inv_id,"return_investor");
		if($result) {
			$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("investor_profile_return_to_investor");
			return redirect()->route('admin.investorprofile', array('inv_id' => base64_encode($inv_id)	))
						->with('success',$successMsg);
		}else{
			return redirect()->route('admin.investorprofile', array('inv_id' => base64_encode($inv_id) ))
						->with('failure','Profile returned to Investor Failed');	
		}	
	}
	
	public function approveInvestorProfileAction(){
			
		$postArray	=	Request::all();
		$inv_id		=	$postArray['investor_id'];
		$dataArray 	= 	array(	'status' 	=>	INVESTOR_STATUS_VERIFIED );
		if(isset($postArray['comment_row'])){
			$this->investorProfileModel->saveComments($postArray['comment_row'],$inv_id);
		}
		$result		=	$this->investorProfileModel->updateInvestorStatus($dataArray,$inv_id,"approve");
		if($result) {
			$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("investor_profile_approved");
			return redirect()->route('admin.investorprofile', array('inv_id' => base64_encode($inv_id)	))
						->with('success',$successMsg);
		}else{
			return redirect()->route('admin.investorprofile', array('inv_id' => base64_encode($inv_id) ))
						->with('failure','Investor Profile information Failed approved');	
		}	
	}
	
	public function approveInvestorAction($inv_id){
		
		$inv_id		=	base64_decode($inv_id);
		if(!$this->investorProfileModel->CheckInvestorExists($inv_id)){
			return redirect()->to('admin/manageinvestors');
		}
		$inv_profile_status	=	$this->investorProfileModel->getInvestorProfileStatus($inv_id);
		
		$dataArray = array(	'status' 	=>	INVESTOR_STATUS_VERIFIED );
		if($inv_profile_status	==	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL) {
			$result		=	$this->investorProfileModel->updateInvestorStatus($dataArray,$inv_id,"approve");
			if($result) {
				$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("investor_profile_approved");
				return redirect()->route('admin.manageinvestors')
							->with('success',$successMsg);
			}else{
				return redirect()->route('admin.manageinvestors')
							->with('failure','Investor Profile information Failed approved');	
			}
		}
		return redirect()->to('admin/manageinvestors');
	}
	
	public function rejectInvestorAction($inv_id){
		
		$inv_id		=	base64_decode($inv_id);
		if(!$this->investorProfileModel->CheckInvestorExists($inv_id)){
			return redirect()->to('admin/manageinvestors');
		}
		$inv_profile_status	=	$this->investorProfileModel->getInvestorProfileStatus($inv_id);
		
		
		$dataArray = array(	'status' 	=>	INVESTOR_STATUS_REJECTED );
		if( ($inv_profile_status	==	INVESTOR_STATUS_NEW_PROFILE) 
				|| ($inv_profile_status	==	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL)) {
			$result		=	$this->investorProfileModel->updateInvestorStatus($dataArray,$inv_id);
			if($result) {
				$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("investor_profile_reject");
				return redirect()->route('admin.manageinvestors')
							->with('success',$successMsg);
			}else{
				return redirect()->route('admin.manageinvestors')
							->with('failure','Investor Profile rejected Failed');	
			}
		}
		return redirect()->to('admin/manageinvestors');
	}
	
	public function deleteInvestorAction($inv_id){
		
		$inv_id		=	base64_decode($inv_id);
		if(!$this->investorProfileModel->CheckInvestorExists($inv_id)){
			return redirect()->to('admin/manageinvestors');
		}
		$inv_profile_status	=	$this->investorProfileModel->getInvestorProfileStatus($inv_id);
		
		$dataArray = array(	'status' 	=>	INVESTOR_STATUS_DELETED );
		if($this->investorProfileModel->getInvestorActiveLoanStatus($inv_id)	==	0) {
			$result		=	$this->investorProfileModel->updateInvestorStatus($dataArray,$inv_id);
			if($result) {
				$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("investor_profile_inactive");
				return redirect()->route('admin.manageinvestors')
							->with('success',$successMsg);
			}else{
				return redirect()->route('admin.manageinvestors')
							->with('failure','Investor Profile has been made inactive Failed');	
			}
		}
		return redirect()->to('admin/manageinvestors');
	}
	
	public function approveInvestorBulkAction(){
		
		$postArray	=	Request::all();
		$result		=	$this->investorProfileModel->updateBulkInvestorStatus($postArray,"approve");
		if($result) {
			$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("investor_profile_approved");
			return redirect()->route('admin.manageinvestors')
						->with('success',$successMsg);
		}else{
			return redirect()->route('admin.manageinvestors')
						->with('failure','Investor Profile information Failed approved');	
		}
	}
	
	public function rejectInvestorBulkAction(){
		
		$postArray	=	Request::all();
		$result		=	$this->investorProfileModel->updateBulkInvestorStatus($postArray,"reject");
		if($result) {
			$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("investor_profile_reject");
			return redirect()->route('admin.manageinvestors')
						->with('success',$successMsg);
		}else{
			return redirect()->route('admin.manageinvestors')
						->with('failure','Investor Profile rejected Failed');	
		}
	}
	
	public function deleteInvestorBulkAction(){
		
		$postArray	=	Request::all();
		$result		=	$this->investorProfileModel->updateBulkInvestorStatus($postArray,"delete");
		if($result) {
			$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("investor_profile_inactive");
			return redirect()->route('admin.manageinvestors')
						->with('success',$successMsg);
		}else{
			return redirect()->route('admin.manageinvestors')
						->with('failure','Investor Profile has been made inactive Failed');	
		}
	}
	
	public function ajaxAvailableBalanceByIDAction() {
		
		$investorId				=	Request::get("investor_id");
		$availableBalance		=	$this->investorProfileModel->getInvestorAvailableBalanceById($investorId);
		return $availableBalance;
	}
	
		public function saveInvestorProfileAction(){
		
		$postArray	=	Request::all();
		$inv_id		=	$postArray['investor_id'];
		$result		=	$this->investorProfileModel->processProfile($postArray,$inv_id);
		if($result) {
			$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("investor_profile_approved");
			return redirect()->route('admin.investorprofile', array('inv_id' => base64_encode($inv_id)	))
						->with('success',$successMsg)
						->with('activeTab',$postArray['active_tab']);
		}else{
			
			return redirect()->route('admin.investorprofile', array('inv_id' => base64_encode($inv_id) ))
						->with('failure','Investor Profile information Failed approved')
						->with('activeTab',$postArray['active_tab']);
		}	
	}
}
