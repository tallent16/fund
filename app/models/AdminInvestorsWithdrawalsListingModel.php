<?php namespace App\models;

class AdminInvestorsWithdrawalsListingModel extends TranWrapper {
	
	public  $allTransList					= 	array();
	public  $withdrawListInfo				= 	array();
	public  $filter_status					= 	"";
	public  $fromDate						= 	"";
	public  $toDate							= 	"";	
	
	public  $allactiveinvestList			= 	array();
	public  $invListInfo					= 	array();
	public  $processbuttontype				= 	"";
	public  $viewRecordsInfo				= 	array();
	public	$investorId						=	"";
	public	$request_date					=	"";
	public	$settlement_date				=	"";
	public	$withdrawal_amount				=	0;
	public	$trans_ref_no					=	"";
	public	$remarks						=	"";
	public	$avail_bal						=	0;
	public	$status							=	"";
	
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
		
	public function viewWithDrawalList($fromDate, $toDate, $filter_status) {
		
		$this->fromDate				= 	date('d-m-Y', strtotime(date('Y-m')." -1 month"));
		$this->toDate				= 	date('d-m-Y', strtotime(date('Y-m')." +1 month"));		
		$this->filter_status 		= 	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED;
		
		if (isset($_REQUEST['filter_status'])) {
		 	$this->filter_status 	= $_REQUEST['filter_status'];
			$this->fromDate			= $_REQUEST['fromdate'];
			$this->toDate			= $_REQUEST['todate'];
		} 
		
		$lnListSql				=	"SELECT users.username,
											investors.investor_id,
											investor_bank_transactions.payment_id,
											date_format(investor_bank_transactions.trans_date,'%d-%m-%Y') 	
																						trans_date,
											date_format(investor_bank_transactions.entry_date,'%d-%m-%Y') 	
																						entry_date,
											ROUND(investor_bank_transactions.trans_amount,2) trans_amount,
											( SELECT	expression
													FROM	codelist_details
													WHERE	codelist_id = :bankstatus_codeparam4
													AND		codelist_code = investor_bank_transactions.status
											) trans_status_name,
											 investor_bank_transactions.status,
											 investor_bank_transactions.trans_id,
											 investor_bank_transactions.trans_type,
											ROUND(( 	SELECT	available_balance
												FROM	investors
												WHERE	investor_id = investor_bank_transactions.investor_id 
											),2) avail_bal
											 
									FROM 	investors,
											users,
											investor_bank_transactions 
									WHERE  investors.user_id   	= users.user_id 
									AND 	investors.investor_id 	= investor_bank_transactions.investor_id 
									AND 	investor_bank_transactions.status =
																if(:filter_codeparam = :unapprove_codeparam3, 	:unapproved_codeparam1, :approved_codeparam2)
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
										
										"trans_type_codeparam5"	=>	INVESTOR_BANK_TRANSCATION_TRANS_TYPE_WITHDRAWAL
									];

		$this->withdrawListInfo	=	$this->dbFetchWithParam($lnListSql, $dataArrayLoanList);
				
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
	
	public function getInvestorsWithDrawInfo($processtype,$investorId,$paymentId){
		
		$this->viewEditInvestorWithDraws($processtype,$investorId,$paymentId);
		$this->processInvestorDropDowns($processtype ,$investorId);
	}	
	
	public function viewEditInvestorWithDraws($processtype,$investorId,$paymentId){
			
			$this->settlement_date		=	date("d-m-Y");
			$this->request_date			=	date("d-m-Y");
			$this->avail_bal			=	$this->getInvestorAvailableBalanceById($investorId);
			$viewRecordSql		= "SELECT 
										ROUND(payments.trans_amount,2) withdrawal_amount,
										date_format(payments.trans_datetime,'%d-%m-%Y') settlement_date,
										payments.trans_reference_number,
										payments.remarks,
										investor_bank_transactions.trans_id,
										investor_bank_transactions.status,
										date_format(investor_bank_transactions.entry_date,'%d-%m-%Y') entry_date,
										( 	SELECT	available_balance
											FROM	investors
											WHERE	investor_id = {$investorId}
										) avail_bal
									FROM 
										payments,investor_bank_transactions
									WHERE 
										investor_bank_transactions.payment_id = payments.payment_id 
									AND investor_bank_transactions.investor_id = {$investorId}
									AND investor_bank_transactions.trans_type = :trans_type_codeparam
									AND payments.payment_id = {$paymentId} ";
			
			$paramArray			=	["trans_type_codeparam"	=>	INVESTOR_BANK_TRANSCATION_TRANS_TYPE_WITHDRAWAL];
			$viewRecordRs		= 	$this->dbFetchWithParam($viewRecordSql,$paramArray);
			if (count($viewRecordRs) > 0) {
			
					$this->settlement_date		=	$viewRecordRs[0]->settlement_date;
					$this->request_date			=	$viewRecordRs[0]->entry_date;
					$this->withdrawal_amount	=	$viewRecordRs[0]->withdrawal_amount;
					$this->trans_ref_no			=	$viewRecordRs[0]->trans_reference_number;
					$this->remarks				=	$viewRecordRs[0]->remarks;
					$this->avail_bal			=	$viewRecordRs[0]->avail_bal;
					$this->status				=	$viewRecordRs[0]->status;
					$this->payment_id			=	$paymentId;
					$this->trans_id				=	$viewRecordRs[0]->trans_id;
			}			
	}	
	
