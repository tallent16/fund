<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
use Log;
use Auth;
class BorrowerApplyLoanModel extends TranWrapper {
	
	public $loan_id		  					=  	"";
	public $loan_title  					=  	"";
	public $loan_reference_number  			=  	"";
	public $borrower_id  					=  	"";
	public $purpose_singleline		  		=  	"";
	public $purpose		  					=  	"";
	public $token_type		  				=  	"";
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
	public $funding_duration  				=  	"";
	public $latitude  						=  	"";
	public $longitude  						=  	"";
	public $loan_image_url  				=  	"";
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
	public $reward_details					= 	array();
	public $item_details					= 	array();
	public $bidTypeSelectOptions			= 	"";
	public $paymentTypeSelectOptions		= 	"";
	public $completeLoanDetails				= 	0;
	public 	$gradeInfo 						= 	array();
	public 	$grade 							= 	"";
	public 	$loan_status 					= 	"";
	public 	$successTxt 					= 	"";
	public 	$loan_description 				= 	"";
	public 	$milstone_name1 				= 	"";
	public 	$milstone_date1 				= 	"";
	public 	$milstone1_id 					= 	0;
	
	public 	$milstone_name2 				= 	"";
	public 	$milstone_date2 				= 	"";
	public 	$milstone2_id 					= 	0;
	public 	$mileStoneArry					=	array();
	public 	$socialLinkArry					=	array();
	public 	$numberoftokens					=	1;
	public 	$costpertoken					=	"";
	
	public function getBorrowerLoanDetails($loan_id) {
		
		$this->getBorrowerLoanInfo($loan_id);
		$this->getBorrowerDocumentListInfo();
		$this->getBorrowerSubmittedDocumentInfo($loan_id);
		$this->getLoanApplyComments($loan_id);
		$this->getLoanApplyOpenCommentsCount($loan_id);
		$this->processDropDowns();
		$this->getBorrowerAllItemTokes($loan_id);
		$this->getBorrowerAllRewardTokes($loan_id);
		$this->getBorrowerAllMilestones($loan_id);
		$this->getBorrowerAllLinks($loan_id);
		
		
		//~ echo $this->milestone_name1."<br>";
		//~ echo $this->milestone_date1."<br>";
		//~ die;
	}
	
	public function getBorrowOrgName ($borrowerId) {
		$sql	=	" SELECT business_name from borrowers 
						where borrower_id = $borrowerId ";
		
		$borrowerName = $this->dbFetchOne($sql);
		
		return $borrowerName;
		
	}
	
	public function getBorrowerLoanInfo($loan_id) {
		
		
		$loanlist_sql			= "SELECT 	loans.loan_id,
											loans.loan_title,
											loans.loan_reference_number,
											loans.borrower_id,
											loans.purpose,	loans.kyc_varify,
											loans.purpose_singleline,												
											loans.token_type,ifnull(DATE_FORMAT(loans.crowd_start_date,'%d/%m/%Y'),'') crowd_start_date,ifnull(DATE_FORMAT(loans.pre_start_date,'%d/%m/%Y'),'') pre_start_date,
										loans.pre_duration,loans.crowd_duration,loans.contract_address,loans.wallet_address,loans.eth_baalance,loans.ristricted_countries as countries,												
											ifnull(DATE_FORMAT(loans.apply_date,'%d/%m/%Y'),'') apply_date,
											ROUND(loans.apply_amount,2) apply_amount ,
											ROUND(loans.numberoftokens,0) numberoftokens ,
											ROUND(loans.costpertoken,2) costpertoken ,
											loans.loan_currency_code,
											loans.loan_tenure,
											loans.target_interest,
											ifnull(DATE_FORMAT(loans.bid_open_date,'%d/%m/%Y'),'') bid_open_date,
											ifnull(DATE_FORMAT(loans.crowd_end_date,'%d/%m/%Y'),'') bid_close_date,
											loans.bid_type,
											case loans.bid_type 
												   when 1 then 'Open Bid' 
												   when 2 then 'Closed Bid'
												   when 3 then 'Fixed Interest'
											end as bidTypeText,
											loans.partial_sub_allowed,
											ROUND(loans.min_for_partial_sub,2) min_for_partial_sub,
											loans.funding_duration,
											loans.latitude,
											loans.longitude,
											loans.location_description,
											loans.loan_image_url,
											loans.loan_video_url,
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
												   when 3 then 'Approved for Backing'
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
											loans.loan_risk_grade grade,
											loans.risk_industry,
											loans.risk_strength,
											loans.risk_weakness,
											loans.loan_description,
											users.firstname,
											borrowers.contact_person_mobile ,
											users.email
									FROM 	loans,borrowers,users
									WHERE	loans.loan_id		=	{$loan_id} 
									AND 	loans.borrower_id 	= 	borrowers.borrower_id
                                    AND		borrowers.user_id 	= 	users.user_id ";
		
		$loanlist_rs		= 	$this->dbFetchAll($loanlist_sql);
		/* echo "<pre>",print_r($loanlist_rs),"</pre>";
		die;*/
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
		//echo "<pre>"; print_r($postArray); die;
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
			$actionSumm =	"For Approval";
			$actionDet  =	"Loan for Approval";
		} else {
			if ($transType != "add") {
				$actionSumm =	"Update";
				$actionDet  =	"Update Loan Details";
			} else {
				$actionSumm =	"Add";
				$actionDet	=	"Add new Loan";
			}
		}

