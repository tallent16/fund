<?php namespace App\models;
use Log;
use DB;

class AdminNotificationsModel extends TranWrapper { 
	
	//Get notification receipients from users table
	public function getReceipients($userType='') {  
				$receipientSql	=	"SELECT user_id id,concat(firstname,' ',lastname) name FROM users"; 
				
				if(!empty($userType)){
					$receipientSql.= " WHERE usertype=".$userType;
				}
				$receipientSql.= " ORDER BY name";
				$result				= 	$this->dbFetchAll($receipientSql);	
				return $result;
	}
	
	// Insert new notification to notifications table on DB
	public function addNotification($dataArray) {
				if(isset($dataArray['notificationId'])){
						$whereArray['notification_id'] = $dataArray['notificationId'];
						unset($dataArray['notificationId']);
						$this->dbUpdate('notifications', $dataArray, $whereArray);
				}else{
					return 	$this->dbInsert("notifications",$dataArray,1); 
				}
	}
	 
	 // Insert notification with user in notification users table on DB
	public function deleteNotification($Id) {
			$where["notification_id"]=$Id;
			$this->dbDelete("notifications", $where);
			$this->dbDelete("notification_users", $where);
	}
	 
	 // Insert notification with user in notification users table on DB
	public function addNotificationUsers($dataArray) {
			return $this->dbInsert("notification_users",$dataArray,2); 
	} 
	
	// Get all broadcast notifications list from notifiction table
	public function getAllNotifications($id=null) {
				$notificationSql	=	"SELECT notification_id,notification_content,notification_datetime,IF(status=1,'Pending','Sent') status FROM notifications"; 
				 
				if(!empty($id)){
						$notificationSql.=" WHERE notification_id={$id}";
				}
			 
				$result	= 	$this->dbFetchAll($notificationSql);	 
				return $result;
	}
	
	// Get all broadcast notifications list from notifiction table
	public function getNotificationRecipients($Id) {
				$notificationSql	=" SELECT nUser.user_id,concat(user.firstname,' ',user.lastname) name FROM notification_users nUser 
												LEFT OUTER JOIN users user 
												ON user.user_id = nUser.user_id
												WHERE  notification_id={$Id}
												ORDER BY name";
				
				$result				= 	$this->dbFetchAll($notificationSql);	 
				return $result;
	}
	
	// Get all broadcast notifications list from notifiction table
	public function getGroupByNotificationRecipients($Id) {
				$notificationSql	=" SELECT usertype FROM notification_users nUser 
												LEFT OUTER JOIN users user 
												ON user.user_id = nUser.user_id
												WHERE  notification_id={$Id}
												Group by usertype";
				
				$result				= 	$this->dbFetchAll($notificationSql);	
				return $result;
	}
	
	//  Check if notifiction users exist
	public function checkRecipients($nId,$userId) {
				$notificationSql	=" SELECT if(count(1) = 1,1,0) flag FROM notification_users WHERE  notification_id={$nId} AND  user_id = {$userId}";
				 
				$result				= 	$this->dbFetchAll($notificationSql);
				return $result;
	}
	
	//  Check if notifiction users exist
	public function deleteNotMatchedReceipients($nId,$userIds) {
				$notificationSql	=" DELETE FROM notification_users  WHERE notification_id={$nId} AND user_id NOT IN ({$userIds})";
				 
				$result				= 	$this->dbFetchAll($notificationSql);
				return $result;
	}
	
	//  Check if notifiction users exist
	public function updateStaus($Id) {
				$dataArray['status']=2;
				$where['notification_id']=$Id;
				return $this->dbUpdate('notifications', $dataArray, $where); 
	}
	 
	
}
