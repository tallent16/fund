<?php namespace App\models;

class AdminInvestorsDepositListingModel extends TranWrapper {
	
	public  $allTransList					= array();
	public  $depositListInfo				= array();
	public  $filter_status					= "";
	public  $fromDate						= "";
	public  $toDate							= "";	
	
	public  $allactiveinvestList			= array();
	public  $invListInfo					= array();
	public  $processbuttontype				= "";
	public  $viewRecordsInfo				= array();
	
	public function processDropDowns() {
				
				
		$filterSql		=	"	SELECT	codelist_id,
										codelist_code,
										codelist_value,
										expression
								FROM	codelist_details
								WHERE	codelist_id in (31)"												
								;
								
		$filter_rs		= 	$this->dbFetchAll($filterSql);			
		
		if (!$filter_rs) {
			throw exception ("Code List Master / Detail information not correct");
			return;
		}
				
		foreach($filter_rs as $filter_row) {

			$codeId 	= 	$filter_row->codelist_id;
			$codeCode 	= 	$filter_row->codelist_code;
			$codeValue 	= 	$filter_row->codelist_value;
			$codeExpr 	= 	$filter_row->expression;
						
			switch ($codeId) {
			
				case 31:
					$this->allTransList[$codeCode] 	=	$codeExpr;
					break;

			}								
					
		}		
		
	} // End process_dropdown
		
	public function viewDepositList($fromDate, $toDate, $filter_status) {
		
		$this->fromDate				= 	date('d-m-Y', strtotime(date('Y-m')." -1 month"));
		$this->toDate				= 	date('d-m-Y', strtotime(date('Y-m')." +1 month"));		
		$this->filter_status 		= 	"1";
		
		if (isset($_REQUEST['filter_status'])) {
		 	$this->filter_status 	= $_REQUEST['filter_status'];
			$this->fromDate			= $_REQUEST['fromdate'];
			$this->toDate			= $_REQUEST['todate'];
		} 
		
		$lnListSql				=	"SELECT users.firstname,
											investors.investor_id,
											investor_bank_transactions.payment_id,
											investor_bank_transactions.trans_date,
											investor_bank_transactions.trans_amount,
											( 	SELECT	expression
												FROM	codelist_details
												WHERE	codelist_id = :bankstatus_codeparam4
												AND		codelist_code = investor_bank_transactions.status) trans_status_name
									 FROM 	investors,
											users,
											investor_bank_transactions 
									 WHERE  investors.user_id   	= users.user_id 
									 AND 	investors.investor_id 	= investor_bank_transactions.investor_id 
									 AND 	investor_bank_transactions.status = if(:filter_codeparam = :unapprove_codeparam3, :unapproved_codeparam1, :approved_codeparam2)
									 AND	investor_bank_transactions.trans_date 
									 BETWEEN :fromDate AND :toDate 
									 ORDER BY investor_bank_transactions.trans_date ";
						 
		$dataArrayLoanList		=	[															
										"filter_codeparam" => $this->filter_status,
										"unapproved_codeparam1" => INVESTOR_BANK_TRANS_STATUS_UNVERIFIED,										
										"approved_codeparam2" => INVESTOR_BANK_TRANS_STATUS_VERIFIED,										
										"unapprove_codeparam3" => INVESTOR_BANK_TRANS_STATUS_UNVERIFIED,
										"bankstatus_codeparam4" => INVESTOR_BANK_TRANS_STATUS,																				
										"fromDate" => $this->getDbDateFormat($this->fromDate),
										"toDate" => $this->getDbDateFormat($this->toDate)
									];

		$this->depositListInfo	=	$this->dbFetchWithParam($lnListSql, $dataArrayLoanList);
				
		return ;		
		
	}
	
	
	
	public function processInvestorDropDowns($processtype,$investorId){
        $this->processbuttontype = $processtype;
		
		if($this->processbuttontype == "view" || "edit" ){
		$invfilterSql						=	"SELECT users.firstname,
														investors.investor_id
												 FROM   investors,users
												 WHERE  investors.user_id = users.user_id 
												 AND    users.status = 2
												 AND    users.email_verified = 1
												 AND 	investors.investor_id = {$investorId}";		
			
		}
		else{
		
		$invfilterSql						=	"SELECT users.firstname,
														investors.investor_id
												 FROM   investors,users
												 WHERE  investors.user_id = users.user_id 
												 AND    users.status = 2
												 AND    users.email_verified = 1";		
		}	
		/*$dataArrayInvList				= 	[															
												"userstatus_codeparam" => "2",
												"emailverified_codeparam" => "1"
											]	
											 								
		$this->invListInfo				=	$this->dbFetchWithParam($filterSql, $dataArrayInvList);		*/				
								
		$invfilter_rs						= 	$this->dbFetchAll($invfilterSql);
		
		if (!$invfilter_rs	) {
			throw exception ("Not correct");
			return;
		}	
	   
	   foreach($invfilter_rs as $invfilter_row) {
		   
		   $inv_name 					= 	$invfilter_row->firstname;
		   $inv_id						=	$invfilter_row->investor_id;
		   
		   $this->allactiveinvestList[$inv_id] = $inv_name;
		
	   }
	}		
	
	
	public function processInvestorDeposits($processtype,$investorId,$paymentId){
					
		if($processtype == "view" || "edit" ){
			$this->viewEditInvestorDeposits($processtype,$investorId,$paymentId);		
		}		
		else{
			$this->addInvestorDeposits();			
		}		
	}
	
	public function addInvestorDeposits(){
			
			
			
	}	
		
	public function viewEditInvestorDeposits($processtype,$investorId,$paymentId){
			
			$viewRecordSql		= "SELECT 
										payments.trans_amount,
										payments.trans_date,
										payments.trans_reference_number,
										payments.remarks
									FROM 
										payments,investor_bank_transactions
									WHERE 
										investor_bank_transactions.payment_id = payments.payment_id 
									AND investor_bank_transactions.investor_id = {$investorId}
									AND investor_bank_transactions.trans_type = 1
									AND payments.payment_id = {$paymentId} ";
									
			$this->viewRecordsInfo	= 	$this->dbFetchRow($viewRecordSql);
			
			if($processtype == "edit"){
				
			}
			
			
	}	
	
	
}
