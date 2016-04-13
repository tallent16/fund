<?php 
namespace App\Http\Controllers;
use	\App\models\Model;
class AdminDisburseLoanController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}	
		
	public function indexAction(){
		
		return view('admin.admin-disburseloan');
				
		
	}
}
