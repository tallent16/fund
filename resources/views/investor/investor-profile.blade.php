@extends('layouts.dashboard')
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 		 
@endsection
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> 
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>	
	<script src="{{ url('js/investor-profile.js') }}" type="text/javascript"></script>
@endsection
@section('page_heading','Profile') 
@section('section')  		

@if($InvPrfMod->investor_id	==	"")
	@var	$trantype	=	"add"
@else
	@var	$trantype	=	"edit"
@endif
<div class="col-sm-12 space-around"> 
	
		<div class="col-sm-12" style="display:none">
			<div class="annoucement-msg-container">
				<div class="alert alert-danger annoucement-msg">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Comments/remarks
				</div>
			</div>
		</div>
		@if($submitted)
			<div class="row">
				<div class="col-sm-12">
					<div class="annoucement-msg-container">
						<div class="alert alert-success">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
							{{ Lang::get('investor-profile.save') }}
						</div>
					</div>
				</div> 
			</div> 	
		@endif
		<fieldset {{$InvPrfMod->viewStatus}} >
			<form method="post" id="form-profile" name="form-profile">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="trantype" value="{{ $trantype }}">
					<input type="hidden" name="investor_id" value="{{ $InvPrfMod->investor_id }}">
					<input type="hidden" name="investor_bankid" value="{{ $InvPrfMod->investor_bankid }}">
				<div class="col-sm-12 col-lg-12"> 
			
						
					<div class="panel panel-primary panel-container">
						<div class="panel-heading panel-headsection">
							<div class="row">
							   <div class="col-xs-12">
									Profile Info
								</div>									
							</div>                           
						</div><!-------------end of---panel heading---------------------->	
						
						<div class="panel-body table-loan applyloan table-bordered">
							<div class="col-sm-6 input-space">
								
								<div class="row">		
									<div class="col-xs-4">											
										<label>First Name</label>												
									</div>
														
									<div class="col-xs-8">													
											<input type="text" name="firstname" 
											value="{{$InvPrfMod->firstname}}" class="form-control">
									</div>
								</div>
								
								<div class="row">		
									<div class="col-xs-4">											
										<label>Last Name</label>												
									</div>
														
									<div class="col-xs-8">													
											<input type="text" name="lastname" 
											value="{{$InvPrfMod->lastname}}" class="form-control">
									</div>
								</div>
								
								<div class="row">		
									<div class="col-xs-4">											
										<label>Display Name</label>												
									</div>
														
									<div class="col-xs-8">													
											<input type="text" name="displayname" 
											value="{{$InvPrfMod->displayname}}" class="form-control">
									</div>
								</div>
								
								<div class="row">		
									<div class="col-xs-4">											
										<label>Email</label>												
									</div>
														
									<div class="col-xs-8">													
											<input type="text" name="email" 
											value="{{$InvPrfMod->email}}" class="form-control">
									</div>
								</div>
								
								<div class="row">		
									<div class="col-xs-4">											
										<label>Mobile Number</label>												
									</div>
														
									<div class="col-xs-8">													
											<input type="text" name="mobile" 
											value="{{$InvPrfMod->mobile}}" class="form-control">
									</div>
								</div>
								
								<div class="row">		
									<div class="col-xs-4">											
										<label>Date of Birth</label>												
									</div>
														
									<div class="col-xs-8">													
											<div class="controls">
													<div class="input-group">
														<input 	type="text" 
																id="date_of_birth"  
																name="date_of_birth" 
																value="{{$InvPrfMod->date_of_birth}}"
																class="date-picker-2 form-control"
																readonly />	
														<label class="input-group-addon btn" for="dob">
															<span class="glyphicon glyphicon-calendar"></span>
														</label>
													</div>													
												</div>
									</div>
								</div>
								
								<div class="row">		
									<div class="col-xs-4">											
										<label>NRIC Number</label>												
									</div>
														
									<div class="col-xs-8">													
											<input type="text" name="nric_number" 
											value="{{$InvPrfMod->nric_number}}" class="form-control">
									</div>
								</div>
								
							
							</div>
							<div class="col-sm-6 input-space">
										<div class="row">		
									<div class="col-xs-4">											
										<label>Bank Name</label>												
									</div>
														
									<div class="col-xs-8">													
											<input type="text" name="bank_name" 
											value="{{$InvPrfMod->bank_name}}" class="form-control">
									</div>
								</div>
								
											
								<div class="row">		
									<div class="col-xs-4">											
										<label>Bank Account Number</label>												
									</div>
														
									<div class="col-xs-8">													
											<input type="text" name="bank_account_number" 
											value="{{$InvPrfMod->bank_account_number}}" class="form-control">
									</div>
								</div>
								
								<div class="row">		
									<div class="col-xs-4">											
										<label>Bank Code</label>												
									</div>
														
									<div class="col-xs-8">													
											<input type="text" name="bank_code" 
											value="{{$InvPrfMod->bank_code}}" class="form-control">
									</div>
								</div>
								
								<div class="row">		
									<div class="col-xs-4">											
										<label>Branch Code</label>												
									</div>
														
									<div class="col-xs-8">													
											<input type="text" name="branch_code" 
											value="{{$InvPrfMod->branch_code}}" class="form-control">
									</div>
								</div>
						</div>
					</div>	
				</div><!-----panel---> 
			</div><!-----col---> 	     
			<div class="col-sm-12 col-lg-12  ">
				<div class="pull-right">
					<button type="submit" 
						class="btn verification-button"	>
						<i class="fa pull-right"></i>
						Save
					</button>
				</div>
			</div>		
			
		</form>             
   </fieldset>
</div><!-----col--12--->

     
  @endsection  
@stop
