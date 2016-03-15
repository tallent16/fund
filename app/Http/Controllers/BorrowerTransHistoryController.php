<?php 
namespace App\Http\Controllers;
use	\App\models\BorrowerTransactionModel;
use Response;
use Request;

class BorrowerTransHistoryController extends Controller {

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
	public function __construct()
	{	
		$this->middleware('auth');
	}
	
	public function littleMoreInit() {
		$this->transactionModel = new BorrowerTransactionModel();
	}	

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function indexAction()
	{
		$transType 	=	'All';
		$fromDate	=	strtotime("-12 Months");
		$toDate		=	strtotime("now");
		

		echo date('d-m-Y', $fromDate);
		die;
		
		if (isset($_REQUEST["fromdate"])) {
			echo $_REQUEST["fromdate"];
		}
		
		return view('borrower.borrower-transcationhistory')
				->with("classname","fa fa-credit-card fa-fw user-icon"); 
	}

}