	public function saveInvestorWithDraws($postArray) {		
		$tranType					=	$postArray['tranType'];
		$trans_id					=	$postArray['trans_id'];
		$paymentId					=	$postArray['payment_id'];
		$this->investorId			=	$postArray['investor_id'];
		$this->withdrawal_amount	=	$this->makeFloat($postArray['withdrawal_amount']);
		$this->request_date			=	$this->getDbDateFormat($postArray['request_date']);
		$this->settlement_date		=	$this->getDbDateFormat($postArray['settlement_date']);
		$this->trans_ref_no			=	$postArray['trans_ref_no'];
		$this->remarks				=	$postArray['remarks'];
		$currency					=	'SGD'; // Hardcoded value
	
		$this->username			=	$this->getUserName('Investor', $this->investorId);
		$moduleName		=	"Investor Withdrawal";

		// Audit Trail related Settings
		if(isset($postArray["isSaveButton"]) && $postArray["isSaveButton"]	!=	"yes") {
			$actionSumm =	"Approval";
			$actionDet  =	"Approval of Investor Withdrawal";
		} else {
			if ($tranType != "add") {
				$actionSumm =	"Update";
				$actionDet  =	"Update Investor Withdrawal";
			} else {
				$actionSumm =	"Add";
				$actionDet	=	"Add New Investor Withdrawal";
			}
		}

		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"username", $this->username);

		
		if(isset($postArray["isSaveButton"]) && $postArray["isSaveButton"]	!=	"yes"){
			$available_balance		=	$this->getInvestorAvailableBalanceById($this->investorId);
			if($this->withdrawal_amount	>	$available_balance){
				// Cannot Allow the process because withdrawal amount exceed the available amount
				return	false;	
			}
			if(strtotime($this->request_date)	>	strtotime($this->settlement_date)){
				// Cannot Allow the process because request_date should not be greater than settlement_date
				return	false;	
			}
		}
		
		$invBankTransStatus			=	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED; 
		$paymentStatus				=	PAYMENT_STATUS_UNVERIFIED;

		$withdrawpaymentInsert_data	=	array(
										
											'trans_datetime' 			=>	$this->settlement_date,
											'trans_type' 				=>	PAYMENT_TRANSCATION_INVESTOR_WITHDRAWAL,
											'trans_amount' 				=> 	$this->withdrawal_amount,
											'currency' 					=> 	$currency,
											'trans_reference_number' 	=> 	$this->trans_ref_no,
											'status' 					=> 	$paymentStatus,
											'remarks' 					=> 	$this->remarks);

		$withdrawInsert_data			=	array(								
											'investor_id' 				=> $this->investorId,									
											'trans_type' 				=> INVESTOR_BANK_TRANSCATION_TRANS_TYPE_WITHDRAWAL,
											'entry_date' 				=> $this->request_date,
											'trans_date' 				=> $this->settlement_date,
											'trans_amount' 				=> $this->withdrawal_amount,
											'trans_currency' 			=> $currency,
											'status' 					=> $invBankTransStatus);	
		
