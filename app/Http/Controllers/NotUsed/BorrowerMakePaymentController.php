<?php namespace App\Http\Controllers;

class BorrowerMakePaymentController extends Controller {

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

	/**
	 * Show the application make payment to the user.
	 *
	 * @return Response
	 */
	public function indexAction()
	{
		return view('borrower.borrower-makepayment')
			->with("classname","fa fa-university fa-fw user-icon"); 
	}

}
