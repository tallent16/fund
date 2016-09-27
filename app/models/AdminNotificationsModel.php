<?php namespace App\models;
use Log;
use DB;

class AdminNotificationsModel extends TranWrapper { 
	 
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
	public function addNotificationUsers($dataArray) {
			return $this->dbInsert("notification_users",$dataArray,2); 
	} 
	
	 
	 // Insert notification with user in notification users table on DB
	public function deleteNotification($Id) {
			$where["notification_id"]=$Id;
			$this->dbDelete("notifications", $where);
			$this->dbDelete("notification_users", $where);
	}
		
	//  Check if notifiction users exist
	public function deleteNotMatchedReceipients($nId,$userIds) {
				$notificationSql	=" DELETE FROM notification_users  WHERE notification_id={$nId} AND user_id NOT IN ({$userIds})"; 
				$result				= 	$this->dbFetchAll($notificationSql);
				return $result;
	}
	
	//  Check if notifiction users exist
	public function updateStatus($Id) {
				$dataArray['status']=2;
				$where['notification_id']=$Id;
				return $this->dbUpdate('notifications', $dataArray, $where); 
	}
	
	//  Update status user notification status
	public function updateUserNotificationStatus($Id,$status,$whereStatus='') {
				$dataArray['notification_user_status']	=	$status;
				$dataArray['notification_read_datetime']	=	date("Y-m-d H:i:s");
				if(!empty($Id)){
					$where['notification_user_id']		=	$Id;
				}
				if(!empty($whereStatus)){
					$where['notification_user_status']	=	$whereStatus;
				} 
				return $this->dbUpdate('notification_users', $dataArray, $where); 
	}
	
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
	
	// Get all broadcast notifications list from notifiction table
	public function getAllNotifications($id=null,$status=null,$dateCheck=null) {
				$notificationSql	=	"SELECT notification_id,notification_content,notification_datetime,IF(status=1,'Pending','Sent') status FROM notifications"; 
				 
				 $notificationSql.=" WHERE 1=1 ";
				if(!empty($id)){
						$notificationSql.=" AND notification_id={$id}"; 
				}
			 
				if(!empty($status)){
						$notificationSql.=" AND status={$status}";
				}
			 
				if(!empty($dateCheck)){
						$notificationSql.=" AND notification_datetime <= now() ";
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
	
	// Get user broadcast notifications list from notifiction  and user notification table
	public function getUserNotifications($userID,$status) {
				$notificationSql	="SELECT * from notification_users nu
												LEFT OUTER JOIN notifications n
												ON n.notification_id = nu.notification_id
												where nu.user_id = {$userID}  
												AND nu.notification_user_status = {$status}
												AND n.status = 2";
				
				$result				= 	$this->dbFetchAll($notificationSql);	
				return $result;
	}
	 
	//  Check if notifiction users exist
	public function checkRecipients($nId,$userId) {
				$notificationSql	=" SELECT if(count(1) = 1,1,0) flag FROM notification_users WHERE  notification_id={$nId} AND  user_id = {$userId}"; 
				$result				= 	$this->dbFetchAll($notificationSql);
				return $result;
	}
	 
	// Cron job send mail
	public function cronBroadcastNotifications() {
			$notifications = $this->getAllNotifications('',1,1);
			if(count($notifications)>0){ 
				foreach($notifications as $notification){
					$this->updateStaus( $notification->notification_id);
				}
			}
	} 
	 
	
}
