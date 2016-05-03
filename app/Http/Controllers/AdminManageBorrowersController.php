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
		//~ echo $bor_id;
		//~ die;
		 if(!$this->borrowerProfileModel->CheckBorrowerExists($bor_id)){
			return redirect()->to('admin/manageborrowers');
		}
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			//~ print_r($postArray);
			//~ die;
			switch($postArray['admin_process']){
				case	"save_comments":
						$result		=	$this->borrowerProfileModel->saveComments($postArray['comment_row'],$bor_id);
						break;
				case	"return_borrower":
						$dataArray = array(	'status' 	=>	BORROWER_STATUS_COMMENTS_ON_ADMIN );
						$result		=	$this->borrowerProfileModel->updateBorrowerStatus($dataArray,$bor_id,"return_borrower");
						break;
				case	"approve":
						$dataArray = array(	'status' 	=>	BORROWER_STATUS_VERIFIED );
						$result		=	$this->borrowerProfileModel->updateBorrowerStatus($dataArray,$bor_id,"approve");
						break;
				case	"update_grade":
						$result		=	$this->borrowerProfileModel->updateBorrowerGrade($postArray,$bor_id);
						break;
			}
			
			$submitted	=	true;
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
	
	public function updateProfileStatusAction($status,$bor_id){
		
		$bor_id		=	base64_decode($bor_id);
		 if(!$this->borrowerProfileModel->CheckBorrowerExists($bor_id)){
			return redirect()->to('admin/manageborrowers');
		}
		$bor_profile_status	=	$this->borrowerProfileModel->getBorrowerProfileStatus($bor_id);
		
		switch($status){
			case	"approve":
					$dataArray = array(	'status' 	=>	BORROWER_STATUS_VERIFIED );
					if($bor_profile_status	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL) {
						$result		=	$this->borrowerProfileModel->updateBorrowerStatus($dataArray,$bor_id,"approve");
					}
					break;
			case	"delete":
					$dataArray = array(	'status' 	=>	BORROWER_STATUS_DELETED );
					if($this->borrowerProfileModel->getBorrowerActiveLoanStatus($bor_id)	==	0) {
						$result		=	$this->borrowerProfileModel->updateBorrowerStatus($dataArray,$bor_id);
					}
					break;
			case	"reject":
					$dataArray = array(	'status' 	=>	BORROWER_STATUS_REJECTED );
					if( ($bor_profile_status	==	BORROWER_STATUS_NEW_PROFILE) 
							|| ($bor_profile_status	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL)) {
						$result		=	$this->borrowerProfileModel->updateBorrowerStatus($dataArray,$bor_id);
					}
					break;
		}
		return redirect()->to('admin/manageborrowers');
	}
	
	public function updateBulkProfileStatusAction(){
		
		$postArray	=	Request::all();
		//~ print_r($postArray);
			//~ die;
		$result		=	$this->borrowerProfileModel->updateBulkBorrowerStatus($postArray,$postArray['processType']);
		return redirect()->to('admin/manageborrowers');
	}
}
