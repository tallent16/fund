<?php 
namespace App\Http\Controllers;
use	\App\models\AdminManageBidsModel;
class AdminManageBidsController extends MoneyMatchController {
	
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}	

	public function littleMoreInit() {
		$this->bidsModel	=	new AdminManageBidsModel;
	}

		
	public function indexAction($loan_id){
		$this->bidsModel->getLoanBids($loan_id);
		
		return view('admin.admin-managebids')->with(["bidsModel" => $this->bidsModel]);
	}
	
	
}
