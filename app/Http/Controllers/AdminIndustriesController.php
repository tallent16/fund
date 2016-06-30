<?php 
namespace App\Http\Controllers;
use Request;
use	\App\models\AdminIndustriesModel;

class AdminIndustriesController extends MoneyMatchController {
	
	public function __construct() {			
		
		$this->middleware('auth');
		$this->init();		
		
	}	
	
	public function littleMoreInit() {
		
		$this->adminindustryModel	=	new AdminIndustriesModel;
		
	}
	
	public function indexAction() {
		$submitted	=	false;
		$this->adminindustryModel->getIndustryList();
	
		$withArry	=	array(	"adminindustryModel" => $this->adminindustryModel,
								"classname"=>"fa fa-cogs fa-fw",
								"submitted"=>$submitted 
							);
		return view('admin.admin-industries')
					->with($withArry); 
		
	}	
	public function saveAction() {
		
		$postArray	=	Request::all();
		$result		=	$this->adminindustryModel->updateIndustries($postArray);
		$successTxt	=	$this->adminindustryModel->getSystemMessageBySlug("update_industry_type");
		if($result) {
			return redirect()->route('admin.industries')
							->with('success',$successTxt);
		}else{
			return redirect()->route('admin.industries')
						->with('failure','Something went wrong!');	
		}
	}
}
