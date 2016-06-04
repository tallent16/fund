$(document).ready(function (){  
	$("#select_all_list").click(function(){	 
		checkall_list(this,"select_question_id");
	});		
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
		$("#security_id"+counterstr).val("");	
		$("#question_id").val(counterstr);
}
/*Delete Question*/
$("#delete_question").click(function(){
	$('input:checkbox:checked').parents("tr").remove();
});
