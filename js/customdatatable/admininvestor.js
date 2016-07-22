var $investor;

$(document).ready(function() {
	callDataTableFunc();
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('#hidden_token').val()
			}
	} );		
	 $("#filter_status").click(function(event){
		var	investorstatus_filter	=	$("#investorstatus_filter").find("option:selected").val();
		investorstatus_filter		=	(investorstatus_filter	==	"all")?"":investorstatus_filter;		
		$investor.columns(8).search(investorstatus_filter).draw();
	});
});

$('#select_all_list').on('click', function (e) {
		checkall_list(this,"admininvestor");
    });
     
function callDataTableFunc(){	
	
	$investor =$('#admininvestor').DataTable( {
			dom: "Tfrtip",
			ajax: baseUrl+"/admin/ajax/admininvestor",			
			columns: [
						{ 
							data: null,														
							render: function(data, type, full, meta){                				
								var str ="";  
								str=str+'<input type="checkbox"';
								str=str+' name="investor_ids[]" class="select_investor_id" ';
								str=str+' data-status="'+data.status+'" class="select_investor_id" ';
								str=str+' data-email="'+data.email+'" data-active-loan="'+data.active_loan+'" ';
								str=str+' value="'+data.investor_id+'"  />';								
								return str;
        					},
        					orderable: false
						},
						{ 
							data: null,	
							className: "text-left",													
							render: function(data, type, full, meta){                				
								var str ="";  								
								str=str+'<a href="'+baseUrl+'/admin/investor/profile/'+btoa(data.investor_id)+'"';
								str=str+'>'+data.email+'</a>';						
								return str;
        					}        					
						},
						{ 
							data: null,		
							className: "text-left",												
							render: function(data, type, full, meta){                				
								var str ="";  								
								str=str+'<a href="'+baseUrl+'/admin/investor/profile/'+btoa(data.investor_id)+'"';
								str=str+'>'+data.display_name+'</a>';						
								return str;
        					}        					
						},	
						{ 
							data: null,	
							className: "text-left",												
							render: function(data, type, full, meta){                				
								var str ="";  								
								str=str+'<a href="'+baseUrl+'/admin/investor/profile/'+btoa(data.investor_id)+'"';
								str=str+'>'+data.mobile_number+'</a>';						
								return str;
        					}        					
						},
						{ 
							data: null,		
							className: "text-right",											
							render: function(data, type, full, meta){                				
								var str ="";  								
								str=str+'<a href="'+baseUrl+'/admin/investor/profile/'+btoa(data.investor_id)+'"';
								str=str+'>'+data.active_loan+'</a>';						
								return str;
        					}        					
						},
						{   
							data: null,		
							className: "text-right",																
							render: function(data, type, full, meta){                				
								var str ="";  								
								str=str+'<a href="'+baseUrl+'/admin/investor/profile/'+btoa(data.investor_id)+'"';
								str=str+'>'+data.available_balance+'</a>';						
								return str;
        					}        					
						},
						{ 
							data: null,	
							className: "text-left",																		
							render: function(data, type, full, meta){                				
								var str ="";  								
								str=str+'<a href="'+baseUrl+'/admin/investor/profile/'+btoa(data.investor_id)+'"';
								str=str+'>'+data.statusText+'</a>';						
								return str;
        					}        					
						},
						{ 
							data: null,	
							className: "text-center",							
							render: function(data, type, full, meta){
									
								var str ="";             					    
								var	encode_inv_id	=	btoa(data.investor_id);
								var	enuser_id		=	btoa(data.user_id);
								var	appClass		=	"disable-indication disabled";
								var	appUrl			=	"javascript:void(0);";
													
								var	rejClass		=	"disable-indication disabled";
								var	rejUrl			=	"javascript:void(0);";
													
								var	delClass		=	"disable-indication disabled";
								var	delUrl			=	"javascript:void(0);";
								
								var submittedForApproval	= 2;
								var submittedNewProfile		= 1;
								var approveinvestor = $('#approveinvestor').val();	
								var rejectinvestor	= $('#rejectinvestor').val();
								var deleteinvestor  = $('#deleteinvestor').val();	
										
								if(data.status	==	submittedForApproval){
									if(approveinvestor == "yes"){
										var	appClass	=	"";
										var	appUrl		=	baseUrl+'/admin/manageinvestors/approve';
										var	appUrl		=	appUrl+"/"+encode_inv_id;
									}
								}
								if((data.status	==	submittedNewProfile)
									|| (data.status	==	submittedForApproval)){
									if(rejectinvestor == "yes"){
										var	rejClass	=	"manageinvestors_reject";
										var	rejUrl		=	baseUrl+'/admin/manageinvestors/reject';
										var	rejUrl		=	rejUrl+"/"+encode_inv_id;
									}
								}
								if(data.active_loan == 0){
									if(deleteinvestor == "yes"){
										var	delClass	=	"manageinvestors_delete";
										var	delUrl		=	baseUrl+'/admin/manageinvestors/delete';
										var	delUrl		=	delUrl+"/"+encode_inv_id;
									}
								}
								var	changePasswordUrl	=	baseUrl+'/admin/changepassword';
								var	changePasswordUrl	=	changePasswordUrl+'/'+enuser_id;
													
								str=str+'<ul class="list-unstyled">'
								str=str+'	<li class="dropdown">'
								str=str+'		<a class="dropdown-toggle" '
								str=str+'				data-toggle="dropdown" href="#">'
								str=str+'					<i class="fa fa-caret-down fa-fw action-style"></i> '
								str=str+'						</a>'
								str=str+'							<ul class="dropdown-menu dropdown-user dropdown-menu-right">'
								str=str+'								<li>'
								str=str+'								<a href="'+appUrl+'" class="'+appClass+'">'
								str=str+'										<i class="fa fa-user fa-fw"></i>'
								str=str+'										Approve'
								str=str+'									</a>'
								str=str+'								</li> ' 
								str=str+'								<li>'	
								str=str+'									<a href="'+rejUrl+'"   class="'+rejClass+'">'
								str=str+'										<i class="fa fa-user fa-fw"></i>'
								str=str+'										Reject'
								str=str+'									</a>'
								str=str+'								</li>'
								str=str+'								<li>'
								str=str+'									<a href="'+delUrl+'"  class="'+delClass+'">'
								str=str+'										<i class="fa fa-user fa-fw"></i>'
								str=str+'										Delete'
								str=str+'									</a>'
								str=str+'								</li>'
								str=str+'								<li>'
								str=str+'									<a href="'+changePasswordUrl+'" >'
								str=str+'										<i class="fa fa-user fa-fw"></i>'
								str=str+'										Change Password'
								str=str+'									</a>'
								str=str+'								</li>'
								str=str+'							</ul>'	
								str=str+'						</li>'
								str=str+'					</ul>'	
																
								return str;				    
							}
						},
						{ data: "status","visible": false },			
			],
		order: [ 1, 'asc' ],
		tableTools: {			
			aButtons: [		
				
			]
		}
    });		
}
