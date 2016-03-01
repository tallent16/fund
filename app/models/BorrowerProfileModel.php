<?php namespace App\models;

class BorrowerProfileModel extends TranWrapper {
	
	public $borrower_id  =  "";
	public $user_id  =  "";
	public $business_name  =  "";
	public $business_organisation  =  "";
	public $date_of_incorporation  =  "";
	public $business_registration_number  =  "";
	public $contact_person  =  "";
	public $contact_person_email  =  "";
	public $contact_person_mobile  =  "";
	public $paid_up_capital  =  "";
	public $number_of_employees  =  "";
	public $operation_since  =  "";
	public $registered_address  =  "";
	public $mailing_address  =  "";
	public $company_profile  =  "";
	public $comments  =  "";
	public $status  =  "";
	public $statusText  =  "";
	public $viewStatus  =  "";
	public $company_image  =  "";
	public $company_video_url  =  "";
	public $borrower_bankid  =  "";
	public $bank_name  =  "";
	public $branch_code  =  "";
	public $bank_account_number  	=  "";
	public $verified_status  		=  "";
	public $bank_code				=  "";
	public $director_details		= array();
	public $directorSelectOptions	= "";
	protected $table = 'borrowers';
	
	protected $primaryKey = 'borrower_id';
	public function getBorrowerDetails() {
		
		$this->getBorrowerCompanyInfo();
		$this->getBorrowerDirectorInfo();
		$this->getBorrowerDirectorDropDown();
	}
		
	public function getBorrowerCompanyInfo() {
		
		
		$current_user_id	=	 $this->getCurrentuserID();
		
		$sql= "	SELECT 	borrowers.borrower_id,
						borrowers.user_id,
						borrowers.business_name,
						borrowers.business_organisation,
						ifnull(DATE_FORMAT(borrowers.date_of_incorporation,'%d/%m/%Y'),'') date_of_incorporation,
						borrowers.business_registration_number,
						borrowers.contact_person,
						borrowers.contact_person_email,
						borrowers.contact_person_mobile,
						ROUND(borrowers.paid_up_capital,2) paid_up_capital,
						borrowers.number_of_employees,
						ifnull(DATE_FORMAT(borrowers.operation_since,'%d/%m/%Y'),'') operation_since,
						borrowers.registered_address,
						borrowers.mailing_address,
						borrowers.company_profile,
						borrowers.comments,
						borrowers.status,
						case borrowers.status 
							   when 1 then 'New profile' 
							   when 2 then 'Submitted for verification'
							   when 3 then 'Corrections required'
							   when 4 then 'Verified'
						end as statusText,
						case borrowers.status 
							   when 1 then '' 
							   when 2 then 'disabled'
							   when 3 then ''
							   when 4 then 'disabled'
						end as viewStatus,
						borrowers.company_image,
						borrowers.company_video_url,
						borrower_banks.borrower_bankid,
						borrower_banks.bank_name,
						borrower_banks.branch_code,
						borrower_banks.bank_account_number,
						borrower_banks.verified_status,
						borrower_banks.bank_code
				FROM 	borrowers
						LEFT JOIN borrower_banks
						ON	(borrowers.borrower_id	=	borrower_banks.borrower_id
						AND	borrower_banks.active_status = 1),
						users
				WHERE	borrowers.user_id	=	{$current_user_id}
				AND		borrowers.user_id	=	users.user_id";
		
		$result		= $this->dbFetchAll($sql);
		
		if ($result) {
		
			$vars = get_object_vars ( $result[0] );
			foreach($vars as $key=>$value) {
				$this->{$key} = $value;
			}
		}
	}
	
	public function getBorrowerDirectorInfo() {
		
		$current_borrower_id	=	 $this->getCurrentBorrowerID();
		
		$sql= "	SELECT 	id,
						borrower_id,
						slno,
						name,
						age,
						period_in_this_business,
						overall_experience,
						accomplishments,
						directors_profile
				FROM 	borrower_directors
				WHERE	borrower_id	=	{$current_borrower_id}";
		
		
		$result		= $this->dbFetchAll($sql);
			
		if ($result) {
			foreach ($result as $directorRow) {
				$newrow = count($this->director_details);
				$newrow ++;
				foreach ($directorRow as $colname => $colvalue) {
					$this->director_details[$newrow][$colname] = $colvalue;
				}
			}
		}
		return $result;
	}
	
	public function getBorrowerDirectorDropDown() {
		
		$directorList			=	array();
		$current_borrower_id	=	 $this->getCurrentBorrowerID();
		
		$sql= "	SELECT 	id,
						borrower_id,
						slno,
						name,
						age,
						period_in_this_business,
						overall_experience,
						accomplishments,
						directors_profile
				FROM 	borrower_directors
				WHERE	borrower_id	=	{$current_borrower_id}";
		
		
		$dir		= $this->dbFetchAll($sql);
		$i				=	0;	
		foreach($dir as $dirOpt){
			$directorList[$i]['id']			=	$dirOpt->slno;
			$directorList[$i]['name']		=	$dirOpt->name;
			$i++;
		}
		$directorSelectOptions			=	 $this->constructSelectOption($directorList, 'name', 'id',"", "");
		$this->directorSelectOptions	=	$directorSelectOptions;
	}
	
	public function processProfile($postArray) {
		
		$transType = $postArray['trantype'];
		if($transType	==	"edit") {
			$borrowerId  	= 	$postArray['borrower_id'];
			$whereArry		=	array("borrower_id" => $borrowerId);
			 $this->dbDelete("borrower_directors",$whereArry);
		}
		$borrowerId		=	 $this->updateBorrowerInfo($postArray,$transType);
		
		if (isset($postArray['director_row'])) {
			$directorRows = $postArray['director_row'];
			
			$this->updateBorrowerDirectorInfo($directorRows,$borrowerId);
		}
		
		$this->updateBorrowerBankInfo($postArray,$borrowerId,$transType);
	}
	
