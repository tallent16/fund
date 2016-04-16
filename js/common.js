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
