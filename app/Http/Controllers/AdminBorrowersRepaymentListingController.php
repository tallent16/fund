<?php 
namespace App\Http\Controllers;
use	\App\models\AdminBorrowersRepaymentListingModel;
class AdminBorrowersRepaymentListingController extends MoneyMatchController {
	
	public $adminBorrowerRepaymentList;
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminBorrowerRepaymentList = new AdminBorrowersRepaymentListingModel();
	}
		
	public function indexAction(){		

		$withArry	=	array(	"adminBorRepayListMod" => $this->adminBorrowerRepaymentList, 								
								"classname"=>"fa fa-cc fa-fw"); 
								
		return view('admin.admin-borrowersrepaymentlisting')
				->with($withArry); 
	
	}
}
