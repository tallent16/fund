$(document).ready(function(){ 
	// date picker
	$('.disbursement_date').datetimepicker({
		autoclose: true, 
		minView: 2,
		format: 'dd-mm-yyyy' 
	}); 
	
   $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
	});

}); 

$("#get_repay_schd").on("click", function() {
		
	 $.ajax({
		type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
		url         : baseUrl+'/ajax/getloanrepayschd', // the url where we want to POST
		data        : {
							loan_id:$('#loan_id').val(),
							disburse_date:$('#disbursement_date').val()
						},
		dataType    : 'json'
	}) // using the done promise callback
	.done(function(data) {
		showRepaymentScheduleFunc(data);		
	});	
	
})
$(".repayment_schedule").on("click", function() {
		
	 $.ajax({
		type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
		url         : baseUrl+'/ajax/getinvestor_repayment', // the url where we want to POST
		data        : {
							loan_id:$(this).attr("data-loan-id"),
							investor_id:$(this).attr("data-investor-id"),
						},
		dataType    : 'json'
	}) // using the done promise callback
	.done(function(data) {
		showInvestorRepaymentFunc(data);		
	});	
	
})

function showRepaymentScheduleFunc(data) {
	var repaySchdTable	= 	"<div class='table-responsive'><table class='table'>" +										
							"	<thead>"+
							"		<tr>" +
							"			<th>Installment Number</th>" +
							"			<th>Schedule Payment Date</th>" +
							"			<th>Principal Amount</th>" +
							"			<th>Interest Amount</th>" +
							"			<th>Total Amount</th>" +
							"		</tr>"+
							"	</thead>"+
							"	<tbody>";	
	var datalength	= data.length;
											
	if(data.length > 0){									
		for (arrIndex = 0; arrIndex < data.length; arrIndex++) {
			origDate	=	data[arrIndex]["payment_scheduled_date"];
			newDate		=	origDate.substring(8,10) + "-" + 
							origDate.substring(5,7) + "-" + 
							origDate.substring(0,4);

			repaySchdTable +=	"		<tr>"+
								"			<td>"+(arrIndex + 1)+"</td> " +
								"			<td>"+newDate+"</td> " +
								"			<td>"+data[arrIndex]["principal_amount"]+"</td> " +
								"			<td>"+data[arrIndex]["interest_amount"]+"</td> " +
								"			<td>"+data[arrIndex]["payment_schedule_amount"]+"</td> " +
								"		</tr>";			
		}
	}
	else{
		repaySchdTable	=	repaySchdTable+"<tr><td colspan='5'> No Repayment Schedule Found</td></tr>";
	}
		repaySchdTable +=	"</tbody>"+
							"</table></div>";
							
		
		$("#payschd_popup .modal-body").html(repaySchdTable);
		$("#payschd_popup").modal("show");
	
}

function showInvestorRepaymentFunc(data) {
	var repaySchdTable	= 	"<div class='table-responsive'><table class='table'>" +										
							"	<thead>"+
							"		<tr>" +
							"			<th>Installment Number</th>" +
							"			<th>Schedule Payment Date</th>" +
							"			<th>Principal Amount</th>" +
							"			<th>Interest Amount</th>" +
							"			<th>Status</th>" +
							"			<th>Total Amount</th>" +
							"		</tr>"+
							"	</thead>"+
							"	<tbody>";	
	var datalength	= data.length;
											
	if(data.length > 0){									
		for (arrIndex = 0; arrIndex < data.length; arrIndex++) {
			origDate	=	data[arrIndex]["payment_scheduled_date"];
			newDate		=	origDate.substring(8,10) + "-" + 
							origDate.substring(5,7) + "-" + 
							origDate.substring(0,4);

			repaySchdTable +=	"		<tr>"+
								"			<td>"+data[arrIndex]["installment_number"]+"</td> " +
								"			<td>"+newDate+"</td> " +
								"			<td>"+data[arrIndex]["principal_amount"]+"</td> " +
								"			<td>"+data[arrIndex]["interest_amount"]+"</td> " +
								"			<td>"+data[arrIndex]["statusText"]+"</td> " +
								"			<td>"+data[arrIndex]["payment_schedule_amount"]+"</td> " +
								"		</tr>";			
		}
	}
	repaySchdTable +=	"</tbody>"+
							"</table></div>";
							
		
		$("#payschd_popup .modal-body").html(repaySchdTable);
		$("#payschd_popup").modal("show");
	
}
