<?php namespace App\models;
use fileupload\FileUpload;
use File;
use Config;
use Log;
use Auth;
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
	public 	$paid_up_capital  				=  	0;
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
	public 	$borrower_bankid  				=  	0;
	public 	$bank_name  					=  	"";
	public 	$branch_code  					=  	"";
	public 	$bank_account_number  			=  	"";
	public 	$bank_statement_url  			=  	"";
	public 	$verified_status  				=  	"";
	public 	$bank_code						=  	"";
	public 	$director_details				= 	array();
	public 	$industryInfo					= 	array();
	public 	$finacialRatioInfo 				= 	array();
	public 	$finacialInfo 					= 	array();
	public 	$gradeInfo 						= 	array();
	public 	$commentsInfo 					= 	array();
	public 	$commentsReplyInfo 				= 	array();
	public 	$directorSelectOptions			= 	"";
	public 	$busin_organSelectOptions		= 	"";
	public 	$comments_count					= 	0;
	public 	$company_info_complete			= 	0;
	public 	$director_info_complete			= 	0;
	public 	$bank_info_complete				= 	0;
	public 	$successTxt 					= 	"";
	
	protected $table 						= 	'borrowers';
	
	protected $primaryKey = 'borrower_id';
	public function getBorrowerDetails($bor_id=null) {
		
		$this->getBorrowerCompanyInfo($bor_id);
		$this->getBorrowerDirectorInfo($bor_id);
		$this->getBorrowerFinacialRatio($bor_id);
		$this->getBorrowerFinacial($bor_id);
		$this->getBorrowerProfileComments($bor_id);
		$this->getBorrowerProfileCommentsReply($bor_id);
		$this->getOpenCommentsCount($bor_id);
		$this->processDropDowns($bor_id);
		$this->getBorrowerBankInfo($bor_id);
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
						borrowers.acra_profile_doc_url,
						borrowers.moa_doc_url,
						borrowers.financial_doc_url,
						borrowers.borrower_risk_grade grade
				FROM 	borrowers,
						users
				WHERE	borrowers.user_id	=	{$current_user_id}
				AND		borrowers.user_id	=	users.user_id";
		
		$result		= $this->dbFetchAll($sql);
		
		if ($result) {
		
			$vars = get_object_vars ( $result[0] );
			foreach($vars as $key=>$value) {
				$this->{$key} = $value;
			}
			$this->company_info_complete	=	1;
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
						directors_profile,
						identity_card_front,
						identity_card_back
				FROM 	borrower_directors
				WHERE	borrower_id	='".$current_borrower_id."'";
		
		
		$result		= $this->dbFetchAll($sql);
			
		if ($result) {
			foreach ($result as $directorRow) {
				$newrow = count($this->director_details);
				$newrow ++;
				foreach ($directorRow as $colname => $colvalue) {
					$this->director_details[$newrow][$colname] = $colvalue;
				}
			}
			$this->director_info_complete	=	1;
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
				WHERE	borrower_id	='".$current_borrower_id."'";
		
		
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

		$transType = $postArray['trantype'];
		$moduleName	=	"Borrower Profile";
		
		if($transType	==	"edit") {
			$borrowerId  	= 	$postArray['borrower_id'];
			$whereArry		=	array("borrower_id" => $borrowerId);

			if($postArray['isSaveButton']	!=	"yes") {
				$actionSumm =	"For Approval";
				$actionDet  =	"Borrower Profile Submit for Approval";
			} else {
				// Audit Trail related Settings
				$actionSumm =	"Update";
				$actionDet  =	"Update Borrower Profile";
			}
		} else {
			$actionSumm =	"Add";
			$actionDet	=	"Add New Borrower Profile";
		}
		
		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"business_name", $postArray['business_name']);
       //  echo '<pre>';print_r($postArray)
		$borrowerId		=	 $this->updateBorrowerInfo($postArray,$transType);

		$this->updateBorrowerDirectorInfo($postArray,$borrowerId);
		
		$this->updateBorrowerProfileInfo($postArray,$borrowerId);		
		
		if (isset($postArray['finacial_row'])) {
			$finacialRows = $postArray['finacial_row'];
			$this->updateBorrowerFinacialInfo($finacialRows,$borrowerId);
		}
			
		if(Auth::user()->usertype	==	USER_TYPE_ADMIN) {
			//Admin only edit the finacial info and profile info
			
			if (isset($postArray['finacialRatio_row'])) {
				$finacialRatioRows = $postArray['finacialRatio_row'];
				$this->updateBorrowerFinacialRatioInfo($finacialRatioRows,$borrowerId);
			}
		}
		if( (isset($postArray['hidden_borrower_status']) &&
					$postArray['hidden_borrower_status']	==	"corrections_required" )
				||(Auth::user()->usertype	==	USER_TYPE_ADMIN) ) {
				if (isset($postArray['comment_row'])) {
					$this->saveComments($postArray['comment_row'],$borrowerId);
				}
		}
		$this->updateBorrowerBankInfo($postArray,$borrowerId,$transType);
		if($postArray['isSaveButton']	!=	"yes") {
			$this->successTxt	=	$this->getSystemMessageBySlug("borrower_profile_submit");
		} else {
			$this->successTxt	=	$this->getSystemMessageBySlug("borrower_profile_update_by_borrwer");
		}
		return $borrowerId;
	}
	
		public function updateBorrowerInfo($postArray,$transType) {
		
	
		if ($transType == "edit") {
			$borrowerId	= $postArray['borrower_id'];
			$status		=	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL;
		} else {
			$borrowerId = 0;
			$status		=	BORROWER_STATUS_NEW_PROFILE;
			if($postArray['isSaveButton']	!=	"yes") {
				$status		=	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL;
			}
			if(Auth::user()->usertype	==	USER_TYPE_ADMIN) {
				$status		=	$postArray['current_profile_status'];
			}
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
		$status 						= 	$status;
		$current_user_id				=	$this->getCurrentuserID();
		
		
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
							'registered_address' 			=> ($registered_address!="")?$registered_address:null,
							'mailing_address' 				=> ($mailing_address!="")?$mailing_address:null);
		if(Auth::user()->usertype	==	USER_TYPE_BORROWER) {
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
			$borrowerId =  $this->dbInsert('borrowers', $dataArray, true);
			if ($borrowerId < 0) {
				return -1;
			}
			$register_datetime	=	date("Y-m-d H:i:s");
			$dataArray 			= 	array('register_datetime'=> ($register_datetime!="")?$register_datetime:null);
			$whereArry			=	array("borrower_id" =>"{$borrowerId}");
			$this->dbUpdate('borrowers', $dataArray, $whereArry);
		}else{
			$whereArry	=	array("borrower_id" =>"{$borrowerId}");
			 $this->dbUpdate('borrowers', $dataArray, $whereArry);
		}
		$this->uploadCompanyProfileAttachments($postArray,$borrowerId);
		return $borrowerId;
		
	}
	
	public function uploadCompanyProfileAttachments($postArray,$borrowerId) {
		
		$fileUploadObj		=	new FileUpload();
		$updateAttachment	=	false;
		$destinationPath 	= 	Config::get('moneymatch_settings.upload_bor');
		$updateDataArry		=	array();
		if(isset($postArray['company_image'])){
			if(isset($postArray['company_image_hidden']) && $postArray['company_image_hidden']!=''){
				$filePath		=	$postArray['company_image_hidden'];
				$fileUploadObj->deleteFile($filePath);
			}
			$file		=	$postArray['company_image'];
			//~ $imagePath	=	$destinationPath."/".$borrowerId."/profile/image";
			$imagePath	=	$destinationPath."/".$borrowerId;
			$prefix		=	"profile_image_";
			$fileUploadObj->createIfNotExists($imagePath);
			
			$company_image		=	$fileUploadObj->storeFile($imagePath ,$file,$prefix);
			if(empty($postArray['company_thumbnail_hidden']) || empty(trim($postArray['company_thumbnail_hidden'])) ) {
				$company_thumbnail		=	$fileUploadObj->storeFile($imagePath ,$file,"thumbnail_");
				$updateDataArry		=	array(	"company_image"=>$company_image,
											"company_image_thumbnail"=>$company_thumbnail
											);
			}
				else
					$updateDataArry["company_image"]	=	$company_image;
			$updateAttachment	=	true;
		}
		if(isset($postArray['company_thumbnail']) && $postArray['company_thumbnail']!=''){
			
			if($postArray['company_image_hidden']	!=	$postArray['company_thumbnail_hidden']){
				$filePath		=	$postArray['company_thumbnail_hidden'];
				$fileUploadObj->deleteFile($filePath);
			}
			
			unset($prefix);
			unset($filename);
			unset($newfilename);
			unset($file);
			
			$file			=	$postArray['company_thumbnail'];
			$thumbnailPath	=	$destinationPath."/".$borrowerId;
			$prefix			=	"thumbnail_";
			$fileUploadObj->createIfNotExists($thumbnailPath);
			
			
			$company_thumbnail							=	$fileUploadObj->storeFile($thumbnailPath ,$file,$prefix);
			$updateDataArry["company_image_thumbnail"]	=	$company_thumbnail;
			$updateAttachment	=	true;
		}
		if(isset($postArray['acra_profile_doc_url']) && $postArray['acra_profile_doc_url']!=''){
			if(isset($postArray['acra_profile_doc_url_hidden']) && $postArray['acra_profile_doc_url_hidden'] != ''){
				$filePath		=	$postArray['acra_profile_doc_url_hidden'];
				$fileUploadObj->deleteFile($filePath);
			}
			unset($prefix);
			unset($filename);
			unset($newfilename);
			unset($file);
			
			$file		=	$postArray['acra_profile_doc_url'];
			$filePath	=	$destinationPath."/".$borrowerId;
			$prefix		=	"ACRA_Bus_pro_";
			$fileUploadObj->createIfNotExists($filePath);
			
			$acra_profile_doc_url					=	$fileUploadObj->storeFile($filePath ,$file,$prefix);
			$updateDataArry["acra_profile_doc_url"]	=	$acra_profile_doc_url;
			$updateAttachment						=	true;
		}
		if(isset($postArray['moa_doc_url']) && $postArray['moa_doc_url']!=''){
			if(isset($postArray['moa_doc_url_hidden'])){
				$filePath		=	$postArray['moa_doc_url_hidden'];
				$fileUploadObj->deleteFile($filePath);
			}
			unset($prefix);
			unset($filename);
			unset($newfilename);
			unset($file);
			
			$file			=	$postArray['moa_doc_url'];
			$filePath		=	$destinationPath."/".$borrowerId;
			$prefix			=	"MAOA_";
			$fileUploadObj->createIfNotExists($filePath);
			
			$moa_doc_url								=	$fileUploadObj->storeFile($filePath ,$file,$prefix);
			$updateDataArry["moa_doc_url"]				=	$moa_doc_url;
			$updateAttachment							=	true;
		}
		if(isset($postArray['financial_doc_url']) && $postArray['financial_doc_url']!= ''){
			if(isset($postArray['financial_doc_hidden'])){
				$filePath		=	$postArray['financial_doc_hidden'];
				$fileUploadObj->deleteFile($filePath);
			}
			unset($prefix);
			unset($filename);
			unset($newfilename);
			unset($file);
			
			$file			=	$postArray['financial_doc_url'];
			$filePath		=	$destinationPath."/".$borrowerId;
			$prefix			=	"FNLRO_";
			$fileUploadObj->createIfNotExists($filePath);
			//~ echo $filePath; die;
			$finan_doc_url								=	$fileUploadObj->storeFile($filePath ,$file,$prefix);
			$updateDataArry["financial_doc_url"]		=	$finan_doc_url;
			$updateAttachment							=	true;
		}
		
		if($updateAttachment) {
			$whereArray	=	["borrower_id" 	=> $borrowerId];
			$this->dbUpdate("borrowers", $updateDataArry, $whereArray);
		}
	}
	public function updateBorrowerProfileInfo($postArray,$borrowerId) {
		
		$company_profile 				= 	$postArray['company_profile'];
		$company_aboutus 				= 	$postArray['about_us'];
		
		$dataArray = array(	
							'company_profile' 				=> ($company_profile!="")?$company_profile:null,
							'company_aboutus' 				=> ($company_aboutus!="")?$company_aboutus:null);
							
		$whereArry	=	array("borrower_id" =>"{$borrowerId}");
		$this->dbUpdate('borrowers', $dataArray, $whereArry);
		return $borrowerId;
	}
	
	public function updateBorrowerDirectorInfo($postArray,$borrowerId) {
	 // $directorRows,$borrowerId) {
		
		if (isset($postArray["director_row"])) {
			$directorRows = $postArray["director_row"];
			$numRows = count($directorRows['name']);
		} else {
			$directorRows = array();
			$numRows = 0;
		}
		//~ echo "<pre>",print_r($directorRows),"</pre>";
		//~ die;
		$updateAttachment	=	false;
		$rowIndex = 0;
		$directorIds  = array();
		$fileUploadObj	=	new FileUpload();
		for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
			$borrower_id 				= $borrowerId;
			
			$id							= $directorRows['id'][$rowIndex];
			if ($id > 0) {
				$directorIds[] = $id;
				$update = true;
			} else {
				$update = false;
			}
			
			$slno						= 	$rowIndex+1;
			$name						= 	$directorRows['name'][$rowIndex];
			$age						= 	$directorRows['age'][$rowIndex];
			$overall_experience			= 	$directorRows['overall_experience'][$rowIndex];
			$accomplishments			= 	$directorRows['accomplishments'][$rowIndex];
			$directors_profile			= 	$directorRows['directors_profile'][$rowIndex];
			$identity_card_front		= 	$directorRows['identity_card_front'][$rowIndex];
			//~ $identity_card_back			= 	$directorRows['identity_card_back'][$rowIndex];
			$destinationPath 			= 	Config::get('moneymatch_settings.upload_bor');
			
			// Construct the data array
			$dataArray = array(	
							'borrower_id' 				=> $borrower_id,
							'slno'						=> $slno,
							'name'	 					=> $name,
							'age'						=> $age,
							'overall_experience' 		=> $overall_experience,
							'accomplishments' 			=> $accomplishments,
							'directors_profile' 		=> $directors_profile);		

			if ($update) {
				$whereArray	=	["borrower_id" 	=> $borrower_id,
								 "id"			=> $id];
				$this->dbUpdate("borrower_directors", $dataArray, $whereArray);
			} else {
				$id	 =  $this->dbInsert('borrower_directors', $dataArray, true);
				$directorIds[]	=	$id;
			}
			
			if(isset($identity_card_front)){
				if(isset($postArray['identity_card_front_hidden'][$rowIndex]) && $postArray['identity_card_front_hidden'][$rowIndex]!=''){
					$filePath		=	$postArray['identity_card_front_hidden'][$rowIndex];
					
					$fileUploadObj->deleteFile($filePath);
					
				}
				unset($prefix);
				unset($filename);
				unset($newfilename);
				unset($file);
				
				$file				=	$identity_card_front;
				$filePath			=	$destinationPath."/".$borrowerId;
				$prefix				=	"dir_iden_front_{$id}_";
				$fileUploadObj->storeFile($filePath ,$file,$prefix);
				$filename 				= 	$file->getClientOriginalName();
				$newfilename 			= 	preg_replace('/\s+/', '_', $filename);
				$newfilename 			= 	$prefix.$newfilename;
				$identity_card_front	=	$filePath."/".$newfilename;
				$updateDataArry			=	array(	"identity_card_front"=>$identity_card_front);
				$updateAttachment		=	true;
			}
			//~ if(isset($identity_card_back)){	
				//~ if(isset($postArray['identity_card_back_hidden'][$rowIndex])){
					//~ $filePath		=	$postArray['identity_card_back_hidden'][$rowIndex];
					//~ $fileUploadObj->deleteFile($filePath);
				//~ }
				//~ unset($prefix);
				//~ unset($filename);
				//~ unset($newfilename);
				//~ unset($file);
				
				//~ $file			=	$identity_card_back;
				//~ $filePath		=	$destinationPath."/".$borrowerId;
				//~ $prefix			=	"dir_iden_back_{$id}_";
				//~ $fileUploadObj->storeFile($filePath ,$file,$prefix);
				//~ $filename 									= 	$file->getClientOriginalName();
				//~ $newfilename 								= 	preg_replace('/\s+/', '_', $filename);
				//~ $newfilename 								= 	$prefix.$newfilename;
				//~ $identity_card_back							=	$filePath."/".$newfilename;
				//~ $updateDataArry["identity_card_back"]		=	$identity_card_back;
				//~ $updateAttachment							=	true;
			//~ }
			if($updateAttachment) {
				$whereArray	=	["borrower_id" 	=> $borrower_id,
								 "id"			=> $id];
				$this->dbUpdate("borrower_directors", $updateDataArry, $whereArray);
			}
		}
		$directors	=	$this->getBorrowerDirectorAttachments($borrowerId,(($numRows	>	0)?$directorIds:""));
		
		$where	=	["borrower_id" => 	$borrowerId,
					 "whereNotIn" =>	["column" => 'id',
										 "valArr" => $directorIds]];
		$dirFilePath	=	"";
		foreach($directors as $dirRow) {
					unset($dirFilePath);
			$dirFilePathFront	=	$dirRow->identity_card_front;
			//~ $dirFilePathBack	=	$dirRow->identity_card_back;

			if($dirFilePathFront!=''){

			$fileUploadObj->deleteFile($dirFilePathFront);
		}
			//~ $fileUploadObj->deleteFile($dirFilePathBack);
		}
		$this->dbDelete("borrower_directors", $where);

		return 1;
	}
	
	public function updateBorrowerFinacialRatioInfo($RatioRows,$borrowerId) {
		
		$numRows = count($RatioRows['borrower_financial_ratios_id']);
		$rowIndex = 0;
		
		for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
			
			$borrower_id 				= $borrowerId;
			$financial_ratios_id		= $RatioRows['borrower_financial_ratios_id'][$rowIndex];
			$ratio_name					= $RatioRows['ratio_name'][$rowIndex];
			$ratio_value_current_year	= $this->makeFloat($RatioRows['current_ratio'][$rowIndex]);
			$ratio_value_previous_year	= $this->makeFloat($RatioRows['previous_ratio'][$rowIndex]);
			
			// Construct the data array
			$dataArray = array(	
							'borrower_id' 				=> $borrower_id,
							'ratio_name'				=> $ratio_name,
							'ratio_value_current_year'	=> $ratio_value_current_year,
							'ratio_value_previous_year'	=> $ratio_value_previous_year);		
							
			if ($this->makeFloat($financial_ratios_id) > 0) {
				$where		=	["borrower_financial_ratios_id" => $financial_ratios_id];
				$this->dbUpdate('borrower_financial_ratios', $dataArray, $where);
			} else {
				// Insert the rows (for all types of transaction)
				$result =  $this->dbInsert('borrower_financial_ratios', $dataArray, true);
				if ($result < 0) {
					return -1;
				}
			}
		}
		return 1;
	}
	
	public function updateBorrowerFinacialInfo($finacialRows,$borrowerId) {
		
		$numRows = count($finacialRows['indicator_name']);
		$rowIndex = 0;
		
		
		for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
			
			$borrower_id 				= 	$borrowerId;
			
			$borrower_financial_info_id =	$finacialRows['borrower_financial_info_id'][$rowIndex];
			$indicator_name				= 	$finacialRows['indicator_name'][$rowIndex];
			$indicator_value			= 	$this->makeFloat($finacialRows['indicator_value'][$rowIndex]);
			$ref_codelist_code			= 	$finacialRows['ref_codelist_code'][$rowIndex];
			
			// Construct the data array
			$dataArray = array(	
							'borrower_id' 				=> $borrower_id,
							'indicator_name'			=> $indicator_name,
							'indicator_value'			=> $indicator_value,	
							'ref_codelist_code'			=> $ref_codelist_code);		
			
			if ($this->makeFloat($borrower_financial_info_id) > 0) {
				$where		=	["borrower_financial_info_id" => $borrower_financial_info_id];
				$this->dbUpdate('borrower_financial_info', $dataArray, $where);
			} else {
				// Insert the rows (for all types of transaction)
				$result =  $this->dbInsert('borrower_financial_info', $dataArray, true);
				if ($result < 0) {
					return -1;
				}
			}
		}
		return 1;
	}
	
	public function updateBorrowerBankInfo($postArray,$borrowerId,$transType) {
		
		if(isset($postArray['bank_statement']) || $postArray['bank_statement_hidden'] !="" ) {
				
			$destinationPath 			= 	Config::get('moneymatch_settings.upload_bor');
			$fileUploadObj				=	new FileUpload();
			
			$dataArray = array(	'borrower_id' 			=> $borrowerId,
								'bank_code' 			=> $postArray['bank_code'],
								'bank_name' 			=> $postArray['bank_name'],
								'branch_code' 			=> $postArray['branch_code'],
								'bank_account_number'	=> ($postArray['bank_account_number']!="")
																					?$postArray['bank_account_number']:NULL,
								'active_status' 		=> 1);
								
			if ( $postArray['borrower_bankid']	==	0) {
				$borrowerBankId =  $this->dbInsert('borrower_banks', $dataArray, true);
				if ($borrowerBankId < 0) {
					return -1;
				}
			
			}else{
				$borrowerBankId	= $postArray['borrower_bankid'];
				$whereArry	=	array("borrower_bankid" =>"{$borrowerBankId}");
				$this->dbUpdate('borrower_banks', $dataArray, $whereArry);
			}
			$updateAttachment		=	false;
			if(isset($postArray['bank_statement'])){
				if(isset($postArray['bank_statement_hidden']) && $postArray['bank_statement_hidden']!=''){
					$filePath		=	$postArray['bank_statement_hidden'];
					$fileUploadObj->deleteFile($filePath);
					
				}
				unset($prefix);
				unset($filename);
				unset($newfilename);
				unset($file);
				
				$file				=	$postArray['bank_statement'];
				$filePath			=	$destinationPath."/".$borrowerId;
				$prefix				=	"bank_stat_{$borrowerBankId}_";
				$fileUploadObj->storeFile($filePath ,$file,$prefix);
				$filename 				= 	$file->getClientOriginalName();
				$newfilename 			= 	preg_replace('/\s+/', '_', $filename);
				$newfilename 			= 	$prefix.$newfilename;
				$bank_statement			=	$filePath."/".$newfilename;
				$updateDataArry			=	array(	"bank_statement_url"=>$bank_statement);
				$updateAttachment		=	true;
			}
			if($updateAttachment) {
				$whereArray	=	["borrower_id" 		=> $borrowerId,
								 "borrower_bankid"	=> $borrowerBankId];
				$this->dbUpdate("borrower_banks", $updateDataArry, $whereArray);
			}
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
		$finacialRatio_rs		= 	 $this->getFinacialRatioList($current_borrower_id);
			
		if ($finacialRatio_rs) {
			foreach ($finacialRatio_rs as $finRatioRow) {
				$newrow = count($this->finacialRatioInfo);
				$newrow ++;
				foreach ($finRatioRow as $colname => $colvalue) {
					$this->finacialRatioInfo[$newrow][$colname] = $colvalue;
				}
			}
		}else{
			$finacialRatio_rs	=	 $this->getBorrowerCodeListFinacialRatio();	
		}

		return $finacialRatio_rs;
		
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
				$this->finacialRatioInfo[$newrow]['borrower_financial_ratios_id'] 	= 	0;
				$this->finacialRatioInfo[$newrow]['ratio_name'] 					= 	$finRatioRow->codelist_value;
				$this->finacialRatioInfo[$newrow]['current_ratio'] 					= 	"0.00";
				$this->finacialRatioInfo[$newrow]['previous_ratio'] 				= 	"0.00";
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
				$this->finacialInfo[$newrow]['borrower_financial_info_id'] 		= 	$finacialRow->borrower_financial_info_id;
				$this->finacialInfo[$newrow]['indicator_name'] 					= 	$finacialRow->codelist_value;
				$this->finacialInfo[$newrow]['indicator_value'] 				= 	"0.00";
				$this->finacialInfo[$newrow]['currency'] 						= 	"";
				$this->finacialInfo[$newrow]['expression'] 						= 	$finacialRow->expression;
				$this->finacialInfo[$newrow]['codelist_code'] 					= 	$finacialRow->codelist_code;
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
	
	public function getBorrowerProfileCommentsReply($bor_id) {
		
		
		if($bor_id	==	null){
			$current_user_id	=	$this->getCurrentuserID();
		}else{
			$current_user_id	=	$this->getUseridByBorrowerID($bor_id);
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
	
	public function getOpenCommentsCount($bor_id) {
		
		
		if($bor_id	==	null){
			$current_user_id	=	$this->getCurrentuserID();
		}else{
			$current_user_id	=	$this->getUseridByBorrowerID($bor_id);
		}
		
		$comments_sql			= 	"	SELECT 	count(profile_comments_id) cnt
										FROM 	profile_comments
										WHERE	user_id	=	{$current_user_id}
										AND		comment_status	=".BORROWER_COMMENT_OPEN;
				
		$this->comments_count	=	$this->dbFetchOne($comments_sql);	
	}
	
	public function saveComments($commentRows,$borrowerId) {
		
		if($this->getUserType()	==	USER_TYPE_ADMIN) {	
			$this->saveCommentsByAdmin($commentRows,$borrowerId);
		}else{
			$this->saveCommentsByBorrower($commentRows,$borrowerId);
		}
		return 1;
	}
	public function saveCommentsByAdmin($commentRows,$borrowerId) {
		
		$numRows = count($commentRows['comment_status_hidden']);
		$rowIndex = 0;
		$userID		=	$this->getUseridByBorrowerID($borrowerId);
		$userType	=	USER_TYPE_BORROWER;
		if($numRows	>	0){
			
			for ($rowIndex = 0; $rowIndex < $numRows; $rowIndex++) {
				
				$comment_status				= 	$commentRows['comment_status_hidden'][$rowIndex];
				$comment_id					= 	$commentRows['comment_id_hidden'][$rowIndex];
				$comment_reply_id			=	$commentRows['comments_reply_id'][$rowIndex];
				
				$comments					= 	$commentRows['comments'][$rowIndex];
				$input_tab					= 	$commentRows['input_tab'][$rowIndex];
				// Construct the data array
				$dataArray = array(	
								'user_type' 				=> $userType,
								'user_id'					=> $userID,
								'input_tab'	 				=> $input_tab,
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
	
	public function saveCommentsByBorrower($commentRows,$borrowerId) {
		
		$numRows = count($commentRows['comment_status_hidden']);
		$rowIndex = 0;
		$userID		=	$this->getUseridByBorrowerID($borrowerId);
		$userType	=	USER_TYPE_BORROWER;
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
	public function updateBorrowerGrade($postArray,$borrowerId) {
		$this->getBorrowerCompanyInfo($borrowerId);

		$this->setAuditOn("Borrower Profile", "Update Risk Grade", "Update Borrower Risk Grade",
								"business_name", $this->business_name);
		
		$dataArray = array(	'borrower_risk_grade' 	=>	$postArray['grade'] );
		$whereArry	=	array("borrower_id" =>"{$borrowerId}");
		$this->dbUpdate('borrowers', $dataArray, $whereArry);
		return $borrowerId;
	}
	
	public function updateBorrowerStatus($dataArray,$borrowerId,$status=null) {
		
		$this->getBorrowerCompanyInfo($borrowerId);
		
		$whereArry			=	array("borrower_id" =>"{$borrowerId}");
		$moduleName			=	"Borrower Profile";
		switch ($status) {
			case "approve":
				$actionSumm =	"Approval";
				$actionDet  =	"Borrower Profile Approval";
				$slug_name	=	"borrower_profile_approved";
				break;
				
			case "return_borrower":
				$actionSumm =	"Comments by Admin";
				$actionDet  =	"Profile return back to Borrower with comments";
				$slug_name	=	"borrower_profile_return_to_borrower";
				break;

			case "reject":
				$actionSumm =	"Profile Rejected";
				$actionDet  =	"Borrower Profile Rejected";
				$slug_name	=	"borrower_profile_reject";
				break;

			case "delete":
				$actionSumm =	"Profile Deleted";
				$actionDet  =	"Borrower Profile Deleted";
				$slug_name	=	"borrower_profile_inactive";
				break;
			
			default:
				$actionSumm =	"Submitted for Approval";
				$actionDet  =	"Profile submitted for approval";
				$slug_name	=	"";
				break;
		}
		
		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"business_name", $this->business_name);
								
		$this->dbUpdate('borrowers', $dataArray, $whereArry);		
						
		$approval_datatime	= 	date("Y-m-d H:i:s");					
		$dataArray			=	array("approval_datetime"=>$approval_datatime);		
		$this->dbUpdate('borrowers', $dataArray, $whereArry);
		
		$bordataArray			=	array("verified_status" =>1);
		$borwhereArry			=	array("borrower_id" =>"{$borrowerId}");
		$this->dbUpdate('borrower_banks', $bordataArray, $borwhereArry);
		
		$borrUserInfo		=	$this->getBorrowerIdByUserInfo($borrowerId);
		$borrInfo			=	$this->getBorrowerInfoById($borrowerId);
		$moneymatchSettings = 	$this->getMailSettingsDetail();
		$fields 			= 	array('[borrower_contact_person]','[application_name]');
		$replace_array 		= 	array();
		$replace_array 		= 	array( $borrInfo->contact_person, $moneymatchSettings[0]->application_name);
		$this->sendMailByModule($slug_name,$borrUserInfo->email,$fields,$replace_array);
		return $borrowerId;
	}
	
	public function updateBulkBorrowerStatus($postArray,$processType) {
		
		switch($processType){
			case	"approve":
					$dataArray = array(	'status' 	=>	BORROWER_STATUS_VERIFIED );
					$status	=	"approve";
					break;
			case	"delete":
					$dataArray = array(	'status' 	=>	BORROWER_STATUS_DELETED );
					$status	=	"delete";
					break;
			case	"reject":
					$dataArray = array(	'status' 	=>	BORROWER_STATUS_REJECTED );
					$status	=	"reject";
					break;
		}
		foreach($postArray['borrower_ids'] as $borRow) {
			$this->updateBorrowerStatus($dataArray,$borRow,$status);
		}
		return 1;
	}
	
	public function getBorrowerBankInfo($bor_id) {
		
		
		if($bor_id	==	null){
			$bor_id	=	$this->getCurrentBorrowerID();
		}
		
		$sql= "	SELECT 	borrower_banks.borrower_bankid,
						borrower_banks.bank_name,
						borrower_banks.branch_code,
						borrower_banks.bank_account_number,
						borrower_banks.verified_status,
						borrower_banks.bank_code,
						borrower_banks.bank_statement_url
				FROM 	borrower_banks
				WHERE	borrower_banks.borrower_id	=	{$bor_id}
				AND		borrower_banks.active_status = 1";
		
		$result		= $this->dbFetchAll($sql);
		
		if ($result) {
		
			$vars = get_object_vars ( $result[0] );
			foreach($vars as $key=>$value) {
				$this->{$key} = $value;
			}
			$this->bank_info_complete	=	1;
		}
	}
	
	public function updateFinancialDoc($borrowerId,$postArray){
		
		$fileUploadObj		=	new FileUpload();
		$updateAttachment	=	false;
		$destinationPath 	= 	Config::get('moneymatch_settings.upload_bor');
		$updateDataArry		=	array();
		if(!isset( $postArray['financial_doc_url'] ) ) {
			return;	
		}
		
		$fin_doc = $postArray['financial_doc_url'];
		$dataArray = array('financial_doc_url' => $fin_doc);
		
		if(isset($postArray['financial_doc_url'])){
			if(isset($postArray['financial_doc_hidden']) && $postArray['financial_doc_hidden']!=''){
				$filePath		=	$postArray['financial_doc_hidden'];
				$fileUploadObj->deleteFile($filePath);
			}
			unset($prefix);
			unset($filename);
			unset($newfilename);
			unset($file);
			
			$file			=	$postArray['financial_doc_url'];
			$filePath		=	$destinationPath."/".$borrowerId;
			$prefix			=	"FNLRO_";
			$fileUploadObj->createIfNotExists($filePath);
			//~ echo $filePath; die;
			$finan_doc_url								=	$fileUploadObj->storeFile($filePath ,$file,$prefix);
			$updateDataArry["financial_doc_url"]		=	$finan_doc_url;
			$updateAttachment							=	true;
		}
		
		if($updateAttachment) {
			$whereArray	=	["borrower_id" 	=> $borrowerId];
			$this->dbUpdate("borrowers", $updateDataArry, $whereArray);
		}
		$this->successTxt	= "Borrower Financial Document Updated Successfully";
		
	}
}