		// $this->setAuditOn($moduleName, $actionSumm, $actionDet, "Borrower", $borrName);
										
		$loanId		=	 $this->updateBorrowerLoanInfo($postArray,$transType,$borrowerId);
		//echo "<pre>"; print_r($postArray); die;
		if(Auth::user()->usertype	==	USER_TYPE_BORROWER 
			||Auth::user()->usertype	==	USER_TYPE_ADMIN) {
			
			$this->updateProjectImage($loanId,$postArray);
			
			$this->updateMilestones($loanId,$postArray);

			$this->updateLinks($loanId,$postArray);
			
			$this->updateBorrowerRewardToken($postArray,$loanId);

			/*if($postArray['link_row']){
				foreach($postArray['link_row'] as $key=>$li){
					$li['loan_id']= $loan_id;
					DB::table('social_links')->insert($li);
				}
			}*/
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
		
			//echo "<pre>"; print_r($postArray); 
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
		if(@$postArray['kyc_varify']){

			$kyc_varify  = $postArray['kyc_varify'];
		}else{
          $kyc_varify  = '0';

		}
					
		$project_title 					=	$postArray['loan_title'];
		$project_ref_number 			=	$postArray['project_ref_num'];
		$purpose						= 	$postArray['project_purpose'];
		$purpose						= 	$postArray['project_purpose'];
		$purpose_singleline				= 	$postArray['purpose_singleline'];
		//$apply_date						= 	$postArray['fund_start_date'];
		
		//$fund_duration					= 	$postArray['fund_duration'];
		$latitude						= 	$postArray['latitude'];
		$longitude						= 	$postArray['longitude'];
		$location_description			= 	(!empty($postArray['location_description'])) ? $postArray['location_description'] : '';
		$loan_video_url					= 	$postArray['project_video'];
		$apply_amount		 			= 	$this->makeFloat($postArray['loan_amount']);
		$numberoftokens		 			= 	$this->makeFloat($postArray['no_of_tokens']);
		$costpertoken		 			= 	$this->makeFloat($postArray['cost_per_token']);
		$partial_sub_allowed 			= 	$postArray['partial_sub_allowed'];
		$token_type 					= 	1;
		$pre_duration 			    =	$postArray['pre_duration'];
		$pre_start_date 			        =	$postArray['pre_start_date'];
		$pre_start_date						= 	$this->getDbDateFormat($pre_start_date);
		$crowd_duration 			    =	$postArray['crowd_duration'];
		if(@$postArray['country']){
		$countries 			        =	implode(",",$postArray['country']);
	}else{
	$countries = '';	
	}
		$crowd_start_date		        =	$postArray['crowd_start_date'];
		if(@$postArray['contract_address']){
		$contract_address 			    =	$postArray['contract_address'];
	   }else{
           $contract_address  = "";

	   }

	   if(@$postArray['wallet_address']){
		$wallet_address =	$postArray['wallet_address'];
	   }else{
           $wallet_address  = "";

	   }
		
		if(@$postArray['eth_baalance']){
		$eth_baalance 	=	$postArray['eth_baalance'];
	   }else{
           $eth_baalance  = "";

	   }
			$crowd_start_date						= 	$this->getDbDateFormat($crowd_start_date);
		if(isset($postArray['min_for_partial_sub']))
			$min_for_partial_sub 			= 	$this->makeFloat($postArray['min_for_partial_sub']);
		else
			$min_for_partial_sub 			= 	"";
		//~ echo $location_description;
		//~ die;
		
		$dataArray = array(	'borrower_id'					=> $borrower_id,
							'loan_title'					=> ($project_title!="")?$project_title:null,
							'loan_description'				=> ($purpose!="")?$purpose:null,
							'loan_reference_number'			=> ($project_ref_number!="")?$project_ref_number:null,
							'purpose_singleline'			=> ($purpose_singleline!="")?$purpose_singleline:null,
							//'apply_date' 					=> $apply_date,
							'apply_amount' 					=> ($apply_amount!="")?$apply_amount:null,
							'numberoftokens' 				=> ($numberoftokens!="")?$numberoftokens:null,
							'costpertoken' 					=> ($costpertoken!="")?$costpertoken:null,
							//'funding_duration' 				=> ($fund_duration!="")?$fund_duration:null,
							'latitude' 						=> ($latitude!="")?$latitude:null,
							'longitude' 					=> ($longitude!="")?$longitude:null,
							'location_description' 			=> ($location_description!="")
																		?$location_description:null,
							'loan_video_url' 				=> ($loan_video_url!="")?$loan_video_url:null,

							'partial_sub_allowed' 			=> ($partial_sub_allowed!="")?$partial_sub_allowed:null,
							'min_for_partial_sub' 			=> ($min_for_partial_sub!="")?$min_for_partial_sub:null,
							'status' 						=> $status,
							'kyc_varify'                    =>$kyc_varify,
							'token_type' 					=>	$token_type,
							'pre_duration' 					=> ($pre_duration!="")?$pre_duration:null,
							'pre_start_date' 				=> ($pre_start_date!="")?$pre_start_date:null,
							'crowd_duration' 					=> ($crowd_duration!="")?$crowd_duration:null,
							'crowd_start_date' 				=> ($crowd_start_date!="")?$crowd_start_date:null,
							'contract_address' 				=> ($contract_address!="")?$contract_address:null,
							'wallet_address' 				=> ($wallet_address!="")?$wallet_address:null,
							'eth_baalance' 				    => ($eth_baalance!="")?$eth_baalance:null,
							'ristricted_countries'          => 	$countries 
							);			
									
	
		$dataArray['crowd_end_date']		=	$this->getDbDateFormat(
															date('d-m-Y',
																strtotime($crowd_start_date. "+".$crowd_duration." days")
																));
		$dataArray['pre_end_date']		=	$this->getDbDateFormat(
															date('d-m-Y',
																strtotime($pre_start_date. "+".$pre_duration." days")
																));

		if ($transType != "edit") {
		//print_r($dataArray); 
			$loanId =  $this->dbInsert('loans', $dataArray, true);

			//echo $loanId; die;
				//
			if ($loanId < 0) {
				return -1;
			}
			return $loanId;
		}else{

		//echo "<pre>"; print_r($dataArray); die;
			$whereArry	=	array("loan_id" =>"{$loanId}");
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
		
		//$this->setAuditOn($moduleName, $actionSumm, $actionDet, "Borrower", $borrName);
		
		$loan_approval_date	=	date("Y-m-d H:i:s");
		$dataArray 			= 	array('loan_approval_date'=> ($loan_approval_date!="")?$loan_approval_date:null);
		$this->dbUpdate('loans', $dataArray, $whereArry);
		
		

		
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
		
		$boid				=	$postArray['borrower_id'];
		
		$loan_risk_grade	=	($postArray['grade']	!=	"")?$postArray['grade']:NULL;
		
		$dataArray			=	array(	"loan_risk_grade"=>$loan_risk_grade
										);
		$whereArry			=	array("loan_id" =>"{$loanId}");
		
		$this->dbUpdate('loans', $dataArray, $whereArry);
				
		return $loanId;
	}
	
	
	public function updateBorrowerRewardToken($postArray,$loanId) {
	//echo "<pre>"; print_r($postArray); die;
		$this->dbDelete("token_item", array("loan_id"=>$loanId));
		
		if (isset($postArray["reward_row"])) {
			$rewardRows = $postArray["reward_row"];
			$numRows = count($rewardRows['title']);
		} else {
			$rewardRows = array();
			$numRows = 0;
		}
		//~ echo "<pre>",print_r($rewardRows),"</pre>";
		//~ echo $loanId;
		//~ die;
		//~ 
		$rowIndex = 0;
		$rewardIds  = array();
		
		for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
			
			$id							= $rewardRows['id'][$rowIndex];
			if ($id > 0) {
				$rewardIds[] = $id;
				$update = true;
			} else {
				$update = false;
			}
			
			$token_title				= 	$rewardRows['title'][$rowIndex];
			$token_cost					= 	$rewardRows['cost'][$rowIndex];
			$token_description			= 	$rewardRows['desc'][$rowIndex];
			$token_limit				= 	$rewardRows['limit'][$rowIndex];
			//$token_est_delv_date		= 	$rewardRows['estDelDate'][$rowIndex];
			$token_est_delv_date		= 	$postArray["rwd_tok_esdldate"];
			// Construct the data array
			$dataArray = array(	
							'loan_id' 					=> $loanId,
							'token_title'	 			=> $token_title,
							'token_cost'				=> $this->makeFloat($token_cost),
							'token_description' 		=> $token_description,
							'token_limit' 				=> $token_limit,
							'estimated_delivery_date' 	=> ($token_est_delv_date!="")?
															$this->getDbDateFormat($token_est_delv_date):NULL,
							);		

			if ($update) {
				$whereArray	=	["loan_id"=> $loanId,
								 "token_reward_id"=> $id];
				
				$this->dbUpdate("token_reward", $dataArray, $whereArray);
			
			} else {
				$id	 =  $this->dbInsert('token_reward', $dataArray, true);
				$rewardIds[]	=	$id;
			}
			
		}
		
		$where	=	["loan_id" => 	$loanId,
					 "whereNotIn" =>	["column" => 'token_reward_id',
										 "valArr" => $rewardIds]];
		$this->dbDelete("token_reward", $where);

		return 1;
	}
	
