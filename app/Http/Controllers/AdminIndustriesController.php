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
								"classname"=>"fa fa-user fa-fw",
								"submitted"=>$submitted 
							);
		return view('admin.admin-industries')
					->with($withArry); 
		
	}	
	public function saveAction() {
		
		$postArray	=	Request::all();
		$result		=	$this->adminindustryModel->updateIndustries($postArray);
		
		if($result) {
			return redirect()->route('admin.industries')
						->with('success','Industries Updated successfully');
		}else{
			return redirect()->route('admin.industries')
						->with('failure','Something went wrong!');	
		}
	}
}
