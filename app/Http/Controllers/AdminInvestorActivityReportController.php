<?php 
namespace App\Http\Controllers;
use	\App\models\AdminInvestorActivityReportModel;
use Response;

class AdminInvestorActivityReportController extends MoneyMatchController {

	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminInvActRepMod = new AdminInvestorActivityReportModel();
	}

	public function indexAction() { 
		
		$filterInv 		= '';
		$filterFromDate	= '';
		$filterToDate 	= '';
		
		if (isset($_REQUEST["investor_filter"])) 
			$filterInv 		= 	$_REQUEST["investor_filter"];
		
		if (isset($_REQUEST["fromDate_filter"])) 
			$filterFromDate	= 	$_REQUEST["fromDate_filter"];

		if (isset($_REQUEST["toDate_filter"])) 
			$filterToDate 	= 	$_REQUEST["toDate_filter"];

		//~ $this->adminInvActRepMod->getLoanList($filterInv, $filterFromDate, $filterToDate);
		
		$withArry	=	array(	"loanListing" => $this->adminInvActRepMod	,
								"classname"=>"fa fa-list-alt fa-fw"
							);
		return view('admin.admin-investoractivity')
			->with($withArry); 
			
					
	}
	
}
