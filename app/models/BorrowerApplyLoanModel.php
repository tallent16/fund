<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
class BorrowerApplyLoanModel extends TranWrapper {
	
	public $loan_id		  					=  	"";
	public $loan_reference_number  			=  	"";
	public $borrower_id  					=  	"";
	public $purpose_singleline		  		=  	"";
	public $purpose		  					=  	"";
	public $apply_date			  			=  	"";
	public $apply_amount		  			=  	"";
	public $loan_currency_code			  	=	"";
	public $loan_tenure		  				=  	"";
	public $loan_tenure_list	  			=  	array();
	public $target_interest  				=  	"";
	public $bid_open_date		  			=  	"";
	public $bid_close_date  				=  	"";
	public $bid_type			  			=  	"";
	public $partial_sub_allowed  			=  	"";
	public $min_for_partial_sub  			=  	"";
	public $repayment_type  				=  	"";
	public $status  						=  	"";
	public $statusText  					=  	"New";
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
	public $format_date						= 	"";
	public	$commentsInfo					=	array();
	public	$comments_count					=	0;

	public $document_details				= 	array();
	public $submitted_document_details		= 	array();
	public $purposeSingleLineInfo			= 	array();
	public $bidTypeSelectOptions			= 	"";
	public $paymentTypeSelectOptions		= 	"";
	
	
	public function getBorrowerLoanDetails($loan_id) {
		
		$this->getBorrowerLoanInfo($loan_id);
		$this->getBorrowerDocumentListInfo();
		$this->getBorrowerSubmittedDocumentInfo($loan_id);
		$this->getLoanApplyComments($loan_id);
		$this->getLoanApplyOpenCommentsCount($loan_id);
		$this->processDropDowns();
	}
		
