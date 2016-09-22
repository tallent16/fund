<?php 
namespace App\Http\Controllers;
use	\App\models\AdminNotificationsModel;
use Request;

class AdminNotificationsController extends MoneyMatchController {

	public function __construct() {
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->notificationsModel	=	new AdminNotificationsModel;
	}
	
	public function indexAction(){
		if(Request::isMethod('post')){
			$postCon = Request::all(); 
			
			$insertData['notification_content']	= $postCon['message'];
			$insertData['status']	= 2; 
			//check send now or later
			if(isset($postCon['sendTime']) && !empty($postCon['sendTime'])){
				$insertData['notification_datetime']	= $postCon['sendTime']; 
				$insertData['status']	= 1;
			}
			
			//insert notifications to  database notifictions table
			// $notificationID = $this->notificationsModel->addNotification($insertData); 
			$insertReceipient['notification_id']	=	1; 
			$insertReceipient['user_id']				=	198;
			$insertReceipient['notification_user_status']	=	1; 
			$this->notificationsModel->addNotificationUsers($insertReceipient); 
			//insert each notifications users to notification_users table
			foreach($postCon['receipients'] as $receipientID){
				
			}
			die;
		}
		return view('admin.admin-broadcastNotifications')->with(array("classname"=>"fa fa-users fa-fw"));
	}
	
	//Get broadcast receipients
	public function getReceipientsAction(){
			$postData = Request::all(); 
			$receipient = array();
			if(count($postData)){
				$receipient = $this->notificationsModel->getReceipients($postData['user']);  
			} 
			return $receipient;
	}
	 

}
