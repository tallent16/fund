<?php namespace App\models;
use Log;
use DB;

class AuditTrailModel extends TranWrapper {
/*---------------------------------------------------------------
 * Used for getting the details of the audit trail records
 * 
 ------------------------------------------------------------------------*/
    public  $modlist 			= array();
    public  $actionlist 		= array();
    public  $tablelist 			= array();
    public  $userlist 			= array();
    public  $auditkeylist		= array();
    public  $newlist			= array();
   
    public  $fromDate 			= "";
    public  $toDate 			= "";
    public  $filtermodule 		= "";
    public  $actionmodule 		= "";
    public  $header_rs 			= array();
	public	$tableData 			= array();
	public 	$actionListValue	=	"all";
	
	public  $tableNiceNames = [	'audit_borrower_banks ' => 'Borrower Bank Info',
								'audit_borrower_directors' => 'Borrower Directors Info',
								'audit_borrower_financial_info ' => 'Financial Info',
								'audit_borrower_financial_ratios' => 'Financial Ratios',
								'audit_borrower_repayment_schedule' => 'Borrower Repayment Schedule',
								'audit_borrowers' => 'Borrower Info',
								'audit_disbursements' => 'Disbursements to Borrowers',
								'audit_investor_bank_transactions ' => 'Investor Bank Transactions',
								'audit_investor_banks ' => 'Investor Banks Info',
								'audit_investor_repayment_schedule ' => 'Investor Repayment Schedule',
								'audit_investors ' => 'Investors Info',
								'audit_loan_approval_comments ' => 'Loan Comments ',
								'audit_loan_bids ' => 'Loan Bids',
								'audit_loan_docs_submitted ' => 'Loan Documents Submitted',
								'audit_loans ' => 'Loan Information',
								'audit_payments' => 'Payment Information',
								'audit_users' => 'User Information'];

	public function getModuleDropdown(){
			$modulesql	 	=   "SELECT distinct module_name 
										FROM audit_master";
			$auditDb		=	DB::connection('auditDb');
			$modulelist		=	$auditDb->select($modulesql);
			$this->modlist['all'] 	=	'All';
			foreach($modulelist as $list){
					$this->modlist[$list->module_name] = $list->module_name;
			}		
			return $this->modlist;					
	}
	
	public function getActionDropdown($module){
		if($module == "All"){
				
			$actionsql	 	=   "SELECT distinct action_summary 
										FROM audit_master ";
		}else{
			$actionsql	 	=   "SELECT distinct action_summary 
										FROM audit_master  where module_name = '{$module}' ";
		}
			$auditDb		=	DB::connection('auditDb');
			$actionlist		=	$auditDb->select($actionsql);
		    $this->actionlist['all'] 	=	'All';
			foreach($actionlist as $list){
					$this->actionlist[$list->action_summary] = $list->action_summary;
			}		
			return $this->actionlist;			
	}
	
