<?php namespace App\models;

class AdminInvestorsDepositListingModel extends TranWrapper {
	
	public  $allTransList					= 	array();
	public  $depositListInfo				= 	array();
	public  $filter_status					= 	"";
	public  $fromDate						= 	"";
	public  $toDate							= 	"";	
	
	public  $allactiveinvestList			= 	array();
	public  $invListInfo					= 	array();
	public  $processbuttontype				= 	"";
	public  $viewRecordsInfo				= 	array();
	public	$deposit_date					=	"";
	public	$deposit_amount					=	"";
	public	$trans_ref_no					=	"";
	public	$remarks						=	"";
	
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
		$this->filter_status 		= 	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED;
		
		if (isset($_REQUEST['filter_status'])) {
		 	$this->filter_status 	= $_REQUEST['filter_status'];
			$this->fromDate			= $_REQUEST['fromdate'];
			$this->toDate			= $_REQUEST['todate'];
		} 
		
		$lnListSql				=	"SELECT users.firstname,
											investors.investor_id,
											investor_bank_transactions.payment_id,
											date_format(investor_bank_transactions.trans_date,'%d-%m-%Y') 	
																						trans_date,
											ROUND(investor_bank_transactions.trans_amount,2) trans_amount,
											( SELECT	expression
													FROM	codelist_details
													WHERE	codelist_id = :bankstatus_codeparam4
													AND		codelist_code = investor_bank_transactions.status
											) trans_status_name
									 FROM 	investors,
											users,
											investor_bank_transactions 
									 WHERE  investors.user_id   	= users.user_id 
									 AND 	investors.investor_id 	= investor_bank_transactions.investor_id 
									 AND 	investor_bank_transactions.status = if(:filter_codeparam = :unapprove_codeparam3, :unapproved_codeparam1, :approved_codeparam2)
									 AND	investor_bank_transactions.trans_date 
											BETWEEN :fromDate AND :toDate 
									AND		investor_bank_transactions.trans_type	=	:trans_type_codeparam5
									 ORDER BY investor_bank_transactions.trans_date ";
						 
		$dataArrayLoanList		=	[															
										"filter_codeparam" 		=>	$this->filter_status,
										"unapproved_codeparam1" => 	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED,										
										"approved_codeparam2" 	=> 	INVESTOR_BANK_TRANS_STATUS_VERIFIED,										
										"unapprove_codeparam3" 	=>	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED,
										"bankstatus_codeparam4" =>	INVESTOR_BANK_TRANS_STATUS,																				
										"fromDate" 				=>	$this->getDbDateFormat($this->fromDate),
										"toDate" 				=>	$this->getDbDateFormat($this->toDate),
										
										"trans_type_codeparam5"	=>	INVESTOR_BANK_TRANSCATION_TRANS_TYPE_DEPOSIT
									];

		$this->depositListInfo	=	$this->dbFetchWithParam($lnListSql, $dataArrayLoanList);
				
