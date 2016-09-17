<?php 
namespace App\Http\Controllers;
use Request;
//~ use	\App\models\AdminLoanApprovalModel;
use	\App\models\BorrowerApplyLoanModel;
use Lang;
use ZipArchive;
class AdminLoanApprovalController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}	
	
	public function littleMoreInit() {
		//~ $this->adminloanApprovalModel	=	new AdminLoanApprovalModel;
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
	public function updateBidCloseDateAction() {
		
		$postArray	=	Request::all();
		$loan_id	=	$postArray['loan_id'];
		
		$result	=	$this->borrowerApplyLoanModel->updateBiCloseDate($postArray['bid_close_date'],$loan_id);
		if($result) {
			$successTxt	=	$this->borrowerApplyLoanModel->getSystemMessageBySlug("loan_bidclose_date_update");
			return redirect()->route('admin.loanapproval', array('loan_id' => base64_encode($loan_id)	))
						->with('success',$successTxt);
		}else{
			return redirect()->route('admin.loanapproval', array('loan_id' => base64_encode($loan_id) ))
						->with('failure','Bid Close Date Updated Failed');	
		}	
	}
	
	public function saveLoanApprovalAction(){
		
		$postArray	=	Request::all();
		$loan_id	=	$postArray['loan_id'];
		$bor_id		=	$postArray['borrower_id'];
		$transtype	=	$postArray['trantype'];
		
		$result	=	$this->borrowerApplyLoanModel->processLoan($postArray);
		$this->borrowerApplyLoanModel->updateBiCloseDate($postArray['bid_close_date'],$loan_id);
		if($result) {
			$successTxt	=	$this->borrowerApplyLoanModel->getSystemMessageBySlug("borrower_loan_save_by_admin");
			return redirect()->route('admin.loanapproval', array('loan_id' => base64_encode($loan_id)	))
						->with('success',$successTxt);
		}else{
			return redirect()->route('admin.loanapproval', array('loan_id' => base64_encode($loan_id) ))
						->with('failure','loan information Updated Failed');	
		}	
	}
	
	public function saveCommentLoanApprovalAction(){
		
		$postArray	=	Request::all();
		$loan_id	=	$postArray['loan_id'];
		$bor_id		=	$postArray['borrower_id'];
		
		$result		=	$this->borrowerApplyLoanModel->saveLoanApplyComments($postArray['comment_row'],$loan_id);
		if($result) {
			$successTxt	=	$this->borrowerApplyLoanModel->getSystemMessageBySlug("loan_comments_saved");
			return redirect()->route('admin.loanapproval', array('loan_id' => base64_encode($loan_id)	))
						->with('success',$successTxt);
		}else{
			return redirect()->route('admin.loanapproval', array('loan_id' => base64_encode($loan_id) ))
						->with('failure','Comments saved Failed');	
		}	
	}
	
	public function returnBorrowerLoanApprovalAction(){
		
		$postArray	=	Request::all();
		$loan_id	=	$postArray['loan_id'];
		$bor_id		=	$postArray['borrower_id'];
		$command	=   $postArray['comment_row'];
		
		$saveresult		=	$this->borrowerApplyLoanModel->saveLoanApplyComments($postArray['comment_row'],$loan_id);
		if($saveresult){
		$dataArray 	= 	array(	'status' 	=>	LOAN_STATUS_PENDING_COMMENTS );
		
		$result		=	$this->borrowerApplyLoanModel->updateLoanApplyStatus($dataArray,$loan_id,
																	$bor_id,"return_borrower");
		}	
		if($result) {
			$successTxt	=	$this->borrowerApplyLoanModel->getSystemMessageBySlug("loan_return_to_borrower");
			return redirect()->route('admin.loanapproval', array('loan_id' => base64_encode($loan_id)	))
						->with('success',$successTxt);
		}else{
			return redirect()->route('admin.loanapproval', array('loan_id' => base64_encode($loan_id) ))
						->with('failure','return borrower  loan approval updated Failed');	
		}	
	}
	
	public function approveLoanApprovalAction(){
			
		$postArray	=	Request::all();
		$loan_id	=	$postArray['loan_id'];
		$bor_id		=	$postArray['borrower_id'];
		$transtype	=	$postArray['trantype'];
		
		$dataArray 	=	array(	'status' 	=>	LOAN_STATUS_APPROVED );
		//~ $result	=	$this->borrowerApplyLoanModel->processLoan($postArray);
		$this->borrowerApplyLoanModel->updateBiCloseDate($postArray['bid_close_date'],$loan_id);
		
		$result		=	$this->borrowerApplyLoanModel->updateLoanApplyStatus($dataArray,$loan_id,
																				$bor_id,"approve");
		if($result) {
			$successTxt	=	$this->borrowerApplyLoanModel->getSystemMessageBySlug("loan_approved");
			return redirect()->route('admin.loanapproval', array('loan_id' => base64_encode($loan_id)	))
						->with('success',$successTxt);
		}else{
			return redirect()->route('admin.loanapproval', array('loan_id' => base64_encode($loan_id) ))
						->with('failure','approved loanaprroval updated Failed');	
		}	
	}
	
	public function canelLoanApprovalAction(){
		
		$postArray	=	Request::all();
		$loan_id	=	$postArray['loan_id'];
		$bor_id		=	$postArray['borrower_id'];
		
		$dataArray 	= 	array(	'status' 	=>	LOAN_STATUS_CANCELLED );
		$result		=	$this->borrowerApplyLoanModel->updateLoanApplyStatus($dataArray,$loan_id,
																				$bor_id,"cancel");
		if($result) {
			$successTxt	=	$this->borrowerApplyLoanModel->getSystemMessageBySlug("loan_cancelled");
			return redirect()->route('admin.loanapproval', array('loan_id' => base64_encode($loan_id)) )
						->with('success',$successTxt);
		}else{
			return redirect()->route('admin.loanapproval', array('loan_id' => base64_encode($loan_id) ))
						->with('failure','cancel loanapproval updated Failed');	
		}		
	}
	public function downloadLoanDocumentAction($doc_id=null) {
		
		// Edit borrower loan passing loan id parameter
		if (null !== $doc_id) {
			$sourceId 		=	explode("_",$doc_id);
			$loan_doc_url	=	$this->borrowerApplyLoanModel->getBorrowerLoanDocUrl($sourceId[0]);
			
			$imageName = $this->get_basename($loan_doc_url);
			header('Content-Disposition: attachment; filename=' .$this->get_basename($loan_doc_url));
			header('Content-Type: application/force-download');
			header('Content-Type: application/octet-stream');
			header('Content-Type: application/download');
			header('Content-Description: File Transfer');
			echo file_get_contents($loan_doc_url);
		}
	}
	public function downloadAllFilesAction(){
	
		$archive_file_name	=	"uploads/documentList.zip";
		$file_name			=	"documentList.zip";
		$doc_ids 			=	Request::get("documents");
		$file_names			=	$this->borrowerApplyLoanModel->getBorrowerAllLoanDocUrl($doc_ids);
		
		$zip = new ZipArchive();
		if(file_exists($archive_file_name)) {
			if ($zip->open($archive_file_name, ZIPARCHIVE::OVERWRITE )!==TRUE) {
				exit("cannot open <$archive_file_name>\n");
			}
		}else{
			if ($zip->open($archive_file_name, ZIPARCHIVE::CREATE )!==TRUE) {
				exit("cannot open <$archive_file_name>\n");
			}
		}
		
		
		
		foreach($file_names as $files){
			$download_file = file_get_contents($files);
			$zip->addFromString(basename($files),$download_file);
		}
		
		$zip->close();
		header("Content-type: application/zip"); 
		header("Content-Disposition: attachment; filename=$file_name"); 
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
		readfile("$archive_file_name"); 
		exit;
		
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
