<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
class BorrowerProfileModel extends TranWrapper {
	
	public 	$borrower_id  					=  	"";
	public 	$bo_id  						=  	"";
	public 	$user_id  						=  	"";
	public 	$business_name  				=  	"";
	public 	$business_organisation  		=  	"";
	public 	$date_of_incorporation  		=  	"";
	public 	$business_registration_number  	=	"";
	public 	$contact_person  				=  	"";
	public 	$contact_person_email  			=  	"";
	public 	$contact_person_mobile  		=  	"";
	public 	$paid_up_capital  				=  	"";
	public 	$number_of_employees  			=  	"";
	public 	$operation_since  				=  	"";
	public 	$registered_address  			=  	"";
	public 	$mailing_address  				=  	"";
	public 	$company_profile  				=  	"";
	public 	$company_aboutus  				=  	"";
	public 	$risk_industry  				=  	"";
	public 	$risk_strength  				=  	"";
	public 	$risk_weakness  				=  	"";
	public 	$comments  						=  	"";
	public 	$status  						=  	BORROWER_STATUS_NEW_PROFILE;
	public 	$statusText  					=  	"New profile";
	public 	$viewStatus  					=  	"";
	public 	$company_image  				=  	"";
	public 	$company_image_thumbnail		=  	"";
	public 	$company_video_url  			=  	"";
	public 	$borrower_bankid  				=  	"";
	public 	$bank_name  					=  	"";
	public 	$branch_code  					=  	"";
	public 	$bank_account_number  			=  	"";
	public 	$verified_status  				=  	"";
	public 	$bank_code						=  	"";
	public 	$director_details				= 	array();
	public 	$industryInfo					= 	array();
	public 	$finacialRatioInfo 				= 	array();
	public 	$finacialInfo 					= 	array();
	public 	$gradeInfo 						= 	array();
	public 	$commentsInfo 					= 	array();
	public 	$directorSelectOptions			= 	"";
	public 	$busin_organSelectOptions		= 	"";
	protected $table 						= 	'borrowers';
	
	protected $primaryKey = 'borrower_id';
	public function getBorrowerDetails($bor_id=null) {
		
		$this->getBorrowerCompanyInfo($bor_id);
		$this->getBorrowerDirectorInfo($bor_id);
		$this->getBorrowerFinacialRatio($bor_id);
		$this->getBorrowerFinacial($bor_id);
		$this->getBorrowerProfileComments($bor_id);
		$this->processDropDowns($bor_id);
	}
		
