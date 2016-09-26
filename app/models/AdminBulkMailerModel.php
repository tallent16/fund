<?php namespace App\models;
use Log;
use DB;

class AdminBulkMailerModel extends TranWrapper { 
	 
	// Get all broadcast notifications list from notifiction table
	public function getAllMailers($id=null) {
				$mailerSql	=	"SELECT bulk_email_id ID,mail_subject subject,mail_content body,mail_schd_datetime date,IF(mail_status=1,'Pending','Sent') status FROM bulk_emails"; 
				 
				if(!empty($id)){
						$mailerSql.=" WHERE bulk_email_id={$id}";
				}
			 
				$result	= 	$this->dbFetchAll($mailerSql);	 
				return $result;
	} 
	
	// Insert new mailer to bulk mailers table on DB
	public function addMailer($dataArray) {
				if(isset($dataArray['mailerId'])){
						$whereArray['bulk_email_id'] = $dataArray['mailerId'];
						unset($dataArray['mailerId']);
						$this->dbUpdate('bulk_emails', $dataArray, $whereArray);
				}else{
						return 	$this->dbInsert("bulk_emails",$dataArray,1); 
				}
	}
	
	// Insert new mailer to bulk mailers table on DB
	public function addMailerRecipients($dataArray) {
					return $this->dbInsert("bulk_emails_users",$dataArray,2);
	} 
	 
	  // Insert notification with user in notification users table on DB
	public function deleteMailer($Id) {
			$where["bulk_email_id"]	=	$Id;
			$this->dbDelete("bulk_emails", $where);
			$this->dbDelete("bulk_emails_users", $where);
	}
	
	//  Check if notifiction users exist
	public function updateStatus($Id) {
				$dataArray['status']			=	2;
				$where['bulk_email_id']	=	$Id;
				return $this->dbUpdate('bulk_emails', $dataArray, $where); 
	}
	
	//  Check if mailer receipient exist
	public function checkRecipients($mId,$userId) {
				$mailerSql	=" SELECT if(count(1) = 1,1,0) flag FROM bulk_emails_users WHERE  bulk_email_id={$mId} AND  user_id = {$userId}";
				 
				$result				= 	$this->dbFetchAll($mailerSql); 
				return $result;
	}
	  
	//  check mail status if it is sent or not
	public function checkMailStatus($mailId) {
				$mailerSql	=" SELECT mail_status status flag FROM bulk_emails_users WHERE  bulk_email_id={$mId}";
				$result				= 	$this->dbFetchAll($mailerSql);
				return $result;
	}
	
	
	// Get all mailer receipient list from mailer table
	public function getMailerRecipients($Id,$status='') {
				$mailerSql	=" SELECT mUser.user_id,user.email,concat(user.firstname,' ',user.lastname) name FROM bulk_emails_users mUser 
										LEFT OUTER JOIN users user 
										ON user.user_id = mUser.user_id ";
										
				$where =" WHERE mUser.bulk_email_id={$Id} ORDER BY name";
				
				$mailerSql.=$where;
				$result				= 	$this->dbFetchAll($mailerSql); 
				return $result;
	}
	
	
	//  check mail status if it is sent or not
	public function getReceipientInfo($userId) {
				$mailerSql	=" SELECT email,concat(firstname,' ',lastname) name FROM users WHERE user_id={$userId}";
				$result				= 	$this->dbFetchAll($mailerSql);
				return $result;
	}
	 
	// Get all broadcast notifications list from notifiction table
	public function getGroupByMailerRecipients($Id) {
				$notificationSql	=" SELECT usertype FROM bulk_emails_users mUser 
												LEFT OUTER JOIN users user 
												ON user.user_id = mUser.user_id
												WHERE  bulk_email_id={$Id}
												Group by usertype";
				
				$result				= 	$this->dbFetchAll($notificationSql);	
				return $result;
	} 
	
	//Send bulk mails to all receipients
	public function sendBulkMails($subject,$body,$to){
			$to=array();
			$to[] = 'muthu.openit@gmail.com';
			$mailArray['msgarray']	=	array("content"=>$body);
			
			$mailArray['msgData'] ['template']		=	'emails.emailTemplate';
			$mailArray['msgData'] ['live_mail']		=	1;
			$mailArray['msgData'] ['from']				=	'muthu.openit@gmail.com';
			$mailArray['msgData'] ['from_name']	=	'Mail Notification';
			$mailArray['msgData'] ['subject']			=	$subject;
			
			foreach($to as $toMail){
					$mailArray['msgData'] ['to']	=	$toMail;
					$this->sendMail($mailArray);
			} 
	}
	
}
