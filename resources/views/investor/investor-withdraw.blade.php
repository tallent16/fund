@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> 
	<script src="{{ url('js/investor-bank.js') }}" type="text/javascript"></script> 
@endsection
@section('page_heading','Banking') 
@section('section')    
<div class="col-sm-12 space-around bank-details"> 
@if($submitted)
<div class="row">
	<div class="col-sm-12">
		<div class="annoucement-msg-container" id="success-alert">
			<div class="alert alert-success">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{Lang::get('Withdraw Successfully')}}
			</div>
		</div>
	</div>
</div>
@endif			
	<div class="panel panel-primary panel-container">	
				
		<div class="panel-heading panel-headsection"><!--panel head-->
			<div class="row">
				<div class="col-xs-12">
					<span class="pull-left">REQUEST WITHDRAWAL</span> 
				</div>													
			</div>							
		</div><!--end panel head-->
			
		<form method="post" id="withdraw_payment" name="withdraw">
		<input  type="hidden" name="_token" 		 	 value="{{ csrf_token() }}">
		<input 	type="hidden" name="current_investor_id" value="{{$modelwithdraw->current_inverstor_id}}">
		
		<div class="panel-body table-loan">		
			<div class="col-sm-12">	
				<div class="row input-space">
											
					<div class="row">									
						<div class="col-sm-5 col-lg-2 ">
							<label>Available Balance</label>
						</div>
						<div class="col-sm-7 col-lg-3">										
							<input type="text" 
									name="available_bal" 
									id="available_bal"
									value="{{round($modelwithdraw->available_bal,2)}}" 
									class="form-control text-right"
									disabled>
						</div>
						<div class="col-xs-12 col-lg-7">
						</div>							
					</div>		
							
					<div class="row">							
						<div class="col-sm-5 col-lg-2 ">
							<label>Request Date	</label>
						</div>
						<div class="col-sm-7 col-lg-3">
							<input type="text" 
									name="deposit_date" 
									value="{{date('d-m-Y', strtotime($modelwithdraw->depositwithdrawdate))}}" 
									class="form-control"
									disabled>
						</div>
						<div class="col-xs-12 col-lg-7">
						</div>								
					</div>	
					
					<div class="row">						
						<div class="col-sm-5 col-lg-2 ">
							<label class="input-required">Withdraw Amount</label>
						</div>
						<div class="col-sm-7 col-lg-3">
							<input type="text" 
									name="withdraw_amount" 
									value="" 
									id="withdraw_amount"
																	
									class="form-control text-right" required><span class="error">Insufficient Balance</span>
						</div>
						<div class="col-xs-12 col-lg-7">
						</div>							
					</div>
					
					<div class="row">						
						<div class="col-sm-5 col-lg-2 ">
							<label class="input-required">Transaction Reference</label>
						</div>
						<div class="col-sm-7 col-lg-3">
							<input type="text" 
									name="withdraw_trans_refer" 
									value="" 
									class="form-control text-right" required>
						</div>
						<div class="col-xs-12 col-lg-7">
						</div>							
					</div>
					
					<div class="row">								
						<div class="col-sm-5 col-lg-2 ">
							<label>Remarks</label>
						</div>
						<div class="col-sm-7 col-lg-3">
							<textarea rows="3" 
								name="withdraw_remarks" 
								class="form-control">
								</textarea>
						</div>
						<div class="col-xs-12 col-lg-7">
						</div>							
					</div>
						
					<div class="row">							
						<div class="col-lg-2 col-sm-6"></div>
							<div class="col-lg-3 col-sm-6">
								<div class="text-right">							
									<button type="submit" id="withdraw" class="btn button-orange">Submit</button>	
								</div>
							</div>
						<div class="col-lg-7">	</div>							
					</div>	
			
				</div>								
			</div>	
		</div>
		</form>	
	</div>	
</div><!-----col 12------->
@endsection  
@stop 
