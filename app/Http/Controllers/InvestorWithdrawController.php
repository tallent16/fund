<?php 
namespace App\Http\Controllers;
use Request;
class InvestorWithdrawController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}
	
	//render the investor withdraw page
	public function index() {		
		
		return view('investor.investor-withdraw')					
					->with("classname","fa fa-university fa-fw user-icon"); 
	}

}
