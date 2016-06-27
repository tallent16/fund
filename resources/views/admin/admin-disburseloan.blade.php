@extends('layouts.dashboard')
@section('page_heading',Lang::get('Manage Loans') )
@section('section')  

@if( ($bidsModel->loan_status	==	LOAN_STATUS_DISBURSED) || ($bidsModel->loan_status	==	LOAN_STATUS_LOAN_REPAID))
	@var	$disableFields			=	"disabled"
	@var	$dispTitle				=	Lang::get("Loan Details")
	@var 	$canViewInvestorList	=	true
	@var	$actionUrl				=	url('admin/saveResched')
	
@else
	@var	$dispTitle				=	Lang::get("Loan Disbursal")
	@var	$disableFields			=	""
	@var 	$canViewInvestorList	=	false
	@var	$actionUrl				=	url('admin/savedisbursement')
@endif
					
					
<form 	id="disbForm"
		method="post" 
		action="{{$actionUrl}}">
<input type="hidden" id="loan_id" name="loan_id" value="{{$bidsModel->loan_id}}" />
<input type="hidden" id="hidden_token" name="_token" value="{{ csrf_token() }}" />
<div class="col-sm-12 space-around">	
	<div class="col-lg-12 col-md-6 col-xs-12">
		<!-----Tab Starts----->
		<ul class="nav nav-tabs">
			<li class="active" id="loan_details_parent" >
				<a 	data-toggle="tab" 
					href="#loan_detail_main">
					{{$dispTitle}}
				</a>
			</li>
			<li  id="borr_repay_schd_parent" >
				<a 	data-toggle="tab" 
					href="#borr_repay_schd">
					{{ Lang::get('Borrower Repayment Schedule')}}
				</a>
			</li>
			
			<li  id="inv_repay_schd_parent" >
				<a 	data-toggle="tab" 
					href="#inv_repay_schd">
					{{ Lang::get('Investor Repayment Schedule')}}
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<!-----First Tab content Starts----->
				@include('widgets.admin.tab.loandisb_loandetails')
			<!-----First Tab content end----->
			
			<!-----Second Tab content Starts----->
				@include('widgets.admin.tab.loandisb_borr_repayschd')
			<!-----First Tab content end----->
			
			<!-----Third Tab content Starts----->
				@include('widgets.admin.tab.loandisb_inv_repayschd')
			<!-----First Tab content end----->
			
		</div> <!-- Tab Contents end -->
		
		<div class="row">	
			<div class="col-xs-12 col-sm-7 col-lg-12 space-around">	
				@if($bidsModel->loan_status	==	LOAN_STATUS_BIDS_ACCEPTED)
					@permission('disburse.admin.disburseloan')				
						<button type="submit" class="btn verification-button" id="disbLoan">
							{{ Lang::get("Disburse Loan") }}</button>
								
						<button type="cancel" class="btn verification-button cancel" id="regenSchd" style="display:none" 
								onclick="recalcRepay()">
								{{ Lang::get("Generate Repay Schedule") }}</button>
					@endpermission
				@endif
				@if ($bidsModel->loan_status == LOAN_STATUS_DISBURSED) 
					@permission('admin.reschedule.loans')
						<button  type="cancel" class="btn verification-button" id="reschdLoan" onclick="reschdLoan()"
								onclick="reschdInsts()">
								{{Lang::get("Reschedule Repayment")}}</button>
					
						<button type="submit" class="btn verification-button cancel" id="saveReschd" style="display:none">
								{{ Lang::get("Save Rescheduled Loan")}}</button>
					@endpermission
				@endif
			</div>					
		</div>
			
	</div><!----panel-container--->
</div>
</form>

@endsection  
@section('bottomscripts')
<script src="{{ asset('assets/scripts/frontend.js') }}" type="text/javascript"></script>	 
<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>	
<script src="{{ url('js/moment.js') }}" type="text/javascript"></script>	
<script>		
var baseUrl	=	"{{url('')}}"




@if($bidsModel->loan_status	==	LOAN_STATUS_BIDS_ACCEPTED)
	submitForm	=	true;
@else 
	submitForm	=	false;
@endif

