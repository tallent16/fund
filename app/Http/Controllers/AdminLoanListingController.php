<?php 
namespace App\Http\Controllers;
use	\App\models\AdminLoanListingModel;
class AdminLoanListingController extends MoneyMatchController {
	
	public $adminLoanListing;
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminLoanListing = new AdminLoanListingModel();
	}
		
	public function indexAction(){
		
		$all_Trans 	=	'All';
		$fromDate	=	date("d-m-Y", strtotime("-12 Months"));
		$toDate		=	date("d-m-Y", strtotime("now"));
		
		if (isset($_REQUEST["fromdate"])) {
			$fromDate	=	$_REQUEST["fromdate"];
		}
		
		if (isset($_REQUEST["todate"])) {
			$toDate 	=	$_REQUEST["todate"];
		}
		
		if (isset($_REQUEST["filter_transcations"])) {
			$all_Trans = $_REQUEST["filter_transcations"];
		}
		
		$this->adminLoanListing->processDropDowns();
		
		$this->adminLoanListing->viewTransList($fromDate, $toDate, $all_Trans);	

		$withArry	=	array(	"adminLoanListing" => $this->adminLoanListing, 
								"fromDate" => $fromDate, 
								"toDate" => $toDate,
								"all_Trans" => $all_Trans,
								"classname"=>"fa fa-list-alt fa-fw");
		return view('admin.admin-loanlisting')
				->with($withArry); 
	
	}
}
