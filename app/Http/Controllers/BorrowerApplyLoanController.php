<?php 
namespace App\Http\Controllers;
use Request;
use	\App\models\BorrowerApplyLoanModel;
use Response;
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
			return $this->getBorrowerLoanDetails('edit', $sourceId);
		} 
	}
	
	public function downloadAction($doc_id=null) {
		
		// Edit borrower loan passing loan id parameter
		if (null !== $doc_id) {
			$sourceId 		=	explode("_",$doc_id);
			$loan_doc_url	=	$this->borrowerApplyLoanModel->getBorrowerLoanDocUrl($sourceId[0]);
			return  Response::download($loan_doc_url);
		} 
	}
	
		protected function processLoan($postArray) {
		
		$tranType 	= 	$postArray["trantype"];
		$result	 	= 	$this->borrowerApplyLoanModel->processLoan($postArray);
		
		$withArry	=	array(	"BorModLoan"=>$this->borrowerApplyLoanModel,
									"classname"=>"fa fa-usd fa-fw user-icon"
								);
		if ($result) {
			switch ($tranType) {
				case "add":
					$withArry["status"]	=	"success";
					$withArry["msg"]	=	"New Loan Created Successfully";
					break;
				
				case "edit":
					$withArry["status"]	=	"success";
					$withArry["msg"]	=	"Loan Updated Successfully";
					$sourceId			=	$postArray["loan_id"];
					$this->borrowerApplyLoanModel->getBorrowerLoanDetails($sourceId);
					break;
			}
			
		} else {
			$withArry["status"]	=	"failure";
			$withArry["msg"]	=	"Failed to create new loan";
		}
		return view('borrower.borrower-applyloan')
				->with($withArry);
	}
	
	protected function getBorrowerLoanDetails($trantype, $sourceId) {
		
		switch ($trantype) {
			
			case "add":
				$this->borrowerApplyLoanModel->processDropDowns();
				$this->borrowerApplyLoanModel->getBorrowerDocumentListInfo();
				break;
				
			case "edit":
				$this->borrowerApplyLoanModel->getBorrowerLoanDetails($sourceId);
				break;
		}
		$withArry	=	array(	"BorModLoan"=>$this->borrowerApplyLoanModel,
									"classname"=>"fa fa-usd fa-fw user-icon"
								);
		return view('borrower.borrower-applyloan')
				->with($withArry);
				
	}
}
