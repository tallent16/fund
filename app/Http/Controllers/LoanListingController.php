<?php 
namespace App\Http\Controllers;

class LoanListingController extends MoneyMatchController {
	/*------------------------------------------------------------
	 *  Loan Listing is common to both Investors' and Borrowers' modules
	 *  
	 * */

	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		
	}

	public function index() {
		
		return view('borrower.borrower-loanlisting')
			->with("classname","fa fa-list fa-fw user-icon"); 
					
	}

}
