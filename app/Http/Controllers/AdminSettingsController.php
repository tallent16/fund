<?php 
namespace App\Http\Controllers;
use	\App\models\AdminSettingsModel;
use Request;
class AdminSettingsController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
		
	}	
	
	public function littleMoreInit() {
		
		$this->adminSettingsModel	=	new AdminSettingsModel;
		
	}
	
	public function indexAction() {
		
		$submitted	=	false;
		
		$returnvalue = $this->adminSettingsModel->getGeneralSettings();	
		
		$withArry	=	array(	"adminsettingModel" => $this->adminSettingsModel,
								"classname"=>"fa fa-user fa-fw",
								"submitted"=>$submitted 								
							);
		
		return view('admin.admin-settings')
						->with($withArry); 
	}
	
	public function saveAction() {
		
		$postArray	=	Request::all();
		$result		=	$this->adminSettingsModel->updateGeneralSettings($postArray);
		
		if($result) {
			return redirect()->route('admin.settings')
						->with('success','Admin Settings Updated successfully');
		}else{
			return redirect()->route('admin.settings')
						->with('failure','Something went wrong!');	
		}
	}
	
}
