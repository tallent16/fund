<?php namespace App\Http\Controllers;
use Auth;
class HomeController extends MoneyMatchController {

	
	public function __construct() {	
		//~ $this->middleware('auth');
	}
	
	//based on user type redirect to related dashboard
	public function checkUserType() {
		
		if (Auth::check()) {

			switch(Auth::user()->usertype) {
				case 1:
					return redirect('borrower/dashboard');
					break;
				case 2:
					return redirect('investor/dashboard');
					break;
				case 3:
					return redirect('admin/manageborrowers');
					break;
			}	
		}
	}
	
	//checks the user login redirect to related dashboard else to home page
	public function customRedirectPath() {
		
		if (Auth::check()) {

			switch(Auth::user()->usertype) {
				case 1:
					return redirect('borrower/dashboard');
					break;
				case 2:
					return redirect('investor/dashboard');
					break;
				case 3:
					return redirect('admin/manageborrowers');
					break;
			}	
			
		}else{
			return redirect('/');
		}
	}
	
	public function indexAction() {
		
		return view('homepage');  
	}
}
