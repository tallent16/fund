<?php 
namespace App\Http\Controllers;
use	\App\models\LoanListingModel;
use Response;

class LoanListingController extends MoneyMatchController {
	/*------------------------------------------------------------
	 *  Loan Listing is common to both Investors' and Borrowers' modules
	 *  
	 * */

	public $loanListing;
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->loanListing = new LoanListingModel();
	}

	public function indexAction() { 
		
		$filterLoanAmt	= 'all';
		$filterCat 		= 'all';
		$filterGrade 	= 'all';
				
		if (isset($_REQUEST["loanamt_filter"])) 
		$filterLoanAmt	= $_REQUEST["loanamt_filter"];
				
		if (isset($_REQUEST["tenure_filter"])) 
		$filterCat 	= $_REQUEST["tenure_filter"];

		if (isset($_REQUEST["grade_filter"])) 
		$filterGrade 	= $_REQUEST["grade_filter"];			
		
		$this->loanListing->getLoanList($filterLoanAmt, $filterCat, $filterGrade);
		$this->loanListing->processDropDowns();
		$withArry	=	array(	"loanListing" => $this->loanListing	, "classname"=>"fa fa-list-alt fa-fw");
		return view('common.loanlisting')
			->with($withArry); 		
	}
	
	public function getActiveLoansAction() {
		$this->loanlisting->getAllActiveLoans();
	}

}
