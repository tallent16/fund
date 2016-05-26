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
		if ($(".select_investor_withdraw:checked").length > 0){
			$(".select_investor_withdraw:checked").each(function(key) {
				var inv_name		=	$(this).attr("data-investor-name");
				var settlementDate	=	$(this).attr("data-settlementDate");
				var requestDate		=	$(this).attr("data-requestDate");
				var withdrawAmt		=	$(this).attr("data-withdrawAmt");
				var	availAmt		=	$(this).attr("data-availAmt");
				var status			=	$(this).attr("data-status");
				if(status	!=	appr_applicable){
					errMessage	=	errMessage+"Not Applicable  Investor Name:"+inv_name+",Settlement Date:";
					errMessage	=	errMessage+settlementDate+",Withdrawal Amount:"+withdrawAmt+"<br>";
				}
			});
			if(errMessage!=""){
				showDialog("",errMessage);
				return false;
			}
			$(".select_investor_withdraw:checked").each(function(key) {
				var inv_name		=	$(this).attr("data-investor-name");
				var settlementDate	=	$(this).attr("data-settlementDate");
				var requestDate		=	$(this).attr("data-requestDate");
				var withdrawAmt		=	$(this).attr("data-withdrawAmt");
				var	availAmt		=	$(this).attr("data-availAmt");
				var status			=	$(this).attr("data-status");
				
				if(	numeral(withdrawAmt).value() >	numeral(availAmt).value() ) {
					errMessage	=	errMessage+" Investor Name:"+inv_name+",Settlement Date:";
					errMessage	=	errMessage+settlementDate+",Withdrawal Amount:"+withdrawAmt+
															" Withdraw Amount exceed available balance<br>";
				}
			});
			if(errMessage!=""){
				showDialog("",errMessage);
				return false;
			}
			$(".select_investor_withdraw:checked").each(function(key) {
				var inv_name		=	$(this).attr("data-investor-name");
				var settlementDate	=	$(this).attr("data-settlementDate");
				var requestDate		=	$(this).attr("data-requestDate");
				var withdrawAmt		=	$(this).attr("data-withdrawAmt");
				var	availAmt		=	$(this).attr("data-availAmt");
				var status			=	$(this).attr("data-status");
				
				requestDate=new Date(requestDate.split("-")[2], requestDate.split("-")[0],
														requestDate.split("-")[1]);
				settlementDate=new Date(settlementDate.split("-")[2], settlementDate.split("-")[0],
															settlementDate.split("-")[1]);
				if(	requestDate >	settlementDate ) {
					errMessage	=	errMessage+"Not Applicable  Investor Name:"+inv_name;
					errMessage	=	errMessage+",Withdrawal Amount:"+withdrawAmt+
										" Request Date "+$(this).attr("data-requestDate")+ 
										"should not be greater than"+
										 "Settlement Date "+ $(this).attr("data-settlementDate")+"<br>";
				}
			});
			if(errMessage!=""){
				showDialog("",errMessage);
				return false;
			}
			$("#processType").val("approve");
			$("#form-investor-listing").attr("action",baseUrl+"/admin/investorwithdrawallist/bulkapprove");
			$("#form-investor-listing").submit();
		}
    });
	$("#bulk_unapprove_button").click(function(){
		var	appr_applicable	=	$("#default_verified_applicable").val();
		var	errMessage		=	"";
		if ($(".select_investor_withdraw:checked").length > 0){
			$(".select_investor_withdraw:checked").each(function(key) {
				var inv_name		=	$(this).attr("data-investor-name");
				var settlementDate	=	$(this).attr("data-settlementDate");
				var withdrawAmt		=	$(this).attr("data-withdrawAmt");
				var status			=	$(this).attr("data-status");
				if(status	!=	appr_applicable){
					errMessage	=	errMessage+"Not Applicable  Investor Name:"+inv_name+",Settlement Date:";
					errMessage	=	errMessage+settlementDate+",Withdrawal Amount:"+withdrawAmt+"<br>";
				}
			});
			if(errMessage!=""){
				showDialog("",errMessage);
				return false;
			}
			$("#processType").val("unapprove");
			$("#form-investor-listing").attr("action",baseUrl+"/admin/investorwithdrawallist/bulkunapprove");
			$("#form-investor-listing").submit();
		}
    });
	$("#bulk_delete_button").click(function(){
		var	appr_applicable	=	$("#default_unverified_applicable").val();
		var	errMessage		=	"";
		if ($(".select_investor_withdraw:checked").length > 0){
			$(".select_investor_withdraw:checked").each(function(key) {
				var inv_name		=	$(this).attr("data-investor-name");
				var settlementDate	=	$(this).attr("data-settlementDate");
				var withdrawAmt		=	$(this).attr("data-withdrawAmt");
				var status			=	$(this).attr("data-status");
				if(status	!=	appr_applicable){
					errMessage	=	errMessage+"Not Applicable  Investor Name:"+inv_name+",Settlement Date:";
					errMessage	=	errMessage+settlementDate+",Withdrawal Amount:"+withdrawAmt+"<br>";
				}
			});
			if(errMessage!=""){
				showDialog("",errMessage);
				return false;
			}
			$("#processType").val("delete");
			$("#form-investor-listing").attr("action",baseUrl+"/admin/investorwithdrawallist/bulkdelete");
			$("#form-investor-listing").submit();
		}
    });
	
    $("#select_all_list").click(function(){
		checkall_list(this,"select_investor_withdraw");
	});
   $("#new_button").click(function(){
	   var	url	=	$(this).attr("data-url");
	   window.location	=	url;
	});
});