	public function getAuditHeaderInfo($fromDate, $toDate, $filterModule, $filteraction) {
		$this->fromDate				= 	date('d-m-Y', strtotime(date('Y-m')." -1 month"));
		$this->toDate				= 	date('d-m-Y', strtotime(date('Y-m')." +1 month"));		
		$this->filtermodule			=   "all";
		$this->actionmodule			=   "all";
		
		if (isset($_REQUEST['action_list']) || isset($_REQUEST['module_list']) ) {
		 	$this->filtermodule		= $_REQUEST['module_list'];
		 	$this->actionmodule		= $_REQUEST['action_list'];
			$this->fromDate			= $_REQUEST['fromdate'];
			$this->toDate			= $_REQUEST['todate'];
		} 
		$auditDb	=	DB::connection('auditDb');
				
		$auditSql	=	"	SELECT 	audit_key,
									user_id,	
									(select moneymatch_new.users.username  from moneymatch_new.users where mm_audit.audit_master.user_id =moneymatch_new.users.user_id )	as username,								
									module_name,
									action_summary,
									action_detail,
									DATE_FORMAT(action_datetime, '%d-%m-%Y') AS action_datetime,
									key_displayfieldname,
									key_displayfieldvalue
							FROM	audit_master
							WHERE	action_datetime between :from_date and :to_date  
							AND		module_name = if (:module1 = 'all', module_name, :module2)
							AND 	action_summary = if (:filteraction1 = 'all', action_summary, :filteraction2) 							
							";
		
		$whereArray	=	array("from_date"		=>	$this->getDbDateFormat($this->fromDate)	,
							  "to_date" 		=>  $this->getDbDateFormat($this->toDate), 
							  "module1"			=>	$this->filtermodule	, "module2" => $this->filtermodule	,
							  "filteraction1" 	=>  $this->actionmodule	,"filteraction2" => $this->actionmodule	);
		
		$this->header_rs	=	$auditDb->select($auditSql, $whereArray);		
		
		
		$row			=	array();
		if ($this->header_rs) {
			foreach ($this->header_rs as $Row) {
				
				$row[] 	= array(
									"DT_RowId"=>$Row->audit_key,
									"user_id"=>$Row->user_id,
									"username"=>$Row->username,	
									"module_name"=>$Row->module_name,									
									"action_summary"=>$Row->action_summary,									
									"action_date"=>$Row->action_datetime,									
									"display_key"=>$Row->key_displayfieldname,									
									"display_value"=>$Row->key_displayfieldvalue									
								);	
			}
		}
			
		return $row;	
		
	}
	
	public function getTableList($module_name,$modulenames){
		
		$moduleName = $module_name.' '.$modulenames;
		$auditDb		=	DB::connection('auditDb');
		$moduleTables	=	[
		
		"Borrower Profile"		=>	[ 
									"audit_borrowers"					=>"Borrower Main Info",	
									"audit_borrower_banks"		  		=>"Borrower Bank Info",
									"audit_borrower_directors"			=>"Borrower Directors Info",
									"audit_borrower_financial_info"		=>"Financial Information of Borrower",
									"audit_borrower_financial_ratios"	=>"Financial Ratios of Borrower",
									"audit_profile_comments"			=>"Profile Comments"
									],
		"Investor Profile"		=>	[
									"audit_investors"					=>"Investor Main Info",
									"audit_investor_banks"				=>"Investor Bank Info",
									"audit_profile_comments"			=>"Profile Comments"
									],
		"Bulk Emailer"			=> 	[
									"audit_bulk_emails"					=>"Emailers",									
									],
		"Bulk Notification"		=> 	[
									"audit_notifications"				=>"Notifications",									
									],		
		"Investor Deposit" 		=>	[
									"audit_investors"					=>"Investor Main Info",
									"audit_investor_bank_transactions"	=>"Investor Bank Transcation",
									"audit_payments"					=>"Payments"
									],
		"Investor Withdrawal" 	=> 	[
									"audit_investors"					=>"Investor Main Info",
									"audit_investor_bank_transactions"	=>"Investor Bank Transcation",
									"audit_payments"					=>"Payments"
									],						
		"Loans Info"			=>  [
									"audit_loans"						=>"Loans Info", 
									"audit_loan_docs_submitted"			=>"Loan Documents Submitted",
									"audit_loan_approval_comments"		=>"Loan Comments Approval"
									],							 
		"Loan Process" 			=> 	[
									"audit_loans"						=>"Loans Info",
									"audit_loan_bids"					=>"Loan Bids Info",
									"audit_disbursements"				=>"Disbursements Info",
									"audit_payments"					=>"Payments", 
									
									],
		"Loan Repayment" 		=>	[
									"audit_loans"						=>"Loans Info",
									"audit_loan_reschedule_info"		=>"Loan Reschedule Info",
									"audit_investor_rescheduled_details"=>"Investor Rescheduled Details",
									"audit_borrower_rescheduled_details"=>"Borrower Rescheduled Details",						
									"audit_borrower_repayment_schedule" =>"Borrower Loan Repayment Schedule", 
									"audit_investor_repayment_schedule" =>"Investor Loan Repayment Schedule",
									"audit_payments"					=>"Payments", 
									]
							];
		
		$tables		=	$moduleTables[$moduleName];	
		
		foreach($tables as $key=>$value){
			$out[$key]	=	$value;
		}
					
		return $out;
	}
	
