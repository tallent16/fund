<?php namespace App\models;
class AdminSettingsModel extends TranWrapper {
	
	public $settingsList	=	array();
	
	public function getGeneralSettings(){
		
		$settings_sql = "SELECT 
								application_name,
								admin_email,
								admin_email_label,
								backend_email,
								backend_email_label,
								mail_cc_to,
								send_live_mails,
								mail_driver,
								mail_host,
								mail_port,
								mail_encryption,
								mail_username,
								mail_password,
								monthly_pay_by_date,
								loan_fixed_fees,
								loan_fees_percent,
								loan_fees_minimum_applicable,
								penalty_fee_minimum,
								penalty_fee_percent,
								penalty_interest 
							FROM
								system_settings";
							
		$result			=	$this->dbFetchAll($settings_sql);
			
		$this->settingsList = 	$result;						
		
	}	
	
	public function updateGeneralSettings($postArray){
		
	//	echo "<pre>",print_r($postArray),"</pre>"; die;
		if(isset($postArray)){
			/*First Tab*/
			$application_Name 		= $postArray['application_name'];
			$mailFromAddress		= $postArray['mail_from_address'];
			$mailFromName			= $postArray['mail_from_name'];
			$backendTeamEmailAdd	= $postArray['backend_team_mailaddress'];
			$backendTeamEmailName	= $postArray['backend_team_mailname'];
			$mailCC					= $postArray['mail_cc'];
			$sendLiveMail			= isset($postArray['livemails'])?$postArray['livemails']:0;
			/*Second Tab*/
			$mailDriver 			= $postArray['mail_driver'];	
			$mailHost				= $postArray['mail_host'];	
			$mailPort				= $postArray['mail_port'];	
			$mailEncrypt			= $postArray['mail_encryption'];	
			$mailUsername			= $postArray['mail_username'];	
			$mailPassword			= $postArray['mail_password'];	
			/*Fourth Tab*/
			$loanMonthly			= $postArray['loan_monthly'];	
			$processFixedFees		= $postArray['processing_fixed_fees'];	
			$processFeePercent		= $postArray['processing_fees_percent'];	
			$processFeeMinimum		= $postArray['processing_fee_minimum'];	
			$penaltyProcessFee		= $postArray['penalty_process_fee'];	
			$penaltyProcessPercent	= $postArray['penalty_process_percent'];	
			$penaltyInterest		= $postArray['penalty_interest'];	
		}
		// Construct the data array
		$dataArray = array(	'application_name'				=> $application_Name,								
							'admin_email' 					=> $mailFromAddress,
							'admin_email_label'				=> $mailFromName,
							'backend_email'					=> $backendTeamEmailAdd,
							'backend_email_label'			=> $backendTeamEmailName,
							'mail_cc_to'					=> $mailCC,
							'send_live_mails'				=> $sendLiveMail,
							
							'mail_driver'					=> $mailDriver,
							'mail_host'						=> $mailHost,
							'mail_port'						=> $mailPort,
							'mail_encryption'				=> $mailEncrypt,
							'mail_username'					=> $mailUsername,
							'mail_password'					=> $mailPassword,
														
							'monthly_pay_by_date'			=> $loanMonthly,
							'loan_fixed_fees'				=> $processFixedFees,
							'loan_fees_percent'				=> $processFeePercent,
							'loan_fees_minimum_applicable'	=> $processFeeMinimum,
							'penalty_fee_minimum'			=> $penaltyProcessFee,
							'penalty_fee_percent'			=> $penaltyProcessPercent,
							'penalty_interest'				=> $penaltyInterest							
						);			
		//echo "<pre>",print_r($dataArray),"</pre>"; die;				
		$whereArray	=	[ "application_name"	=> $application_Name];
		$id = $this->dbUpdate('system_settings', $dataArray, $whereArray);
		if($id)		{		 
			return 	1;
		}else{
			return 	-1;
		}
	}
	
}