		if($tranType	==	"add") {
			
			$paymentId 							=	$this->dbInsert("payments", $withdrawpaymentInsert_data, 1);
			$withdrawInsert_data['payment_id']	=	$paymentId;
			$trans_id	=	$this->dbInsert("investor_bank_transactions", $withdrawInsert_data, 1);
		}else{
			
			if($paymentId	==	0) {
				$paymentId 			=	$this->dbInsert("payments", $withdrawpaymentInsert_data, 1);
			}else{
				
				$wherePaymentArry	=	array("payment_id" =>"{$paymentId}");
				$this->dbUpdate('payments', $withdrawpaymentInsert_data, $wherePaymentArry);
			}
			
			$withdrawInsert_data['payment_id']	=	$paymentId;
			$whereWithDrawArry					=	array("trans_id" =>"{$trans_id}");
			
			$this->dbUpdate('investor_bank_transactions', $withdrawInsert_data, $whereWithDrawArry);
		}
		//Update the Investor Available balance amount
		if(isset($postArray["isSaveButton"]) && $postArray["isSaveButton"]	!=	"yes"){
			$this->approveWithDraw($trans_id);
		}
	}
	
	public function approveWithDraw($trans_id) {
		
		$investorBankTranInfo	=	$this->getInvesorBankTransInfoById($trans_id);
		$paymentId				=	$investorBankTranInfo[0]->payment_id;
		$investorId				=	$investorBankTranInfo[0]->investor_id;
		$withdrawAmt			=	$investorBankTranInfo[0]->trans_amount;
		$request_date			=	$investorBankTranInfo[0]->entry_date;
		$settlement_date		=	$investorBankTranInfo[0]->trans_date;
		$available_balance		=	$this->getInvestorAvailableBalanceById($investorId);
		
		if($withdrawAmt	>	$available_balance){
			// Cannot Allow the process because withdrawal amount exceed the available amount
			return	false;	
		}
		if(strtotime($request_date)	>	strtotime($settlement_date)){
			// Cannot Allow the process because request_date should not be greater than settlement_date
			return	false;	
		}
		
		$this->username			=	$this->getUserName('Investor', $investorId);
		$moduleName		=	"Investor Withdrawals";
		$actionSumm =	"Approval";
		$actionDet  =	"Approval of Investor Withdrawal";

		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"username", $this->username);

		// Update the Investor bank Transancation Status Approved
		$withdrawWhereArry		=	array("trans_id" =>"{$trans_id}");
		$withdrawDataArry		=	array("status"	=>	INVESTOR_BANK_TRANS_STATUS_VERIFIED);
		$this->dbUpdate('investor_bank_transactions', $withdrawDataArry, $withdrawWhereArry);
		
		// Update the Investor payments Status Approved
		$paymentWhereArry		=	array("payment_id" =>"{$paymentId}");
		$paymentDataArry		=	array("status"	=>	PAYMENT_STATUS_VERIFIED);
		$this->dbUpdate('payments', $paymentDataArry, $paymentWhereArry);
		
		// Update the Investor Avaliable balance 
	
		$resetAvailableBalance	=	$available_balance	-	$withdrawAmt;
		
		$investorWhereArray		=	array("investor_id"	=>	$investorId);
		$investorDataArray			=	array("available_balance"	=>	$resetAvailableBalance);
		
		$this->dbUpdate('investors', $investorDataArray, $investorWhereArray);
		
		$invUserInfo		=	$this->getInvestorIdByUserInfo($investorId);
		$moneymatchSettings = $this->getMailSettingsDetail();
		$fields 			= 	array(	'[investor_firstname]', '[investor_lastname]',
										'[withdraw_request_date]','[investor_current_balance]',
										'[application_name]'
										);
		$replace_array 		= 	array( 	$invUserInfo->firstname,
										$invUserInfo->lastname,
										$investorBankTranInfo[0]->entry_date,
										$resetAvailableBalance, 
										$moneymatchSettings[0]->application_name);
		
		$this->sendMailByModule("investor_withdrawal_approved",$invUserInfo->email,$fields,$replace_array);
	}
	
	public function unApproveWithDraw($trans_id) {
		
		$investorBankTranInfo	=	$this->getInvesorBankTransInfoById($trans_id);
		$paymentId				=	$investorBankTranInfo[0]->payment_id;
		$investorId				=	$investorBankTranInfo[0]->investor_id;
		$withdrawAmt			=	$investorBankTranInfo[0]->trans_amount;

		$this->username			=	$this->getUserName('Investor', $investorId);
		$moduleName		=	"Investor Withdrawals";
		$actionSumm =	"Unapproval";
		$actionDet  =	"Unapproval of Investor Withdrawal";

		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"username", $this->username);
		
		// Update the Investor bank Transancation Status Approved
		$withdrawWhereArry		=	array("trans_id" =>"{$trans_id}");
		$withdrawDataArry		=	array("status"	=>	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED);
		$this->dbUpdate('investor_bank_transactions', $withdrawDataArry, $withdrawWhereArry);
		
		// Update the Investor payments Status Approved
		$paymentWhereArry		=	array("payment_id" =>"{$paymentId}");
		$paymentDataArry		=	array("status"	=>	PAYMENT_STATUS_UNVERIFIED);
		$this->dbUpdate('payments', $paymentDataArry, $paymentWhereArry);
		
		// Update the Investor Avaliable balance 
		$available_balance		=	$this->getInvestorAvailableBalanceById($investorId);
		$resetAvailableBalance	=	$available_balance	+	$withdrawAmt;
		
		$investorWhereArray		=	array("investor_id"	=>	$investorId);
		$investorDataArray		=	array("available_balance"	=>	$resetAvailableBalance);
		
		$this->dbUpdate('investors', $investorDataArray, $investorWhereArray);
		
		$invUserInfo		=	$this->getInvestorIdByUserInfo($investorId);
		$moneymatchSettings = $this->getMailSettingsDetail();
		$fields 			= 	array(	'[investor_firstname]', '[investor_lastname]',
										'[withdraw_request_date]','[investor_current_balance]',
										'[application_name]'
										);
		$replace_array 		= 	array( 	$invUserInfo->firstname,
										$invUserInfo->lastname,
										$investorBankTranInfo[0]->entry_date,
										$resetAvailableBalance, 
										$moneymatchSettings[0]->application_name);
		
		$this->sendMailByModule("investor_withdrawal_unapproved",$invUserInfo->email,$fields,$replace_array);
	}
	
	public function deleteWithDraw($trans_id) {
		
		$investorBankTranInfo	=	$this->getInvesorBankTransInfoById($trans_id);
		$paymentId				=	$investorBankTranInfo[0]->payment_id;
		$investorId				=	$investorBankTranInfo[0]->investor_id;
		$withdrawAmt			=	$investorBankTranInfo[0]->trans_amount;

		$this->username			=	$this->getUserName('Investor', $investorId);
		$moduleName		=	"Investor Withdrawals";
		$actionSumm =	"Delete";
		$actionDet  =	"Delete of Investor Withdrawal";

		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"username", $this->username);

		
		// Delete the Investor bank Transancation Record By the transaction ID
		$deleteWhereArry		=	array("trans_id" =>"{$trans_id}");
		$this->dbDelete("investor_bank_transactions",$deleteWhereArry);
		
		// Delete the Payment Record By the Payment ID
		$deletePaymentWhereArry		=	array("payment_id" =>"{$paymentId}");
		$this->dbDelete("payments",$deletePaymentWhereArry);
	}
	
	public function bulkApproveWithDraw($postArray) {
		
		foreach($postArray['transaction_id'] as $transaction_id) {
			$this->approveWithDraw($transaction_id);
		}
	}
	
	public function bulkunApproveWithDraw($postArray) {
		
		foreach($postArray['transaction_id'] as $transaction_id) {
			$this->unApproveWithDraw($transaction_id);
		}
	}
	
	public function bulkDeleteWithDraw($postArray) {
		
		foreach($postArray['transaction_id'] as $transaction_id) {
			$this->deleteWithDraw($transaction_id);
		}
	}
	
	
		
	public function getInvestorAllWithDrawals($fromDate, $toDate, $filter_status) {
		
		$this->fromDate				= 	date('d-m-Y', strtotime(date('Y-m')." -1 month"));
		$this->toDate				= 	date('d-m-Y', strtotime(date('Y-m')." +1 month"));		
		$this->filter_status 		= 	$filter_status;
		$current_investor_id		=	$this->getCurrentInvestorID();
		$filterStatus				=	"";
		
		if (isset($_REQUEST['filter_status'])) {
		 	$this->filter_status 	= $_REQUEST['filter_status'];
			$this->fromDate			= $_REQUEST['fromdate'];
			$this->toDate			= $_REQUEST['todate'];
		} 
		
		
		if($filter_status	!=	"all"){
			$filterStatus	="	AND 	investor_bank_transactions.status = 
										if(:filter_codeparam = :unapprove_codeparam3, 
												:unapproved_codeparam1, :approved_codeparam2)";
		}
		//~ echo $filter_status.$filterStatus;
		//~ die;
		$lnListSql				=	"	SELECT	investors.investor_id,												
												investor_bank_transactions.payment_id,
											date_format(investor_bank_transactions.trans_date,'%d-%m-%Y') 	
																						trans_date,
											date_format(investor_bank_transactions.entry_date,'%d-%m-%Y') 	
																						entry_date,
												ROUND(investor_bank_transactions.trans_amount,2) trans_amount,
												( SELECT	expression
														FROM	codelist_details
														WHERE	codelist_id = :bankstatus_codeparam4
														AND		codelist_code = investor_bank_transactions.status
												) trans_status_name,
												 investor_bank_transactions.status,
												 investor_bank_transactions.trans_id
										FROM 	investors,
												investor_bank_transactions 
										WHERE  investors.investor_id 	= {$current_investor_id}
										AND		investors.investor_id 	= investor_bank_transactions.investor_id 
											{$filterStatus}
									 AND	investor_bank_transactions.trans_date
											BETWEEN :fromDate AND :toDate 
									AND		investor_bank_transactions.trans_type	=	:trans_type_codeparam5
									ORDER BY investor_bank_transactions.trans_date";
		$dataArrayLoanList		=	array();			 
		$dataArrayLoanList		=	[	"bankstatus_codeparam4" =>	INVESTOR_BANK_TRANS_STATUS,						
										"fromDate" 				=>	$this->getDbDateFormat($this->fromDate),
										"toDate" 				=>	$this->getDbDateFormat($this->toDate),
										"trans_type_codeparam5"	=>	INVESTOR_BANK_TRANSCATION_TRANS_TYPE_WITHDRAWAL
									];
		
		if($filter_status	!=	"all"){
			$dataArrayLoanListAdditional	=	[	"filter_codeparam" 			=>	$this->filter_status,
													"unapproved_codeparam1" 	=>	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED,
													"approved_codeparam2" 		=>	INVESTOR_BANK_TRANS_STATUS_VERIFIED,
													"unapprove_codeparam3"		=>	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED
												];	
			$dataArrayLoanList				=	array_merge($dataArrayLoanList,$dataArrayLoanListAdditional);
		}
		
		$this->withdrawListInfo	=	$this->dbFetchWithParam($lnListSql, $dataArrayLoanList);
		
		return ;		
		
	}
	
	public function getCurrentInvestorWithDrawInfo($processtype,$paymentId){
		
		$current_investor_id		=	$this->getCurrentInvestorID();
		$this->processbuttontype 	= 	$processtype;
		$this->investorId			=	$current_investor_id;
		
		$this->settlement_date		=	date("d-m-Y");
		$this->request_date			=	date("d-m-Y");
		if(empty($paymentId)){
			$viewRecordSql		= "SELECT	available_balance avail_bal
										FROM	investors
										WHERE	investor_id = {$current_investor_id}";
			$this->avail_bal	= $this->dbFetchOne($viewRecordSql);
		}else{
		$viewRecordSql		= "SELECT 
									ROUND(payments.trans_amount,2) withdrawal_amount,
									date_format(payments.trans_datetime,'%d-%m-%Y') settlement_date,
									payments.trans_reference_number,
									payments.remarks,
									investor_bank_transactions.trans_id,
									investor_bank_transactions.status,
									date_format(IFNULL(investor_bank_transactions.entry_date,
												{$this->settlement_date}),'%d-%m-%Y') entry_date,
									( 	SELECT	available_balance
										FROM	investors
										WHERE	investor_id = {$current_investor_id}
									) avail_bal
								FROM 
									payments,investor_bank_transactions
								WHERE 
									investor_bank_transactions.payment_id = payments.payment_id 
								AND investor_bank_transactions.investor_id = {$current_investor_id}
								AND investor_bank_transactions.trans_type = :trans_type_codeparam
								AND payments.payment_id = {$paymentId} ";
		
		$paramArray			=	["trans_type_codeparam"	=>	INVESTOR_BANK_TRANSCATION_TRANS_TYPE_WITHDRAWAL];
		$viewRecordRs		= 	$this->dbFetchWithParam($viewRecordSql,$paramArray);
		if (count($viewRecordRs) > 0) {
		
				$this->settlement_date		=	$viewRecordRs[0]->settlement_date;
				$this->request_date			=	$viewRecordRs[0]->entry_date;
				$this->withdrawal_amount	=	$viewRecordRs[0]->withdrawal_amount;
				$this->trans_ref_no			=	$viewRecordRs[0]->trans_reference_number;
				$this->remarks				=	$viewRecordRs[0]->remarks;
				$this->avail_bal			=	$viewRecordRs[0]->avail_bal;
				$this->status				=	$viewRecordRs[0]->status;
				$this->payment_id			=	$paymentId;
				$this->trans_id				=	$viewRecordRs[0]->trans_id;
			}
		}				
	}	
		
}
