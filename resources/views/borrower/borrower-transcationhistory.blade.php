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
				{{ Form::select('transtype', $tranModel->tranTypeFilter, $tranModel->tranType, ["class" => "selectpicker"]) }} 
			</div>	
		</div>
				
		<div class="col-sm-3"> 														
			<div class="form-group">							
				<strong>{{ Lang::get('From Date') }}</strong><br>							
				<input id="fromdate" name="fromdate" value="{{$tranModel->fromDate}}" 
						type="text" class="date-picker form-control" />
			</div>	
		</div>

		<div class="col-sm-3"> 
			<div class="form-group">								
				<strong>{{ Lang::get('To Date') }}</strong><br>							
				<input id="todate" name="todate" value="{{$tranModel->toDate}}"
						type="text" class="date-picker form-control" />
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
				<button type="submit" class="btn verification-button">{{ Lang::get('Export to Excel') }}</button>		
			</div>	
		</div>

</div>

<div class="row">
	<div class="col-sm-12 space-around"> 
		<div class="table-responsive applyloan" id="transhistory-container"> 
			<table class="table tab-fontsize">
				<thead>
					<tr>
						<th class="tab-head">{{ Lang::get('Loan Reference Number')}}</th>
						<th class="tab-head">{{ Lang::get('Apply Date')}}</th>
						<th class="tab-head">{{ Lang::get('Bid Close Date')}}D</th>
						<th class="tab-head">{{ Lang::get('Apply Amount')}}</th>
						<th class="tab-head">{{ Lang::get('Amount Realized')}}</th>
						<th class="tab-head">{{ Lang::get('Target Interest')}} %</th>
						<th class="tab-head">{{ Lang::get('Realized Interest')}} %</th>
						<th class="tab-head">{{ Lang::get('Balance Outstanding')}}</th>	
					</tr>
				</thead>
				
				<tbody>
					@foreach ($tranModel->loanList as $loanRow)
						<tr>
							<td>{{$loanRow->loan_reference_number}}</td>
							<td>{{$loanRow->apply_date}}</td>
							<td>{{$loanRow->bid_close_date}}</td>
							<td>{{$loanRow->apply_amount}}</td>
							<td>{{$loanRow->bid_sanctioned_amount}}</td>
							<td>{{$loanRow->target_interest}}</td>
							<td>{{$loanRow->final_interest_rate}}</td>
							<td>{{$loanRow->balance_os}}</td>
						</tr>		
						<?php
						$loan_id		= 	$loanRow->loan_id;
						$loanTrans	 	=	$tranModel->tranList[$loan_id];
						?>
						@if (count($loanTrans) > 0)
							<tr>
								<td colspan="9">										
									<div class="col-sm-2"></div>
									<div class="col-sm-10">										
										<div class="table-responsive" id="trans-history">
											<table class="table">
												<tr>														
													<th style="text-align:left">{{ Lang::get('Transcation Type')}}</th>
													<th>{{ Lang::get('Transcation Date')}}</th>
													<th style="text-align:right">{{ Lang::get('Transcation Amount')}}</th>
													<th style="text-align:left">{{ Lang::get('Transcation Details')}}</th>
												</tr>							
												@foreach ($loanTrans as $loanTransRow)
												<tr>
													<td style="text-align:left">{{ Lang::get($loanTransRow->tran_type)}}</td>
													<td>{{$loanTransRow->tran_date}}</td>
													<td style="text-align:right">{{$loanTransRow->tran_amt}}</td>
													<td style="text-align:left">{{ Lang::get($loanTransRow->transdetail)}}</td>
												</tr>
												@endforeach
											</table>
										</div>
									</div>
								</td>
							</tr>
						@endif
					@endforeach
				</tbody>
			</table>
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
