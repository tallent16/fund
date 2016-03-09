@var	$par_sub_allowed_yes	=	""
@var	$par_sub_allowed_no		=	""

@if($BorModLoan->partial_sub_allowed	==	1)
	@var	$par_sub_allowed_yes		=	"checked"
@else
	@var	$par_sub_allowed_no			=	"checked"
@endif  
<div id="loans_info" class="tab-pane fade in active">
	<div class="panel panel-default applyloan">   
		<div class="panel-body">
				<div class="row">
				   <div class="col-md-6">
						<h4>{{ Lang::get('borrower-applyloan.purpose_of_loan') }}</h4>														   
							<textarea 	id="laon_purpose"
										name="laon_purpose">{{$BorModLoan->purpose}}</textarea> 					
					</div>
					   
					<div class="col-md-6">	
							<div class="row">		
								<div class="col-xs-4">											
									<label>{{ Lang::get('borrower-applyloan.loan_amount') }}</label>												
								</div>
													
								<div class="col-xs-8">													
									<input 	type="text" 
											class="form-control select-width"
											name="loan_amount"												
											id="loan_amount" 
											value="{{$BorModLoan->apply_amount}}">												
								</div>
							</div>
						
							<div class="row">		
								<div class="col-xs-4">											
									<label>{{ Lang::get('borrower-applyloan.loan_tenure') }}</label>												
								</div>
															
								<div class="col-xs-8">													
									<input 	type="text" 
											class="form-control select-width"
											name="loan_tenure"												
											id="loan_tenure"
											value="{{$BorModLoan->loan_tenure}}" >												
								</div>
							</div>
						
							<div class="row">		
								<div class="col-xs-4">											
									<label>{{ Lang::get('borrower-applyloan.target_int') }}</label>												
								</div>
															
								<div class="col-xs-8">													
									<input type="text" class="form-control select-width" 
											name="target_interest"												
											id="target_interest"
											value="{{$BorModLoan->target_interest}}" >																	
								</div>
							</div>
						
							<div class="row">		
								<div class="col-xs-4">											
									<label>{{ Lang::get('borrower-applyloan.bid_type') }}</label>												
								</div>
															
								<div class="col-xs-8">													
									<select 	id="bid_type" 
												name="bid_type" 
												class="selectpicker"> 
										{{$BorModLoan->bidTypeSelectOptions}}
									</select>												
								</div>
							</div>
						
							<div class="row">		
								<div class="col-xs-4">											
									<label>{{ Lang::get('borrower-applyloan.bid_close_date') }}</label>												
								</div>
															
								<div class="col-xs-8">																									 
									<div class="controls">
										<div class="input-group">
											<input 	id="date-picker-2" 
													type="text" 
													class="date-picker form-control" 
													name="bid_close_date"
													value="{{$BorModLoan->bid_close_date}}" />
											<label for="date-picker-2" class="input-group-addon btn">
												<span class="glyphicon glyphicon-calendar"></span>
											</label>
										</div>													
									</div>																			
								</div>
							</div>
						
							<div class="row">		
								<div class="col-xs-4">											
									<label>{{ Lang::get('borrower-applyloan.accept_partial_sub') }}</label>												
								</div>
															
								<div class="col-xs-8">														 
									<label class="radio-inline">
										<input 	type="radio" 
												name="partial_sub_allowed"
												value="1"
												{{$par_sub_allowed_yes}} >
										{{ Lang::get('borrower-applyloan.yes') }}
									</label>
									<label class="radio-inline">
										<input 	type="radio" 
												name="partial_sub_allowed"
												value="2"
												{{$par_sub_allowed_no}}>
										{{ Lang::get('borrower-applyloan.no') }}
									</label>
																							
								</div>
							</div>	
							
							<div class="row">		
								<div class="col-xs-4">											
									<label>{{ Lang::get('borrower-applyloan.minimum_limit') }}</label>												
								</div>
															
								<div class="col-xs-8">														 
									<input 	type="text" 
											class="form-control select-width"
											 name="min_for_partial_sub"
											 value="{{$BorModLoan->min_for_partial_sub}}">	
																							
								</div>
							</div>	
						
							<div class="row">		
								<div class="col-xs-4">											
									<label>{{ Lang::get('borrower-applyloan.payment_type') }}</label>												
								</div>
															
								<div class="col-xs-8">						 							
									<select id="payment_type" 
											name="payment_type" 
											class="selectpicker">
											{{$BorModLoan->paymentTypeSelectOptions}}
									</select>												
								</div>
							</div>
					<!--<div class="panel-primary panel-container">
							<div class="panel-heading panel-headsection"><!--panel head-->
							<!---<div class="row">
									<div class="col-sm-12">
										<span class="pull-left">{{ Lang::get('borrower-applyloan.loan_summary') }}</span> 
									</div>																
								</div>							
							</div>
						</div>
							
						<div class="table-responsive"><!---table start-->
						<!--	<table class="table table-bordered .tab-fontsize text-left">		
								<tbody>
									<tr>
										<td class="col-md-3">{{ Lang::get('borrower-applyloan.purpose_of_loan') }}</td>
										<td class="col-md-3">To increase our current car fleet for personal and corporate services.</td>		
									</tr>
									<tr>
										<td class="col-md-3">{{ Lang::get('borrower-applyloan.loan_amount') }}</td>
										<td class="col-md-3">$1,000,00</td>		
									</tr>
									<tr>
										<td class="col-md-3">{{ Lang::get('borrower-applyloan.loan_tenure') }}</td>
										<td class="col-md-3">12</td>		
									</tr>
										<tr>
										<td class="col-md-3">{{ Lang::get('borrower-applyloan.target_int') }}</td>
										<td class="col-md-3">10%</td>		
									</tr>
										<tr>
										<td class="col-md-3">{{ Lang::get('borrower-applyloan.bid_type') }}</td>
										<td class="col-md-3">Open bidding</td>		
									</tr>
										<tr>
										<td class="col-md-3">{{ Lang::get('borrower-applyloan.bid_close_date') }}</td>
										<td class="col-md-3">01 JAN 2016</td>		
									</tr>	
										<tr>
										<td class="col-md-3">{{ Lang::get('borrower-applyloan.accept_partial_sub') }}</td>
										<td class="col-md-3">YES</td>		
									</tr>	
									<tr>
										<td class="col-md-3">{{ Lang::get('borrower-applyloan.minimum_limit') }}</td>
										<td class="col-md-3">$1,000,00</td>		
									</tr>
									<tr>
										<td class="col-md-3">{{ Lang::get('borrower-applyloan.payment_type') }}</td>
										<td class="col-md-3">One Time or Bullet</td>		
									</tr>													
								</tbody>
							</table>
						</div>
															
						<div class="row">							
							<div class="col-sm-12"> 
								<div class="pull-right">	
									<button type="submit" class="add-director-button">{{ Lang::get('borrower-applyloan.next') }}</button>
								</div>
							</div>
						</div>--->
						
					</div><!--col--->									   								   
				</div><!--row-->	
		</div><!--panel-body--->
	</div><!--panel---->
</div><!--first-tab--->
