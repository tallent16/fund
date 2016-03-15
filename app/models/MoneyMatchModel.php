<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Log;

class MoneyMatchModel extends Model {

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
		
		$result			=	"";
		try {
			$id 			= 	DB::table($tableName)->insertGetId($dataArray);
			if ($returnLastValue) {
				$result = $id;
			}
		}catch (\Exception $e) {
			
			$this->dbErrorHandler($e);
			return false;
		}
			
		return $result;
	}
	
	
	public function dbUpdate($tableName, $dataArray, $where) {
		try {
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
		$sqlStat_rs 	= 	$query->fetch();
		return	$sqlStat_rs;
	}
	
	public function dbFetchWithParam($sqlStatment, $paramArray) {
		
		try {
			$resultRs 	=	DB::select($sqlStatement, $paramArray);
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
}
