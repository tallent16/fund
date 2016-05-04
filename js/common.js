var	formElementsChanged	=	false;
var	formValid			=	false;

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
    $("#side-menu li a").on('click',function(event){
		if(formElementsChanged) {
			cancelNavigationClicked();
		}else{
			formValid	=	true;
		}
		if (!formValid) 
			event.preventDefault();
	});
	function cancelNavigation(retval) {
		// This is called from the showDialogWithOkCancel as a callback when the user clicks one of the 
		// OK or Cancel buttons.
		if (retval == 1) {
			formValid = true;
			 $("#side-menu li a").click();
		} else {
			formValid = false;
		}
		
	}
	
	function cancelNavigationClicked() {
		// The dialog box utility of jQuery is asynchronous. The execution of the Javascript code will not wait
		// for the user input. Therefore we have a callback function to re-trigger the submission if the 
		// user confirms cancellation
		
		if (formValid) {
			return;
		} 
		formElementsChanged	=	false;
		retval = showDialogWithOkCancel("", "Do you want to proceed  navigate it may lose change", "cancelNavigation")
		
	}
	callSubmitReplyActionFunc();
	callAdminCommonFunc();
   
   $('form').on('change', 'input, select, textarea', function(){
		console.log('Form changed!');
		formElementsChanged	=	true;
	});
});
function callAdminCommonFunc(){
	/*=========================================================================================================
	 * Admin Manage Borrowers jquery event function starts
	 * ========================================================================================================*/
	 
	/* This click event is create new comments
	 * by the admin
	 */ 
	$("#add_comment_button").click(function(){
		screenType	=	$(this).attr("data-screen-type");
		addNewCommentRow(screenType);
    });
	/* This click event is delete comments
	 * by the admin
	 */ 
	$("#delete_comment_button").click(function(){
	   delCommentRow();
    });
	/* This click event is submit comments
	 * by the admin
	 */ 
	$("#save_comment_button").click(function(){
		var comments	=	new Array();
		var	errMessage	=	"";
		var	i			=	0
		$('span.error').remove();
		$('.has-error').removeClass("has-error");
		
		if ($(".select_comment:not(#comment_id_XXX)").length > 0){
			$(".select_comment").each(function() {
				var rowID	=	$(this).attr("data-row-id");
				if(rowID	!=	"XXX"){
					if($("#comments_"+rowID).val()	==	"") {
						$parentTag	=	$("#comments_"+rowID+"_parent");;
						$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
					}
				}
			});
			if ($("#commentBoxContainer").has('.has-error').length == 0){
				$("#admin_process").val("save_comments");
				$("#form-profile").submit();	
			}
		}
    });
    $("#select_all_comments").click(function(){
		checkall_list(this,"select_comment");
	});
    $(".commentClass").click(function(){
		var	commentId	=	$(this).attr("id");
		var	id			=	commentId.replace("comment_status_","");
		if($(this).is(":checked")) {
			$("#comment_status_hidden_"+id).val(2);
		}else{
			$("#comment_status_hidden_"+id).val(1);
		}
	});
	/* This click event is update borrower status
	 * by the admin
	 */ 
	$("#returnback_button").click(function(){
		screenType	=	$(this).attr("data-screen-type");
		$("#admin_process").val("return_"+screenType);
		
		$("#form-profile").submit();
    });
	$("#approve_profile_button").click(function(){
	
		$("#admin_process").val("approve");
		
		$("#form-profile").submit();
    });
	/* This click event is update borrower grade
	 * by the admin
	 */ 
	$("#update_grade").click(function(){
       $("#admin_process").val("update_grade");
    //   $("#form-profile").submit();
    });
    /*=========================================================================================================
	 * Admin Manage Borrowers jquery event function ends
	 * ========================================================================================================*/	
}