	public function getAuditInfo($tablename,$auditkey){
		$auditDb		=	DB::connection('auditDb');		
		
		$sql			=	"SELECT audit_columns('$tablename') columns";				

		$auditdata		=	$auditDb->select($sql);
		
		$displaysql		=	"SELECT col_name, col_dispname
									FROM  audit_tablecolumns 
									WHERE tab_name = '{$tablename}'
									";
									
		$displaydata	=	$auditDb->select($displaysql);
	
		foreach ($displaydata as $value) {
			$array1[$value->col_name] = $value->col_dispname;
		}
		
		$sql1			=	"SELECT ".$auditdata[0]->columns.",audit_when FROM (SELECT ".$auditdata[0]->columns.",audit_when
									FROM {$tablename} as old
									WHERE audit_key = {$auditkey}
									order by audit_subkey desc LIMIT 0 , 2) as newrec group by audit_when";

		$auditdata1		=	$auditDb->select($sql1);
		
		$finalArray		= array();
		foreach ($auditdata1 as $row) {
			$finalArrayRow = array();
			foreach ($row as $key => $value) {
				if ($key == 'audit_when') 
					continue;
				$finalArrayRow[$array1[$key]] = $value;
			}
			$finalArray[] = $finalArrayRow;
		}
		
		if($finalArray){							
			return $finalArray;	
		}else{			
			return -1;			
		}				
	}	
	
	//below are done by venkat sir...
	
	public function getAuditDetails($audit_key) {
		// Get the object referring to the Audit DB
		$auditDb	=	DB::connection('auditDb');
		//~ echo 'sdns';die;
		
		// The tables that get affected by each module
		$moduleTables	=	["Borrower Profile"		=>	["audit_borrower_banks", "audit_borrower_directors",
														 "audit_borrower_financial_info", "audit_borrowers",
														 "audit_borrower_financial_ratios"],
							 "Investor Profile"		=>	["audit_investor_banks", "audit_investors", "audit_users"],
							 "Investor Deposit" 	=>	["audit_investor_bank_transactions", "audit_payments"],
							 "Investor Withdrawals" => 	["audit_investor_bank_transactions", "audit_payments"],
							 "Loan Updates"			=> 	["audit_loan_approval_comments", "audit_loan_docs_submitted", "audit_loans"],
							 "Loans"				=> 	["audit_loans","audit_loan_docs_submitted"],
							 "Loan Bids" 			=> 	["audit_loan_bids", "audit_investors"],
							 "Loan Process" 		=> 	["audit_loans", "audit_borrower_repayment_schedule", "audit_disbursements",
														 "audit_investor_repayment_schedule", "audit_payments"],
							 "Loan Repayments" 		=>	["audit_loans", "audit_borrower_repayment_schedule", "audit_disbursements",
														 "audit_investor_repayment_schedule", "audit_payments", "audit_investors"]];
							 			 
		// Get the Module name associated with the audit_key
		$moduleName	=	$auditDb::table('audit_master')->where('audit_key', $audit_key)->pluck("module_name");
		
		$tables		=	$moduleTables[$moduleName];
		$sql		=	"	SELECT	*	FROM	audit_tablecolumns
							WHERE	tab_name = :tab_name
							ORDER BY col_disp_order ";
			
		foreach	($tables	as $tableName) {
			$tabCols_rs	=	$auditDb::select ($sql, ["tab_name" =>	$tableName]);
			$tableSql	= 	"SELECT ";
			$first		=	true;
			unset($colDispVal);
			$colDispVal	=	array();
			
			foreach ($tabCols_rs as $tabCols_row) {
				$tableSql = ($first?"":", ").$tabCols_row->col_name;
				$colDispVal[$tabCols_row->col_name] = $tabCols_row->col_dispname;
				$first  = false;
			}

			$tableSql	=	", audit_action, audit_when FROM $tableName WHERE audit_key = :audit_key ";
			$tableRs	=	$auditDb::select($tableSql, ["audit_key" => $audit_key]);
			
			if (in_array(["audit_borrower_financial_info", "audit_borrower_financial_ratios", "audit_loan_docs_submitted"], $tableName)) {
				// These tables have a special way of arranging the display 
				/* TODO */
				/* to be implemented */
				continue;
			
			}

			if (count($tableRs) > 0) {
				foreach ($tableRs as $tableRow) {
					$this->tableData[$tableName]["action"] = $tableRow->audit_action;
					$this->tableData[$tableName]["nicename"] = $this->tableNiceNames[$tableName];
					
					foreach ($tableRow as $colname => $value) {
						if (in_array(["audit_action", "audit_when"], $colname)) {
							// don't process these special columns
							continue;
						}
						$this->tableData[$tableName][$colname][$tableRow->auditWhen] = $value;
						$this->tableData[$tableName][$colname]["display_name"] = $colDispVal[$colname];
					}
					
				}
			}
		}
	}
	
	public function tableSpecialDisplay($tableName, $tableRs, $auditKey) {
	// This is for displaying the tables audit_borrower_financial_info, audit_borrower_financial_ratios, 
	// audit_loan_docs_submitted
	
		$lookupArray	=	array();
		
		
		switch ($tableName) {
			case 'audit_borrower_financial_info':
				$sql	=	"	select 	ratio_name, 
										ratio_value_current_year, 
										ratio_value_previous_year
								from	$tableName
								where	audit_key = :auditkey";
				$tmpRs	=	DB::select($sql, ["auditkey" => $auditKey]);
				$this->tableData[$tableName]["action"] = $tableRow->audit_action;
				$this->tableData[$tableName]["nicename"] = $this->tableNiceNames[$tableName];
				
				foreach ($tmpRs	as $tmpRow) {
					$ratioName	=	$tmpRow->ratio_name;
					$this->tableData[$tableName][$ratioName."_curr_year"][$tableRow->auditWhen] = $tmpRow->ratio_value_current_year;
					$this->tableData[$tableName][$ratioName."_prev_year"][$tableRow->auditWhen] = $tmpRow->ratio_value_previous_year;
				}
				break;
								
			
			case 'audit_borrower_financial_ratios':
				$sql	=	"	select	indicator_name,
										indicator_value
								from	$tableName
								where	audit_key  = :auditkey";
				$tmpRs	=	DB::select($sql, ["auditkey" => $auditKey]);
				$this->tableData[$tableName]["action"] = $tableRow->audit_action;
				$this->tableData[$tableName]["nicename"] = $this->tableNiceNames[$tableName];

				foreach ($tmpRs	as $tmpRow) {
					$indicname	=	$tmpRow->indicator_name;
					$this->tableData[$tableName][$indicname][$tableRow->auditWhen] = $tmpRow->ratio_value_current_year;
					$this->tableData[$tableName][$indicname][$tableRow->auditWhen] = $tmpRow->ratio_value_previous_year;
				}
				break;
								
				
			
			case 'audit_loan_docs_submitted':
				$sql	=	"	SELECT 	short_name,
										loan_doc_url
								FROM	audit_loan_docs_submitted a,
										audit_loan_doc_master b
								where	a.loan_doc_id = b.loan_doc_id
								AND		a.audit_key = :audit_key ";
				//~ $tmpRs	=	
				break;
		}		
	}
}
