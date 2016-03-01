@extends('layouts.transhistory-dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>  
@endsection
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 		 
@endsection
@section('page_heading','Transcation History') 

@section('section')    
<div class="col-sm-12"> 			
	<div class="row">	
		
		<div class="col-sm-12"> 
			<div class="row"> 
				<div class="col-sm-12"> 
				<div class="col-sm-3"> 
					<button type="submit" class="button-black tab-head">ALL</button>			
					<button type="submit" class="button-black tab-head">REPAYMENTS</button>			
					<button type="submit" class="button-black tab-head">FEES</button>			
				</div><!--col--3-->
				
				<div class="col-sm-9 text-right"> 
					
					<div class="col-sm-2">
						<label>START-DATE</label>
					</div>
								
					<div class="col-sm-3">						
						<div class="controls">							
							<div class="input-group">								
								<input id="date-picker-2" type="text" class="date-picker form-control" />
								<label for="date-picker-2" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>
								</label>
							</div>													
						</div>		
					</div>
					
					<div class="col-sm-2">
						<label>END-DATE</label>
					</div>
						
					<div class="col-sm-3">
						<div class="controls">
							<div class="input-group">
								<input id="date-picker-3" type="text" class="date-picker form-control" />
								<label for="date-picker-3" class="input-group-addon btn"><span class="glyphicon glyphicon-calendar"></span>
								</label>
							</div>													
						</div>
					</div>	
					
						
					<div class="col-sm-1">							
						<button type="submit" class="verification-button">GO</button>	
					</div>
							
					<div class="col-sm-1">							
						<button type="submit" class="verification-button">EXPORT</button>	
					</div>
					
				</div><!--col--9-->	
				</div><!--col-12-->			
						
			</div><!--row-->
				
			<div class="row">
				<div class="col-sm-12"> 
					
					<div class="table-responsive applyloan" id="transhistory-container"> 
						<table class="table tab-fontsize">
							<thead>
								<tr>
									<th class="tab-head">LOAN REFERENCE NUMBER</th>
									<th class="tab-head">DATE OF APPLICATION</th>
									<th class="tab-head">DATE OF CLOSURE OF BID</th>
									<th class="tab-head">AMOUNT APPLIED</th>
									<th class="tab-head">AMOUNT BID/REALIZED</th>
									<th class="tab-head">TARGET INTEREST%</th>
									<th class="tab-head">REALIZED INTEREST%</th>
									<th class="tab-head">BALANCE OUTSTANDING</th>									
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>1018</td>
									<td>11 Nov 2016</td>
									<td>26 Nov 2016</td>
									<td>$1,000.00</td>
									<td>$1,000.00</td>
									<td>18%</td>
									<td>10%</td>
									<td>$1,000</td>								
												
								</tr>		
								<tr>
									<td colspan="9">										
										<div class="col-sm-2"></div>
										<div class="col-sm-10">										
											<div class="table-responsive" id="trans-history">
												<table class="table">
													<tr>														
														<th>Transcation Type</th>
														<th>Transcation Date</th>
														<th>Transcation Amount</th>
														<th>Transcation Details</th>
														<th>Balance Outstanding</th>
													</tr>	
													<tr>														
														<td>Disbursement</td>
														<td>25 nov 2016</td>
														<td>$1,000</td>
														<td>-</td>
														<td>-</td>
													</tr>	
												</table>
											</div>	
										</div>									
									</td>
								</tr>
									<tr>
									<td>1018</td>
									<td>11 Nov 2016</td>
									<td>26 Nov 2016</td>
									<td>$1,000.00</td>
									<td>$1,000.00</td>
									<td>18%</td>
									<td>10%</td>
									<td>$1,000</td>													
								</tr>		
								<tr>
									<td colspan="9">									
										<div class="col-sm-2"></div>
										<div class="col-sm-10">										
											<div class="table-responsive" id="trans-history">
												<table class="table">
													<tr>
														<th>Transcation Type</th>
														<th>Transcation Date</th>
														<th>Transcation Amount</th>
														<th>Transcation Details</th>
														<th>Balance Outstanding</th>
													</tr>	
													<tr>														
														<td>Disbursement</td>
														<td>25 nov 2016</td>
														<td>$1,000</td>
														<td>-</td>
														<td>-</td>
													</tr>	
												</table>
											</div>	
										</div>										
									</td>
								</tr>
									<tr>
									<td>1018</td>
									<td>11 Nov 2016</td>
									<td>26 Nov 2016</td>
									<td>$1,000.00</td>
									<td>$1,000.00</td>
									<td>18%</td>
									<td>10%</td>
									<td>$1,000</td>													
								</tr>		
								<tr>
									<td colspan="9">										
										<div class="col-sm-2"></div>
										<div class="col-sm-10">										
											<div class="table-responsive" id="trans-history">
												<table class="table">
													<tr>												
														<th>Transcation Type</th>
														<th>Transcation Date</th>
														<th>Transcation Amount</th>
														<th>Transcation Details</th>
														<th>Balance Outstanding</th>
													</tr>	
													<tr>														
														<td>Disbursement</td>
														<td>25 nov 2016</td>
														<td>$1,000</td>
														<td>-</td>
														<td>-</td>
													</tr>	
												</table>
											</div>	
										</div>									
									</td>
								</tr>
									<tr>
									<td>1018</td>
									<td>11 Nov 2016</td>
									<td>26 Nov 2016</td>
									<td>$1,000.00</td>
									<td>$1,000.00</td>
									<td>18%</td>
									<td>10%</td>
									<td>$1,000</td>												
								</tr>	
								<tr>
									<td colspan="9">										
										<div class="col-sm-2"></div>
										<div class="col-sm-10">										
											<div class="table-responsive" id="trans-history">
												<table class="table">
													<tr>												
														<th>Transcation Type</th>
														<th>Transcation Date</th>
														<th>Transcation Amount</th>
														<th>Transcation Details</th>
														<th>Balance Outstanding</th>
													</tr>	
													<tr>														
														<td>Disbursement</td>
														<td>25 nov 2016</td>
														<td>$1,000</td>
														<td>-</td>
														<td>-</td>
													</tr>	
												</table>
											</div>	
										</div>									
									</td>
								</tr>															
							</tbody>
						</table>						
					</div>
					
				</div><!---col-->
			</div><!--row-->
			
			<!--</div><!--row-->			
			
		</div><!--col--12-->		
		
	<div><!--row-->
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
