var formValid	=	false;
$(document).ready(function (){ 
	//file extension check
	/* $('#submit_button').click(function(e) {
      var file = $('input[type="file"]').val();
      var exts = ['png','jpg','jpeg','gif'];
      // first check if file field has any value
      if ( file ) {
        // split file name at dot
        var get_ext = file.split('.');
        // reverse name to check extension
        get_ext = get_ext.reverse();
        // check file type is valid as given in 'exts' array
        if ( $.inArray ( get_ext[0].toLowerCase(), exts ) > -1 ){
          $('#company_image_parent').addClass('has-error').append('<span class="control-label error">Allowed Extension* Jpg,png,jpeg</span>');
        } else {
          $('#company_image_parent').addClass('has-error').append('<span class="control-label error">Invalid Extension</span>');
        
          e.preventDefault();
        }
      }
    });	*/
    
  /* $('#submit_button').click(function(e) {
		var file = $('input[type="file"]').val();
		if(file != ''){		
			if ( /\.(jpe?g|png|gif|jpg)$/i.test(file) ) {
				
				alert('valid');
			}else{
				alert('invalid');
				$('#company_image_parent').addClass('has-error').append('<span class="control-label error">Invalid Extension</span>');
				e.preventDefault();
			}
		}
	});*/

	
	//Only Mobile Numbers
	 $(".mobile").keypress(function (e) {
     //if the letter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
        $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
	 
    //Only accept numbers    
	$(".numeric").keydown(function(event) { 
		// Allow only backspace and delete
		if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 ) {
			// let it happen, don't do anything
		}
		else {
			// Ensure that it is a number and stop the keypress
			if (event.keyCode < 48 || event.keyCode > 57 ) {
				event.preventDefault();	
			}	
		}
	});		
	
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
    
	$("#admin_save_button").click(function(){
      $("#isSaveButton").val("yes");
       $("#form-profile").attr("action",baseUrl+"/admin/borrower/profile/save");
       formValid	=	true;
    });
    
	$("#approve_profile_button").click(function(){
		$("#form-profile").attr("action",baseUrl+"/admin/borrower/profile/approve");
		
		formValid	=	true;
		
		if(validateTab("company_info"))
			formValid	=	false;
		if(validateTab("director_info"))
			formValid	=	false;
		if(validateTab("profile_info"))
			formValid	=	false;
		if(validateTab("financial_info"))
			formValid	=	false;
		if(validateTab("bank_info"))
			formValid	=	false;
		if(validateTab("bank_info"))
			formValid	=	false;
			
		if($('.commentClass:not(#comment_status_XXX)').not(':checked').length){
			errMessage	=	"Please close all comments before approve";
			showDialog("",errMessage);
			$('.nav-tabs a[href="#comments_info"]').tab('show');
			formValid	=	false;
		}
		
    });
    
	$("#update_grade").click(function(){
      $("#form-profile").attr("action",baseUrl+"/admin/borrower/profile/update_grade");
    });
    
	$("#returnback_button").click(function(){
      $("#form-profile").attr("action",baseUrl+"/admin/borrower/profile/return_borrower");
      
		if($('.commentClass:checked').length){
			errMessage	=	"There is no open comments to return back to borrower";
			showDialog("",errMessage);
			formValid	=	false;
		}else{
			formValid	=	true;
		}
    });
	
	$("#save_comment_button").click(function(){
      $("#form-profile").attr("action",baseUrl+"/admin/borrower/profile/save_comments");
      formValid	=	true;
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
		
		if($(this).hasClass("disabled"))
			return false;
		currentTabNextButton($(this));
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
				formValid	=	false;
			}
		}
		
		if($("#screen_mode").val()	==	"admin"){
			
			if(!formValid){
				event.preventDefault();
			}
			
		}
		$("#active_tab").val($(".nav-tabs li.active a").attr("href"));
	});
	 
	checkAllTabCompleteStatus();
	textAreaToolTip();
});

