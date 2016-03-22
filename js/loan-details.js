$(document).ready(function (){  
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
	});
	/*List one record at a time*/	    
	$("#bid_now").click(function(){
		$(this).hide();
		$('#form-bid').show();
    });

    $("#cancel_bid").click(function(){
		$('#isCancelButton').val("yes");
    });
	
	 $("#newCommentBoxButton").on('click',function(){
		
		
		var loanID		=	$("#loanID-XXX").val();
		var userID		=	$("#commentUser-XXX").val();
		var commentTxt	=	$("#newCommentBoxInput").val();
		if(commentTxt	!=	"") {
			var data = {	
						loanID: loanID, 
						userID: userID,
						commentTxt: commentTxt
						};
		
			// process the form
			$.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : baseUrl+'/ajax/investor/send_comment', // the url where we want to POST
				data        : data,
				dataType    : 'json'
			})
				// using the done promise callback
				.done(function(data) {
					if(data.status	==	"success"){
						
						$("#newCommentBoxInput").val("");
						commentHtmlTemplate		=	$("#commentTemplate").html();
						commentHtmlTemplate 	= 	commentHtmlTemplate.replace(/COMMENTTEXT/g, commentTxt);
						commentHtmlTemplate 	= 	commentHtmlTemplate.replace(/XXX/g, data.comment_id);
						$(".mainCommentDivBlock").prepend(commentHtmlTemplate);
						callSubmitReplyActionFunc();
					}
				});
		}
	});

});
