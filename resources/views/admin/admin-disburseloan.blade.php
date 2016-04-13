@extends('layouts.dashboard')
@section('bottomscripts')
<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>	 
<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>	
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
@section('page_heading',Lang::get('Manage Loans') )
@section('section')  
<div class="col-sm-12 space-around">	
	<div class="panel-primary panel-container">
		
			<div class="panel-heading panel-headsection"><!--panel head-->
				<div class="row">
					<div class="col-sm-12">
						<span class="pull-left">DISBURSE LOAN</span> 														
					</div>																
				</div>					
			</div><!--panel head end-->

			<div class="panel-body applyloan table-border-custom">	
				<div class="row">	
									
				   <div class="col-md-6 col-xs-12 input-space">					   	
						<div class="row">		
							<div class="col-xs-12 col-sm-5">
								<label>
									{{ Lang::get('Loan Reference Number') }}
								</label>
							</div>	
							<div class="col-xs-12 col-sm-7">									
								<input 	type="text" 
										class="form-control"
										name="loan_ref_num"												
										id="loan_ref_num" 											
										value="L-2016-04" disabled>	
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-12 col-sm-5">
								<label>{{ Lang::get('Sanctioned Amount') }}	</label>
							</div>	
							<div class="col-xs-12 col-sm-7">									
								<input 	type="text" 
										class="form-control text-right"
										name="sanctioned_amount"												
										id="sanctioned_amount" 											
										value="90,000.00" disabled>	
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-12 col-sm-5">
								<label>{{ Lang::get('Processing Fee') }}</label>
							</div>	
							<div class="col-xs-12 col-sm-7">									
								<input 	type="text" 
										class="form-control text-right"
										name="processing_fee"												
										id="processing_fee" 											
										value="4.00">	
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-12 col-sm-5">
								<label>{{ Lang::get('Amount Disbursed') }}</label>
							</div>	
							<div class="col-xs-12 col-sm-7">									
								<input 	type="text" 
										class="form-control text-right"
										name="amount_disburse"												
										id="amount_disburse" 											
										value="86,250.00" disabled>	
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-12 col-sm-5">
								<label>{{ Lang::get('Payment Reference') }}</label>
							</div>	
							<div class="col-xs-12 col-sm-7">									
								<input 	type="text" 
										class="form-control"
										name="payment_ref"												
										id="payment_ref" 											
										value="NEFT TRANSFER - A20290">	
							</div>
						</div>							
					</div>
					
					<div class="col-md-6 col-xs-12 input-space">					   	
						<div class="row">		
							<div class="col-xs-12 col-sm-5">
								<label>{{ Lang::get('Disbursement Date') }}</label>
							</div>	
							<div class="col-xs-12 col-sm-7">															   
								<div class="controls">
									<div class="input-group">
										<input 	id="date-picker" 
												type="text" 
												class="date-picker form-control" 
												name="bid_close_date"
												value="" />
										<label for="date-picker" class="input-group-addon btn">
											<span class="glyphicon glyphicon-calendar"></span>
										</label>
									</div>													
								</div>		
							</div>
						</div>
							
						<div class="row">		
							<div class="col-xs-12 col-sm-5">
								<label>{{ Lang::get('Fixed Fees') }}</label>
							</div>	
							<div class="col-xs-12 col-sm-7">									
								<input 	type="text" 
										class="form-control text-right"
										name="fixed_fees"												
										id="fixed_fees" 											
										value="150">	
							</div>
						</div>
							
						<div class="row">		
							<div class="col-xs-12 col-sm-5">
								<label>{{ Lang::get('Total Fees') }}</label>
							</div>	
							<div class="col-xs-12 col-sm-7">									
								<input 	type="text" 
										class="form-control text-right"
										name="total_fees"												
										id="total_fees" 											
										value="3750" disabled>	
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-12 col-sm-5">
								<label>{{ Lang::get('Remarks') }}</label>
							</div>	
							<div class="col-xs-12 col-sm-7">									
							<textarea rows="3" class="form-control" 
									name="remarks" name="remarks"></textarea>	
							</div>
						</div>							
					</div>
					
				</div><!----row--->
				
				<div class="row">		
					<div class="col-xs-12">
						<button type="button" class="btn verification-button">
							Disburse Loan</button>
					</div>
				</div>
				
			</div><!----panel-body--->
	
	</div><!----panel-container--->
</div>
@endsection  
@stop
