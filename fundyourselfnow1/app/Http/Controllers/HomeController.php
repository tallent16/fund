<?php 
namespace App\Http\Controllers;
use	\App\models\HomepageListingModel;
use	\App\models\LoanDetailsModel;
use	\App\models\BorrowerApplyLoanModel;
use	\App\models\AdminNotificationsModel;
use Auth;
use Request;
use Session;
use DB;
use datetime;
use Mail;
use File;
use Aws\S3\S3Client;
class HomeController extends MoneyMatchController {

	public $home;
	public $bucket = 'arn:aws:s3:::devfyn';
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
		//$s3 = S3Client::factory();
	//	echo '<pre>';print_r($s3 );die;

/*
$result = $s3->putBucketWebsite(array(
    'Bucket'        => $bucket,    
    'IndexDocument' => array('Suffix' => 'index.php'),
    'ErrorDocument' => array('Key' => 'error.html'),
));


$result = $s3->getBucketWebsite(array(
    'Bucket' => $bucket,
));
echo $result->getPath('IndexDocument/Suffix');die;*/

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
	public function getloan_links($loan_id){
    $social_link = DB::table("social_links")->where('loan_id','=',$loan_id)->get();
	//echo '<pre>';print_r($social_link);die;
 return	$social_link;
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

	public function allProjectsPage1(){	
		$data = $this->home->loans();
       return view('clander')->with(array('home'=>$data)); 
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
		$links  = $this->getloan_links($sourceId[0]);
		$detailArray = DB::table('loan_updates')->where('loan_id','=',$sourceId[0])->get();
		$twiterlink = '';
		 $fblink ='';
		 if($links){
		foreach ($links as $li){
			if($li->name=='Twitter'){
             $twiterlink = $li->link;

			}
			if($li->name=='Facebook'){
             $fblink = $li->link;

			}
		}
	}



		$this->loanDetailsModel->getLoanDetails($sourceId[0]);
		$withArry	=	array(	"LoanDetMod"=>$this->loanDetailsModel,
			                     "twiterlink"=>$twiterlink,
			                     "fblink"=>$fblink,
			                     'all_links'=>$links,
                                 "project_update"=>$detailArray,
								"classname"=>"fa fa-file-text fa-fw",
								"loan_id"=>$loan_id,
								"submitted"=>$submitted,
								"subType"=>$subType,
								"BorModLoan"=>$this->borrowerApplyLoanModel
								);

		if (Auth::check()) {

	 if(Auth::user()->usertype=='2') {

	 	$investor = DB::table('investors')->where('user_id','=',Auth::user()->user_id)->first();
        $withArry['investors']=$investor;
	       }
			
			
		 }
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

	public function addAlertNotification(){ 

		$datetime = new DateTime('now');
		$datetime->modify('+1 day');
		$current_date = $datetime->format('Y-m-d');

		$loans = DB::table('loans')
			->where('status','=','3')
			->get();
		//echo "<pre>"; print_r($loans); die;

		foreach($loans as $k=>$val){
			$open_date = $val->pre_start_date;
			$close_date = $val->crowd_start_date;
			//$open_date = "2017-09-01";
			if(@$val->pre_start_date && $current_date == $open_date){
				//if(@$val->bid_open_date){
                // echo $current_date.'   '.$open_date;
				$followers = DB::table('loan_follows as l')
						->join('users as u','l.user_id','=','u.user_id')
						->where('l.loan_id','=',$val->loan_id)
						->where('l.status','=','1')
						->get();
					
				if($followers){
					$notification_data = array(
								'notification_content' 	=> $val->loan_title.' pre sale will start on '.$open_date,
								'notification_datetime'	=> date('Y-m-d H:i:s'),
								'status'				=> '2'
								);
					$id = DB::table('notifications')->insertGetId($notification_data);

					foreach($followers as $follow){
                         $users = DB::table('users')
						->where('user_id','=',$follow->user_id)
						->first();
						$user_data = array(
								'notification_id'	=>	$id,
								'user_id'			=>	$follow->user_id,
								'notification_user_status'	=> '1'
								);
						$res = DB::table('notification_users')->insert($user_data);
					
						if($res){
							$msgData = array(	
									"subject" => "Pre Sale Start", 
									"from" => 'notifications@fundyourselfnow.com',
									"from_name" => "fundyourselfnow",
									"to" => $follow->email,
									//"cc" => "",
									"live_mail" => "1",
									"template"=>"emails.emailTemplate"
									);

							$msgarray = array("content" =>'Hello '.$users->firstname.' '.$users->lastname.'<br><br>'.$val->loan_title.' pre sale will start on '.$open_date.'<br><br>'.'Sincerely,<br>Team FundYourselvesNow');
							$this->sendMail($msgData,$msgarray);
						}
					}
				}
			}

			if(@$val->crowd_start_date && $current_date == $close_date){

				$followers2 = DB::table('loan_follows as l')
						->join('users as u','l.user_id','=','u.user_id')
						->where('l.loan_id','=',$val->loan_id)
						->where('l.status','=','1')
						->get();

				if($followers2){
					$notification_data2 = array(
								'notification_content' 	=> $val->loan_title.' crowd sale will start on '.$close_date,
								'notification_datetime'	=> date('Y-m-d H:i:s'),
								'status'				=> '2'
								);
					$id2 = DB::table('notifications')->insertGetId($notification_data2);

					foreach($followers2 as $follow2){

						$user_data2 = array(
								'notification_id'	=>	$id2,
								'user_id'			=>	$follow2->user_id,
								'notification_user_status'	=> '1'
								);
						$res2 = DB::table('notification_users')->insert($user_data2);
					
						if($res2){
							$msgData2 = array(	
									"subject" => "Crowd Sale Start", 
									"from" => 'notifications@fundyourselfnow.com',
									"from_name" => "fundyourselfnow",
									"to" => $follow2->email,
									//"cc" => "",
									"live_mail" => "1",
									"template"=>"emails.emailTemplate"
									);

							$msgarray2 = array("content" => $val->loan_title.' crowd sale will start on '.$close_date);
							$this->sendMail($msgData2,$msgarray2);
						}
					}
				}
			}
		}
	}


		public function sendMail($msgData,$msgarray){
				Mail::send($msgData['template'], $msgarray, 
					function($message) use ($msgData) {
						if ($msgData['live_mail'] == 1){ 
							$message->to($msgData['to']);
						} else {
							$message->to($msgData['from']);
						}
		
						$message->from($msgData['from'], $msgData['from_name']);
						/*if(isset($msgData['cc'])){
							$email_cc_arr = explode(",", $msgData['cc']); 
							$message->cc($email_cc_arr);
						}*/
						$message->subject($msgData['subject']);
				});
		}

		function staticPage($page){ 
			$data= DB::table('pages')->where('page_name','=',$page)->first();
			//print_r($data);
			if($data){
				return view('static_page')->with(array('data'=>$data->content));
			}else{
				$data = "<center><h2>Page not found!</h2></center>";
				return view('static_page')->with(array('data'=>$data));
			}
		}

}
