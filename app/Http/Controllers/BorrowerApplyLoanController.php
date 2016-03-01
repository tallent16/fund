<?php 
namespace App\Http\Controllers;

class BorrowerApplyLoanController extends MoneyMatchController {

	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		
	}

	public function index() {
		return view('borrower.borrower-applyloan');
	}

}
