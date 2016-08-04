<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
use Auth;
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
	public $completeLoanDetails				= 	0;
	public 	$gradeInfo 						= 	array();
	public 	$grade 							= 	"";
	public 	$loan_status 					= 	"";
	public 	$successTxt 					= 	"";
	
	public function getBorrowerLoanDetails($loan_id) {
		
		$this->getBorrowerLoanInfo($loan_id);
		$this->getBorrowerDocumentListInfo();
		$this->getBorrowerSubmittedDocumentInfo($loan_id);
		$this->getLoanApplyComments($loan_id);
		$this->getLoanApplyOpenCommentsCount($loan_id);
		$this->processDropDowns();
	}
	
	public function getBorrowOrgName ($borrowerId) {
		$sql	=	" SELECT business_name from borrowers 
						where borrower_id = $borrowerId ";
		
		$borrowerName = $this->dbFetchOne($sql);
		
		return $borrowerName;
		
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
											ROUND(loans.min_for_partial_sub,2) min_for_partial_sub,
											loans.repayment_type,
											case loans.repayment_type 
												   when 1 then 'Bullet' 
												   when 2 then 'Monthly Interest'
												   when 3 then 'EMI'
											end as repaymentText,
											loans.status loan_status,
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
											loans.loan_video_url,
											loans.loan_risk_grade grade,
											loans.risk_industry,
											loans.risk_strength,
											loans.risk_weakness,
											users.firstname
									FROM 	loans,borrowers,users
									WHERE	loans.loan_id		=	{$loan_id} 
									AND 	loans.borrower_id 	= 	borrowers.borrower_id
                                    AND		borrowers.user_id 	= 	users.user_id ";
		
		$loanlist_rs		= 	$this->dbFetchAll($loanlist_sql);
		
		if ($loanlist_rs) {
		
			$vars = get_object_vars ( $loanlist_rs[0] );
			foreach($vars as $key=>$value) {
				$this->{$key} = $value;
			}
			$this->completeLoanDetails	=	1;
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
		if(Auth::user()->usertype	==	USER_TYPE_BORROWER) {
			$borrowerId = $this->getCurrentBorrowerID();
		}else{
			$borrowerId =	$postArray['borrower_id'];
		}
		$borrName	= $this->getBorrowOrgName($borrowerId);
		
		$moduleName		=	"Loans";

		// Audit Trail related Settings
		if(isset($postArray["isSaveButton"]) && $postArray["isSaveButton"]	!=	"yes") {
			$actionSumm =	"Approval";
			$actionDet  =	"Approval of Loans";
		} else {
			if ($transType != "add") {
				$actionSumm =	"Update";
				$actionDet  =	"Update Loan Details";
			} else {
				$actionSumm =	"Add";
				$actionDet	=	"Add new Loan";
			}
		}

		$this->setAuditOn($moduleName, $actionSumm, $actionDet, "Borrower", $borrName);
										
		$loanId		=	 $this->updateBorrowerLoanInfo($postArray,$transType,$borrowerId);
		if(Auth::user()->usertype	==	USER_TYPE_BORROWER) {
			$this->updateBorrowerLoanDocuments($postArray,$transType,$loanId);
		}
		
		if( (isset($postArray['hidden_loan_statusText']) &&
					$postArray['hidden_loan_statusText']	==	"corrections_required" )
				||(Auth::user()->usertype	==	USER_TYPE_ADMIN) ) {
			if (isset($postArray['comment_row'])) {
				$this->saveLoanApplyComments($postArray['comment_row'],$loanId);
			}
		}
		if(Auth::user()->usertype	==	USER_TYPE_ADMIN) {
			$this->updateLoanGradeRiskFactor($postArray,$loanId);
		}
		
		if($postArray['isSaveButton']	!=	"yes") {
			$this->successTxt	=	$this->getSystemMessageBySlug("borrower_loan_submit");
		} else {
				$this->successTxt	=	$this->getSystemMessageBySlug("borrower_loan_save_by_borrower");
		}
		
		return $loanId;
	}
	
	public function updateBorrowerLoanInfo($postArray,$transType,$borrower_id) {
		
		
		if ($transType == "edit") {
			$loanId		=	$postArray['loan_id'];
			$status		=	$postArray['hidden_loan_status'];
			if(Auth::user()->usertype	==	USER_TYPE_BORROWER) {
				if($postArray['isSaveButton']	!=	"yes") {
					$status		=	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL;	
				}
			}else if(Auth::user()->usertype	==	USER_TYPE_ADMIN){
				$status		=	$postArray['hidden_loan_status'];
			}
		} else {
			$loanId = 0;
			$status		=	BORROWER_STATUS_NEW;
			if($postArray['isSaveButton']	!=	"yes") {
				$status		=	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL;	
			}
		}		
		
					
		$loan_reference_number 			=	"L-";
		$format_date 					= 	date('Ym');
		$purpose						= 	$postArray['laon_purpose'];
		$purpose_singleline				= 	$postArray['purpose_singleline'];
		$apply_date						= 	$this->getDbDateFormat(date("d/m/Y"));
		$apply_amount		 			= 	$this->makeFloat($postArray['loan_amount']);
		$loan_tenure	 				= 	$postArray['loan_tenure'];
		$target_interest	 			= 	$postArray['target_interest'];
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
			$dataArray['bid_close_date']		=	$this->getDbDateFormat(date('d-m-Y', strtotime("+20 days")));
			
			$dataArray['penalty_interest']		=	$this->getSystemSettingFieldByKey("penalty_interest");
			$dataArray['penalty_fee_minimum']	=	$this->getSystemSettingFieldByKey("penalty_fee_minimum");
			$dataArray['penalty_fee_percent']	=	$this->getSystemSettingFieldByKey("penalty_fee_percent");
			
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
				$newfilename 	= 	 preg_replace('/\s+/', '_', $filename);
				$loan_doc_url	=	$destinationPath."/".$newfilename;
				
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
					$prefix			=	"doc_{$loan_doc_id}_";
					$loan_doc_url	=	$fileUploadObj->storeFile($destinationPath ,$file,$prefix);
					unset($dataArray);
					unset($whereArry);
					$dataArray 		= 	array(	'loan_doc_url'	=> $loan_doc_url);	
					$whereArry		=	array("loan_id" =>"{$loan_id}","loan_doc_id" =>"{$loan_doc_id}");
					$this->dbUpdate('loan_docs_submitted', $dataArray, $whereArry);
			// Insert or Update the loan documents list	
				
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
								AND		expression !='all' ";
								
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
		
		$grade_sql					=	"	SELECT	codelist_id,
													codelist_code,
													codelist_value,
													expression
											FROM	codelist_details
											WHERE	codelist_id = 20
											AND		codelist_code!=6";
											
		$grade_rs					= 	$this->dbFetchAll($grade_sql);
		if ($grade_rs) {
			foreach($grade_rs as $gradeRow) {
				$gradeRowIndex	=	$gradeRow->codelist_value;
				$gradeRowvalue	=	$gradeRow->codelist_value;
				$this->gradeInfo[$gradeRowIndex]	=	$gradeRowvalue;
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
		$idArray  = array();
		
		if($numRows	>	0){
			for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
				
				$comment_status		= $commentRows['comment_status_hidden'][$rowIndex];
				$comment_id			= $commentRows['comment_id_hidden'][$rowIndex];
				
				
				$comment_datetime	= $this->getDbDateFormat(date("d/m/Y"));
			
				$dataArray			= [	'loan_id'					=> $loan_id,
										'comments_status'			=> $comment_status,
										'comment_datetime' 			=> $comment_datetime];
				$whereArray			= ["loan_approval_comments_id"=> $comment_id];
				
				if(Auth::user()->usertype	==	USER_TYPE_ADMIN) {
					$comments			= $commentRows['comments'][$rowIndex];
					$dataArray['comemnt_text']	= $comments;
				}
				if ($comment_id > 0) {
					$this->dbUpdate('loan_approval_comments', $dataArray, $whereArray);
				}else{
					
					$comment_id = $this->dbInsert('loan_approval_comments', $dataArray, true);
				}
				$idArray[]			= $comment_id;
				
			}
		} else {
			// Just so that we are not sending an empty array to the where condition
			$idArray[] = -1;
		}
		unset($whereArray);
		
		$where	=	["loan_id" => 	$loan_id,
					 "whereNotIn" =>	["column" => 'loan_approval_comments_id',
										 "valArr" => $idArray]];
		$this->dbDelete("loan_approval_comments", $where);
		return 1;
	}
	
	
	public function updateLoanApplyStatus($dataArray,$loanId,$borrowerId,$status=null) {
			
		$whereArry			=	array("loan_id" =>"{$loanId}");
		$this->dbUpdate('loans', $dataArray, $whereArry);
		$borrName	= $this->getBorrowOrgName($borrowerId);
		
		$moduleName		=	"Loans";

		// Audit Trail related Settings
		switch ($status) {
			case "approve":
				$actionSumm =	"Approval";
				$actionDet  =	"Approval of Loans";
				$slug_name	=	"loan_approved";
				break;
				
			case "return_borrower":
				$actionSumm =	"Comments by Admin";
				$actionDet  =	"Loan returned to Borrower with Comments";
				$slug_name	=	"loan_return_to_borrower";
				break;
				
			case "cancel":
				$actionSumm =	"Cancelled";
				$actionDet  =	"Loan Cancelled";
				$slug_name	=	"loan_cancelled";
				break;
			
		}
		$this->getBorrowerLoanInfo($loanId);
		
		$loan_approval_date	=	date("Y-m-d H:i:s");
		$dataArray 			= 	array('loan_approval_date'=> ($loan_approval_date!="")?$loan_approval_date:null);
		$this->dbUpdate('loans', $dataArray, $whereArry);
		
		$this->setAuditOn($moduleName, $actionSumm, $actionDet, "Borrower", $borrName);

		
		$borrUserInfo		=	$this->getBorrowerIdByUserInfo($borrowerId);
		$borrInfo			=	$this->getBorrowerInfoById($borrowerId);
		$moneymatchSettings = 	$this->getMailSettingsDetail();
		
		$fields 			= array('[borrower_contact_person]','[application_name]',
								'[purpose-for-loan]','[loan_number]','[loan_apply_date]');
		$replace_array 		= array();
		$replace_array 		= array( 	$borrInfo->contact_person, 
											$moneymatchSettings[0]->application_name,
											$this->purpose_singleline,
											$this->loan_reference_number 
											,$this->apply_date);
											
		$this->sendMailByModule($slug_name,$borrUserInfo->email,$fields,$replace_array);
		return $loanId;
	}
	
	public function updateBiCloseDate($bidCloseDate,$loanId) {
		
		$dataArray			=	array("bid_close_date"=>$this->getDbDateFormat($bidCloseDate));
		$whereArry			=	array("loan_id" =>"{$loanId}");
		$this->dbUpdate('loans', $dataArray, $whereArry);
				
		return $loanId;
	}
	
	public function getBorrowerAllLoanDocUrl($doc_ids) {
		
		$docUrls					=	array();
		$loandocumenturl_sql		= 	"	SELECT 	loan_doc_url
											FROM 	loan_docs_submitted	
											WHERE	loan_doc_submitted_id	IN (".implode($doc_ids,',').")";
		
		$loandocumenturl_rs			= 	$this->dbFetchAll($loandocumenturl_sql);
		$fileUploadObj				=	new FileUpload();
		
		foreach($loandocumenturl_rs as $loanDocRow) {
			$docUrls[]				=	$fileUploadObj->getFile($loanDocRow->loan_doc_url);
		}
		return $docUrls;
	}
	
	
	public function updateLoanGradeRiskFactor($postArray,$loanId) {
		
		$loan_risk_grade	=	($postArray['grade']	!=	"")?$postArray['grade']:NULL;
		$risk_industry		=	($postArray['risk_industry']	!=	"")?$postArray['risk_industry']:NULL;
		$risk_strength		=	($postArray['risk_strength']	!=	"")?$postArray['risk_strength']:NULL;
		$risk_weakness		=	($postArray['risk_weakness']	!=	"")?$postArray['risk_weakness']:NULL;
		
		$dataArray			=	array(	"loan_risk_grade"=>$loan_risk_grade,
										"risk_industry"=>$risk_industry,	
										"risk_strength"=>$risk_strength,	
										"risk_weakness"=>$risk_weakness
										);
		$whereArry			=	array("loan_id" =>"{$loanId}");
		
		$this->dbUpdate('loans', $dataArray, $whereArry);
				
		return $loanId;
	}
	
}
