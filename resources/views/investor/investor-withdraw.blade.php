@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> 
@endsection
@section('page_heading','Banking') 
@section('status_button')						
		<!--------Status Button Section---->		
			  <h4><span class="label label-default status-label">Status</span></h3>														
@endsection
@section('section')    
<div class="col-sm-12 space-around bank-details"> 			
		<div class="panel panel-primary panel-container">	
					
				<div class="panel-heading panel-headsection"><!--panel head-->
					<div class="row">
						<div class="col-xs-12">
							<span class="pull-left">REQUEST WITHDRAWAL</span> 
						</div>													
					</div>							
				</div><!--end panel head-->
										
				<div class="table-responsive"><!---table start-->
					<table class="table table-loan text-left .tab-fontsizebig">							
						<tbody>
							<tr>
								<td class="tab-left-head col-md-3"><span>Date Of Request</span></td>
								<td class="col-md-3">
									<input type="text" name="date_of_request" value="1000" class="form-control">
								</td>
								<td class="col-md-6"></td>
							</tr>
							<tr>
								<td class="tab-left-head">Amount Available</td>
								<td><input type="text" name="amount_avail" value="50000"  class="form-control"></td>
								<td border="0"></td>
							</tr>
							<tr>
								<td class="tab-left-head">Withdrawal Amount</td>
								<td><input type="text" name="withdrawal amount" value="1000"  class="form-control"></td>
								<td></td>
							</tr>																						
						</tbody>
					</table>							 
				</div><!---table end---> 
			</div><!-------panel------>	
				
			
				<div class="col-sm-12">	
					<div class="text-center">							
						<button type="submit" class="btn button-orange">Submit</button>	
					</div>
					
				</div>
			</div>		
			
			
			
			<div class="col-sm-12">					
				<div class="table-responsive"><!---table start-->
					<table class="table table-loan text-left .tab-fontsizebig">							
						<tbody>
							<tr>
								<td class="tab-left-head col-md-3"><span>Bank Account Number</span></td>
								<td class="col-md-3">
									<input type="text" name="bank_account_num" value="1232465" class="form-control">
								</td>
								<td class="col-md-6"></td>
							</tr>
							<tr>
								<td class="tab-left-head">One time Password</td>
								<td><input type="password" name="one_time_password" value="*******"  class="form-control"></td>
								<td border="0"></td>
							</tr>
							<tr>
								<td class="tab-left-head">Re-type Password</td>
								<td><input type="password" name="retype_password" value="********"  class="form-control"></td>
								<td></td>
							</tr>																						
						</tbody>
					</table>							 
				</div><!---table end---> 
			</div>	
			
				<div class="col-sm-12">	
					<div class="text-center">							
						<button type="submit" class="btn button-orange">Confirm</button>	
					</div>
					
				</div>
			</div>	
	
</div><!-----col 12------->
@endsection  
@stop 
