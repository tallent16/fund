@extends('layouts.dashboard')
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 		 
@endsection
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> 
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>	
	<script src="{{ url('js/borrower-makepayment.js') }}" type="text/javascript"></script>
@endsection
@section('page_heading','Make Payment') 
@section('section')     
	<div class="col-sm-12 space-around"> 			
	
		<div class="panel panel-primary panel-container">
			<div class="panel-heading panel-headsection">
				<div class="row">
				   <div class="col-xs-12">
						Payment Details
					</div>									
				</div>                           
			</div><!-------------end of---panel heading---------------------->	
			
			<div class="table-responsive">				
				<table class="table text-left">					
					<tbody>
						<tr>
							<td class="tab-left-head col-md-3">Loan Reference Number</th>
							<td class="col-md-3">
								<input type="text" name="bank_code" value="1018" class="form-control">
							</td>	
							<td class="col-md-6"></td>																		
						</tr>
						<tr>
							<td class="tab-left-head">Due Date for Repayment</th>						
							<td>
							<div class="controls">
										<div class="input-group">
											<input 	type="text" 
													id="duedate" 
													name="duedate"
													value=""
													class="date-picker form-control"
													readonly />	
											<label class="input-group-addon btn" for="duedate">
												<span class="glyphicon glyphicon-calendar"></span>
											</label>
										</div>													
									</div>
							</td>		
							<td></td>																			
						</tr>	
						<tr>
							<td class="tab-left-head">Amount Due</td>
							<td><input type="text" name="bank_code" value="1000" class="form-control"></td>		
							<td></td>																				
						</tr>	
						<tr>
							<td class="tab-left-head">Penalty</td>
							<td><input type="text" name="bank_code" value="500" class="form-control"></td>	
							<td></td>																					
						</tr>	
						<tr>
							<td class="tab-left-head">Total due</td>		
							<td><input type="text" name="bank_code" value="2000" class="form-control"></td>		
							<td></td>																			
						</tr>										
					</tbody>
				</table>	
				</div>						
			</div><!-----table responsive--->				
			
		</div><!-----panel--->      
		
		
		<div class="col-sm-12">
			<div class="pull-right">
					<button type="submit" 
						class="btn verification-button"	>
					<i class="fa pull-right"></i>
					Submit for Payment
				</button>
			</div>
		</div>		
		             
   
</div><!-----col--12--->

	@endsection  
@stop
