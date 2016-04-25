@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script>		
	$(document).ready(function(){ 
	// date picker
	$('.request_date').datetimepicker({
		autoclose: true, 
		minView: 2,
		format: 'dd-mm-yyyy' 
		}); 	
	$('.settlement_date').datetimepicker({
		autoclose: true, 
		minView: 2,
		format: 'dd-mm-yyyy' 
		}); 
	}); 
	</script>
@endsection
@section('page_heading',Lang::get('Investor Withdrawals') )
@section('section')  
<div class="col-sm-12 space-around">
	<div class="panel-primary panel-container">
		
		<div class="panel-heading panel-headsection"><!--panel head-->
			<div class="row">
				<div class="col-sm-12">
					<span class="pull-left">{{ Lang::get('Enter the Withdrawal Request')}}</span> 
				</div>
			</div>					
		</div><!--panel head end-->

		<div class="panel-body applyloan table-border-custom input-space">	
			
			<div class="row"><!-- Row 1 -->					
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Investor Name')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-3">
					<select >
						<option>Investor1</option>
						<option>Investor2</option>
					</select>	
				</div>	
			
						
			</div> <!-- Row 1 -->
			
			<div class="row"><!-- Row 2 -->					
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Available Balance')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-3">
					<input 	id="avail_bal" 
								type="text" 
								class="avail_bal form-control text-right" 
								name="avail_bal"									
								value="2543.24" 
								disabled />		
				</div>	
			
						
			</div> <!-- Row 2 -->
			
			<div class="row"><!-- Row 3 -->				
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Request Date') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3 controls">
					<div class="input-group">
						<input 	id="request_date" 
								type="text" 
								class="request_date form-control" 
								name="request_date"									
								value="24-04-2016" />

						<label for="request_date" class="input-group-addon btn">
							<span class="glyphicon glyphicon-calendar"></span>
						</label>
					</div>
				</div>	
				
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Settlement Date') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3 controls">
					<div class="input-group">
						<input 	id="settlement_date" 
								type="text" 
								class="settlement_date form-control" 
								name="settlement_date"									
								value="24-04-2016" />

						<label for="settlement_date" class="input-group-addon btn">
							<span class="glyphicon glyphicon-calendar"></span>
						</label>
					</div>
				</div>				
							
					
			</div> <!-- Row 3 -->
			
			<div class="row"><!-- Row 4 -->				
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Withdrawal Amount') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-3">					
						<input 	id="withdrawal_amount" 
								type="text" 
								class="withdrawal_amount form-control text-right" 
								name="withdrawal_amount"									
								value="45232.00" 
								/>						
				</div>							
			</div> <!-- Row 4 -->
						
			
			<div class="row"><!-- Row 5 -->				
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Transcation Reference No') }}
					</label>
				</div>	
				<div class="col-xs-12 col-sm-7 col-lg-5">					
						<input 	id="trans_ref_no" 
								type="text" 
								class="trans_ref_no form-control" 
								name="trans_ref_no"									
								value="NG245" 
								 />						
				</div>
			</div> <!-- Row 5-->
			
			<div class="row"><!-- Row 6-->	
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Remarks')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-5">
					<textarea rows="3" class="form-control">
					</textarea>	
				</div>	
			</div> <!-- Row 6 -->
			
			<div class="row">
				<div class="col-lg-12 space-around">
					<div class="form-group">	
						<button class="btn verification-button">
							{{ Lang::get('Save')}}
						</button>
						<button class="btn verification-button">
							{{ Lang::get('Approve')}}
						</button>
					</div>
				</div>
			</div>			
			
		</div>
		
	</div>				
</div>

@endsection  
@stop
