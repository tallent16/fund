<?php 
namespace App\Http\Controllers;
use Request;
use	\App\models\BorrowerApplyLoanModel;
use Response;
use Lang;
use Session;
class BorrowerApplyLoanController extends MoneyMatchController {

	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->borrowerApplyLoanModel	=	new BorrowerApplyLoanModel;
	}
	
	public function indexAction($laon_id=null) {
		
		if (Request::isMethod('post')) {
			$postArray	=	Request::all();
			return $this->processLoan($postArray);
		}
		// Create new borrower laon
		if (null === $laon_id) {
			$sourceId =	0;
			return $this->getBorrowerLoanDetails('add', $sourceId);
		} 
		// Edit borrower loan passing loan id parameter
		if (null !== $laon_id) {
			$sourceId =	base64_decode($laon_id);
			$loanStatus		=	$this->borrowerApplyLoanModel->getLoanStatus($sourceId);
			if($loanStatus	==	LOAN_STATUS_CANCELLED) {
				return redirect()->to('creator/myloaninfo');
			}
			return $this->getBorrowerLoanDetails('edit', $sourceId);
		} 
	}
	
	public function downloadAction($doc_id=null) {
		
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
	protected function processLoan($postArray) {
		
		$tranType 	= 	$postArray["trantype"];
		$result	 	= 	$this->borrowerApplyLoanModel->processLoan($postArray);
		
		$withArry	=	array(	"BorModLoan"=>$this->borrowerApplyLoanModel,
									"classname"=>"fa fa-file-image-o fa-fw"
								);
		if ($result) {
			switch ($tranType) {
				case "add":
				
					break;
				
				case "edit":
					
					$sourceId			=	$postArray["loan_id"];
					$this->borrowerApplyLoanModel->getBorrowerLoanDetails($sourceId);
					break;
			}
			Session::put("success",$this->borrowerApplyLoanModel->successTxt);
			
		} else {
			$withArry["status"]	=	"failure";
			$withArry["msg"]	=	"Failed to create new loan";
			Session::put("failure","Loan Information failed saved");
		}
		return redirect()->to('creator/myloaninfo');
	
	}
	
	protected function getBorrowerLoanDetails($trantype, $sourceId) {
		
		switch ($trantype) {
			
			case "add":
				$this->borrowerApplyLoanModel->loan_status			=	LOAN_STATUS_NEW;
				$this->borrowerApplyLoanModel->bid_close_date	=	date('d-m-Y', strtotime("+20 days"));
				$this->borrowerApplyLoanModel->processDropDowns();
				$this->borrowerApplyLoanModel->getBorrowerDocumentListInfo();
				$this->borrowerApplyLoanModel->defaultMilestones();
				break;
				
			case "edit":
				$this->borrowerApplyLoanModel->getBorrowerLoanDetails($sourceId);
				
				break;
		}
		$withArry	=	array(	"BorModLoan"=>$this->borrowerApplyLoanModel,
									"classname"=>"fa fa-file-image-o fa-fw"
								);
		return view('borrower.borrower-applyloan')
				->with($withArry);
				
	}
	
	protected function checkApplyLoanValidationction() {
		$postArray	=	Request::all();
		$rowArray	=	array(	"loan_amountErr"=>"",
								"partialSubAmountErr"=>""
							);
		$status		=	"success";
		if($postArray['loan_amount'] <=	0) {
			$rowArray['loan_amountErr']	=	Lang::get("Loan should be greater than zero");
			$status						=	"error";
		}
		
		if($postArray['partialSubAllowed'] ==	1) {
			
			if($postArray['partialSubAmount'] <=	0) {
				$rowArray['partialSubAmountErr']	=	Lang::get("Minimal Partial Subscription should be greater than zero");
				$status								=	"error";
			}
		}
		return	json_encode(array("status"=>$status,"row"=>$rowArray));
	}
	
}
