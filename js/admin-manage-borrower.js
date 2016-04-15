$(document).ready(function (){  
	

	$("#bulk_approve_button").click(function(){
		var	appr_applicable	=	$("#default_approve_applicable").val();
		var	errMessage		=	"";
		if ($(".select_borrower_id:checked").length > 0){
			$(".select_borrower_id:checked").each(function(key) {
				var status	=	$(this).attr("data-status");
				var email	=	$(this).attr("data-email");
				if(status	!=	appr_applicable){
					errMessage	=	errMessage+"not applicable for this borrower "+email+" \n\n";
				}
			});
			if(errMessage!=""){
				alert(errMessage);
				return false;
			}
			$("#processType").val("approve");
			$("#form-manage-borrower").submit();
		}
    });
	/* This click event is delete comments
	 * by the admin
	 */ 
	$("#bulk_reject_button").click(function(){
		var	reject_applicable		=	$("#default_reject_applicable").val();
		var	reject_applicableArr	=	reject_applicable.split(",");
	  	var	errMessage		=	"";
		if ($(".select_borrower_id:checked").length > 0){
			$(".select_borrower_id:checked").each(function(key) {
				var status		=	$(this).attr("data-status");
				var email		=	$(this).attr("data-email");
				var active_loan	=	$(this).attr("data-active-loan");
				if ($.inArray(status, reject_applicableArr)	===	-1){
					errMessage	=	errMessage+"not applicable for this borrower "+email+" \n\n";
				}
			});
			if(errMessage!=""){
				alert(errMessage);
				return false;
			}
			$("#processType").val("reject");
			$("#form-manage-borrower").submit();
		}
    });
	$("#bulk_delete_button").click(function(){
		var	errMessage		=	"";
		if ($(".select_borrower_id:checked").length > 0){
			$(".select_borrower_id:checked").each(function(key) {
				var status		=	$(this).attr("data-status");
				var email		=	$(this).attr("data-email");
				var active_loan	=	$(this).attr("data-active-loan");
				if(active_loan >0){
					errMessage	=	errMessage+"not applicable for this borrower "+email+" \n\n";
				}
			});
			if(errMessage!=""){
				alert(errMessage);
				return false;
			}
			$("#processType").val("delete");
			$("#form-manage-borrower").submit();
		}
    });
	
    $("#select_all_list").click(function(){
		checkall_list(this,"select_borrower_id");
	});
   
});