	public function updateBorrowerItemToken($postArray,$loanId) {
	
		$this->dbDelete("token_reward", array("loan_id"=>$loanId));
		
		if (isset($postArray["item_row"])) {
			$itemdRows = $postArray["item_row"];
			$numRows = count($itemdRows['title']);
		} else {
			$itemdRows = array();
			$numRows = 0;
		}
		//~ echo "<pre>",print_r($directorRows),"</pre>";
		//~ die;
		
		$rowIndex = 0;
		$itemIds  = array();
		
		for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
			
			$id							= $itemdRows['id'][$rowIndex];
			if ($id > 0) {
				$itemIds[] = $id;
				$update = true;
			} else {
				$update = false;
			}
			
			$token_title				= 	$itemdRows['title'][$rowIndex];
			$token_pledge_amount		= 	$itemdRows['plgamt'][$rowIndex];
			$token_description			= 	$itemdRows['desc'][$rowIndex];
			$token_est_delv_date		= 	$itemdRows['estDelDate'][$rowIndex];
			$token_limit				= 	$itemdRows['limit'][$rowIndex];
			
			// Construct the data array
			$dataArray = array(	
							'loan_id' 					=> $loanId,
							'token_title'	 			=> $token_title,
							'token_pledge_amount'		=> $this->makeFloat($token_pledge_amount),
							'token_description' 		=> $token_description,
							'token_est_delv_date' 		=> $this->getDbDateFormat($token_est_delv_date),
							'token_limit' 				=> $token_limit);		

			if ($update) {
				$whereArray	=	["loan_id" 	=> $loanId,
								 "token_item_id"			=> $id];
				$this->dbUpdate("token_item", $dataArray, $whereArray);
			} else {
				$id	 =  $this->dbInsert('token_item', $dataArray, true);
				$itemIds[]	=	$id;
			}
			
		}
		
