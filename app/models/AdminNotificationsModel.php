<?php namespace App\models;
use Log;
use DB;

class AdminNotificationsModel extends TranWrapper { 
	 
	// Insert new notification to notifications table on DB
	public function addNotification($dataArray,$userID) {
				/*************Audit INSERT AND UPDATE****************/			
				$usernameSql	=	"SELECT username FROM users where user_id IN ({$userID})"; 				
				$username		= 	$this->dbFetchAll($usernameSql);				
				
				foreach($username	as $row){
					$usernam[] = $row->username;
				}
				$usernames = implode(',',$usernam);				
								
				$moduleName	=	"Bulk Notification";
				/*************Audit INSERT AND UPDATE****************/
				if(isset($dataArray['notificationId'])){
						$actionSumm =  "Update";
						$actionDet  =  "Update Notification Content";
					
						$whereArray['notification_id'] = $dataArray['notificationId'];
						unset($dataArray['notificationId']);
						
						$this->setAuditOn($moduleName, $actionSumm, $actionDet,
									"username", $usernames);                    //audit update
								
						$this->dbUpdate('notifications', $dataArray, $whereArray);
				}else{
						$actionSumm =  "Add";
						$actionDet  =  "Add Notification Content";
						
						$this->setAuditOn($moduleName, $actionSumm, $actionDet,
									"username", $usernames);					//audit insert
									
					return 	$this->dbInsert("notifications",$dataArray,1); 
				}
	}
	 
	 // Insert notification with user in notification users table on DB
	public function addNotificationUsers($dataArray,$userid) {
						
						/****************************Audit INSERT********************************/
						$usernameSql	=	"SELECT username FROM users where user_id IN ({$userid})"; 				
						$username		= 	$this->dbFetchAll($usernameSql);				
						
						foreach($username	as $row){
							$usernam[] = $row->username;
						}
						$usernames = implode(',',$usernam);
						
						$moduleName		=  "Bulk Notification";
						$actionSumm 	=  "Add";
						$actionDet  	=  "Add Notification Users";
						
						$this->setAuditOn($moduleName, $actionSumm, $actionDet,
									"username", $usernames);			//audit insert
						/****************************Audit INSERT********************************/
			return $this->dbInsert("notification_users",$dataArray,2); 
	} 
	
	 
	 // Insert notification with user in notification users table on DB
	public function deleteNotification($Id) {
			$where["notification_id"]=$Id;
			/****************************Audit DELETE********************************/
			$moduleName	=  "Bulk Notification";
			$actionSumm =  "Delete";
			$actionDet  =  "Delete Notification Content";
			
			$useridSql 	= 	"SELECT user_id from notification_users where notification_id = ({$Id})";			
			$userid		= 	$this->dbFetchAll($useridSql);				
			
			foreach($userid	as $row){
				$userID[] = $row->user_id;
			}
			$userids = implode(',',$userID);	
			
			$usernameSql 	= 	"SELECT username from users where user_id IN ({$userids})";
			$username		= 	$this->dbFetchAll($usernameSql);	
						
			foreach($username	as $row){
				$userName[] = $row->username;
			}
			$userNames = implode(',',$userName);
					
			$this->setAuditOn($moduleName, $actionSumm, $actionDet,
						"username", $userNames);				            //audit delete
			/****************************Audit DELETE********************************/			
			$this->dbDelete("notifications", $where);
			$this->dbDelete("notification_users", $where);
	}
		
	//  Check if notifiction users exist
	public function deleteNotMatchedReceipients($nId,$userIds) {
		/****************************Audit DELETE********************************/	
				$moduleName	=  "Bulk Notification";
				$actionSumm =  "Delete";
				$actionDet  =  "Delete Notification Recipients";
				
				$usernameSql 	= 	"SELECT username from users where user_id IN ({$userIds})";
				$username		= 	$this->dbFetchAll($usernameSql);	
							
				foreach($username	as $row){
					$userName[] = $row->username;
				}
				$userNames = implode(',',$userName);
						
				$this->setAuditOn($moduleName, $actionSumm, $actionDet,
							"username", $userNames);		       // audit delete
		/****************************Audit DELETE********************************/	
				$notificationSql	=" DELETE FROM notification_users  WHERE notification_id={$nId} AND user_id NOT IN ({$userIds})"; 
				$result				= 	$this->dbFetchAll($notificationSql);
				return $result;
	}
	
	//  Check if notifiction users exist
	public function updateStatus($Id,$status) {
		
				$dataArray['status']=$status;
				$where['notification_id']=$Id;
				/*************Audit UPDATE****************/
				$moduleName	=  "Bulk Notification";
				$actionSumm =  "Update";
				$actionDet  =  "Update Notification Status";
				
				$useridSql 	= 	"SELECT user_id from notification_users where notification_id = ({$Id})";			
				$userid		= 	$this->dbFetchAll($useridSql);				
				
				foreach($userid	as $row){
					$userID[] = $row->user_id;
				}
				$userids = implode(',',$userID);	
								
				$usernameSql	=	"SELECT username FROM users where user_id IN ({$userids})"; 				
				$username		= 	$this->dbFetchAll($usernameSql);				
				
				foreach($username	as $row){
					$usernam[] = $row->username;
				}
				$usernames = implode(',',$usernam);	
				
				$this->setAuditOn($moduleName, $actionSumm, $actionDet,
									"username", $usernames);                 //audit update
				/*************Audit UPDATE****************/		
				return $this->dbUpdate('notifications', $dataArray, $where); 
	}
	
	//  Update status user notification status
	public function updateUserNotificationStatus($Id,$userId,$status,$whereCon=array()) {
						
				$dataArray['notification_user_status']	=	$status;
				$dataArray['notification_read_datetime']	=	date("Y-m-d H:i:s");
				 
				if(!empty($Id)){
					$where['notification_user_id']		=	$Id;
				}
				if(!empty($userId)){
					$where['user_id']		=	$userId;
				} 
				if(isset($whereCon['id'])){
					$where['notification_id']	=	$whereCon['id'];
				} 
				if(isset($whereCon['status'])){
					$where['notification_user_status']	=	$whereCon['status'];
				} 
				/*************Audit UPDATE****************/
				$moduleName	=  "Bulk Notification";
				$actionSumm =  "Update";
				$actionDet  =  "Update Notification User Status";
				
				$usernameSql	=	"SELECT username FROM users where user_id IN ({$userId})"; 				
				$username		= 	$this->dbFetchAll($usernameSql);				
				
				foreach($username	as $row){
					$usernam[] = $row->username;
				}
				$usernames = implode(',',$usernam);	
				
				$this->setAuditOn($moduleName, $actionSumm, $actionDet,
									"username", $usernames);			//audit update
				/*************Audit UPDATE****************/				
				return $this->dbUpdate('notification_users', $dataArray, $where);  
	}
	
	//  Update status user notification status based on notification table
	public function updateUserNotificationsList($userId) {
				$selectNotifications	 = "SELECT n.notification_id ID FROM notifications n
														left outer join notification_users un
														ON un.notification_id = n.notification_id
														WHERE un.user_id = {$userId} AND n.status = 2";
				$listNotification		= 	$this->dbFetchAll($selectNotifications);
			 
				foreach($listNotification as $notification){
						$this->updateUserNotificationStatus('',$userId,2,array("id"=>$notification->ID,"status"=>1));
				} 
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
					$this->updateStatus( $notification->notification_id,2);
				}
			}
	} 
	 
	
}
