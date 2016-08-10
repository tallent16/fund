<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
use Log;
use Auth;
class InvestorProfileModel extends TranWrapper {
	
	public 	$investor_id	  				=  	"";
	public 	$user_id	  					=  	"";
	public 	$firstname	  					=  	"";
	public 	$lastname	  					=  	"";
	public 	$displayname  					=  	"";
	public 	$email  						=  	"";
	public 	$mobile	  						=  	"";
	//public  $nationality					=	"Singaporean";
	public	$acc_creation_date				;
	public	$gender							=	"";
	public	$identity_card_image_front		=	"";
	public	$identity_card_image_back		=	"";
	public	$address_proof_image			=	"";
	
	public	$estimated_yearly_income		=	"";	
	public 	$date_of_birth  				=  	"";
	public 	$nric_number			  		=  	"";
	public 	$statusText			  			=  	"New profile";
	public 	$viewStatus			  			=  	"";
	public 	$investor_bankid  				=  	"";
	public 	$bank_name  					=  	"";
	public 	$bank_account_number  			=  	"";
	public 	$bank_statement_url  			=  	"";
	public 	$branch_code  					=  	"";
	public 	$bank_code						=  	"";
	public 	$commentsInfo 					= 	array();
	public 	$comments_count					= 	0;
	public 	$status							= 	"";
	public  $allTransList					= array();
	public  $nationality_code				= "SG";
	public 	$commentsReplyInfo 				= 	array();
	public 	$successTxt 					= 	"";
	
	public function processDropDowns() {				
				
		$filterSql		=	"SELECT * FROM nationality";
								
		$filter_rs		= 	$this->dbFetchAll($filterSql);	
		
		if (!$filter_rs) {
			throw exception ("not correct");
			return;
		}
		
		foreach($filter_rs as $filter_row) {
			$countryname 	= 	$filter_row->country_name;
			$countrycode 	= 	$filter_row->country_code;
			$this->allTransList[$countrycode ] 	=	$countryname;
		}
		
		/*$defaultfilterSql  		= "SELECT 
									country_name 
									FROM nationality 
									WHERE country_code='SG' ";
						
		$this->filter_code		= 	$this->dbFetchOne($defaultfilterSql);*/
	
	}		
	
	public function getInvestorDetails($inv_id=null) {
		
		
		$this->getInvestorProfile($inv_id);
		$this->getInvestorProfileComments($inv_id);
		$this->getBorrowerProfileCommentsReply($inv_id);
		$this->getOpenCommentsCount($inv_id);
		$this->processDropDowns();
	}
		
	public function getInvestorProfile($inv_id) {
		
		if($inv_id	==	null){
			$current_user_id	=	$this->getCurrentuserID();
		}else{
			$current_user_id	=	$this->getUseridByInvestorID($inv_id);
		}
		$this->status			= INVESTOR_STATUS_NEW_PROFILE;
		$investorprofile_sql	= 	"	SELECT 	investors.investor_id ,
											ifnull(DATE_FORMAT(investors.date_of_birth,'%d/%m/%Y'),'') date_of_birth,
											investors.nric_number,
											investors.nationality,
											investors.gender,											
											ROUND(investors.estimated_yearly_income,2) estimated_yearly_income,																						
											ifnull(DATE_FORMAT(investors.acc_creation_date,'%d/%m/%Y'),'') acc_creation_date,
											investors.identity_card_image_front,											
											investors.identity_card_image_back,											
											investors.address_proof_image,											
											investors.status,
											case investors.status 
													when 1 then 'New profile' 
													when 2 then 'Submitted for verification'
													when 3 then 'Corrections required'
													when 4 then 'Verified'
											end as statusText,
											case investors.status 
													when 1 then '' 
													when 2 then 'disabled' 
													when 3 then '' 
													when 4 then 'disabled'
											end as viewStatus,
											investor_banks.investor_bankid,
											investor_banks.bank_name,
											investor_banks.branch_code,
											investor_banks.bank_account_number,
											investor_banks.verified_status,
											investor_banks.bank_code,
											investor_banks.bank_statement_url
									FROM 	investors
											LEFT JOIN investor_banks
											ON	(investors.investor_id	=	investor_banks.investor_id
											AND	investor_banks.active_status = 1),
											users
									WHERE	investors.user_id	=	{$current_user_id}
									AND		investors.user_id	=	users.user_id";
		
		$investorprofile_rs		= 	$this->dbFetchAll($investorprofile_sql);
	
		if ($investorprofile_rs) {
		
			$vars = get_object_vars ( $investorprofile_rs[0] );
			foreach($vars as $key=>$value) {
				$this->{$key} = $value;
			}
		}
		$userprofile_sql	= 	"	SELECT 	users.firstname,
											users.lastname,
											users.username displayname,
											users.email,
											users.mobile,
											users.user_id
									FROM 	users
									WHERE	users.user_id	=	{$current_user_id}";
		
		$userprofile_rs		= 	$this->dbFetchAll($userprofile_sql);
	
		if ($userprofile_rs) {
		
			$vars = get_object_vars ( $userprofile_rs[0] );
			foreach($vars as $key=>$value) {
				$this->{$key} = $value;
			}
		}
	}
	
