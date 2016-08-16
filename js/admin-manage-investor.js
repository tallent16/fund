var manInvDeleteConfirmUrl	=	"";
var manInvRejectConfirmUrl	=	"";
var manInvBulkDeleteConfirm	=	false;
var manInvBulkRejectConfirm	=	false;
$(document).ready(function (){  
	
	$("#bulk_approve_button").click(function(){
		var	appr_applicable	=	$("#default_approve_applicable").val();
		var	errMessage		=	"";
		if ($(".select_investor_id:checked").length > 0){
			$(".select_investor_id:checked").each(function(key) {
				var status	=	$(this).attr("data-status");
				var email	=	$(this).attr("data-email");
				if(status	!=	appr_applicable){
					errMessage	=	errMessage+"not applicable for this Invrower "+email+"<br> \n\n";
				}
			});
			if(errMessage!=""){
				showCusDialog("",errMessage);	
				return false;
			}
			$("#processType").val("approve");
			$("#form-manage-investor").attr("action",baseUrl+"/admin/manageinvestors/bulkapprove");
			$("#form-manage-investor").submit();
		}
    });
	/* This click event is delete comments
	 * by the admin
	 */ 
	$("#bulk_reject_button").click(function(){
		var	reject_applicable		=	$("#default_reject_applicable").val();
		var	reject_applicableArr	=	reject_applicable.split(",");
	  	var	errMessage		=	"";
		if ($(".select_investor_id:checked").length > 0){
			if(!manInvBulkRejectConfirm) {
				$(".select_investor_id:checked").each(function(key) {
					var status		=	$(this).attr("data-status");
					var email		=	$(this).attr("data-email");
					var active_loan	=	$(this).attr("data-active-loan");
					if ($.inArray(status, reject_applicableArr)	===	-1){
						errMessage	=	errMessage+"not applicable for this Invrower "+email+"<br> \n\n";
					}
				});
				if(errMessage!=""){
					showCusDialog("",errMessage);	
					return false;
				}
				retval = showDialogWithOkCancel("", "Warning!! Once Rejected you cannot undo this action."
											+" Do you want to proceed with the rejection", "bulkRejectManageInvestorFunc");
				return false;
			}
			$("#processType").val("reject");
			$("#form-manage-investor").attr("action",baseUrl+"/admin/manageinvestors/bulkreject");
			$("#form-manage-investor").submit();
		}
    });
	$("#bulk_delete_button").click(function(){
		var	errMessage		=	"";
		if ($(".select_investor_id:checked").length > 0){
			if(!manInvBulkDeleteConfirm) {
				$(".select_investor_id:checked").each(function(key) {
					var status		=	$(this).attr("data-status");
					var email		=	$(this).attr("data-email");
					var active_loan	=	$(this).attr("data-active-loan");
					if(active_loan >0){
						errMessage	=	errMessage+"not applicable for this Invrower "+email+" \n\n";
					}
				});
				if(errMessage!=""){
					showCusDialog("",errMessage);	
					return false;
				}
				retval = showDialogWithOkCancel("", "Warning!! Once Deleted you cannot undo this action."
											+" Do you want to proceed with the deletion", "bulkDeleteManageInvestorFunc");
				return false;		
			
			}
			$("#processType").val("delete");
			$("#form-manage-investor").attr("action",baseUrl+"/admin/manageinvestors/bulkdelete");
			$("#form-manage-investor").submit();
		}
    });
	
    $("#select_all_list").click(function(){
		checkall_list(this,"select_investor_id");
	});
	
	
    $(".manageinvestors_delete").click(function(event){
		
		event.preventDefault();
		manInvDeleteConfirmUrl	=	$(this).attr("href");
		retval = showDialogWithOkCancel("", "Warning!! Once Deleted you cannot undo this action."
											+" Do you want to 	proceed with the deletion", "deleteManageInvestorFunc");
	});
	
    $(".manageinvestors_reject").click(function(event){
		event.preventDefault();
		manInvRejectConfirmUrl	=	$(this).attr("href");
		retval = showDialogWithOkCancel("", "Warning!! Once Rejected you cannot undo this action."
											+" Do you want to proceed with the rejection", "rejectManageInvestorFunc");
	});
   
});

//=================Delete callback functions=============================================
function deleteManageInvestorFunc(retval) {
	// This is called from the showDialogWithOkCancel as a callback when the user clicks one of the 
	// OK or Cancel buttons.
	if (retval == 1) {
		window.location	=	 manInvDeleteConfirmUrl;
	} else {
		manInvDeleteConfirmUrl	=	"";
	}
}

function bulkDeleteManageInvestorFunc(retval) {
	// This is called from the showDialogWithOkCancel as a callback when the user clicks one of the 
	// OK or Cancel buttons.
	if (retval == 1) {
		manInvBulkDeleteConfirm	=	true;
		$("#bulk_delete_button").click();
	} else {
		manInvBulkDeleteConfirm	=	false;
	}
}
//=================Reject callback functions=============================================
function rejectManageInvestorFunc(retval) {
	// This is called from the showDialogWithOkCancel as a callback when the user clicks one of the 
	// OK or Cancel buttons.
	if (retval == 1) {
		window.location	=	 manInvRejectConfirmUrl;
	} else {
		manInvRejectConfirmUrl	=	"";
	}
}
function bulkRejectManageInvestorFunc(retval) {
	// This is called from the showDialogWithOkCancel as a callback when the user clicks one of the 
	// OK or Cancel buttons.
	if (retval == 1) {
		manInvBulkRejectConfirm	=	true;
		$("#bulk_reject_button").click();
		
	} else {
		manInvBulkRejectConfirm	=	false;
	}
}
function showCusDialog($title, $message) {
	
	$title = "Fund Yourselves Now";
	htmlelement = "<div id='dialog-message' title='"+ $title + "'> <p> " + $message+ " </p> </div>"
						
	$('body').append(htmlelement);
	
	$( "#dialog-message" ).dialog({
		modal: true,
		buttons: {
			Ok: function() {			
				$('.select_investor_id').prop('checked', false); 
				$( this ).dialog( "close" );
				$( this ).dialog( "destroy" );
				$( this ).remove();
			}
		}
    });
}
