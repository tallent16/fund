<?php namespace App\models;

class AdminInvestorsDepositViewModel extends TranWrapper {
	
	public  $allactiveinvestList					= array();
	public  $invListInfo							= array();
	
	public function processInvestorDropDowns(){
		
		$filterSql						=	"SELECT users.firstname,
													investors.investor_id
											 FROM   investors,users
											 WHERE  investors.user_id = users.user_id 
											 AND    users.status = 2
											 AND    users.email_verified = 1";			
		/*$dataArrayInvList				= 	[															
												"userstatus_codeparam" => "2",
												"emailverified_codeparam" => "1"
											]	
											 								
		$this->invListInfo				=	$this->dbFetchWithParam($filterSql, $dataArrayInvList);		*/				
								
		$filter_rs						= 	$this->dbFetchAll($filterSql);
		
		if (!$filter_rs	) {
			throw exception ("Not correct");
			return;
		}	
	   
	   foreach($filter_rs as $filter_row) {
		   
		   $inv_name 					= 	$filter_row->firstname;
		   $inv_id						=	$filter_row->investor_id;
		   
		   $this->allactiveinvestList[$inv_id] = $inv_name;
		
	   }
	}
	
}
