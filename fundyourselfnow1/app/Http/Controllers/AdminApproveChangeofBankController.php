<?php 
namespace App\Http\Controllers;
use	\App\models\AdminApproveChangeofBankModel;
use Request;
class AdminApproveChangeofBankController extends MoneyMatchController {	
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminApproveChangeBankModel = new AdminApproveChangeofBankModel();
	}
		
	public function indexAction(){
		
		return view('admin.admin-approvechangeofbank');
				
	}


}