	public function processProfile($postArray) {
		//~ echo "<pre>",print_r($postArray),"</pre>";
		//~ die;
		$transType 		=	$postArray['trantype'];
		$investorId		=	$this->updateInvestorInfo($postArray,$transType);
		$moduleName		=	"Investor Profile";

		if($transType	==	"edit") {
			$investorId  	= 	$postArray['investor_id'];
			$whereArry		=	array("investor_id" => $investorId);

			if($postArray['isSaveButton']	!=	"yes") {
				$actionSumm =	"Investor Profile for approval";
				$actionDet  =	"Investor Profile Submit for Approval";
			} else {
				// Audit Trail related Settings
				$actionSumm =	"Update";
				$actionDet  =	"Update Investor Profile";
			}
		} else {
			$actionSumm =	"Add";
			$actionDet	=	"Add New Investor Profile";
		}

		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"username", $postArray['displayname']);
		
		$this->updateInvestorBankInfo($postArray,$investorId,$transType);
		
		if (isset($postArray['hidden_investor_status']) 
				&& $postArray['hidden_investor_status']	==	"corrections_required" ) {
			if (isset($postArray['comment_row'])) {
				$this->saveComments($postArray['comment_row'],$investorId);
			}
		}
		if($postArray['isSaveButton']	!=	"yes") {
			$this->successTxt	=	$this->getSystemMessageBySlug("investor_profile_submit");
		} else {
				$this->successTxt	=	$this->getSystemMessageBySlug("investor_profile_update_by_investor");
		}
		return $investorId;
	}
	
	public function updateInvestorInfo($postArray,$transType) {		
		if ($transType == "edit") {
			$investorId	= $postArray['investor_id'];
			$status		=	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL;
		} else {
			$investorId = 0;
			$status		=	INVESTOR_STATUS_NEW_PROFILE;
			if($postArray['isSaveButton']	!=	"yes") {
				$status		=	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL;
			}
		}
	
		$firstname 						=	$postArray['firstname'];
		$lastname						= 	$postArray['lastname'];
		$displayname					= 	$postArray['displayname'];
		$email							= 	$postArray['email'];
		$mobile							= 	$postArray['mobile'];		
		$nationality					= 	$postArray['nationality'];		
			
		$gender							= 	$postArray['gender'];		
		if(isset($postArray['gender']))
			$gender 			= 	$postArray['gender'];
		else
			$gender 			= 	"";
		$estimated_yearly_income		= 	$this->makeFloat($postArray['estimated_yearly_income']);
		$acc_creation_date				=	$this->getDbDateFormat(date("d/m/Y"));
		if(Auth::user()->usertype	==	USER_TYPE_INVESTOR) {
			$current_user_id				=	$this->getCurrentuserID();
		}
		$date_of_birth					=	$postArray['date_of_birth'];
		if($date_of_birth	==	"") 
			$date_of_birth				= 	NULL;
		else
			$date_of_birth				= 	$this->getDbDateFormat($date_of_birth);
		$nric_number 					= 	$postArray['nric_number'];
		
		
		
		$dataUserArray 	= 	array(	'firstname' 					=> ($firstname!="")?$firstname:null,
									'lastname'						=> ($lastname!="")?$lastname:null,
									'username'						=> ($displayname!="")?$displayname:null,
									'email'							=> $email,
									'mobile' 						=> ($mobile!="")?$mobile:null);
									
									
		$dataArray 		= 	array(	'date_of_birth' 				=> $date_of_birth,
									'nric_number'					=> ($nric_number!="")?$nric_number:null,
									'nationality' 					=> ($nationality!="")?$nationality:null,
									'gender' 						=> ($gender!="")?$gender:null,
									'estimated_yearly_income' 		=> ($estimated_yearly_income!="")?$estimated_yearly_income:null);
		if(Auth::user()->usertype	==	USER_TYPE_INVESTOR) {
			if ($transType != "edit") {
				$dataArray['user_id']	=	$current_user_id;
			}
		}							
				
		if ($transType == "edit") {
			if($postArray['isSaveButton']	!=	"yes") {
				$dataArray['status'] = $status;
			}
		}else{
			$dataArray['status'] = $status;
		}
		
		if ($transType != "edit") {
			
			//Insert the investor table
			$investorId =  $this->dbInsert('investors', $dataArray, true);			
			$this->uploadInvestorProfileAttachments($postArray,$investorId);
			if ($investorId < 0) {
				return -1;
			}	
			//updating register time	
			$register_datetime	= 	date("Y-m-d H:i:s");					
			$dataArray			=	array("register_datetime"=>$register_datetime);	
			$whereArry			=	array("investor_id" =>"{$investorId}");			
			$this->dbUpdate('investors', $dataArray, $whereArry);
						
			
			if(Auth::user()->usertype	==	USER_TYPE_ADMIN) {
				$user_info			=	$this->getUseridByInvestorID($investorId);
				$current_user_id	=	$user_info;
			}
			//Update the users table
			$whereUserArry		=	array("user_id" =>"{$current_user_id}");
			$this->dbUpdate('users', $dataUserArray, $whereUserArry);
			return $investorId;		
			
		}else{
			
			//Update the investor table
			$whereArry	=	array("investor_id" =>"{$investorId}");
			$this->dbUpdate('investors', $dataArray, $whereArry);
			
			$this->uploadInvestorProfileAttachments($postArray,$investorId);
			
			if(Auth::user()->usertype	==	USER_TYPE_ADMIN) {
				$user_info			=	$this->getUseridByInvestorID($investorId);
				$current_user_id	=	$user_info;
			}
			//Update the users table
			$whereUserArry		=	array("user_id" =>"{$current_user_id}");
			$this->dbUpdate('users', $dataUserArray, $whereUserArry);
			return $investorId;			
		}
		
	}
	public	function uploadInvestorProfileAttachments($postArray,$investorId) {
		
		/*identity_card_image_front*/
		
		$destinationPath 				= 	Config::get('moneymatch_settings.upload_inv');
		$updateDataArry					=	array();
		$fileUploadObj					=	new FileUpload();
		$updateAttachment				=	false;
		
		if(isset($postArray['identity_card_image_front'])){
			$file		=	$postArray['identity_card_image_front'];
			$imagePath	=	$destinationPath."/".$investorId;
			$fileUploadObj->createIfNotExists($imagePath);
			
			$prefix						=	"idcard_front_";
			$identity_card_image_front	=	$fileUploadObj->storeFile($imagePath ,$file,$prefix);
			$updateDataArry['identity_card_image_front']	=	$identity_card_image_front;
			$updateAttachment			=	true;
		}
		
		/*identity_card_image_back*/
	
		if(isset($postArray['identity_card_image_back'])){
			$file		=	$postArray['identity_card_image_back'];
			$imagePath	=	$destinationPath."/".$investorId;
			$fileUploadObj->createIfNotExists($imagePath);
			
			$prefix						=	"idcard_back_";
			$identity_card_image_back	=	$fileUploadObj->storeFile($imagePath ,$file,$prefix);
			$updateDataArry['identity_card_image_back']	=	$identity_card_image_back;
			$updateAttachment			=	true;
		}
		
		/*address_proof_image*/	
		
		if(isset($postArray['address_proof_image'])){
			$file		=	$postArray['address_proof_image'];
			$imagePath	=	$destinationPath."/".$investorId;
			$fileUploadObj->createIfNotExists($imagePath);
			
			$prefix					=	"addr_proof_";
			$address_proof_image	=	$fileUploadObj->storeFile($imagePath ,$file,$prefix);
			$updateDataArry	['address_proof_image']	=	$address_proof_image;
			$updateAttachment		=	true;
		}
		
		if($updateAttachment) {			
			$whereArray	=	["investor_id" 	=> $investorId];
			$this->dbUpdate("investors", $updateDataArry, $whereArray);
		}
	}
	
	public function updateInvestorBankInfo($postArray,$investorId,$transType) {		
		
		$destinationPath 			= 	Config::get('moneymatch_settings.upload_inv');
		$fileUploadObj				=	new FileUpload();
		
		$investorBankId	= $postArray['investor_bankid'];
		
		$dataArray = array(	'investor_id' 			=> $investorId,
							'bank_code' 			=> $postArray['bank_code'],
							'bank_name' 			=> $postArray['bank_name'],
							'branch_code' 			=> $postArray['branch_code'],
							'bank_account_number'	=> ($postArray['bank_account_number']!="")
																				?$postArray['bank_account_number']:NULL,
							'active_status' 		=> 1);
							
		if ($investorBankId == "") {
			$investorBankId =  $this->dbInsert('investor_banks', $dataArray, true);
			if ($investorBankId < 0) {
				return -1;
			}
		}else{
			
			$whereArry	=	array("investor_bankid" =>"{$investorBankId}");
			$this->dbUpdate('investor_banks', $dataArray, $whereArry);
		}
		$updateAttachment		=	false;
		if(isset($postArray['bank_statement'])){
			if(isset($postArray['bank_statement_hidden'])){
				$filePath		=	$postArray['bank_statement_hidden'];
				$fileUploadObj->deleteFile($filePath);
				
			}
			unset($prefix);
			unset($filename);
			unset($newfilename);
			unset($file);
			
			$filePath				=	$destinationPath."/".$investorId;
			$fileUploadObj->createIfNotExists($filePath);
			
			$file					=	$postArray['bank_statement'];
			
			$prefix					=	"bank_stat_{$investorBankId}_";
			$bank_statement_path	=	$fileUploadObj->storeFile($filePath ,$file,$prefix);
			$updateDataArry			=	array(	"bank_statement_url"=>$bank_statement_path);
			$updateAttachment		=	true;
		}
		if($updateAttachment) {
			$whereArray	=	["investor_id" 		=> $investorId,
							 "investor_bankid"	=> $investorBankId];
			$this->dbUpdate("investor_banks", $updateDataArry, $whereArray);
		}
		return $investorBankId;
	
	}
	
	public function CheckFieldExists($postArray) {
		
		if($postArray['field_name']	==	"username") {
			$userName	=	$postArray['field_value'];
			$id			=	$postArray['user_id'];
			return	$this->CheckExistingUserName($userName,$id);
			
		}else{
			$userEmail	=	$postArray['field_value'];
			$id			=	$postArray['user_id'];
			return	$this->CheckExistingUserEmail($userEmail,$id);
		}
		return $investorBankId;
	}
	
	
	public function getInvestorProfileComments($inv_id) {
		
		
		if($inv_id	==	null){
			$current_user_id	=	$this->getCurrentuserID();
		}else{
			$current_user_id	=	$this->getUseridByInvestorID($inv_id);
		}
		
		$comments_sql	= 	"	SELECT 	profile_comments_id,
										user_type,
										user_id,
										input_tab,
										comments,
										comment_status
								FROM 	profile_comments
								WHERE	user_id	=	{$current_user_id}
								AND		inresponse_to IS NULL";
				
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
	
	public function getBorrowerProfileCommentsReply($inv_id) {
		
		
		if($inv_id	==	null){
			$current_user_id	=	$this->getCurrentuserID();
		}else{
			$current_user_id	=	$this->getUseridByInvestorID($inv_id);
		}
		
		$comments_sql	= 	"	SELECT 	profile_comments_id,
										comments,
										inresponse_to,
										comment_status
								FROM 	profile_comments
								WHERE	user_id	=	{$current_user_id}
								AND		inresponse_to	IS NOT NULL";
		
		$comments_rs	=	$this->dbFetchAll($comments_sql);	
		
		if ($comments_rs) {
			foreach ($comments_rs as $commentRow) {
				$profile_comments_id	=	$commentRow->profile_comments_id;
				$inresponse_to			=	$commentRow->inresponse_to;
				$this->commentsReplyInfo['text'][$inresponse_to]	=	$commentRow->comments;
				$this->commentsReplyInfo['id'][$inresponse_to]		=	$commentRow->profile_comments_id;
			}
		
		}else{
			$comments_rs	=	 array();	
		}
		return	$comments_rs;
	}
	
	public function getOpenCommentsCount($inv_id) {
		
		
		if($inv_id	==	null){
			$current_user_id	=	$this->getCurrentuserID();
		}else{
			$current_user_id	=	$this->getUseridByInvestorID($inv_id);
		}
		
		$comments_sql			= 	"	SELECT 	count(profile_comments_id) cnt
										FROM 	profile_comments
										WHERE	user_id	=	{$current_user_id}
										AND		comment_status	=".PROFILE_COMMENT_OPEN;
				
		$this->comments_count	=	$this->dbFetchOne($comments_sql);	
	}
	
	
	public function saveComments($commentRows,$investorId) {
		
		if($this->getUserType()	==	USER_TYPE_ADMIN) {	
			$this->saveCommentsByAdmin($commentRows,$investorId);
		}else{
			$this->saveCommentsByInvestor($commentRows,$investorId);
		}
		return 1;
	}
	public function saveCommentsByAdmin($commentRows,$investorId) {
		echo "admincomments";
		$numRows = count($commentRows['comment_status_hidden']);
		$rowIndex = 0;
		$userID		=	$this->getUseridByInvestorID($investorId);
		$userType	=	USER_TYPE_INVESTOR;
		if($numRows	>	0){
			
			for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
				
				$comment_status				= 	$commentRows['comment_status_hidden'][$rowIndex];
				$comment_id					= 	$commentRows['comment_id_hidden'][$rowIndex];
				$comment_reply_id			=	$commentRows['comments_reply_id'][$rowIndex];
				
				$comments					= 	$commentRows['comments'][$rowIndex];
				
				// Construct the data array
				$dataArray = array(	
								'user_type' 				=> $userType,
								'user_id'					=> $userID,
								'comments'					=> $comments,
								'comment_status'			=> $comment_status,
								'comment_datetime' 			=> $this->getDbDateFormat(date("d/m/Y")));
				if($comment_id	==	0) {
					// Insert the rows (for all types of transaction)
					$result =  $this->dbInsert('profile_comments', $dataArray, true);
					if ($result < 0) {
						return -1;
					}
					$commentIds[]	=	$result;
				}else{
					unset($dataArray);
					unset($whereArry);
					$whereArry	=	array("profile_comments_id" =>$comment_id);
					$dataArray = array(	
							'comments'					=> $comments,
							'comment_status'			=> $comment_status,
							'comment_datetime' 			=> $this->getDbDateFormat(date("d/m/Y")));
					$result =  $this->dbUpdate('profile_comments', $dataArray, $whereArry);
					$commentIds[]	=	$comment_id;
					if($comment_reply_id	!=0)
						$commentIds[]	=	$comment_reply_id;
				}
					
			}
			$whereArry	=	[	"user_id" 		=> 	$userID,
								"whereNotIn" 	=>	["column" => 'profile_comments_id',
											 "valArr" => $commentIds]];
			$this->dbDelete("profile_comments",$whereArry);
		}
	}
	
	public function saveCommentsByInvestor($commentRows,$investorId) {
		
		$numRows = count($commentRows['comment_status_hidden']);
		$rowIndex = 0;
		$userID		=	$this->getUseridByInvestorID($investorId);
		$userType	=	USER_TYPE_INVESTOR;
		if($numRows	>	0){
			
			for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
				
				$comment_status				= 	$commentRows['comment_status_hidden'][$rowIndex];
				$comment_id					= 	$commentRows['comment_id_hidden'][$rowIndex];
				$comment_reply_id			=	$commentRows['comments_reply_id'][$rowIndex];
				$dataArray = array(
										'comment_status'			=> $comment_status,
										'comment_datetime' 			=> $this->getDbDateFormat(date("d/m/Y"))
									);	
					$whereArry	=	array("profile_comments_id" =>"{$comment_id}");
					$this->dbUpdate('profile_comments', $dataArray, $whereArry);
					if($commentRows['comments_reply'][$rowIndex]	!=	""	) {
						if(	$comment_reply_id	==	0) {
							unset($dataArray);
							$dataArray = array(	
									'user_id'					=> $userID,
									'comments'					=> $commentRows['comments_reply'][$rowIndex],
									'inresponse_to'				=> $commentRows['comment_id_hidden'][$rowIndex],
									'comment_datetime' 			=> $this->getDbDateFormat(date("d/m/Y")));
							$result =  $this->dbInsert('profile_comments', $dataArray, true);
						}else{
							unset($dataArray);
							unset($whereArry);
							$whereArry	=	array("profile_comments_id" =>$comment_reply_id);
							$dataArray = array(	
									'user_id'					=> $userID,
									'comments'					=> $commentRows['comments_reply'][$rowIndex],
									'inresponse_to'				=> $commentRows['comment_id_hidden'][$rowIndex],
									'comment_datetime' 			=> $this->getDbDateFormat(date("d/m/Y")));
							$result =  $this->dbUpdate('profile_comments', $dataArray, $whereArry);
						}
					}
			}
		}
	}
	public function updateInvestorStatus($dataArray,$investorId,$status=null) {
		
		$whereArry			=	array("investor_id" =>"{$investorId}");
		
		$invUserInfo		=	$this->getInvestorIdByUserInfo($investorId);
		$invInfo			=	$this->getInvestorInfoById($investorId);
		$moneymatchSettings = 	$this->getMailSettingsDetail();
		$fields 			= 	array('[investor_firstname]', '[investor_lastname]','[application_name]');
		$replace_array 		= 	array();
		$replace_array 		= 	array( 	$invUserInfo->firstname,
										$invUserInfo->lastname, 
										$moneymatchSettings[0]->application_name);
											
		$moduleName			=	"Investor Profile";
		switch ($status) {
			case "approve":
				$actionSumm =	"Approval";
				$actionDet  =	"Investor Profile Approval";
				$slug_name	=	"investor_profile_approved";
				break;
				
			case "return_investor":
				$actionSumm =	"Comments by Admin";
				$actionDet  =	"Profile return back to Investor with comments";
				$slug_name	=	"investor_profile_return_to_investor";
				break;

			case "reject":
				$actionSumm =	"Profile Rejected";
				$actionDet  =	"Investor Profile Rejected";
				$slug_name	=	"investor_profile_reject";
				break;

			case "delete":
				$actionSumm =	"Profile Deleted";
				$actionDet  =	"Investor Profile Deleted";
				$slug_name	=	"investor_profile_inactive";
				break;
			
			default:
				$actionSumm =	"Submitted for Approval";
				$actionDet  =	"Profile submitted for approval";
				break;
		}
		
		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"username", $this->displayname);		

		$this->dbUpdate('investors', $dataArray, $whereArry);
		//updating approval time
		$approval_datatime	= 	date("Y-m-d H:i:s");					
		$dataArray			=	array("approval_datetime"=>$approval_datatime);	
		$this->dbUpdate('investors', $dataArray, $whereArry);
		
		$invdataArray			=	array("verified_status" =>1);
		$invwhereArry			=	array("investor_id" =>"{$investorId}");
		$this->dbUpdate('investor_banks', $invdataArray, $invwhereArry);
		
		$this->sendMailByModule($slug_name,$invUserInfo->email,$fields,$replace_array);
		return $investorId;
	}
	
	public function updateBulkInvestorStatus($postArray,$processType) {
		
		switch($processType){
			case	"approve":
					$dataArray = array(	'status' 	=>	INVESTOR_STATUS_APPROVED );
					$status	=	"approve";
					break;
			case	"delete":
					$dataArray = array(	'status' 	=>	INVESTOR_STATUS_DELETED );
					$status	=	"delete";
					break;
			case	"reject":
					$dataArray = array(	'status' 	=>	INVESTOR_STATUS_REJECTED);
					$status	=	"reject";
					break;
		}
		foreach($postArray['investor_ids'] as $invRow) {
			$this->updateInvestorStatus($dataArray,$invRow,$status);
		}
		return 1;
	}
	
	public function updateMobileNumber($inv_id,$postArray){
		
		$mobile = $postArray['mobile'];
		$dataArray = array('mobile' => $mobile);
		$userInfo	=	$this->getInvestorIdByUserInfo($inv_id);
		$whereArry = array('user_id'=>$userInfo->user_id);
		$this->dbUpdate('users', $dataArray, $whereArry);
		$this->successTxt	=	$this->getSystemMessageBySlug("investor_profile_mobile_update");
	}
	
}
