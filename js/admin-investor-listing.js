$(document).ready(function (){  
	
	// date picker
	$('.fromdate').datetimepicker({
		autoclose: true, 
		minView: 2,
		format: 'dd-mm-yyyy' 
	}); 
	$('.todate').datetimepicker({
		autoclose: true, 
		minView: 2,
		format: 'dd-mm-yyyy' 
	}); 
	$("#bulk_approve_button").click(function(){
		var	appr_applicable	=	$("#default_unverified_applicable").val();
		var	errMessage		=	"";
		if ($(".select_investor_deposit:checked").length > 0){
			$(".select_investor_deposit:checked").each(function(key) {
				var inv_name		=	$(this).attr("data-investor-name");
				var depositDate		=	$(this).attr("data-depositDate");
				var depositAmount	=	$(this).attr("data-depositAmount");
				var status			=	$(this).attr("data-status");
				if(status	!=	appr_applicable){
					errMessage	=	errMessage+"Not Applicable  Investor Name:"+inv_name+",Deposit Date:";
					errMessage	=	errMessage+depositDate+",Deposit Amount:"+depositAmount+"<br>";
				}
			});
			if(errMessage!=""){
				showDialog("",errMessage);
				return false;
			}
			$("#processType").val("approve");
			$("#form-investor-listing").submit();
		}
    });
	$("#bulk_unapprove_button").click(function(){
		var	appr_applicable	=	$("#default_verified_applicable").val();
		var	errMessage		=	"";
		if ($(".select_investor_deposit:checked").length > 0){
			$(".select_investor_deposit:checked").each(function(key) {
				var inv_name		=	$(this).attr("data-investor-name");
				var depositDate		=	$(this).attr("data-depositDate");
				var depositAmount	=	$(this).attr("data-depositAmount");
				var status			=	$(this).attr("data-status");
				if(status	!=	appr_applicable){
					errMessage	=	errMessage+"Not Applicable  Investor Name:"+inv_name+",Deposit Date:";
					errMessage	=	errMessage+depositDate+",Deposit Amount:"+depositAmount+"<br>";
				}
			});
			if(errMessage!=""){
				showDialog("",errMessage);
				return false;
			}
			$("#processType").val("unapprove");
			$("#form-investor-listing").submit();
		}
    });
	$("#bulk_delete_button").click(function(){
		var	appr_applicable	=	$("#default_verified_applicable").val();
		var	errMessage		=	"";
		if ($(".select_investor_deposit:checked").length > 0){
			$(".select_investor_deposit:checked").each(function(key) {
				var inv_name		=	$(this).attr("data-investor-name");
				var depositDate		=	$(this).attr("data-depositDate");
				var depositAmount	=	$(this).attr("data-depositAmount");
				var status			=	$(this).attr("data-status");
				if(status	!=	appr_applicable){
					errMessage	=	errMessage+"Not Applicable  Investor Name:"+inv_name+",Deposit Date:";
					errMessage	=	errMessage+depositDate+",Deposit Amount:"+depositAmount+"<br>";
				}
			});
			if(errMessage!=""){
				showDialog("",errMessage);
				return false;
			}
			$("#processType").val("delete");
			$("#form-investor-listing").submit();
		}
    });
	
    $("#select_all_list").click(function(){
		checkall_list(this,"select_investor_deposit");
	});
   $("#new_button").click(function(){
	   var	url	=	$(this).attr("data-url");
	   window.location	=	url;
	});
});
