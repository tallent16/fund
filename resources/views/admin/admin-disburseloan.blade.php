@extends('layouts.dashboard')
@section('page_heading',Lang::get('Manage Loans') )
@section('section')  
<form method="post" action="{{url('admin/savedisbursement')}}">
	<input type="hidden" id="loan_id" name="loan_id" value="{{$bidsModel->loan_id}}" />
	<input type="hidden" id="hidden_token" name="_token" value="{{ csrf_token() }}" />

<div class="col-sm-12 space-around">	
	<div class="panel-primary panel-container disburse-loan">
		
			<div class="panel-heading panel-headsection"><!--panel head-->
				<div class="row">
					<div class="col-sm-12">
						<span class="pull-left">{{ Lang::get('DISBURSE LOAN')}}</span> 
					</div>
				</div>					
			</div><!--panel head end-->

			<div class="panel-body applyloan table-border-custom input-space">	
				
				<div class="row"><!-- Row 1 -->					
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Loan Reference No')}}
						</label>
					</div>								
					<div class="col-xs-12 col-sm-7 col-lg-3">
						<input 	type="text" 
								class="form-control"
								name="loan_reference_number"
								id="loan_ref_num" 											
								value="{{$bidsModel->loan_reference_number}}" 
								disabled>	
					</div>	
				
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Disbursement Date') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-3 controls">
						<div class="input-group">
							<input 	id="disbursement_date" 
									type="text" 
									class="disbursement_date form-control" 
									name="disbursement_date"
									required
									value="{{$bidsModel->system_date}}" />

							<label for="disbursement_date" class="input-group-addon btn">
								<span class="glyphicon glyphicon-calendar"></span>
							</label>
						</div>
					</div>
					
				</div> <!-- Row 1 -->
				
				<div class="row"><!-- Row 2 -->	
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Sanctioned Amount') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-3">									
						<input 	type="text" 
								class="form-control text-right"
								name="loan_sanctioned_amount"
								id="loan_sanctioned_amount"
								value=
								"{{number_format($bidsModel->loan_sanctioned_amount, 2, '.', ',')}}"
								disabled>	
					</div>
			
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Fees Type Applicable') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-3">									
						<input 	type="text" 
								class="form-control text-right"
								name="fees_type_applicable"												
								id="fees_type_applicable" 											
								value="{{ Lang::get($bidsModel->codelist_value) }}"
								disabled>	
					</div>
					
				</div><!-- Row 2 -->
				
				<div class="row"><!-- Row 3-->			
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Processing Fee (%)') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-3">	
						<input 	type="text" 
								class="form-control text-right"
								name="loan_fees_percent"												
								id="loan_fees_percent" 											
								value="{{number_format($bidsModel->loan_fees_percent, 2, '.', ',')}}"
								disabled>	
					</div>
					
					<div class="col-xs-12 col-sm-5 col-lg-3">
							<label>{{ Lang::get('Fixed Fees') }}</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-3">									
						<input 	type="text" 
								class="form-control text-right"
								name="loan_fixed_fees"												
								id="loan_fixed_fees" 											
								value="{{number_format($bidsModel->loan_fixed_fees, 2, '.', ',')}}" 
								disabled>	
					</div>	
							
				</div><!-- Row 3 -->
				
				<div class="row"><!-- Row 4-->
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Total Processing Fees') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-3">									
						<input 	type="text" 
								class="form-control text-right"
								name="loan_process_fees"											
								id="loan_process_fees" 											
								value="{{number_format($bidsModel->loan_process_fees, 2, '.', ',')}}" 
								disabled>	
					</div>
								
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>
							{{ Lang::get('Amount Disbursed') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-3">									
						<input 	type="text" 
								class="form-control text-right"
								name="amount_disbursed"												
								id="amount_disbursed" 											
								value="{{number_format($bidsModel->amount_disbursed, 2, '.', ',')}}"
								disabled
								>	
					</div>

					
				</div>  <!-- Row 4 -->	
					
				<div class="row">  <!-- Row 5-->				
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label for="payment_ref">
							{{ Lang::get('Payment Reference') }}
						</label>
					</div>	

					<div class="col-xs-12 col-sm-7 col-lg-3">									
						<input 	type="text" 
								class="form-control"
								name="payment_ref"												
								id="payment_ref"
								required 											
								value="">	
					</div>

					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label>	
							{{ Lang::get('Remarks') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-3">									
						<textarea rows="3" class="form-control" 
								name="remarks" 
								id="remarks"></textarea>	
					</div>	
									
				</div>  <!-- Row 5 -->		

				<div class="row">		
					<div class="col-xs-12  col-sm-7 col-lg-3">
						<button type="button" class="btn verification-button" id="get_repay_schd">
							{{ Lang::get('Show Repayment Schedule')}}</button>
					</div>

					<div class="col-xs-12 col-sm-7 col-lg-3">
						<button type="submit" class="btn verification-button">
							{{ Lang::get('Disburse Loan')}}</button>
					</div>

					
					
				</div>
				
			</div><!----panel-body--->
	
	</div><!----panel-container--->
</div>
</form>

<div id="payschd_popup" title="Repayment Schedule" style="display:none" >
	

</div>
@endsection  

@section('bottomscripts')
<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>	 
<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>	
<script src="{{ url('js/moment.js') }}" type="text/javascript"></script>	
	

<script>		
var baseUrl	=	"{{url('')}}"

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

$("form").submit(function(event) {
	system_date = {{$bidsModel->system_date}};
	disburse_date = $("#disbursement_date").val();
	
	// Disbursement date cannot be a future date
	if (moment(system_date).isBefore(disburse_date)) {
		showDialog("", "{{Lang::get('Disbursement Date should not be a future date')}}");
		event.preventDefault();
	}
	
	$("form input[type=text]").each (function() {
		$(this).removeAttr("disabled")
	})
	
})

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
		var repaySchdTable	= 	"	<table> " +
								"		<tr>" +
								"			<th>Installment Number</th>" +
								"			<th>Schedule Payment Date</th>" +
								"			<th>Principal Amount</th>" +
								"			<th>Interest Amount</th>" +
								"			<th>Total Amount</th>" +
								"		</tr>";
										
		for (arrIndex = 0; arrIndex < data.length; arrIndex++) {
			repaySchdTable +=	"		<tr>"+
								"			<td>"+(arrIndex + 1)+"</td> " +
								"			<td>"+data[arrIndex]["payment_scheduled_date"]+"</td> " +
								"			<td>"+data[arrIndex]["principal_amount"]+"</td> " +
								"			<td>"+data[arrIndex]["interest_amount"]+"</td> " +
								"			<td>"+data[arrIndex]["payment_schedule_amount"]+"</td> " +
								"		</tr> "
								
			
		}
		
		$("#payschd_popup").html(repaySchdTable);
		$("#payschd_popup").dialog();
	});
	
	
})

</script>
@endsection

@stop
