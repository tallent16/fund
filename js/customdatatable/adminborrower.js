var $borrower;

$(document).ready(function() {
	callDataTableFunc();
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('#hidden_token').val()
			}
	} );		
	 $("#filter_status").click(function(event){
		var	borrowerstatus_filter	=	$("#borrowerstatus_filter").find("option:selected").val();
		borrowerstatus_filter		=	(borrowerstatus_filter	==	"all")?"":borrowerstatus_filter;		
		$borrower.columns(8).search(borrowerstatus_filter).draw();
	});
});

$('#select_all_list').on('click', function (e) {
		checkall_list(this,"adminborrower");
    });
     
function callDataTableFunc(){	
	
	$borrower =$('#adminborrower').DataTable( {
			dom: "Tfrtip",
			ajax: baseUrl+"/admin/ajax/adminborrower",			
			columns: [
						{ 
							data: null,														
							render: function(data, type, full, meta){                				
								var str ="";  
								str=str+'<input type="checkbox"';
								str=str+' name="borrower_ids[]" class="select_borrower_id" ';
								str=str+' data-status="'+data.status+'" class="select_borrower_id" ';
								str=str+' data-email="'+data.email+'" data-active-loan="'+data.active_loan+'" ';
								str=str+' value="'+data.borrower_id+'"  />';								
								return str;
        					},
        					orderable: false
						},
						{ 
							data: null,													
							render: function(data, type, full, meta){                				
								var str ="";  								
								str=str+'<a href="'+baseUrl+'/admin/borrower/profile/'+btoa(data.borrower_id)+'"';
								str=str+'>'+data.email+'</a>';						
								return str;
        					}        					
						},
						{ 
							data: null,													
							render: function(data, type, full, meta){                				
								var str ="";  								
								str=str+'<a href="'+baseUrl+'/admin/borrower/profile/'+btoa(data.borrower_id)+'"';
								str=str+'>'+data.business_name+'</a>';						
								return str;
        					}        					
						},	
						{ 
							data: null,													
							render: function(data, type, full, meta){                				
								var str ="";  								
								str=str+'<a href="'+baseUrl+'/admin/borrower/profile/'+btoa(data.borrower_id)+'"';
								str=str+'>'+data.industry+'</a>';						
								return str;
        					}        					
						},
						{ 
							data: null,		
							className: "text-right",											
							render: function(data, type, full, meta){                				
								var str ="";  								
								str=str+'<a href="'+baseUrl+'/admin/borrower/profile/'+btoa(data.borrower_id)+'"';
								str=str+'>'+data.active_loan+'</a>';						
								return str;
        					}        					
						},
						{   
							data: null,		
							className: "text-right",																
							render: function(data, type, full, meta){                				
								var str ="";  								
								str=str+'<a href="'+baseUrl+'/admin/borrower/profile/'+btoa(data.borrower_id)+'"';
								str=str+'>'+data.tot_bal_outstanding+'</a>';						
								return str;
        					}        					
						},
						{ 
							data: null,																		
							render: function(data, type, full, meta){                				
								var str ="";  								
								str=str+'<a href="'+baseUrl+'/admin/borrower/profile/'+btoa(data.borrower_id)+'"';
								str=str+'>'+data.statusText+'</a>';						
								return str;
        					}        					
						},
						{ 
							data: null,							
							render: function(data, type, full, meta){
									
								var str ="";             					    
								var	encode_bor_id	=	btoa(data.borrower_id);
								var	enuser_id		=	btoa(data.user_id);
								var	appClass		=	"disable-indication disabled";
								var	appUrl			=	"javascript:void(0);";
													
								var	rejClass		=	"disable-indication disabled";
								var	rejUrl			=	"javascript:void(0);";
													
								var	delClass		=	"disable-indication disabled";
								var	delUrl			=	"javascript:void(0);";
								
								var submittedForApproval	= 2;
								var submittedNewProfile		= 1;
								var approveborrower = $('#approveborrower').val();	
								var rejectborrower	= $('#rejectborrower').val();
								var deleteborrower  = $('#deleteborrower').val();	
										
								if(data.status	==	submittedForApproval){
									if(approveborrower == "yes"){
										var	appClass	=	"";
										var	appUrl		=	baseUrl+'/admin/manageborrowers/approve';
										var	appUrl		=	appUrl+"/"+encode_bor_id;
									}
								}
								if((data.status	==	submittedNewProfile)
									|| (data.status	==	submittedForApproval)){
									if(rejectborrower == "yes"){
										var	rejClass	=	"manageborrowers_reject";
										var	rejUrl		=	baseUrl+'/admin/manageborrowers/reject';
										var	rejUrl		=	rejUrl+"/"+encode_bor_id;
									}
								}
								if(data.active_loan == 0){
									if(deleteborrower == "yes"){
										var	delClass	=	"manageborrowers_delete";
										var	delUrl		=	baseUrl+'/admin/manageborrowers/delete';
										var	delUrl		=	delUrl+"/"+encode_bor_id;
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
