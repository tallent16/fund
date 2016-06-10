$(document).ready(function (){  
	$("#select_all_list").click(function(){	 
		checkall_list(this,"select_industry_id");
	});			
});	

/*Add New Question*/
$("#new_industry").click(function(){
	addNewRow();
	 AutoNumber();
});
function addNewRow(){
		htmlTemplate = $("#industryTemplate").html();
		counterint = parseInt($("#industry_id").val());

		counterint++;
		counterstr = counterint.toString();

		htmlTemplate = htmlTemplate.replace(/XXX/g, counterstr);
		$("#admin_table tbody").append("<tr>"+htmlTemplate+"</tr>");		
		$("#industry_id").val(counterstr);
}	

/*Delete Question*/
$("#delete_industry").click(function(event){
	$('table#admin_table tr').each(function (i) {
		if ($(this).find('input.select_industry_id').is(':checked')) {
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
