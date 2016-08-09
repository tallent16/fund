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
<div class="space-around">	
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
						<button  type="cancel" class="btn verification-button" id="reschdLoan" onclick="reschdInsts(0)">
								{{Lang::get("Reschedule Repayment")}}</button>
					
						<button type="submit" class="btn verification-button" id="saveReschd" onclick="saveResc(0)"
						style="display:none">
								{{ Lang::get("Save Rescheduled Loan")}}</button>
					@endpermission
				@endif
			</div>					
		</div>
			
	</div><!----panel-container--->
</div>
</form>

<div id="dummyDiv" style="display:none">
	<table id="borrEditSchd">
		<tr id="borrRow_XXX">
			<td>
				<input id="inst_number" 
					type="hidden" 
					style="width:50px;text-align:right;" 
					value="xxx_inst_number" 
					disabled 
					readonly
					class="form-control "> 
					xxx_inst_number
			</td>
			<td>
				<input id="orig_date" 
					type="text" 
					style="width:99px;text-align:left;" 
					value="xxx_repayment_schedule_date" 
					disabled 
					readonly
					class="form-control  date-field"> 
			</td>
			<td>
				<div class="controls">
					<div class="input-group" style="width:138px;">
						<input id="repayment_schedule_date_XXX" 
							type="text" 
							style="text-align:left;" 
							name="borrSchd[_XXX][repayment_schedule_date]" 
							value="xxx_repayment_schedule_date"
							disabled 
							class="form-control date-field edit_toggle_XXX"> 
							
						<label for="repayment_schedule_date_XXX" class="input-group-addon btn">
							<span class="glyphicon glyphicon-calendar"></span>
						</label>
					</div>
				</div>
			</td>

			<td>
				<input id="principal_component_XXX" 
					type="text" 
					style="width:109px; text-align:right;" 
					name="borrSchd[_XXX][principal_component]" 
					readonly
					value="xxx_principal_component" 
					disabled 
					class="form-control borr_prin_amt "> 
			</td>
			<td>
				<input id="interest_component_XXX" 
					type="text" 
					style="width:97px; text-align:right;" 
					name="borrSchd[_XXX][interest_component]" 
					value="xxx_interest_component" 
					readonly
					disabled 
					class="form-control borr_int_amt"> 
			</td>
			
			<td>
				<input id="penalty_fee_XXX" 
					type="text" 
					style="width:87px; text-align:right;" 
					name="borrSchd[_XXX][penalty_fee]" 					
					value="xxx_repayment_penalty_charges" 
					onchange="computeBorrTotal(_XXX)"
					decimal="2"					
					disabled 
					class="form-control edit_toggle_XXX borr_penalty_fee"> 
			</td>
			<td>
				<input id="penalty_interest_XXX" 
					type="text" 
					style="width:87px; text-align:right;" 
					name="borrSchd[_XXX][penalty_interest]" 
					value="xxx_repayment_penalty_interest" 
					disabled 
					class="form-control borr_penalty_interest"> 
			</td>
			<td>
				<input id="total_XXX" 
					type="text" 
					style="width:109px; text-align:right;" 
					name="borrSchd[_XXX][total]" 
					value="xxx_total" 
					readonly
					disabled 
					class="form-control borr_total"> 
			</td>
			<td>
				<input id="status_XXX" 
					type="hidden" 
					style="width:125px; text-align:left;" 
					value="xxx_repayment_status" 
					disabled 
					readonly
					class="form-control "> 					
			xxx_repayment_status
			</td>
			<td>
				<i id="fa_edit_XXX" class="fa fa-edit" onclick="editInst(_XXX)" )=""></i>
			</td>
		</tr>
	
	</table>
	
	<table id="borrEditSchdTotal">
		<tr id="borrRow_XXX">
			<td colspan=3 >
				<span style="text-align:right">
				Total
				</span>
			</td>

			<td>
				<input id="total_prinamt"
					type="text" 
					style="width:109px; text-align:right;" 
					name="total_prinamt"
					readonly
					value="" 
					disabled 
					class="form-control "> 
			</td>
			<td>
				<input id="total_intamt" 
					type="text" 
					style="width:97px; text-align:right;" 
					name="total_intamt"
					value="" 
					readonly
					disabled 
					class="form-control "> 
			</td>
			
			<td>
				<input id="total_penfee" 
					type="text" 
					style="width:87px; text-align:right;" 
					name="total_penfee"
					value="" 
					decimal="2"
					disabled 
					class="form-control "> 
			</td>
			<td>
				<input id="total_penint" 
					type="text" 
					style="width:87px; text-align:right;" 
					name="total_penint"
					value="" 
					readonly
					disabled 
					class="form-control "> 
			</td>
			<td>
				<input id="total_repayment" 
					type="text" 
					style="width:109px; text-align:right;" 
					name="total_repayment"
					value="" 
					readonly
					disabled 
					class="form-control"> 
			</td>
			
		</tr>
	
	</table>
	
	<table id="invEditSchd">
		<tr id="invRow_XXX" class="invRow_XXX" style="display:none">
			<td>&nbsp;</td>
			<td colspan="2">
				<input id="investor_name_XXX_xxx_invId" 
					type="text" style=" text-align:left;" 
					value="xxx_invName" 
					readonly 
					class="form-control ">
			</td>

			
			<td>
				<input id="principal_component_XXX_xxx_invId" 
					type="text" 
					style=" text-align:right;" 
					name="invSchd[xxx_invId][_XXX][principal_component]" 
					onchange="computeInvTotal(_XXX, xxx_invId)"
					decimal="2"
					value="xxx_principal_component" 
					class="form-control ">
			</td>
			
			<td>
				<input id="interest_component_XXX_xxx_invId" 
					type="text" 
					style=" text-align:right;" 
					name="invSchd[xxx_invId][_XXX][interest_component]" 
					onchange="computeInvTotal(_XXX, xxx_invId)"
					decimal="2"
					value="xxx_interest_component" 
					class="form-control ">
			</td>
			
			
			<td>&nbsp;</td>
			<td>
				<input id="penalty_interest_XXX_xxx_invId" 
					type="text" style=" 
					text-align:right;" 
					name="invSchd[xxx_invId][_XXX][penalty_interest]" 
					onchange="computeInvTotal(_XXX, xxx_invId)"
					decimal="2"
					value="xxx_repayment_penalty_interest" 
					class="form-control ">
			</td>
			
			<td>
				<input id="total_XXX_xxx_invId" 
					type="text" 
					style=" text-align:right;" 
					name="invSchd[xxx_invId][_XXX][total]"
					value="xxx_total" 
					readonly
					class="form-control ">
			</td>
		</tr>
	</table>
	<table id="borrDisbSchd">
		<tr>
			<td class="text-left"> xxx_inst_number</td>
			<td class="text-left"> xxx_payment_schedule_date</td>
			<td class="text-left"> xxx_repayment_actual_date</td>
			<td class="text-right"> xxx_principal_component</td>
			<td class="text-right"> xxx_interest_component</td>
			<td class="text-right"> xxx_repayment_penalty_charges</td>
			<td class="text-right"> xxx_repayment_penalty_interest</td>
			<td class="text-right"> xxx_total</td>
			<td class="text-left"> xxx_repayment_status</td>
			<td class="text-left"> </td>
			
		</tr>
	
	</table> 
	<table id="invDisbSchd">
		<tr>
			<td class="text-left"> xxx_inst_number</td>
			<td class="text-left"> xxx_payment_schedule_date</td>
			<td class="text-left"> xxx_repayment_actual_date</td>
			<td class="text-right"> xxx_principal_component</td>
			<td class="text-right"> xxx_interest_component</td>
			<td class="text-right"> xxx_repayment_penalty_interest</td>
			<td class="text-right"> xxx_total</td>
			<td class="text-left"> xxx_repayment_status</td>
			<td class="text-left"> </td>
		</tr>
	
	</table>
	<table id="AccSchd">
		<tr>
			<td class="text-left"> xxx_inst_number</td>
			<td class="text-left"> xxx_payment_scheduled_date</td>
			<td class="text-right"> xxx_principal_amount</td>
			<td class="text-right"> xxx_interest_amount</td>
			<td class="text-right"> xxx_payment_schedule_amount</td>
		</tr>
	</table>
	
