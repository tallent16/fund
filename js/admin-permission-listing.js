$(document).ready(function (){  
	

	$("#change_role").click(function(){
		pathURL				=	"/admin/role-permission/edit/"+$("#role_filter").find("option:selected").val();
		window.location	=	baseUrl+pathURL;
    });
    
	$("#save_permission").click(function(){
		if($("#trantype").val()	==	"add") {
			$("#hidden_role_name").val($("#role_name").val());
			validateForm($("#role_name").val());
		}else{
			$("#hidden_role_filter").val($("#role_filter").val());
		}
		if ($(".select_permission_id:checked").length > 0){
			if (!$("#parent_role_name").hasClass('has-error')) {
				
				$("#form-role-permission").attr("action",baseUrl+"/admin/role-permission/save");
				$("#form-role-permission").submit();
			}
		}
    });
	
    $("#select_all_list").click(function(){
		checkall_list(this,"select_permission_id");
	});
	 
	 $(this).on("click","#select_all_modules",function() {
			if($(this).is(":checked")) {
				$(".modules").attr("checked",true);
				$(".modules").prop("checked",true);
				$(".modules_privileges").show();
			}else{
				$(".modules").removeAttr("checked");
				$(".modules_privileges").hide();	
			}
	});
	
	$(".modules").click(function(){
		$id	=	$(this).val();
		$class=	"module_"+$id;
		if($(this).is(":checked")) {
			
			$("."+$class).show();	
		}else{
			$("."+$class).hide();
		}
	});		
});

function validateForm(value) {
	
	if((value!='')) {
		$.ajax({
			
			type: "POST",
			url: baseUrl+"/admin/ajax/CheckRoleNameavailability",
			data: {	'role_name':$("#role_name").val(),
					'_token':$("#_token").val()},
			async : false,
			cache:false,
			success: function (data) {
			  if(data=='1') {
				 $(".label_role_name_error").html("");
				 $(".label_role_name_error").hide();
				 $(".label_role_name_error").parent().removeClass("has-error");
				 return true;
			  } else if(data=='2') {
				 $(".label_role_name_error").html("Role name "+ value +" already exists");
				 $("#role_name").val("");
				 $(".label_role_name_error").show();
				 $(".label_role_name_error").parent().addClass("has-error");
				 $("html, body").scrollTop(0);
			  }
			}
		}); 
	}else{
		$(".label_role_name_error").html("Enter the Role name");
		$(".label_role_name_error").show();
		$(".label_role_name_error").parent().addClass("has-error");
		 $("html, body").scrollTop(0);
	}    
}
