<?php 
namespace App\Http\Controllers;
use	\App\models\AdminBorrowersRepaymentViewModel;
class AdminBorrowersRepaymentViewController extends MoneyMatchController {
	
	public $adminBorrowerRepaymentList;
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminBorrowerRepaymentView = new AdminBorrowersRepaymentViewModel();
	}
		
	public function indexAction(){		

		$withArry	=	array(	"adminBorRepayViewMod" => $this->adminBorrowerRepaymentView, 								
								"classname"=>"fa fa-cc fa-fw"); 
								
		return view('admin.admin-borrowersrepaymentview')
				->with($withArry); 
	
	}
}