</div>
@endsection  
@section('bottomscripts')
<script src="{{ asset('assets/scripts/frontend.js') }}" type="text/javascript"></script>	 
<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>	
<script src="{{ url('js/moment.js') }}" type="text/javascript"></script>	
<script src="{{ url('js/numeral.min.js') }}" type="text/javascript"></script>	

<script>		
var baseUrl	=	"{{url('')}}"


<?php	$index = 0 ?>
invInfo	=	[]
@foreach($bidsModel->loanInvestors as $loanbidRow)
	invInfo[{{$index}}] = {"inv_id": "{{$loanbidRow->investor_id}}",
				 "inv_name":"{{$loanbidRow->username}}" }
	<?php $index++ ?>
@endforeach

@if($bidsModel->loan_status	==	LOAN_STATUS_BIDS_ACCEPTED)
	submitForm	=	true;
@else 
	submitForm	=	false;
@endif

invRepaySchd	=	{{$bidsModel->jsonInvRepay}}
reschdEdited	=	false; // To ensure that the user is not trying to save the Rescheduled loan without any changes

$("form").submit(function(event) {
	// To do validations before the submit happens
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

$(document).ready(function () {
	
	@foreach($bidsModel->repayment_schedule as $key => $repaySchd)
		// The display fields for the Repayment schedules are different 
		// when the status is accepted / disbursed. When accepted, the actual date and penalty
		// columns are not shown.
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


function haveToRecalc() {
	
	// The user has changed the disbursement date details. Don't allow him to disburse the loan
	// till he recalculates the schedule
	$("#disbLoan").hide();
	$("#regenSchd").show();
	$("#payment_ref").removeAttr("required");	
	submitForm = false;
	
}

function createTableRows(userType, rowData) {
	// Common function for loading the table data for the Borrower & Investor repayment schedules
	// called at the time of loading the page (for borrowers), when the user clicks on show investor 
	// schedules and when the user clicks on Recalculate repayment schedule
	@if($bidsModel->loan_status	==	LOAN_STATUS_BIDS_ACCEPTED)
		sourceTable		=	'#AccSchd tbody'
	@else 
		if (userType == 'borrower') 
			sourceTable =  '#borrDisbSchd tbody'
		else
			sourceTable =  '#invDisbSchd tbody'
	@endif
	
	if (userType == 'borrower') 
		targetTable = '#bidsummary'
	else
		targetTable = '#invInst'
		
	rowHtml = $(sourceTable).html();

	
	$.each (rowData, function (key, value) {
		rE	=	new RegExp("xxx_" + key, "g")
		
		rowHtml = rowHtml.replace(rE, value);
	})
	
	$(targetTable).append(rowHtml);
}

function recalcRepay() {
	// The user has changed the disbursement date or the pay-by date
	// and has to recalculate the repayment
	
	// First remove the rows from the HTML Table
	$('#bidsummary tr:not(:first)').remove();

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
		invRepaySchd 	= data['invSchd']
		borrRepaySchd 	= data['borrSchd']
		numofInst		= borrRepaySchd.length
		
		for (borrInd = 0; borrInd < numofInst; borrInd ++) {
			rowData = borrRepaySchd[borrInd];
			rowData['inst_number'] = borrInd+1;
			createTableRows('borrower', rowData);
			
		}
		
		// Hide the Regenerate payment schdule button
		$("#regenSchd").hide();
		
		// show the Disburse loan button
		$("#disbLoan").show();
		$("#payment_ref").attr("required", true);
		submitForm = true;
		
	});
}

function showInvInst(invId) {
	// When the user clicks on the show repayment schedule button
	// First remove the rows from the HTML Table
	$('#invInst tr:not(:first)').remove();
	
	invInstData	=	invRepaySchd[invId];
	invInstLen	=	invInstData.length
	
	for (invInd = 0; invInd < invInstLen; invInd++) {
		rowData	=	invInstData[invInd]
		rowData['inst_number'] = invInd+1;
		createTableRows('investor', rowData);
	}
	
}

function reschdInsts(callback_response) {
	$("#bidsummary").removeClass('table-striped table-bordered');
	// When the user clicks on the "Reschedule Loan" button
	// Before we reschedule the loan, we need to ask for a confirmation/
	// Since jQuery execution doesn't wait while the modal window is being shown
	// we need to manually control the execution flow
	
	// The default action of the button means that if the user presses [enter] in any of the fields, then this funciton is called
	// To prevent this, check if the button is hidden and if hidden then don't execute any further
	if (!$("#reschdLoan").is(":visible")) 
		return;

	canContinue = false;
	
	switch (callback_response) {
		
		case -1:
			// The response from the modal dialog box for cancelling the operation
			return;
			break;
			
		case 0:
			// The initial call from the button. Just show the dialog and return
			showDialogWithOkCancel("FYN", "{{$bidsModel->systemAllMessage[4]['loan_resched_confirm']}}", "reschdInsts");
			return;
			break;
			
		case 1:
			// the response from the modal dialog box to go ahead with the reschedule
			canContinue = true;
			
	}
	
	if (!canContinue) 
		return;
			
	// To build the table rows
	@if ($bidsModel->loan_status == LOAN_STATUS_DISBURSED)
		borrJson	=	{{$bidsModel->jsonBorrRepay}}
		invJson		=	{{$bidsModel->jsonInvRepay}}
	@endif
	$('#bidsummary tr:not(:first)').remove();
	
	for (browIndex=0; browIndex < borrJson.length; browIndex ++) {
		borrRowData	=	borrJson[browIndex]
		borrRowData['inst_number'] = browIndex+1
		instNumber	=	browIndex + 1

		rowHtml	=	$("#borrEditSchd tbody").html()
		
		$.each(borrRowData, function (key, value) {
			rE	=	new RegExp("xxx_" + key, "g")
			rowHtml	=	rowHtml.replace(rE, value)
		})
		
		rowHtml = rowHtml.replace(/_XXX/g, instNumber)
		
		$("#bidsummary").append(rowHtml);
		statusId	=	"#status"+instNumber
		
		paidStatus	=	$(statusId).val()
		if (paidStatus != 'Unpaid') {
			$("#fa_edit"+instNumber).remove();
		}
		
		$('#repayment_schedule_date'+instNumber).datetimepicker({
			autoclose: true, 
			minView: 2,
			format: 'dd-mm-yyyy' 
		}); 
		
		for (invIndex = 0; invIndex < invInfo.length; invIndex++) {
			invId	=	invInfo[invIndex]['inv_id'];
			invName	=	invInfo[invIndex]['inv_name']
			invRowData	=	invJson[invId][browIndex]
			invRowData['Invname'] = invName
			
			rowHtml = $("#invEditSchd tbody").html()
			
			$.each(invRowData, function (key, value) {
				rE	=	new RegExp("xxx_" + key, "g")				
				rowHtml = rowHtml.replace(rE, value)
			})
			
			rowHtml = rowHtml.replace(/_XXX/g, instNumber)
			rE	=	new RegExp("xxx_invId", "g")
			rowHtml = rowHtml.replace(rE, invId);
			
			rE	=	new RegExp("xxx_invName", "g")
			rowHtml = rowHtml.replace(rE, invName);
			
			$("#bidsummary").append(rowHtml);
		}
	}
	
	rowHtml	=	$("#borrEditSchdTotal tbody").html()
	
	$("#inv_repay_schd_parent").hide()
	$("#inv_repay_schd").hide()
	
	$("#label_remarks").text("{{Lang::get('Notes for Reschedule')}}")
	$("#remarks").attr("name", "reschd_notes");
	$("#remarks").attr("required", true);
	$("#remarks").attr("disabled", false);

	$("#reschd_date_label").show();
	$("#reschd_date_div").show();
	$("#reschd_date").attr("required", true);
	$("#reschdLoan").hide()
	$("#saveReschd").show()
	
	$("#bidsummary").append(rowHtml);
	$('#reschd_date').datetimepicker({
		autoclose: true, 
		minView: 2,
		format: 'dd-mm-yyyy' 
	}); 
	// initiateDateFieldFunc();
	computeGrandTotal();
	
}



function editInst(instNumber) {
	$("#bidsummary").removeClass('table-striped table-bordered');
	$(".edit_toggle"+instNumber).each (function () {
		$(this).removeAttr("disabled")
	})

	invRowClass = ".invRow" + instNumber
	$(invRowClass).show();
	 
	
	$("input[decimal]").each(function() {
		
		$(this).on("focus", function () {
			onFocusNumberField(this)
		})
		$(this).on("blur", function () {
			onBlurNumberField(this)
		})
	})
	
	submitForm = false;
	reschdEdited = true;
}

function saveResc(callback_response) {
	if (!reschdEdited) {
		showDialog("FYN", "{{$bidsModel->systemAllMessage[4]['loan_resched_nothing_to_save']}}")
		return;
	}
	switch (callback_response) {
		case -1:
			return;
			break;
			
		case 0:
			loanAmt	=	{{$bidsModel->loan_sanctioned_amount}}
			totPrin =	numeral($("#total_prinamt").val())
			
			if (totPrin > loanAmt) {
				showDialog("FYN", "{{$bidsModel->systemAllMessage[4]['loan_reschd_entry_error']}}")
				return
			}
			
		
			if (totPrin < loanAmt) {
				showDialogWithOkCancel("FYN", "{{$bidsModel->systemAllMessage[4]['loan_resched_confirm_writeoff']}}", "saveReschd");
				return;
			}
			break;
			
	}
	submitForm	=	true
	$("form").submit();
	
	
}

function computeInvTotal(instNumb, invId) {
	
	// Compute the total that has been entered for each of the investor and post it to the Main Repayment Installment
	objId	=	"#principal_component" + instNumb +"_" +  invId
	obj		=	$(objId);
	val		=	$(objId).val();
	intAmt = numeral($("#interest_component" + instNumb + "_" + invId).val())
	prinAmt = numeral($(objId).val())
	penAmt = numeral($("#penalty_interest" + instNumb +"_" +  invId).val())
	
	total = intAmt + prinAmt + penAmt
	$("#total" + instNumb + "_" + invId).val(numeral(total).format("0,000.00"))
	instPrinAmt = 0; // Principal Amt for this installment
	instIntAmt	= 0; // Interest Amt for this installment
	instPenInt	= 0; // Penalty Interest for this installment (in case of late payment)
	instPenFee	= 0; // Penalty Fees for this installment (in case of late payment)
	
	
	for (invIndex = 0; invIndex < invInfo.length; invIndex++) {
		invId	=	invInfo[invIndex]['inv_id'];
		invPrinAmt = $("#principal_component" + instNumb + "_" +  invId).val();
		invIntAmt = $("#interest_component" + instNumb + "_" + invId).val();
		invPenInt = $("#penalty_interest" + instNumb + "_" + invId).val();
		
		instPrinAmt += numeral(invPrinAmt);
		instIntAmt += numeral(invIntAmt);
		instPenInt += numeral(invPenInt);
	}
	
	
	instTotal = instPrinAmt + instIntAmt + instPenInt + instPenFee
	$("#total" + instNumb).val(numeral(instTotal).format("0,000.00"))
	$("#principal_component" + instNumb).val(numeral(instPrinAmt).format("0,000.00"))
	$("#penalty_interest" + instNumb).val(numeral(instPenInt).format("0,000.00"))
	$("#interest_component" + instNumb).val(numeral(instIntAmt).format("0,000.00"))
	$("#penalty_interest" + instNumb).val(numeral(instPenInt).format("0,000.00"))
	computeBorrTotal(instNumb);
	
}

function computeBorrTotal(instNumb) {
	borrPrin	=	numeral($("#principal_component"+instNumb).val())
	borrInst	=	numeral($("#interest_component"+instNumb).val())
	borrPenFee	=	numeral($("#penalty_fee"+instNumb).val())
	borrPenInt	=	numeral($("#penalty_interest"+instNumb).val())
	
	instTotal	=	borrPrin + borrInst + borrPenFee + borrPenInt;
	$("#total"+instNumb).val(numeral(instTotal).format("0,000.00"))
	computeGrandTotal();
}

function computeGrandTotal() {
	totalPrin	=	0;
	totalInt	=	0;
	totalPenInt	=	0;
	totalPenFee	=	0;
	totalRepay	=	0;
	
	$(".borr_prin_amt").each (function () {
		totalPrin += numeral($(this).val())
	})

	$(".borr_int_amt").each (function () {
		totalInt += numeral($(this).val())
	})
	
	$(".borr_penalty_interest").each (function () {
		totalPenInt += numeral($(this).val())
	})

	$(".borr_penalty_fee").each (function () {
		totalPenFee += numeral($(this).val())
	})

	$(".borr_total").each (function () {
		totalRepay += numeral($(this).val())
	})
	
	$("#total_prinamt").val(numeral(totalPrin).format("0,000.00"));
	$("#total_intamt").val(numeral(totalInt).format("0,000.00"));
	$("#total_penint").val(numeral(totalPenInt).format("0,000.00"));
	$("#total_penfee").val(numeral(totalPenFee).format("0,000.00"));
	$("#total_repayment").val(numeral(totalRepay).format("0,000.00"));
	
	
}

</script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="{{ url('js/admin-disburseloan.js') }}" type="text/javascript"></script>

@endsection
@stop
