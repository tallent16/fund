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
				<input id="fromdate" name="fromdate" value="" 
						type="text" filter_field="Yes" class="date-picker form-control" />
			</div>	
		</div>

		<div class="col-sm-6 col-lg-3"> 
			<div class="form-group">								
				<strong>{{ Lang::get('To Date')}}</strong><br>							
				<input id="todate" name="todate" value=""
						type="text" filter_field="Yes"
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
	<!---<div class="col-sm-4 col-lg-2">
		<div class="form-group">	
			<button  id="hide_show_filter" class="btn verification-button" onclick="hideShowFilter()">
				{{ Lang::get('Show Filter')}}
			</button>
		</div>
	</div>	--->
	
</div><!-----First row----->

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
							<th class="tab-head text-left">{{ Lang::get('Tenure') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Loan Applied Amount') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Total Bids Received Number') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Total Bids Received Amount') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Total Sanctioned Amount') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Total Prinicipal O/s') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Total Interest O/s') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Total Penalty Interest') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Total Penalty Charges') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Overdue Amount') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Overdue Since') }}</th>
							<th class="tab-head text-left">{{ Lang::get('Action') }}</th>
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
