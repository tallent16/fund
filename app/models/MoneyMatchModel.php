<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class MoneyMatchModel extends Model {

	public $auditKey = 0;
	private $auditDb;
	public $auditFlag 				= false;
	public $systemAllSetting 		= "";
	public $systemAllMessage 		=	array();
	public $emailAllNotification 	= 	array();
	
	// Use this date wherever you want to use System date
	public $systemDate_str;
	public $systemDate_DT;
	
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
					// The data array will not have the auto increment column in it. 
					// So we need to fetch the column from the information_schema before we 
					// update this to the audit records
					$tmpRs	=	DB::select("SELECT column_name from information_schema.columns 
									where table_schema = '{$currDatabase}' and table_name = '{$tableName}' 
									and extra = 'auto_increment'");
					
					$aiColname	=	$tmpRs[0]->column_name;
					$dataArray[$aiColname] = $result;
				}
			}
			if ($this->auditFlag) {
				// Insert a record in audit 
				$auditData	=	$dataArray;
				$auditData["audit_key"] = $this->auditKey;
				$this->recordAudit("Add", "After", $tableName, $auditData, "");
			}
			
		}catch (\Exception $e) {
			
			$this->dbErrorHandler($e);
			return false;
		}
			
		return $result;
	}
	
	public function dbUpdate($tableName, $dataArray, $where) {
		try {

			$dbObject	=	$this->getFilteredObject($tableName, $where);
			if ($this->auditFlag) {
				$this->recordAudit("Update", "Before", $tableName, $dataArray, $where);
			}
			DB::table($tableName)->where($where)->update($dataArray);
			if ($this->auditFlag) {
				$this->recordAudit("Update", "After", $tableName, $dataArray, $where);
			}
				

		}catch (\Exception $e) {
			$this->dbErrorHandler($e);
			return false;
		}
		return true;
	}
	
	
	public function dbDelete($tableName,$where) {
		
		try {
			if ($this->auditFlag) {
				$auditData = array();
				$this->recordAudit("Delete", "Before", $tableName, $auditData, $where);
			}

			$dbObject	=	$this->getFilteredObject($tableName, $where);
			$dbObject->delete();
		} catch (\Exception $e) {
			
			$this->dbErrorHandler($e);
			return false;
		}
		
	}
	
	public function getFilteredObject($tableName, $where, $schema="default") {
		
		if ($schema != "default") {
			$tmpObj = 	DB::connection($schema);
			$tmpObj =	$tmpObj->table($tableName);
		} else {
			$tmpObj 	=	DB::table($tableName);
		}
		
		foreach ($where as $key => $val) {
			switch ($key) {
				case "orWhere":
					$whereCol = $val["column"];
					$whereVal = $val["colVal"];
					$tmpObj = $tmpObj->orWhere($whereCol, $whereVal);
					break;
					
				case "whereIn":
					$whereCol = $val["column"];
					$whereVal = $val["valArr"];

					$tmpObj = $tmpObj->whereIn($whereCol, $whereVal);
					break;
					
				case "whereNotIn":
					$whereCol = $val["column"];
					$whereVal = $val["valArr"];

					$tmpObj = $tmpObj->whereNotIn($whereCol, $whereVal);
					break;
					
				default:
					$tmpObj = $tmpObj->where($key, "=", $val);
					break;
			}
		}
		return $tmpObj;
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
		try {
			$pdoDB = DB::connection()->getPdo();
			$query = $pdoDB->prepare($sqlStatement);
			$query->execute();
			$colname = $query->fetchColumn();
			return	$colname;
		} catch (\Exception $e) {
			
			$this->dbErrorHandler($e);
			return false;
		}
	}
	
	public function dbFetchRow($sqlStatement) {
		try {
			$pdoDB = DB::connection()->getPdo();
			$query = $pdoDB->prepare($sqlStatement);
			$query->execute();
			$sqlStat_rs 	= 	$query->fetch(\PDO::FETCH_ASSOC);
			return	$sqlStat_rs;
		} catch (\Exception $e) {
			
			$this->dbErrorHandler($e);
			return false;
		}
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
		try {
			$pdoDB 		= 	DB::connection()->getPdo();
			$query 		= 	$pdoDB->prepare($sqlStatement);
			$sqlStat_rs	=	$query->execute();
			return $sqlStat_rs;		
		} catch (\Exception $e) {
			
			$this->dbErrorHandler($e);
			return false;
		}
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
								$keyDisplayFieldName, $keyDisplayFieldValue) {
	
	// This will initiate the Audit Insert and store the auditKey field's value in $this->auditKey
		$dataArray	=	[	'user_id' =>	$this->getCurrentuserID(),
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

	public function recordAudit($action, $when, $tableName, $dataArray, $where="" ) {
		// if the where condition is there then use the where condition to get the records
		// and insert it into the audit
		// If the where condition is not there (only happens in the case of Add then 
		// insert the data available in the dataArray
		
		
		if ($where != "") {
			$tmpObject	=	$this->getFilteredObject($tableName, $where);
			$tmpRs		=	$tmpObject->get();
			$auditData  =	array();
			
			foreach ($tmpRs as $tmpRow) {
				// There may be multiple rows fetched by the where condition. If 
				// there are multip rows then each of the rows need to be added into the audit
				foreach ($tmpRow as $key => $val) {
					// The auditData is an array while the fetched information is an object
					// We convert the object into an array
					$auditData[$key] = $val;
				}
				
				// Append the audit header information
				// The action in the individual rows is because in an transaction upddate there can be 
				// subsidiary tables where rows are deleted or added
				$auditData['audit_key'] = $this->auditKey;
				$auditData['audit_action'] = $action; 
				$auditData['audit_when'] = $when;
				$auditDb		=	DB::connection('auditDb');
				$auditTableName	=	'audit_'.$tableName;
				$auditDb->table($auditTableName)->insert($auditData);
			}
			
		} else {
			// This happens only in the case of insert (where will not be present)
			$auditData = $dataArray;
			$auditData['audit_key'] = $this->auditKey;
			$auditData['audit_action'] = $action;
			$auditData['audit_when'] = $when;
			$auditDb		=	DB::connection('auditDb');
			$auditTableName	=	'audit_'.$tableName;
			$auditDb->table($auditTableName)->insert($auditData);
		}
	}
	
	public function getAllSystemSettings() {
		
		$sql= "	SELECT 	*
				FROM 	system_settings";
		
		$result		= $this->dbFetchRow($sql);
		$this->systemAllSetting =	$result;
		return $result;
	}
	
	public function getAllSystemMessages() {
		
		$sql= "	SELECT *
				FROM 	system_messages";
		
		$result		= $this->dbFetchAll($sql);
		foreach($result as $systemMsgRow) {
			$mod_id			=	$systemMsgRow->module_id;
			$slug			=	$systemMsgRow->slug_name;
			$messageText	=	$systemMsgRow->message_text;
			
			$this->systemAllMessage[$mod_id][$slug]	=	$messageText;
		}
		return $messageText;
	}

}

