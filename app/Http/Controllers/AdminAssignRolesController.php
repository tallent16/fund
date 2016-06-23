<?php 
namespace App\Http\Controllers;
use	\App\models\AdminAssignRolesModel;
use Request;
class AdminAssignRolesController extends MoneyMatchController {
	
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminAssignRolesModel = new AdminAssignRolesModel();
	}
		
	public function indexAction($user_id){
		
		
		$this->adminAssignRolesModel->getAssignRoleDetails($user_id);
		$withArry	=	array(	"adminAssRolModel" => $this->adminAssignRolesModel, 
								"classname"=>"fa fa-list-alt fa-fw");
		return view('admin.admin-assign-roles')
				->with($withArry); 
	
	}
		
	public function saveUserRolesAction(){
		
		$postArray	=	Request::all();
		$result		=	$this->adminAssignRolesModel->saveUserRoles($postArray);
		if($result) {
			$successTxt	=	$this->adminAssignRolesModel->getSystemMessageBySlug("roles_for_user");
			return redirect()->route('admin.assignroles', array('user_id' => $postArray['user_id']))
						->with('success',$successTxt);
		}else{
			return redirect()->route('admin.assignroles', array('user_id' => $postArray['user_id']))
						->with('failure','Roles assigned Failed');	
		}	
	
	}
}
