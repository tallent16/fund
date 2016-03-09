<?php 
namespace App\Http\Controllers;
use Request;
class InvestorLoanListingController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}
	
	//render the borrower Dashboard page
	public function index() {		
		
		return view('investor.investor-loanlisting')					
					->with("classname","fa fa-list fa-fw user-icon"); 
	}

}
