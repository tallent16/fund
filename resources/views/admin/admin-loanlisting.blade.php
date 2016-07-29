@extends('layouts.dashboard')
@section('styles')
	{{ Html::style('css/datatable/jquery.dataTables.css') }}
	{{ Html::style('css/datatable/dataTables.tableTools.css') }}
	{{ Html::style('css/datatable/dataTables.editor.css') }}		
	<style>
		table.dataTable thead th, table.dataTable thead td {
			padding: 10px;
			border-bottom:none;
			font-size:12px;
		}
		table.dataTable thead > th {
			color: #fff;			
			text-decoration:none;			
		}		
		table.dataTable thead > tr{
			background-color:#333;
			color:#fff;
		}
		.dataTable td a{
			color:#333;
			text-decoration:none;		
		}
		.table-responsive{
			overflow:visible;
		}
		table.dataTable.no-footer{
			border:none;
		}
	</style>
@stop
@section('page_heading',Lang::get('Loan Listing') )
@section('section')  
<div class="col-sm-12 space-around">
<div id="filter_area" >
<form method="get">
	<div class="row">		
		<div class="col-sm-12 col-lg-3"> 														
			<div class="form-group">	
					<strong>{{ Lang::get('Filter Transcations') }}</strong><br>							
					{{ Form::select('filter_transcations', $adminLoanListing->allTransList, $adminLoanListing->filter_code, ["class" => "selectpicker","id" => "filter_transcations"]) }} 
			</div>		
		</div>		
				
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group">							
				<strong>{{ Lang::get('From Date')}}</strong><br>							
				<input id="fromdate" name="fromdate" value="{{$adminLoanListing->fromDate}}" 
						type="text" class="date-picker form-control" />
			</div>	
		</div>

		<div class="col-sm-6 col-lg-3"> 
			<div class="form-group">								
				<strong>{{ Lang::get('To Date')}}</strong><br>							
				<input id="todate" name="todate" value="{{$adminLoanListing->toDate}}"
						type="text" class="date-picker form-control" />
			</div>	
		</div>
		
	</div>
</div>

<div class="row">	
	<div class="col-sm-3 col-lg-2" id="apply_filter_div" >
		<div class="form-group">	
			<button type="button" id="filter_status" class="btn verification-button">
				{{ Lang::get('Apply Filter')}}
			</button>
		</div>
	</div>
</form>	
	<!---<div class="col-sm-4 col-lg-2">
		<div class="form-group">	
			<button  id="hide_show_filter" class="btn verification-button" onclick="hideShowFilter()">
				{{ Lang::get('Show Filter')}}
			</button>
		</div>
	</div>	--->
	
</div><!-----First row----->

<!--

