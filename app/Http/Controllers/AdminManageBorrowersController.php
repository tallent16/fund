<?php 
namespace App\Http\Controllers;
use	\App\models\AdminManageBorrowersModel;
use	\App\models\BorrowerProfileModel;
class AdminManageBorrowersController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminborModel	=	new AdminManageBorrowersModel;
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
		$this->borrowerProfileModel->getBorrowerDetails($bor_id);
		$withArry	=	array(		"modelBorPrf"=>$this->borrowerProfileModel,
									"classname"=>"fa fa-reply fa-fw user-icon",
									"submitted"=>$submitted
								);	
		return view('borrower.borrower-profile')
				->with($withArry);
		
	}
}
