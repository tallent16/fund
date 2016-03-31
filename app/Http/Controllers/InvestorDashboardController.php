<?php 
namespace App\Http\Controllers;
use	\App\models\InvestorDashboardModel;
use Request;
class InvestorDashboardController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->investorDashboardModel	=	new InvestorDashboardModel;
	}
	
	//render the investor dashboard page
	public function indexAction() {		
		
		$this->investorDashboardModel->getInvestorDashboardDetails();
		
		$withArry		=	array(	"InvDashMod"=>$this->investorDashboardModel,
									"classname"=>"fa fa-gear fa-fw user-icon"
								);
		return view('investor.investor-dashboard')					
					->with($withArry); 
	}

}
