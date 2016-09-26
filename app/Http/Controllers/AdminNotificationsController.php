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
		$this->title 							= 	"Broadcast Notifications";
		$this->className					 =	"fa fa-users fa-fw";
	}

	//Create add broadcast notification page
	public function createNotifications($Id=null){
				if(Request::isMethod('post')){
							$postCon = Request::all();
							
							if(!empty($Id)){
										$insertData['notificationId']	 = $Id;
							}
							
							$insertData['notification_content']		= $postCon['message'];
							$insertData['notification_datetime']	= date("Y-m-d H:i"); 
							$insertData['status']	= 2; 
							
							//check send now or later
							if(isset($postCon['sendTime']) && !empty($postCon['sendTime'])){
										$insertData['notification_datetime']	= date("Y-m-d H:i",strtotime($postCon['sendTime'])); 
										$insertData['status']	= 1;
							}
							
							//insert notifications to  database notifictions table
							$notificationID = $this->notificationsModel->addNotification($insertData); 
							
							if(isset($insertData['notificationId'])){
										$notificationID=$insertData['notificationId'];
							}
							
							//insert each notifications users to notification_users table
							foreach($postCon['receipients'] as $receipientID){
										$checkRecords  = $this->notificationsModel->checkRecipients($notificationID,$receipientID); 	
										if(count($checkRecords) && $checkRecords{0}->flag==0){
													$insertReceipient['notification_id']	=	$notificationID; 
													$insertReceipient['user_id']				=	$receipientID;
													$insertReceipient['notification_user_status']	=	1; 
													$this->notificationsModel->addNotificationUsers($insertReceipient);
										}
										$userIds[]=$receipientID;
							}
							
							if(!empty($Id)){
								$userIds = implode(",",$userIds);
								$this->notificationsModel->deleteNotMatchedReceipients($notificationID,$userIds);
							}
							
							return redirect('admin/broadcast/notificationsList');
				}
				return view('admin.admin-broadcastNotifications')->with(array("useBlade"=>"notifications","title"=>$this->title,"classname"=>$this->className));
	}
	
	
	// Generate function for edit existing notification
	public function editNotification($Id) {
					$userList = $allReceipients=$allSelected='';
					$input=array();
					
					$groupUsers 	= $this->notificationsModel->getGroupByNotificationRecipients($Id);
			
					if(count($groupUsers)>0){
								$filter				=	$this->getFilterRecipients($groupUsers); 
								 
								if(isset($filter['users'])){
										$userList = $this->notificationsModel->getReceipients(0);
								}else{
										$userList = $this->notificationsModel->getReceipients($filter['type']);
								}
								
								foreach($userList as $data){
										if(!empty($data->name)){
											$allReceipients.="<option value={$data->id} selected>{$data->name}</option>";
										}
								}
								$mulitSelector['options'] = $allReceipients;
					}
	
					$receipientList =  $this->getNotificationRecipients($Id);
					foreach($receipientList as $value){
							if(!empty($value->name)){
								$allSelected.="<option value={$value->user_id} selected>{$value->name}</option>";
							}
					}
					$selectReceipients['options'] = $allSelected; 
					
					$notification = $this->notificationsModel->getAllNotifications($Id); 
					
					if(count($notification)>0){
								$notification			 = $notification{0};
								$input['later']			=	date("d-m-Y H:i",strtotime($notification->notification_datetime));
								$input['message']	=	$notification->notification_content;
					}
			
				return view('admin.admin-broadcastNotifications')->with(array("useBlade"=>"notifications","title"=>$this->title,"classname"=>$this->className,"filter"=>$filter,"multiSelector"=>$mulitSelector,"receipientSelector"=>$selectReceipients,"send"=>$input));
	}
	
	//Create add broadcast notification page
	public function notificationsList(){
				return view('admin.admin-notificationsList')->with(array("classname"=>$this->className));
	}
	 
	//Create add broadcast notification page
	public function deleteNotification($Id){
				$notification = $this->notificationsModel->deleteNotification($Id); 
				return redirect('admin/broadcast/notificationsList');
	}
	
	
	//Create add broadcast notification page
	public function processNotification($Id){
				$notification = $this->notificationsModel->updateStaus($Id); 
				return redirect('admin/broadcast/notificationsList');
	}
	 
	
	//Get broadcast receipients
	public function getReceipients(){
			$postData = Request::all(); 
			
			$receipient = array();
			if(count($postData)){
				$receipient = $this->notificationsModel->getReceipients($postData['userType']);
			} 
			return $receipient;
	}
	
	//Get all broadcast notifications
	public function getNotifications(){
			$notifications = array();
		 
			$notifications = $this->notificationsModel->getAllNotifications();  
			
			foreach ($notifications as $data) { 
						$row[] 	= array(
											"DT_RowId"=>$data->notification_id,
											"ID"=>$data->notification_id, 				
											"message"=>$data->notification_content	,								
											"date"=>date("d-m-Y H:i",strtotime($data->notification_datetime)),								
											"status"=>$data->status
										);	 
					}  
			return json_encode(array("data"=>$row));
	}
	
	//Get receipients for specific notification
	public function getNotificationRecipients($Id){ 
			$receipients = $this->notificationsModel->getNotificationRecipients($Id); 
			return $receipients;
	}
	
	//Get receipients for specific notification
	public function getFilterRecipients($groupUsers){ 
			$filter= array(); 
			
			if(count($groupUsers)>1){
						$filter['users']=count($groupUsers);
			}else{
						$groupUsers = $groupUsers{0};
						 
						if($groupUsers->usertype==1){
								$filter['borrowers'] = true;
								$filter['type'] = $groupUsers->usertype;
						}elseif($groupUsers->usertype==2){
								$filter['Investers']= true;
								$filter['type'] = $groupUsers->usertype;
						}elseif($groupUsers->usertype==3){
								$filter['system']= true;
								$filter['type'] = $groupUsers->usertype;
						}
			} 
			
			return $filter;
	}
	 

}
