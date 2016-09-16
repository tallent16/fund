@extends('layouts.dashboard')
@section('styles')
	{{ Html::style('css/datatable/jquery.dataTables.css') }}
	{{ Html::style('css/datatable/dataTables.tableTools.css') }}
	{{ Html::style('css/datatable/dataTables.editor.css') }}		

@stop
@section('page_heading',Lang::get('Commission Fees Ledger Report') )
@section('section')  
<div class="col-sm-12 space-around">
<div id="filter_area" >
<form method="post" action="{{url('admin/commission-fees-ledger/report')}}">
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
						value="{{$adminCommFeeLedRepMod->fromDate}}"
						type="text" 
						filter_field="Yes" 
						class="date-picker form-control" />
			</div>	
		</div>

		<div class="col-sm-6 col-lg-3"> 
			<div class="form-group">								
				<strong>{{ Lang::get('To Date')}}</strong><br>							
				<input 	id="todate" 
						name="todate" 
						value="{{$adminCommFeeLedRepMod->toDate}}"
						type="text" 
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
		action="{{url('admin/commission-fees-ledger-report/download')}}">
		<input  type="hidden" 
				name="_token"
				id="hidden_token"
				value="{{ csrf_token() }}" />
		<input type="hidden" id="report_json" name="report_json" />
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
@if(!empty($adminCommFeeLedRepMod->loanListInfo))
	<div class="row">		
		<div class="col-lg-12 col-md-12">
			<div class="table-responsive">
				<table class="table tab-fontsize table-border-custom text-left" id="adminloanlisting">
					<thead>
						<tr>
							<th class="tab-head text-left">{{ Lang::get('Loan Ref No') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Organisation Name') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Borrower Grade') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Loan Disbursal Date') }}</th>
							<th class="tab-head text-right">{{ Lang::get('Loan Disbursal Amount') }}</th>
							<th class="tab-head text-right">{{ Lang::get('Processing Fixed Fees') }}</th>
							<th class="tab-head text-right">{{ Lang::get('Processing Commission') }}</th>
						</tr>
					</thead>
					<tbody>
						@var	$tot_fix_fees	=	0
						@var	$tot_comm		=	0
						@foreach($adminCommFeeLedRepMod->loanListInfo as $listRow)
							<tr>
								<td class="text-left">{{$listRow->loan_reference_number}}</td>
								<td class="text-left">{{$listRow->business_name}}</td>
								<td class="text-left">{{$listRow->loan_risk_grade}}</td>
								<td class="text-left">{{$listRow->disbursement_date}}</td>
								<td class="text-right">
									{{number_format($listRow->amount_disbursed,2,'.',',')}}
								</td>
								<td class="text-right">
									{{number_format($listRow->process_fix_fees,2,'.',',')}}
								</td>
								<td class="text-right">
									{{number_format($listRow->process_commission,2,'.',',')}}
								</td>
							</tr>
							@var	$tot_fix_fees	=	$tot_fix_fees	+	$listRow->process_fix_fees
							@var	$tot_comm		=	$tot_comm		+	$listRow->process_commission
						@endforeach
							<tr>
								<td class="text-left"></td>
								<td class="text-left"></td>
								<td class="text-left"></td>
								<td class="text-right"></td>
								<td class="text-right">
									Total:
								</td>
								<td class="text-right">
									{{number_format($tot_fix_fees,2,'.',',')}}
								</td>
								<td class="text-right">
									{{number_format($tot_comm,2,'.',',')}}
								</td>
							</tr>
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
<script> var baseUrl	=	"{{url('')}}" </script>

<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
<script src="{{ url('js/jquery.tabletojson.js') }}" type="text/javascript"></script>
<script>
	function convert2json() {
		var reportJson 	= $('.table').tableToJSON(); // Convert the table into a javascript object
		$obj				=	JSON.stringify(reportJson);
	
		$("#report_json").val($obj);
		if(reportJson.length > 0) {
			$("#excel_export").submit();
		}else{
			showDialog("","No Data avilable to Export");
		}
		
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
