<?php 
namespace App\models;
use Mail;
use Auth;
use fileupload\FileUpload;
use File;
class TranWrapper extends MoneyMatchModel {
		
	public function CheckUserName($userName)	{
		
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	users 
					WHERE 	username = '".$userName."'";
		$cnt 	=	$this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function CheckExistingUserName($userName,$id)	{
		
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	users 
					WHERE 	username = '".$userName."' 
					AND 	user_id <>".$id;
				
		$cnt 	= 	$this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function CheckUserEmail($userEmail) {
			
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	users 
					WHERE 	email = '".$userEmail."'";
				
		$cnt 	= $this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function CheckExistingUserEmail($userEmail,$id) {
		
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	users 
					WHERE 	email = '".$userEmail."' 
					AND 	user_id <>".$id;
				
		$cnt 	= $this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function sendMail($postArray) {
		
			$email		=	$postArray['email'];
			$subject	=	$postArray['subject'];
			
			\Mail::send('emails.confirmation', $postArray, function($message) use ($email,$subject) {
				
				$message->to($email)->subject($subject);
			});
	}
	
	public function checkActivationCode($code) {
		
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	users 
					WHERE 	activation = '".$code."'";
				
		$cnt 	= $this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function checkCodeStatus($code) {
		
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	users 
					WHERE 	activation = '".$code."' 
					AND 	(status = 1 OR status is NULL)";
				
		$cnt 	= 	$this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function updateCodeStatus($code) {
	
		$whereArry	=	array("activation" =>"{$code}");
		$this->dbUpdate('users', array('status' => 2,'email_verified' => 1), $whereArry);
	}
	
	public function getCurrentuserID() {
		
		return	Auth::user()->user_id;
	}
	
	public function getUserType() {
		$user_id	=	Auth::user()->user_id;
		
		$sql		=	"	SELECT 	usertype 
							FROM	users
							WHERE	user_id = {$user_id}";
		
		$result		=	$this->dbFetchAll($sql);
		
		if (count($result) > 0) {
			$userType = $result[0]->usertype;
			return $userType;
		}
		
		return -1; //Not a possibility since the user will be there in order that 
					// he is authorized to use it. so Duh!!!

	}
	
	public function getCurrentBorrowerID() {
		
		$user_id	=	Auth::user()->user_id;
		
		$sql= "	SELECT 	borrower_id
				FROM 	borrowers 
				WHERE 	user_id = '".$user_id."'";
		
		$result 	= $this->dbFetchAll($sql);
		
		if(isset($result[0])) {
			$borrower_id = $result[0]->borrower_id;
		}else{
			$borrower_id = 0;
		}
		return $borrower_id;
	}
	
	public function getCurrentInvestorID() {
		
		$user_id	=	Auth::user()->user_id;
		
		$sql= "	SELECT 	investor_id
				FROM 	investors 
				WHERE 	user_id = '".$user_id."'";
		
		$result 	= $this->dbFetchAll($sql);
		
		if(isset($result[0])) {
			$investor_id = $result[0]->investor_id;
		}else{
			$investor_id = 0;
		}
		return $investor_id;
	}

	
	
	public function getBusinessOrganisationList() {
		
		$bus_orgArry	=	array();	
		$busorg_sql 	= "SELECT	bo_id,
									bo_name,
									bo_borrowing_allowed
							FROM	business_organisations  ";
		
		
		$busorg_rs		=	$this->dbFetchAll($busorg_sql);
		$i				=	0;	
		foreach($busorg_rs as $busorgOpt){
			$bus_orgArry[$i]['bo_id']					=	$busorgOpt->bo_id;
			$bus_orgArry[$i]['bo_name']					=	$busorgOpt->bo_name;
			$bus_orgArry[$i]['bo_borrowing_allowed']	=	$busorgOpt->bo_borrowing_allowed;
			$i++;
		}
		return $bus_orgArry;
	}
	
	public function getFinacialRatioList($borrwerID) {
		
		$finacialRation_sql		= 	"	SELECT 	ratio_name,
												ratio_value_current_year current_ratio,
												ratio_value_previous_year previous_ratio
										FROM 	borrower_financial_ratios
										WHERE	borrower_id	=	{$this->borrower_id}";
		
		
		$finacialRation_rs		= 	$this->dbFetchAll($finacialRation_sql);
		return $finacialRation_rs;
	}
	
	public function getFinacialList($borrwerID) {
		
		$finacial_sql	= 	"	SELECT 	indicator_name,
										IFNULL(ROUND(indicator_value,2),'') indicator_value,
										currency
								FROM 	borrower_financial_info
								WHERE	borrower_id	=	{$borrwerID}";
		
		
		$finacial_rs	= 	$this->dbFetchAll($finacial_sql);
		return $finacial_rs;
	}
	
	
	public function getCodeListFinacialRatio() {
		
		$finacialRation_sql		= 	"	SELECT	codelist_id,
													codelist_code,
													codelist_value,
													expression
											FROM	codelist_details
											WHERE	codelist_id = 13";
		
		
		$finacialRation_rs		= 	$this->dbFetchAll($finacialRation_sql);
		return $finacialRation_rs;
	}
	
	public function getCodeListFinacial() {
		
		$finacial_sql	= 	"	SELECT	codelist_id,
													codelist_code,
													codelist_value,
													expression
											FROM	codelist_details
											WHERE	codelist_id = 14";
		
		
		$finacial_rs	= 	$this->dbFetchAll($finacial_sql);
		return $finacial_rs;
	}
	
	public function getImagePath($desitinationPath) {
		
		$fileUploadObj	=	new FileUpload();
		$imagePath		=	$fileUploadObj->getFile($desitinationPath);
		if(!$this->checkRemoteFile($imagePath)) {
			return	url()."/img/noimage.png";
		}else{
			return	$imagePath;
		}
		
	}
	
	public function checkRemoteFile($url)	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		// don't download content
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		if(curl_exec($ch)!==FALSE)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function getTimeAgo( $date ) {
		
		if( empty( $date ) ) {
			return "No date provided";
		}

		$periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");

		$lengths = array("60","60","24","7","4.35","12","10");

		$now = time();

		$unix_date = strtotime( $date );

		// check validity of date

		if( empty( $unix_date ) ) {
			return "Bad date";
		}

		// is it future date or past date

		if( $now > $unix_date ) {
			$difference = $now - $unix_date;
			$tense = "ago";
		}else {
			$difference = $unix_date - $now;
			$tense = "from now";
		}

		for( $j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++ ) {
			$difference /= $lengths[$j];
		}

		$difference = round( $difference );

		if( $difference != 1 ) {
			$periods[$j].= "s";
		}
		return "$difference $periods[$j] {$tense}";

	}
	
	public function getLoanStatus($loan_id) {
		
		$loan_sql	= "	SELECT 	status 
						FROM 	loans 
						WHERE 	loan_id = '".$loan_id."'";
				
		$loan_rs	= 	$this->dbFetchOne($loan_sql);
		return $loan_rs;
	}
	
}
