<?php 
namespace App\Http\Controllers;
use Request;
use	\App\models\AdminBusinessOrgTypeModel;

class AdminBusinessOrgTypeController extends MoneyMatchController {
	
	public function __construct() {			
		
		$this->middleware('auth');
		$this->init();		
		
	}	
	
	public function littleMoreInit() {
		
		$this->adminbusiorgtypeModel	=	new AdminBusinessOrgTypeModel;
		
	}
	
	public function indexAction() {
		
		$submitted	=	false;
		$this->adminbusiorgtypeModel->getBusinessOrgTypes();
	
		$withArry	=	array(	"adminbusinessorgModel" => $this->adminbusiorgtypeModel,
								"classname"=>"fa fa-cogs fa-fw",
								"submitted"=>$submitted 
							);					
		
		return view('admin.admin-businessorgtype')
						->with($withArry); 
	}
	public function saveAction() {		
		$postArray		=	Request::all();		
		$result			=	$this->adminbusiorgtypeModel->updateBusinessOrgTypes($postArray);
		$successTxt		=	$this->adminbusiorgtypeModel->getSystemMessageBySlug("update_organisation_type");
		if($result) {
			return redirect()->route('admin.businessorgtype')
							->with('success',$successTxt);
		}else{
			return redirect()->route('admin.businessorgtype')
						->with('failure','Something went wrong!');	
		}
	}
	
}
