<?php namespace App\models;

class AdminInvestorsDepositListingModel extends TranWrapper {
	
	public  $allTransList					= array();
	public  $depositListInfo				= array();
	public  $filter_status					= "";
	public  $fromDate						= "";
	public  $toDate							= "";	
	
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
		
		$lnListSql	=	"SELECT users.firstname,
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
		
}
	

