<?php 
namespace App\Http\Controllers;  

class ManagePasswordController extends MoneyMatchController {
	
	public function __construct() {	
		
	}
	
	public function resetPasswordAction() { 
	
		return view('resetpassword'); 
	}  
	public function forgotPasswordAction() { 
	
		return view('forgotpassword'); 
	}
	 public function NewPasswordAction() { 
	
		return view('newpassword'); 
	} 
	
}
