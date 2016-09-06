<?php 
namespace App\Http\Controllers;
use	\App\models\AdminLoanListingReportModel;
use Response;
use Request;
use Excel;

class AdminLoanListingReportController extends MoneyMatchController {

	
	public function __construct() {	
		
		$this->middleware('auth');
		$this->init();
	}
	
	public function littleMoreInit() {
		$this->adminLoanListRepModel = new AdminLoanListingReportModel();
	}

	public function indexAction() { 
		
		//~ die("dfdfd");
		$withArry	=	array(	"adminBankActRepMod" => $this->adminLoanListRepModel	,
								"classname"=>"fa fa-list-alt fa-fw"
							);
		return view('admin.admin-loanlistingreport')
			->with($withArry); 
			
					
	}
	
	public function indexPostAction() { 
		
		$filterFromDate		=	"";
		$filterToDate		=	"";
		
		if (isset($_REQUEST["fromDate_filter"])) 
			$filterFromDate	= 	$_REQUEST["fromDate_filter"];

		if (isset($_REQUEST["toDate_filter"])) 
			$filterToDate 	= 	$_REQUEST["toDate_filter"];
		
		if(	$filterFromDate!=""	&&	$filterToDate!="" ) {
			
			$this->adminBankActRepMod->getBankActivityReportInfo( $filterFromDate, $filterToDate);
		}
	
		$withArry	=	array(	"adminBankActRepMod" => $this->adminBankActRepMod	,
								"classname"=>"fa fa-list-alt fa-fw"
							);
		return view('admin.admin-bankactivity')
			->with($withArry); 
			
					
	}
	
	
	public function DownloadBankAction() { 
		
		$postArray	=	Request::all();
		$jsonObj	=	json_decode($postArray['report_json'],true);
		
		$headers	=	[
							0=>"Bank Activity Report",
							1=>"for the period {$postArray['from_date']} to {$postArray['to_date']}",
								
						];
		$headStart	=	1;
		$startRow	=	3;
		$breakColumn=	"Date";			
		
		Excel::create('BankActivityReport', function($excel) 
			use ($jsonObj,$headers,$headStart,$startRow,$breakColumn)
		 {
				$excel->sheet('BankSheet', function($sheet)
					use ($headers,$headStart,$startRow,$breakColumn,$jsonObj)
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
						foreach ($jsonObj as $jsonCol => $jsonVal) {
						
								$sheet->setCellValue('A'.$currExcelRow,$jsonVal['Date']);
								$sheet->setCellValue('B'.$currExcelRow, $jsonVal['Transaction Type']);
								$sheet->setCellValue('C'.$currExcelRow, $jsonVal['Reference Number']);
								$sheet->setCellValue('D'.$currExcelRow, $jsonVal['Details']);
								$sheet->setCellValue('E'.$currExcelRow, $jsonVal['Dr Amount']);
								$sheet->setCellValue('F'.$currExcelRow, $jsonVal['Cr Amount']);
								$sheet->setCellValue('G'.$currExcelRow, $jsonVal['Balance']);
								$currExcelRow++;
						}					
					});
							
		})->download('xls');
		
	}
	
}
