@extends('layouts.dashboard')
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> 
	<script src="{{ url('js/bankdetails.js') }}" type="text/javascript"></script>	
	<script>
		var baseUrl	=	"{{url('')}}"
		$(document).ready(function(){ 	
			$(".jfilestyle").jfilestyle({buttonText: "Upload",buttonBefore: true,inputSize: '110px'});  // file upload  
		}); 
	</script>
	<script src="{{ url('js/jquery-filestyle.min.js') }}" type="text/javascript"></script>	
@endsection
@section('page_heading','Banking') 
@section('section') 
<div class="col-sm-12 bank-details space-around"> 
	@if($submitted)
	<div class="row">
		<div class="col-sm-12">
			<div class="annoucement-msg-container" id="success-alert">
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						@if($tranType	==	"add")							
							{{ Lang::get('Bank Details added successfully') }}
						@else
							{{ Lang::get('Bank Details updated successfully') }}
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
								<span class="pull-left">{{ Lang::get('Bank Details') }}</span> 
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
												<form method="post" id="update_form-{{$bankdetailRow->bankid}}" 
													 enctype="multipart/form-data">
													<input type="hidden" name="_token" value="{{ csrf_token() }}">
													<input type="hidden" name="transtype" value="edit">
													<input type="hidden" name="bankid" value="{{ $bankdetailRow->bankid }}">
											@endif	
										
													<div class="row">		
														<div class="col-xs-12 col-sm-5 col-lg-3">											
															<label  class="input-required"> 
																	{{ Lang::get('Bank Name') }}
															</label>												
														</div>
																			
														<div class="col-xs-12 col-sm-7 col-lg-3" id="bankname_{{$i}}_parent">													
																	<input type="text" 
																			id="bankname_{{$i}}" 
																			name="bankname" 
																			value="{{$bankdetailRow->bank_name}}" 
																			class="form-control required"
																			 {{$disablestatus}}
																			/>
														</div>
													</div>
													
													
													<div class="row">		
														<div class="col-xs-12 col-sm-5 col-lg-3">											
															<label  class="input-required">
																{{ Lang::get('Bank Code') }}
															</label>												
														</div>
																			
														<div class="col-xs-12 col-sm-7 col-lg-3" id="bankcode_{{$i}}_parent">													
																	<input type="text" 
																	id="bankcode_{{$i}}" 
																	name="bankcode" 
																	value="{{$bankdetailRow->bank_code}}" 
																	class="form-control required" 
																	 {{$disablestatus}}/>	
														</div>
													</div>
													
													<div class="row">		
														<div class="col-xs-12 col-sm-5 col-lg-3">											
															<label class="input-required">
																{{ Lang::get('Branch Code') }}
															</label>												
														</div>
																			
														<div class="col-xs-12 col-sm-7 col-lg-3" id="branchcode_{{$i}}_parent">													
																	<input type="text" 
																	id="branchcode_{{$i}}" 
																	name="branchcode" 
																	value="{{$bankdetailRow->branch_code}}" 
																	class="form-control required"
																	{{$disablestatus}}/>
														</div>
													</div>
													
													<div class="row">		
														<div class="col-xs-12 col-sm-5 col-lg-3">											
															<label  class="input-required">
																{{ Lang::get('Bank Account Number') }}
															</label>												
														</div>
																			
														<div 	class="col-xs-12 col-sm-7 col-lg-3" 
																id="bankaccnumber_{{$i}}_parent">													
																	<input type="text" 
																	id="bankaccnumber_{{$i}}" 
																	name="bankaccnumber" 
																	value="{{$bankdetailRow->bank_account_number}}" 
																	class="form-control text-right required"
																	{{$disablestatus}} />
														</div>
													</div>
													
													<div class="row">		
														<div class="col-xs-12 col-sm-5 col-lg-3">											
															<label>{{ Lang::get('Active Status') }}</label>												
														</div>
																			
														<div class="col-xs-12 col-sm-7 col-lg-3">													
															@if ($bankdetailRow->active_status == BANK_DETAILS_ACTIVE)
															<div class="table-border-custom form-control">  Active </div>
															@else
															<div class="table-border-custom form-control">  InActive </div>
															@endif	
														</div>
													</div>
													
													<div class="row">		
														<div class="col-xs-12 col-sm-5 col-lg-3">											
															<label>{{ Lang::get('Verified Status') }}</label>												
														</div>
																			
														<div class="col-xs-12 col-sm-7 col-lg-3">													
															@if ($bankdetailRow->verified_status == BANK_DETAILS_VERIFIED)
															<div class="table-border-custom form-control">   Verified </div>
															@else
															<div class="table-border-custom form-control">    Unverified </div>
															@endif	
																<input type="hidden" 
																		id="verified_status_{{$bankdetailRow->bankid}}" 
																		name="verified_status_{{$bankdetailRow->bankid}}" 
																		value="{{$bankdetailRow->verified_status}}" 
																		/>
														</div>											
												
												
													</div>								
													<div class="row">		
														<div class="col-xs-12 col-sm-5 col-lg-3">											
															<label>{{ Lang::get('Bank Statement') }}</label>												
														</div>
																			
														<div class="col-xs-12 col-sm-7 col-lg-3"  id ="bank_statement_{{$i}}_parent">	
															<input 	type="file" 
																	class="jfilestyle  required attachment" 
																	data-buttonBefore="true" 
																	id="bank_statement_{{$i}}"
																	name="bank_statement"
																	/>
															<input 	type="hidden" 
																	id="bank_statement_{{$i}}_hidden"
																	name="bank_statement_hidden"
																	value="{{ $bankdetailRow->bank_statement_url }}"
																		/>	
															@if($bankdetailRow->bank_statement_url!="")
																@var	$bankUrl	=	url('download/investor/bank/attachment');	
																@var	$bankUrl	=	$bankUrl."/".$bankdetailRow->investor_id."_".rand(10,100);	
																@var	$bankUrl	=	$bankUrl."/".$bankdetailRow->bankid;	
																<a 	href="{{$bankUrl}}"  
																	class="hyperlink">
																	{{basename($bankdetailRow->bank_statement_url)}}
																</a>
															@endif
														</div>											
												
												
													</div>								
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
						<button type="button" id="update_button" class="btn button-orange">{{ Lang::get('UPDATE') }}</button>					
						<button type="button" id="add_button" class="btn button-orange">{{ Lang::get('ADD') }}</button>	
					</div>				
				</div>
			
		</div>
	</div>		
					
