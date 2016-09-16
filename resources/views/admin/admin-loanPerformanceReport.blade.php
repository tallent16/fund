@extends('layouts.dashboard')
@section('styles')
	{{ Html::style('css/datatable/jquery.dataTables.css') }}
	{{ Html::style('css/datatable/dataTables.tableTools.css') }}
	{{ Html::style('css/datatable/dataTables.editor.css') }}		
	<style>
		label.error{
			 color: #a94442;	
		}
	</style>
@stop
@section('page_heading',Lang::get('Loan Performance Report') )
@section('section')  
<div class="col-sm-12 space-around">
<div id="filter_area" >
<form method="post" action="{{url('admin/loan-perform/report')}}">
	<input  type="hidden" 
			name="_token"
			id="hidden_token"
			value="{{ csrf_token() }}" />
	
	<div class="row">		
				
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group">							
				<strong>{{ Lang::get('From Date')}}</strong><br>							
				<input 	id="fromdate" 
						name="fromdate" 
						value="{{$adminLoanPerRepMod->fromDate}}" 
						type="text" 
						data-rule-required="true"
						filter_field="Yes" 
						class="date-picker form-control" />
			</div>	
		</div>

		<div class="col-sm-6 col-lg-3"> 
			<div class="form-group">								
				<strong>{{ Lang::get('To Date')}}</strong><br>							
				<input 	id="todate" 
						name="todate" 
						value="{{$adminLoanPerRepMod->toDate}}" 
						type="text" 
						data-rule-required="true"
						filter_field="Yes"
						class="date-picker form-control" />
			</div>	
		</div>
	</div>
</div>

<div class="row">	
	<div class="col-sm-3 col-lg-2" id="apply_filter_div" >
		<div class="form-group">	
			<button type="submit" id="filter_status" class="btn verification-button">
				{{ Lang::get('Apply Filter')}}
			</button>
		</div>
	</div>
