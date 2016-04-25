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
		
		$withArry	=	array(	"adminInvWithListMod" => $this->adminInvestorWithdrawalList, 														
								"classname"=>"fa fa-cc fa-fw"); 
								
		return view('admin.admin-investorswithdrawalslisting')
				->with($withArry); 
	
	}
}
