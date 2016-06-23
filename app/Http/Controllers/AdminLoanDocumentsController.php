<?php 
namespace App\Http\Controllers;
use Request;
use	\App\models\AdminLoanDocumentsModel;

class AdminLoanDocumentsController extends MoneyMatchController {
	
	public function __construct() {			
		
		$this->middleware('auth');
		$this->init();		
		
	}	
	
	public function littleMoreInit() {
		
		$this->adminloandocModel	=	new AdminLoanDocumentsModel;
		
	}
	
	public function indexAction() {
		
		$submitted	=	false;
		
		$this->adminloandocModel->getLoanDocuments();
	
		$withArry	=	array(	"adminloandocModel" => $this->adminloandocModel,
								"classname"=>"fa fa-user fa-fw",
								"submitted"=>$submitted 
							);
		return view('admin.admin-loandocuments')
					->with($withArry); 
		
	}
	
	public function saveAction() {
		
		$postArray	=	Request::all();
		$result		=	$this->adminloandocModel->updateLoanDocuments($postArray);
		$successTxt	=	$this->adminloandocModel->getSystemMessageBySlug("update_loan_documents_required");
		if($result) {
			return redirect()->route('admin.loandocrequired')
						->with('success',$successTxt);
		}else{
			return redirect()->route('admin.loandocrequired')
						->with('failure','Something went wrong!');	
		}
	}
	
}
