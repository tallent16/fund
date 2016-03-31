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
		
	public function getInvestorDetails() {
		
		$this->getInvestorProfile();
	}
		
	public function getInvestorProfile() {
		
		$current_user_id		=	 $this->getCurrentuserID();
		
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
	
}
