<?php 
namespace App\models;
use Mail;
use Auth;
use fileupload\FileUpload;
use File;
use Hash;
use Illuminate\Support\Facades\Log;
class TranWrapper extends MoneyMatchModel {
	public  $isCronJobRunning	=	false;	
	public function __construct() {
		$this->getAllSystemSettings();
		$this->getAllSystemMessages();
	}
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
	
	public function getUserName($userType, $userId) {
		switch ($userType) {
			case 'Investor':
				$where = " ( select user_id from investors where investor_id = $userId )";
				break;
				
			case 'Borrower':
				$where = " ( select user_id from borrowers where borrower_id = $userId )";
				break;
				
			case 'User':
				$where = $userId;
				break;
				
		}
			
		$sql	=	" select username from users where user_id = $where ";
		$username = $this->dbFetchOne($sql);	
		return $username;
	}
	
	public function sendMailByModule($slug,$toEmailAddress,$fieldArray,$replaceArray) {
		
		if( $slug !=	"") {
			$sendMail	=	$this->getSystemMessageBySlug($slug,"send_email");
			if($sendMail) {
				$emailSettings 		= $this->getEmailMessagesBySlug($slug);
				$moneymatchSettings = $this->getMailSettingsDetail();
				
				$mailContents		= $emailSettings[0]->email_content;
				$mailSubject		= $emailSettings[0]->email_subject;
				
				$new_content 		= str_replace($fieldArray, $replaceArray, $mailContents);
				$new_subject 		= str_replace($fieldArray, $replaceArray, $mailSubject);				
				$new_content		= str_replace('[application_name]', $moneymatchSettings[0]->application_name, $new_content);
				$new_subject		= str_replace('[application_name]', $moneymatchSettings[0]->application_name, $new_subject);
				
				if( strpos($new_content, '[LOGO]') !== false ) {
					$logo	=	$this->getEmailLogo();	
					$msgarray = array(
									"content" =>str_replace('[LOGO]', $logo, $new_content ) 
								);											
				}else{											
					$msgarray = array(
								"content" => $new_content);
				}
				
				
				
				$msgData = array(	"subject" => $new_subject, 
									"from" => $moneymatchSettings[0]->admin_email,
									"from_name" => $moneymatchSettings[0]->application_name,
									"to" => $toEmailAddress,
									"cc" => $moneymatchSettings[0]->mail_cc_to,
									"live_mail" => $moneymatchSettings[0]->send_live_mails,
									"template"=>"emails.emailTemplate");
									
				$mailArry	=	array(	"msgarray"=>$msgarray,
										"msgData"=>$msgData);
										
				$this->sendMail($mailArry);
			}
		}
	}
	public function sendMail($postArray) {
		
			//~ $email		=	$postArray['email'];
			//~ $subject	=	$postArray['subject'];
			//~ $template	=	$postArray['template'];
			
				$msgarray	=	$postArray['msgarray'];
				$msgData	=	$postArray['msgData'];
				
			\Mail::send($msgData['template'], $msgarray, 
				function($message) use ($msgData) {
					if ($msgData['live_mail'] == 1){ 
						$message->to($msgData['to']);
					} else {
						$message->to($msgData['from']);
					}
		
					$message->from($msgData['from'], $msgData['from_name']);
					if(isset($msgData['cc'])){
						$email_cc_arr = explode(",", $msgData['cc']); 
						$message->cc($email_cc_arr);
					}
					$message->subject($msgData['subject']);
			});
			
			//~ \Mail::send($template, $postArray, function($message) use ($email,$subject) {
				
				//~ $message->to($email)->subject($subject);
			//~ });
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
		$this->dbUpdate('users', array('status' => USER_STATUS_VERIFIED,'email_verified' => USER_EMAIL_VERIFIED), $whereArry);
	}
	 
