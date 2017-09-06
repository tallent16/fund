<?php namespace App\Http\Controllers;
use Request;
class CreatorWalletController extends MoneyMatchController {

	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		//~ $this->borrowerMyLoanInfoModel	=	new BorrowerMyLoanInfoModel;
	}
	
	public function indexAction() {
		
			
		$withArry	=	array(	"classname"=>"fa fa-file-text fa-fw"
							);	
		
		return view('borrower.borrower-wallet')
			->with($withArry);
	}
	
	
}
