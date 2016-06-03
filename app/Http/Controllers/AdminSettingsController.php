<?php 
namespace App\Http\Controllers;
use	\App\models\AdminSettingsModel;

class AdminSettingsController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
		
	}	
	
	public function littleMoreInit() {
		
		$this->auditSettingsModel	=	new AdminSettingsModel;
		
	}
	
	public function indexAction() {
		
		return view('admin.admin-settings');
		
	}
	
	
}
