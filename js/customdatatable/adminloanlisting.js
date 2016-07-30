var $loanlisting;

//From date and To date filtering
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
//calling AJAX 
$(document).ready(function() {
	callDataTableFunc();
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('#hidden_token').val()
			}
	} );
	$("#filter_status").click(function(event){   //filter the status
		var	transcation_filter	=	$("#filter_transcations").find("option:selected").val();
		transcation_filter		=	(transcation_filter	==	"11")?"":transcation_filter;		
		$loanlisting.columns(8).search(transcation_filter).draw();	
	});	
	
		
	var p = new Date();
	var n = new Date();

	p.setMonth(p.getMonth() - 1); //subtract month - prev
	n.setMonth(n.getMonth() + 1); //adding month - next

	//adding zero for month
	if((p.getMonth()+1) < 10){	
		var prevDate = (p.getDate() + '/' +("0"+(p.getMonth() + 1) ) + '/' +  p.getFullYear());
	}else{
		var prevDate = (p.getDate() + '/' +(p.getMonth() + 1)  + '/' +  p.getFullYear());
	}
	if((n.getMonth()+1) < 10){	
		var nextDate = (n.getDate() + '/' +("0"+(n.getMonth() + 1) ) + '/' +  n.getFullYear());
	}else{
		var nextDate = (n.getDate() + '/' +(n.getMonth() + 1)  + '/' +  n.getFullYear());
	}

	//set in the datepicker
	$("#fromdate").val(prevDate);
	$("#todate").val(nextDate);
  //~ $("#fromdate").datetimepicker({
				//~ autoclose: true, 
				//~ minView: 2,
				//~ format: 'dd/mm/yyyy' ,
				//~ onChangeDateTime: function(){
						   //~ startDate = $("#fromdate").val();
													   //~ }
													   //~ });
	//~ $("#todate").datetimepicker({
				//~ autoclose: true, 
				//~ minView: 2,
				//~ format: 'dd/mm/yyyy' ,
				//~ onClose: function(){
						//~ var endDate = $("#todate").val();
						//~ if(startDate>endDate){
							   //~ alert('Please select correct date');
						 //~ }
		 //~ }
		  //~ });
});
//values setup based on status before use
function inheritvarvalues(data){
	
	var	loan_id	=	btoa(data.loan_id);
	var LOAN_STATUS_NEW 					= 1;
	var LOAN_STATUS_DISBURSED 		 		= 7;
	var LOAN_STATUS_LOAN_REPAID 	 		= 10;
	var LOAN_STATUS_PENDING_COMMENTS 		= 4;
	var LOAN_STATUS_SUBMITTED_FOR_APPROVAL 	= 2;
	var LOAN_STATUS_APPROVED 				= 3;
	var LOAN_STATUS_CLOSED_FOR_BIDS 		= 5;
	var LOAN_STATUS_BIDS_ACCEPTED 			= 6;
		
	
	if  (data.status	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL){
				var	actionUrl		=	baseUrl+'/admin/loanapproval';
				var	actionUrl		=	actionUrl+"/"+loan_id	;
	}					
	else if (data.status	==	LOAN_STATUS_APPROVED){																	
				var	actionUrl		=	baseUrl+'/admin/managebids';
				var	actionUrl		=	actionUrl+"/"+atob(loan_id);		
	}			
	else if (data.status	==	LOAN_STATUS_CLOSED_FOR_BIDS){
				var	actionUrl		=	baseUrl+'/admin/managebids';
				var	actionUrl		=	actionUrl+"/"+atob(loan_id);	
	}	
	else if	(data.status == LOAN_STATUS_BIDS_ACCEPTED)		{											
				var	actionUrl		=	baseUrl+'/admin/disburseloan';
				var	actionUrl		=	actionUrl+"/"+loan_id	;		
	}						
	else{
				var	actionUrl		=	"javascript:void(0);";								
	}
	
	
	if  (data.status	==	LOAN_STATUS_NEW){ 
			var	actionUrl		=	baseUrl+'/admin/loanapproval';  
			var	actionUrl		=	actionUrl+"/"+loan_id;
	}
	if  (data.status	==	LOAN_STATUS_DISBURSED){
			var	actionUrl		=	baseUrl+'/admin/loanview';
			var	actionUrl		=	actionUrl+"/"+loan_id;	
	}
	if  (data.status	==	LOAN_STATUS_LOAN_REPAID){
			var	actionUrl		=	baseUrl+'/admin/loanview';
			var	actionUrl		=	actionUrl+"/"+loan_id;	
	}
	if  (data.status	==	LOAN_STATUS_PENDING_COMMENTS){
			var	actionUrl		=	baseUrl+'/admin/loanapproval';
			var	actionUrl		=	actionUrl+"/"+loan_id;		 				
	}
	return actionUrl;
}


function callDataTableFunc(){	
							
	$loanlisting =$('#adminloanlisting').DataTable( {
		
			dom: "Tfrtip",
			ajax: baseUrl+"/admin/ajax/adminloanlisting",			
			columns: [
	
						{ 													
							data: null,		
							className: "text-left",											
							render: function(data, type, full, meta){ 								
								var actionUrl = inheritvarvalues(data);	           				
								var str ="";  								
								str=str+'<a href="'+actionUrl+'"';
								str=str+'>'+data.loan_reference_number+'</a>';						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "text-left",											
							render: function(data, type, full, meta){ 								
								var actionUrl = inheritvarvalues(data);	           				
								var str ="";  								
								str=str+'<a href="'+actionUrl+'"';
								str=str+'>'+data.business_name+'</a>';						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "text-right",											
							render: function(data, type, full, meta){ 								
								var actionUrl = inheritvarvalues(data);	           				
								var str ="";  								
								str=str+'<a href="'+actionUrl+'"';
								str=str+'>'+data.loan_sanctioned_amount+'</a>';						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "text-right",											
							render: function(data, type, full, meta){ 								
								var actionUrl = inheritvarvalues(data);	           				
								var str ="";  								
								str=str+'<a href="'+actionUrl+'"';
								str=str+'>'+data.target_interest+'</a>';						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "text-right",											
							render: function(data, type, full, meta){ 								
								var actionUrl = inheritvarvalues(data);	           				
								var str ="";  								
								str=str+'<a href="'+actionUrl+'"';
								str=str+'>'+data.loan_tenure+'</a>';						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "text-right",											
							render: function(data, type, full, meta){ 								
								var actionUrl = inheritvarvalues(data);	           				
								var str ="";  								
								str=str+'<a href="'+actionUrl+'"';
								str=str+'>'+data.bid_type+'</a>';						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "text-left",											
							render: function(data, type, full, meta){ 								
								var actionUrl = inheritvarvalues(data);	           				
								var str ="";  								
								str=str+'<a href="'+actionUrl+'"';
								str=str+'>'+data.bid_close_date+'</a>';						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "text-left",											
							render: function(data, type, full, meta){ 								
								var actionUrl = inheritvarvalues(data);	           				
								var str ="";  								
								str=str+'<a href="'+actionUrl+'"';
								str=str+'>'+data.loan_status_name+'</a>';						
								return str;
        					 
        					}
						},							
						{ data: "status","visible": false }								
			],
		order: [ 0, 'asc' ],
		tableTools: {			
			aButtons: [		
				
			]
		}
    });		
}
