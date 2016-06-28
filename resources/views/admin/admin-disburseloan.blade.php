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
						<button  type="cancel" class="btn verification-button" id="reschdLoan" onclick="reschdInsts()">
								{{Lang::get("Reschedule Repayment")}}</button>
					
						<button type="submit" class="btn verification-button" id="saveReschd" onclick="saveReschd()"
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
					type="text" 
					style="width:60px; text-align:right;" 
					value="xxx_inst_number" 
					disabled 
					readonly
					class="form-control "> 
			</td>
			<td>
				<input id="orig_date" 
					type="text" 
					style="width:100px; text-align:left;" 
					value="xxx_repayment_schedule_date" 
					disabled 
					readonly
					class="form-control  date-field"> 
			</td>
			<td>
				<input id="repayment_schedule_date" 
					type="text" 
					style="width:100px; text-align:left;" 
					name="repayment_schedule_date[_XXX]" 
					class="edit_toggle_XXX"
					value="xxx_repayment_schedule_date"
					disabled 
					class="form-control  date-field"> 
					
				<label for="repayment_schedule_date" class="input-group-addon btn">
					<span class="glyphicon glyphicon-calendar"></span>
				</label>
			</td>
			principal_component
			interest_component
			penalty_interest
			
			<td>
				<input id="principal_component_XXX" 
					type="text" 
					style="width:90px; text-align:right;" 
					name="principal_component[_XXX]" 
					readonly
					value="xxx_principal_component" 
					class="borr_prin_amt"
					disabled 
					class="form-control "> 
			</td>
			<td>
				<input id="interest_component_XXX" 
					type="text" 
					style="width:90px; text-align:right;" 
					name="interest_component[_XXX]" 
					value="xxx_interest_component" 
					class="borr_int_amt"
					readonly
					disabled 
					class="form-control "> 
			</td>
			<td>
				<input id="penalty_interest_XXX" 
					type="text" 
					style="width:80px; text-align:right;" 
					name="penalty_interest[_XXX]" 
					value="xxx_repayment_penalty_interest" 
					class="borr_penalty_interest"
					readonly
					disabled 
					class="form-control "> 
			</td>
			<td>
				<input id="penalty_fee_XXX" 
					type="text" 
					style="width:80px; text-align:right;" 
					name="penalty_fee[_XXX]" 
					class="edit_toggle_XXX borr_penalty_fee"
					value="xxx_repayment_penalty_charges" 
					onchange="computeBorrTotal(_XXX)"
					decimal="2"
					disabled 
					class="form-control "> 
			</td>
			<td>
				<input id="total_XXX" 
					type="text" 
					style="width:90px; text-align:right;" 
					name="total" 
					
					value="xxx_total" 
					readonly
					disabled 
					class="form-control "> 
			</td>
			<td>
				<input id="status" 
					type="text" 
					style="width:90px; text-align:left;" 
					value="xxx_repayment_status" 
					disabled 
					readonly
					class="form-control "> 
			</td>
			<td>
				<i class="fa fa-edit" onclick="editInst(1)" )=""></i>
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
					name="principal_component[xxx_invId][_XXX]" 
					onchange="computeInvTotal(_XXX, xxx_invId)"
					decimal="2"
					value="xxx_principal_component" 
					class="form-control ">
			</td>
			
			<td>
				<input id="interest_component_XXX_xxx_invId" 
					type="text" 
					style=" text-align:right;" 
					name="interest_component[xxx_invId][_XXX]" 
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
					name="penalty_interest[xxx_invId][_XXX]" 
					onchange="computeInvTotal(_XXX, xxx_invId)"
					decimal="2"
					value="xxx_repayment_penalty_interest" 
					class="form-control ">
			</td>
			
			<td>
				<input id="total_XXX_xxx_invId" 
					type="text" 
					style=" text-align:right;" 
					name="total"
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
		</tr>
	
	</table>
	<table id="InvDisbSchd">
		<tr>
			<td class="text-left"> xxx_inst_number</td>
			<td class="text-left"> xxx_payment_schedule_date</td>
			<td class="text-left"> xxx_repayment_actual_date</td>
			<td class="text-right"> xxx_principal_component</td>
			<td class="text-right"> xxx_interest_component</td>
			<td class="text-right"> xxx_repayment_penalty_interest</td>
			<td class="text-right"> xxx_total</td>
			<td class="text-left"> xxx_repayment_status</td>
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

invRepaySchd	=	{{$bidsModel->jsonInvRepay}}

function createTableRows(userType, rowData) {
	@if($bidsModel->loan_status	==	LOAN_STATUS_BIDS_ACCEPTED)
		sourceTable		=	'#AccSchd tbody'
	@else 
		if (userType = 'borrower') 
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
	$('#invInst tr:not(:first)').remove();
	
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
			alert (rE.toString());
			rowHtml = rowHtml.replace(rE, invId);
			
			rE	=	new RegExp("xxx_invName", "g")
			rowHtml = rowHtml.replace(rE, invName);
			
			$("#bidsummary").append(rowHtml);
		}
	}
	
}



function editInst(instNumber) {
	$(".edit_toggle"+instNumber).each (function () {
		$(this).removeAttr("disabled")
	})

	invRowClass = ".invRow" + instNumber
	$(invRowClass).show();
	 
	$("#reschdLoan").hide()
	$("#saveReschd").show()
	$("input[decimal]").each(function() {
		
		$(this).on("focus", function () {
			onFocusNumberField(this)
		})
		$(this).on("blur", function () {
			onBlurNumberField(this)
		})
	})
	
	$('#repayment_schedule_date').datetimepicker({
		autoclose: true, 
		minView: 2,
		format: 'dd-mm-yyyy' 
	}); 
	
	submitForm = false;
}

function saveReschd() {
	loanAmt	=	{{$bidsModel->loan_sanctioned_amount}}
	
	
	
	
}

function computeInvTotal(instNumb, invId) {
	intAmt = numeral($("#interest_component" + instNumb + invId).val())
	prinAmt = numeral($("#principal_component" + instNumb + invId).val())
	penAmt = numeral($("#penalty_interest" + instNumb + invId).val())
	
	total = intAmt + prinAmt + penAmt
	$("#total" + instNumb + invId).val(numeral(total).format("0,000.00"))
	instPrinAmt = 0; // Principal Amt for this installment
	instIntAmt	= 0; // Interest Amt for this installment
	instPenInt	= 0; // Penalty Interest for this installment (in case of late payment)
	instPenFee	= 0; // Penalty Fees for this installment (in case of late payment)
	
	for (invIndex = 0; invIndex < invInfo.length; invIndex++) {
		invId	=	invInfo[invIndex]['inv_id'];
		invPrinAmt = $("#principal_component" + instNumb + invId).val();
		invIntAmt = $("#interest_component" + instNumb + invId).val();
		invPenInt = $("#penalty_interest" + instNumb + invId).val();
		
		instPrinAmt += numeral(invPrinAmt);
		instIntAmt += numeral(invIntAmt);
		instPenInt += numeral(invPenInt);
	}
	
		
		
		
	
}

$(document).ready(function () {

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
