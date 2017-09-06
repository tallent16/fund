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
	public	$investorId						=	"";
	public	$trans_id						=	0;
	public	$payment_id						=	0;
	public	$deposit_date					=	"";
	public	$deposit_amount					=	"0.00";
	public	$trans_ref_no					=	"";
	public	$remarks						=	"";
	public	$status							=	"";
	
	public function processDropDowns() {
				
				
		$filterSql		=	"	SELECT	codelist_id,
										codelist_code,
										codelist_value,
										expression
								FROM	codelist_details
								WHERE	codelist_id in (31) 
								ORDER BY codelist_code DESC"												
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
		
		$this->fromDate				= 	date('d-m-Y', strtotime(date('Y-m')." -2 month"));
		$this->toDate				= 	date('d-m-Y', strtotime(date('Y-m')." +2 month"));		
		$this->filter_status 		= 	3;
		$applyFilter				=	0;
		
		if (isset($_REQUEST['filter_transcations'])) {
		 	$this->filter_status 	= $_REQUEST['filter_transcations'];
			$this->fromDate			= $_REQUEST['fromdate'];
			$this->toDate			= $_REQUEST['todate'];
			$applyFilter			=	1;	
		} 
		
		$lnListSql				=	"SELECT 
											concat(users.firstname,' ',users.lastname) fname,											
											users.email,
											users.mobile,											investors.investor_id,																
											investor_bank_transactions.payment_id,
											CONCAT('INV-DEP-',investor_banks.investor_bankid) cust_trans_id,
											date_format(investor_bank_transactions.trans_date,'%d-%m-%Y') 	
																						trans_date,
											format(ROUND(investor_bank_transactions.trans_amount,2),2) trans_amount,
											( SELECT	expression
													FROM	codelist_details
													WHERE	codelist_id = :bankstatus_codeparam4
													AND		codelist_code = investor_bank_transactions.status
											) trans_status_name,
											 investor_bank_transactions.status,
											 investor_bank_transactions.trans_id
									FROM 	investors,
											users,
											investor_bank_transactions,
											investor_banks
									WHERE   investors.user_id   	= users.user_id 
									AND 	investors.investor_id 	= investor_bank_transactions.investor_id 
									AND 	investor_bank_transactions.status = if(:filter_codeparam = 3, investor_bank_transactions.status, :filter_codeparam2)
									AND		investor_bank_transactions.trans_date BETWEEN 
											if (:filter_codeparam3 = 0, investor_bank_transactions.trans_date, :fromDate) AND 
											if (:filter_codeparam4 = 0, investor_bank_transactions.trans_date, :toDate)	
									AND 	investor_banks.investor_id = investor_bank_transactions.investor_id													
									AND		investor_bank_transactions.trans_type	=	:trans_type_codeparam5
									ORDER BY investor_bank_transactions.trans_date";
						
		$dataArrayLoanList		=	[															
										"filter_codeparam" 		=>	$this->filter_status,
										
										"filter_codeparam2" 	=>	$this->filter_status,
										
										"filter_codeparam3" 	=>	$applyFilter,
										
										"filter_codeparam4" 	=>	$applyFilter,
										
										//~ "unapproved_codeparam1" => 	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED,										
										//~ "approved_codeparam2" 	=> 	INVESTOR_BANK_TRANS_STATUS_VERIFIED,										
										//~ "unapprove_codeparam3" 	=>	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED,
										"bankstatus_codeparam4" =>	INVESTOR_BANK_TRANS_STATUS,																				
										"fromDate" 				=>	$this->getDbDateFormat($this->fromDate),
										"toDate" 				=>	$this->getDbDateFormat($this->toDate),
										
										"trans_type_codeparam5"	=>	INVESTOR_BANK_TRANSCATION_TRANS_TYPE_DEPOSIT
									];

		$this->depositListInfo	=	$this->dbFetchWithParam($lnListSql, $dataArrayLoanList);
		//~ echo "<pre>",print_r($dataArrayLoanList),"</pre>";
		$row			=	array();
		if ($this->depositListInfo) {
			foreach ($this->depositListInfo as $Row) {
				
				$row[] 	= array(
									"DT_RowId"=>"row_".$Row->investor_id,
									"investor_id"=>$Row->investor_id,
									"payment_id"=>$Row->payment_id,
									"ctrans_id"=>$Row->cust_trans_id,
									"trans_id"=>$Row->trans_id,
									"name"=>$Row->fname,									
									"email"=>$Row->email,
									"mobile"=>$Row->mobile,									
									"trans_date"=>$Row->trans_date,
									"trans_amount"=>$Row->trans_amount,									
									"status"=>$Row->status,
									"trans_status_name"=>$Row->trans_status_name										
								);	
			}
		}
			
		return $row;			
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
								
		//~ $invfilter_rs				= 	$this->dbFetchAll($invfilterSql);
		
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
			
			$this->deposit_date	=	date("d-m-Y H:i:s");
			$viewRecordSql		= "SELECT 
										ROUND(payments.trans_amount,2) trans_amount,
										date_format(payments.trans_datetime,'%d-%m-%Y %H:%i:%s') trans_date,
										payments.trans_reference_number,
										payments.remarks,
										investor_bank_transactions.trans_id,
										investor_bank_transactions.status
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
					$this->trans_id			=	$viewRecordRs[0]->trans_id;
					$this->status			=	$viewRecordRs[0]->status;
					$this->payment_id		=	$paymentId;
			}
	}	

	public function saveInvestorDeposits($postArray) {
		
		$tranType				=	$postArray['tranType'];
		$trans_id				=	$postArray['trans_id'];
		$paymentId				=	$postArray['payment_id'];
		$this->investorId		=	$postArray['investor_id'];
		$this->deposit_amount	=	$this->makeFloat($postArray['deposit_amount']);
		$this->deposit_date		=	date("Y-m-d H:i:s", strtotime($postArray['deposit_date']));
		$this->trans_ref_no		=	$postArray['trans_ref_no'];
		$this->remarks			=	$postArray['remarks'];
		$currency				=	'SGD'; // Hardcoded value
		//~ echo "<pre>",print_r($this->deposit_date),"</pre>"; die;
		$this->username			=	$this->getUserName('Investor', $this->investorId);
		$moduleName		=	"Investor Deposit";

		// Audit Trail related Settings
		if(isset($postArray["isSaveButton"]) && $postArray["isSaveButton"]	!=	"yes") {
			$actionSumm =	"Approval";
			$actionDet  =	"Approval of Investor Deposit";
		} else {
			if ($tranType != "add") {
				$actionSumm =	"Update";
				$actionDet  =	"Update Investor Deposit";
			} else {
				$actionSumm =	"Add";
				$actionDet	=	"Add New Investor Deposit";
			}
		}

		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"username", $this->username);
	
		$invBankTransStatus			=	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED; 
		$paymentStatus				=	PAYMENT_STATUS_UNVERIFIED;

		$depositpaymentInsert_data	=	array(
										'trans_datetime' =>$this->deposit_date,
										'trans_type' => PAYMENT_TRANSCATION_INVESTOR_DEPOSIT,							
										'trans_amount' => $this->deposit_amount,
										'currency' => $currency,
										'trans_reference_number' => $this->trans_ref_no,
										'status' => $paymentStatus,
										'remarks' => $this->remarks);

		$depositInsert_data			=	array(								
										'investor_id' => $this->investorId,									
										'trans_type' => INVESTOR_BANK_TRANSCATION_TRANS_TYPE_DEPOSIT,
										'trans_date' => $this->deposit_date,
										'trans_amount' => $this->deposit_amount,
										'trans_currency' => $currency,
										'status' => $invBankTransStatus);	
				
		if($tranType	==	"add") {
			
			$paymentId 							=	$this->dbInsert("payments", $depositpaymentInsert_data, 1);
			$depositInsert_data['payment_id']	=	$paymentId;
			$trans_id	=	$this->dbInsert("investor_bank_transactions", $depositInsert_data, 1);
		}else{
			
			if($paymentId	==	0) {
				$paymentId 			=	$this->dbInsert("payments", $depositpaymentInsert_data, 1);
			}else{
				
				$wherePaymentArry	=	array("payment_id" =>"{$paymentId}");
				$this->dbUpdate('payments', $depositpaymentInsert_data, $wherePaymentArry);
			}
			
			$depositInsert_data['payment_id']	=	$paymentId;
			$whereDepositArry					=	array("trans_id" =>"{$trans_id}");
			
			$this->dbUpdate('investor_bank_transactions', $depositInsert_data, $whereDepositArry);
		}
		//Update the Investor Available balance amount
		if(isset($postArray["isSaveButton"]) && $postArray["isSaveButton"]	!=	"yes"){
			$this->approveDeposit($trans_id);
		}
	}
	
	public function approveDeposit($trans_id) {
		//~ \Log::error("approve Deposit:".$trans_id);
		$investorBankTranInfo	=	$this->getInvesorBankTransInfoById($trans_id);
		$paymentId				=	$investorBankTranInfo[0]->payment_id;
		$investorId				=	$investorBankTranInfo[0]->investor_id;
		$this->username			=	$this->getUserName('Investor', $investorId);
		
		$depositAmt				=	$investorBankTranInfo[0]->trans_amount;

		$moduleName		=	"Investor Deposit";

		// Audit Trail related Settings
		$actionSumm =	"Approval";
		$actionDet  =	"Approval of Investor Deposit";

		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"username", $this->username);
								
		// Update the Investor bank Transancation Status Approved
		$whereDepositArry		=	array("trans_id" =>"{$trans_id}");
		$depositdataArry		=	array("status"	=>	INVESTOR_BANK_TRANS_STATUS_VERIFIED);
		$this->dbUpdate('investor_bank_transactions', $depositdataArry, $whereDepositArry);
		
		// Update the Investor payments Status Approved
		$wherePaymentArry		=	array("payment_id" =>"{$paymentId}");
		$depositPaymentArry		=	array("status"	=>	PAYMENT_STATUS_VERIFIED);
		$this->dbUpdate('payments', $depositPaymentArry, $wherePaymentArry);
		
		// Update the Investor Avaliable balance 
		$available_balance		=	$this->getInvestorAvailableBalanceById($investorId);
		$resetAvailableBalance	=	$available_balance	+	$depositAmt;
		
		$whereInvestorArray		=	array("investor_id"	=>	$investorId);
		$dataInvestorArray		=	array("available_balance"	=>	$resetAvailableBalance);
		
		$this->dbUpdate('investors', $dataInvestorArray, $whereInvestorArray);
		$invUserInfo		=	$this->getInvestorIdByUserInfo($investorId);
		$moneymatchSettings = 	$this->getMailSettingsDetail();
		$fields 			= 	array(	'[investor_firstname]', '[investor_lastname]',
										'[investor_current_balance]','[application_name]'
										);
		$replace_array 		= 	array( 	$invUserInfo->firstname,
										$invUserInfo->lastname,
										$resetAvailableBalance, 
										$moneymatchSettings[0]->application_name);
		
		$this->sendMailByModule("investor_deposit_approved",$invUserInfo->email,$fields,$replace_array);
	}
	
	public function unApproveDeposit($trans_id) {
		
		$investorBankTranInfo	=	$this->getInvesorBankTransInfoById($trans_id);
		$paymentId				=	$investorBankTranInfo[0]->payment_id;
		$investorId				=	$investorBankTranInfo[0]->investor_id;
		
		$depositAmt				=	$investorBankTranInfo[0]->trans_amount;

		$this->username			=	$this->getUserName('Investor', $investorId);
		$moduleName		=	"Investor Deposit";

		// Audit Trail related Settings
		$actionSumm =	"Unapproval";
		$actionDet  =	"Unapproval of Investor Deposit";

		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"username", $this->username);

		
		// Update the Investor bank Transancation Status Approved
		$whereDepositArry		=	array("trans_id" =>"{$trans_id}");
		$depositdataArry		=	array("status"	=>	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED);
		$this->dbUpdate('investor_bank_transactions', $depositdataArry, $whereDepositArry);
		
		// Update the Investor payments Status Approved
		$wherePaymentArry		=	array("payment_id" =>"{$paymentId}");
		$depositPaymentArry		=	array("status"	=>	PAYMENT_STATUS_UNVERIFIED);
		$this->dbUpdate('payments', $depositPaymentArry, $wherePaymentArry);
		
		// Update the Investor Avaliable balance 
		$available_balance		=	$this->getInvestorAvailableBalanceById($investorId);
		$resetAvailableBalance	=	$available_balance	-	$depositAmt;
		
		$whereInvestorArray		=	array("investor_id"	=>	$investorId);
		$dataInvestorArray		=	array("available_balance"	=>	$resetAvailableBalance);
		
		$this->dbUpdate('investors', $dataInvestorArray, $whereInvestorArray);
		
		$invUserInfo		=	$this->getInvestorIdByUserInfo($investorId);
		$moneymatchSettings = $this->getMailSettingsDetail();
		
		$fields 			= 	array(	'[investor_firstname]', '[investor_lastname]',
										'[investor_current_balance]','[application_name]'
										);
		$replace_array 		= 	array( 	$invUserInfo->firstname,
										$invUserInfo->lastname,
										$resetAvailableBalance, 
										$moneymatchSettings[0]->application_name);
		
		$this->sendMailByModule("investor_deposit_unapproved",$invUserInfo->email,$fields,$replace_array);
	}
	
	public function deleteDeposit($trans_id) {
		
		$investorBankTranInfo	=	$this->getInvesorBankTransInfoById($trans_id);
		$paymentId				=	$investorBankTranInfo[0]->payment_id;
		$investorId				=	$investorBankTranInfo[0]->investor_id;
		$depositAmt				=	$investorBankTranInfo[0]->trans_amount;

		$this->username			=	$this->getUserName('Investor', $investorId);
		$moduleName		=	"Investor Deposit";

		// Audit Trail related Settings
		$actionSumm =	"Delete";
		$actionDet  =	"Delete Investor Deposit";

		$this->setAuditOn($moduleName, $actionSumm, $actionDet,
								"username", $this->username);
		
		// Delete the Investor bank Transancation Record By the transaction ID
		$whereDepositArry		=	array("trans_id" =>"{$trans_id}");
		$this->dbDelete("investor_bank_transactions",$whereDepositArry);
		
		// Delete the Payment Record By the Payment ID
		$wherePaymentArry		=	array("payment_id" =>"{$paymentId}");
		$this->dbDelete("payments",$wherePaymentArry);
	}
	
	public function bulkApproveDeposit($postArray) {
		
		foreach($postArray['transaction_id'] as $transaction_id) {
			$this->approveDeposit($transaction_id);
		}
	}
	
	public function bulkUnApproveDeposit($postArray) {
		
		foreach($postArray['transaction_id'] as $transaction_id) {
			$this->unApproveDeposit($transaction_id);
		}
	}
	
	public function bulkDeleteDeposit($postArray) {
		
		foreach($postArray['transaction_id'] as $transaction_id) {
			$this->deleteDeposit($transaction_id);
		}
	}
	
		
	public function getInvestorAllDeposits($fromDate, $toDate, $filter_status) {
		
		$this->fromDate				= 	date('d-m-Y', strtotime(date('Y-m')." -1 month"));
		$this->toDate				= 	date('d-m-Y', strtotime(date('Y-m')." +1 month"));		
		$this->filter_status 		= 	3;
		$current_investor_id		=	$this->getCurrentInvestorID();
		$filterStatus				=	"";
		
		if (isset($_REQUEST['filter_status'])) {
		 	$this->filter_status 	= $_REQUEST['filter_status'];
			$this->fromDate			= $_REQUEST['fromdate'];
			$this->toDate			= $_REQUEST['todate'];
		} 
		
		
		if($filter_status	!=	"3"){
			$filterStatus	="	AND 	investor_bank_transactions.status = 
										if(:filter_codeparam = :unapprove_codeparam3, 
												:unapproved_codeparam1, :approved_codeparam2)";
		}
		
		$lnListSql				=	"	SELECT	investors.investor_id,
												investor_bank_transactions.payment_id,
												date_format(investor_bank_transactions.trans_date,'%d-%m-%Y') 	
																							trans_date,
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
										"trans_type_codeparam5"	=>	INVESTOR_BANK_TRANSCATION_TRANS_TYPE_DEPOSIT
									];
		
		if($filter_status	!=	"3"){
			$dataArrayLoanListAdditional	=	[	"filter_codeparam" 			=>	$this->filter_status,
													"unapproved_codeparam1" 	=>	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED,
													"approved_codeparam2" 		=>	INVESTOR_BANK_TRANS_STATUS_VERIFIED,
													"unapprove_codeparam3"	=>	INVESTOR_BANK_TRANS_STATUS_UNVERIFIED
												];	
			$dataArrayLoanList				=	array_merge($dataArrayLoanList,$dataArrayLoanListAdditional);
		}
		
		$this->depositListInfo	=	$this->dbFetchWithParam($lnListSql, $dataArrayLoanList);
	
		return ;		
		
	}
	
	public function getCurrentInvestorDepositInfo($processtype,$paymentId){
			
			$this->deposit_date			=	date("d-m-Y H:i:s");
			
			$current_investor_id		=	$this->getCurrentInvestorID();
			$this->processbuttontype 	= 	$processtype;
			$this->investorId			=	$current_investor_id;
			$viewRecordSql				= "SELECT 
													ROUND(payments.trans_amount,2) trans_amount,
													date_format(payments.trans_datetime,'%d-%m-%Y %H:%i:%s') trans_date,
													payments.trans_reference_number,
													payments.remarks,
													investor_bank_transactions.trans_id,
													investor_bank_transactions.status
											FROM 
													payments,investor_bank_transactions
											WHERE 
													investor_bank_transactions.payment_id = payments.payment_id 
											AND 	investor_bank_transactions.investor_id = {$current_investor_id}
											AND 	investor_bank_transactions.trans_type = :trans_type_codeparam
											AND		payments.payment_id = {$paymentId} ";
			
			$paramArray			=	["trans_type_codeparam"	=>	INVESTOR_BANK_TRANSCATION_TRANS_TYPE_DEPOSIT];
			$viewRecordRs		= 	$this->dbFetchWithParam($viewRecordSql,$paramArray);
			
			if (count($viewRecordRs) > 0) {
			
					$this->deposit_date		=	$viewRecordRs[0]->trans_date;
					$this->deposit_amount	=	$viewRecordRs[0]->trans_amount;
					$this->trans_ref_no		=	$viewRecordRs[0]->trans_reference_number;
					$this->remarks			=	$viewRecordRs[0]->remarks;
					$this->trans_id			=	$viewRecordRs[0]->trans_id;
					$this->status			=	$viewRecordRs[0]->status;
					$this->payment_id		=	$paymentId;
			}
			//~ echo "<pre>",print_r($viewRecordRs),"</pre>"; die;
			echo $this->deposit_date;
	}	
		
}
