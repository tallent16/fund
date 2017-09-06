<?php 
namespace App\Http\Controllers;
use	\App\models\AdminSettingsModel;
use Request;
use DB;
class AdminSettingsController extends MoneyMatchController {
	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();		
	}	
	
	public function littleMoreInit() {
		
		$this->adminSettingsModel	=	new AdminSettingsModel;		
	}
	
	public function indexAction() {
		$defaultmodule = "all";
		$submitted	=	false;
		
		$returnvalue = $this->adminSettingsModel->getGeneralSettings();	
		
		$re=$this->adminSettingsModel->getModuleDropdown();	
		
		$withArry	=	array(	"adminsettingModel" => $this->adminSettingsModel,
								"classname"=>"fa fa-cogs fa-fw",
								"submitted"=>$submitted 								
							);
		
		return view('admin.admin-settings')
						->with($withArry); 
	}
	
	public function ajaxAction() {	
		
		$defaultmodule 	= 'all';
		
		if (isset($_REQUEST["modulelist"])) 
			$defaultmodule 	= $_REQUEST["modulelist"];
			
		$response_data 	= 	$this->adminSettingsModel->getModuleTable($defaultmodule);
		
		return json_encode(array("rows"=>$response_data));		
	}
	
	public function ajaxEditAction() {	
		$slug				= 	Request::get('slug_name');
		$editresponse_data 	= 	$this->adminSettingsModel->getEditModuleTable($slug);		
		return json_encode($editresponse_data);			
	}
	
	public function ajaxEmailEditAction() {	
		$slug				= 	Request::get('slug_name');		
		$emailresponse_data 	= 	$this->adminSettingsModel->getEditEmailContent($slug);		
		return json_encode($emailresponse_data);			
	}
	
	public function saveSystemEmailAction(){
		
		$postArray				=	Request::all();			
		$slug					= 	$postArray['slug_name'];	
		$email_subject			= 	$postArray['email_subject'];	
		$email_content			= 	$postArray['email_content'];
		$saveresponse_data 		= 	$this->adminSettingsModel->updateEmailMessage($email_subject,$email_content,$slug);		
		$successTxt	=	$this->adminSettingsModel->successTxt;
		if($saveresponse_data) {			
			return redirect()->route('admin.settings')												
						->with('success',$successTxt);					
		}else{
			return redirect()->route('admin.settings')
						->with('failure','Something went wrong!');	
		}		
	}
	
	public function saveSystemMessagesAction() {
		
		$postArray				=	Request::all();		
		$event_action			= 	$postArray['event_action'];
		$slug					= 	$postArray['slug'];
		$emailslug				= 	$postArray['email_slug'];
		$sendmail				= 	$postArray['sendmail'];
		
		$messageresponse_data 	= 	$this->adminSettingsModel->updateModuleMessage($event_action,$slug,$emailslug,$sendmail);
		$successTxt	=	$this->adminSettingsModel->successTxt;
		if($messageresponse_data) {			
			return redirect()->route('admin.settings')						
						->with('success',$successTxt);
		}else{
			return redirect()->route('admin.settings')
						->with('failure','Something went wrong!');	
		}		
	}
	
	public function saveSystemSettingsAction() {
		
		$postArray	=	Request::all();		
		$result		=	$this->adminSettingsModel->updateGeneralSettings($postArray);
		$successTxt	=	$this->adminSettingsModel->successTxt;
		if($result) {
			return redirect()->route('admin.settings')						
						->with('success',$successTxt);
		}else{
			return redirect()->route('admin.settings')
						->with('failure','Something went wrong!');	
		}
	}


	public function update_static_page($page){
		if(@$_POST['save']){
			$postArray	=	Request::all();
			//print_r($postArray); die;
			DB::table('pages')
				->where('page_name','=',$postArray['page'])
				->update(array('content' => $postArray['project_purpose']));

			return redirect("admin/update/{$postArray['page']}");
		}
		$data= DB::table('pages')->where('page_name','=',$page)->first();
			//print_r($data);
			if($data){
				return view('admin.admin-staticpage')->with(array('data'=>$data->content,'title'=>$data->page_name));
			}else{
				$data = "<center><h2>Page not found!</h2></center>";
				return view('admin.admin-staticpage')->with(array('data'=>$data,'title'=>''));
			}
	}
	
}
