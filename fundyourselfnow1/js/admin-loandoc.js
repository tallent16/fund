$(document).ready(function (){  
	$("#select_all_list").click(function(){	 
		checkall_list(this,"select_loandoc_id");
	});			
});	

/*Add New Question*/
$("#new_doc").click(function(){
	addNewRow();
	AutoNumber();     
});
function addNewRow(){
		htmlTemplate = $("#loandocTemplate").html();
		counterint = parseInt($("#loandoc_id").val());

		counterint++;
		counterstr = counterint.toString();

		htmlTemplate = htmlTemplate.replace(/XXX/g, counterstr);
		$("#admin_table tbody").append("<tr>"+htmlTemplate+"</tr>");		
		$("#loandoc_id").val(counterstr);
		$("#is_mandatory_"+counterstr).selectpicker("refresh");
		$("#is_active_"+counterstr).selectpicker("refresh");
}	

/*Delete Question*/
$("#delete_doc").click(function(){
	$('table#admin_table tr').each(function (i) {
		if ($(this).find('input.select_loandoc_id').is(':checked')) {
			$(this).closest('tr').remove();
			$('#delete_check').val( function(i, oldval) {
				return parseInt( oldval, 10) + 1;
			});
		}
	});  
	 AutoNumber();     
});
function AutoNumber(){
	$('table#admin_table tr').each(function (i) {
		$(this).find('span.slno').text(i);
	});
}
