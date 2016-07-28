var $loanlisting;

var now = new Date();

var day = ("0" + now.getDate()).slice(-2);
var month = ("0" + (now.getMonth() + 1)).slice(-2);

var fromdate = (day)+"/"+(month - 3)+"/"+now.getFullYear() ;
var todate = (day)+"/"+(month + 3)+"/"+now.getFullYear() ;

//~ $('#fromdate').val(fromdate);
//~ $('#todate').val(todate);
//alert($('#todate').val(todate));

//~ var d = new Date();
//~ d.setMonth(d.getMonth() - 2);
//~ $("#fromdate").val(d);
//~ now.today().add(-30).days();
//~ alert(now.today().add(-30).days());
$.fn.dataTableExt.afnFiltering.push(
	function( oSettings, aData, iDataIndex ) {
		var iFini = document.getElementById('fromdate').value;
		var iFfin = document.getElementById('todate').value;
		var iStartDateCol = 6;
		var iEndDateCol = 6;

		iFini=iFini.substring(6,10) + iFini.substring(3,5)+ iFini.substring(0,2);
		iFfin=iFfin.substring(6,10) + iFfin.substring(3,5)+ iFfin.substring(0,2);

		var datofini=aData[iStartDateCol].substring(6,10) + aData[iStartDateCol].substring(3,5)+ aData[iStartDateCol].substring(0,2);
		var datoffin=aData[iEndDateCol].substring(6,10) + aData[iEndDateCol].substring(3,5)+ aData[iEndDateCol].substring(0,2);

		if ( iFini === "" && iFfin === "" )
		{
			return true;
		}
		else if ( iFini <= datofini && iFfin === "")
		{
			return true;
		}
		else if ( iFfin >= datoffin && iFini === "")
		{
			return true;
		}
		else if (iFini <= datofini && iFfin >= datoffin)
		{
			return true;
		}
		return false;
	}
);

$(document).ready(function() {
	callDataTableFunc();
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('#hidden_token').val()
			}
	} );
	$("#filter_status").click(function(event){
		var	transcation_filter	=	$("#filter_transcations").find("option:selected").val();
		transcation_filter		=	(transcation_filter	==	"11")?"":transcation_filter;		
		$loanlisting.columns(8).search(transcation_filter).draw();		
	});	
});

function callDataTableFunc(){	
    
	$loanlisting =$('#adminloanlisting').DataTable( {
			dom: "Tfrtip",
			ajax: baseUrl+"/admin/ajax/adminloanlisting",			
			columns: [
						{ data: "loan_reference_number",className: "text-left"},
						{ data: "business_name",className: "text-left"},
						{ data: "loan_sanctioned_amount",className: "text-right"},
						{ data: "target_interest",className: "text-right"},
						{ data: "loan_tenure",className: "text-right"},
						{ data: "bid_type",className: "text-right"},
						{ data: "bid_close_date",className: "text-left"},
						{ data: "loan_status_name",className: "text-left"},
						{ data: "status","visible": false }
								
			],
		order: [ 0, 'asc' ],
		tableTools: {			
			aButtons: [		
				
			]
		}
    });		
}
