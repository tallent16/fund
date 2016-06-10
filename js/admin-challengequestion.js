$(document).ready(function (){  
	$("#select_all_list").click(function(){	 
		checkall_list(this,"select_question_id");
	});			
});	

/*Add New Question*/
$("#new_question").click(function(){
	addNewRow();
	AutoNumber();
});
function addNewRow(){
		htmlTemplate = $("#questionTemplate").html();
		counterint = parseInt($("#question_id").val());

		counterint++;
		counterstr = counterint.toString();

		htmlTemplate = htmlTemplate.replace(/XXX/g, counterstr);
		$("#admin_table tbody").append("<tr>"+htmlTemplate+"</tr>");		
		$("#question_id").val(counterstr);
}	

/*Delete Question*/
$("#delete_question").click(function(event){
	$('table#admin_table tr').each(function (i) {
		if ($(this).find('input.select_question_id').is(':checked')) {
			$(this).closest('tr').remove();
		}
	});
     AutoNumber();
});
function AutoNumber(){
	$('table#admin_table tr').each(function (i) {
		$(this).find('span').text(i);
	});
}
