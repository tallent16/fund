var $repaylisting;

$(document).ready(function() {
	callDataTableFunc();
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('#hidden_token').val()
			}
	} );	
});

$('#select_all_list').on('click', function (e) {
		checkall_list(this,"adminrepaymentlisting");
});
function variabledec(data){	
	var	SchUrl			=	baseUrl+'/admin/borrowersrepayview';
	var	repSchUrl		=	SchUrl+"/edit/"+btoa(data.repayment_schedule_id);
	var	repSchUrl		=	repSchUrl+"/"+btoa(data.loan_id);
	return 	repSchUrl;
}
function callDataTableFunc(){	
	
	$repaylisting =$('#adminrepaymentlisting').DataTable( {
		dom: "Tfrtip",
		ajax: baseUrl+"/admin/ajax/adminrepaylist",			
		columns: [
				{ 
					data: null,														
					render: function(data, type, full, meta){                				
						var str ="";  
						str=str+'<input type="checkbox"';
						str=str+' name="repayment_schedule[]" class="select_repayment" ';
						str=str+' data-status="'+data.status+'" data-penality="'+data.penalty_fixed_amount+'" ';
						str=str+' data-loan-ref="'+data.loan_reference_number+'" data-schdDate="'+data.repayment_schedule_date+'" ';
						str=str+'data-tran-ref="'+data.trans_reference_number+'" value="'+data.repayment_schedule_id+'"  />';								
						return str;
					},
					orderable: false
				},
				{ 
					data: null,		
					className: "text-left",											
					render: function(data, type, full, meta){  
						var repSchUrl = variabledec(data);												              				
						var str ="";  								
						str=str+'<a href="'+repSchUrl+'"';
						str=str+'>'+data.loan_reference_number+'</a>';						
						return str;
					}        					
				},
				{ 
					data: null,
					className: "text-left",													
					render: function(data, type, full, meta){  
						var repSchUrl = variabledec(data);              				
						var str ="";  								
						str=str+'<a href="'+repSchUrl+'"';
						str=str+'>'+data.repayment_schedule_date+'</a>';						
						return str;
					}        					
				},	
				{ 
					data: null,		
					className: "text-left",											
					render: function(data, type, full, meta){  
						var repSchUrl = variabledec(data);              				
						var str ="";  								
						str=str+'<a href="'+repSchUrl+'"';
						str=str+'>'+data.repayment_actual_date+'</a>';						
						return str;
					}        					
				},
				{ 
					data: null,		
					className: "text-right",											
					render: function(data, type, full, meta){ 
						var repSchUrl = variabledec(data);             				
						var str ="";  								
						str=str+'<a href="'+repSchUrl+'"';
						str=str+'>'+data.repayment_scheduled_amount+'</a>';						
						return str;
					}        					
				},
				{   
					data: null,		
					className: "text-right",																
					render: function(data, type, full, meta){  
						var repSchUrl = variabledec(data);             				
						var str ="";  								
						str=str+'<a href="'+repSchUrl+'"';
						str=str+'>'+data.penalty_fixed_amount+'</a>';						
						return str;
					}        					
				},
				{ 
					data: null,	
					className: "text-left",																					
					render: function(data, type, full, meta){  
						var repSchUrl = variabledec(data);               				
						var str ="";  								
						str=str+'<a href="'+repSchUrl+'"';
						str=str+'>'+data.loan_status_name+'</a>';						
						return str;
					}        					
				},
				{ 
					data: null,		
					className: "text-left",													
					render: function(data, type, full, meta){
						var	SchUrl			=	baseUrl+'/admin/borrowersrepayview';
						var	repEditSchUrl	=	SchUrl+"/edit/"+btoa(data.repayment_schedule_id);
						var	repEditSchUrl	=	repEditSchUrl+"/"+btoa(data.loan_id);
						
						var	repViewSchUrl	=	SchUrl+"/view/"+btoa(data.repayment_schedule_id);   
						var	repViewSchUrl	=	repViewSchUrl+"/"+btoa(data.loan_id);
						
						if(data.loan_status_name	==	"Not Approved"){							
							var	apprUrl		=	baseUrl+'/admin/borrowersrepaylist/approve';
							var	apprUrl		=	apprUrl+"/"+data.repayment_schedule_id;
							var	classname	=	"";		
						}
						else{
							var	apprUrl		=	"javascript:void(0);";
							var	classname	=	"disable-indication disabled";		
						}
						if(data.loan_status_name	!=	"Approved"){
							var	classrepaySch		=	"";		
						}else{
							var	classrepaySch		=	"disable-indication disabled";									
						}
											
						var str =""; 					
						str=str+'<ul class="list-unstyled">'
						str=str+'	<li class="dropdown">'
						str=str+'		<a class="dropdown-toggle" '
						str=str+'				data-toggle="dropdown" href="#">'
						str=str+'					<i class="fa fa-caret-down fa-fw action-style"></i> '
						str=str+'						</a>'
						str=str+'							<ul class="dropdown-menu dropdown-user dropdown-menu-right">'
						str=str+'								<li>'
						str=str+'									<a href="'+repEditSchUrl+'" class="'+classrepaySch+'">'
						str=str+'										<i class="fa fa-user fa-fw"></i>'
						str=str+'											Edit/Approve'
						str=str+'									</a>'
						str=str+'								</li> ' 
						str=str+'								<li>'	
						str=str+'									<a href="'+repViewSchUrl+'" >'
						str=str+'										<i class="fa fa-user fa-fw"></i>'
						str=str+'											View'
						str=str+'									</a>'
						str=str+'								</li>'
						str=str+'								<li>'
						str=str+'									<a href="'+apprUrl+'" '
						str=str+'										data-tranf-no="'+data.trans_reference_number+'" '
						str=str+'										class="approveRepayment '+classname+' " >'
						str=str+'											<i class="fa fa-user fa-fw"></i>'
						str=str+'												Approve Selected'
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
	order: [ 1, 'asc' ],
	tableTools: {			
		aButtons: [		
			
		]
	}
	});		
}
