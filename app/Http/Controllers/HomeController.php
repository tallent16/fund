<?php namespace App\Http\Controllers;
use Auth;
class HomeController extends Controller {

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
		//~ $this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('borrower.home');
	}

	public function checkUserType()
	{
		
		if (Auth::check()) {

			switch(Auth::user()->user_type){
				case 1:
					return redirect('admin');
					break;
				case 2:
					return redirect('borrower');
					break;
				case 3:
					return redirect('investor');
					break;
						
			}	
		
		}

	}
	public function customRedirectPath()
	{
		
		if (Auth::check()) {

			switch(Auth::user()->user_type){
				case 1:
					return redirect('admin');
					break;
				case 2:
					return redirect('borrower');
					break;
				case 3:
					return redirect('investor');
					break;
						
			}	
		
		}else{
			return redirect('/');
		}

	}

}