<div class="row">
	<div class="col-sm-12"> 
		<div class="table-responsive applyloan borrower-admin"> 
			<table class="table tab-fontsize table-border-custom text-left">
				<thead>
					<tr>
						<th class="tab-head text-left">{{ Lang::get('Loan Reference Number') }}</th>
						<th class="tab-head text-left">{{ Lang::get('Borrower Organisation Name') }}</th>
						<th class="tab-head text-right">{{ Lang::get('Loan Amount') }}</th>
						<th class="tab-head text-right">{{ Lang::get('Target Interest') }}</th>
						<th class="tab-head text-right">{{ Lang::get('Tenure') }}</th>
						<th class="tab-head text-left">{{ Lang::get('Bid Type') }}</th>
						<th class="tab-head text-left">{{ Lang::get('Bid Close Date') }}</th>
						<th class="tab-head text-left">{{ Lang::get('Status') }}</th>
					</tr>
				</thead>
				<tbody>	
				
					@if (count($adminLoanListing->loanListInfo) > 0)			
						@foreach($adminLoanListing->loanListInfo as $loanlistRow)
							
							@var	$loan_id	=	base64_encode($loanlistRow->loan_id);
							@if  ($loanlistRow->status	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL)
										@var	$actionUrl		=	url('admin/loanapproval/')
										@var	$actionUrl		=	$actionUrl."/".$loan_id							
							@elseif ($loanlistRow->status	==	LOAN_STATUS_APPROVED)																	
										@var	$actionUrl		=	url('admin/managebids/')
										@var	$actionUrl		=	$actionUrl."/".base64_decode($loan_id)					
							@elseif ($loanlistRow->status	==	LOAN_STATUS_CLOSED_FOR_BIDS)
										@var	$actionUrl		=	url('admin/managebids/')
										@var	$actionUrl		=	$actionUrl."/".base64_decode($loan_id)		
							@elseif	($loanlistRow->status == LOAN_STATUS_BIDS_ACCEPTED)													
										@var	$actionUrl		=	url('admin/disburseloan/')
										@var	$actionUrl		=	$actionUrl."/".$loan_id									
							@else
										@var	$actionUrl		=	"javascript:void(0);"									
							@endif
							@if  ($loanlistRow->status	==	LOAN_STATUS_NEW)
									@var	$actionUrl		=	url('admin/loanapproval/')
									@var	$actionUrl		=	$actionUrl."/".$loan_id		
							@endif
							@if  ($loanlistRow->status	==	LOAN_STATUS_DISBURSED)
									@var	$actionUrl		=	url('admin/loanview/')
									@var	$actionUrl		=	$actionUrl."/".$loan_id		
							@endif
							@if  ($loanlistRow->status	==	LOAN_STATUS_LOAN_REPAID)
									@var	$actionUrl		=	url('admin/loanview/')
									@var	$actionUrl		=	$actionUrl."/".$loan_id		
							@endif
							@if  ($loanlistRow->status	==	LOAN_STATUS_PENDING_COMMENTS)
								@var	$actionUrl		=	url('admin/loanapproval/')
								@var	$actionUrl		=	$actionUrl."/".$loan_id								
							@endif

									<tr class="odd" id="11" role="row">								
										<td class="text-left">
											<a href="{{$actionUrl}}">
												{{$loanlistRow->loan_reference_number}}
											</a>
										</td>
										<td class="text-left">
											<a href="{{$actionUrl}}">
												{{$loanlistRow->business_name}}
											</a>
										</td>
										<td class="text-right">
											<a href="{{$actionUrl}}">
												{{number_format($loanlistRow->loan_sanctioned_amount,2,'.',',')}}
											</a>
										</td>
										<td class="text-right">
											<a href="{{$actionUrl}}">
												{{$loanlistRow->target_interest}}
											</td>
										<td class="text-right">
											<a href="{{$actionUrl}}">
												{{$loanlistRow->loan_tenure}}
											</a>
										</td>
										<td class="text-left">
											<a href="{{$actionUrl}}">
												{{$loanlistRow->bid_type_name}}
											</a>
										</td>
										<td class="text-left">
											<a href="{{$actionUrl}}">
												{{$loanlistRow->bid_close_date}}
											</a>
											</td>
										<td class="text-left">
											<a href="{{$actionUrl}}">
												{{$loanlistRow->loan_status_name}}
											</a>
										</td>
									</tr>						

						@endforeach
					@endif				
							
				</tbody>
			</table>
		</div>
	</div>
</div><!------second row------>

	<div class="row">		
		<div class="col-lg-12 col-md-12">
			<div class="table-responsive">
				<table class="table table-striped" id="adminloanlisting">
					<thead>
						<tr>
							<th>{{ Lang::get('Loan Reference No') }}</th>
							<th>{{ Lang::get('Borrower Organisation Name') }}</th>
							<th>{{ Lang::get('Loan Amt') }}</th>
							<th>{{ Lang::get('Target Interest') }}</th>
							<th>{{ Lang::get('Tenure') }}</th>
							<th>{{ Lang::get('Bid Type') }}</th>
							<th>{{ Lang::get('Bid Close Date') }}</th>
							<th>{{ Lang::get('Status') }}</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>							
		</div>
	</div>
				
</div>
@endsection
@stop
@section('bottomscripts')
<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
<script> var baseUrl	=	"{{url('')}}" </script>
<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
{{ Html::script('js/datatable/jquery.dataTables.min.js') }}
{{ Html::script('js/datatable/dataTables.tableTools.min.js') }}
{{ Html::script('js/datatable/dataTables.editor.js') }}	
{{ Html::script('js/customdatatable/adminloanlisting.js') }} 
<script>	/*
function hideShowFilter() {

	hideShow = $("#hide_show_filter").html();
	
	if (hideShow == "Hide Filter") {
		$("#apply_filter_div").hide();
		$("#filter_area").hide();
		$("#hide_show_filter").html("{{ Lang::get('Show Filter') }}")
	} else {
		$("#apply_filter_div").show();
		$("#filter_area").show();
		$("#hide_show_filter").html("{{ Lang::get('Hide Filter') }}")
	}

}	*/
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
}); 
</script>
@endsection  