	public function getCurrentuserID() { 
		
		try{
			
			if($this->isCronJobRunning) {
				$retval ='214'; 
			}else{
					$retval = Auth::user()->user_id;   
			}
		}catch( \Exception  $e )  { 
			$retval ='214';
		}
		
		 return $retval;
	}
	
	
	public function getUserType() {
		if (Auth::check()) {
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
					
		} else {
			return 0;
		}
		
		

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
		
		if (isset(Auth::user()->user_id)) {
			$user_id	=	Auth::user()->user_id;
			
			$sql= "	SELECT 	investor_id
					FROM 	investors 
					WHERE 	user_id = '".$user_id."'";
			
			$result 	= $this->dbFetchAll($sql);
		}
		
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
							FROM	business_organisations  
							WHERE	bo_borrowing_allowed	=	1";
		
		
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
		
		$finacialRatio_sql		= 	"	SELECT 	borrower_financial_ratios_id,
												ratio_name,
												ratio_value_current_year current_ratio,
												ratio_value_previous_year previous_ratio
										FROM 	borrower_financial_ratios
										WHERE	borrower_id	=	{$borrwerID}";
		
		
		$finacialRatio_rs		= 	$this->dbFetchAll($finacialRatio_sql);
		return $finacialRatio_rs;
	}
	
	public function getFinacialList($borrwerID) {
		
		$finacial_sql	= 	"	SELECT 	borrower_financial_info_id,
										indicator_name,
										IFNULL(ROUND(indicator_value,2),'') indicator_value,
										currency,
										( 	SELECT	expression 
											FROM	codelist_details
											WHERE	codelist_id = 14
											AND		codelist_code = ref_codelist_code
										) expression,
										ref_codelist_code codelist_code
								FROM 	borrower_financial_info
								WHERE	borrower_id	=	{$borrwerID}";
		
		
		$finacial_rs	= 	$this->dbFetchAll($finacial_sql);
		return $finacial_rs;
	}
	
	
	public function getCodeListFinacialRatio() {
		
		$finacialRatio_sql		= 	"	SELECT	0 borrower_financial_ratios_id,
												codelist_id,
												codelist_code,
												codelist_value,
												expression
										FROM	codelist_details
										WHERE	codelist_id = 13";
		
		
		$finacialRatio_rs		= 	$this->dbFetchAll($finacialRatio_sql);
		return $finacialRatio_rs;
	}
	
