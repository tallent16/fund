<?php 
namespace App\Http\Controllers;
use	\App\models\BorrowerRepayLoansModel;
use	Request;
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
		
		$withArry	=	array(	"adminBorRepayListMod" => $this->adminBorrowerRepaymentList, 								
								"classname"=>"fa fa-cc fa-fw"); 
								
		return view('admin.admin-borrowersrepaymentlisting')
				->with($withArry); 
	
	}
	public function ajaxRepayList(){	
				
		$row = $this->adminBorrowerRepaymentList->getAllBorrowerRepaymentLoans();		
		return json_encode(array("data"=>$row));		
	}
		
	public function approveRepaymentAction($repayment_schedule_id){		

		$this->adminBorrowerRepaymentList->approveBorrowerRepayment($repayment_schedule_id);
		return redirect()->to('admin/borrowersrepaylist');
	}
		
	public function bulkApproveRepaymentAction(){		
		
		$postArray	=	Request::all();
		$this->adminBorrowerRepaymentList->bulkApproveBorrowerRepayment($postArray);
		return redirect()->to('admin/borrowersrepaylist');
	}
}