</div><!-----col 12------->

<div style="display:none">
<input type="hidden" id="max_bank" value= "{{ count($modelbankdet->bankListRs) }}" />
	<div  id="bankTemplate">
		<div id="XXX" class="bank-list">
			<form method="post" id="form-bankdetails-XXX" name="form-bankdetails" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="transtype" value="add">
				
						<div class="row">		
							<div class="col-xs-12 col-sm-5 col-lg-3">											
								<label  class="input-required"> 
									{{ Lang::get('Bank Name') }}
								</label>												
							</div>
												
							<div class="col-xs-12 col-sm-7 col-lg-3" id="bankname_XXX_parent">													
										<input type="text" 
										id="bankname_XXX" 
										name="bankname" 													
										class="form-control required">
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-12 col-sm-5 col-lg-3">											
								<label  class="input-required"> 
									{{ Lang::get('Bank Code') }}
								</label>												
							</div>
												
							<div class="col-xs-12 col-sm-7 col-lg-3" id="bankcode_XXX_parent">													
										<input type="text" 
										id="bankcode_XXX" 
										name="bankcode" 													
										class="form-control required"
										/>
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-12 col-sm-5 col-lg-3">											
								<label  class="input-required"> 
									{{ Lang::get('Branch Code') }}
								</label>												
							</div>
												
							<div class="col-xs-12 col-sm-7 col-lg-3" id="branchcode_XXX_parent">													
										<input type="text" 
										id="branchcode_XXX" 
										name="branchcode" 													
										class="form-control required">
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-12 col-sm-5 col-lg-3">											
								<label  class="input-required"> 
									{{ Lang::get('Bank Account Number') }}
								</label>												
							</div>
												
							<div class="col-xs-12 col-sm-7 col-lg-3" id="bankaccnumber_XXX_parent">													
										<input type="text" 
										id="bankaccnumber_XXX" 
										name="bankaccnumber" 													
										class="form-control required">
							</div>
						</div>
						
						<div class="row">		
							<div class="col-xs-12 col-sm-5 col-lg-3">											
								<label>
									{{ Lang::get('Active Status') }}
								</label>										
							</div>
												
							<div class="col-xs-12 col-sm-7 col-lg-3">													
							<div class="table-border-custom form-control"> <label>{{ Lang::get('InActive') }}</label>	</div>
							</div>
						</div> 
						
						<div class="row">		
							<div class="col-xs-12 col-sm-5 col-lg-3">											
								<label>{{ Lang::get('Verified Status') }}</label>											
							</div>
												
							<div class="col-xs-12 col-sm-7 col-lg-3">													
							<div class="table-border-custom form-control"> <label>{{ Lang::get('Unverified') }}</label>	</div>
							</div>
						</div>							
						
						<div class="row">		
							<div class="col-xs-12 col-sm-5 col-lg-3">											
								<label>{{ Lang::get('Bank Statement') }}</label>												
							</div>
												
							<div class="col-xs-12 col-sm-7 col-lg-3"  id="bank_statement_XXX_parent">	
								<input 	type="file" 
										class="required attachment" 
										data-buttonBefore="true" 
										name="bank_statement"
										id="bank_statement_XXX"
										/>
								<input 	type="hidden" 
										id="bank_statement_XXX_hidden"
										name="bank_statement_hidden"
										value=""
											/>	
							</div>											
						</div>				
				<div class="col-sm-12">	 
					<div class="pull-right">
						<button type="button" id="save_button_XXX" class="btn verification-button">{{ Lang::get('SUBMIT FOR APPROVAL') }}</button>	
					</div>
				</div>
			</form>		
		</div>			
	</div>
	
</div>
@endsection  
@stop 
