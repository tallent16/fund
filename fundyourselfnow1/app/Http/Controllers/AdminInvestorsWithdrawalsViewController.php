<?php 
namespace App\Http\Controllers;
use	\App\models\AdminInvestorsWithdrawalsViewModel;
class AdminInvestorsWithdrawalsViewController extends MoneyMatchController {
	
	public $adminInvestorWithdrawalView;
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminInvestorWithdrawalView = new AdminInvestorsWithdrawalsViewModel();
	}
		
	public function indexAction(){			
		
		$withArry	=	array(	"adminInvWithViewMod" => $this->adminInvestorWithdrawalView, 														
								"classname"=>"fa fa-cc fa-fw"); 
								
		return view('admin.admin-investorswithdrawalsview')
				->with($withArry); 
	
	}
}
