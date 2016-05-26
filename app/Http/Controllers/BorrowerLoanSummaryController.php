<?php 
namespace App\Http\Controllers;
use	\App\models\BorrowerLoanSummaryModel;
use Response;
use Request;

class BorrowerLoanSummaryController extends MoneyMatchController {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	 
	public $tranModel;
	
	public function __construct()
	{	
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->tranModel = new BorrowerLoanSummaryModel();
	}	

	/**
	 * Show the application transcation history to the user.
	 *
	 * @return Response
	 */
	public function indexAction()
	{
		$transType 	=	'All';
		$fromDate	=	date("d-m-Y", strtotime("-12 Months"));
		$toDate		=	date("d-m-Y", strtotime("now"));

		
		if (isset($_REQUEST["fromdate"])) {
			$fromDate	=	$_REQUEST["fromdate"];
		}
		
		if (isset($_REQUEST["todate"])) {
			$toDate 	=	$_REQUEST["todate"];
		}
		
		if (isset($_REQUEST["transtype"])) {
			$transType = $_REQUEST["transtype"];
		}

		
		$this->tranModel->viewTransList($fromDate, $toDate, $transType);
		
		$withArry	=	array(	"tranModel" => $this->tranModel	, 
								"fromDate" => $fromDate, 
								"toDate" => $toDate,
								"tranType" => $transType,
								"classname"=>"fa fa fa-list fa-fw");
		
		return view('borrower.borrower-loansummary')
				->with($withArry); 
	}

}
