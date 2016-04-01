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
        if($(this).hasClass("disabled"))
            return false;
    });
    
	 $("#next_button").click(function(){
		 $('span.error').remove();
		 $('div.has-error').removeClass("has-error");
		var active = $("ul.nav-tabs li.active a");
        var	cur_tab		=	active.attr("href");
        cur_tab			=	cur_tab.replace("#","");
        switch(cur_tab) {
			case	'company_info':
				  if(!validateTab(cur_tab)) {
						$('.nav-tabs a[href="#director_info"]').tab('show');
						$('a[href="#director_info"]').parent().removeClass("disabled");
					}
				break;
			case	'director_info':
				  if(validateTab('company_info')) {
						$('.nav-tabs a[href="#company_info"]').tab('show');
						return;
					}
					$('.nav-tabs a[href="#profile_info"]').tab('show');
					$('a[href="#profile_info"]').parent().removeClass("disabled");
				break;
			case	'profile_info':
				  if(validateTab('company_info')) {
						$('.nav-tabs a[href="#company_info"]').tab('show');
						return;
					}
					if(!validateTab(cur_tab)) {
						$('.nav-tabs a[href="#financial_info"]').tab('show');
						$('a[href="#financial_info"]').parent().removeClass("disabled");
					}
					
				break;
				
		}
    });
});

function validateTab(cur_tab) {
	
	$("#"+cur_tab+" :input.required").each(function(){
		var	input_id	=	$(this).attr("id");
		var inputVal 	= 	$(this).val();
		var $parentTag = $("#"+input_id+"_parent");
		if(inputVal == ''){
			$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
		}
	});
	if ($("#"+cur_tab).has('div.has-error').length > 0)
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
