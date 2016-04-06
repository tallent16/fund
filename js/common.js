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
  callSubmitReplyActionFunc();

   
});
function callSubmitReplyActionFunc() { 
	 $(".submit_reply").on('click',function(){
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
				url         : replyUrl, // the url where we want to POST
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
}
function onFocusNumberField($thisField) {
	if ($($thisField).attr("decimal") !== undefined) {
		console.log($($thisField).val());
		console.log($thisField);
		$valueofNumber = numeral($($thisField).val()).value();
		$($thisField).attr("placeholder", "0");
		if ($valueofNumber == 0) {
			$($thisField).val("");
		}

	}
	//  $($thisField).select()
}

function onBlurNumberField($thisField) {
	$valueofNumber = $($thisField).val();
	$decimal	= $($thisField).attr("decimal")
	$format		= "0,000.00";
	
	switch ($decimal) {
		case "0":
			$format = "0,000";
			break;
			
		case "2":
			$format = "0,000.00"
			break;
			
		case "4":
			$format = "0,000.0000";
			break;
			
		case "5":
			$format = "0,000.00000";
			break;
			
		case "8":
			$format = "0,000.00000000";
			break;
		
	}
	
	$formatNumber = numeral($valueofNumber).format($format);
	
	$($thisField).val($formatNumber);
	
}
function showDialog($title, $message) {
	
	$title = "Money Match Management System";
	htmlelement = "<div id='dialog-message' title='"+ $title + "'> <p> " + $message+ " </p> </div>"
						
	$('body').append(htmlelement);
	
	$( "#dialog-message" ).dialog({
      modal: true,
      buttons: {
        Ok: function() {
		  $( this ).dialog( "close" );
          $( this ).dialog( "destroy" );
          $( this ).remove();
        }
      }
    });
	

}
