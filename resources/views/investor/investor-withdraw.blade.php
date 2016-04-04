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
		
		<div class="panel-body table-loan">		
			<div class="col-sm-12">	
				<div class="row input-space">
						
						<div class="row">									
									<div class="col-sm-5 col-lg-2 ">
										<span>Invested in Loans</span>
									</div>
									<div class="col-sm-7 col-lg-3">
										<input type="text" name="date_of_request" value="1000" class="form-control">
									</div>
									<div class="col-xs-12 col-lg-7">
									</div>								
						</div>	
						<div class="row">									
									<div class="col-sm-5 col-lg-2 ">
										<span>Reserved for Investments</span>
									</div>
									<div class="col-sm-7 col-lg-3">
										<input type="text" name="amt_avail" value="1000" class="form-control">
									</div>
									<div class="col-xs-12 col-lg-7">
									</div>						
						</div>	
						<div class="row">									
									<div class="col-sm-5 col-lg-2 ">
										<span>Available for investment</span>
									</div>
									<div class="col-sm-7 col-lg-3">
										<input type="text" name="withdraw_amt" value="1000" class="form-control">
									</div>
									<div class="col-xs-12 col-lg-7">
									</div>							
						</div>		
							
						<div class="row">			
										
									<div class="col-sm-5 col-lg-2 ">
										<span>Request Date	</span>
									</div>
									<div class="col-sm-7 col-lg-3">
										<input type="text" name="bank_acc_num" value="1000" class="form-control">
									</div>
									<div class="col-xs-12 col-lg-7">
									</div>	
							
						</div>	
						<div class="row">			
									
									<div class="col-sm-5 col-lg-2 ">
										<span>Withdraw Amount</span>
									</div>
									<div class="col-sm-7 col-lg-3">
										<input type="text" name="date_of_request" value="1000" class="form-control">
									</div>
									<div class="col-xs-12 col-lg-7">
									</div>	
						
						</div>
						
						<div class="row">							
							<div class="col-lg-2 col-sm-6"></div>
								<div class="col-lg-3 col-sm-6">
									<div class="text-right">							
										<button type="submit" class="btn button-orange">Submit</button>	
									</div>
								</div>
							<div class="col-lg-7">	</div>							
						</div>	
				</div>	
							

					
				</div>	
			</div>
	
	</div>
	
</div><!-----col 12------->
@endsection  
@stop 
