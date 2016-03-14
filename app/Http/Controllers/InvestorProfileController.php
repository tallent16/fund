<?php 
namespace App\Http\Controllers;
use Request;
class InvestorProfileController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}
	
	//render the borrower Dashboard page
	public function indexAction() {		
		
		return view('investor.investor-profile')					
					->with("classname","fa fa-user fa-fw user-icon"); 
	}

}
