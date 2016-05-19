<?php namespace App\models;
use Log;
use DB;

class AuditTrailModel extends TranWrapper {
/*---------------------------------------------------------------
 * Used for getting the details of the audit trail records
 * 
 ------------------------------------------------------------------------*/
 
	public	$tableData 	=	array();
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

	
	public function getAuditHeaderInfo($fromDate, $toDate, $filterModule) {
		$auditSql	=	"	SELECT 	audit_key,
									user_id,
									module_name,
									action_summary,
									action_detail,
									action_datetime,
									key_displayfieldname,
									key_displayfieldvalue
							FROM	audit_master
							WHERE	action_datetime between :from_date and :to_date
							AND		module_name = if (:module1 = 'ALL', module_name, :module2) ";

		$auditDb	=	DB::connection('auditDb');
		$whereArray	=	array("from_date"	=>	$fromDate, "to_date" => $toDate, 
							  "module1"		=>	$filterModule, "module2" => $filterModule);
		
		$header_rs	=	$auditDb::select($auditSql, $whereArray);
		
		return $header_rs;
	}
	
	public function getAuditDetails($audit_key) {
		// Get the object referring to the Audit DB
		$auditDb	=	DB::connection('auditDb');
		
		
		// The tables that get affected by each module
		$moduleTables	=	["Borrower Profile"		=>	["audit_borrower_banks", "audit_borrower_directors",
														 "audit_borrower_financial_info", "audit_borrowers",
														 "audit_borrower_financial_ratios"],
							 "Investor Profile"		=>	["audit_investor_banks", "audit_investors", "audit_users"],
							 "Investor Deposit" 	=>	["audit_investor_bank_transactions", "audit_payments"],
							 "Investor Withdrawals" => 	["audit_investor_bank_transactions", "audit_payments"],
							 "Loan Updates"			=> 	["audit_loan_approval_comments", "audit_loan_docs_submitted", "audit_loans"],
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