</form>	
<form 	class="form-horizontal" 
		id="excel_export" 
		method="post"
		action="{{url('admin/loan-perform-report/download')}}">
		<input  type="hidden" 
				name="_token"
				id="hidden_token"
				value="{{ csrf_token() }}" />
		<input type="hidden" id="report_json" name="report_json" />
		<input type="hidden" id="hidden_from_date" name="from_date" />
		<input type="hidden" id="hidden_to_date" name="to_date" />
		<div class="col-sm-4 col-lg-2">
			<div class="form-group">	
				<button  id="export_all"
						class="btn verification-button" 
						type="button"
						onclick="convert2json()">
					{{ Lang::get('Export')}}
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
@if(!empty($adminLoanPerRepMod->loanListInfo))
	<div class="row">		
		<div class="col-lg-12 col-md-12">
			<div class="table-responsive">
				<table class="table tab-fontsize table-border-custom text-left" id="adminloanlisting">
					<thead>
						<tr>
							<th class="tab-head text-left">{{ Lang::get('Loan Ref No') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Organisation Name') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Borrower Grade') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Bid Type') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Repayment Type') }}</th>
							<th class="tab-head text-right">{{ Lang::get('Tenure') }}</th>
							<th class="tab-head text-right">{{ Lang::get('Loan Applied Amount') }}</th>
							<th class="tab-head text-right">{{ Lang::get('Total Bids Received Number') }}</th>
							<th class="tab-head text-right">{{ Lang::get('Total Bids Received Amount') }}</th>
							<th class="tab-head text-right">{{ Lang::get('Loan Sanctioned Amount') }}</th>
							<th class="tab-head text-right">{{ Lang::get('Total Prinicipal O/s') }}</th>
							<th class="tab-head text-right">{{ Lang::get('Total Interest O/s') }}</th>
							<th class="tab-head text-right">{{ Lang::get('Total Penalty Interest') }}</th>
							<th class="tab-head text-right">{{ Lang::get('Total Penalty Charges') }}</th>
							<th class="tab-head text-right">{{ Lang::get('Overdue Amount') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Overdue Since') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Action') }}</th>
							<th style="display:none">LoanID</th>
						</tr>
					</thead>
					<tbody>
						@foreach($adminLoanPerRepMod->loanListInfo as $listRow)
							<tr id="row_{{$listRow->loan_id}}">
								<td class="text-left">
									{{  $listRow->loan_reference_number}}
								</td>
								<td class="text-left">
									{{  $listRow->business_name}}
								</td>
								<td class="text-left">
									{{  $listRow->bor_grade}}
								</td>
								<td class="text-left">
									{{ $listRow->bid_type }}
								</td>
								<td class="text-left">
									{{ $listRow->repayment_type }}
								</td>
								<td class="text-right">
									{{ $listRow->loan_tenure }}
								</td>
								<td class="text-right num_format">
									{{ number_format($listRow->apply_amount,2,'.',',') }}
								</td>
								<td class="text-right num_format">
									{{ $listRow->tot_bids_received }}
								</td>
								<td class="text-right num_format">
									{{ number_format($listRow->tot_bids_received_amt,2,'.',',') }}
								</td>
								<td class="text-right num_format">
									{{ number_format($listRow->loan_sanctioned_amount,2,'.',',') }}
								</td>
								<td class="text-right num_format">
									{{number_format($listRow->tot_principal_os,2,'.',',') }}
								</td>
								<td class="text-right num_format">
									{{ number_format($listRow->tot_interest_os,2,'.',',')}}
								</td>
								<td class="text-right num_format">
									{{ number_format($listRow->overdue_amt,2,'.',',') }}
								</td>
								<td class="text-right num_format">
									{{ $listRow->tot_penalty_charges}}
								</td>
								<td class="text-right num_format">
									{{ number_format($listRow->overdue_amt,2,'.',',') }}
								</td>
								<td class="text-left">
									{{ $listRow->overdue_since }}
								</td>
								<td class="text-left">
									<button 
										onclick="showBorrowerRepaymentSchedule({{$listRow->loan_id}})"
										class="btn verification-button repayment_schedule" 
										type="button">
										Show Repayments
									</button>
								</td>	
								<td style="display:none">{{ $listRow->loan_id }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>							
		</div>
	</div>
@endif				
</div>
@endsection
@stop
@section('bottomscripts')
<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
<script> 
	var baseUrl			=	"{{url('')}}" 
	@if(!empty($adminLoanPerRepMod->jsonBorrRepay))
		var	borRepSchdJson	=	{{$adminLoanPerRepMod->jsonBorrRepay}}
	@endif
</script>

<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
<script src="{{ url('js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ url('js/jquery.tabletojson.js') }}" type="text/javascript"></script>
<script>
	function convert2json() {
		
		$(".bor_repay_schd").remove();
		//~ jQuery('.num_format').html().replace(',', '');
		$('.num_format').html().replace(/,/g, '');
		var reportJson 		= 	$('.table').tableToJSON(); // Convert the table into a javascript object
		$obj				=	JSON.stringify(reportJson);
		$fromDate			=	$("#fromdate").val();
		$toDate				=	$("#todate").val();
		
		$("#hidden_from_date").val($fromDate);
		$("#hidden_to_date").val($toDate);
		$("#report_json").val($obj);
		if(reportJson.length > 0) {
			$("#excel_export").submit();
		}else{
			showDialog("","No Data avilable to Export");
		}
	}
	
	function showBorrowerRepaymentSchedule(loan_id) {

		borRepSchd	=	getBorrRepaySchdByJson(loan_id);
		
		$(".bor_repay_schd").remove();
		var	str	=	"";
		str	=	"<tr class='bor_repay_schd'><td colspan='12'>";
		str	=	str+"<table class='table table-bordered table-striped'>"+
					"<thead><tr><th class='tab-head text-left'>Inst-No</th>"+
					"<th class='tab-head text-left'>Inst Due Date</th>"+
					"<th class='tab-head text-left'>Inst Act Pay Date</th>"+
					"<th class='tab-head text-right'>Schd Inst Amount</th>"+
					"<th class='tab-head text-right'>Principal</th>"+
					"<th class='tab-head text-right'>Interest</th>"+
					"<th class='tab-head text-right'>Penalty</th>"+
					"<th class='tab-head text-left'>Status</th></tr></thead><tbody>";
		
		$.each(borRepSchd, function (index, value) {
			str	=	str+"<tr><td class='text-left'>"+borRepSchd[index].installment_number+"</td>"+
					"<td class='text-left'>"+borRepSchd[index].repayment_schedule_date+"</td>"+
					"<td class='text-left'>"+borRepSchd[index].repayment_actual_date+"</td>"+
					"<td class='text-right'>"+borRepSchd[index].repayment_scheduled_amount+"</td>"+
					"<td class='text-right'>"+borRepSchd[index].principal_component+"</td>"+
					"<td class='text-right'>"+borRepSchd[index].interest_component+"</td>"+
					"<td class='text-right'>"+borRepSchd[index].penalty+"</td>"+
					"<td class='text-left'>"+borRepSchd[index].repayment_status+"</td></tr>";
		});
		str	=	str+"</tbody></table></td><td colspan='5'></td></tr>";
		$(str).insertAfter("#row_"+loan_id);
	}
	
	function getBorrRepaySchdByJson(loan_id) {
		var listRepSchd	=	"";
		
		$.each(borRepSchdJson, function (index, value) {
			console.log(loan_id+":"+index);
			if(loan_id	==	index) {
				listRepSchd	=	borRepSchdJson[index];
			}	
		});
		return	listRepSchd;
	}
</script>


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
	$('form').validate().settings.ignore = ':not(select:hidden, input:visible, textarea:visible)';
	$('form').validate();
	$('#fromdate').datetimepicker({
	autoclose: true, 
	minView: 2,
	format: 'dd-mm-yyyy' 

	}); 
	$('#todate').datetimepicker({
	autoclose: true, 
	minView: 2,
	format: 'dd-mm-yyyy' 

	});         
}); 
</script>
@endsection  
