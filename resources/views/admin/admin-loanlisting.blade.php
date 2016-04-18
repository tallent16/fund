@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	@endsection
@section('page_heading',Lang::get('Loan Listing') )
@section('section')  
<div class="col-sm-12 space-around">
<div id="filter_area" style="display:none">
<form method="get">
	<div class="row">	
		
		<div class="col-sm-12 col-lg-3"> 														
			<div class="form-group">	
				<strong>{{ Lang::get('All Transcations')}}</strong><br>	
					 <div class="dropdown selectpicker">
						<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">{{ Lang::get('All')}}
						<span class="caret"></span></button>
						<ul class="dropdown-menu">
						<li><a href="#">{{ Lang::get('New')}}</a></li>
						<li><a href="#">{{ Lang::get('Submitted')}}</a></li>
						<li><a href="#">{{ Lang::get('Comments by Admin')}}</a></li>
						<li><a href="#">{{ Lang::get('Bids Closed')}}</a></li>
						<li><a href="#">{{ Lang::get('Bids Accepted')}}</a></li>
						<li><a href="#">{{ Lang::get('Loan Disbursed')}}</a></li>
						<li><a href="#">{{ Lang::get('Repayment Complete')}}</a></li>
						</ul>
					</div>
				
			</div>	
		</div>
				
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group">							
				<strong>{{ Lang::get('From Date')}}</strong><br>							
				<input id="fromdate" name="fromdate" value="" 
						type="text" class="date-picker form-control" />
			</div>	
		</div>

		<div class="col-sm-6 col-lg-3"> 
			<div class="form-group">								
				<strong>{{ Lang::get('To Date')}}</strong><br>							
				<input id="todate" name="todate" value=""
						type="text" class="date-picker form-control" />
			</div>	
		</div>

		
	</div>
</div>

<div class="row">	
	<!--<div class="col-sm-12" >-->
		<div class="col-sm-3 col-lg-2" id="apply_filter_div" style="display:none">
			<div class="form-group">	
				<button type="submit" class="btn verification-button">
					{{ Lang::get('Apply Filter')}}
				</button>
			</div>
		</div>
</form>
		<div class="col-sm-4 col-lg-2">
			<div class="form-group">	
				<button  id="hide_show_filter" class="btn verification-button" onclick="hideShowFilter()">
					{{ Lang::get('Show Filter')}}
				</button>
			</div>
		</div>
		<!--</div>-->		
</div>


<div class="row">
	<div class="col-sm-12"> 
		<div class="table-responsive applyloan"> 
			<table class="table tab-fontsize table-border-custom" id="open-close">
				<thead>
					<tr>
						<th class="tab-head">{{ Lang::get('Loan Reference Number') }}</th>
						<th class="tab-head">{{ Lang::get('Borrower Organisation Name') }}</th>
						<th class="tab-head text-right">{{ Lang::get('Loan Amount') }}</th>
						<th class="tab-head text-right">{{ Lang::get('Target Interest') }}</th>
						<th class="tab-head text-right">{{ Lang::get('Tenure') }}</th>
						<th class="tab-head">{{ Lang::get('Bid Type') }}</th>
						<th class="tab-head">{{ Lang::get('Bid Close Date') }}</th>
						<th class="tab-head">{{ Lang::get('Status') }}</th>
					</tr>
				</thead>
				<tbody>
					
							<tr class="odd" id="11" role="row">								
								<td>{{ Lang::get('L-125465')}}</td>
								<td>{{ Lang::get('Name')}}</td>
								<td class="text-right">{{ Lang::get('1256558')}}</td>
								<td class="text-right">{{ Lang::get('15%')}}</td>
								<td class="text-right">{{ Lang::get('3')}}</td>
								<td>{{ Lang::get('Closed')}}</td>
								<td>{{ Lang::get('12-04-2016')}}</td>
								<td>{{ Lang::get('Disbursed')}}</td>
							</tr>
							<tr class="odd" id="11" role="row">								
								<td>{{ Lang::get('L-125465')}}</td>
								<td>{{ Lang::get('Name')}}</td>
								<td class="text-right">{{ Lang::get('1256558')}}</td>
								<td class="text-right">{{ Lang::get('15%')}}</td>
								<td class="text-right">{{ Lang::get('3')}}</td>
								<td>{{ Lang::get('Closed')}}</td>
								<td>{{ Lang::get('12-04-2016')}}</td>
								<td>{{ Lang::get('Disbursed')}}</td>
							</tr>
							<tr class="odd" id="11" role="row">								
								<td>{{ Lang::get('L-125465')}}</td>
								<td>{{ Lang::get('Name')}}</td>
								<td class="text-right">{{ Lang::get('1256558')}}</td>
								<td class="text-right">{{ Lang::get('15%')}}</td>
								<td class="text-right">{{ Lang::get('3')}}</td>
								<td>{{ Lang::get('Closed')}}</td>
								<td>{{ Lang::get('12-04-2016')}}</td>
								<td>{{ Lang::get('Disbursed')}}</td>
							</tr>
					
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
	
	// Add event listener for opening and closing transcation details
	/*$(".details-control").click(function() {
		var loan_id = $(this).parent().attr("id");		
		if($(this).parent().hasClass("shown")){
			$("#"+loan_id).removeClass("shown");
			$("#tran_row_"+loan_id).hide();
		}
		else{
			$("#"+loan_id).addClass("shown");
			$("#tran_row_"+loan_id).show();				
		}
	});*/
        
}); 
</script>  
@endsection  
@stop
