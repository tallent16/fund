var $user;

$(document).ready(function() {
	callDataTableFunc();
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('#hidden_token').val()
			}
	} );
	
});

function callDataTableFunc(){
		
	$user =$('#adminborrower').DataTable( {
			dom: "Tfrtip",
			ajax: public_path+"/admin/ajax/adminborrower",
			columns: [	
			
						{ 
								data: null,
								className: "center",
								render: function(data, type, full, meta){
									
									var str ="";  
									str=str+'<input type="checkbox"';
									str=str+' name="user_id" class="user_id"';
									str=str+' value="'+data.user_id+'" />';
									
									return str;
								},
								orderable: false
						},
						{ 
							data: null,
							className: "center",
							render: function(data, type, full, meta){
								
								var str ="";  
								if($("#userCanEdit").val()	==	"yes") {           					    
									str=str+'<a href="javascript:void(0);"';
									str=str+' class="editor_edit user_edit_master" >';
									str=str+data.username+'</a>';
								}else{
									str=data.username
								}
								return str;
							}
						},
						{ 
							data: null,
							className: "center",
							render: function(data, type, full, meta){
								
								var str ="";   
								if($("#userCanEdit").val()	==	"yes") {           					    
									str=str+'<a href="javascript:void(0);"';
									str=str+' class="editor_edit user_edit_master" >';
									str=str+data.email+'</a>';
								}else{
									str=data.email
								}
								return str;
							}
						},
						{ 
							data: null,
							className: "center",
							render: function(data, type, full, meta){
								
								var str ="";  
								if($("#userCanEdit").val()	==	"yes") {            					    
									str=str+'<a href="javascript:void(0);"';
									str=str+' class="editor_edit  user_edit_master" >';
									str=str+data.statusText+'</a>';
								}else{
									str=data.statusText
								}
								return str;
							}
						},{ 
							data: null,
							className: "center",
							render: function(data, type, full, meta){
									
								var str ="";             					    
								str=str+'<a href="'+public_path+'/admin/changepassword/'+data.enuser_id+'"';
								str=str+' >Change Password </a>';
								str=str+'/';
								str=str+'<a href="'+public_path+'/admin/assign-roles/'+data.user_id+'"';
								str=str+' >Assign Roles</a>';
								return str;				    
							}
						}
					],
			order: [ 1, 'asc' ],
			tableTools: {
				
				aButtons: [
					{  }					
				]
			}
		} );
}
