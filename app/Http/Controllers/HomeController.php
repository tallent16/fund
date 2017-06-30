<?php 
namespace App\Http\Controllers;
use	\App\models\HomepageListingModel;
use	\App\models\LoanDetailsModel;
use	\App\models\BorrowerApplyLoanModel;
use Auth;
use Request;
use Session;
class HomeController extends MoneyMatchController {

	public $home;
	
	public function __construct() {	
		 //~ $this->middleware('auth');
		 $this->init();		 
	}
	
	public function littleMoreInit() {
		$this->home = new HomepageListingModel();
		$this->loanDetailsModel = new LoanDetailsModel();
		$this->borrowerApplyLoanModel = new BorrowerApplyLoanModel();
	}
	
	//based on user type redirect to related dashboard
	public function checkUserType() {
		
		//~ if (Auth::check()) {

			//~ switch(Auth::user()->usertype) {
				//~ case 1:
					//~ return redirect('borrower/dashboard');
					//~ break;
				//~ case 2:
					//~ return redirect('investor/dashboard');
					//~ break;
				//~ case 3:
					//~ return redirect('admin/dashboard');
					//~ break;
			//~ }	
			
		//~ }
		return redirect('/');
	}
	
	//checks the user login redirect to related dashboard else to home page
	public function customRedirectPath() {
		
		//~ if (Auth::check()) {

			//~ switch(Auth::user()->usertype) {
				//~ case 1:
					//~ return redirect('borrower/dashboard');
					//~ break;
				//~ case 2:
					//~ return redirect('investor/dashboard');
					//~ break;
				//~ case 3:
					//~ return redirect('admin/dashboard');
					//~ break;
			//~ }	
			
		//~ }else{
			return redirect('/');
		//~ }
	}
	
	public function indexAction() {
		$this->home->getIndustries();
		$this->home->getLoanList();
		$this->home->getRecommendedList();
		$withArry	=	array(	"home" => $this->home);
		return view('homepage')->with($withArry); 
	}
	
	//~ public function getAllCategories(){
		//~ $this->home->getIndustries();
		//~ $withArry	=	array(	"home" => $this->home , "classname"=>"fa fa-tachometer fa-fw"); 
		//~ return view('categories')->with($withArry); 
	//~ }
	
	public function getProjects($catname=null){	
				
		$this->home->processDropDowns();
		$catname = base64_decode($catname);	
		$this->home->getProjectList($catname);
		$withArry	=	array(	"home" => $this->home , "classname"=>"fa fa-tachometer fa-fw");
		return view('projectpage')->with($withArry); 
	}
	
	//~ public function getExcitingProjects(){
		
		//~ $this->home->getRecommendedList();	
		//~ $withArry	=	array(	"home" => $this->home , "classname"=>"fa fa-tachometer fa-fw");
		//~ return view('projects')->with($withArry); 
	//~ }
	
	//~ public function getPopularProjects(){
		//~ $this->home->getLoanList();
		//~ $withArry	=	array(	"home" => $this->home , "classname"=>"fa fa-tachometer fa-fw");
		//~ return view('projects')->with($withArry); 	
	//~ }
	
	public function allCategoriesPage(){
		$this->home->getIndustries();
		$withArry	=	array(	"home" => $this->home , "classname"=>"fa fa-tachometer fa-fw"); 
		return view('categoryPage')->with($withArry); 
	} 
	
	public function allProjectsPage($type=null){	
		
		$filterCat 		= 'all';		
		$sortbyfield	= 'all';		
		if (isset($_REQUEST["tenure_filter"])) 
		$filterCat 		= $_REQUEST["tenure_filter"];	
		if (isset($_REQUEST["sortby"])) 
		$sortbyfield 	= $_REQUEST["sortby"];	
					
		$this->home->processDropDowns();
		
		if($type=='exciting'){			
			$this->home->getRecommendedList($filterCat);				
		}else if($type=='popular'){
			$this->home->getLoanList($filterCat);	
		}else{				
			$this->home->getLoanListing($filterCat,$sortbyfield);
		}
		
		$withArry	=	array(	"home" => $this->home , "classname"=>"fa fa-tachometer fa-fw");
		return view('projectpage')->with($withArry); 
	}
	
	public function projectDetails($loan_id){
		$sourceId	=	explode("_",base64_decode($loan_id));
				
		//~ $this->loanDetailsModel->getLoanDetails($sourceId[0]);
		//~ $this->borrowerApplyLoanModel->getBorrowerLoanDetails($sourceId[0]);
		$this->borrowerApplyLoanModel->getBorrowerLoanInfo($sourceId[0]);
		$this->borrowerApplyLoanModel->getBorrowerAllMilestones($sourceId[0]);
		$this->borrowerApplyLoanModel->getBorrowerAllRewardTokes($sourceId[0],"yes");
		
		$submitted	=	false;
		$subType	=	"";
		
		if (Request::isMethod('post')) {
			 
			$postArray	=	Request::all();
			
			$result		=	$this->loanDetailsModel->processBid($postArray);
			if($result) {
				$submitted	=	true;
				Session::put("success",$this->loanDetailsModel->successTxt);
			}
			$subType	=	$postArray['isCancelButton'];			
		}
		
		$this->loanDetailsModel->getLoanDetails($sourceId[0]);
		$withArry	=	array(	"LoanDetMod"=>$this->loanDetailsModel,
								"classname"=>"fa fa-file-text fa-fw",
								"loan_id"=>$loan_id,
								"submitted"=>$submitted,
								"subType"=>$subType,
								"BorModLoan"=>$this->borrowerApplyLoanModel
								);
		return view('projectdetails')
			->with($withArry);
	}
	
	public function ajaxAvailableBalanceAction() {
		$availableBalance		=	$this->loanDetailsModel->getInvestorAvailablBalance();
		return $availableBalance;
	}
	
	public function mypageAction() {
		
		return view('mypage');  
	}
}
