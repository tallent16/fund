var $changebank;

$(document).ready(function() {
	callDataTableFunc();
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('#hidden_token').val()
			}
	} );	
});
function variabledec(data){	
	var	editUrl	=	baseUrl +'/admin/approvechangeofbank'+'/'+btoa(data.usertype)+'/'+btoa(data.borrower_id)+'/'+btoa(data.borrower_bankid);
	return editUrl;
}
function callDataTableFunc(){	
	
	$changebank =$('#adminchangebank').DataTable( {
		dom: "Tfrtip",
		ajax: baseUrl+"/admin/ajax/adminchangebank",			
		columns: [
					 { 
						data: null,		
						className: "text-left",											
						render: function(data, type, full, meta){ 
							var editUrl = variabledec(data);             				
							var str ="";  								
							str=str+'<a href="'+editUrl+'"';
							str=str+'>'+data.usertype+'</a>';						
							return str;
						}        					
					},
					 { 
						data: null,		
						className: "text-left",											
						render: function(data, type, full, meta){ 
							var editUrl = variabledec(data);             				
							var str ="";  								
							str=str+'<a href="'+editUrl+'"';
							str=str+'>'+data.name+'</a>';						
							return str;
						}        					
					},
					{ 
						data: null,		
						className: "text-left",											
						render: function(data, type, full, meta){ 
							var editUrl = variabledec(data);             				
							var str ="";  								
							str=str+'<a href="'+editUrl+'"';
							str=str+'>'+data.bank_name+'</a>';						
							return str;
						}        					
					},
					 { 
						data: null,		
						className: "text-left",											
						render: function(data, type, full, meta){ 
							var editUrl = variabledec(data);             				
							var str ="";  								
							str=str+'<a href="'+editUrl+'"';
							str=str+'>'+data.bank_code+'</a>';						
							return str;
						}        					
					},
					 { 
						data: null,		
						className: "text-left",											
						render: function(data, type, full, meta){ 
							var editUrl = variabledec(data);             				
							var str ="";  								
							str=str+'<a href="'+editUrl+'"';
							str=str+'>'+data.branch_code+'</a>';						
							return str;
						}        					
					},
					 { 
						data: null,		
						className: "text-right",											
						render: function(data, type, full, meta){ 
							var editUrl = variabledec(data);             				
							var str ="";  								
							str=str+'<a href="'+editUrl+'"';
							str=str+'>'+data.bank_account_number+'</a>';						
							return str;
						}        					
					},
					{ data: "bank_statement_url","visible": false },									
				],
		order: [ 0, 'asc' ],
		tableTools: {			
					aButtons: [		
						
							]
					}
	});		
}
