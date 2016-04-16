@extends('layouts.dashboard')
@section('page_heading',Lang::get('Manage Loans') )
@section('section')  
<div class="col-sm-12 space-around">	
	<div class="panel-primary panel-container disburse-loan">
		
			<div class="panel-heading panel-headsection"><!--panel head-->
				<div class="row">
					<div class="col-sm-12">
						<span class="pull-left">{{ Lang::get('DISBURSE LOAN')}}</span> 
					</div>
				</div>					
			</div><!--panel head end-->

			<div class="panel-body applyloan table-border-custom input-space">	
				
				<div class="row"><!-- Row 1 -->					
					<div class="col-xs-12 col-sm-6 col-lg-2">
						<label>
							{{ Lang::get('Loan Reference No')}}
						</label>
					</div>								
					<div class="col-xs-12 col-sm-6 col-lg-3">
						<input 	type="text" 
								class="form-control"
								name="loan_reference_number"
								id="loan_ref_num" 											
								value="{{$bidsModel->loan_reference_number}}" 
								disabled>	
					</div>	
				
					<div class="col-xs-12 col-sm-6 col-lg-2">
						<label>
							{{ Lang::get('Disbursement Date') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-6 col-lg-3 controls">
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
					<div class="col-lg-2">
						
					</div>
				</div> <!-- Row 1 -->
				
				<div class="row"><!-- Row 2 -->	
					<div class="col-xs-12 col-sm-6 col-lg-2">
						<label>
							{{ Lang::get('Sanctioned Amount') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-6 col-lg-3">									
						<input 	type="text" 
								class="form-control text-right"
								name="loan_sanctioned_amount"
								id="loan_sanctioned_amount"
								value=
								"{{number_format($bidsModel->loan_sanctioned_amount, 2, '.', ',')}}"
								disabled>	
					</div>
			
					<div class="col-xs-12 col-sm-6 col-lg-2">
						<label>
							{{ Lang::get('Fixed Fees') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-6 col-lg-3">									
						<input 	type="text" 
								class="form-control text-right"
								name="fixed_fees"												
								id="fixed_fees" 											
								value="150">	
					</div>
					<div class="col-lg-2">
						
					</div>
				</div><!-- Row 2 -->
				
				<div class="row"><!-- Row 3-->			
					<div class="col-xs-12 col-sm-6 col-lg-2">
						<label>
							{{ Lang::get('Processing Fee (%)') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-6 col-lg-3">									
						<input 	type="text" 
								class="form-control text-right"
								name="processing_fee"												
								id="processing_fee" 											
								value="4.00">	
					</div>
					
					<div class="col-xs-12 col-sm-6 col-lg-2">
							<label>{{ Lang::get('Total Fees') }}</label>
					</div>	
					<div class="col-xs-12 col-sm-6 col-lg-3">									
						<input 	type="text" 
								class="form-control text-right"
								name="total_fees"												
								id="total_fees" 											
								value="3750" disabled>	
					</div>	
					<div class="col-lg-2">
						
					</div>			
				</div><!-- Row 3 -->
				
				<div class="row"><!-- Row 4-->
					<div class="col-xs-12 col-sm-6 col-lg-2">
						<label>
							{{ Lang::get('Amount Disbursed') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-6 col-lg-3">									
						<input 	type="text" 
								class="form-control text-right"
								name="amount_disburse"												
								id="amount_disburse" 											
								value="86,250.00" disabled>	
					</div>
								
					<div class="col-xs-12 col-sm-6 col-lg-2">
						<label>
							{{ Lang::get('Payment Reference') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-6 col-lg-3">									
						<input 	type="text" 
								class="form-control"
								name="payment_ref"												
								id="payment_ref" 											
								value="NEFT TRANSFER - A20290">	
					</div>
					<div class="col-lg-2">
						
					</div>
				</div>  <!-- Row 4 -->	
					
				<div class="row">  <!-- Row 5-->				
					<div class="col-xs-12 col-sm-6 col-lg-2">
						<label>	
							{{ Lang::get('Remarks') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-6 col-lg-3">									
						<textarea rows="3" class="form-control" 
								name="remarks" name="remarks"></textarea>	
					</div>					
				</div>  <!-- Row 5 -->		

				<div class="row">		
					<div class="col-xs-12 space-around">
						<button type="button" class="btn verification-button">
							Disburse Loan</button>
					</div>
				</div>
				
			</div><!----panel-body--->
	
	</div><!----panel-container--->
</div>
@endsection  

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

@stop
