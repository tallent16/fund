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
		ul.radio  {
		  margin: 0;
		  padding: 0;
		  margin-left: 20px;
		  list-style: none;
		}

		ul.radio li {
			border: 1px transparent solid;
			display: inline-block;
			margin-right: 25px;
		}

	</style>
@stop
@section('page_heading',Lang::get('Investor Profile Report') )
@section('section')  
<div class="col-sm-12 space-around">
<div id="filter_area" >
<form method="post" action="{{url('admin/investor-profiles/report')}}">
	<input  type="hidden" 
			name="_token"
			id="hidden_token"
			value="{{ csrf_token() }}" />
	<div class="row">		
				
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group">	
					<strong>{{ Lang::get('Status') }}</strong><br>							
					{{ Form::select('approval_status', 
							$adminInvProRepMod->allAprovalStatus, 
							'', 
							["class" => "selectpicker",
							"id" => "loan_status"]) }} 
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
		action="{{url('admin/investor-profiles-report/download')}}">
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
@if(!empty($adminInvProRepMod->invListInfo))
	<div class="row">		
		<div class="col-lg-12 col-md-12">
			<div class="table-responsive">
				<table class="table tab-fontsize table-border-custom text-left" id="adminloanlisting">
					<thead>
						<tr>
							<th class="tab-head text-left">{{ Lang::get('Investor Id') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Investor User Name') }}</th>
							<th class="tab-head text-left">{{ Lang::get('First Name') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Last name') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Email') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Mobile Number') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Date of Birth') }}</th>
							<th class="tab-head text-left">{{ Lang::get('NRIC Number') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Nationality') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Estimated Yearly Income') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Balance on Hand') }}</th>
							<th class="tab-head text-left">{{ Lang::get('No of Loans Applied') }}</th>
							<th class="tab-head text-left">{{ Lang::get('No of Loans Invested') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Total Invested Amount') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Total Returns') }}</th>
							<th class="tab-head text-left">{{ Lang::get('ROI') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($adminInvProRepMod->invListInfo as $listRow)
							<tr>
								<td class="text-left">{{$listRow->investor_id}}</td>
								<td class="text-left">{{$listRow->username}}</td>
								<td class="text-left">{{$listRow->firstname}}</td>
								<td class="text-left">{{$listRow->lastname}}</td>
								<td class="text-left">{{$listRow->email}}</td>
								<td class="text-left">{{$listRow->mobile_number}}</td>
								<td class="text-left">{{$listRow->dob}}</td>
								<td class="text-left">{{$listRow->nric_number}}</td>
								<td class="text-left">{{$listRow->nationality}}</td>
								<td class="text-left">{{number_format($listRow->estimated_yearly_income,2,'.',',')}}</td>
								<td class="text-left">{{number_format($listRow->available_balance,2,'.',',')}}</td>
								<td class="text-left">{{$listRow->no_loan_applied}}</td>
								<td class="text-left">{{$listRow->no_loan_invested}}</td>
								<td class="text-left">{{number_format($listRow->tot_invest_amt,2,'.',',')}}</td>
								<td class="text-left">{{number_format($listRow->tot_returns,2,'.',',')}}</td>
								<td class="text-left">{{number_format($listRow->roi,2,'.',',')}}</td>
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
<script>	

/*
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
