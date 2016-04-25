$(document).ready(function (){  
	
	$("#add_loanapply_comment_button").click(function(){
		screenType	=	$(this).attr("data-screen-type");
		addNewLoanApplyCommentRow(screenType);
    });
	$("#returnback_loanapply_button").click(function(){
		
		$("#admin_process").val("return_borrower");
		
		$("#form-profile").submit();
    });
	$("#approve_loanapply_button").click(function(){
	
		$("#admin_process").val("approve");
		
		$("#form-profile").submit();
    });
	$("#close_comment_button").click(function(){
		$(".commentClass").each(function() {
			var	id	=	$(this).attr("id").replace("comment_status_","");
			$(this).attr("checked",true);
			$(this).prop("checked",true);
			$("#comment_status_hidden_"+id).val(2);
		});
    });
	$("#cancel_loanapply_button").click(function(){
		
		$("#admin_process").val("cancel");
		
		$("#form-profile").submit();
    });

});

function addNewLoanApplyCommentRow(screenType){
		
	screenMode		=	$("#screen_mode").val();
	htmlTemplate 	= 	$("#commentTemplate").html();
	counterint 		= 	parseInt($("#max_comment").val());

	counterint++;
	counterstr = counterint.toString();

	htmlTemplate = htmlTemplate.replace(/XXX/g, counterstr);
	$("#commentBoxContainer").append(htmlTemplate);
	
	$("#max_comment").val(counterstr);

	$(".commentClass").click(function(){
		var	commentId	=	$(this).attr("id");
		var	id			=	commentId.replace("comment_status_","");
		if($(this).is(":checked")) {
			$("#comment_status_hidden_"+id).val(2);
		}else{
			$("#comment_status_hidden_"+id).val(1);
		}
	});
}
