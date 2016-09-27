<?php 
namespace App\Http\Controllers;
use	\App\models\AdminBulkMailerModel;
use	\App\models\AdminNotificationsModel;
use Request;

class AdminBulkMailersController extends AdminNotificationsController {

	public function __construct() {
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->mailersModel			=	new AdminBulkMailerModel;
		$this->notificationsModel	=	new AdminNotificationsModel;
		$this->title 							= 	"Bulk Mailer";
		$this->className					 =	"fa fa-envelope fa-fw";
	}

	//List bulk mails
	public function mailerList(){
				return view('admin.admin-bulkMalierList')->with(array("classname"=>$this->className));
	}
	
	//Get all mailers
	public function getAjaxMailersList(){
			$mailers =$row = array();
			
			$mailers = $this->mailersModel->getAllMailers();
			
			foreach ($mailers as $data) {
						$row[] 	= array(
											"DT_RowId"=>$data->ID,
											"ID"=>$data->ID,
											"subject"=>$data->subject,
											"date"=> $data->date,
											"status"=>$data->status
										);	 
					}  
			return json_encode(array("data"=>$row)); 
	}
	
	//Get receipients for specific notification
	public function getMailerRecipients($Id){
			$receipients = $this->mailersModel->getMailerRecipients($Id); 
			return $receipients;
	}
	
	//Create add broadcast notification page
	public function createBulkMails($Id=null){
				if(Request::isMethod('post')){
							$postCon = Request::all();
							$mailerStatus =1;
							
							if(!empty($Id)){
										$insertData['mailerId']	 = $Id;
										$mailerStatus = $this->mailersModel->checkMailStatus($Id); 
							}
							
							$insertData['mail_subject']		= $postCon['subject'];
							$insertData['mail_content']		= $postCon['body'];
							$insertData['mail_schd_datetime']	= date("Y-m-d H:i"); 
							$insertData['mail_status']	= 2; 
							
							//check send now or later
							if(isset($postCon['sendTime']) && !empty($postCon['sendTime'])){
										$insertData['mail_schd_datetime']	= date("Y-m-d H:i",strtotime($postCon['sendTime'])); 
										$insertData['mail_status']	= 1;
							} else{
								if($mailerStatus == 1){
										$this->mailersModel->sendBulkMails( $postCon['subject'],$postCon['body'],$postCon['receipients']);
								}
							}
							
							//insert notifications to  database notifictions table
							$mailerID = $this->mailersModel->addMailer($insertData); 
							
							//If edit Mailer to change specific mailer id 
							if(isset($insertData['mailerId'])){
										$mailerID=$insertData['mailerId'];
							}
							
							//insert each notifications users to notification_users table
							foreach($postCon['receipients'] as $receipientID){
										$checkRecords  = $this->mailersModel->checkRecipients($mailerID,$receipientID); 
										if($checkRecords{0}->flag==0){
													$insertReceipient['bulk_email_id']	=	$mailerID; 
													$insertReceipient['user_id']				=	$receipientID;
													$insertReceipient['bulk_email_user_status']	=	1; 
													$this->mailersModel->addMailerRecipients($insertReceipient);
										}
										$userIds[]=$receipientID;
							}
							
							if(!empty($Id)){
								$userIds = implode(",",$userIds);
								$this->mailersModel->deleteNotMatchedReceipients($mailerID,$userIds);
							}
							
							return redirect('admin/bulkMailer/mailList');
				}
				return view('admin.admin-broadcastNotifications')->with(array("useBlade"=>"mailers","title"=>$this->title,"classname"=>$this->className));
	}
	
	// Generate function for edit existing notification
	public function editMailer($Id) {
					$userList = $allReceipients=$allSelected='';
					$input=array();
					
					$groupUsers 	= $this->mailersModel->getGroupByMailerRecipients($Id);
			
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
	
					$receipientList =  $this->getMailerRecipients($Id);
					foreach($receipientList as $value){
							if(!empty($value->name)){
								$allSelected.="<option value={$value->user_id} selected>{$value->name}</option>";
							}
					}
					$selectReceipients['options'] = $allSelected; 
					
					$mailer = $this->mailersModel->getAllMailers($Id); 
					
					if(count($mailer)>0){
								$mailer			 = $mailer{0};
								$input['later']			=	(!empty($mailer->date))?date("d-m-Y H:i",strtotime($mailer->date)):'';
								$input['subject']	=	$mailer->subject;
								$input['body']		=	$mailer->body;
					}
			
				return view('admin.admin-broadcastNotifications')->with(array("useBlade"=>"mailers","title"=>$this->title,"classname"=>$this->className,"filter"=>$filter,"multiSelector"=>$mulitSelector,"receipientSelector"=>$selectReceipients,"send"=>$input));
	}
	
	public function deleteMailer($Id){
			$mailers = $this->mailersModel->deleteMailer($Id);
			return redirect('admin/bulkMailer/mailList');
	}
	
	public function processMailer($Id){
			$mailer				 = $this->mailersModel->getAllMailers($Id); 
			$mailer 				 =	$mailer{0};
			$receipientsList = $this->mailersModel->getMailerRecipients($Id); 
			 
			if(count($receipientsList)>0){
				$receipientsList = $receipientsList{0};
				foreach($receipientsList  as $uId){
					$userId[]=$uId;
				}
				
				if(!empty($userId)){
					$this->mailersModel->sendBulkMails($mailer->subject,$mailer->body,$userId);
				}
			}
			$mailers 	= $this->mailersModel->updateStatus($Id);
			return redirect('admin/bulkMailer/mailList');
	} 

	public function copyRecords($Id){
		  $this->mailersModel->copyExistingMessages($Id); 
	} 

}
