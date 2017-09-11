<?php 
namespace App\Http\Controllers;
use	\App\models\BorrowerMyLoanInfoModel;
use Request;
use Storage;
class BorrowerMyLoanInfoController extends MoneyMatchController {

	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->borrowerMyLoanInfoModel	=	new BorrowerMyLoanInfoModel;
	}
	
	public function indexAction() {
		
		$filterLoanStatus_filter 	= '11';
		
		if (isset($_REQUEST["loanstatus_filter"])) 
			$filterLoanStatus_filter 	= $_REQUEST["loanstatus_filter"];
			
		$withArry	=	array(	"BorModMyLoanInfo"=>$this->borrowerMyLoanInfoModel,
								"classname"=>"fa fa-file-text fa-fw"
							);	
		$this->borrowerMyLoanInfoModel->getBorrowerAllLoanDetails($filterLoanStatus_filter);	
		return view('borrower.borrower-myloaninfo')
			->with($withArry);
	}
	public function myloan() {
	 $data = $this->borrowerMyLoanInfoModel->myloans();
	 /*$objectUrl = Storage::cloud()->url('uploads/borrower/PROIMG_Screenshot_from_2017-09-01_12:47:45.png');
	
	echo $objectUrl;die;
	*/
	
	return view('clander')->with(array('home'=>$data));
			
	 }
	
	public function ajaxRepayScheduleAction() {
		$loan_id 		= 	Request::get('loan_id');
		$response_data 	= 	$this->borrowerMyLoanInfoModel->getBorrowerRepaymentSchedule($loan_id);
		return json_encode(array("rows"=>$response_data));
	}
	
}



