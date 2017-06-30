@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script> 
	<script src="{{ url('js/borrower-transhistory.js') }}" type="text/javascript"></script> 
@endsection
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 		 
@endsection
@section('page_heading',Lang::get('Project Summary'))
@section('section')    
<div class="col-sm-12 space-around">
<div id="filter_area" style="display:none">
<form method="get">
	<div class="row">	
		<!--<div class="col-sm-12"> -->
		<div class="col-sm-12 col-lg-3"> 														
			<div class="form-group">	
				<strong>{{ Lang::get('borrower-transcationhistory.filter_transcations')}}</strong><br>	
				{{ Form::select('transtype', $tranModel->tranTypeFilter, $tranModel->tranType,
					 ["class" => "selectpicker",
					 "filter_field" => "Yes"]) }} 
			</div>	
		</div>
				
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group">							
				<strong>{{ Lang::get('borrower-transcationhistory.from_date') }}</strong><br>							
				<input id="fromdate" name="fromdate" value="{{$tranModel->fromDate}}" 
						type="text" filter_field = "Yes" class="date-picker form-control" />
			</div>	
		</div>

		<div class="col-sm-6 col-lg-3"> 
			<div class="form-group">								
				<strong>{{ Lang::get('borrower-transcationhistory.to_date') }}</strong><br>							
				<input id="todate" name="todate" value="{{$tranModel->toDate}}"
						type="text" filter_field = "Yes" class="date-picker form-control" />
			</div>	
		</div>

		<!--</div>-->
	</div>
</div>

<div class="row">
	<!--<div class="col-sm-12" >-->
		<div class="col-sm-3 col-lg-2" id="apply_filter_div" style="display:none">
			<button type="submit" class="btn verification-button">
				{{ Lang::get('borrower-loanlisting.apply_filter') }}
			</button>
		</div>
</form>
		<div class="col-sm-4 col-lg-2">
			<button  id="hide_show_filter" class="btn verification-button" onclick="hideShowFilter()">
				{{ Lang::get('borrower-loanlisting.show_filter') }}
			</button>
		</div>
	<!--</div>-->
<!--
		<div class="col-sm-5 col-lg-8"> 
			<div class="form-group">								
				<button type="submit" class="btn verification-button">{{ Lang::get('borrower-transcationhistory.export_excel') }}</button>		
			</div>	
		</div>
-->

</div>

<div class="row">
	<div class="col-sm-12"> 
		<div class="table-responsive applyloan" id="transhistory-container"> 
			<table class="table">
				<thead>
					<tr>
						<th class="tab-head text-left"></th>
						<th class="tab-head text-left">{{ Lang::get('borrower-transcationhistory.loan_reference_no') }}</th>
						<th class="tab-head text-left">{{ Lang::get('borrower-transcationhistory.apply_date') }}</th>
						<th class="tab-head text-left">{{ Lang::get('borrower-transcationhistory.bid_closedate') }}</th>
						<th class="tab-head text-right">{{ Lang::get('borrower-transcationhistory.apply_amt') }}</th>
						<th class="tab-head text-right">{{ Lang::get('borrower-transcationhistory.amt_realized') }}</th>
						<th class="tab-head text-right">{{ Lang::get('borrower-transcationhistory.milestone') }}</th>
						
					</tr>
				</thead>
				
				<tbody>
					@if($tranModel->loanList)
					@foreach ($tranModel->loanList as $loanRow)
						<tr id="{{$loanRow->loan_id}}" role="row">
							<td class="text-left"></td>
							<td class="text-left">{{$loanRow->loan_reference_number}}</td>
							<td class="text-left col-sm-2">{{$loanRow->apply_date}}</td>
							<td class="text-left">{{$loanRow->bid_close_date}}</td>
							<td class="text-right">{{$loanRow->apply_amount}}</td>
							<td class="text-right">{{$loanRow->bid_sanctioned_amount}}</td>
							<td class="text-right">{{$loanRow->total_milestone}}</td>
						</tr>		
					
					@endforeach
					@else
					<tr>
						<td>
							No Data Found
						</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
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
	
	// Add event listener for opening and closing transcation details
	$(".details-control").click(function() {
		var loan_id = $(this).parent().attr("id");		
		if($(this).parent().hasClass("shown")){
			$("#"+loan_id).removeClass("shown");
			$("#tran_row_"+loan_id).hide();
		}
		else{
			$("#"+loan_id).addClass("shown");
			$("#tran_row_"+loan_id).show();				
		}
	});
   
}); 
</script>  
@endsection  
@stop
