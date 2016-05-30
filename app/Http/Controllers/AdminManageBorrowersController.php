<?php 
namespace App\Http\Controllers;
use Request;
use	\App\models\AdminManageBorrowersModel;
use	\App\models\BorrowerProfileModel;
class AdminManageBorrowersController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminborModel		=	new AdminManageBorrowersModel;
		$this->borrowerProfileModel	=	new BorrowerProfileModel;
	}
	
	public function indexAction(){
		
		$filterBorrowerStatus_filter 	= 'all';
		
		if (isset($_REQUEST["borrowerstatus_filter"])) 
			$filterBorrowerStatus_filter 	= $_REQUEST["borrowerstatus_filter"];
		$this->adminborModel->getManageBorrowerDetails($filterBorrowerStatus_filter);				
		$withArry	=	array(		"adminbormodel"=>$this->adminborModel,
									"classname"=>"fa fa-reply fa-fw user-icon"
								);	
		return view('admin.admin-manageborrowers')
				->with($withArry);
		
	}
	
	public function viewProfileAction($bor_id){
		
		$submitted	=	false;
		$bor_id		=	base64_decode($bor_id);
		
		 if(!$this->borrowerProfileModel->CheckBorrowerExists($bor_id)){
			return redirect()->to('admin/manageborrowers');
		}
		$this->borrowerProfileModel->getBorrowerDetails($bor_id);
		$withArry	=	array(		"modelBorPrf"=>$this->borrowerProfileModel,
									"classname"=>"fa fa-reply fa-fw user-icon",
									"submitted"=>$submitted ,
									"InvBorPrf"=>$this->borrowerProfileModel,
									"user_type"=>"borrower"
								);	
		return view('borrower.borrower-profile')
				->with($withArry);
		
	}
	
	public function saveCommentProfileAction(){
		
		$postArray	=	Request::all();
		$bor_id		=	$postArray['borrower_id'];
		$result		=	$this->borrowerProfileModel->saveComments($postArray['comment_row'],$bor_id);
		if($result) {
			return redirect()->route('admin.borrowerprofile', array('bor_id' => base64_encode($bor_id)	))
						->with('success','Comments saved successfully');
		}else{
			return redirect()->route('admin.borrowerprofile', array('bor_id' => base64_encode($bor_id) ))
						->with('failure','Comments saved Failed');	
		}	
	}
	
	public function returnBorrowerProfileAction(){
		
		$postArray	=	Request::all();
		$bor_id		=	$postArray['borrower_id'];
		$dataArray 	= 	array(	'status' 	=>	BORROWER_STATUS_COMMENTS_ON_ADMIN );
		$this->borrowerProfileModel->saveComments($postArray['comment_row'],$bor_id);
		$result		=	$this->borrowerProfileModel->updateBorrowerStatus($dataArray,$bor_id,"return_borrower");
		if($result) {
			return redirect()->route('admin.borrowerprofile', array('bor_id' => base64_encode($bor_id)	))
						->with('success','return borrower updated successfully');
		}else{
			return redirect()->route('admin.borrowerprofile', array('bor_id' => base64_encode($bor_id) ))
						->with('failure','return borrower updated Failed');	
		}	
	}
	
	public function approveBorrowerProfileAction(){
			
		$postArray	=	Request::all();
		$bor_id		=	$postArray['borrower_id'];
		$dataArray	= 	array(	'status' 	=>	BORROWER_STATUS_VERIFIED );
		if(isset($postArray['comment_row'])){
			$this->borrowerProfileModel->saveComments($postArray['comment_row'],$bor_id);
		}
		$result		=	$this->borrowerProfileModel->updateBorrowerStatus($dataArray,$bor_id,"approve");
		if($result) {
			return redirect()->route('admin.borrowerprofile', array('bor_id' => base64_encode($bor_id)	))
						->with('success','approve borrower updated successfully');
		}else{
			return redirect()->route('admin.borrowerprofile', array('bor_id' => base64_encode($bor_id) ))
						->with('failure','approved borrower updated Failed');	
		}	
	}
	
	public function updateGradeProfileAction(){
		
		$postArray	=	Request::all();
		$bor_id		=	$postArray['borrower_id'];
		$result		=	$this->borrowerProfileModel->updateBorrowerGrade($postArray,$bor_id);
		if($result) {
			
			return redirect()->route('admin.borrowerprofile', array('bor_id' => base64_encode($bor_id)	))
						->with('success','update borrower grade updated successfully');
		}else{
			
			return redirect()->route('admin.borrowerprofile', array('bor_id' => base64_encode($bor_id) ))
						->with('failure','update borrower grade updated Failed');	
			
		}		
	}
	
	public function approveBorrowerAction($bor_id){
		
		$bor_id		=	base64_decode($bor_id);
		if(!$this->borrowerProfileModel->CheckBorrowerExists($bor_id)){
			return redirect()->to('admin/manageborrowers');
		}
		$bor_profile_status	=	$this->borrowerProfileModel->getBorrowerProfileStatus($bor_id);
		$dataArray = array(	'status' 	=>	BORROWER_STATUS_VERIFIED );
		if($bor_profile_status	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL) {
			$result		=	$this->borrowerProfileModel->updateBorrowerStatus($dataArray,$bor_id,"approve");
			if($result) {
				return redirect()->route('admin.manageborrowers')
							->with('success','approve borrower updated successfully');
			}else{
				return redirect()->route('admin.manageborrowers')
							->with('failure','approve borrower updated Failed');	
			}
		}
		return redirect()->to('admin/manageborrowers');
	}
	
	public function rejectBorrowerAction($bor_id){
		
		$bor_id		=	base64_decode($bor_id);
		if(!$this->borrowerProfileModel->CheckBorrowerExists($bor_id)){
			return redirect()->to('admin/manageborrowers');
		}
		$bor_profile_status	=	$this->borrowerProfileModel->getBorrowerProfileStatus($bor_id);
		
		$dataArray = array(	'status' 	=>	BORROWER_STATUS_REJECTED );
		if( ($bor_profile_status	==	BORROWER_STATUS_NEW_PROFILE) 
				|| ($bor_profile_status	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL)) {
			$result		=	$this->borrowerProfileModel->updateBorrowerStatus($dataArray,$bor_id,"reject");
			if($result) {
				return redirect()->route('admin.manageborrowers')
							->with('success','reject borrower updated successfully');
			}else{
				return redirect()->route('admin.manageborrowers')
							->with('failure','reject borrower updated Failed');	
			}
		}
		return redirect()->to('admin/manageborrowers');
	}
	
	public function deleteBorrowerAction($bor_id){
		
		$bor_id		=	base64_decode($bor_id);
		if(!$this->borrowerProfileModel->CheckBorrowerExists($bor_id)){
			return redirect()->to('admin/manageborrowers');
		}
		$bor_profile_status	=	$this->borrowerProfileModel->getBorrowerProfileStatus($bor_id);
		
		$dataArray = array(	'status' 	=>	BORROWER_STATUS_DELETED );
		if($this->borrowerProfileModel->getBorrowerActiveLoanStatus($bor_id)	==	0) {
			$result		=	$this->borrowerProfileModel->updateBorrowerStatus($dataArray,$bor_id,"delete");
			if($result) {
				return redirect()->route('admin.manageborrowers')
							->with('success','reject borrower updated successfully');
			}else{
				return redirect()->route('admin.manageborrowers')
							->with('failure','reject borrower updated Failed');	
			}
		}
		return redirect()->to('admin/manageborrowers');
	}
	
	public function approveBorrowerBulkAction(){
		
		$postArray	=	Request::all();
		$result		=	$this->borrowerProfileModel->updateBulkBorrowerStatus($postArray,"approve");
		if($result) {
			return redirect()->route('admin.manageborrowers')
						->with('success','approve borrower updated successfully');
		}else{
			return redirect()->route('admin.manageborrowers')
						->with('failure','approve borrower updated Failed');	
		}
	}
	
	public function rejectBorrowerBulkAction(){
		
		$postArray	=	Request::all();
		$result		=	$this->borrowerProfileModel->updateBulkBorrowerStatus($postArray,"reject");
		if($result) {
			return redirect()->route('admin.manageborrowers')
						->with('success','reject borrower updated successfully');
		}else{
			return redirect()->route('admin.manageborrowers')
						->with('failure','reject borrower updated Failed');	
		}
	}
	
	public function deleteBorrowerBulkAction(){
		
		$postArray	=	Request::all();
		$result		=	$this->borrowerProfileModel->updateBulkBorrowerStatus($postArray,"delete");
		if($result) {
			return redirect()->route('admin.manageborrowers')
						->with('success','delete borrower updated successfully');
		}else{
			return redirect()->route('admin.manageborrowers')
						->with('failure','delete borrower updated Failed');	
		}
	}
}
