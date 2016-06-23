<?php 
namespace App\Http\Controllers;
use	\App\models\AdminRolesModel;
use Request;
use Session;
class AdminRolesController extends MoneyMatchController {
	
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminRolesModel = new AdminRolesModel();
	}
		
	public function indexAction(){
		
		$this->adminRolesModel->getRoleList();
		$withArry	=	array(	"adminRolesModel" => $this->adminRolesModel, 
								"classname"=>"fa fa-list-alt fa-fw");
		return view('admin.admin-roles')
				->with($withArry); 
	
	}
		
	public function deleteAction($role_id){
		
		$this->adminRolesModel->deleteRole($role_id);
		$successTxt	=	$this->adminRolesModel->successTxt;
		
		return redirect()->route('admin.roles')
						->with('success',$successTxt);
	}
		
	public function roleUsersAction($role_id){
		
		$this->adminRolesModel->getRoleUsers($role_id);
		$withArry	=	array(	"adminRolesModel" => $this->adminRolesModel, 
								"classname"=>"fa fa-list-alt fa-fw");
		return view('admin.admin-role-users')
				->with($withArry); 
	
	}
	
	public function addRolePermissionsAction($role_id){
		
		$this->adminRolesModel->getRolePermissionDetails($role_id);
		$withArry	=	array(	"adminRolesModel" 	=>	$this->adminRolesModel, 
								"trantype"			=>	'add',
								"classname"=>"fa fa-list-alt fa-fw");
		return view('admin.admin-role-permissions')
				->with($withArry); 
	}
		
	public function editRolePermissionsAction($role_id){
		
		$this->adminRolesModel->getRolePermissionDetails($role_id);
		$withArry	=	array(	"adminRolesModel" 	=>	$this->adminRolesModel, 
								"trantype"			=>	'edit',
								"classname"=>"fa fa-list-alt fa-fw");
		return view('admin.admin-role-permissions')
				->with($withArry); 
	}
	
	public function saveRolePermissionsAction(){
		
		$postArray				=	Request::all();
		$role_id				=	$postArray['role_filter'];
		$this->adminRolesModel->processPermission($postArray);
		$successTxt	=	$this->adminRolesModel->successTxt;
		if($postArray['trantype']	==	"add") {
			return redirect()->to('admin/roles')
						->with('success',$successTxt);
		}
		return redirect()->route('admin.rolepermission.edit', array('role_id' => $role_id))
						->with('success',$successTxt);
	}
	
	//checks the Role Name exists or not
	public function CheckRoleNameavailability(Request $request) {
		
		$role_name	=	Request::input('role_name');
	
		if($this->adminRolesModel->CheckRoleName($role_name))
			echo "2" ;
		else
			echo "1";
	}
}