		$where	=	["loan_id" => 	$loanId,
					 "whereNotIn" =>	["column" => 'token_item_id',
										 "valArr" => $itemIds]];
		$this->dbDelete("token_item", $where);

		return 1;
	}
	
	public function getBorrowerAllRewardTokes($loanId,$sortBy='') {
		
		$orderBy		=	"";
		if($sortBy!="") {
			$orderBy		=	"	ORDER BY token_cost";
		}
		$loanreward_sql		= 	"	SELECT 	token_reward_id id,
												token_title,
												token_cost,
												token_description,
												token_limit,
												estimated_delivery_date,
												loans.numberoftokens,
												(loans.numberoftokens * token_cost) claimamount
										FROM 	token_reward,loans
										WHERE	token_reward.loan_id = {$loanId}
										AND		token_reward.loan_id = loans.loan_id
										{$orderBy}";
		
	
		$loanreward_rs		= 	$this->dbFetchAll($loanreward_sql);
		
		if ($loanreward_rs) {
			foreach ($loanreward_rs as $rwdRow) {
				$newrow = count($this->reward_details);
				$newrow ++;
				foreach ($rwdRow as $colname => $colvalue) {
					$this->reward_details[$newrow][$colname] = $colvalue;
				}
			}
		}
		return $loanreward_rs;
	}
	
	public function getBorrowerAllItemTokes($loanId) {
		
		$loanitem_sql		= 	"	SELECT 		token_item_id id,
												token_title,
												token_pledge_amount,
												token_description,
												token_est_delv_date,
												token_limit
										FROM 	token_item
										WHERE	loan_id = {$loanId}";
		
		
		$loanitem_rs		= 	$this->dbFetchAll($loanitem_sql);
			
		if ($loanitem_rs) {
			foreach ($loanitem_rs as $itemRow) {
				$newrow = count($this->item_details);
				$newrow ++;
				foreach ($itemRow as $colname => $colvalue) {
					$this->item_details[$newrow][$colname] = $colvalue;
				}
			}
		}
		return $loanitem_rs;
	}
	
	public function updateProjectImage($loanId,$postArray){
		
		$fileUploadObj			=	new FileUpload();
		$updateAttachment		=	false;
		$destinationPath 		= 	Config::get('moneymatch_settings.upload_bor');
		$updateDataArry			=	array();
		
		if(!isset($postArray['project_image'])){
			return;
		}
	
		$project_image 			= 	$postArray['project_image'];
		$project_image_hidden 	= 	$postArray['project_image_hidden'];
		$dataArray 				= 	array('loan_image_url' => $project_image);
		//echo $project_image_hidden;die;
		if(isset($project_image)){
			if(isset($project_image_hidden) && $project_image_hidden !=''){
				$filePath		=	$project_image_hidden;

				$fileUploadObj->deleteFile($filePath);
			}
			unset($prefix);
			unset($filename);
			unset($newfilename);
			unset($file);
			
			$file			=	$project_image;
			$filePath		=	$destinationPath;
			$prefix			=	"PROIMG_";
			$fileUploadObj->createIfNotExists($filePath);
			//~ echo $filePath; die;
			$loan_image_url		=	$fileUploadObj->storeFile($filePath ,$file,$prefix);
			$updateDataArry["loan_image_url"]			=	$loan_image_url;
			$updateAttachment							=	true;
		}
		
		if($updateAttachment) {
			$whereArray	=	["loan_id" 	=> $loanId];
			$this->dbUpdate("loans", $updateDataArry, $whereArray);
		}
		$this->successTxt	= "Project Image  Updated Successfully";
		
	}
	
	public function updateMilestones($loanId,$postArray){
			
		if (isset($postArray["milstone_row"])) {
			$milestoneRows = $postArray["milstone_row"];
			$numRows = count($milestoneRows['id']);
		} else {
			$rewardRows = array();
			$numRows = 0;
		}
		
		$rowIndex = 0;
		$milestoneIds  = array();
		
		for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
			
			$id							= $milestoneRows['id'][$rowIndex];
			if ($id > 0) {
				$milestoneIds[] = $id;
				$update = true;
			} else {
				$update = false;
			}
			
			$milestone_name				= 	$milestoneRows['name'][$rowIndex];
			$milestone_date				= 	$milestoneRows['date'][$rowIndex];
			$milestone_disbursed		= 	$milestoneRows['disbursed'][$rowIndex];
			if(!empty($milestone_name) && !empty($milestone_date) ) {
				
				
				// Construct the data array
				$dataArray = array(	
								'loan_id' 					=> $loanId,
								'milestone_name'	 		=> $milestone_name,
								'milestone_date'	 		=> (!empty($milestone_date))?
																	$this->getDbDateFormat($milestone_date):NULL,
								'milestone_disbursed'	 	=> $milestone_disbursed
								);		

				if ($update) {
					$whereArray	=	["loan_id"=> $loanId,
									 "loan_milestone_id"=> $id];
					
					$this->dbUpdate("loan_milestones", $dataArray, $whereArray);
				
				} else {
					$id	 =  $this->dbInsert('loan_milestones', $dataArray, true);
					$milestoneIds[]	=	$id;
				}
			}	
		}
		
		$whereArray	=	["loan_id" 	=> $loanId,
						 "whereNotIn" =>	["column" => 'loan_milestone_id',
										 "valArr" => $milestoneIds]];
		$this->dbDelete("loan_milestones", $whereArray);
		
	}

	public function updateLinks($loanId,$postArray){
			
		if (isset($postArray["link_row"])) {
			$milestoneRows = $postArray["link_row"];
			$numRows = count($milestoneRows['id']);
		} else {
			$rewardRows = array();
			$numRows = 0;
		}
		
		$rowIndex = 0;
		$milestoneIds  = array();
		
		for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
			
			$id							= $milestoneRows['id'][$rowIndex];
			if ($id > 0) {
				$milestoneIds[] = $id;
				$update = true;
			} else {
				$update = false;
			}
			
			$milestone_name				= 	$milestoneRows['name'][$rowIndex];
			$milestone_link				= 	$milestoneRows['link'][$rowIndex];
			if(!empty($milestone_name) && !empty($milestone_link) ) {
				
				
				// Construct the data array
				$dataArray = array(	
								'loan_id' 					=> $loanId,
								'name'	 		=> $milestone_name,
								'link'	 		=> $milestone_link
								);		

				if ($update) {
					$whereArray	=	["loan_id"=> $loanId,
									 "id"=> $id];
					
					$this->dbUpdate("social_links", $dataArray, $whereArray);
				
				} else {
					$id	 =  $this->dbInsert('social_links', $dataArray, true);
					$milestoneIds[]	=	$id;
				}
			}	
		}
		
		$whereArray	=	["loan_id" 	=> $loanId,
						 "whereNotIn" =>	["column" => 'id',
										 "valArr" => $milestoneIds]];
		$this->dbDelete("social_links", $whereArray);
		
	}
	
	public function getBorrowerAllMilestones($loanId) {
		
		$milestone_sql		= 	"	SELECT 		*
									FROM 	 loan_milestones
									WHERE	loan_id = {$loanId}";
		
		$milestone_rs		= 	$this->dbFetchAll($milestone_sql);
		
		if(!empty($milestone_rs)) {
			foreach($milestone_rs as $milestoneRow) {
				$id			=	$milestoneRow->loan_milestone_id;
				$name		=	$milestoneRow->milestone_name;
				$disbursed	=	$milestoneRow->milestone_disbursed;
				if($milestoneRow->milestone_date	!=	"0000-00-00" && $milestoneRow->milestone_date!="") {
					$date	=	date("d-m-Y",strtotime($milestoneRow->milestone_date));
				}
				else{
					$date	=	"";
				}
				$this->mileStoneArry[$id]	=	array(
													"milestone_name"=>$name,
													"milestone_date"=>$date,
													"milestone_disbursed"=>$disbursed
												);
			}
		}else{
			$this->defaultMilestones();
		}
		return $milestone_rs;
	}

	public function getBorrowerAllLinks($loanId) {
		
		$links_sql		= 	"	SELECT 		*
									FROM 	 social_links
									WHERE	loan_id = {$loanId}";
		
		$links_rs		= 	$this->dbFetchAll($links_sql);
		
		if(!empty($links_rs)) {
			foreach($links_rs as $linksRow) {
				$id			=	$linksRow->id;
				$name		=	$linksRow->name;
				$link		=	$linksRow->link;
				$this->socialLinkArry[$id]	=	array(
													"name"=>$name,
													"link"=>$link
												);
			}
		}else{
			$this->defaultSocialLink();
		}
		return $links_rs;
	}
	
	public function defaultMilestones() {
		
		
		$this->mileStoneArry[0]	=	array(
										"milestone_name"=>"",
										"milestone_date"=>"",
										"milestone_disbursed"=>""
										);
	}

	public function defaultSocialLink() {
		
		
		$this->socialLinkArry[0]	=	array(
										"name"=>"",
										"link"=>""
										);
	}
	
}
