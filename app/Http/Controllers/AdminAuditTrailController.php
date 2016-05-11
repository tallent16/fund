<?php 
namespace App\Http\Controllers;
use	\App\models\AdminAuditTrailModel;

class AdminAuditTrailController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
		
	}	
	
	public function littleMoreInit() {
		$this->audittrailModel	=	new AdminAuditTrailModel;

	}
	
	public function indexAction() {
		
		return view('admin.admin-audittrail');
		
	}
	
	
}
