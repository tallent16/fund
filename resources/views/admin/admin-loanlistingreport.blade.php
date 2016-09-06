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
@section('page_heading',Lang::get('Loan Listing Report') )
@section('section')  
<div class="col-sm-12 space-around">
<div id="filter_area" >
<form method="get">
	<div class="row">		
		<div class="col-sm-12 col-lg-6"> 														
			<div class="form-group">
				<label></label>						
				<input  name="transdate_type" value="1" 
						type="checkbox"  class="date-picker form-control" />
			</div>	
		</div>
	</div>
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
		
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group">	
					<strong>{{ Lang::get('Status') }}</strong><br>							
					{{ Form::select('loan_status', 
							[], 
							'', 
							["class" => "selectpicker",
							"id" => "loan_status"]) }} 
			</div>		
		</div>	
		
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group">	
					<strong>{{ Lang::get('Grade') }}</strong><br>							
					{{ Form::select('grade', 
							[], 
							'', 
							["class" => "selectpicker",
							"id" => "grade"]) }} 
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
