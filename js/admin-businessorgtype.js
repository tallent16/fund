$(document).ready(function (){  
	$("#select_all_list").click(function(){	 
		checkall_list(this,"select_businessorgtype_id");
	});			
});	

/*Delete Question*/
$("#delete_businessorgtype").click(function(){
//$('input:checkbox:checked').parents("tr").remove();	
	$('table tr').each(function (i) {
		if ($(this).find('input[type="checkbox"]').is(':checked')) {
			$(this).closest('tr').remove();
		}

	});       
});

/*Add New Question*/
$("#new_businessorgtype").click(function(){
	addNewRow();
});
function addNewRow(){
		htmlTemplate = $("#businessOrgTypeTemplate").html();
		counterint = parseInt($("#business_org_type_id").val());

		counterint++;
		counterstr = counterint.toString();

		htmlTemplate = htmlTemplate.replace(/XXX/g, counterstr);
		$("#admin_table tbody").append("<tr>"+htmlTemplate+"</tr>");		
		$("#business_org_type_id").val(counterstr);
}	
