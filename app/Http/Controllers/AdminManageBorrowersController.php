<?php 
namespace App\Http\Controllers;
include( app_path()."/libraries/php/DataTables.php" );
use
	DataTables\Editor,
	DataTables\Editor\Field,
	DataTables\Editor\Format,
	DataTables\Editor\Join,
	DataTables\Editor\Validate;
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
			
		//$this->adminborModel->getManageBorrowerDetails($filterBorrowerStatus_filter);	
		$this->adminborModel->processDropDowns();
			
		$withArry	=	array(		"adminbormodel"=>$this->adminborModel,
									"classname"=>"fa fa-reply fa-fw user-icon"
							);	
		
		return view('admin.admin-manageborrowers')
				->with($withArry);
			
	}
	
	public function ajaxBorrowerList(){		
		$filterBorrowerStatus_filter 	= 'all';
		if (isset($postArray["borrowerstatus_filter"])) 
			$filterBorrowerStatus_filter 	= $postArray["borrowerstatus_filter"];			
		$row = $this->adminborModel->getBorrowerListInfo($filterBorrowerStatus_filter);		
		return json_encode(array("data"=>$row));		
	}
	
	public function viewProfileAction($bor_id){
		
		$submitted	=	false;
		$activeTab	=	"#company_info";
		$bor_id		=	base64_decode($bor_id);
		
		if(!$this->borrowerProfileModel->CheckBorrowerExists($bor_id)){
			return redirect()->to('admin/manageborrowers');
		}
		$this->borrowerProfileModel->getBorrowerDetails($bor_id);
		$withArry	=	array(		"modelBorPrf"=>$this->borrowerProfileModel,
									"classname"=>"fa fa-reply fa-fw user-icon",
									"submitted"=>$submitted ,
									"InvBorPrf"=>$this->borrowerProfileModel,
									"user_type"=>"borrower",
									"activeTab"=>$activeTab
								);	
		
		return view('borrower.borrower-profile')
				->with($withArry);
		
	}
	
	public function saveCommentProfileAction(){
		
		$postArray	=	Request::all();
		$bor_id		=	$postArray['borrower_id'];
		$result		=	$this->borrowerProfileModel->saveComments($postArray['comment_row'],$bor_id);
		if($result) {
			$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("borrower_profile_comments_saved");
			return redirect()->route('admin.borrowerprofile', array('bor_id' => base64_encode($bor_id)	))
						->with('success',$successMsg);
		}else{
			return redirect()->route('admin.borrowerprofile', array('bor_id' => base64_encode($bor_id) ))
						->with('failure','Borrower Profile comments saved Failed');	
		}	
	}
	
	public function returnBorrowerProfileAction(){
		
		$postArray	=	Request::all();
		$bor_id		=	$postArray['borrower_id'];
		$dataArray 	= 	array(	'status' 	=>	BORROWER_STATUS_COMMENTS_ON_ADMIN );
		$this->borrowerProfileModel->saveComments($postArray['comment_row'],$bor_id);
		$result		=	$this->borrowerProfileModel->updateBorrowerStatus($dataArray,$bor_id,"return_borrower");
		if($result) {
			$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("borrower_profile_return_to_borrower");
			return redirect()->route('admin.borrowerprofile', array('bor_id' => base64_encode($bor_id)	))
						->with('success',$successMsg);
		}else{
			return redirect()->route('admin.borrowerprofile', array('bor_id' => base64_encode($bor_id) ))
						->with('failure','Profile returned to Borrower Failed');	
		}	
	}
	
	public function approveBorrowerProfileAction(){
			
		$postArray	=	Request::all();
		$bor_id		=	$postArray['borrower_id'];
		$dataArray	= 	array(	'status' 	=>	BORROWER_STATUS_VERIFIED );
		$this->borrowerProfileModel->processProfile($postArray,$bor_id);
		$result		=	$this->borrowerProfileModel->updateBorrowerStatus($dataArray,$bor_id,"approve");
		if($result) {
			$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("borrower_profile_approved");
			return redirect()->route('admin.borrowerprofile', array('bor_id' => base64_encode($bor_id)	))
						->with('success',$successMsg);
		}else{
			return redirect()->route('admin.borrowerprofile', array('bor_id' => base64_encode($bor_id) ))
						->with('failure','Borrower Profile information Failed approved');	
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
				$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("borrower_profile_approved");
				return redirect()->route('admin.manageborrowers')
							->with('success',$successMsg);
			}else{
				return redirect()->route('admin.manageborrowers')
							->with('failure','Borrower Profile information Failed approved');	
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
				$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("borrower_profile_reject");
				return redirect()->route('admin.manageborrowers')
							->with('success',$successMsg);
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
				$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("borrower_profile_inactive");
				return redirect()->route('admin.manageborrowers')
							->with('success',$successMsg);
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
			$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("borrower_profile_approved");
			return redirect()->route('admin.manageborrowers')
						->with('success',$successMsg);
		}else{
			return redirect()->route('admin.manageborrowers')
						->with('failure','Borrower Profile information Failed approved');	
		}
	}
	
	public function rejectBorrowerBulkAction(){
		
		$postArray	=	Request::all();
		$result		=	$this->borrowerProfileModel->updateBulkBorrowerStatus($postArray,"reject");
		if($result) {
			$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("borrower_profile_reject");
			return redirect()->route('admin.manageborrowers')
						->with('success',$successMsg);
		}else{
			return redirect()->route('admin.manageborrowers')
						->with('failure','reject borrower updated Failed');	
		}
	}
	
	public function deleteBorrowerBulkAction(){
		
		$postArray	=	Request::all();
		$result		=	$this->borrowerProfileModel->updateBulkBorrowerStatus($postArray,"delete");
		if($result) {
			$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("borrower_profile_inactive");
			return redirect()->route('admin.manageborrowers')
						->with('success',$successMsg);
		}else{
			return redirect()->route('admin.manageborrowers')
						->with('failure','delete borrower updated Failed');	
		}
	}

	public function saveBorrowerProfileAction(){
		
		$postArray	=	Request::all();
		$bor_id		=	$postArray['borrower_id'];
		$result		=	$this->borrowerProfileModel->processProfile($postArray,$bor_id);
		if($result) {
			$successMsg	=	$this->borrowerProfileModel->getSystemMessageBySlug("borrower_profile_update_by_borrwer");
			return redirect()->route('admin.borrowerprofile', array('bor_id' => base64_encode($bor_id)	))
						->with('success',$successMsg)
						->with('activeTab',$postArray['active_tab']);
		}else{
			
			return redirect()->route('admin.borrowerprofile', array('bor_id' => base64_encode($bor_id) ))
						->with('failure','borrower profile updated Failed')
						->with('activeTab',$postArray['active_tab']);
		}	
	}
}