	public function getBorrowerCompanyInfo($bor_id) {
		
		if($bor_id	==	null){
			$current_user_id	=	$this->getCurrentuserID();
		}else{
			$current_user_id	=	$this->getUseridByBorrowerID($bor_id);
		}
		
		$sql= "	SELECT 	borrowers.borrower_id,
						borrowers.user_id,
						borrowers.bo_id,
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
						borrowers.company_aboutus,
						borrowers.risk_industry,
						borrowers.risk_strength,
						borrowers.risk_weakness,
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
						borrowers.company_image_thumbnail,
						borrowers.company_video_url,
						borrowers.borrower_risk_grade grade,
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
	
	public function getBorrowerDirectorInfo($bor_id) {
		
		if($bor_id	==	null){
			$current_borrower_id	=	 $this->getCurrentBorrowerID();
		}else{
					$current_borrower_id	=	$bor_id;
		}
		
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
	
	public function getBorrowerDirectorList($bor_id) {
		
		$directorList			=	array();
		if($bor_id	==	null){
			$current_borrower_id	=	 $this->getCurrentBorrowerID();
		}else{
			$current_borrower_id	=	$bor_id;
		}
		
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
		
		
		$dir_rs		= $this->dbFetchAll($sql);
		$i				=	0;	
		foreach($dir_rs as $dirOpt){
			$directorList[$i]['id']			=	$dirOpt->slno;
			$directorList[$i]['name']		=	$dirOpt->name;
			$i++;
		}
		return $directorList;
	}
	
	public function processProfile($postArray) {
		
		//~ echo "<pre>",print_r($postArray),"</pre>";
		//~ die;	
		$transType = $postArray['trantype'];
		if($transType	==	"edit") {
			$borrowerId  	= 	$postArray['borrower_id'];
			$whereArry		=	array("borrower_id" => $borrowerId);
			$this->dbDelete("borrower_directors",$whereArry);
			$this->dbDelete("borrower_financial_ratios",$whereArry);
			$this->dbDelete("borrower_financial_info",$whereArry);
		}
		$borrowerId		=	 $this->updateBorrowerInfo($postArray,$transType);
		
		if (isset($postArray['director_row'])) {
			$directorRows = $postArray['director_row'];
			
			$this->updateBorrowerDirectorInfo($directorRows,$borrowerId);
		}
		
		if (isset($postArray['finacialRatio_row'])) {
			$finacialRatioRows = $postArray['finacialRatio_row'];
			$this->updateBorrowerFinacialRatioInfo($finacialRatioRows,$borrowerId);
		}
		
		if (isset($postArray['finacial_row'])) {
			$finacialRows = $postArray['finacial_row'];
			$this->updateBorrowerFinacialInfo($finacialRows,$borrowerId);
		}
		
		$this->updateBorrowerBankInfo($postArray,$borrowerId,$transType);
	}
	
	public function updateBorrowerInfo($postArray,$transType) {
		
		if($postArray['isSaveButton']	==	"yes") {
			$status		=	BORROWER_STATUS_NEW_PROFILE;	
		}else{
			$status		=	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL;
		}
		if ($transType == "edit") {
			$borrowerId	= $postArray['borrower_id'];
		} else {
			$borrowerId = 0;
		}
		$business_name 					=	$postArray['business_name'];
		$business_organisation			= 	$postArray['business_organisation'];
		$date_of_incorporation			= 	$postArray['date_of_incorporation'];
		if($date_of_incorporation	==	"") 
			$date_of_incorporation		= 	$this->getDbDateFormat(date("d/m/Y"));
		else
			$date_of_incorporation		= 	$this->getDbDateFormat($date_of_incorporation);
		$business_reg_number 			= 	$postArray['business_registration_number'];
		$industry			 			= 	$postArray['industry'];
		$contact_person 				= 	$postArray['contact_person'];
		$contact_person_mobile 			= 	$postArray['contact_person_mobile'];
		$paid_up_capital 				= 	$this->makeFloat($postArray['paid_up_capital']);
		$number_of_employees 			= 	$postArray['number_of_employees'];
		$operation_since 				= 	$postArray['operation_since'];
		if($operation_since	==	"") 
			$operation_since			= 	 $this->getDbDateFormat(date("d/m/Y"));
		else
			$operation_since			= 	 $this->getDbDateFormat($operation_since);
		$registered_address 			= 	$postArray['registered_address'];
		$mailing_address 				= 	$postArray['mailing_address'];
		$company_profile 				= 	$postArray['company_profile'];
		$company_aboutus 				= 	$postArray['about_us'];
		$risk_industry 					= 	$postArray['risk_industry'];
		$risk_strength 					= 	$postArray['risk_strength'];
		$risk_weakness 					= 	$postArray['risk_weakness'];
		$status 						= 	$status;
		$current_user_id				=	$this->getCurrentuserID();
		$destinationPath 				= 	Config::get('moneymatch_settings.upload_bor');
		$updateDataArry					=	array();
		$fileUploadObj					=	new FileUpload();
		if(isset($postArray['company_image'])){
			$file		=	$postArray['company_image'];
			$imagePath	=	$destinationPath."/".$borrowerId."/profile/image";
			$fileUploadObj->createIfNotExists($imagePath);
			$fileUploadObj->storeFile($imagePath ,$file);
			$filename 			= 	$file->getClientOriginalName();
			$company_image		=	$imagePath."/".$filename;
			$updateDataArry		=	array(	"company_image"=>$company_image,
											"company_image_thumbnail"=>$company_image
											);
		}
		if(isset($postArray['company_thumbnail'])){
			$file			=	$postArray['company_thumbnail'];
			$thumbnailPath	=	$destinationPath."/".$borrowerId."/profile/thumbnail";
			$fileUploadObj->createIfNotExists($thumbnailPath);
			$fileUploadObj->storeFile($thumbnailPath ,$file);
			$filename 									= 	$file->getClientOriginalName();
			$company_thumbnail							=	$thumbnailPath."/".$filename;
			$updateDataArry["company_image_thumbnail"]	=	$company_thumbnail;
			
		}
		//~ if(isset($postArray['company_video'])){
			//~ $file			=	$postArray['company_video'];
			//~ $videoPath		=	$destinationPath."/".$borrowerId."/profile/video";
			//~ $fileUploadObj->createIfNotExists($videoPath);
			//~ $fileUploadObj->storeFile($thumbnailPath ,$file);
			//~ $filename 								= 	$file->getClientOriginalName();
			//~ $company_video							=	$thumbnailPath."/".$filename;
			//~ $updateDataArry["company_video_url"]	=	$company_video;
		//~ }
		
		$dataArray = array(	'business_name' 				=> ($business_name!="")?$business_name:null,
							'bo_id'							=> ($business_organisation!="")?$business_organisation:null,
							'industry'						=> ($industry!="")?$industry:null,
							'date_of_incorporation'			=> $date_of_incorporation,
							'business_registration_number' 	=> ($business_reg_number!="")?$business_reg_number:null,
							'contact_person' 				=> ($contact_person!="")?$contact_person:null,
							'contact_person_mobile' 		=> ($contact_person_mobile!="")?$contact_person_mobile:null,
							'paid_up_capital' 				=> ($paid_up_capital!="")?$paid_up_capital:null,
							'number_of_employees' 			=> ($number_of_employees!="")?$number_of_employees:null,
							'operation_since' 				=> ($operation_since!="")?$operation_since:null,
							'risk_industry' 				=> ($risk_industry!="")?$risk_industry:null,
							'risk_strength' 				=> ($risk_strength!="")?$risk_strength:null,
							'risk_weakness' 				=> ($risk_weakness!="")?$risk_weakness:null,
							'registered_address' 			=> ($registered_address!="")?$registered_address:null,
							'mailing_address' 				=> ($mailing_address!="")?$mailing_address:null,
							'company_profile' 				=> ($company_profile!="")?$company_profile:null,
							'company_aboutus' 				=> ($company_aboutus!="")?$company_aboutus:null,
							'status' 						=> ($status!="")?$status:null,
							'user_id' 						=> $current_user_id);
		
		if(count($updateDataArry) > 0) {
			foreach($updateDataArry as $key=>$value) {
				$dataArray[$key]	=	$value;
			}	
		}					
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
	
	public function updateBorrowerFinacialRatioInfo($RatioRows,$borrowerId) {
		
		//~ echo "<pre>",print_r($finacialRatioRows),"</pre>";
		//~ die;
		$numRows = count($RatioRows['ratio_id']);
		$rowIndex = 0;
		
		for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
			
			$borrower_id 				= $borrowerId;
			$ratio_name					= $RatioRows['ratio_name'][$rowIndex];
			$ratio_value_current_year	= $RatioRows['current_ratio'][$rowIndex];
			$ratio_value_previous_year	= $RatioRows['previous_ratio'][$rowIndex];
			
			// Construct the data array
			$dataArray = array(	
							'borrower_id' 				=> $borrower_id,
							'ratio_name'				=> $ratio_name,
							'ratio_value_current_year'	=> $ratio_value_current_year,
							'ratio_value_previous_year'	=> $ratio_value_previous_year);		
							
			
			// Insert the rows (for all types of transaction)
			$result =  $this->dbInsert('borrower_financial_ratios', $dataArray, true);
			if ($result < 0) {
				return -1;
			}
		}
		return 1;
	}
	
	public function updateBorrowerFinacialInfo($finacialRows,$borrowerId) {
		
		$numRows = count($finacialRows['indicator_name']);
		$rowIndex = 0;
		
		for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
			
			$borrower_id 				= 	$borrowerId;
			$indicator_name				= 	$finacialRows['indicator_name'][$rowIndex];
			$indicator_value			= 	$finacialRows['indicator_value'][$rowIndex];
				
			// Construct the data array
			$dataArray = array(	
							'borrower_id' 				=> $borrower_id,
							'indicator_name'			=> $indicator_name,
							'indicator_value'			=> $indicator_value);		
							
			
			// Insert the rows (for all types of transaction)
			$result =  $this->dbInsert('borrower_financial_info', $dataArray, true);
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
							'active_status' 		=> 1);
							
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
	
	public function processDropDowns($bor_id) {
		
		$industry_sql				=	"	SELECT	codelist_id,
													codelist_code,
													codelist_value,
													expression
											FROM	codelist_details
											WHERE	codelist_id = 15";
											
		$industry_rs				= 	$this->dbFetchAll($industry_sql);
		if ($industry_rs) {
			foreach($industry_rs as $industryRow) {
				$industryRowIndex	=	$industryRow->codelist_value;
				$industryRowvalue	=	$industryRow->codelist_value;
				$this->industryInfo[$industryRowIndex]	=	$industryRowvalue;
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
		
		$this->directorSelectOptions	=	$this->constructSelectOption($this->getBorrowerDirectorList($bor_id),
															'name', 'id',"", "");		
		$this->busin_organSelectOptions	=	$this->constructSelectOption($this->getBusinessOrganisationList(),
															'bo_name', 'bo_id',$this->bo_id, "");		
	}
	
	public function getBorrowerFinacialRatio($bor_id) {
		
		if($bor_id	==	null){
			$current_borrower_id	=	 $this->getCurrentBorrowerID();
		}else{
			$current_borrower_id	=	$bor_id;
		}
		$finacialRation_rs		= 	 $this->getFinacialRatioList($current_borrower_id);
			
		if ($finacialRation_rs) {
			foreach ($finacialRation_rs as $finRatioRow) {
				$newrow = count($this->finacialRatioInfo);
				$newrow ++;
				foreach ($finRatioRow as $colname => $colvalue) {
					$this->finacialRatioInfo[$newrow][$colname] = $colvalue;
				}
			}
		}else{
			$finacialRation_rs	=	 $this->getBorrowerCodeListFinacialRatio();	
		}
		return $finacialRation_rs;
	}
			
	public function getBorrowerFinacial($bor_id) {
		
		if($bor_id	==	null){
			$current_borrower_id	=	 $this->getCurrentBorrowerID();
		}else{
			$current_borrower_id	=	$bor_id;
		}
		$finacial_rs			= 	 $this->getFinacialList($current_borrower_id);
			
		if ($finacial_rs) {
			foreach ($finacial_rs as $directorRow) {
				$newrow = count($this->finacialInfo);
				$newrow ++;
				foreach ($directorRow as $colname => $colvalue) {
					$this->finacialInfo[$newrow][$colname] = $colvalue;
				}
			}
		}else{
			$finacial_rs	=	 $this->getBorrowerCodeListFinacial();	
		}
		return $finacial_rs;
	}
	
	public function getBorrowerCodeListFinacialRatio() {
		
		$finacialRation_rs		= 	 $this->getCodeListFinacialRatio();
			
		if ($finacialRation_rs) {
			foreach ($finacialRation_rs as $finRatioRow) {
				$newrow = count($this->finacialRatioInfo);
				$newrow ++;
				$this->finacialRatioInfo[$newrow]['ratio_name'] 	= 	$finRatioRow->codelist_value;
				$this->finacialRatioInfo[$newrow]['current_ratio'] 	= 	"0.00";
				$this->finacialRatioInfo[$newrow]['previous_ratio'] = 	"0.00";
			}
		}
		return $finacialRation_rs;
	}
			
	public function getBorrowerCodeListFinacial() {
		
		$finacial_rs			= 	 $this->getCodeListFinacial();
			
		if ($finacial_rs) {
			foreach ($finacial_rs as $finacialRow) {
				$newrow = count($this->finacialInfo);
				$newrow ++;
				$this->finacialInfo[$newrow]['indicator_name'] 		= 	$finacialRow->codelist_value;
				$this->finacialInfo[$newrow]['indicator_value'] 	= 	"0.00";
				$this->finacialInfo[$newrow]['currency'] 			= 	"";
			}
		}
		return $finacial_rs;
	}
	
	
	public function getBorrowerProfileComments($bor_id) {
		
		
		if($bor_id	==	null){
			$current_user_id	=	$this->getCurrentuserID();
		}else{
			$current_user_id	=	$this->getUseridByBorrowerID($bor_id);
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
	
}
