$(document).ready(function (){  
	$("#select_all_list").click(function(){	 
		checkall_list(this,"select_businessorgtype_id");
	});	
		
	//~ $('#form-businessorgtype').on('submit', function(e) {
			//~ e.unbind().submit();
          //~ setTimeout(function() {
               //~ window.location.reload();
          //~ },0);
          //~ this.submit();
    //~ });	
});	

/*Add New Question*/
$("#new_businessorgtype").click(function(){
	addNewRow();
	 AutoNumber();
});
function addNewRow(){
		htmlTemplate = $("#businessOrgTypeTemplate").html();
		counterint = parseInt($("#business_org_type_id").val());

		counterint++;
		counterstr = counterint.toString();

		htmlTemplate = htmlTemplate.replace(/XXX/g, counterstr);
		$("#admin_table tbody").append("<tr>"+htmlTemplate+"</tr>");		
		$("#business_org_type_id").val(counterstr);
		$("#lending_allowed_"+counterstr).selectpicker("refresh");
}	

/*Delete Question*/
$("#delete_businessorgtype").click(function(){
	$('table#admin_table tr').each(function (i) {
		if ($(this).find('input.select_businessorgtype_id').is(':checked')) {
			$(this).closest('tr').remove();
		}
	});  
	 AutoNumber();     
});
function AutoNumber(){
	$('table#admin_table tr').each(function (i) {
		$(this).find('span.slno').text(i);
	});
}
$("#update_businessorgtype").click(function(){	
	$( "#update_businessorgtype" ).one( "click", function() { 
		$('#form-businessorgtype').submit();
	});
		
	 setTimeout(function(){
		  $('#form-businessorgtype').submit();
		},0);
	
 });
