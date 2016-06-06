<?php 
namespace App\Http\Controllers;
use	\App\models\LoanListingModel;
use Response;

class LoanListingAllController extends MoneyMatchController {
	/*------------------------------------------------------------
	 *  Loan Listing is common to both Investors' and Borrowers' modules
	 *  
	 * */

	public $loanListing;
	
	public function __construct() {	
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->loanListing = new LoanListingModel();
	}
	
	public function getActiveLoansAction() {
		$this->loanListing->getAllActiveLoans();
	}

}