function reschdLoan() {
	$("reschdLoan").hide();
	$("saveReschd").show();
}


function haveToRecalc() {
	
	// The user has changed the disbursement date details. Don't allow him to disburse the loan
	// till he recalculates the schedule
	$("#disbLoan").hide();
	$("#regenSchd").show();
	$("#payment_ref").removeAttr("required");	
	submitForm = false;
	
}
$("form").submit(function(event) {
	system_date = "{{$bidsModel->system_date}}";
	disburse_date = $("#disbursement_date").val();
	
	if (!submitForm) {
		event.preventDefault();
		return
	}
	
	// Disbursement date cannot be a future date
	if (moment(system_date).isBefore(disburse_date)) {
		showDialog("", "{{Lang::get('Disbursement Date should not be a future date')}}");
		event.preventDefault();
	}
	
	$("form input[type=text]").each (function() {
		$(this).removeAttr("disabled");
	})	
})

disbColTitles	=	['{{Lang::get("Inst Number")}}', '{{Lang::get("Schd Date")}}', '{{Lang::get("Actual Date")}}',
					   '{{Lang::get("Principal")}}', '{{Lang::get("Interest")}}', '{{Lang::get("Penalty Fees")}}', 
					   '{{Lang::get("Penalty Int")}}', '{{Lang::get("Total")}}', '{{Lang::get("Status")}}'];
						
accColTitles	=	['{{Lang::get("Inst Number")}}', '{{Lang::get("Schd Date")}}', '{{Lang::get("Principal")}}', 
						'{{Lang::get("Interest")}}', '{{Lang::get("Total")}}'];
						
disbColNames		=	['inst_number', 'payment_schedule_date', 'repayment_actual_date', 
						'principal_component', 'interest_component', 'repayment_penalty_charges',
						'repayment_penalty_interest', 'total', 'repayment_status']

accColNames		=	['inst_number', 'payment_scheduled_date', 'principal_amount', 'interest_amount', 
						'payment_schedule_amount']	
						
						

disbColTypes	=	["text", "text", "text", "decimal", "decimal", "decimal", "decimal", "decimal", "text"]
accColTypes		=	["text", "text", "decimal", "decimal", "decimal"]


invRepaySchd	=	{{$bidsModel->jsonInvRepay}}

function createTableHeader(userType) {
	@if($bidsModel->loan_status	==	LOAN_STATUS_BIDS_ACCEPTED)
		colTitles	=	accColTitles
		colTypes	=	accColTypes
	@else 
		colTitles	=	disbColTitles
		colTypes	=	disbColTypes
	@endif
	
	if (userType == 'borrower') 
		tableId = '#bidsummary'
	else
		tableId = '#invInst'
	
	// To create the header row for the Payment Schedule when status is Disbursed or Repaid
	headHtml = "";
	for (ind = 0;ind < colTitles.length; ind++) {
		if (userType != 'borrower' && ind == 5) 
			continue;
			
		if (colTypes[ind] == "text")
			textAlign	=	"text-left"
		else
			textAlign	=	"text-right"
			
		headHtml += '<th class="tab-head col-sm-1 ' + textAlign + '">' + colTitles[ind] + '</th>';
	}
	headHtml = "<tr>"+ headHtml + "</tr>"
	$(tableId).append(headHtml);
	
}


function createTableRows(userType, rowData) {
	@if($bidsModel->loan_status	==	LOAN_STATUS_BIDS_ACCEPTED)
		colNames	=	accColNames
		colTypes	=	accColTypes
	@else 
		colNames	=	disbColNames
		colTypes	=	disbColTypes
	@endif
	
	if (userType == 'borrower') 
		tableId = '#bidsummary'
	else
		tableId = '#invInst'
		
	rowHtml = ""
	for (ind=0; ind < colNames.length; ind++) {
		if (userType != 'borrower' && ind == 5) 
			continue;
			
		if (colTypes[ind] == "text")
			textAlign	=	"text-left"
		else
			textAlign	=	"text-right"
		rowHtml += 	'<td class="' + textAlign + '"> ' + rowData[colNames[ind]] + '</td>';
		
	}
	rowHtml = "<tr>" + rowHtml + "</tr>"
	$(tableId).append(rowHtml);

}

