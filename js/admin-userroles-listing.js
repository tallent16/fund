$(document).ready(function (){  
	

	$("#change_user").click(function(){
		pathURL				=	"/admin/assign-roles/"+$("#user_filter").find("option:selected").val();
		window.location	=	baseUrl+pathURL;
    });
    
	$("#save_permission").click(function(){
		$("#user_id").val($("#user_filter").find("option:selected").val())
		if ($(".select_role_id:checked").length > 0){
			$("#form-user-roles").submit();
		}
    });
	
});
