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
				$(".list_region_id").each(function (key) {
					if($(this).is(":checked")){
						var tr = $(this).parents('tr');
						tr.remove();
					}
				});
			}
	 });
});
function callDataTableFunc(){
	var options =[];
	$userTypeOptions 	= 	buildUserTypeList();
	$statusOptions 		= 	buildStatusDropDownList();
	
	editor = new $.fn.dataTable.Editor( {
		ajax: "ajax/user_master",
		table: "#user",
		fields: [ {
				label: "User Name:",
				name: "user_name"
			}, {
				label: "Email:",
				name: "email"
			}, {
				label: "Password:",
				name: "password",
			},{
				label: "User Type:",
				name: "user_type",
				type: 'select',
				"ipOpts": $userTypeOptions
			}, {
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
		ajax: "ajax/user_master",
		columns: [	
		
					{ 
							data: null,
							className: "center",
							render: function(data, type, full, meta){
                				
								var str ="";             					    
								str=str+'<input type="checkbox"';
								str=str+' name="user_id" class="user_id"';
								str=str+' value="'+data.id+'" />';
								return str;
        					},
        					orderable: false
					},
					{ 
						data: null,
						className: "center",
						render: function(data, type, full, meta){
							
							var str ="";             					    
							str=str+'<a href="javascript:void(0);"';
							str=str+' class="editor_edit user_edit_master" >';
							str=str+data.user_name+'</a>';
							return str;
						}
					},
					{ 
						data: null,
						className: "center",
						render: function(data, type, full, meta){
							
							var str ="";             					    
							str=str+'<a href="javascript:void(0);"';
							str=str+' class="editor_edit user_edit_master" >';
							str=str+data.email+'</a>';
							return str;
						}
					},
					{ 
						data: null,
						className: "center",
						render: function(data, type, full, meta){
							var $userType	=	"";
							switch(data.user_type){
								case "1":
									$userType	=	"Admin";
									break;
								case "2":
									$userType	=	"Borrower";
									break;
								case "3":
									$userType	=	"Investor";
									break;
							}
							var str ="";             					    
							str=str+'<a href="javascript:void(0);"';
							str=str+' class="editor_edit  user_edit_master" >';
							str=str+$userType+'</a>';
							return str;
						}
					},{ 
						data: null,
						className: "center",
						render: function(data, type, full, meta){
								var $Status	=	"";
								switch(data.status){
								case "0":
									$Status	=	"Deactive";
									break;
								case "1":
									$Status	=	"Active";
									break;
							}
							var str ="";             					    
							str=str+'<a href="javascript:void(0);"';
							str=str+' class="editor_edit  user_edit_master" >';
							str=str+$Status+'</a>';
							return str;				    
						}
					}
				],
		order: [ 1, 'asc' ],
		tableTools: {
			sRowSelect: "os",
			sRowSelector: 'td:first-child',
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

     });
}


function callDeleteClickEventFunc(){
	
	$('#delete_region').on('click', function (e) {
			e.preventDefault();
			var rows = [];
			$(".list_region_id").each(function (key) {
				if($(this).is(":checked")){
					var tr = $(this).closest('tr');
					var row = region.row( tr );
					rows.push(row);
				}
			});
			if(rows.length	==	0)
					return false;
			 editor.remove( rows, {
				title: "Delete Region",
				message:"<h3>Are you sure to delete the selected Regions</h3>",
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
	opt.push({value : 1,label : "Admin"});
	opt.push({value : 2,label : "Borrower"});
	opt.push({value : 3,label : "Investor"});
	return opt;
	
}

function buildStatusDropDownList(){
	
	var opt = new Array();
	var opt = new Array();
	opt.push({value : 1,label : "Active"});
	opt.push({value : 0,label : "Deactive"});
	return opt;
	
}
