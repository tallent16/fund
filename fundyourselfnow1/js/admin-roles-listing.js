manRolesConfirmUrl	=	"";
$(document).ready(function (){  
		
	$(".manageroles_delete").click(function(event){
			event.preventDefault();
			manRolesConfirmUrl	=	$(this).attr("href");
			retval = showDialogWithOkCancel("", "Warning!! Once Deleted you cannot undo this action."
												+" Do you want to proceed with the deletion", "deleteManageRolesFunc");
	});
   
});
function deleteManageRolesFunc(retval) {
	// This is called from the showDialogWithOkCancel as a callback when the user clicks one of the 
	// OK or Cancel buttons.
	if (retval == 1) {
		window.location	=	 manRolesConfirmUrl;
	} else {
		manRolesConfirmUrl	=	"";
	}
}
