<?php 
namespace App\Http\Controllers;
use	\App\models\AdminBorrowerActivityReportModel;
use Response;
use Request;
use Excel;
class AdminBorrowerActivityReportController extends MoneyMatchController {

	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminBorActRepMod = new AdminBorrowerActivityReportModel();
	}

	public function indexAction() { 
		

		$this->adminBorActRepMod->processBorrowerDropDowns();
		$withArry	=	array(	"adminBorActRepMod" => $this->adminBorActRepMod	,
								"classname"=>"fa fa-list-alt fa-fw"
							);
		return view('admin.admin-borroweractivity')
			->with($withArry); 
			
					
	}
	
	public function indexPostAction() { 
		
		$filterBor			=	"";
		$filterFromDate		=	"";
		$filterToDate		=	"";
		
		if (isset($_REQUEST["borrower_filter"])) 
			$filterBor 		= 	$_REQUEST["borrower_filter"];
		
		if (isset($_REQUEST["fromDate_filter"])) 
			$filterFromDate	= 	$_REQUEST["fromDate_filter"];

		if (isset($_REQUEST["toDate_filter"])) 
			$filterToDate 	= 	$_REQUEST["toDate_filter"];
		
		if(	$filterBor!=""	&&	$filterFromDate!=""	&&	$filterToDate!="" ) {
			
			$this->adminBorActRepMod->getBorrowerActivityReportInfo($filterBor, $filterFromDate, $filterToDate);
		}
		
		$this->adminBorActRepMod->processBorrowerDropDowns();
		$withArry	=	array(	"adminBorActRepMod" => $this->adminBorActRepMod	,
								"classname"=>"fa fa-list-alt fa-fw"
							);
		return view('admin.admin-borroweractivity')
			->with($withArry); 
			
					
	}
	
	public function DownloadBorrowerAction() { 
		
		$postArray	=	Request::all();
		$jsonObj	=	json_decode($postArray['report_json'],true);
		$needle = 'Transaction Detail Report for Borrower:';
		//~ $result = $this->mySearch($jsonObj, "Date", $needle,strlen($needle));
		$i	=	0;
		$prev_bor	=	"";
		$cur_bor	=	"";
		$allBorrowerArry	=	array();
		
		foreach($jsonObj as $key=>$data) {
			$cur_bor	=	$data['Date'];
			if($i	==	0 && $prev_bor=="") {
				$allBorrowerArry[$i][]	=	$data;
				$prev_bor	=	$data['Date'];
				
			}else{
				
				if (strlen(strstr($cur_bor,$needle))>0) {
					$i++;
					$allBorrowerArry[$i][]	=	$data;
					$prev_bor	=	$cur_bor;
					$cur_bor	=	$data['Date'];
				}else{
					$allBorrowerArry[$i][]	=	$data;
				}
			}
			
		}
		//~ echo "<pre>",print_r($jsonObj),"</pre>";
		//~ die;
		$headers	=	[
							0=>"Borrower Activity Report",
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
		Excel::create('BorrowerActivityReport', function($excel) 
			use ($allBorrowerArry,$headers,$headStart,$startRow,$breakColumn)
		 {
			foreach ($allBorrowerArry as $key=>$jsonRow) {
				$excel->sheet('Borrower'.$key, function($sheet)
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
						$needle = 'Transaction Detail Report for Borrower:';
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
	
}
