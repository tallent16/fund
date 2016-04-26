<?php 
namespace App\Http\Controllers;
use	\App\models\AdminInvestorsDepositViewModel;
class AdminInvestorsDepositViewController extends MoneyMatchController {
	
	public $adminInvestorDepositView;
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminInvestorDepositView = new AdminInvestorsDepositViewModel();
	}
		
	public function indexAction(){		
		
		$this->adminInvestorDepositView->processInvestorDropDowns();
		
		$withArry	=	array(	"adminInvDepViewMod" => $this->adminInvestorDepositView, 								
								"classname"=>"fa fa-cc fa-fw"); 
								
		return view('admin.admin-investorsdepositview')
				->with($withArry); 
	
	}
	
}

