$(document).ready(function (){  
	$("#select_all_list").click(function(){	 
		checkall_list(this,"select_question_id");
	});	
	
	
	/*Delete Question*/
$("#delete_question").click(function(){
	//$('input:checkbox:checked').parents("tr").remove();
	
        $('table tr').each(function (i) {
            if ($(this).find('input[type="checkbox"]').is(':checked')) {
                $(this).closest('tr').remove();
            }

        });
        AutoNumber();
});
AutoNumber();

function AutoNumber(){
	$('table tr').each(function (i) {
		$(this).find('span').text(i);
	});
}
	
	
	
	
	
	
	
	
	
	
	
	
		
});
/*Add New Question*/
$("#new_question").click(function(){
	addNewRow();
});
function addNewRow(){
		htmlTemplate = $("#questionTemplate").html();
		counterint = parseInt($("#question_id").val());

		counterint++;
		counterstr = counterint.toString();

		htmlTemplate = htmlTemplate.replace(/XXX/g, counterstr);
		$("#security_table tbody").append("<tr>"+htmlTemplate+"</tr>");		
		$("#question_id").val(counterstr);
}

