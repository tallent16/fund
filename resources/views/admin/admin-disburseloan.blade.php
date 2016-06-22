@extends('layouts.dashboard')
@section('page_heading',Lang::get('Manage Loans') )
@section('section')  

@if( ($bidsModel->loan_status	==	LOAN_STATUS_DISBURSED) || ($bidsModel->loan_status	==	LOAN_STATUS_LOAN_REPAID))
	@var	$disableFields			=	"disabled"
	@var	$dispTitle				=	Lang::get("Loan Details")
	@var 	$canViewInvestorList	=	true
	@var	$button1Text			=	Lang::get("Reschedule Repayment")
	@var	$button1Id				=	"reschdLoan"
	@var	$button2Text			=	Lang::get("Save Rescheduled Loan")
	@var	$button2Id				=	"saveReschd"
	@var	$actionUrl				=	url('admin/saveResched')
	
@else
	@var	$dispTitle				=	Lang::get("Loan Disbursal")
	@var	$disableFields			=	""
	@var 	$canViewInvestorList	=	false
	@var	$button1Text			=	Lang::get("Disburse Loan")
	@var	$button1Id				=	"reschdLoan"
	@var	$buttonText				=	Lang::get("Generate Repay Schedule")
	@var	$button2Id				=	"reschdLoan"
	@var	$actionUrl				=	url('admin/savedisbursement')
@endif
					
					
<form 	method="post" 
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

$("form").submit(function(event) {
	system_date = "{{$bidsModel->system_date}}";
	disburse_date = $("#disbursement_date").val();
	
	// Disbursement date cannot be a future date
	if (moment(system_date).isBefore(disburse_date)) {
		showDialog("", "{{Lang::get('Disbursement Date should not be a future date')}}");
		event.preventDefault();
	}
	
	$("form input[type=text]").each (function() {
		$(this).removeAttr("disabled");
	})	
})
</script>
<script src="{{ url('js/admin-disburseloan.js') }}" type="text/javascript"></script>
@endsection
@stop
