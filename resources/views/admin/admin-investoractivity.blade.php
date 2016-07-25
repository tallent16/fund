@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('Investor Activty Report') )
@section('section')  
<div class="col-sm-12 space-around">
<div id="filter_area" >
<form method="get">
	<div class="row">		
		<div class="col-sm-12 col-lg-3"> 														
			<div class="form-group">	
					<strong>{{ Lang::get('Investor Name') }}</strong><br>							
					{{ Form::select('investor_filter',[''=>'']+ $adminInvActRepMod->allactiveinvestList,'',
												["class" => "selectpicker" ]) }} 
			</div>		
		</div>		
				
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group">							
				<strong>{{ Lang::get('From Date')}}</strong><br>							
				<input id="fromdate" name="fromDate_filter" value="" 
						type="text" class="date-picker form-control" />
			</div>	
		</div>

		<div class="col-sm-6 col-lg-3"> 
			<div class="form-group">								
				<strong>{{ Lang::get('To Date')}}</strong><br>							
				<input id="todate" name="toDate_filter" value=""
						type="text" class="date-picker form-control" />
			</div>	
		</div>
		
	</div>
</div>

<div class="row">	
	<div class="col-sm-3 col-lg-2" id="apply_filter_div" >
		<div class="form-group">	
			<button type="submit" class="btn verification-button">
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
	<div class="col-sm-12"> 
		<div class="table-responsive applyloan borrower-admin"> 
			<table class="table tab-fontsize table-border-custom text-left">
				<thead>
					<tr>
						<th class="tab-head text-left">{{ Lang::get('Date') }}</th>
						<th class="tab-head text-left">{{ Lang::get('Transaction Type') }}</th>
						<th class="tab-head text-left">{{ Lang::get('Reference Number') }}</th>
						<th class="tab-head text-left">{{ Lang::get('Details') }}</th>
						<th class="tab-head text-right">{{ Lang::get('Dr Amount') }}</th>
						<th class="tab-head text-right">{{ Lang::get('Cr Amount') }}</th>
						<th class="tab-head text-right">{{ Lang::get('Balance') }}</th>
					</tr>
				</thead>
				<tbody>	
				
					
				</tbody>
			</table>
		</div>
	</div>
</div><!------second row------>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>    
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
@stop

