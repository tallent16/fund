<?php 
namespace App\Http\Controllers;
use	\App\models\AdminInvestorActivityReportModel;
use Response;
use	Excel;
use	Request;

class AdminInvestorActivityReportController extends MoneyMatchController {

	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminInvActRepMod = new AdminInvestorActivityReportModel();
	}

	public function indexAction() { 
		$uploadedFile	=	"reportExcelTemplate/sample.xls";
		
				/*Excel::create('Filename', function($excel)  {
					// Create first sheet
					$excel->sheet('Investor 1', function($sheet) {
						$sheet->getStyle('A')->getAlignment()->applyFromArray(
							array('horizontal' => 'left')
						);
						$sheet->getStyle('D')->getAlignment()->applyFromArray(
							array('horizontal' => 'right')
						);
						$sheet->setCellValue('A1', 'R S Jayasathyanarayanan');
						$sheet->setCellValue('B1', 'Senior Web  Developer');
						$sheet->setCellValue('C1', 'Open IT Works');
						$sheet->setCellValue('D1', '35');
						$sheet->setCellValue('E1', '30000');
	
						$sheet->cells('A1:B1', function($cell) {
							$cell->setBackground('#000000');
							$cell->setFontColor('#ffffff');
							$cell->setFontSize(16);
						});
						
					
					});
					$excel->sheet('Investor 2', function($sheet) {
						
						$sheet->cells('A1:B1', function($cell) {
							$cell->setBackground('#000000');
							$cell->setFontColor('#ffffff');
							$cell->setFontSize(16);
						});
					});
				})->download('xls');*/
			
		$this->adminInvActRepMod->processInvestorDropDowns();
		$withArry	=	array(	"adminInvActRepMod" => $this->adminInvActRepMod	,
								"classname"=>"fa fa-list-alt fa-fw"
							);
		return view('admin.admin-investoractivity')
			->with($withArry); 
			
					
	}
	
	public function indexPostAction() { 
		
		$filterInv			=	"";
		$filterFromDate		=	"";
		$filterToDate		=	"";
		
		if (isset($_REQUEST["investor_filter"])) 
			$filterInv 		= 	$_REQUEST["investor_filter"];
		
		if (isset($_REQUEST["fromDate_filter"])) 
			$filterFromDate	= 	$_REQUEST["fromDate_filter"];

		if (isset($_REQUEST["toDate_filter"])) 
			$filterToDate 	= 	$_REQUEST["toDate_filter"];
		
		if(	$filterInv!=""	&&	$filterFromDate!=""	&&	$filterToDate!="" ) {
			
			$this->adminInvActRepMod->getInvestorActivityReportInfo($filterInv, $filterFromDate, $filterToDate);
		}
		
		$this->adminInvActRepMod->processInvestorDropDowns();
		$withArry	=	array(	"adminInvActRepMod" => $this->adminInvActRepMod	,
								"classname"=>"fa fa-list-alt fa-fw"
							);
		return view('admin.admin-investoractivity')
			->with($withArry); 
			
					
	}
	
	public function DownloadInvestorAction() { 
		
		$postArray	=	Request::all();
		$jsonObj	=	json_decode($postArray['report_json'],true);
		$needle = 'Transaction Detail Report for Investor:';
		//~ $result = $this->mySearch($jsonObj, "Date", $needle,strlen($needle));
		$i	=	0;
		$prev_inv	=	"";
		$cur_inv	=	"";
		$allInvestorArry	=	array();
		foreach($jsonObj as $key=>$data) {
			$cur_inv	=	$data['Date'];
			if($i	==	0 && $prev_inv=="") {
				$allInvestorArry[$i][]	=	$data;
				$prev_inv	=	$data['Date'];
				
			}else{
				
				if (strlen(strstr($cur_inv,$needle))>0) {
					$i++;
					$allInvestorArry[$i][]	=	$data;
					$prev_inv	=	$cur_inv;
					$cur_inv	=	$data['Date'];
				}else{
					$allInvestorArry[$i][]	=	$data;
				}
			}
			
		}
		//~ echo "<pre>",print_r($jsonObj),"</pre>";
		//~ die;
		$headers	=	[
							0=>"Investor Activity Report",
							1=>"for the period {$postArray['from_date']} to {$postArray['to_date']}",
							//~ 2=>[	"Date",
									//~ "Transaction Type",
									//~ "Reference Number",
									//~ "Details",
									//~ "Dr Amount",
									//~ "Cr Amount",
									//~ "Balance"
								//~ ]
								
						];
		$headStart	=	1;
		$startRow	=	3;
		$breakColumn=	"Date";			
		Excel::create('InvestorActivityReport', function($excel) 
			use ($allInvestorArry,$headers,$headStart,$startRow,$breakColumn)
		 {
			foreach ($allInvestorArry as $key=>$jsonRow) {
				$excel->sheet('Investor'.$key, function($sheet)
					use ($headers,$headStart,$startRow,$breakColumn,$jsonRow)
				 {
						$sheet->getStyle('E')->getAlignment()->applyFromArray(
							array('horizontal' => 'right')
						);
						$sheet->getStyle('F')->getAlignment()->applyFromArray(
							array('horizontal' => 'right')
						);
						$sheet->getStyle('G')->getAlignment()->applyFromArray(
							array('horizontal' => 'right')
						);
						$headerRow = $headStart;
						foreach ($headers as $headerInfo) {
							if(is_array($headerInfo)) {
								$sheet->setCellValue('A'.$headerRow,$headerInfo[0]);
								$sheet->setCellValue('B'.$headerRow, $headerInfo[1]);
								$sheet->setCellValue('C'.$headerRow, $headerInfo[2]);
								$sheet->setCellValue('D'.$headerRow, $headerInfo[3]);
								$sheet->setCellValue('E'.$headerRow, $headerInfo[4]);
								$sheet->setCellValue('F'.$headerRow, $headerInfo[5]);
								$sheet->setCellValue('G'.$headerRow, $headerInfo[6]);
							}else{
								$sheet->setCellValue('A'.$headerRow,$headerInfo);
							}
							$headerRow ++;
						}
						$currExcelRow = $startRow;
						$needle = 'Transaction Detail Report for Investor:';
						foreach ($jsonRow as $jsonCol => $jsonVal) {
							if ( (strlen(strstr($jsonVal['Date'],$needle))	==	0 )
								) {
								$sheet->setCellValue('A'.$currExcelRow,$jsonVal['Date']);
								$sheet->setCellValue('B'.$currExcelRow, $jsonVal['Transaction Type']);
								$sheet->setCellValue('C'.$currExcelRow, $jsonVal['Reference Number']);
								$sheet->setCellValue('D'.$currExcelRow, $jsonVal['Details']);
								$sheet->setCellValue('E'.$currExcelRow, $jsonVal['Dr Amount']);
								$sheet->setCellValue('F'.$currExcelRow, $jsonVal['Cr Amount']);
								$sheet->setCellValue('G'.$currExcelRow, $jsonVal['Balance']);
								$currExcelRow++;
							}else{
								$sheet->setCellValue('A'.$currExcelRow,$jsonVal['Date']);
								$currExcelRow++;
							}
							
						}					
					});
				
			
			}		
							
		})->download('xls');
		
	}
	
	public function mySearch($array, $key, $search,$len) 	{
		$results = array();
		foreach ($array as $rootKey => $data) {
			if (array_key_exists($key, $data)) {
				if (strncmp($search, substr($data[$key], 0, $len), strlen($search)) == 0) {
					$results[] = $rootKey;
				}
			}
		}
		return $results;
	}

}
