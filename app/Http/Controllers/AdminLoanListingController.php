<?php 
namespace App\Http\Controllers;
use	\App\models\AdminLoanListingModel;
class AdminLoanListingController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}	
		
	public function indexAction(){
		
		return view('admin.admin-loanlisting');
				
		
	}
}
