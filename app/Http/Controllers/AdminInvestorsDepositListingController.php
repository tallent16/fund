<?php 
namespace App\Http\Controllers;
use	\App\models\AdminInvestorsDepositListingModel;
class AdminInvestorsDepositListingController extends MoneyMatchController {
	
	public $adminInvestorDepositList;
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminInvestorsDepositList = new AdminInvestorsDepositListingModel();
	}
		
	public function indexAction(){		

		$withArry	=	array(	"adminInvDepListMod" => $this->adminInvestorsDepositList, 								
								"classname"=>"fa fa-cc fa-fw"); 
								
		return view('admin.admin-investorsdepositlisting')
				->with($withArry); 
	
	}
}
