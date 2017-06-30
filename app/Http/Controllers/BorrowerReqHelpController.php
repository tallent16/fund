<?php namespace App\Http\Controllers;
use Request;
class BorrowerReqHelpController extends MoneyMatchController {

	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		//~ $this->borrowerMyLoanInfoModel	=	new BorrowerMyLoanInfoModel;
	}
	
	public function indexAction() {
		
			
		$withArry	=	array(	"classname"=>"fa fa-file-text fa-fw",
								"pageheading"=>"Request Help"
							);	
		
		return view('common.coming-soon')
			->with($withArry);
	}
	
	
}
