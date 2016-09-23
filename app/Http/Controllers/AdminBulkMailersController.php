<?php 
namespace App\Http\Controllers;
use	\App\models\AdminNotificationsModel;
use Request;

class AdminBulkMailersController extends MoneyMatchController {

	public function __construct() {
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->notificationsModel	=	new AdminNotificationsModel;
		$this->title 							= 	"Bulk Mailers";
		$this->className					 =	"fa fa-envelope fa-fw";
	}

	//Create add broadcast notification page
	public function sendBulkMails($Id=null){
				 
				return view('admin.admin-broadcastNotifications')->with(array("useBlade"=>"mailers","title"=>$this->title,"classname"=>$this->className));
	}
	 
	 

}
