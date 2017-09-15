$(document).ready(function (){  
	// test push check
	 $('div.ui-button').on('dialogclose', function(event) {
		alert('closed');SS
	});
		
	$(".approveRepayment").click(function(e) {
			if($(this).attr("data-tranf-no") ==	"") {
				showDialog("","Cannot Approve the Repayment due to empty transcation reference number");	
				e.preventDefault();
			}
	});
	
	$("#bulk_approve_button").click(function(){
		var	appr_applicable	=	$("#default_unverified_applicable").val();		
		var	errMessage		=	"";
		if ($(".select_repayment:checked").length > 0){
			$(".select_repayment:checked").each(function(key) {
				var loan_ref	=	$(this).attr("data-loan-ref");
				var schdDate	=	$(this).attr("data-schdDate");
				var penality	=	$(this).attr("data-penality");
				var status		=	$(this).attr("data-status");
				
				if(status	!=	appr_applicable){
					errMessage	=	errMessage+"Not Applicable for this Loan Loan Ref:"+loan_ref+",Schedule Date:";
					errMessage	=	errMessage+schdDate+",Penality:"+penality+"<br>";
				}
			});
			if(errMessage!=""){
				showCusDialog("",errMessage);	
				return false;
			}
			$(".select_repayment:checked").each(function(key) {
				var loan_ref	=	$(this).attr("data-loan-ref");
				var schdDate	=	$(this).attr("data-schdDate");
				var penality	=	$(this).attr("data-penality");
				var trans_ref	=	$(this).attr("data-tran-ref");
				if(trans_ref	==	""){ 
					errMessage	=	errMessage+"Transaction Reference Number shoud not be empty for this Loan Loan Ref:"+loan_ref+",Schedule Date:";
					errMessage	=	errMessage+schdDate+",Penality:"+penality+"<br><br>";
				}
			});
			if(errMessage!=""){
				showCusDialog("",errMessage);	
				return false;
			}
			$("#form-borrower-repayment").submit();
		}
    });
	
    $("#select_all_list").click(function(){
		checkall_list(this,"select_repayment");
	});
   
});
function showCusDialog($title, $message) {
	
	$title = "Fund Yourselves Now";
	htmlelement = "<div id='dialog-message' title='"+ $title + "'> <p> " + $message+ " </p> </div>"
						
	$('body').append(htmlelement);
	
	$( "#dialog-message" ).dialog({
		modal: true,
		buttons: {
			Ok: function() {			
				$('.select_repayment').prop('checked', false); 
				$( this ).dialog( "close" );
				$( this ).dialog( "destroy" );
				$( this ).remove();
			}
		}
    });
}