	public function updateBorrowerInfo($postArray,$transType) {
		
		
		if ($transType == "edit") {
			$borrowerId	= $postArray['borrower_id'];
			$status		=	2;
		} else {
			$borrowerId = 0;
			$status		=	1;
		}
		$business_name 					=	$postArray['business_name'];
		$business_organisation			= 	$postArray['business_organisation'];
		$date_of_incorporation			= 	$postArray['date_of_incorporation'];
		if($date_of_incorporation	==	"") 
			$date_of_incorporation		= 	 $this->getDbDateFormat(date("d/m/Y"));
		else
			$date_of_incorporation		= 	 $this->getDbDateFormat($date_of_incorporation);
		$business_reg_number 			= 	$postArray['business_registration_number'];
		$contact_person 				= 	$postArray['contact_person'];
		$contact_person_mobile 			= 	$postArray['contact_person_mobile'];
		$paid_up_capital 				= 	 $this->makeFloat($postArray['paid_up_capital']);
		$number_of_employees 			= 	$postArray['number_of_employees'];
		$operation_since 				= 	$postArray['operation_since'];
		if($operation_since	==	"") 
			$operation_since			= 	 $this->getDbDateFormat(date("d/m/Y"));
		else
			$operation_since			= 	 $this->getDbDateFormat($operation_since);
		$registered_address 			= 	$postArray['registered_address'];
		$mailing_address 				= 	$postArray['mailing_address'];
		$company_profile 				= 	$postArray['company_profile'];
		$status 						= 	$status;
		$current_user_id				=	 $this->getCurrentuserID();
		
		$dataArray = array(	'business_name' 				=> ($business_name!="")?$business_name:null,
							'business_organisation'			=> ($business_organisation!="")?$business_organisation:null,
							'date_of_incorporation'			=> $date_of_incorporation,
							'business_registration_number' 	=> ($business_reg_number!="")?$business_reg_number:null,
							'contact_person' 				=> ($contact_person!="")?$contact_person:null,
							'contact_person_mobile' 		=> ($contact_person_mobile!="")?$contact_person_mobile:null,
							'paid_up_capital' 				=> ($paid_up_capital!="")?$paid_up_capital:null,
							'number_of_employees' 			=> ($number_of_employees!="")?$number_of_employees:null,
							'operation_since' 				=> ($operation_since!="")?$operation_since:null,
							'registered_address' 			=> ($registered_address!="")?$registered_address:null,
							'mailing_address' 				=> ($mailing_address!="")?$mailing_address:null,
							'company_profile' 				=> ($company_profile!="")?$company_profile:null,
							'status' 						=> ($status!="")?$status:null,
							'user_id' 						=> $current_user_id);
							
	//~ echo "<pre>",print_r($dataArray),"</pre>";
		//~ die;	
		if ($transType != "edit") {
			$borrowerId =  $this->dbInsert('borrowers', $dataArray, true);
			if ($borrowerId < 0) {
				return -1;
			}
			return $borrowerId;
		}else{
			$whereArry	=	array("borrower_id" =>"{$borrowerId}");
			 $this->dbUpdate('borrowers', $dataArray, $whereArry);
			return $borrowerId;
		}
	}
	
	public function updateBorrowerDirectorInfo($directorRows,$borrowerId) {
		
		$numRows = count($directorRows['name']);
		$rowIndex = 0;
		echo $numRows;
		//~ die; 
		for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
			
			$borrower_id 				= $borrowerId;
			$slno						= $rowIndex+1;
			$name						= $directorRows['name'][$rowIndex];
			$age						= $directorRows['age'][$rowIndex];
			$period_in_this_business	= $directorRows['period_in_this_business'][$rowIndex];
			$overall_experience			= $directorRows['overall_experience'][$rowIndex];
			$accomplishments			= $directorRows['accomplishments'][$rowIndex];
			$directors_profile			= $directorRows['directors_profile'][$rowIndex];
		
			// Construct the data array
			$dataArray = array(	
							'borrower_id' 				=> $borrower_id,
							'slno'						=> $slno,
							'name'	 					=> $name,
							'age'						=> $age,
							'period_in_this_business' 	=> $period_in_this_business,
							'overall_experience' 		=> $overall_experience,
							'accomplishments' 			=> $accomplishments,
							'directors_profile' 		=> $directors_profile);		
							
			
			// Insert the rows (for all types of transaction)
			$result =  $this->dbInsert('borrower_directors', $dataArray, true);
			if ($result < 0) {
				return -1;
			}
		}
		return 1;
	}
	
	public function updateBorrowerBankInfo($postArray,$borrowerId,$transType) {
		
		$dataArray = array(	'borrower_id' 			=> $borrowerId,
							'bank_code' 			=> $postArray['bank_code'],
							'bank_name' 			=> $postArray['bank_name'],
							'branch_code' 			=> $postArray['branch_code'],
							'bank_account_number'	=> ($postArray['bank_account_number']!="")
																				?$postArray['bank_account_number']:NULL,
							'active_status' 		=> 1,
							'verified_status' 		=> $postArray['verified_status']);
							
		if ($transType != "edit") {
			$borrowerBankId =  $this->dbInsert('borrower_banks', $dataArray, true);
			if ($borrowerBankId < 0) {
				return -1;
			}
			return $borrowerBankId;
		}else{
			$borrowerBankId	= $postArray['borrower_bankid'];
			$whereArry	=	array("borrower_bankid" =>"{$borrowerBankId}");
			$this->dbUpdate('borrower_banks', $dataArray, $whereArry);
			return $borrowerBankId;
		}
	}
}
