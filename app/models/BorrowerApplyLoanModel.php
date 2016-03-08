<?php namespace App\models;
use fileupload\FileUpload;
use File;
class BorrowerApplyLoanModel extends TranWrapper {
	
	public $loan_id		  					=  	"";
	public $loan_reference_number  			=  	"";
	public $borrower_id  					=  	"";
	public $purpose		  					=  	"";
	public $apply_date			  			=  	"";
	public $apply_amount		  			=  	"";
	public $loan_currency_code			  	=	"";
	public $loan_tenure		  				=  	"";
	public $target_interest  				=  	"";
	public $bid_open_date		  			=  	"";
	public $bid_close_date  				=  	"";
	public $bid_type			  			=  	"";
	public $partial_sub_allowed  			=  	"";
	public $min_for_partial_sub  			=  	"";
	public $repayment_type  				=  	"";
	public $status  						=  	"";
	public $comments  						=  	"";
	public $final_interest_rate  			=  	"";
	public $loan_sactioned_amount  			=  	"";
	public $trans_fees  					=  	"";
	public $total_disbursed  				=  	"";
	public $total_principal_repaid  		=  	"";
	public $total_interest_paid  			=  	"";
	public $total_penalties_paid  			=  	"";
	public $loan_product_image  			=  	"";
	public $loan_video_url  				=  	"";

	public $document_details				= 	array();
	
	public function getBorrowerLoanDetails($loan_id) {
		
		$this->getBorrowerLoanInfo($loan_id);
		$this->getBorrowerDocumentListInfo();
		//~ $this->processDropDowns();
	}
		
	public function getBorrowerLoanInfo($loan_id) {
		
		$current_borrower_id	=	 $this->getCurrentBorrowerID();
		
		$loanlist_sql			= "	SELECT 	loans.loan_id,
											loans.loan_reference_number,
											loans.borrower_id,
											loans.purpose,
											ifnull(DATE_FORMAT(loans.apply_date,'%d/%m/%Y'),'') apply_date,
											ROUND(loans.apply_amount,2) apply_amount ,
											loans.loan_currency_code,
											loans.loan_tenure,
											loans.target_interest,
											ifnull(DATE_FORMAT(loans.bid_open_date,'%d/%m/%Y'),'') bid_open_date,
											ifnull(DATE_FORMAT(loans.bid_close_date,'%d/%m/%Y'),'') bid_close_date,
											ifnull(DATE_FORMAT(borrowers.operation_since,'%d/%m/%Y'),'') operation_since,
											loans.bid_type,
											loans.partial_sub_allowed,
											loans.min_for_partial_sub,
											loans.repayment_type,
											loans.status,
											loans.comments,
											loans.final_interest_rate,
											case loans.status 
												   when 1 then 'New' 
												   when 2 then 'Submitted for Approval'
												   when 3 then 'Pending Comments'
												   when 4 then 'Approved for Bid'
												   when 5 then 'Bid Closed'
												   when 6 then 'Loan Disbursed'
												   when 7 then 'Repayments Complete'
											end as statusText,
											loans.comments,
											loans.final_interest_rate,
											loans.loan_sactioned_amount,
											loans.trans_fees,
											loans.total_disbursed,
											loans.total_principal_repaid,
											loans.total_interest_paid,
											loans.total_penalties_paid,
											loans.loan_product_image,
											loans.loan_video_url
									FROM 	loans
									WHERE	loans.loan_id		=	{$loan_id}";
		
		$loanlist_rs		= 	$this->dbFetchAll($loanlist_sql);
		
		if ($loanlist_rs) {
		
			$vars = get_object_vars ( $loanlist_rs[0] );
			foreach($vars as $key=>$value) {
				$this->{$key} = $value;
			}
		}
	}
	
	public function getBorrowerDocumentListInfo() {
		
		$loandocument_sql		= 	"	SELECT 	loan_doc_id,
												doc_name,
												is_mandatory,
												short_name
										FROM 	loan_doc_master";
		
		
		$loandocument_rs		= 	$this->dbFetchAll($loandocument_sql);
			
		if ($loandocument_rs) {
			foreach ($loandocument_rs as $docRow) {
				$newrow = count($this->document_details);
				$newrow ++;
				foreach ($docRow as $colname => $colvalue) {
					$this->document_details[$newrow][$colname] = $colvalue;
				}
			}
		}
		return $loandocument_rs;
	}
	
	public function processLoan($postArray) {
		//~ $fileUploadObj		=	new FileUpload();
		//~ $destinationPath 	= 	'uploads/borrower';
		//~ foreach($postArray['documents'] as $file) {
			//~ if(isset($file)) {
				//~ $fileUploadObj->storeFile($destinationPath ,$file);
			//~ }
		//~ }
		
		//~ $transType = $postArray['trantype'];
		$transType = 'add';
		//~ if($transType	==	"edit") {
			//~ $borrowerId  	= 	$postArray['borrower_id'];
			//~ $whereArry		=	array("borrower_id" => $borrowerId);
			 //~ $this->dbDelete("borrower_directors",$whereArry);
		//~ }
		$loanId		=	 $this->updateBorrowerLoanInfo($postArray,$transType);
		$this->updateBorrowerLoanDocuments($postArray,$transType,$loanId);
	}
	
