<?php 
namespace App\Http\Controllers;
use	\App\models\BorrowerRepayLoansModel;
use Request;
class AdminBorrowersRepaymentViewController extends MoneyMatchController {
	
	public $adminBorrowerRepaymentList;
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminBorrowerRepaymentView = new BorrowerRepayLoansModel();
	}
		
	public function indexAction($type,$installment_id,$loan_id){		

		$installmentId 	= 	base64_decode($installment_id);	
		$loanid			= 	base64_decode($loan_id);
		
		$submitted		=	false;
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			if($postArray['submitType']	==	"approve" || $postArray['submitType']	==	"save"){
				$this->adminBorrowerRepaymentView->saveRepayment($postArray);
			}else{
				$loanId		=	$postArray['loan_id'];
				$instNum	=	$postArray['installment_number'];
				$this->adminBorrowerRepaymentView->unapprovePayments($loanId, $instNum);
			}
			$submitted		=	true;
		}
		$this->adminBorrowerRepaymentView->getRepaymentDetails($installmentId,$loanid);
	
		$withArry	=	array(	"adminBorRepayViewMod" => $this->adminBorrowerRepaymentView, 								
								"classname"=>"fa fa-cc fa-fw",
								"submitted"=>$submitted,
								"type"=>$type); 
								
		return view('admin.admin-borrowersrepaymentview')
				->with($withArry); 
	
	}
	
	public function recalculatePenalityAction(){		

		$postArray	=	Request::all();
		$result	=	$this->adminBorrowerRepaymentView->recalculatePenality($postArray);
		return	json_encode($result);
	}
}
