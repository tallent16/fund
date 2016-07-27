var $loanlisting;

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
		$('#fromdate').keyup( function() { $loanlisting.draw(); } );
		$('#todate').keyup( function() { $loanlisting.draw(); } );
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

