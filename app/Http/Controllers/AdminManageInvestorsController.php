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
		//~ echo $inv_id;
		//~ die;
		 if(!$this->investorProfileModel->CheckInvestorExists($inv_id)){
			return redirect()->to('admin/manageinvestors');
		}
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			//~ print_r($postArray);
			//~ die;
			switch($postArray['admin_process']){
				case	"save_comments":
						$result		=	$this->investorProfileModel->saveComments($postArray['comment_row'],$inv_id);
						break;
				case	"return_investor":
						$dataArray = array(	'status' 	=>	INVESTOR_STATUS_COMMENTS_ON_ADMIN );
						$result		=	$this->investorProfileModel->updateInvestorStatus($dataArray,$inv_id,"return_investor");
						break;
				case	"approve":
						$dataArray = array(	'status' 	=>	INVESTOR_STATUS_VERIFIED );
						$result		=	$this->investorProfileModel->updateInvestorStatus($dataArray,$inv_id,"approve");
						break;
			}
			
			$submitted	=	true;
		}
		$this->investorProfileModel->getInvestorDetails($inv_id);
		$withArry	=	array(		"InvPrfMod"=>$this->investorProfileModel,
									"classname"=>"fa fa-reply fa-fw user-icon",
									"submitted"=>$submitted
								);	
		return view('investor.investor-profile')
				->with($withArry);
		
	}
	
	public function updateProfileStatusAction($status,$inv_id){
		
		$inv_id		=	base64_decode($inv_id);
		 if(!$this->investorProfileModel->CheckInvestorExists($inv_id)){
			return redirect()->to('admin/manageinvestors');
		}
		$inv_profile_status	=	$this->investorProfileModel->getInvestorProfileStatus($inv_id);
		
		switch($status){
			case	"approve":
					$dataArray = array(	'status' 	=>	INVESTOR_STATUS_VERIFIED );
					if($bor_profile_status	==	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL) {
						$result		=	$this->investorProfileModel->updateInvestorStatus($dataArray,$inv_id,"approve");
					}
					break;
			case	"delete":
					$dataArray = array(	'status' 	=>	INVESTOR_STATUS_DELETED );
					if($this->investorProfileModel->getInvestorActiveLoanStatus($inv_id)	==	0) {
						$result		=	$this->investorProfileModel->updateInvestorStatus($dataArray,$inv_id);
					}
					break;
			case	"reject":
					$dataArray = array(	'status' 	=>	INVESTOR_STATUS_REJECTED );
					if( ($inv_profile_status	==	INVESTOR_STATUS_NEW_PROFILE) 
							|| ($inv_profile_status	==	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL)) {
						$result		=	$this->investorProfileModel->updateInvestorStatus($dataArray,$inv_id);
					}
					break;
		}
		return redirect()->to('admin/manageinvestors');
	}
	
	public function updateBulkProfileStatusAction(){
		
		$postArray	=	Request::all();
		//~ print_r($postArray);
			//~ die;
		$result		=	$this->investorProfileModel->updateBulkInvestorStatus($postArray,$postArray['processType']);
		return redirect()->to('admin/manageinvestors');
	}
}
