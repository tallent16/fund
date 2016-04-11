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
		$filterIntRate 	= 'all';
		$filterLoanAmt	= 'all';
		$filterTenure 	= 'all';
		$filterGrade 	= 'all';
		
		if (isset($_REQUEST["intrate_filter"])) 
			$filterIntRate 	= $_REQUEST["intrate_filter"];
		
		if (isset($_REQUEST["loanamt_filter"])) 
		$filterLoanAmt	= $_REQUEST["loanamt_filter"];
		
		
		if (isset($_REQUEST["tenure_filter"])) 
		$filterTenure 	= $_REQUEST["tenure_filter"];

		if (isset($_REQUEST["grade_filter"])) 
		$filterGrade 	= $_REQUEST["grade_filter"];			
		
		$this->loanListing->getLoanList($filterIntRate, $filterLoanAmt, $filterTenure, $filterGrade);
		$this->loanListing->processDropDowns();

		$withArry	=	array(	"loanListing" => $this->loanListing	, "classname"=>"fa fa-list-alt fa-fw");
		return view('common.loanlisting')
			->with($withArry); 
			
					
	}

}
