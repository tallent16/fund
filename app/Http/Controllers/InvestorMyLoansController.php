<?php 
namespace App\Http\Controllers;
use Request;
class InvestorMyloansController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}
	
	//render the borrower Dashboard page
	public function indexAction() {		
		
		return view('investor.investor-myloans')					
					->with("classname","fa fa-gear fa-fw user-icon"); 
	}

}
