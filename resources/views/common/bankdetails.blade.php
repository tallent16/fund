@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> 
	<script src="{{ url('js/bankdetails.js') }}" type="text/javascript"></script>	
@endsection
@section('page_heading','Banking') 
@section('status_button')						
		<!--------Status Button Section---->		
			  <h4><span class="label label-default status-label">Status</span></h3>														
@endsection
@section('section') 

<div class="col-sm-12 bank-details space-around"> 
	@if($submitted)
	<div class="row">
		<div class="col-sm-12">
			<div class="annoucement-msg-container">
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						@if($tranType	==	"add")							
							Bank Details added successfully
						@else
							Bank Details updated successfully
						@endif	
				</div>
			</div>
		</div>
	</div>
	@endif
	<div class="row">
		<div class="col-sm-12">	
			<div class="panel panel-primary panel-container">	
						
					<div class="panel-heading panel-headsection"><!--panel head-->
						<div class="row">
							<div class="col-xs-12">
								<span class="pull-left">Bank Details</span> 
							</div>													
						</div>							
					</div><!--end panel head-->
					
					
						@var $bankdetails = $modelbankdet->bankListRs;
						<div class="panel-body applyloan"><!---table start-->
								 <div class="divs">
										
									@var	$i	=	1
									@foreach($bankdetails as $bankdetailRow)
									
										<!--Disable the edit record table when click add button-->
										@var $bankListRow	=	"" 							  
										@if($i	!=1)
											@var $bankListRow	=	"style='display:none'"	
										@endif
										<!---->
										
										<!--Input fields disabled when status is verified-->
											@if ($bankdetailRow->verified_status == BANK_DETAILS_VERIFIED)
											   @var $disablestatus = "disabled"
											@else
											   @var $disablestatus = ""
											@endif
										<!---end-->
										
										<div class="bank-list" id="{{$bankdetailRow->bankid}}"
											{{$bankListRow}}>
											@if($bankdetailRow->verified_status	==	BANK_DETAILS_UNVERIFIED)
												<form method="post">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<input type="hidden" name="transtype" value="edit">
													<input type="hidden" name="bankid" value="{{ $bankdetailRow->bankid }}">
											@endif	
										
										<div class="row">
												<div class="col-sm-12 col-lg-6 input-space">
													<div class="row">		
														<div class="col-xs-4">											
															<label>Bank Code</label>												
														</div>
																			
														<div class="col-xs-8">													
																	<input type="text" 
																	id="bankcode_{{$i}}" 
																	name="bankcode" 
																	value="{{$bankdetailRow->bank_code}}" 
																	class="form-control" 
																	 {{$disablestatus}}/>	
														</div>
													</div>
													
													<div class="row">		
														<div class="col-xs-4">											
															<label>Bank Name</label>												
														</div>
																			
														<div class="col-xs-8">													
																	<input type="text" 
																	id="bankname_{{$i}}" 
																	name="bankname" 
																	value="{{$bankdetailRow->bank_name}}" 
																	class="form-control"
																	 {{$disablestatus}}/>
														</div>
													</div>
													
													<div class="row">		
														<div class="col-xs-4">											
															<label>Branch Code</label>												
														</div>
																			
														<div class="col-xs-8">													
																	<input type="text" 
																	id="branchcode_{{$i}}" 
																	name="branchcode" 
																	value="{{$bankdetailRow->bank_code}}" 
																	class="form-control"
																	{{$disablestatus}}/>
														</div>
													</div>
													
													<div class="row">		
														<div class="col-xs-4">											
															<label>Bank Account Number</label>												
														</div>
																			
														<div class="col-xs-8">													
																	<input type="text" 
																	id="bankaccnumber_{{$i}}" 
																	name="bankaccnumber" 
																	value="{{$bankdetailRow->bank_account_number}}" 
																	class="form-control"
																	{{$disablestatus}} />
														</div>
													</div>
													
													<div class="row">		
														<div class="col-xs-4">											
															<label>Active Status</label>												
														</div>
																			
														<div class="col-xs-8">													
															@if ($bankdetailRow->active_status == BANK_DETAILS_ACTIVE)
															   Active
															@else
															   InActive
															@endif	
														</div>
													</div>
													
													<div class="row">		
														<div class="col-xs-4">											
															<label>Verified Status</label>												
														</div>
																			
														<div class="col-xs-8">													
															@if ($bankdetailRow->verified_status == BANK_DETAILS_VERIFIED)
															   Verified
															@else
															   Unverified
															@endif	
														</div>
													</div>													
													
													
												</div>
												
												<div class="col-sm-6">
												</div>
											</div>										
											
											@if($bankdetailRow->verified_status	==	BANK_DETAILS_UNVERIFIED)
														<div class="pull-right">
															<button type="submit" id="save_button" class="btn button-orange">UPDATE</button>	
														</div>																						
											@endif	
											</form>	
											
										</div>
											@var	$i++
										@endforeach										
								</div>
					</div><!---table end---> 					
				
			</div><!-------panel------>	
		</div>	
	</div>
	<div class="row bankdet-pagi"> 
			<div class="col-sm-12">
				
				<div class="col-sm-6">			
					<ul class="pagination">
						<li>
							<a href="javascript:void(0)" id="prev">
								<i class="fa fa-chevron-circle-left"></i>
							</a>
						</li>
						<li>
							<a href="javascript:void(0)" id="next">
								<i class="fa fa-chevron-circle-right"></i>
								</a>
						</li>	
					</ul>			
				</div>
						
				<div class="col-sm-6">	
					<div class="pull-right">					
						<button type="submit" id="add-bank" class="btn button-orange">ADD</button>	
					</div>				
			</div>
			
		</div>
	</div>		
					
</div><!-----col 12------->

<div style="display:none">
<input type="hidden" id="max_bank" value= "{{ count($modelbankdet->bankListRs) }}" />
	<div  id="bankTemplate">
		<div id="XXX" class="bank-list">
			<form method="post" id="form-bankdetails" name="form-bankdetails" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="transtype" value="add">
				
				<div class="row">
					<div class="col-sm-6 input-space">
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>Bank Code</label>												
							</div>
												
							<div class="col-xs-8">													
										<input type="text" 
										id="bankcode_x" 
										name="bankcode" 													
										class="form-control"
										/>
							</div>
						</div>
						
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>Bank Name</label>												
							</div>
												
							<div class="col-xs-8">													
										<input type="text" 
										id="bankname_x" 
										name="bankname" 													
										class="form-control">
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>Branch Code</label>												
							</div>
												
							<div class="col-xs-8">													
										<input type="text" 
										id="branchcode_x" 
										name="branchcode" 													
										class="form-control">
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>Bank Account Number</label>												
							</div>
												
							<div class="col-xs-8">													
										<input type="text" 
										id="bankaccnumber_x" 
										name="bankaccnumber" 													
										class="form-control">
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>Active Status</label>												
							</div>
												
							<div class="col-xs-8">													
								InActive
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-4">											
								<label>Verified Status</label>												
							</div>
												
							<div class="col-xs-8">													
								Unverified
							</div>
						</div>
						<div class="col-sm-6"></div>
					</div>
				</div>		
							
				<div class="col-sm-12">	 
					<div class="pull-right">
						<button type="submit" id="save_button" class="btn button-orange">SAVE</button>	
					</div>
				</div>
			</form>		
		</div>			
	</div>
	
</div>
@endsection  
@stop 
