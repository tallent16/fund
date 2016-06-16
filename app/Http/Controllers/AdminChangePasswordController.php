<?php 
namespace App\Http\Controllers;
use	\App\models\AdminChangePasswordModel;
use Request;
use Auth;
class AdminChangePasswordController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminChangePasswordModel = new AdminChangePasswordModel();
	}
		
	public function indexAction($user_id){
		
		$selected_user_id	=	base64_decode($user_id);
		
		$this->adminChangePasswordModel->setChangePasswordVariables($selected_user_id);
		
		$withArry	=	array(	"adminChanPassMod" => $this->adminChangePasswordModel,
								"classname"=>"fa fa-user fa-fw");
							
		
		return view('admin.admin-changepassword')
							->with($withArry);
	}

	public function saveChangePasswordAction(){
		
		$postArray				=	Request::all();
		$current_user_password	=	$postArray['current_user_password'];
		$current_user_id		=	Auth::user()->user_id;
		$selected_user_id		=	$postArray['selected_user_id'];
		$this->adminChangePasswordModel->setChangePasswordVariables($selected_user_id);
		
		if(!$this->adminChangePasswordModel->checkPasswordByUserID($current_user_password,$current_user_id) ) {
			return redirect()->route('admin.changepassword', array('user_id' => base64_encode($selected_user_id)	))
				->with('failure','current user password invalid');
		}
		
		$this->adminChangePasswordModel->updateChangePassword($postArray);
		
		return redirect()->route($this->adminChangePasswordModel->returnRouteName)
						->with('success','User Password Changed successfully');
	}
}
