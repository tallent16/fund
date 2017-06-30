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
		label.error{
			 color: #a94442;	
		}
	</style>
@stop
@section('page_heading',Lang::get('Project Listing Report') )
@section('section')  
@var	$apply_date			=	"checked"
@var	$sanctioned_date	=	""
@if($adminLoanListRepModel->date_type	==	"sanctioned" )
	@var	$apply_date			=	""
	@var	$sanctioned_date	=	"checked"

@endif
<div class="col-sm-12 space-around">
<div id="filter_area" >
<form 	method="POST" 
		class='form-validate' 
		action="{{url('admin/project-listing/report')}}" >
	<input  type="hidden" 
			name="_token"
			id="hidden_token"
			value="{{ csrf_token() }}" />
	<div class="row">		
		<div class="col-sm-12 col-lg-6"> 														
			<div class="form-group">
				<fieldset class="radiogroup">
					<legend>Select Date Type</legend>
					  <ul class="radio">
						<li>
							<input 	type="radio" 
									name="date_type" 
									id="app_date_type" 
									value="apply"
									{{$apply_date}} />
							<label for="app_date_type">By Apply Date</label>
						</li>
						<li>
							<input	type="radio" 
									name="date_type" 
									id="san_date_type" 
									value="sanctioned" 
									{{$sanctioned_date}} />
							<label for="san_date_type">By Sanctioned Date </label>
						</li>
					  </ul>
				</fieldset>

			</div>	
		</div>
	</div>
	<div class="row">		
				
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group">							
				<strong>{{ Lang::get('From Date')}}</strong><br>							
				<input 	id="fromdate" 
						name="fromdate" 
						value="{{$adminLoanListRepModel->fromDate}}" 
						data-rule-required="true"
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
						value="{{$adminLoanListRepModel->toDate}}"
						type="text" 
						data-rule-required="true"
						filter_field="Yes"
						class="date-picker form-control" />
			</div>	
		</div>
		
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group">	
					<strong>{{ Lang::get('Status') }}</strong><br>							
					{{ Form::select('loan_status[]', 
							$adminLoanListRepModel->allLoanStatus, 
							$adminLoanListRepModel->loanStatusVal,
							["class" => "selectpicker",
							"id" => "loan_status",
							"data-live-search"=>"1",
							"data-actions-box"=>"true",
							"data-selected-text-format"=>"count>3",
							"data-size"=>"5",
							"multiple"=>"multiple",
							"data-rule-required"=>"true"]) }} 
			</div>		
		</div>	
		
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group">	
					<strong>{{ Lang::get('Grade') }}</strong><br>							
					{{ Form::select('grade[]', 
							$adminLoanListRepModel->allBorGrade, 
							$adminLoanListRepModel->borGradeVal, 
							["class" => "selectpicker",
							"id" => "grade",
							"data-live-search"=>"1",
							"data-actions-box"=>"true",
							"data-selected-text-format"=>"count>3",
							"data-size"=>"5",
							"multiple"=>"multiple",
							"data-rule-required"=>"true"]) }} 
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
		action="{{url('admin/project-listing-report/download')}}">
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
	@if(!empty($adminLoanListRepModel->loanListInfo))
		<div class="row">		
			<div class="col-lg-12 col-md-12">
				<div class="table-responsive">
					<table class="table tab-fontsize table-border-custom text-left" id="adminloanlisting">
						<thead>
							<tr>
								<th class="tab-head text-left">{{ Lang::get('Ref No') }}</th>
								<th class="tab-head text-left">{{ Lang::get('Creator Organasition Name') }}</th>
								<th class="tab-head text-left">{{ Lang::get('Creator Grade') }}</th>
								<th class="tab-head text-right">{{ Lang::get('Funding Goal') }}</th>
								<th class="tab-head text-left">{{ Lang::get('Apply Date') }}</th>
								<th class="tab-head text-left">{{ Lang::get('Approval Date') }}</th>
								<th class="tab-head text-right">{{ Lang::get('Partial Subscription Amount') }}</th>
								<th class="tab-head text-left">{{ Lang::get('Status') }}</th>
							</tr>
						</thead>
						<tbody>
							@foreach($adminLoanListRepModel->loanListInfo as $listRow)
								<tr>
									<td class="text-left">{{$listRow->loan_reference_number}}</td>
									<td class="text-left">{{$listRow->business_name}}</td>
									<td class="text-left">{{$listRow->bor_grade}}</td>
									<td class="text-right">{{number_format($listRow->apply_amount,2,'.',',')}}</td>
									<td class="text-left">{{$listRow->apply_date}}</td>
									<td class="text-left">{{$listRow->loan_approval_date}}</td>
									<td class="text-right">{{number_format($listRow->par_sub_amt,2,'.',',')}}</td>
									<td class="text-left">{{$listRow->loan_status_name}}</td>
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
<script src="{{ url('js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ url('js/jquery.tabletojson.js') }}" type="text/javascript"></script>
<script>
	function convert2json() {
		var reportJson 	= $('.table').tableToJSON(); // Convert the table into a javascript object
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
