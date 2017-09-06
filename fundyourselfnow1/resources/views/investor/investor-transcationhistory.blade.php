@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script> 
	<script src="{{ url('js/borrower-transhistory.js') }}" type="text/javascript"></script> 
@endsection
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 		 
@endsection
@section('page_heading',Lang::get('Transaction History'))
@section('section')    
	@var	$tranList	=	$tranModel->tranList;
	<div class="col-sm-12 space-around">	
	
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
						type="text" filter_field="Yes" class="date-picker form-control" />
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


<div class="row">
	<!--<div class="col-sm-12" >-->
		<div class="col-sm-3 col-lg-2" id="apply_filter_div" >
			<button type="submit" id="filter_invtrans" class="btn verification-button">
				{{ Lang::get('borrower-loanlisting.apply_filter') }}
			</button>
		</div>
</form>

				<!----table----row-->		
		<div class="row">
			<div class="col-sm-12 space-around"> 
				
				<div class="table-responsive applyloan"> 
					<table id="inv_trans" class="table table-striped table-border-custom text-left">
						<thead>
							<tr>
								<th class="tab-head text-left">{{Lang::get('Reference for Clarity')}}</th>
								<th class="tab-head text-left">{{Lang::get('Transaction Date')}}</th>
								<th class="tab-head text-left">{{Lang::get('Transaction Type')}}</th>
								<th class="tab-head text-right">{{Lang::get('Amount')}}</th>
								<th class="tab-head text-left">{{Lang::get('Remarks')}}</th>
								<th class="tab-head text-right">{{Lang::get('Closing Balance')}}</th>																
							</tr>
						</thead>
						<tbody>
							@if(count($tranList) > 0)
								@var	$closingBalance	=	0
								@foreach($tranList[$tranModel->current_inverstor_id] as $tranListRow)
									@var	$closingBalance	=	$closingBalance+(($tranListRow->trans_amount)*($tranListRow->plus_or_minus))
									<tr>
										<td>{{$tranListRow->trans_reference_number}}</td>
										<td>{{$tranListRow->trans_date}}</td>
										<td>{{$tranListRow->trans_type}}</td>
										<td class="text-right">{{number_format($tranListRow->trans_amount,2,'.',',')}}</td>
										<td>{{$tranListRow->remarks}}</td>
										<td class="text-right">{{number_format($tranListRow->balance,2,'.',',')}}</td>											
									</tr>							
								@endforeach
							@endif
						</tbody>
					</table>						
				</div>
				
				</div><!---col-12-->
			</div><!--row-->					
			
	</div><!--col--12-->		
		 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>    
<script>
$(document).ready(function(){ 
	// date picker
	$('.date-picker').datetimepicker({
	autoclose: true, 
	minView: 2,
	format: 'dd/mm/yyyy' 

	}); 
	if(window.location.search) {		  
		$("#inv_trans th:last-child, #inv_trans td:last-child").remove();
	 }
}); 
$("#filter_invtrans").click(function(){
	    
     if(window.location.search) {		  
		$("#inv_trans th:last-child, #inv_trans td:last-child").remove();
	 }
});

</script>  
@endsection  
@stop