	public function updateBorrowerLoanInfo($postArray,$transType) {
		
		if($postArray['isSaveButton']	==	"yes") {
			$status		=	BORROWER_STATUS_NEW;	
		}else{
			$status		=	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL;
		}
		if ($transType == "edit") {
			$loanId	= $postArray['loan_id'];
		} else {
			$loanId = 0;
		}
		
		$loan_reference_number 			=	"Loan-Ref-";
		$borrower_id					= 	$this->getCurrentBorrowerID();
		$purpose						= 	$postArray['laon_purpose'];
		$apply_date						= 	$this->getDbDateFormat(date("d/m/Y"));
		$apply_amount		 			= 	$this->makeFloat($postArray['loan_amount']);
		$loan_tenure	 				= 	$postArray['loan_tenure'];
		$target_interest	 			= 	$postArray['target_interest'];
		$bid_close_date 				= 	$postArray['bid_close_date'];
		if($bid_close_date	==	"") 
			$bid_close_date				= 	$this->getDbDateFormat(date("d/m/Y"));
		else
			$bid_close_date				= 	$this->getDbDateFormat($bid_close_date);
		$bid_type		 				= 	$postArray['paid_up_capital'];
		$partial_sub_allowed 			= 	$postArray['partial_sub_allowed'];
		$min_for_partial_sub 			= 	$this->makeFloat($postArray['min_for_partial_sub']);
	
		$repayment_type 				= 	$postArray['payment_type'];
		$final_interest_rate 			= 	$postArray['target_interest'];
		$loan_sactioned_amount 			= 	$apply_amount;
		$trans_fees						=	$apply_amount - ( ($apply_amount*4)/100 );
		$total_disbursed				=	$apply_amount	-	$trans_fees;
		
		$dataArray = array(	'loan_reference_number' 		=> $loan_reference_number,
							'borrower_id'					=> $borrower_id,
							'purpose'						=> ($purpose!="")?$purpose:null,
							'apply_date	' 					=> $apply_date,
							'apply_amount' 					=> ($apply_amount!="")?$apply_amount:null,
							'loan_tenure' 					=> ($loan_tenure!="")?$loan_tenure:null,
							'target_interest' 				=> ($target_interest!="")?$target_interest:null,
							'bid_close_date' 				=> ($bid_close_date!="")?$bid_close_date:null,
							'bid_type' 						=> ($bid_type!="")?$bid_type:null,
							'partial_sub_allowed' 			=> ($partial_sub_allowed!="")?$partial_sub_allowed:null,
							'min_for_partial_sub' 			=> ($min_for_partial_sub!="")?$min_for_partial_sub:null,
							'repayment_type' 				=> $repayment_type,
							'final_interest_rate' 			=> ($final_interest_rate!="")?$final_interest_rate:null,
							'loan_sactioned_amount' 		=> $loan_sactioned_amount,
							'trans_fees' 					=> $trans_fees,
							'total_disbursed' 				=> $total_disbursed);
							
	//~ echo "<pre>",print_r($dataArray),"</pre>";
		//~ die;	
		if ($transType != "edit") {
			$loanId =  $this->dbInsert('loans', $dataArray, true);
			if ($loanId < 0) {
				return -1;
			}
			// Update the loan_reference_number to the newly added row
			$dataArray 	= 	array( 'loan_reference_number'	=> $loan_reference_number.$loanId);
			$whereArry	=	array("loan_id" =>"{$loanId}");
			$result = $this->dbUpdate('loans', $dataArray, $whereArry );
			return $loanId;
		}else{
			$whereArry	=	array("loan_id" =>"{$loanId}");
			$this->dbUpdate('loans', $dataArray, $whereArry);
			return $loanId;
		}
	}
	
	public function updateBorrowerLoanDocuments($postArray,$transType,$loanId) {
		
		$fileUploadObj	=	new FileUpload();
		$numRows 		= 	count($postArray['document_ids']);
		$rowIndex		= 	0;
		$borrower_id	= 	$this->getCurrentBorrowerID();
		
		for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
			
			$loan_doc_id		= 	$postArray['document_ids'][$rowIndex];
			$loan_id			= 	$loanId;
			$destinationPath 	= 	Config::get('moneymatch_settings.upload_bor');
			$destinationPath 	= 	$destinationPath."/".$borrower_id."/loan".$loan_id."documents";
			if(!File::exists($destinationPath)) {
				File::makeDirectory($destinationPath, 0755, true);
			}
			
			// Construct the data array
			if(isset($postArray['documents'][$rowIndex])) {
				
				$file			=	$postArray['documents'][$rowIndex];
				$filename 		= 	$file->getClientOriginalName();
				$loan_doc_url	=	$destinationPath."/".$filename;
				
				$dataArray 	= 	array(	
									'loan_doc_id' 				=> $loan_doc_id,
									'loan_id'					=> $loan_id,
									'loan_doc_url'	 			=> $loan_doc_url);		
								
				// Insert or Update the loan documents list
					if($transType	==	"add") {
						$result =  $this->dbInsert('loan_docs_submitted', $dataArray, true);
						if ($result < 0) {
							return -1;
						}
					}else{
						$whereArry	=	array("loan_id" =>"{$loan_id}","loan_doc_id" =>"{$loan_doc_id}");
						$this->dbUpdate('loan_docs_submitted', $dataArray, $whereArry);
					}
			// Insert or Update the loan documents list	
				$fileUploadObj->storeFile($destinationPath ,$file);
			}
		}
		return 1;
	}
	
}
