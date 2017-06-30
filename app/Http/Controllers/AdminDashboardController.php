<?php 
namespace App\Http\Controllers;
use Request;
use	\App\models\AdminDashboardModel;

class AdminDashboardController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminDashboardModel = new AdminDashboardModel();
	}
	
	public function indexAction(){
		
		$this->adminDashboardModel->getDashboardDetails();
		$periodic_snapshot	=	array("panel_group_id"=>"acc_periodic_snapshot");
		
		$periodic_snapshot["panels"][]	=	array(
													"panel_id"=>"not_fully_subscribed",
													"panel_title"=>"PROJECT NOT FULLY SUBSCRIBED",
													"panel_body_widget"=>
																"widgets.admin.accordion.loans_not_fullysubscribed",
													"panel_body_content"=>
																$this->adminDashboardModel->loanNotFullySubscribed,
													"panel_collapse_class"=>"in"
													);
		$periodic_snapshot["panels"][]	=	array(
		
													"panel_id"=>"defaulting_loans",
													"panel_title"=>"DEFAULTING PROJECT",
													"panel_body_widget"=>
																"widgets.admin.accordion.defaulting_loans",
													"panel_body_content"=>
																		$this->adminDashboardModel->defaultingLoans,
													"panel_collapse_class"=>""
													
													);
		$periodic_snapshot["panels"][]	=	array(
													"panel_id"=>"commissions_earned",
													"panel_title"=>"COMMISSIONS EARNED",
													"panel_body_widget"=>
																"widgets.admin.accordion.commissions_earned",
													"panel_body_content"=>
																	$this->adminDashboardModel->commissionsEarned,
													"panel_collapse_class"=>""
													
													);
		$periodic_snapshot["panels"][]	=	array(
													"panel_id"=>"penalties_levies",
													"panel_title"=>"PENALTIES LEVIES",
													"panel_body_widget"=>
																"widgets.admin.accordion.penalties_levies",
													"panel_body_content"=>
																	$this->adminDashboardModel->penaltiesLevies,
													"panel_collapse_class"=>""
													
													);
		$withArry	=	array(	
									"classname"=>"fa fa-reply fa-fw user-icon",
									"periodic_snapshot"=>$periodic_snapshot,
									"dashMod"=>$this->adminDashboardModel
								);	
		return view('admin.admin-dashboard')
				->with($withArry);
		
	}
	
	
}
