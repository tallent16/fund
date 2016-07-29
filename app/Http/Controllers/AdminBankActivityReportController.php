<?php 
namespace App\Http\Controllers;
use	\App\models\AdminBankActivityReportModel;
use Response;

class AdminBankActivityReportController extends MoneyMatchController {

	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminBankActRepMod = new AdminBankActivityReportModel();
	}

	public function indexAction() { 
		
		$withArry	=	array(	"adminBankActRepMod" => $this->adminBankActRepMod	,
								"classname"=>"fa fa-list-alt fa-fw"
							);
		return view('admin.admin-bankactivity')
			->with($withArry); 
			
					
	}
	
	public function indexPostAction() { 
		
		$filterFromDate		=	"";
		$filterToDate		=	"";
		
		if (isset($_REQUEST["fromDate_filter"])) 
			$filterFromDate	= 	$_REQUEST["fromDate_filter"];

		if (isset($_REQUEST["toDate_filter"])) 
			$filterToDate 	= 	$_REQUEST["toDate_filter"];
		
		if(	$filterFromDate!=""	&&	$filterToDate!="" ) {
			
			$this->adminBankActRepMod->getBankActivityReportInfo( $filterFromDate, $filterToDate);
		}
	
		$withArry	=	array(	"adminBankActRepMod" => $this->adminBankActRepMod	,
								"classname"=>"fa fa-list-alt fa-fw"
							);
		return view('admin.admin-bankactivity')
			->with($withArry); 
			
					
	}
	
}
