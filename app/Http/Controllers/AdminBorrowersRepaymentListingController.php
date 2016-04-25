<?php 
namespace App\Http\Controllers;
use	\App\models\BorrowerRepayLoansModel;
class AdminBorrowersRepaymentListingController extends MoneyMatchController {
	
	public $adminBorrowerRepaymentList;
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminBorrowerRepaymentList = new BorrowerRepayLoansModel();
	}
		
	public function indexAction(){		

		$this->adminBorrowerRepaymentList->getAllBorrowerRepaymentLoans();
		$withArry	=	array(	"adminBorRepayListMod" => $this->adminBorrowerRepaymentList, 								
								"classname"=>"fa fa-cc fa-fw"); 
								
		return view('admin.admin-borrowersrepaymentlisting')
				->with($withArry); 
	
	}
}