		return ;		
		
	}
	
	
	
	public function processInvestorDropDowns($processtype,$investorId){
        $this->processbuttontype = $processtype;
		
		if($this->processbuttontype == "view" || $this->processbuttontype == "edit" ){
		$invfilterSql						=	"SELECT users.firstname,
														investors.investor_id
												 FROM   investors,users
												 WHERE  investors.user_id = users.user_id 
												 AND    users.status = :userstatus_codeparam
												 AND    users.email_verified = :emailverified_codeparam
												 AND 	investors.investor_id = {$investorId}";		
			
		}
		else{
		
		$invfilterSql						=	"SELECT users.firstname,
														investors.investor_id
												 FROM   investors,users
												 WHERE  investors.user_id = users.user_id 
												 AND    users.status = :userstatus_codeparam
												 AND    users.email_verified = :emailverified_codeparam";		
		}	
		$dataArrayInvList				= 	[															
												"userstatus_codeparam" => USER_STATUS_VERIFIED,
												"emailverified_codeparam" => USER_EMAIL_VERIFIED
											];
												
		$invfilter_rs					=	$this->dbFetchWithParam($invfilterSql, $dataArrayInvList);			
								
		//~ $invfilter_rs						= 	$this->dbFetchAll($invfilterSql);
		
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
	
	public function getInvestorsDepositInfo($processtype,$investorId,$paymentId){
		
		$this->viewEditInvestorDeposits($processtype,$investorId,$paymentId);
		$this->processInvestorDropDowns($processtype ,$investorId);
	}	
	
	public function viewEditInvestorDeposits($processtype,$investorId,$paymentId){
			
			$viewRecordSql		= "SELECT 
										ROUND(payments.trans_amount,2) trans_amount,
										date_format(payments.trans_date,'%d-%m-%Y') trans_date,
										payments.trans_reference_number,
										payments.remarks
									FROM 
										payments,investor_bank_transactions
									WHERE 
										investor_bank_transactions.payment_id = payments.payment_id 
									AND investor_bank_transactions.investor_id = {$investorId}
									AND investor_bank_transactions.trans_type = :trans_type_codeparam
									AND payments.payment_id = {$paymentId} ";
			
			$paramArray			=	["trans_type_codeparam"	=>	INVESTOR_BANK_TRANSCATION_TRANS_TYPE_DEPOSIT];
			$viewRecordRs		= 	$this->dbFetchWithParam($viewRecordSql,$paramArray);
			if (count($viewRecordRs) > 0) {
			
					$this->deposit_date		=	$viewRecordRs[0]->trans_date;
					$this->deposit_amount	=	$viewRecordRs[0]->trans_amount;
					$this->trans_ref_no		=	$viewRecordRs[0]->trans_reference_number;
					$this->remarks			=	$viewRecordRs[0]->remarks;
			}
	}	
	
	public function saveInvestorDeposits($postArray) {
		
		$tranType		=	$postArray['tranType'];
		$trans_id		=	$postArray['trans_id'];
		$paymentId		=	$postArray['payment_id'];
		
		if(isset($postArray["isSaveButton"]) && $postArray["isSaveButton"]	!=	"yes"){
			$invBankTransStatus			=	INVESTOR_BANK_TRANS_STATUS_VERIFIED; 
			$paymentStatus				=	PAYMENT_STATUS_VERIFIED;
			
		}else{
			$invBankTransStatus			=	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED; 
			$paymentStatus				=	PAYMENT_STATUS_UNVERIFIED;
		}
		
		$depositpaymentInsert_data	=	array(
										'trans_date' =>$this->depositwithdrawdate,
										'trans_type' => PAYMENT_TRANSCATION_INVESTOR_DEPOSIT,							
										'trans_amount' => $this->transamount,
										'currency' => $currency,
										'trans_reference_number' => $this->transReference,
										'status' => PAYMENT_STATUS_UNVERIFIED,
										'remarks' => $this->remarks);

		$depositInsert_data			=	array(								
										'investor_id' => $this->investid,									
										'trans_type' => INVESTOR_BANK_TRANSCATION_STATUS_DEPOSIT,
										'trans_date' => $this->depositwithdrawdate,
										'trans_amount' => $this->transamount,
										'trans_currency' => $currency,
										'status' => $status);	
				
		if($tranType	==	"add") {
			
			$paymentId 							=	$this->dbInsert("payments", $depositpaymentInsert_data, 1);
			$depositInsert_data['payment_id']	=	$paymentId;
			$this->dbInsert("investor_bank_transactions", $depositInsert_data, 0);
		}else{
			
			$depositInsert_data['payment_id']	=	$paymentId;
			$whereDepositArry					=	array("trans_id" =>"{$trans_id}");
			if($paymentId	==	0) {
				$paymentId 						=	$this->dbInsert("payments", $depositpaymentInsert_data, 1);
			}
			$depositInsert_data['payment_id']	=	$paymentId;
			
			$this->dbUpdate('investor_bank_transactions', $depositInsert_data, $whereDepositArry);
		}
		//Update the Investor Available balance amount
		if(isset($postArray["isSaveButton"]) && $postArray["isSaveButton"]	!=	"yes"){
			
		}
	}
	
}
