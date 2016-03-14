<?php 
namespace App\Http\Controllers;
use Request;
class InvestorBankDetailsController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}
	
	//render the investor Bank Details page
	public function indexAction() {		
		
		return view('investor.investor-bankdetails')					
					->with("classname","fa fa-university fa-fw user-icon"); 
	}

}