function recalcRepay() {
	// First remove the rows from the HTML Table
	
	
	loanId		=	$("#loan_id").val();
	disbDate 	=	$("#disbursement_date").val();
	payByDay	=	$("#monthly_pay_by_date").val();
	
	// Make the ajax call to get the recalculated rows
	$.ajax({
	  type: "GET",
	  cache:false,
	  dataType: "json",
	  url: baseUrl+"/ajax/getloanrepayschd?loan_id="+loanId+"&disburse_date=" + 
						disbDate + "&monthly_pay_by_date=" + payByDay,
	}).done(function(data) {
		$('#bidsummary tr:not(:first)').remove();
		invRepaySchd 	= data['invSchd']
		borrRepaySchd 	= data['borrSchd']
		numofInst		= borrRepaySchd.length
		
		for (borrInd = 0; borrInd < numofInst; borrInd ++) {
			rowData = borrRepaySchd[borrInd];
			rowData['inst_number'] = borrInd+1;
			createTableRows('borrower', rowData);
			
		}
		
		// The user has changed the disbursement date details and has asked for recalculation
		// of the repayment schedule
		// After the repayment schedule is recalculated, show the disburse loan button 
		$("#regenSchd").hide();
		$("#disbLoan").show();
		$("#payment_ref").attr("required", true);
		submitForm = true;
		
	});
}

function showInvInst(invId) {
	// First remove the rows from the HTML Table
	$('#invInst tr').remove();
	
	createTableHeader('investor');
	invInstData	=	invRepaySchd[invId];
	invInstLen	=	invInstData.length
	
	for (invInd = 0; invInd < invInstLen; invInd++) {
		rowData	=	invInstData[invInd]
		rowData['inst_number'] = invInd+1;
		createTableRows('investor', rowData);
	}
	
}

function reschdInsts() {
	// To build the table rows
	@if ($bidsModel->loan_status == LOAN_STATUS_DISBURSED)
		borrJson	=	{{$bidsModel->jsonBorrRepay}}
		invJson		=	{{$bidsModel->jsonInvRepay}}
	@endif
	$('#bidsummary tr:not(:first)').remove();
	<?php	$index = 0 ?>
	@foreach($bidsModel->loanInvestors as $loanbidRow)
		invInfo[{{$index}}] = {'inv_id': '{{$loanbidRow->investor_id}}',
					 'inv_name':'{{$loanbidRow->username}}' }
		<?php $index++ ?>
	@endforeach
}

$(document).ready(function () {

	createTableHeader('borrower');
	@foreach($bidsModel->repayment_schedule as $key => $repaySchd)

		@if($bidsModel->loan_status	==	LOAN_STATUS_BIDS_ACCEPTED)
			rowData	=	{'inst_number': '{{$key + 1}}',
						 'payment_scheduled_date': '{{$repaySchd["payment_scheduled_date"]}}', 
						 'principal_amount': '{{$repaySchd["principal_amount"]}}', 
						 'interest_amount': '{{$repaySchd["interest_amount"]}}', 
						 'payment_schedule_amount': '{{$repaySchd["payment_schedule_amount"]}}'}
		@else

			rowData	=	{'inst_number': '{{$key + 1}}', 
						 'payment_schedule_date': '{{$repaySchd["repayment_schedule_date"]}}',
						 'repayment_actual_date': '{{$repaySchd["repayment_actual_date"]}}', 
						 'principal_component': '{{$repaySchd["principal_component"]}}',
						 'interest_component': '{{$repaySchd["interest_component"]}}',
						 'repayment_penalty_charges': '{{$repaySchd["repayment_penalty_charges"]}}',
						 'repayment_penalty_interest': '{{$repaySchd["repayment_penalty_interest"]}}', 
						 'total': '{{$repaySchd["total"]}}', 
						 'repayment_status': '{{$repaySchd["repayment_status"]}}'}
		@endif

		createTableRows('borrower', rowData);
	@endforeach	
})

</script>
<script src="{{ url('js/admin-disburseloan.js') }}" type="text/javascript"></script>
@endsection
@stop