/* 	This function get commentTemplate and create new comment
*/ 
function addNewCommentRow(screenType){
		
		screenMode	=	$("#screen_mode").val();
		htmlTemplate = $("#commentTemplate").html();
		counterint = parseInt($("#max_comment").val());

		counterint++;
		counterstr = counterint.toString();

		htmlTemplate = htmlTemplate.replace(/XXX/g, counterstr);
		$("#commentBoxContainer").append(htmlTemplate);
		if(screenType	==	"borrower"){
			$("#input_tab_"+counterstr).selectpicker("refresh");
		}
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
/* 	This function delete the selected comments
*/ 
function delCommentRow(){
	if ($(".select_comment:checked").length > 0){
		$(".select_comment:checked").each(function() {
			var rowID	=	$(this).attr("data-row-id");
			if(rowID	!=	"XXX")
				$("#comment-row-"+rowID).remove();
		});
	}
}
/* 	This function check the all comments are closed if yes 
 * borrower allow to submit for approval
*/ 
function checkAdminAllCommentsClosed(){
	var	no_of_comments			=	$(".commentClass:not(#comment_status_XXX)").length;
	var	no_of_checked_comments	=	$(".commentClass:not(#comment_status_XXX):checked").length;
	//~ alert("no_of_comments:"+no_of_comments+" | no_of_checked_comments:"+no_of_checked_comments);
	if(no_of_comments	!=	no_of_checked_comments)
		return true;
	return false;
}

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
	
	$title = "Fund Yourselves Now";
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

function showDialogWithOkCancel($title, $message, $callback) {
	$title = "Fund Yourselves Now";
	htmlelement = "<div id='dialog-message' title='"+ $title + "'> <p> " + $message+ " </p> </div>"
	$('body').append(htmlelement);

	var buttonClicked = false;
	var retval = 1;
	$( "#dialog-message" ).dialog({
		modal: true,
		buttons: [
				{
					text: "Ok",
					click: function() {
						$( this ).dialog( "close" );
						$( this ).dialog( "destroy");
						$( this ).remove();
						window[$callback] (1);
						
				}
				},
				{
					text: "Cancel",
					click: function() {
						$( this ).dialog( "close" );
						$( this ).dialog( "destroy" );
						$( this ).remove();
						window[$callback] (-1);
					}
				}
				]
	});
	
}

function checkall_list(obj,classname){

	if(obj.checked) { 
		
		$('.'+classname).each(function() { 
			this.checked = true; 
		});
	}else{
		
		$('.'+classname).each(function() { 
			this.checked = false;                       
		});         
	}
}

/*------------------------------------------------------------------------
 * Maths Functions to get a proper rounding, ceil, floor of a number
 * taken from the site: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Math/round
 * 
 * */
// Closure
(function() {
  /**
   * Decimal adjustment of a number.
   *
   * @param {String}  type  The type of adjustment.
   * @param {Number}  value The number.
   * @param {Integer} exp   The exponent (the 10 logarithm of the adjustment base).
   * @returns {Number} The adjusted value.
   */
  function decimalAdjust(type, value, exp) {
    // If the exp is undefined or zero...
    if (typeof exp === 'undefined' || +exp === 0) {
      return Math[type](value);
    }
    value = +value;
    exp = +exp;
    // If the value is not a number or the exp is not an integer...
    if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0)) {
      return NaN;
    }
    // Shift
    value = value.toString().split('e');
    value = Math[type](+(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp)));
    // Shift back
    value = value.toString().split('e');
    return +(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp));
  }

  // Decimal round
  if (!Math.round10) {
    Math.round10 = function(value, exp) {
      return decimalAdjust('round', value, exp);
    };
  }
  // Decimal floor
  if (!Math.floor10) {
    Math.floor10 = function(value, exp) {
      return decimalAdjust('floor', value, exp);
    };
  }
  // Decimal ceil
  if (!Math.ceil10) {
    Math.ceil10 = function(value, exp) {
      return decimalAdjust('ceil', value, exp);
    };
  }
})();
