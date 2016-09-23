var manBorDeleteConfirmUrl	=	"";
var manBorRejectConfirmUrl	=	"";
var manBorBulkDeleteConfirm	=	false;
var manBorBulkRejectConfirm	=	false;
$(document).ready(function (){  
	
	$("#bulk_approve_button").click(function(e){
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
				showCusDialog("",errMessage);							
				return false;
			}
			
			$("#processType").val("approve");
			$("#form-manage-borrower").attr("action",baseUrl+"/admin/manageborrowers/bulkapprove");
			$("#form-manage-borrower").submit();
		}
    });
	/* This click event is delete comments
	 * by the admin
	 */ 
	$("#bulk_reject_button").click(function(){
		
		if ($(".select_borrower_id:checked").length > 0){
			if(!manBorBulkRejectConfirm) {
				var	reject_applicable		=	$("#default_reject_applicable").val();
				var	reject_applicableArr	=	reject_applicable.split(",");
				var	errMessage		=	"";
				
					
				$(".select_borrower_id:checked").each(function(key) {
					var status		=	$(this).attr("data-status");
					var email		=	$(this).attr("data-email");
					var active_loan	=	$(this).attr("data-active-loan");
					if ($.inArray(status, reject_applicableArr)	===	-1){
						errMessage	=	errMessage+"not applicable for this borrower "+email+" \n\n";
					}
				});
				if(errMessage!=""){
					showCusDialog("",errMessage);
					return false;
				}
				retval = showDialogWithOkCancel("", "Warning!! Once Rejected you cannot undo this action."
											+" Do you want to proceed with the rejection", "bulkRejectManageBorrowerFunc");
				return false;
			}
			$("#processType").val("reject");
			$("#form-manage-borrower").attr("action",baseUrl+"/admin/manageborrowers/bulkreject");
			$("#form-manage-borrower").submit();	
		}
	});
	$("#bulk_delete_button").click(function(){
		if ($(".select_borrower_id:checked").length > 0){
			if(!manBorBulkDeleteConfirm) {
				var	errMessage		=	"";
				
				$(".select_borrower_id:checked").each(function(key) {
					var status		=	$(this).attr("data-status");
					var email		=	$(this).attr("data-email");
					var active_loan	=	$(this).attr("data-active-loan");
					if(active_loan >0){
						errMessage	=	errMessage+"not applicable for this borrower "+email+" \n\n";
					}
				});
				if(errMessage!=""){
					showCusDialog("",errMessage);
					return false;
				}
				retval = showDialogWithOkCancel("", "Warning!! Once Deleted you cannot undo this action."
											+" Do you want to proceed with the deletion", "bulkDeleteManageBorrowerFunc");
				return false;		
			}
		
			$("#processType").val("delete");
			$("#form-manage-borrower").attr("action",baseUrl+"/admin/manageborrowers/bulkdelete");
			$("#form-manage-borrower").submit();
		}
    });
	
    $("#select_all_list").click(function(){
		checkall_list(this,"select_borrower_id");
	});
	
    $(".manageborrowers_delete").click(function(event){
		
		event.preventDefault();
		manBorDeleteConfirmUrl	=	$(this).attr("href");
		retval = showDialogWithOkCancel("", "Warning!! Once Deleted you cannot undo this action."
											+" Do you want to 	proceed with the deletion", "deleteManageBorrowerFunc");
	});
	
    $(".manageborrowers_reject").click(function(event){
		event.preventDefault();
		manBorRejectConfirmUrl	=	$(this).attr("href");
		retval = showDialogWithOkCancel("", "Warning!! Once Rejected you cannot undo this action."
											+" Do you want to proceed with the rejection", "rejectManageBorrowerFunc");
	});
   
   
   
});

//=================Delete callback functions=============================================
function deleteManageBorrowerFunc(retval) {
	// This is called from the showDialogWithOkCancel as a callback when the user clicks one of the 
	// OK or Cancel buttons.
	if (retval == 1) {
		window.location	=	 manBorDeleteConfirmUrl;
	} else {
		manBorDeleteConfirmUrl	=	"";
	}
}

function bulkDeleteManageBorrowerFunc(retval) {
	// This is called from the showDialogWithOkCancel as a callback when the user clicks one of the 
	// OK or Cancel buttons.
	if (retval == 1) {
		manBorBulkDeleteConfirm	=	true;
		$("#bulk_delete_button").click();
	} else {
		manBorBulkDeleteConfirm	=	false;
	}
}
//=================Reject callback functions=============================================
function rejectManageBorrowerFunc(retval) {
	// This is called from the showDialogWithOkCancel as a callback when the user clicks one of the 
	// OK or Cancel buttons.
	if (retval == 1) {
		window.location	=	 manBorRejectConfirmUrl;
	} else {
		manBorRejectConfirmUrl	=	"";
	}
}
function bulkRejectManageBorrowerFunc(retval) {
	// This is called from the showDialogWithOkCancel as a callback when the user clicks one of the 
	// OK or Cancel buttons.
	if (retval == 1) {
		manBorBulkRejectConfirm	=	true;
		$("#bulk_reject_button").click();
		
	} else {
		manBorBulkRejectConfirm	=	false;
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
				$('.select_borrower_id').prop('checked', false); 
				$( this ).dialog( "close" );
				$( this ).dialog( "destroy" );
				$( this ).remove();
			}
		}
    });
}
