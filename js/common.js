$(document).ready(function (){  
	
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
	});
    $(".replyLink").on('click',function(){
		var replyID	=	$(this).attr("data-reply-id");
		$("#commentBoxInput-"+replyID).focus();
	});
    $(".submit_comment").on('click',function(){
		var commentID	=	$(this).attr("id");
		var loanID		=	$("#loanID-"+commentID).val();
		var userID		=	$("#commentUser-"+commentID).val();
		var commentTxt	=	$("#commentBoxInput-"+commentID).val();
		if(commentTxt	!=	"") {
			var data = {	
						commentID: commentID, 
						loanID: loanID, 
						userID: userID,
						commentTxt: commentTxt
						};
		
			// process the form
			$.ajax({
				type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
				url         : baseUrl+'/ajax/borrower/send_comment', // the url where we want to POST
				data        : data,
				dataType    : 'json'
			})
				// using the done promise callback
				.done(function(data) {
					if(data.status	==	"success"){
						$("#commentBoxInput-"+commentID).val("");
						replyHtmlTemplate	=	$("#replyTemplate").html();
						replyHtmlTemplate 	= 	replyHtmlTemplate.replace(/COMMENTTEXT/g, commentTxt);
						replyHtmlTemplate 	= 	replyHtmlTemplate.replace(/COMMENTID/g, commentID);
						$("#replyBlock-"+commentID).prepend(replyHtmlTemplate);
					}
				});
		}
	});

});
