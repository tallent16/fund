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
});
