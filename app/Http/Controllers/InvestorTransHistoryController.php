<?php 
namespace App\Http\Controllers;
use Request;
class InvestorTransHistoryController extends MoneyMatchController {

	public function __construct() {	
		$this->middleware('auth');
		$this->init();
	}
	
	//render the Investor Transcation History
	public function index() {		
		
		return view('investor.investor-transcationhistory')					
					->with("classname","fa fa-credit-card fa-fw user-icon"); 
	}
	
}
