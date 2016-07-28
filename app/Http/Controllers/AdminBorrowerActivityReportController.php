<?php 
namespace App\Http\Controllers;
use	\App\models\AdminBorrowerActivityReportModel;
use Response;

class AdminBorrowerActivityReportController extends MoneyMatchController {

	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminBorActRepMod = new AdminBorrowerActivityReportModel();
	}

	public function indexAction() { 
		

		$this->adminBorActRepMod->processBorrowerDropDowns();
		$withArry	=	array(	"adminBorActRepMod" => $this->adminBorActRepMod	,
								"classname"=>"fa fa-list-alt fa-fw"
							);
		return view('admin.admin-borroweractivity')
			->with($withArry); 
			
					
	}
	
	public function indexPostAction() { 
		
		$filterBor			=	"";
		$filterFromDate		=	"";
		$filterToDate		=	"";
		
		if (isset($_REQUEST["borrower_filter"])) 
			$filterBor 		= 	$_REQUEST["borrower_filter"];
		
		if (isset($_REQUEST["fromDate_filter"])) 
			$filterFromDate	= 	$_REQUEST["fromDate_filter"];

		if (isset($_REQUEST["toDate_filter"])) 
			$filterToDate 	= 	$_REQUEST["toDate_filter"];
		
		if(	$filterBor!=""	&&	$filterFromDate!=""	&&	$filterToDate!="" ) {
			
			$this->adminBorActRepMod->getBorrowerActivityReportInfo($filterBor, $filterFromDate, $filterToDate);
		}
		
		$this->adminBorActRepMod->processBorrowerDropDowns();
		$withArry	=	array(	"adminBorActRepMod" => $this->adminBorActRepMod	,
								"classname"=>"fa fa-list-alt fa-fw"
							);
		return view('admin.admin-borroweractivity')
			->with($withArry); 
			
					
	}
	
}
