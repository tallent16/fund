@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script> 
	<script src="{{ url('js/borrower-transhistory.js') }}" type="text/javascript"></script> 
@endsection
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 		 
@endsection
@section('page_heading',Lang::get('borrower-transcationhistory.page_heading'))
@section('section')    
<div class="col-sm-12 space-around">
<div id="filter_area" style="display:none">
<form method="get">
	<div class="row">	
		<!--<div class="col-sm-12"> -->
		<div class="col-sm-12 col-lg-3"> 														
			<div class="form-group">	
				<strong>{{ Lang::get('borrower-transcationhistory.filter_transcations')}}</strong><br>	
				{{ Form::select('transtype', $tranModel->tranTypeFilter, $tranModel->tranType, ["class" => "selectpicker"]) }} 
			</div>	
		</div>
				
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group">							
				<strong>{{ Lang::get('borrower-transcationhistory.from_date') }}</strong><br>							
				<input id="fromdate" name="fromdate" value="{{$tranModel->fromDate}}" 
						type="text" class="date-picker form-control" />
			</div>	
		</div>

		<div class="col-sm-6 col-lg-3"> 
			<div class="form-group">								
				<strong>{{ Lang::get('borrower-transcationhistory.to_date') }}</strong><br>							
				<input id="todate" name="todate" value="{{$tranModel->toDate}}"
						type="text" class="date-picker form-control" />
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
		<div class="col-sm-5 col-lg-8"> 
			<div class="form-group">								
				<button type="submit" class="btn verification-button">{{ Lang::get('borrower-transcationhistory.export_excel') }}</button>		
			</div>	
		</div>

</div>

<div class="row">
	<div class="col-sm-12"> 
		<div class="table-responsive applyloan" id="transhistory-container"> 
			<table class="table tab-fontsize">
				<thead>
					<tr>
						<th class="tab-head">{{ Lang::get('borrower-transcationhistory.loan_reference_no') }}</th>
						<th class="tab-head">{{ Lang::get('borrower-transcationhistory.apply_date') }}</th>
						<th class="tab-head">{{ Lang::get('borrower-transcationhistory.bid_closedate') }}</th>
						<th class="tab-head text-right">{{ Lang::get('borrower-transcationhistory.apply_amt') }}</th>
						<th class="tab-head text-right">{{ Lang::get('borrower-transcationhistory.amt_realized') }}</th>
						<th class="tab-head text-right">{{ Lang::get('borrower-transcationhistory.target_interest') }}%</th>
						<th class="tab-head text-right">{{ Lang::get('borrower-transcationhistory.realized_interest') }} %</th>
						<th class="tab-head text-right">{{ Lang::get('borrower-transcationhistory.balance_outstanding') }}</th>	
					</tr>
				</thead>
				
				<tbody>
					@foreach ($tranModel->loanList as $loanRow)
						<tr>
							<td>{{$loanRow->loan_reference_number}}</td>
							<td>{{$loanRow->apply_date}}</td>
							<td>{{$loanRow->bid_close_date}}</td>
							<td class="text-right">{{$loanRow->apply_amount}}</td>
							<td class="text-right">{{$loanRow->bid_sanctioned_amount}}</td>
							<td class="text-right">{{$loanRow->target_interest}}</td>
							<td class="text-right">{{$loanRow->final_interest_rate}}</td>
							<td class="text-right">{{$loanRow->balance_os}}</td>
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
											<table class="table text-left">
												<tr>														
													<th class="text-left">{{ Lang::get('borrower-transcationhistory.trans_type') }}</th>
													<th class="text-left">{{ Lang::get('borrower-transcationhistory.trans_date') }}</th>
													<th class="text-right">{{ Lang::get('borrower-transcationhistory.trans_amt') }}</th>
													<th class="text-left">{{ Lang::get('borrower-transcationhistory.trans_details') }}</th>
												</tr>							
												@foreach ($loanTrans as $loanTransRow)
												<tr>
													<td>{{ Lang::get($loanTransRow->tran_type)}}</td>
													<td>{{$loanTransRow->tran_date}}</td>
													<td class="text-right">{{$loanTransRow->tran_amt}}</td>
													<td>{{ Lang::get($loanTransRow->transdetail)}}</td>
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
