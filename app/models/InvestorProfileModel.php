<?php namespace App\models;

class InvestorProfileModel extends TranWrapper {
	
	public 	$investor_id	  				=  	"";
	public 	$user_id	  					=  	"";
	public 	$firstname	  					=  	"";
	public 	$lastname	  					=  	"";
	public 	$displayname  					=  	"";
	public 	$email  						=  	"";
	public 	$mobile	  						=  	"";
	public 	$date_of_birth  				=  	"";
	public 	$nric_number			  		=  	"";
	public 	$statusText			  			=  	"";
	public 	$viewStatus			  			=  	"";
	public 	$investor_bankid  				=  	"";
	public 	$bank_name  					=  	"";
	public 	$bank_account_number  			=  	"";
	public 	$branch_code  					=  	"";
	public 	$bank_code						=  	"";
	public 	$commentsInfo 					= 	array();
	public 	$comments_count					= 	0;
		
	public function getInvestorDetails($inv_id=null) {
		
		$this->getInvestorProfile($inv_id);
	}
		
	public function getInvestorProfile($inv_id) {
		
		if($inv_id	==	null){
			$current_user_id	=	$this->getCurrentuserID();
		}else{
			$current_user_id	=	$this->getUseridByInvestorID($inv_id);
		}
		
		$investorprofile_sql	= 	"	SELECT 	investors.investor_id ,
											ifnull(DATE_FORMAT(investors.date_of_birth,'%d/%m/%Y'),'') date_of_birth,
											investors.nric_number,
											case investors.status 
												   when 1 then 'New profile' 
												   when 4 then 'Verified'
											end as statusText,
											case investors.status 
												   when 1 then '' 
												   when 4 then 'disabled'
											end as viewStatus,
											investor_banks.investor_bankid,
											investor_banks.bank_name,
											investor_banks.branch_code,
											investor_banks.bank_account_number,
											investor_banks.verified_status,
											investor_banks.bank_code
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
		
		$transType 		=	$postArray['trantype'];
		$investorId		=	$this->updateInvestorInfo($postArray,$transType);
		
		$this->updateInvestorBankInfo($postArray,$investorId,$transType);
		
		if (isset($postArray['hidden_investor_status']) && $postArray['hidden_investor_status']	==	"corrections_required" ) {
			if (isset($postArray['comment_row'])) {
				$this->saveComments($postArray['comment_row'],$borrowerId);
			}
		}
		
		return $investorId;
	}
	
	public function updateInvestorInfo($postArray,$transType) {
		
		if ($transType == "edit") {
			$investorId	= $postArray['investor_id'];
		} else {
			$investorId = 0;
		}
	
		$firstname 						=	$postArray['firstname'];
		$lastname						= 	$postArray['lastname'];
		$displayname					= 	$postArray['displayname'];
		$email							= 	$postArray['email'];
		$mobile							= 	$postArray['mobile'];
		$current_user_id				=	$this->getCurrentuserID();
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
									'status' 						=> 1,
									'user_id' 						=> $current_user_id);
		
		
	//~ echo "<pre>",print_r($dataArray),"</pre>";
		//~ die;	
		if ($transType != "edit") {
			
			//Insert the investor table
			$investorId =  $this->dbInsert('investors', $dataArray, true);
			if ($investorId < 0) {
				return -1;
			}
			
			//Update the users table
			$whereUserArry		=	array("user_id" =>"{$current_user_id}");
			$this->dbUpdate('users', $dataUserArray, $whereUserArry);
			return $investorId;
		}else{
			
			//Update the investor table
			$whereArry	=	array("investor_id" =>"{$investorId}");
			$this->dbUpdate('investors', $dataArray, $whereArry);
			
			//Update the users table
			$whereUserArry		=	array("user_id" =>"{$current_user_id}");
			$this->dbUpdate('users', $dataUserArray, $whereUserArry);
			return $investorId;
		}
	}
	
	public function updateInvestorBankInfo($postArray,$investorId,$transType) {
		
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
			return $investorBankId;
		}else{
			
			$whereArry	=	array("investor_bankid" =>"{$investorBankId}");
			$this->dbUpdate('investor_banks', $dataArray, $whereArry);
			return $investorBankId;
		}
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
								WHERE	user_id	=	{$current_user_id}";
				
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
		
		$numRows = count($commentRows['comment_status_hidden']);
		$rowIndex = 0;
		$userID		=	$this->getUseridByInvestorID($investorId);
		$userType	=	USER_TYPE_INVESTOR_;
		if($numRows	>	0){
			if($this->getUserType()	==	USER_TYPE_ADMIN){
				$whereArry		=	array("user_id" => $userID);
				$this->dbDelete("profile_comments",$whereArry);
			}
			for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
				
				$comment_status				= $commentRows['comment_status_hidden'][$rowIndex];
				$comment_id					= $commentRows['comment_id_hidden'][$rowIndex];
				
				if($this->getUserType()	==	USER_TYPE_ADMIN) {	
					
					$comments					= $commentRows['comments'][$rowIndex];
					$input_tab					= $commentRows['input_tab'][$rowIndex];
					// Construct the data array
					$dataArray = array(	
									'user_type' 				=> $userType,
									'user_id'					=> $userID,
									'input_tab'	 				=> $input_tab,
									'comments'					=> $comments,
									'comment_status'			=> $comment_status,
									'comment_datetime' 			=> $this->getDbDateFormat(date("d/m/Y")));
										
					// Insert the rows (for all types of transaction)
					$result =  $this->dbInsert('profile_comments', $dataArray, true);
					if ($result < 0) {
						return -1;
					}
				}else{
					
					$dataArray = array(
										'comment_status'			=> $comment_status,
										'comment_datetime' 			=> $this->getDbDateFormat(date("d/m/Y"))
									);	
					$whereArry	=	array("profile_comments_id" =>"{$comment_id}");
					$this->dbUpdate('profile_comments', $dataArray, $whereArry);
				}
			}
		}
		return 1;
	}
	
	public function updateInvestorStatus($dataArray,$investorId,$status=null) {
		
		$whereArry	=	array("investor_id" =>"{$investorId}");
		$this->dbUpdate('investors', $dataArray, $whereArry);
		$invUserInfo	=	$this->getInvestorIdByUserInfo($investorId);
		
		if($status	==	"approve") {
			$mailArray	=	array(	"email"=>"sathya@syllogic.in",
									"subject"=>"Money Match - Investor Approval",
									"template"=>"emails.ApporvalTemplate",
									"username"=>$invUserInfo->username,
									"useremail"=>$invUserInfo->email
								);
			$this->sendMail($mailArray);
		}
		if($status	==	"return_invetor") {
			$mailArray	=	array(	"email"=>"sathya@syllogic.in",
									"subject"=>"Money Match - Investor Correction Required",
									"template"=>"emails.CorrectionRequiredTemplate",
									"username"=>$invUserInfo->username,
									"useremail"=>$invUserInfo->email
								);
			$this->sendMail($mailArray);
		}
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
					$status	=	null;
					break;
			case	"reject":
					$dataArray = array(	'status' 	=>	INVESTOR_STATUS_REJECTED);
					$status	=	null;
					break;
		}
		foreach($postArray['investor_ids'] as $invRow) {
			$this->updateInvestorStatus($dataArray,$invRow,$status);
		}
	}
}
