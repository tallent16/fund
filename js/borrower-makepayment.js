$(document).ready(function (){ 
	// date picker
	$('#schduledate').datetimepicker({
		autoclose: true,
		minView: 2,
		format: 'dd/mm/yyyy'
	});   
	$('#actualdate').datetimepicker({
		autoclose: true,
		minView: 2,
		format: 'dd/mm/yyyy'
	});   
	$("#save_form_payment").submit(function() {
		$("input").removeAttr("disabled");
	});
});
