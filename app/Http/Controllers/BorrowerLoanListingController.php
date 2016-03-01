<?php 
namespace App\Http\Controllers;

class BorrowerLoanListingController extends MoneyMatchController {

	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		
	}

	public function index() {
		return view('borrower.borrower-loanlisting');
	}

}
