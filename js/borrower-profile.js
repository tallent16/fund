$(document).ready(function (){  
	
	$(".divs div.dir-list").each(function(e) {
        if (e != 0)
            $(this).hide();
    });
    
    $("#directorDropDown").on('change',function(){
		selectedValue	=	$(this).find("option:selected").val();
		if(selectedValue	==	"")
			return;
		  $(".divs div.dir-list:visible").hide();
          $("#"+selectedValue).show();
	});

    $("#next").click(function(){
		 if ($(".divs div.dir-list:visible").next().length != 0){
            $(".divs div:visible").next().show().prev().hide();
         }
        else {
		    $(".divs div.dir-list:visible").hide();
            $(".divs div.dir-list:first").show();
        }
        changeDropDown	=	$('.divs div.dir-list:not(:hidden)').attr("id");
        resetDirectorDropDown(changeDropDown);
        console.log($('.divs div.dir-list:visible').attr("id"));
		console.log($('.divs div.dir-list:visible').next().attr("id"));
        return false;
    });

    $("#prev").click(function(){
        if ($(".divs div.dir-list:visible").prev().length != 0)
            $(".divs div:visible").prev().show().next().hide();
        else {
            $(".divs div.dir-list:visible").hide();
            $(".divs div.dir-list:last").show();
        }
         changeDropDown	=	$('.divs div.dir-list:not(:hidden)').attr("id");
		
        return false;
    });
	
    $("#add-director").click(function(){
       addNewDirectorRow();
    });
	
	$("#save_button").click(function(){
      $("#isSaveButton").val("yes");
    });
	
    $(".fa-trash").click(function(){
		if($(this).hasClass("disabled"))
			return;
       delDirectorRow();
    });
    
	// date picker
	$('#date_of_incorporation').datetimepicker({
		autoclose: true,
		minView: 2,
		format: 'dd/mm/yyyy'
	});
	// date picker
	$('#operation_since').datetimepicker({
		autoclose: true,
		minView: 2,
		format: 'dd/mm/yyyy'
	});
  
	 $(".nav-tabs > li").click(function(){
		$("#next_button").show();
		$("#submit_button").hide();
		if($(this).hasClass("disabled"))
            return false;
        if($(this).find("a").attr("href")	==	"#bank_info") {
			if($("#screen_mode").val()	==	"borrower"){
				
				if($("#borrower_status").val()	==	""){
					$("#next_button").hide();
					$("#submit_button").show();
				}
			}
		}
        if($(this).find("a").attr("href")	==	"#comments") {
			$("#next_button").hide();
			$("#submit_button").show();
			$("#returnback_button").show();
		}
	});
    
	 $("#next_button").click(function(){
		callTabValidateFunc();
    });
    
	$(".amount-align").on("focus", function() {
			onFocusNumberField(this);
	})

	$(".amount-align").on("blur", function() {
		onBlurNumberField(this)
	})
	
	$("#form-profile").submit(function( event ) {
		if($("#screen_mode").val()	==	"borrower"){
			var	isSaveButtonClicked		=	$("#isSaveButton").val();
			if(isSaveButtonClicked	!=	"yes") {
				
				if(callTabValidateFunc())
					event.preventDefault();
				if(validateTab("bank_info"))
					event.preventDefault();
				if($("#borrower_status").val()	==	"corrections_required") {
					if(checkAdminAllCommentsClosed()){
						showDialog("","Please close the corrections and submit again for approval");
						event.preventDefault();
					}
				}
				$("#next_button").hide();
				$("#submit_button").show();
			}
		}
	});
	/*=========================================================================================================
	 * Admin Manage Borrowers jquery event function starts
	 * ========================================================================================================*/
	 
	/* This click event is create new comments
	 * by the admin
	 */ 
	$("#add_comment_button").click(function(){
       addNewCommentRow();
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
		
		if ($(".select_comment").length > 0){
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
       $("#admin_process").val("return_borrower");
       $("#form-profile").submit();
    });
	/* This click event is update borrower grade
	 * by the admin
	 */ 
	$("#update_grade").click(function(){
       $("#admin_process").val("update_grade");
       $("#form-profile").submit();
    });
    /*=========================================================================================================
	 * Admin Manage Borrowers jquery event function ends
	 * ========================================================================================================*/
	 
	callcheckAllTabFilledFunc();
	
});

function callTabValidateFunc() {

	$('span.error').remove();
	$('.has-error').removeClass("has-error");
	var active = $("ul.nav-tabs li.active a");
	var	cur_tab		=	active.attr("href");
	cur_tab			=	cur_tab.replace("#","");
	$("#next_button").show();
	$("#submit_button").hide();
	$("#director_error_info").hide();
	$("#director_error_info").removeClass("has-error");
	$("#director_error_info").removeClass("alert-danger");
	$("#director_error_label").html("");
	if(validateTab('company_info')) {
		$('.nav-tabs a[href="#company_info"]').tab('show');
		return true;
	}else{
		if(cur_tab	==	"company_info") {
			$('.nav-tabs a[href="#director_info"]').tab('show');
			$('a[href="#director_info"]').parent().removeClass("disabled");
			return true;
		}
	}
	if($(".divs").has('.dir-list').length 	==	0) {
		$("#director_error_info").show();
		$("#director_error_info").addClass("has-error");
		$("#director_error_info").addClass("alert-danger");
		$("#director_error_label").html("Atleast One Director Information Required");
		return true;
	}
	if(validateTab('director_info')) {
		$("#director_error_info").show();
		$("#director_error_info").addClass("has-error");
		$("#director_error_info").addClass("alert-danger");
		$("#director_error_label").html("Required Missing Field in Director Listing ");
		$('.nav-tabs a[href="#director_info"]').tab('show');
		return true;
	}else{
		if(cur_tab	==	"director_info") {
			$('.nav-tabs a[href="#profile_info"]').tab('show');
			$('a[href="#profile_info"]').parent().removeClass("disabled");
			return true;
		}
	}
	if(validateTab('profile_info')) {
		$('.nav-tabs a[href="#profile_info"]').tab('show');
		return true;
	}else {
		if(cur_tab	==	"profile_info") {
			$('.nav-tabs a[href="#financial_info"]').tab('show');
			$('a[href="#financial_info"]').parent().removeClass("disabled");
			return true;
		}
	}
	if(validateTab('financial_info')) {
		$('.nav-tabs a[href="#financial_info"]').tab('show');
		return true;
	}else{
		if(cur_tab	==	"financial_info") {
			$('.nav-tabs a[href="#bank_info"]').tab('show');
			$('a[href="#bank_info"]').parent().removeClass("disabled");
			if($("#screen_mode").val()	==	"borrower"){
				if($("#borrower_status").val()	==	""){
					$("#next_button").hide();
					$("#submit_button").show();
				}
			}
			return true;
		}
	}
	if(cur_tab	==	"bank_info") {
		if($("#screen_mode").val()	==	"borrower"){
			if($("#borrower_status").val()	==	"corrections_required"){
				$('.nav-tabs a[href="#comments"]').tab('show');
				$("#next_button").hide();
				$("#submit_button").show();
			}
		}else{
			$('.nav-tabs a[href="#comments"]').tab('show');
			$("#next_button").hide();
			$("#returnback_button").show();
		}
	}
}
function validateTab(cur_tab) {
	
	$("#"+cur_tab+" :input.required").each(function(){
		var	input_id	=	$(this).attr("id");
		var inputVal 	= 	$(this).val();
		var $parentTag = $("#"+input_id+"_parent");
		if(inputVal == ''){
			if(inputVal == ''){
				if(input_id	==	"company_image") {
					if($("#"+input_id+"_hidden").val() == ''){
						$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
					}
				}else{
					$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
				}
			}
		}
	});
	if ($("#"+cur_tab).has('.has-error').length > 0)
		return true;
	else
		return false;
}
function addNewDirectorRow(){
		
		htmlTemplate = $("#directorTemplate").html();
		counterint = parseInt($("#max_director").val());

		counterint++;
		counterstr = counterint.toString();

		htmlTemplate = htmlTemplate.replace(/XXX/g, counterstr);
		$(".divs ").append(htmlTemplate);
		$("#name_"+counterstr).val("Director"+counterstr);
		$("#max_director").val(counterstr);
		$("#directorDropDown").append("<option value='"+counterstr+"'>"+"Director"+counterstr+"</option>");
		$('#directorDropDown').val(counterstr);
		$("#directorDropDown").selectpicker("refresh");
		$(".divs div.dir-list:visible").hide();
        $(".divs div.dir-list:last").show();
}
function delDirectorRow(){
	if ($(".divs div.dir-list").length > 0){
		curDir	=	$(".divs div.dir-list:visible").attr("id");
		removeDirectorDropDownOption(curDir);
		nextDir	=	getNextDirector();
		if(nextDir	!=	""){
			$(".divs div.dir-list").hide();
            $("#"+nextDir).show();	
		}
	}
}

function resetDirectorDropDown(setValue){
	$("#directorDropDown").val(setValue);
    $("#directorDropDown").selectpicker("refresh");
}

function removeDirectorDropDownOption(removeValue){
	$("#directorDropDown option[value='"+removeValue+"']").remove();
    $("#directorDropDown").selectpicker("refresh");
    $("#"+removeValue).remove();
}

function getNextDirector(){
	return	$("#directorDropDown option:selected").val();
}
function callcheckAllTabFilledFunc() {
	if(checkTabFilled("company_info")){//check Company Info Filled
		$('.nav-tabs a[href="#director_info"]').parent().removeClass("disabled");
		//Enable the Director Info Tab
		if(checkTabFilled("director_info")){//check Director Info Filled
			$('.nav-tabs a[href="#profile_info"]').parent().removeClass("disabled");
			//Enable the Profile Info Tab
			if(checkTabFilled("profile_info")){//check Profile Info Filled
				$('.nav-tabs a[href="#financial_info"]').parent().removeClass("disabled");
				//Enable the Finacial Info  Tab
				if(checkTabFilled("financial_info")){//check Financial Info Filled
					$('.nav-tabs a[href="#bank_info"]').parent().removeClass("disabled");
					//Enable the Bank Info  Tab
				}
			}
		}
	}
}
function checkTabFilled(cur_tab) {
	var	cnt	=	0;
	$("#"+cur_tab+" :input.required").each(function(){
		var inputVal 	= 	$(this).val();
		var	input_id	=	$(this).attr("id");
		if(inputVal == ''){
				if(input_id	==	"company_image") {
					if($("#"+input_id+"_hidden").val() == '')
						cnt++;
				}else{
					cnt++;
				}
			}
	});
	if (cnt == 0)
		return true;
	else
		return false;
}
/* 	This function get commentTemplate and create new comment
*/ 
function addNewCommentRow(){
		
		htmlTemplate = $("#commentTemplate").html();
		counterint = parseInt($("#max_comment").val());

		counterint++;
		counterstr = counterint.toString();

		htmlTemplate = htmlTemplate.replace(/XXX/g, counterstr);
		$("#commentBoxContainer").append(htmlTemplate);
		$("#input_tab_"+counterstr).selectpicker("refresh");
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
