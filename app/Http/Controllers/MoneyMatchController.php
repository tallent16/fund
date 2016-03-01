<?php 
namespace App\Http\Controllers;  

use Auth;
use Session;
use Input;
use Redirect;

class MoneyMatchController extends Controller {

   public function init() {
	   
		//~ // Setup the models object 
		
		$this->user			=	new \App\models\UserModel();
		$this->littleMoreInit();
		
	}
	
 	public function littleMoreInit() {
		// This is a stub method will be implemented in the descendent objects
		
	}
}
