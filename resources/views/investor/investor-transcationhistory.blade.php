@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script> 
	<script src="{{ url('js/borrower-transhistory.js') }}" type="text/javascript"></script> 
@endsection
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 		 
@endsection
@section('page_heading',Lang::get('Transcation History'))
@section('section')    
	@var	$tranList	=	$tranModel->tranList;
	<div class="col-sm-12 space-around">	
				<!----table----row-->		
		<div class="row">
			<div class="col-sm-12 space-around"> 
				
				<div class="table-responsive applyloan"> 
					<table class="table table-striped table-border-custom text-left">
						<thead>
							<tr>
								<th class="tab-head text-left">{{Lang::get('Transcation Reference')}}</th>
								<th class="tab-head text-left">{{Lang::get('Transcation Date')}}</th>
								<th class="tab-head text-left">{{Lang::get('Transcation Type')}}</th>
								<th class="tab-head text-right">{{Lang::get('Amount')}}</th>
								<th class="tab-head text-left">{{Lang::get('Remarks')}}</th>
								<th class="tab-head text-right">{{Lang::get('Closing Balance')}}</th>																
							</tr>
						</thead>
						<tbody>
							@if(count($tranList) > 0)
								@var	$closingBalance	=	0
								@foreach($tranList as $tranListRow)
									@var	$closingBalance	=	$closingBalance+(($tranListRow->trans_amount)*($tranListRow->plus_or_minus))
									<tr>
										<td>{{$tranListRow->trans_reference_number}}</td>
										<td>{{$tranListRow->trans_date}}</td>
										<td>{{$tranListRow->trans_type}}</td>
										<td class="text-right">{{number_format($tranListRow->trans_amount,2,'.',',')}}</td>
										<td>{{$tranListRow->remarks}}</td>
										<td class="text-right">{{number_format($closingBalance,2,'.',',')}}</td>											
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
}); 
</script>  
@endsection  
@stop
