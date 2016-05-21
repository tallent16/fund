<?php 
namespace App\Http\Controllers;
use Request;
use	\App\models\AdminLoanApprovalModel;
use	\App\models\BorrowerApplyLoanModel;
use Lang;
class AdminLoanApprovalController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}	
	
	public function littleMoreInit() {
		$this->adminloanApprovalModel	=	new AdminLoanApprovalModel;
		$this->borrowerApplyLoanModel	=	new BorrowerApplyLoanModel;
	}
		
	public function indexAction($loan_id){
		
		$submitted	=	false;
		$sourceId =	base64_decode($loan_id);
		$loanStatus		=	$this->borrowerApplyLoanModel->getLoanStatus($sourceId);
		if($loanStatus	==	LOAN_STATUS_CANCELLED) {
			return redirect()->to('admin/loanlisting');
		}
		 if(!$this->borrowerApplyLoanModel->CheckLoanExists($sourceId)){
			return redirect()->to('admin/loanlisting');
		}
		$this->borrowerApplyLoanModel->getBorrowerLoanDetails($sourceId);
		return view('admin.admin-loanapprovalmode')
					->with(array("adminLoanApprMod"=>$this->borrowerApplyLoanModel,
									"submitted"=>$submitted,
									"classname"=>"fa fa-check-circle fa-fw"
								)
						);
	}
	
	public function saveLoanApprovalAction($loan_id){
		
		$sourceId =	base64_decode($loan_id);
		$postArray	=	Request::all();
		$bor_id		=	$postArray['borrower_id'];
		switch($postArray['admin_process']){
			case	"save_comments":
					$result		=	$this->borrowerApplyLoanModel->saveLoanApplyComments($postArray['comment_row'],
																								$sourceId);
					break;
			case	"return_borrower":
					$dataArray = array(	'status' 	=>	LOAN_STATUS_PENDING_COMMENTS );
					$result		=	$this->borrowerApplyLoanModel->updateLoanApplyStatus($dataArray,$sourceId,
																				$bor_id,"return_borrower");
					break;
			case	"approve":
					$dataArray 				=	array(	'status' 	=>	LOAN_STATUS_APPROVED );
					
					$this->borrowerApplyLoanModel->updateBiCloseDate($postArray['bid_close_date'],$sourceId);
					$result		=	$this->borrowerApplyLoanModel->updateLoanApplyStatus($dataArray,$sourceId,
																				$bor_id,"approve");
					break;
			case	"cancel":
					$dataArray = array(	'status' 	=>	LOAN_STATUS_CANCELLED );
					$result		=	$this->borrowerApplyLoanModel->updateLoanApplyStatus($dataArray,$sourceId,
																				$bor_id,"cancel");
					break;
		}
		if($result) {
			return redirect()->route('admin.loanapprovalview', array('loan_id' => $loan_id	))
							->with('success','Loan Approval status updated successfully');
		}else{
			return redirect()->route('admin.loanapprovalview', array('loan_id' => $loan_id	))
						->with('failure','Loan Approval status updated Failed');	
		}	
	}
	
	public function downloadLoanDocumentAction($doc_id=null) {
		
		// Edit borrower loan passing loan id parameter
		if (null !== $doc_id) {
			$sourceId 		=	explode("_",$doc_id);
			$loan_doc_url	=	$this->borrowerApplyLoanModel->getBorrowerLoanDocUrl($sourceId[0]);
			$imageName = $this->get_basename($loan_doc_url);
			//~ return  Response::download($loan_doc_url);
			header('Content-Disposition: attachment; filename=' .$this->get_basename($loan_doc_url));
			header('Content-Type: application/force-download');
			header('Content-Type: application/octet-stream');
			header('Content-Type: application/download');
			header('Content-Description: File Transfer');
			echo file_get_contents($loan_doc_url);
		}
	}
	
	
	public function get_basename($filename) {
		return preg_replace('/^.+[\\\\\\/]/', '', $filename);
	}
	
	protected function checkBiCloseDateValidationction() {
		$postArray				=	Request::all();
		$rowArray				=	array("bidcloseDateErr"=>"");
		$status					=	"success";
		list($bidDate, $bidMonth, $bidYear) = explode("/", $postArray['bidcloseDate']);
		$formattedbidcloseDate	=	$bidYear."-".$bidMonth."-".$bidDate;
		
		 if(strtotime($formattedbidcloseDate) <	strtotime('today') ){
				$rowArray['bidcloseDateErr']	=	Lang::get("Bid Close Date should not be earlier than today");
				$status							=	"error";
		}
		return	json_encode(array("status"=>$status,"row"=>$rowArray));
	}
}