function callTabValidateFunc() {

	$('span.error').remove();
	$('.has-error').removeClass("has-error");
	var active = $("ul.nav-tabs li.active a");
	var	cur_tab		=	active.attr("href");
	cur_tab			=	cur_tab.replace("#","");
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
			currentTabNextButton($("director_info"));
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
		currentTabNextButton($("director_info"));
		return true;
	}else{
		if(cur_tab	==	"director_info") {
			$('.nav-tabs a[href="#profile_info"]').tab('show');
			$('a[href="#profile_info"]').parent().removeClass("disabled");
			return true;
		}
	}
	if($("#screen_mode").val()	==	"admin") {
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
	}
	if(cur_tab	==	"bank_info") {
		if($("#screen_mode").val()	==	"borrower"){
			if($("#borrower_status").val()	==	"corrections_required"){
				$('.nav-tabs a[href="#comments_info"]').tab('show');
				$("#next_button").hide();
				$("#submit_button").show();
			}
		}else{
			$('.nav-tabs a[href="#comments_info"]').tab('show');
			$("#next_button").hide();
			$("#returnback_button").show();
			$("#approve_profile_button").show();
		}
	}
}
function validateTab(cur_tab) {	
	$("#"+cur_tab+" :input.required").each(function(){		
		var	input_id	=	$(this).attr("id");
		var inputVal 	= 	$(this).val();
		var $parentTag = $("#"+input_id+"_parent");
	
		if($('#'+input_id).hasClass("num")){	
			if(inputVal != ""){
				if(!$.isNumeric(inputVal)){		
					$parentTag.addClass('has-error').append('<span class="control-label error">Only Numbers</span>');
				}
			}
		}
		if(inputVal == ''){
			switch(input_id){
				case 'company_image':
				case 'acra_profile_doc_url':
				case 'moa_doc_url':
					if($("#"+input_id+"_hidden").val() == ''){
						$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
					}
					break;	
				default:
					
					if($('#'+input_id).hasClass("attachment")){
						
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
		$("#name_"+counterstr).val("");	
		$("#max_director").val(counterstr);
		$("#directorDropDown").append("<option value='"+counterstr+"'>"+""+"</option>");
		$('#directorDropDown').val(counterstr);
		$("#directorDropDown").selectpicker("refresh");
		$(".divs div.dir-list:visible").hide();
        $(".divs div.dir-list:last").show();
        textAreaToolTip();
        
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

function textAreaToolTip() {
	 $('[data-toggle="tooltip"]').tooltip();
}

function checkAllTabCompleteStatus() {
	$("#submit_button").hide();
	var	profile_status			=	$("#profile_status").val();
	var	company_info_complete	=	$("#company_info_complete").val();
	var	director_info_complete	=	$("#director_info_complete").val();
	var	bank_info_complete		=	$("#bank_info_complete").val();
	var	active_tab				=	$("#active_tab").val();
	
	if ( profile_status	== "New profile") {
		
		if (parseInt(company_info_complete)) {
			enable_director_info_tab();
			hide_next_button();
		} else {
			disable_director_info_tab();
			disable_bank_info_tab();
			show_next_button();
		}

		if (parseInt(director_info_complete)) {
			enable_bank_info_tab();
		} else {
			disable_bank_info_tab();
		}
		
	}else {
		enable_director_info_tab();
		enable_bank_info_tab();
	}
	switch(active_tab){
		case "#company_info":
			$('.nav-tabs a[href="#company_info"]').tab('show');
			break;
		case "#director_info":
			if(!$("#director_info_parent").hasClass("disabled")) {
				$('.nav-tabs a[href="#director_info"]').tab('show');
				currentTabNextButton($("#director_info_parent"));
			}
			break;
		case "#profile_info":
			if(!$("#profile_info_parent").hasClass("disabled")) {
				$('.nav-tabs a[href="#profile_info"]').tab('show');
			}
			break;
		case "#financial_info":
			if(!$("#financial_info_parent").hasClass("disabled")) {
				$('.nav-tabs a[href="#financial_info"]').tab('show');
			}
			break;
		case "#bank_info":
			if(!$("#bank_info_parent").hasClass("disabled")) {
				$('.nav-tabs a[href="#bank_info"]').tab('show');
				if($("#borrower_status").val()	==	""){
					$("#submit_button").show();
				}
			}
			break;
		case "#comments_info":
			$('.nav-tabs a[href="#comments_info"]').tab('show');
			$("#submit_button").show();
			$("#returnback_button").show();
			$("#approve_profile_button").show();
			break;
	}
	
	
}

function enable_director_info_tab() {
	$("#director_info_parent").removeClass("disabled");
}
function disable_director_info_tab() {

	$("#director_info_parent").addClass("disabled");
}

function enable_bank_info_tab() {
	$("#bank_info_parent").removeClass("disabled");
}
function disable_bank_info_tab() {

	$("#bank_info_parent").addClass("disabled");
}
function show_next_button() {
	$("#next_button").show();
}
function hide_next_button() {
	$("#next_button").hide();
}
function currentTabNextButton($this) {
	$("#submit_button").hide();
	var	profile_status			=	$("#profile_status").val();
	var	company_info_complete	=	$("#company_info_complete").val();
	var	director_info_complete	=	$("#director_info_complete").val();
	var	bank_info_complete		=	$("#bank_info_complete").val();
	
	if ( profile_status	== "New profile") {
		if($this.find("a").attr("href")	==	"#company_info") {
			if (parseInt(company_info_complete))  {
				hide_next_button();
			}else{
				show_next_button();
			}
		}
		if($this.find("a").attr("href")	==	"#director_info") {
			if (parseInt(director_info_complete))  {
				hide_next_button();
			}else{
				show_next_button();
			}
		}
	}
	if($this.find("a").attr("href")	==	"#bank_info") {
		if($("#screen_mode").val()	==	"borrower"){
			if($("#borrower_status").val()	==	""){
				hide_next_button();
				$("#submit_button").show();
			}
		}
	}
	if($this.find("a").attr("href")	==	"#comments_info") {
		hide_next_button();
		$("#submit_button").show();
		$("#returnback_button").show();
		$("#approve_profile_button").show();
	}

}
function writeReply(replyId) {
	$("#"+replyId).show();
	$("#"+replyId).focus();
}
function fileextensioncheck(){	
	$('#submit_button,#save_button').click(function(event) {	
	var ext = $('input[type=file]').val().split('.').pop().toLowerCase();
		if(ext != ''){
			if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
				$('#company_image_parent').addClass('has-error').append('<span class="control-label error">Invalid Extension</span>');				
				false;
				event.preventDefault();
			}
		}
	});	
}

/*	
var val = $('input[type=file]').val().toLowerCase();
var regex = new RegExp("(.*?)\.(jpg|jpeg|png|gif)$");
if(val != ''){
	if(!(regex.test(val))) {				
			$('#company_image_parent').addClass('has-error').append('<span class="control-label error">Invalid Extension</span>');
			return false;
		} 
}*/

