<?php 
namespace App\Http\Controllers;
use	\App\models\BorrowerRepayLoansModel;
class AdminBorrowersRepaymentViewController extends MoneyMatchController {
	
	public $adminBorrowerRepaymentList;
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminBorrowerRepaymentView = new BorrowerRepayLoansModel();
	}
		
	public function indexAction($installment_id,$loan_id){		

		$installmentId 	= 	base64_decode($installment_id);	
		$loanid			= 	base64_decode($loan_id);
					
		$this->adminBorrowerRepaymentView->newRepayment($installmentId,$loanid);
		$withArry	=	array(	"adminBorRepayViewMod" => $this->adminBorrowerRepaymentView, 								
								"classname"=>"fa fa-cc fa-fw"); 
								
		return view('admin.admin-borrowersrepaymentview')
				->with($withArry); 
	
	}
}
