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
		
	<div class="col-sm-12 space-around">	
		<div class="row"> 
		
				<!--col-12--->	
				<div class="col-sm-12"> 
					<button type="submit" class="btn button-black tab-head">ALL</button>			
					<button type="submit" class="btn button-black tab-head">REPAYMENTS</button>			
					<button type="submit" class="btn button-black tab-head">FEES</button>			
				</div>
				<!--col--5-->	
				<div class="col-lg-5 space-around"> 
					
					<div class="col-lg-4">
						<label>FROM DATE</label>
					</div>
								
					<div class="col-lg-8">						
						<div class="controls">							
							<div class="input-group">								
								<input id="fromdate" type="text" class="date-picker form-control" />
								<label for="fromdate" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>
								</label>
							</div>													
						</div>		
					</div>
					
				</div>
				<!--col--5-->	
				<div class="col-lg-5 space-around">
					
					<div class="col-lg-4">
						
						<label>TO DATE</label>
					</div>
						
					<div class="col-lg-8">
						<div class="controls">
							<div class="input-group">
								<input id="todate" type="text" class="date-picker form-control" />
								<label for="todate" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>
								</label>
							</div>													
						</div>
					</div>	
				</div>
				<!--col--4-->		
				<div class="col-lg-2 text-right space-around"> 														
						<button type="submit" class="btn verification-button">GO</button>							
						<button type="submit" class="btn verification-button">EXPORT</button>		
				</div>
				<!---all--cols--end--in header-->	
			<!--</div><!--col-12-->			
						
		</div><!--row-->
		<!----table----row-->		
		<div class="row">
			<div class="col-sm-12 space-around"> 
				
				<div class="table-responsive applyloan"> 
					<table class="table tab-fontsize table-striped table-border-custom">
						<thead>
							<tr>
								<th class="tab-head">TRANSCATION REFERENCE</th>
								<th class="tab-head">TRANSCATION DATE</th>
								<th class="tab-head">TRANSCATION TYPE</th>
								<th class="tab-head">AMOUNT</th>
								<th class="tab-head">REMARKS</th>
								<th class="tab-head">CLOSING BALANCE</th>																
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1018</td>
								<td>25 Nov 2016</td>
								<td>Deposits</td>
								<td>$1,000.00</td>
								<td>$1,000.00</td>
								<td>$1,000.00</td>											
							</tr>							
							<tr>
								<td>1019</td>
								<td>25 Nov 2016</td>
								<td>Deposits</td>
								<td>$1,000.00</td>
								<td>$1,000.00</td>
								<td>$1,000.00</td>											
							</tr>
							<tr>
								<td>1020</td>
								<td>25 Nov 2016</td>
								<td>Deposits</td>
								<td>$1,000.00</td>
								<td>$1,000.00</td>
								<td>$1,000.00</td>											
							</tr>
							<tr>
								<td>1021</td>
								<td>25 Nov 2016</td>
								<td>Deposits</td>
								<td>$1,000.00</td>
								<td>$1,000.00</td>
								<td>$1,000.00</td>											
							</tr>
							<tr>
								<td>1022</td>
								<td>25 Nov 2016</td>
								<td>Deposits</td>
								<td>$1,000.00</td>
								<td>$1,000.00</td>
								<td>$1,000.00</td>											
							</tr>
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
