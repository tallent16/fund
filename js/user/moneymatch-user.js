var editor;
var $user;

$(document).ready(function() {
	callDataTableFunc();
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('#hidden_token').val()
			}
	} );
	$( document ).ajaxComplete(function() {
		call_list_select_all_event();
		callEditClickEventFunc();
		callDeleteClickEventFunc();
		
	});
	
	
	$('#select_all_list').on('click', function (e) {
		checkall_list(this,"user_id");
     });
     
    /* editor.on( 'onOpen', function () {
		// Get the 'input' element from the 'code' input field and set an attribute on it
		$( 'input', this.node( 'error_code' ) ).attr( 'maxLength', 10 );
		$( 'input', this.node( 'error_severity' ) ).attr( 'maxLength', 3 );
		$( 'input', this.node( 'alert_frequency_period' ) ).attr( 'maxLength', 3 );
		$( 'input', this.node( 'alert_frequency_repeat' ) ).attr( 'maxLength', 3 );
	} ); */
    
	 editor.on( 'onSubmitSuccess', function ( e, json,data ) {
		if(data.DT_RowId	==	undefined ){
			$(".user_id").each(function (key) {
					if($(this).is(":checked")){
						var tr = $(this).parents('tr');
						tr.remove();
						if($("#hidden_user_id").val()	==	tr.attr("id").replace("row_","") ) {
							window.location	=	public_path+"/auth/logout";
						}
					}
				});
			
		}
	 });
	checkUserPermission();
	 $('#user').removeClass("DTTT_selectable");
});
function checkUserPermission() {
	if($("#userCanAdd").val()	==	"no") {
		$("#ToolTables_user_0").remove();
	}
	if($("#userCanDelete").val()	==	"no") {
		$("#ToolTables_user_1").remove();
	}
	$("#ToolTables_user_0").css("visibility", "visible");
	$("#ToolTables_user_1").css("visibility", "visible");
}
function callDataTableFunc(){
	var options =[];
	$userTypeOptions 	= 	buildUserTypeList();
	$statusOptions 		= 	buildStatusDropDownList();
	
	editor = new $.fn.dataTable.Editor( {
		ajax: public_path+"/admin/ajax/user_master",
		table: "#user",
		fields: [ {
				label: "User Name:",
				name: "username"
			}, {
				label: "Email:",
				name: "email"
			}, {
				label: "Password:",
				name: 	"password",
				type:	"password"
			},{
				label: "Status:",
				name: "status",
				type: 'select',
				"ipOpts": $statusOptions
			}
		],
        i18n: {
				create: {
					button: "New",
					title:  "Add New User",
					submit: "Save"
				}
			}
	} );
	
	$user =$('#user').DataTable( {
		dom: "Tfrtip",
		ajax: public_path+"/admin/ajax/user_master",
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
				{ sExtends: "editor_create", editor: editor },
				{ sExtends: "editor_remove", editor: editor }
			]
		}
	} );
}

$.urlParam = function(name){
    var results = new RegExp('[\?&amp;]' + name + '=([^&amp;#]*)').exec(window.location.href);
if(results == null){
return "";
}
    return results[1] || 0;
}

function call_list_select_all_event(){
	
	$(".list_region_id").on('click', function (e) {
	
		var len =$(".list_region_id:checked").length;
		var unchecklen =$(".list_region_id").length;
		
		if(len == unchecklen ){
			$("#select_all_list").attr("checked","checked");
			$("#select_all_list").prop("checked","checked");
		}else{
			$("#select_all_list").removeAttr("checked");
		}
	});
}

function callAddClickEventFunc(){
	
	$('#add_region').on('click', function (e) {
        e.preventDefault();
		
         editor.create(
            'Create New Region',
            {
                "label": "Add New Region",
                "fn": function () {
                    editor.submit()
                }
            });
             $("#DTE_Field_region_code").removeAttr("disabled");
      });
}


function callEditClickEventFunc(){
	
	$('#user').on('click', 'a.editor_edit', function (e) {
        e.preventDefault();
		
        editor.edit( $(this).closest('tr'), {
            title: 'Edit User Master',
            buttons: 'Update'
        });
		$(".DTE_Field_Name_password").remove();
     });
}


function callDeleteClickEventFunc(){
	
	$('#ToolTables_user_1').on('click', function (e) {
			e.preventDefault();
			var rows = [];
			$(".user_id").each(function (key) {
				if($(this).is(":checked")){
					var tr = $(this).closest('tr');
					var row = $user.row( tr );
					rows.push(row);
				}
			});
			if(rows.length	==	0)
					return false;
			console.log(rows);
			 editor.remove( rows, {
				title: "Delete User",
				message:"<h3>Are you sure to delete the selected Users</h3>",
				buttons: [
					{
						label: 'Cancel', fn: function() {
							this.close();
						}
					},
					{
						label: 'Delete', fn: function() {
							this.submit();
						}
					}
				]
			});
     });	
}
function buildUserTypeList(){
	
	var opt = new Array();
	opt.push({value : 1,label : "Borrower"});
	opt.push({value : 2,label : "Investor"});
	opt.push({value : 3,label : "Admin"});
	return opt;
	
}

function buildStatusDropDownList(){
	
	var opt = new Array();
	var opt = new Array();
	opt.push({value : 2,label : "Active"});
	opt.push({value : 1,label : "Deactive"});
	return opt;
	
}
