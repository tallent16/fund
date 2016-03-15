@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script> 
	<script src="{{ url('js/borrower-transhistory.js') }}" type="text/javascript"></script> 
@endsection
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 		 
@endsection
@section('page_heading','Transcation History')
@section('section')    
<div id="filter_area" style="display:none">
<form method="get">
	<div class="row">	
		<!--<div class="col-sm-12"> -->
		<div class="col-sm-3"> 														
			<div class="form-group">	
				<strong>Filter Transactions</strong><br>							
				<select class="selectpicker" name="transtype">
					<option	value="Disbursals">Disbursals</option>
					<option	value="Fees">Fees</option>
					<option	value="Repayments">Repayments</option>
					<option	value="All">All</option>
				</select>
			</div>	
		</div>
				
		<div class="col-sm-3"> 														
			<div class="form-group">							
				<strong>From Date</strong><br>							
				<input id="fromdate" name="fromdate" type="text" class="date-picker form-control" />
			</div>	
		</div>

		<div class="col-sm-3"> 
			<div class="form-group">								
				<strong>To Date</strong><br>							
				<input id="todate" name="todate" type="text" class="date-picker form-control" />
			</div>	
		</div>

		<!--</div>-->
	</div>
</div>

<div class="row">
	<!--<div class="col-sm-12" >-->
		<div class="col-sm-2" id="apply_filter_div" style="display:none">
			<button type="submit" class="btn verification-button">
				{{ Lang::get('Apply Filter') }}
			</button>
		</div>
</form>
		<div class="col-sm-2">
			<button  id="hide_show_filter" class="btn verification-button" onclick="hideShowFilter()">
				{{ Lang::get('Show Filter') }}
			</button>
		</div>
	<!--</div>-->
		<div class="col-sm-3"> 
			<div class="form-group">								
				<button type="submit" class="btn verification-button">Export to Excel</button>		
			</div>	
		</div>

</div>

		 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>    
<script>
	
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

} 
	
$(document).ready(function(){ 
	// date picker
	$('.date-picker').datetimepicker({
	autoclose: true, 
	minView: 2,
	format: 'dd/mm/yyyy' 

	}); 
}); 
</script>  
@endsection  
@stop
