<?php 
namespace App\Http\Controllers;
use Request;
use	\App\models\AdminLoanApprovalModel;
use	\App\models\BorrowerApplyLoanModel;
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
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			$bor_id		=	$postArray['borrower_id'];
			//~ print_r($postArray);
			//~ die;
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
						$dataArray = array(	'status' 	=>	LOAN_STATUS_APPROVED );
						$result		=	$this->borrowerApplyLoanModel->updateLoanApplyStatus($dataArray,$sourceId,
																					$bor_id,"approve");
						break;
				case	"cancel":
						$dataArray = array(	'status' 	=>	LOAN_STATUS_CANCELLED );
						$result		=	$this->borrowerApplyLoanModel->updateLoanApplyStatus($dataArray,$sourceId,
																					$bor_id,"cancel");
						break;
			}
			
			$submitted	=	true;
		}
		
		$this->borrowerApplyLoanModel->getBorrowerLoanDetails($sourceId);
		return view('admin.admin-loanapprovalmode')
					->with(array("adminLoanApprMod"=>$this->borrowerApplyLoanModel,
									"submitted"=>$submitted,
									"classname"=>"fa fa-check-circle fa-fw"
								)
						);
				
		
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
}
