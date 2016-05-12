<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class MoneyMatchModel extends Model {

	public $auditKey = 0;
	private $auditDb;
	public $auditFlag = false;
	
	public function constructSelectOption($options, $displayColumn, $valueColumn, $currentValue, $defaultOption) {
		// To construct the options required for HTML Select 

		$htmlOptions = "";
		$optionCount = count($options);
		
		$htmlOptions   = ($defaultOption == "" ? "": "<option value=''>{$defaultOption}</option>\n");
		$selected	 = "";
	
		foreach ($options as $optionRow) {
			$displayVal = $optionRow[$displayColumn];
			$valueVal = $optionRow[$valueColumn];
			
			$selected = ($valueVal == $currentValue ? "Selected": "");
			
			$htmlOptions = $htmlOptions . "<option value='{$valueVal}' {$selected}> {$displayVal}</option>\n";
		}

		return $htmlOptions;
	}
	
	public function makeFloat($inputStr) {
		
		$replaceValues = array(",", "(", ")");
		$outputstr = $inputStr;
		foreach ($replaceValues as $replstr) {
			$outputstr = str_replace($replstr, "", $outputstr);
		}

		if (substr($inputStr, 0,1) == "(") {
			// return -1 * floatval($outputstr);
		} 
		
		return floatval($outputstr);
		
	}
	
	public function getDbDateFormat($formDate) {
		// The form uses date in the format of dd-mm-yyyy; when saving to db we need to have it as yyyy-mm-dd
		$dbDate = substr($formDate, 6,4)."-".substr($formDate, 3, 2)."-".substr($formDate,0,2);
		return $dbDate;
	}
	
	public function dbInsert($tableName, $dataArray, $returnLastValue) {
		$currDatabase	= \Config::get('database.connections.mysql.database');
		$result			=	"";
		try {
			$id 			= 	DB::table($tableName)->insertGetId($dataArray);
			
			if ($returnLastValue) {
				$result = $id;
				if ($this->auditFlag) {
					// The data array will not have
					$tmpRs	=	DB::select("SELECT column_name from information_schema.columns 
									where table_schema = $currDatabase and table_name = $tableName 
									and extra = 'auto_increment'");
					$aiColname	=	$tmpRs[0]->column_name;
					$dataArray[$aiColname] = $result;
				}
			}
			if ($this->auditFlag) {
				$this->recordAuditInsert($tableName, $dataArray);
			}
		}catch (\Exception $e) {
			
			$this->dbErrorHandler($e);
			return false;
		}
			
		return $result;
	}
	
	public function dbUpdate($tableName, $dataArray, $where) {
		try {
				$this->recordAuditUpdate($tableName, $dataArray, $where);

			if ($this->auditFlag) {
			}
			DB::table($tableName)->where($where)->update($dataArray);
		}catch (\Exception $e) {
			$this->dbErrorHandler($e);
			return false;
		}
		return true;
	}
	
	public function dbDelete($tableName,$where) {
		
		DB::table($tableName)->where($where)->delete();
	}
	
	public function dbFetchAll($sqlStatement) {
		
		try {
			
			$sqlStat_rs		=	 DB::select($sqlStatement);
			
		} catch (\Exception $e) {
			
			$this->dbErrorHandler($e);
			return false;
		}
		return $sqlStat_rs;
	}
	
	public function dbFetchOne($sqlStatement) {
		
		$pdoDB = DB::connection()->getPdo();
		$query = $pdoDB->prepare($sqlStatement);
		$query->execute();
		$colname = $query->fetchColumn();
		return	$colname;
	}
	
	public function dbFetchRow($sqlStatement) {
		
		$pdoDB = DB::connection()->getPdo();
		$query = $pdoDB->prepare($sqlStatement);
		$query->execute();
		$sqlStat_rs 	= 	$query->fetch(\PDO::FETCH_ASSOC);
		return	$sqlStat_rs;
	}
	
	public function dbFetchWithParam($sqlStatment, $paramArray) {
		
		try {
			$resultRs 	=	DB::select($sqlStatment, $paramArray);
		} catch (\Exception $e) {
			$this->dbErrorHandler($e);
			return false;
		}
		return $resultRs;
	}
	
	public function dbExecuteSql($sqlStatement) {
		
		$pdoDB 		= 	DB::connection()->getPdo();
		$query 		= 	$pdoDB->prepare($sqlStatement);
		$sqlStat_rs	=	$query->execute();
		return $sqlStat_rs;		
	}
	
	public function dbErrorHandler($e) {		
		Log::error($e->getMessage());
	}
	
	public function dbEnableQueryLog() {
		DB::enableQueryLog();
	}
	
	public function dbGetLog() {
		return DB::getQueryLog();
	}
	
	public function dbDisableQueryLog() {
		DB::disableQueryLog();
	}

	public function setAuditOn($moduleName, $actionSummary, $actionDetail, 
								$keyDisplayFieldName, $keyDisplayFieldvalue) {
	// This will initiate the Audit Insert and store the auditKey field's value in $this->auditKey
		$dataArray	=	[	'user_id' =>	$this->getCurrentuserID,
							'module_name' => $moduleName,
							'action_summary' => $actionSummary,
							'action_detail' => $actionDetail,
							'key_displayfieldname' => $keyDisplayFieldName,
							'key_displayfieldvalue' =>	$keyDisplayFieldValue];
		
		$auditDb	=	DB::connection('auditDb');
		$this->auditKey = $auditDb->table('audit_master')->insertGetId($dataArray);	
		$this->auditFlag = true;
	}
	
	public function setAuditOff() {
		$this->auditFlag = false;
	}
	
	public function recordAuditInsert($tableName, $dataArray) {
		$tableName	=	'audit_'.$tableName;
		$dataArray['audit_key'] = $this->auditKey;
		$auditDb	=	DB::connection('auditDb');
		$auditDb->table($tableName)->insert($dataArray);
	}
	
	public function recordAuditUpdate($tableName, $dataArray, $where) {
		// We need to check whether the updated value is same as the original value 
		// so that we are inserting only the changed values in the audit tables
		$changedData	=	array();
		$tmpRs	=	DB::table($tableName)->where($where)->first();
		echo "<pre>", print_r($tmpRs),"</pre>";
		
		die;
		
		foreach ($dataArray as $fieldName => $fieldValue) {
			
			foreach ($dataArray as $fieldName => $fieldValue) {
			
			
			}
			
			
			
		}
		
		
		
	}
	
	
	public function getAuditDb() {
		$this->auditDb = DB::connection('auditDb');
		$this->auditDb->table('audit_master')->insertGetId($dataArray);
		
	}
}
