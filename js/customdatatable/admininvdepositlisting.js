var $invdepositlisting;

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
		transcation_filter		=	(transcation_filter	==	"3")?"":transcation_filter;		
		$invdepositlisting.columns(6).search(transcation_filter).draw();
		
	//From date and To date filtering
	$.fn.dataTableExt.afnFiltering.push(
		function( oSettings, aData, iDataIndex ) {
			var iFini = document.getElementById('fromdate').value;
			var iFfin = document.getElementById('todate').value;
			var iStartDateCol = 2;
			var iEndDateCol = 2;

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
		});	
	});	
			
	var p = new Date();
	var n = new Date();

	p.setMonth(p.getMonth() - 2); //subtract month - prev
	n.setMonth(n.getMonth() + 2); //adding month - next
	
	if((p.getDate()) < 10){	
		var pdate = ("0"+p.getDate());
	}else{
		var pdate = (p.getDate());
	}
	if((n.getDate()) < 10){	
		var ndate = ("0"+n.getDate());
	}else{
		var ndate = (n.getDate());
	}	
	
	//~ //adding zero for month
	if((p.getMonth()+1) < 10){	
		var prevDate = (pdate + '-' +("0"+(p.getMonth() + 1) ) + '-' +  p.getFullYear());
	}else{
		var prevDate = (pdate + '-' +(p.getMonth() + 1)  + '-' +  p.getFullYear());
	}
	if((n.getMonth()+1) < 10){	
		var nextDate = (ndate + '-' +("0"+(n.getMonth() + 1) ) + '-' +  n.getFullYear());
	}else{
		var nextDate = (ndate + '-' +(n.getMonth() + 1)  + '-' +  n.getFullYear());
	}

	//set in the datepicker
	$("#fromdate").val(prevDate);
	$("#todate").val(nextDate);
 
});

//values setup based on status before use
function inheritvarvalues(data){
	var invUrl		=	baseUrl+'/admin/investordepositview';
	var	inveditUrl	=	invUrl+"/edit/"+btoa(data.payment_id)+"/";
	var	inveditUrl	=	inveditUrl+btoa(data.investor_id);
	return inveditUrl;
}

function callDataTableFunc(){	
						
	$invdepositlisting =$('#admininvdepositlisting').DataTable( {
		
			dom: "Tfrtip",
			ajax: baseUrl+"/admin/ajax/admininvdepositlist",			
			columns: [
	
						{ 													
							data: null,														
							render: function(data, type, full, meta){                				
								var str ="";  
								str=str+'<input type="checkbox"';
								str=str+' name="transaction_id[]" class="select_investor_deposit" ';
								str=str+' data-investor-name="'+data.firstname+'" data-depositDate="'+data.trans_date+'" ';
								str=str+' data-depositAmount="'+data.trans_amount+'" data-status="'+data.status+'" ';
								str=str+' value="'+data.trans_id+'"  />';
								return str;
							},
							orderable: false
						},
						{ 													
							data: null,		
							className: "text-left",											
							render: function(data, type, full, meta){ 								
								var inveditUrl = inheritvarvalues(data);	           				
								var str ="";  								
								str=str+'<a href="'+inveditUrl+'"';
								str=str+'>'+data.firstname+'</a>';						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "text-left",											
							render: function(data, type, full, meta){ 								
								var inveditUrl = inheritvarvalues(data);	           				
								var str ="";  								
								str=str+'<a href="'+inveditUrl+'"';
								str=str+'>'+data.trans_date+'</a>';						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "text-right",											
							render: function(data, type, full, meta){ 								
								var inveditUrl = inheritvarvalues(data);	           				
								var str ="";  								
								str=str+'<a href="'+inveditUrl+'"';
								str=str+'>'+data.trans_amount+'</a>';						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "text-left",											
							render: function(data, type, full, meta){ 								
								var inveditUrl = inheritvarvalues(data);	           				
								var str ="";  								
								str=str+'<a href="'+inveditUrl+'"';
								str=str+'>'+data.trans_status_name+'</a>';						
								return str;
        					 
        					}
						},
						
						{ 
						data: null,		
						className: "text-left",													
						render: function(data, type, full, meta){	
													
							var	invUrl		=	baseUrl + '/admin/investordepositview';
							var	invaddUrl	=	invUrl+"/add/0/"+btoa(data.investor_id);
							var	inveditUrl	=	invUrl+"/edit/"+btoa(data.payment_id)+"/";
							var	inveditUrl	=	inveditUrl+btoa(data.investor_id);
							var	invviewUrl	=	invUrl+"/view/"+btoa(data.payment_id)+"/";
							var	invviewUrl	=	invviewUrl+btoa(data.investor_id);	
											 
							var str =""; 					
							str=str+'<ul class="list-unstyled">'
							str=str+'	<li class="dropdown">'
							str=str+'		<a class="dropdown-toggle" '
							str=str+'				data-toggle="dropdown" href="#">'
							str=str+'					<i class="fa fa-caret-down fa-fw action-style"></i> '
							str=str+'						</a>'
							str=str+'							<ul class="dropdown-menu dropdown-user dropdown-menu-right">'
							str=str+'								<li>'	
							str=str+'									<a href="'+inveditUrl+'" >'
							str=str+'										<i class="fa fa-user fa-fw"></i>'
							str=str+'											Edit Deposit'
							str=str+'									</a>'
							str=str+'								</li>'
							str=str+'								<li>'
							str=str+'									<a href="'+invviewUrl+'"  >'
							str=str+'											<i class="fa fa-user fa-fw"></i>'
							str=str+'												View Deposit'
							str=str+'									</a>'
							str=str+'								</li>'						
							str=str+'							</ul>'	
							str=str+'						</li>'
							str=str+'					</ul>'	
															
							return str;				    
						},
						orderable: false
				}, 
				{ data: "status","visible": false },	
			],
		order: [ 0, 'asc' ],
		tableTools: {			
			aButtons: [		
				
			]
		}
    });		
}