	public function getCodeListFinacial() {
		
		$finacial_sql	= 	"	SELECT	0 borrower_financial_info_id,
										codelist_id,
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
	
	public function checkLoanDocumentUpdate($loan_doc_id,$loan_id) {
		
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	loan_docs_submitted 
					WHERE 	loan_doc_id = '".$loan_doc_id."' 
					AND 	loan_id ={$loan_id}";
				
		$cnt 	= $this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function getUseridByBorrowerID($bor_id) {
		
		
		$sql= "	SELECT 	user_id
				FROM 	borrowers 
				WHERE 	borrower_id= '".$bor_id."'";
		
		$result 	= $this->dbFetchAll($sql);
		
		if(isset($result[0])) {
			$user_id = $result[0]->user_id;
		}else{
			$user_id = 0;
		}
		return $user_id;
	}
	
	public function CheckBorrowerExists($bor_id)	{
		
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	borrowers 
					WHERE 	borrower_id = '".$bor_id."'";
		$cnt 	=	$this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function getBorrowerProfileStatus($bor_id) {
		
		
		$sql= "	SELECT 	status
				FROM 	borrowers 
				WHERE 	borrower_id= '".$bor_id."'";
		
		$result 	= $this->dbFetchAll($sql);
		
		if(isset($result[0])) {
			$status = $result[0]->status;
		}else{
			$status = 0;
		}
		return $status;
	}
	
	public function getBorrowerActiveLoanStatus($bor_id) {
		
		$argArray		=	[
							"approved" => LOAN_STATUS_APPROVED,
							"closed" => LOAN_STATUS_CLOSED_FOR_BIDS,
							"disbursed" => LOAN_STATUS_DISBURSED,
							"repaid" 	=> LOAN_STATUS_LOAN_REPAID
							];
		$activeloan_sql	= "	SELECT 	COUNT(loans.loan_id) active_loan
							FROM 	loans 
							WHERE 	loans.status IN (:approved, :closed,:disbursed,:repaid)
							AND 	loans.borrower_id ={$bor_id}";
		
		$result 		= 	$this->dbFetchWithParam($activeloan_sql,$argArray);
		
		if(isset($result[0])) {
			$active_loan = $result[0]->active_loan;
		}else{
			$active_loan = 0;
		}
		return $active_loan;
	}
	
	public function getBorrowerIdByUserInfo($borrowerId) {
		
		
		$borruser_sql		= "	SELECT 	user_id,
										username,
										email,
										firstname,
										lastname
								FROM 	users 
								WHERE 	user_id =(
													SELECT 	user_id
													FROM	borrowers
													WHERE	borrower_id={$borrowerId}
												)
								";
		
		$borruser_rs 		= 	$this->dbFetchAll($borruser_sql);
		
		return $borruser_rs[0];
	}
	
	public function getUseridByInvestorID($inv_id) {
		
		
		$sql= "	SELECT 	user_id
				FROM 	investors 
				WHERE 	investor_id= '".$inv_id."'";
		
		$result 	= $this->dbFetchAll($sql);
		
		if(isset($result[0])) {
			$user_id = $result[0]->user_id;
		}else{
			$user_id = 0;
		}
		return $user_id;
	}
	
	public function CheckInvestorExists($inv_id)	{
		
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	investors 
					WHERE 	investor_id = '".$inv_id."'";
		$cnt 	=	$this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function getInvestorProfileStatus($inv_id) {
		
		
		$sql= "	SELECT 	status
				FROM 	investors 
				WHERE 	investor_id= '".$inv_id."'";
		
		$result 	= $this->dbFetchAll($sql);
		
		if(isset($result[0])) {
			$status = $result[0]->status;
		}else{
			$status = 0;
		}
		return $status;
	}
	
	public function getInvestorActiveLoanStatus($inv_id) {
		
		$argArray		=	[
							"bid_open" => LOAN_BIDS_STATUS_OPEN,
							"bid_accepted" => LOAN_BIDS_STATUS_ACCEPTED,
							"repayment_complete" => LOAN_STATUS_LOAN_REPAID
							];
		$activeloan_sql	= "	SELECT 	COUNT(*) active_loan
							FROM 	loan_bids,
									loans
							WHERE 	(loan_bids.bid_status = (:bid_open) 
										OR loan_bids.bid_status = (:bid_accepted))
							AND 	loans.status != (:repayment_complete)
							AND 	loan_bids.investor_id = {$inv_id}
							AND		loan_bids.loan_id	=	loans.loan_id";
		
		$result 		= 	$this->dbFetchWithParam($activeloan_sql,$argArray);
		
		if(isset($result[0])) {
			$active_loan = $result[0]->active_loan;
		}else{
			$active_loan = 0;
		}
		return $active_loan;
	}
	
	public function getInvestorIdByUserInfo($investorId) {
		
		
		$invuser_sql		= "	SELECT 	user_id,
										username,
										email,
										firstname,
										lastname
								FROM 	users 
								WHERE 	user_id =(
													SELECT 	user_id
													FROM	investors
													WHERE	investor_id={$investorId}
												)
								";
		
		$invuser_rs 		= 	$this->dbFetchAll($invuser_sql);
		
		return $invuser_rs[0];
	}
	
	public function CheckLoanExists($loan_id)	{
		
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	loans 
					WHERE 	loan_id = '".$loan_id."'";
		$cnt 	=	$this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function getloanInstallmentIds($repayment_schedule_id) {
		
		$repayment_sql			= 	"	SELECT	loan_id,
												installment_number
										FROM	borrower_repayment_schedule
										WHERE	repayment_schedule_id = {$repayment_schedule_id}";
		
		
		$repayment_rs			= 	$this->dbFetchAll($repayment_sql);
		return $repayment_rs;
	}
	
	public function getInvestorAvailableBalanceById($investor_id) {
		
		$investorAvbal_sql			= 	"	SELECT 	IFNULL(ROUND(available_balance,2),0) available_balance
											FROM 	investors
											WHERE	investor_id	=	{$investor_id}";
		
		
		$investorAvbal_rs			= 	$this->dbFetchOne($investorAvbal_sql);
		return $investorAvbal_rs;
	}
	
	public function getInvesorBankTransInfoById($trans_id) {
		
		$invBankTran_sql			= 	"	SELECT	investor_id,
													payment_id,
													trans_amount,
													entry_date,
													trans_date
											FROM	investor_bank_transactions
											WHERE	trans_id = {$trans_id}";
		
		
		$invBankTran_rs				= 	$this->dbFetchAll($invBankTran_sql);
		return $invBankTran_rs;
	}
	
	public function getBorrowerInfoById($borrowerId) {
		
		
		$borr_sql		= "	SELECT 	*
							FROM	borrowers
							WHERE	borrower_id={$borrowerId}";
		
		$borr_rs 		= 	$this->dbFetchAll($borr_sql);
		
		return $borr_rs[0];
	}
	
	public function getInvestorInfoById($investorId) {
		
		
		$inv_sql		= "	SELECT 	*
							FROM	investors
							WHERE	investor_id={$investorId}";
		
		$inv_rs 		= 	$this->dbFetchAll($inv_sql);
		
		return $inv_rs[0];
	}
	
	public function getMailSettingsDetail(){
		
		$moneymatch_sql	= "	SELECT 	*
							FROM 	system_settings";
				
		$moneymatch_rs = $this->dbFetchAll($moneymatch_sql);
		return $moneymatch_rs;
	}
	
	public function getEmailLogo(){
		
		$logo_sql		= "	SELECT 	email_logo
							FROM 	system_settings";
				
		$logo_rs 		= $this->dbFetchOne($logo_sql);
		
		$logo_url		= url()."/".$logo_rs;
		
		return '<img src="'.$logo_url.'"><br>';
	}
	
	public function getRoleNameById($role_id)	{
		
		$sql= "	SELECT 	name
				FROM 	roles 
				WHERE 	id= '".$role_id."'";
		
		$result 	= $this->dbFetchAll($sql);
		
		if(isset($result[0])) {
			$name = $result[0]->name;
		}else{
			$name = "";
		}
		return $name;
	}
	
	public function CheckRoleName($roleName)	{
		
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	roles 
					WHERE 	name = '".$roleName."'";
		$cnt 	=	$this->dbFetchOne($sql);
		return ($cnt == 0)?false:true;
	}
	
	public function getSystemSettingFieldByKey($fieldKey)	{
		
		$system_settings	=	$this->getMailSettingsDetail();
		return $system_settings[0]->$fieldKey;
	}
	
	public function updateBorrowerApplyLoanStatus($loanId,$status) {
	
		$whereArry	=	array("loan_id" =>"{$loanId}");
		$dataArry	=	array("status"=>$status);
		$this->dbUpdate('loans',$dataArry , $whereArry);
	}
	
	public function checkLoanRepaymentCompleted($loanId)	{
		
		$argArray		=	[
							"unpaid" => BORROWER_REPAYMENT_STATUS_UNPAID,
							"unverified" => BORROWER_REPAYMENT_STATUS_UNVERIFIED
							];
		$sql	= "	SELECT 	count(*) cnt 
					FROM 	borrower_repayment_schedule 
					WHERE 	loan_id = '".$loanId."'
					AND		(repayment_status = (:unpaid) 
										OR repayment_status = (:unverified))";
										
		$result 		= 	$this->dbFetchWithParam($sql,$argArray);
		
		if(isset($result[0])) {
			$cnt = $result[0]->cnt;
		}else{
			$cnt = -1;
		}
		return ($cnt == 0)?true:false;
	}
	
	public function getBorrowerProfileAllAttachments($id){
		
		$bor_pro_sql	= "	SELECT 	company_image,
									company_image_thumbnail,
									acra_profile_doc_url,
									moa_doc_url,
									financial_doc_url
							FROM 	borrowers
							WHERE	borrower_id	=	{$id}";
				
		$bor_pro_rs = $this->dbFetchAll($bor_pro_sql);
		if(isset($bor_pro_rs[0])) {
			return $bor_pro_rs[0];
		}
		return 0;
	}
	
	public function getBorrowerDirAttachmentById($dir_id){
		
		$bor_dir_sql	= "	SELECT 	identity_card_front,
									identity_card_back
							FROM 	borrower_directors
							WHERE	id	=	{$dir_id}";
				
		$bor_dir_rs = $this->dbFetchAll($bor_dir_sql);
		if(isset($bor_dir_rs[0])) {
			return $bor_dir_rs[0];
		}
		return 0;
	}
	
	public function getBorrowerDirectorAttachments($borrower_id,$dir_ids){
		
		$whereDirids	=	"";
		if($dir_ids!="")
			$whereDirids	=	" AND	id	NOT IN (".implode(',',$dir_ids).")";	
		
		$bor_dir_sql	= "	SELECT 	identity_card_front,
									identity_card_back
							FROM 	borrower_directors
							WHERE	borrower_id	=	{$borrower_id}
							{$whereDirids}";
				
		$bor_dir_rs = $this->dbFetchAll($bor_dir_sql);
		if(isset($bor_dir_rs)) {
			return $bor_dir_rs;
		}
		return 0;
	}
	
	public function getBankAttachmentById($tableName,$fieldName,$condition){
		
		$bor_dir_sql	= "	SELECT 	{$fieldName}
							FROM 	{$tableName}
							WHERE	{$condition}";
		$bor_dir_rs = $this->dbFetchAll($bor_dir_sql);
		if(isset($bor_dir_rs[0])) {
			return $bor_dir_rs[0];
		}
		return 0;
	}
	
	public function getUserInfoByUserId($user_id){
		
		$user_sql	= "	SELECT 	*
							FROM 	users
							WHERE	user_id =	{$user_id}";
		$user_rs = $this->dbFetchAll($user_sql);
		if(isset($user_rs[0])) {
			return $user_rs[0];
		}
		return 0;
	}
	
	public function getBorrowerInfoByUserId($user_id){
		
		$bor_sql	= "	SELECT 	*
							FROM 	borrowers
							WHERE	user_id =	{$user_id}";
		$bor_rs = $this->dbFetchAll($bor_sql);
		if(isset($bor_rs[0])) {
			return $bor_rs[0];
		}
		return 0;
	}
	
	public function getInvestorInfoByUserId($user_id){
		
		$inv_sql	= "	SELECT 	*
							FROM 	invesstors
							WHERE	user_id =	{$user_id}";
		$inv_rs = $this->dbFetchAll($inv_sql);
		if(isset($inv_rs[0])) {
			return $inv_rs[0];
		}
		return 0;
	}
	
	public function checkPasswordByUserID($current_user_password,$current_user_id)	{
		
		return Hash::check($current_user_password, $this->getUserInfoByUserId($current_user_id)->password);
	}
	
	public function getSystemMessages($modId = '') {
		
		$where	=	"";
		if($modId	!=	'') {
			$where	=	"WHERE module_id ={$modId}";
		}
		$sql= "	SELECT 	slug_name,
						message_text
				FROM 	system_messages
				{$where}";
		
		$result		= $this->dbFetchAll($sql);
		return $result;
	}
	public function getSystemMessageBySlug($slug,$fieldName='message_text') {
		
		$sql= "	SELECT 	{$fieldName}
				FROM 	system_messages
				WHERE	slug_name ='{$slug}'";
		$result		= $this->dbFetchOne($sql);
		return $result;
	}
	
	public function prnt($postArray,$die=true) {
		echo "<pre>",print_r($postArray),"</pre>";
		if($die)
			die;
	}
		
	public function getEmailMessagesBySlug($slug='') {
		
		$where	=	"";
		if($slug	!=	'') {
			$where	=	"WHERE Slug_name ='{$slug}'";
		}
		$sql= "	SELECT 	*
				FROM 	email_notifications
				{$where}";
		
		$result		= $this->dbFetchAll($sql);
		return $result;
	}
	
	public function convertVideoUrlToEmbedeUrl($url,$wd="100%",$hg="400") {
	
	   // video url patterns(youtube, instagram, vimeo, dailymotion, youku, mp4, ogg, webm)
      $ytRegExp = "/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/";
      $ytMatchRes = preg_match($ytRegExp,$url,$ytMatch);
    
      $igRegExp = "/(?:www\.|\/\/)instagram\.com\/p\/(.[a-zA-Z0-9_-]*)/";
      $igMatchRes =  preg_match($igRegExp,$url,$igMatch);

      $vRegExp = "/\/\/vine\.co\/v\/([a-zA-Z0-9]+)/";
      $vMatchRes = preg_match($vRegExp,$url,$vMatch);

      $vimRegExp = "/\/\/(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/";
      $vimMatchRes = preg_match($vimRegExp,$url,$vimMatch);

      $dmRegExp = "/.+dailymotion.com\/(video|hub)\/([^_]+)[^#]*(#video=([^_&]+))?/";
      $dmMatchRes = preg_match($dmRegExp,$url,$dmMatch);

      $youkuRegExp = "/\/\/v\.youku\.com\/v_show\/id_(\w+)=*\.html/";
      $youkuMatchRes = preg_match($youkuRegExp,$url,$youkuMatch);

      $mp4RegExp = "/^.+.(mp4|m4v)$/";
      $mp4MatchRes = preg_match($mp4RegExp,$url,$mp4Match);

      $oggRegExp = "/^.+.(ogg|ogv)$/";
      $oggMatchRes = preg_match($oggRegExp,$url,$oggMatch);

      $webmRegExp = "/^.+.(webm)$/";
      $webmMatchRes = preg_match($webmRegExp,$url,$webmMatch);

      $video="";
     
      if ( $ytMatchRes && strlen($ytMatch[1])	=== 11) {
       $youtubeId = $ytMatch[1];
       
        $video ='<iframe frameborder="0" src="//www.youtube.com/embed/'.$youtubeId.'"' ;
        $video =$video.' width="'.$wd.'" height="'.$hg.'" ></iframe>';
      } else if ($igMatchRes && count($igMatch[0])) {
		  
		$video ='<iframe frameborder="0" src="https://instagram.com/p/'.$igMatch[1].'/embed/"' ;
        $video =$video.' width="'.$wd.'" height="'.$hg.'" scrolling="no" allowtransparency="true" ></iframe>';
        
      } else if ($vMatchRes && strlen($vMatch[0])) {
        
        $video ='<iframe frameborder="0" src="'.$vMatch[0].'/embed/simple"' ;
        $video =$video.' width="'.$wd.'" height="'.$hg.'" class="vine-embed" ></iframe>';
        
      } else if ($vimMatchRes && strlen($vimMatch[3])) {
		
		$video ='<iframe webkitallowfullscreen mozallowfullscreen allowfullscreen' ;
		$video =$video.' frameborder="0" src="//player.vimeo.com/video/'.$vimMatch[3].'"' ;
        $video =$video.' width="'.$wd.'" height="'.$hg.'" ></iframe>';
      
      } else if ($dmMatchRes && strlen($dmMatch[2])) {
        
        $video ='<iframe frameborder="0" src="//www.dailymotion.com/embed/video/'.$dmMatch[2].'"' ;
        $video =$video.' width="'.$wd.'" height="'.$hg.'" class="vine-embed" ></iframe>';
      } else if ($youkuMatchRes && strlen($youkuMatch[1])) {
		  
		$video ='<iframe webkitallowfullscreen mozallowfullscreen allowfullscreen' ;
		$video =$video.' frameborder="0" src="//player.youku.com/embed/'.$youkuMatch[1].'"' ;
        $video =$video.' width="'.$wd.'" height="'.$hg.'" ></iframe>';
      } else if ($mp4MatchRes || $oggMatchRes || $webmMatchRes) {
		
		$video	=	'<video controls src="'.$url.'"  width="'.$wd.'" height="'.$hg.'" ></video>';
      }
      
      return	$video;
	}
}