	public function getBorrowerLoanInfo($loan_id) {
		
		
		
		$loanlist_sql			= "	SELECT 	loans.loan_id,
											loans.loan_reference_number,
											loans.borrower_id,
											loans.purpose,
											loans.purpose_singleline,											
											ifnull(DATE_FORMAT(loans.apply_date,'%d/%m/%Y'),'') apply_date,
											ROUND(loans.apply_amount,2) apply_amount ,
											loans.loan_currency_code,
											loans.loan_tenure,
											loans.target_interest,
											ifnull(DATE_FORMAT(loans.bid_open_date,'%d/%m/%Y'),'') bid_open_date,
											ifnull(DATE_FORMAT(loans.bid_close_date,'%d/%m/%Y'),'') bid_close_date,
											loans.bid_type,
											case loans.bid_type 
												   when 1 then 'Open Bid' 
												   when 2 then 'Closed Bid'
												   when 3 then 'Fixed Interest'
											end as bidTypeText,
											loans.partial_sub_allowed,
											loans.min_for_partial_sub,
											loans.repayment_type,
											case loans.repayment_type 
												   when 1 then 'Bullet' 
												   when 2 then 'Monthly Interest'
												   when 3 then 'EMI'
											end as repaymentText,
											loans.status,
											loans.comments,
											loans.final_interest_rate,
											case loans.status 
												   when 1 then '' 
												   when 2 then 'disabled'
												   when 3 then 'disabled'
												   when 4 then ''
												   when 5 then 'disabled'
												   when 6 then 'disabled'
												   when 7 then 'disabled'
												   when 9 then 'disabled'
											end as viewStatus,
											case loans.status 
												   when 1 then 'New' 
												   when 2 then 'Submitted for Approval'
												   when 3 then 'Approved for Bid'
												   when 4 then 'Pending Comments'
												   when 5 then 'Bid Closed'
												   when 6 then 'Loan Disbursed'
												   when 7 then 'Unsuccessful Loan'
												   when 9 then 'Repayments Complete'
											end as statusText,
											loans.comments,
											loans.final_interest_rate,
											loans.loan_sanctioned_amount,
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
	
	public function getBorrowerSubmittedDocumentInfo($loan_id) {
		
		$loandocument_sql		= 	"	SELECT 	loan_doc_id,
												loan_doc_submitted_id,
												loan_doc_url,
												status
										FROM 	loan_docs_submitted
										WHERE	loan_id	={$loan_id}";
		
		
		$loandocument_rs		= 	$this->dbFetchAll($loandocument_sql);
			
		if ($loandocument_rs) {
			foreach ($loandocument_rs as $docRow) {
				$docRowIndex	=	$docRow->loan_doc_id;
				$docRowValue	=	$docRow->loan_doc_submitted_id;
				$this->submitted_document_details[$docRowIndex] = $docRowValue;
				$this->submitted_document_details['loan_doc_url'][$docRowIndex] = $docRow->loan_doc_url;
			}
		}
		return $loandocument_rs;
	}
	
	public function processLoan($postArray) {
		
		$transType 	= $postArray['trantype'];
		$loanId		=	 $this->updateBorrowerLoanInfo($postArray,$transType);
		$this->updateBorrowerLoanDocuments($postArray,$transType,$loanId);
		if (isset($postArray['hidden_loan_status']) && $postArray['hidden_loan_status']	==	"corrections_required" ) {
			if (isset($postArray['comment_row'])) {
				$this->saveLoanApplyComments($postArray['comment_row'],$loanId);
			}
		}
		return $loanId;
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
		
					
		$loan_reference_number 			=	"L-";
		$format_date 					= 	date('Ym');
		$borrower_id					= 	$this->getCurrentBorrowerID();
		$purpose						= 	$postArray['laon_purpose'];
		$purpose_singleline				= 	$postArray['purpose_singleline'];
		$apply_date						= 	$this->getDbDateFormat(date("d/m/Y"));
		$apply_amount		 			= 	$this->makeFloat($postArray['loan_amount']);
		$loan_tenure	 				= 	$postArray['loan_tenure'];
		$target_interest	 			= 	$postArray['target_interest'];
		$bid_close_date 				= 	$postArray['bid_close_date'];
		if($bid_close_date	==	"") 
			$bid_close_date				= 	$this->getDbDateFormat(date("d/m/Y"));
		else
			$bid_close_date				= 	$this->getDbDateFormat($bid_close_date);
		$bid_type		 				= 	$postArray['bid_type'];
		$partial_sub_allowed 			= 	$postArray['partial_sub_allowed'];
		if(isset($postArray['min_for_partial_sub']))
			$min_for_partial_sub 			= 	$this->makeFloat($postArray['min_for_partial_sub']);
		else
			$min_for_partial_sub 			= 	"";
		$repayment_type 				= 	$postArray['payment_type'];
		$final_interest_rate 			= 	$postArray['target_interest'];
		$loan_sanctioned_amount 		= 	$apply_amount;
		$trans_fees						=	($apply_amount*4)/100 ;
		$total_disbursed				=	$apply_amount	-	$trans_fees;
		
		$dataArray = array(	'borrower_id'					=> $borrower_id,
							'purpose'						=> ($purpose!="")?$purpose:null,
							'purpose_singleline'			=> ($purpose_singleline!="")?$purpose_singleline:null,
							'apply_date' 					=> $apply_date,
							'apply_amount' 					=> ($apply_amount!="")?$apply_amount:null,
							'loan_tenure' 					=> ($loan_tenure!="")?$loan_tenure:null,
							'target_interest' 				=> ($target_interest!="")?$target_interest:null,
							'bid_close_date' 				=> ($bid_close_date!="")?$bid_close_date:null,
							'bid_type' 						=> ($bid_type!="")?$bid_type:null,
							'partial_sub_allowed' 			=> ($partial_sub_allowed!="")?$partial_sub_allowed:null,
							'min_for_partial_sub' 			=> ($min_for_partial_sub!="")?$min_for_partial_sub:null,
							'repayment_type' 				=> $repayment_type,
							'final_interest_rate' 			=> ($final_interest_rate!="")?$final_interest_rate:null,
							'loan_sanctioned_amount' 		=> $loan_sanctioned_amount,
							'trans_fees' 					=> $trans_fees,
							'status' 						=> $status,
							'total_disbursed' 				=> $total_disbursed);
							
	// echo "<pre>",print_r($dataArray),"</pre>";
		
		if ($transType != "edit") {
			$loanId =  $this->dbInsert('loans', $dataArray, true);
			if ($loanId < 0) {
				return -1;
			}
			// Update the loan_reference_number to the newly added row		
			$dataArray 	   = array( 'loan_reference_number'	=> $loan_reference_number.$format_date."-".$loanId);
			$whereArry	   = array("loan_id" =>"{$loanId}");
			$result 	   = $this->dbUpdate('loans', $dataArray, $whereArry );
			return $loanId;
		}else{
			$whereArry								=	array("loan_id" =>"{$loanId}");
			if (!$this->dbUpdate('loans', $dataArray, $whereArry)) {
				return -1;
			}
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
						if($this->checkLoanDocumentUpdate($loan_doc_id,$loan_id)) {
							$whereArry	=	array("loan_id" =>"{$loan_id}","loan_doc_id" =>"{$loan_doc_id}");
							$this->dbUpdate('loan_docs_submitted', $dataArray, $whereArry);
						}else{
							$result =  $this->dbInsert('loan_docs_submitted', $dataArray, true);
							if ($result < 0) {
								return -1;
							}
						}
					}
					
			// Insert or Update the loan documents list	
				$fileUploadObj->storeFile($destinationPath ,$file);
			}
		}
		return 1;
	}
	
	public function processDropDowns() {
		
		$bidTypeList		=	array(
									array("id"=>1,"name"=>"Open Bid"),
									array("id"=>2,"name"=>"Closed Bid"),
									array("id"=>3,"name"=>"Fixed Interest")
								);
		$paymentTypeList	=	array(
								array("id"=>1,"name"=>"Bullet"),
								array("id"=>2,"name"=>"Monthly Interest"),
								array("id"=>3,"name"=>"EMI")
							);
		$purpose_singlelineSql		=	"	SELECT	codelist_id,
													codelist_code,
													codelist_value,
													expression
											FROM	codelist_details
											WHERE	codelist_id = 16";
											
		$purpose_singleline_rs		= 	$this->dbFetchAll($purpose_singlelineSql);
		if ($purpose_singleline_rs) {
			foreach($purpose_singleline_rs as $pur_sinlineRow) {
				$pur_sinlineRowIndex	=	$pur_sinlineRow->codelist_value;
				$pur_sinlineRowvalue	=	$pur_sinlineRow->codelist_value;
				$this->purposeSingleLineInfo[$pur_sinlineRowIndex]	=	$pur_sinlineRowvalue;
			}
		}
		
		$this->bidTypeSelectOptions	=	$this->constructSelectOption($bidTypeList,
															'name', 'id',$this->bid_type, "--Please Select--");		
		$this->paymentTypeSelectOptions	=	$this->constructSelectOption($paymentTypeList,
															'name', 'id',$this->repayment_type, "--Please Select--");		
		$loanTenureCode =	19;
	
		$filterSql		=	"	SELECT	codelist_id,
										codelist_code,
										codelist_value,
										expression
								FROM	codelist_details
								WHERE	codelist_id in ($loanTenureCode)
								AND		expression !='all' order by codelist_code desc";
								
		$filter_rs		= 	$this->dbFetchAll($filterSql);

		if (!$filter_rs) {
			throw exception ("Code List Master / Detail information not correct");
			return;
		}
		
		foreach($filter_rs as $filter_row) {

			$codeId 	= 	$filter_row->codelist_id;
			$codeCode 	= 	$filter_row->codelist_code;
			$codeValue 	= 	$filter_row->codelist_value;
			$codeExpr 	= 	$filter_row->expression;
			
			switch ($codeId) {
			
				case 19:
					$this->loan_tenure_list[$codeCode] 	=	$codeValue;
					break;

			}
			
		}
		
	}
	
	public function getBorrowerLoanDocUrl($doc_id) {
		
		$loandocumenturl_sql		= 	"	SELECT 	loan_doc_url
											FROM 	loan_docs_submitted	
											WHERE	loan_doc_submitted_id	={$doc_id}";
		
		$loandocumenturl_rs			= 	$this->dbFetchOne($loandocumenturl_sql);
		$fileUploadObj				=	new FileUpload();
		$loan_doc_full_path			=	$fileUploadObj->getFile($loandocumenturl_rs);
		return $loan_doc_full_path;
	}
	
	
	public function getLoanApplyComments($loan_id) {
		
		$comments_sql	= 	"	SELECT 	loan_approval_comments_id,
										loan_id,
										comment_datetime,
										comemnt_text,
										comments_status
								FROM 	loan_approval_comments
								WHERE	loan_id	=	{$loan_id}";
				
		$comments_rs	=	$this->dbFetchAll($comments_sql);	
		if ($comments_rs) {
			foreach ($comments_rs as $commentRow) {
				$newrow = count($this->commentsInfo);
				$newrow ++;
				foreach ($commentRow as $colname => $colvalue) {
					$this->commentsInfo[$newrow][$colname] = $colvalue;
				}
			}
		}else{
			$comments_rs	=	 array();	
		}
		return	$comments_rs;
	}
	
	public function getLoanApplyOpenCommentsCount($loan_id) {
		
		$comments_sql			= 	"	SELECT 	count(loan_approval_comments_id) cnt
										FROM 	loan_approval_comments
										WHERE	loan_id	=	{$loan_id}
										AND		comments_status	=".PROFILE_COMMENT_OPEN;
				
		$this->comments_count	=	$this->dbFetchOne($comments_sql);	
	}
	
	public function saveLoanApplyComments($commentRows,$loan_id) {
		
		$numRows = count($commentRows['comment_status_hidden']);
		$rowIndex = 0;
		
		if($numRows	>	0){
			if($this->getUserType()	==	USER_TYPE_ADMIN){
				$whereArry		=	array("loan_id" => $loan_id);
				$this->dbDelete("loan_approval_comments",$whereArry);
			}
			for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
				
				$comment_status				= $commentRows['comment_status_hidden'][$rowIndex];
				$comment_id					= $commentRows['comment_id_hidden'][$rowIndex];
				
				if($this->getUserType()	==	USER_TYPE_ADMIN) {	
					
					$comments					= $commentRows['comments'][$rowIndex];
					// Construct the data array
					$dataArray = array(	
									
									'loan_id'					=> $loan_id,
									'comemnt_text'				=> $comments,
									'comments_status'			=> $comment_status,
									'comment_datetime' 			=> $this->getDbDateFormat(date("d/m/Y")));
										
					// Insert the rows (for all types of transaction)
					$result =  $this->dbInsert('loan_approval_comments', $dataArray, true);
					if ($result < 0) {
						return -1;
					}
				}else{
					
					$dataArray = array(
										'comments_status'			=> $comment_status,
										'comment_datetime' 			=> $this->getDbDateFormat(date("d/m/Y"))
									);	
					$whereArry	=	array("loan_approval_comments_id" =>"{$comment_id}");
					$this->dbUpdate('loan_approval_comments', $dataArray, $whereArry);
				}
			}
		}
		return 1;
	}
	
	
	public function updateLoanApplyStatus($dataArray,$loanId,$borrowerId,$status=null) {
		
		$whereArry	=	array("loan_id" =>"{$loanId}");
		$this->dbUpdate('loans', $dataArray, $whereArry);
		$borrUserInfo	=	$this->getBorrowerIdByUserInfo($borrowerId);
		
		if($status	==	"approve") {
			$mailArray	=	array(	"email"=>"sathya@syllogic.in",
									"subject"=>"Money Match - Borrower Loan Approval",
									"template"=>"emails.borrLoanApporvalTemplate",
									"body_content"=>"Congratulations your loan sucessfully verified",
									"username"=>$borrUserInfo->username,
									"useremail"=>$borrUserInfo->email
								);
			$this->sendMail($mailArray);
		}
		if($status	==	"return_borrower") {
			$mailArray	=	array(	"email"=>"sathya@syllogic.in",
									"subject"=>"Money Match - Borrower Correction Required",
									"template"=>"emails.borrLoanApporvalTemplate",
									"body_content"=>"Correction required for your apllied loan ",
									"username"=>$borrUserInfo->username,
									"useremail"=>$borrUserInfo->email
								);
			$this->sendMail($mailArray);
		}
		return $loanId;
	}
	
}
