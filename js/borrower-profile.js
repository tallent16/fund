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
  
});
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
