<?php 
namespace App\Http\Controllers;
use	\App\models\AuditTrailModel;
use Request;
class AdminAuditTrailController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();		
	}	
	
	public function littleMoreInit() {
		$this->audittrailModel	=	new AuditTrailModel;
	}
	
	public function indexAction() {
		$fromDate		=	date('d-m-Y', strtotime(date('Y-m')." -1 month"));
		$toDate			=	date('d-m-Y', strtotime(date('Y-m')." +1 month"));	
		$action_list 	= "all";
		$module_list 	= "all";
		if (isset($_REQUEST["action_list"])) 
			$action_list 	= $_REQUEST["action_list"];
		if (isset($_REQUEST["module_list"])) 
			$module_list 	= $_REQUEST["module_list"];
		if (isset($_REQUEST["fromdate"])) 
			$fromdate 	= $_REQUEST["fromdate"];
		if (isset($_REQUEST["todate"])) 
			$todate 	= $_REQUEST["todate"];
			
		$this->audittrailModel->getModuleDropdown();
		$this->audittrailModel->getActionDropdown();	
		//~ print_r($toDate);	 die;
		
		$this->audittrailModel->getAuditHeaderInfo($action_list,$module_list,$fromDate,$toDate);
		$withArry	=	array(	"adminAuditTrailMod" => $this->audittrailModel, 
								"fromDate" => $fromDate, 
								"toDate" => $toDate,								
								"classname"=>"fa fa-key fa-fw"); 
								
		return view('admin.admin-audittrail')
				->with($withArry); 
	}
	
	//~ public function auditInfoAction(){
		
		
		
	//~ }	
	
}
