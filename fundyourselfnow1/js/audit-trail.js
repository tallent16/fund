$(document).ready(function(){ 	
	
	// date picker
	$('#fromdate').datetimepicker({
	autoclose: true, 
	minView: 2,
	format: 'dd/mm/yyyy' 
	}); 
	
	$('#todate').datetimepicker({
	autoclose: true, 
	minView: 2,
	format: 'dd/mm/yyyy' 
	});         
		
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
	});	
		
	$("#modulelist").change(function() {					
		$.ajax({
			type: "POST",
			url: baseUrl+"/admin/audit_trial/optionfilter",
			data: {module_list: $(this).find(":selected").text()},			                  
			dataType    : 'json'
		})
		.done(function(data) {										
			showdropdown(data);
		});
	});
	$("#modulelist").trigger("change");
}); 	

function showdropdown(data){	
	var	str = 	"";	
	$('#action_list option').remove();
	$.each(data.rows, function(value, key){
		$('#action_list').append("<option value='"+value.toString()+"' >"+key+"</option>");	
	});	
	$("#action_list").val("{{$adminAuditTrailMod->actionListValue}}");
	$('#action_list').selectpicker("refresh");
}
