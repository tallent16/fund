var $borrower;
var editor;

$(document).ready(function() {
	callDataTableFunc();
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('#hidden_token').val()
			}
	} );		
});

$('#select_all_list').on('click', function (e) {
		checkall_list(this,"adminborrower");
    });
     
function callDataTableFunc(){	
	
	editor = new $.fn.dataTable.Editor( {
		ajax: baseUrl+"/admin/ajax/adminborrower",
		table: "#adminborrower",
		fields: [ 
			//~ {
				//~ label: "user_id:", 
				//~ name: "user_id"
			//~ },
			{
				label: "email:", 
				name: "email"
			}, {
				label: "business_name:",
				name: "business_name"
			},
			 //~ {
				//~ label: "industry:",
				//~ name: 	"industry"				
			//~ },{
				//~ label: "active_loan:",
				//~ name: "active_loan"				
			//~ },{
				//~ label: "tot_bal_outstanding:",
				//~ name: "tot_bal_outstanding"				
			//~ }
			//~ ,{
				//~ label: "Status:",
				//~ name: "status"				
			//~ }
			
		],
        i18n: {
				create: {
					button: "New",
					title:  "Add New User",
					submit: "Save"
				}
			}
	} );
	
			
			
	$borrower =$('#adminborrower').DataTable( {
			dom: "Tfrtip",
			ajax: baseUrl+"/admin/ajax/adminborrower",
			//~ columns: [	
			
						//~ { 
								//~ data: null,
								//~ className: "center",
								//~ render: function(data, type, full, meta){
									
									//~ var str ="";  
									//~ str=str+'<input type="checkbox"';
									//~ str=str+' name="user_id" class="user_id"';
									//~ str=str+' value="'+data.user_id+'" />';
									
									//~ return str;
								//~ },
								//~ orderable: false
						//~ },
						//~ { 
							//~ data: null,
							//~ className: "center",
							//~ render: function(data, type, full, meta){
								
								//~ var str ="";  
								
									//~ str=data.email
								
								//~ return str;
							//~ }
						//~ },
						//~ { 
							//~ data: null,
							//~ className: "center",
							//~ render: function(data, type, full, meta){
								
								//~ var str ="";   
								
									//~ str=data.business_name
								
								//~ return str;
							//~ }
						//~ },
						//~ { 
							//~ data: null,
							//~ className: "center",
							//~ render: function(data, type, full, meta){
								
								//~ var str ="";  
								
									//~ str=data.industry
							
								//~ return str;   
							//~ }
						//~ },
						//~ { 
							//~ data: null,
							//~ className: "center",
							//~ render: function(data, type, full, meta){
								
								//~ var str ="";  
								
									//~ str=data.active_loan
								
								//~ return str;    
							//~ }
						//~ },						
						//~ { 
							//~ data: null,
							//~ className: "center",
							//~ render: function(data, type, full, meta){
								
								//~ var str ="";  
								
									//~ str=data.tot_bal_outstanding
							
								//~ return str;  
							//~ }
						//~ },
						//~ { 
							//~ data: null,
							//~ className: "center",
							//~ render: function(data, type, full, meta){
								
								//~ var str ="";  
								
									//~ str=data.status
								
								//~ return str;  
							//~ }
						//~ },
						//~ { 
							//~ data: null,
							//~ className: "center",
							//~ render: function(data, type, full, meta){
									
								//~ var str ="";             					    
								//~ str=str+'<a href="'+baseUrl+'/admin/changepassword/'+data.enuser_id+'"';
								//~ str=str+' >Change Password </a>';
								//~ str=str+'/';
								//~ str=str+'<a href="'+baseUrl+'/admin/assign-roles/'+data.user_id+'"';
								//~ str=str+' >Assign Roles</a>';
								//~ return str;				    
							//~ }
						//~ }
					//~ ],
			//~ order: [ 1, 'asc' ],
			//~ tableTools: {
				//~ aButtons: [
				//~ { sExtends: "", editor: editor },
				//~ { sExtends: "", editor: editor }
			//~ ]
				
			//~ }
			
			columns: [
						{ 
							data: null,
							className: "center",
							render: function(data, type, full, meta){
                				
								var str ="";  
								str=str+'<input type="checkbox"';
								str=str+' name="user_id" class="DT_RowId"';
								str=str+' value="'+data.DT_RowId+'" />';
								
								return str;
        					},
        					orderable: false
						},
			 
						{ "data": "email" },
						{ "data": "business_name" },
						{ "data": "industry" },
						{ "data": "active_loan" },
						{ "data": "tot_bal_outstanding" },						
						{ "data": "status"}
						
			 
			],
		order: [ 1, 'asc' ],
		tableTools: {
			
			aButtons: [
				
				
			]
		}
    });
		
}
