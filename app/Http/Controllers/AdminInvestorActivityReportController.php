<?php 
namespace App\Http\Controllers;
use	\App\models\AdminInvestorActivityReportModel;
use Response;
use	Excel;

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
		 Excel::load( $uploadedFile, function ( $excelSheetReader )
        {

            // Select the right sheet
            $excelSheetReader->sheet('Sheet1', function($sheet) {

                // Select the right cell (or range of cells)
                $sheet->cells('A1:B1', function($cell) {
                    $cell->setBackground('#000000');
                    $cell->setFontColor('#ffffff');
                    $cell->setFontSize(16);

                });
            });
            $excelSheetReader->createsheet('Sheet2', function($sheet) {

                // Select the right cell (or range of cells)
                $sheet->cells('A1:B1', function($cell) {
                    $cell->setBackground('#000000');
                    $cell->setFontColor('#ffffff');
                    $cell->setFontSize(16);

                });
            });

        } )->download('xls');
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
	
}
