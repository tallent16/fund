@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script> 

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
		<div class="table-responsive applyloan" > 
			<table class="table tab-fontsize text-left table-striped table-border-custom">
				<thead>
					<tr>
						<th class="tab-head text-left">{{ Lang::get('borrower-transcationhistory.loan_reference_no') }}</th>
						<th class="tab-head text-left">{{ Lang::get('borrower-transcationhistory.trans_date') }}</th>
						<th class="tab-head text-left">{{ Lang::get('borrower-transcationhistory.trans_type') }}</th>
						<th class="tab-head text-right">{{ Lang::get('borrower-transcationhistory.trans_amt') }}</th>
						<th class="tab-head text-left">{{ Lang::get('borrower-transcationhistory.trans_details') }}</th>
					</tr>
				</thead>
				<tbody>
					@if (count($tranModel->tranList) > 0)
						@foreach ($tranModel->tranList as $loanRow)
							<tr class="odd" id="{{$loanRow->loan_id}}" role="row">
								<td>
									{{$loanRow->loan_reference_number}}
									<i 	class="fa fa-exclamation-circle	 trans_detail_icon" 
										style="cursor:pointer;"
										data-loan-id="{{$loanRow->loan_id}}"></i>
								</td>
								<td>{{$loanRow->tran_date}}</td>
								<td>{{ Lang::get($loanRow->tran_type)}}</td>
								<td class="text-right">{{$loanRow->tran_amt}}</td>
								<td>{{ Lang::get($loanRow->transdetail)}}</td>
							</tr>
						@endforeach		
					@endif
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>

<input type="hidden" name="_token" id="hidden_token" value="{{ csrf_token() }}">	
 @section ('popup-box_panel_title',Lang::get('Transaction Detail'))
	@section ('popup-box_panel_body')
	 <div class="form-horizontal">
		<div class="form-group">
			<div class="col-sm-5 col-md-5">
				{{Lang::get('Loan Reference Number')}}:
			</div>
			<div class="col-sm-7 col-md-7">
				<span id="span_loan_ref_no">
					loan-ref-4
				</span>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-5 col-md-5">
				{{Lang::get('Bid Close Date')}}:
			</div>
			<div class="col-sm-7 col-md-7">
				<span id="span_bid_close_date">
					01-03-2016
				</span>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-5 col-md-5">
				{{Lang::get('Sanctioned Amount')}}:
			</div>
			<div class="col-sm-7 col-md-7">
				<span id="span_sanctioned_amount">
					100000.00
				</span>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-5 col-md-5">
				{{Lang::get('Interest Rate')}}:
			</div>
			<div class="col-sm-7 col-md-7">
				<span id="span_interest_rate">
					10%
				</span>
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-5 col-md-5">
				{{Lang::get('Balance Outstanding')}}:
			</div>
			<div class="col-sm-7 col-md-7">
				<span id="span_balance_outstanding">
					0.00
				</span>
			</div>
		</div>
	</div>
	@endsection
	@include('widgets.modal_box.panel', array(	'id'=>'transaction_detail',
												'aria_labelledby'=>'transaction_detail',
												'as'=>'popup-box',
												'class'=>'',
											))
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
	
	 // Add event listener for opening and closing details
/*
	$( ".details-control" ).click(function() {
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

$(document).ready(function(){ 
	 $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
	});
	$(".trans_detail_icon").on('click',function(){
		$.ajax({
			type        : "POST", // define the type of HTTP verb we want to use (POST for our form)
			url         : "{{url()}}/borrower/ajax/trans_detail", // the url where we want to POST
			data        : {loan_id:$(this).attr("data-loan-id")},
			dataType    : 'json'
		}).done(function(data) {
			showTransDetailPopupFunc(data);
		});
	});
}); 

function showTransDetailPopupFunc(data) {
	$("#span_loan_ref_no").html(data.row.loan_ref_no);
	$("#span_bid_close_date").html(data.row.bid_close_date);
	$("#span_sanctioned_amount").html(data.row.sanctioned_amount);
	$("#span_interest_rate").html(data.row.interest_rate);
	$("#span_balance_outstanding").html(data.row.balance_outstanding);
	$('#transaction_detail').modal('show');
}


</script>  
@endsection  
@stop
