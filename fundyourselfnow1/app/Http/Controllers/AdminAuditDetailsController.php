<?php 
namespace App\Http\Controllers;
use	\App\models\AdminAuditDetailsModel;

class AdminAuditDetailsController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
		
	}	
	
	public function littleMoreInit() {
		
		$this->auditdetailsModel	=	new AdminAuditDetailsModel;
		
	}
	
	public function indexAction() {
		
		return view('admin.admin-auditdetails');
		
	}
	
	
}
