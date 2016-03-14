<?php 
namespace App\Http\Controllers;
use Request;
use	\App\models\BorrowerDashboardModel;
class BorrowerDashboardController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}
	
	//Additional initiate model
	public function littleMoreInit() {
		$this->borrowerDashboardModel	=	new BorrowerDashboardModel;
	}
	
	//render the borrower Dashboard page
	public function indexAction() {
		
		$this->borrowerDashboardModel->getBorrowerDashboardDetails();
		return view('borrower.borrower-dashboard')
					->with("BorDashMod",$this->borrowerDashboardModel)
					->with("classname","fa fa-gear fa-fw user-icon"); 
	}

}
