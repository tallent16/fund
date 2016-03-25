<?php namespace App\Http\Controllers;
use	\App\models\BorrowerRepayLoansModel;
use Response;
class BorrowerRepayLoansController extends Controller {

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
		$this->repayloan = new BorrowerRepayLoansModel();
	}

	/**
	 * Show the application repay loans to the user.
	 *
	 * @return Response
	 */
	public function indexAction()
	{
		return view('borrower.borrower-repayloans')
			->with("classname","fa fa-university fa-fw user-icon"); 
	}

}
