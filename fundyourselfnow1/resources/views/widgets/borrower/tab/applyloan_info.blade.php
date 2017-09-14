@var	$par_sub_allowed_yes		=	"" 
@var	$par_sub_allowed_no			=	""
@var	$par_sub_allowed_disabled	=	"disabled"
@var	$add_milestone_button			=	""

@if($BorModLoan->partial_sub_allowed	==	1)
	@var	$par_sub_allowed_yes		=	"checked"
	@var	$par_sub_allowed_disabled	=	""
@else
	@var	$par_sub_allowed_no			=	"checked"
@endif  

@if(count($BorModLoan->mileStoneArry) >=3	)
	@var	$add_milestone_button	=	"style='display:none;'"
@endif
@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
	@if($adminLoanApprMod->loan_status	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL)
		@var	$applyLoanTab	=	""
	@else
		@var	$applyLoanTab	=	"disabled"
	@endif
@else
	@var	$applyLoanTab	=	$BorModLoan->viewStatus
@endif

<div id="loans_info" class="tab-pane fade in active">
	<div class="panel panel-default applyloan">   
		<div class="panel-body">	
			<fieldset {{$applyLoanTab}}>	
				@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
					<div class="row">		
						<div class="col-xs-12 col-sm-5 col-lg-3">
							<label>
								{{ Lang::get('Status') }}
							</label>
						</div>	
						<div class="col-xs-12 col-sm-7 col-lg-3">
							{{ $adminLoanApprMod->statusText}}
						</div>
						
						<div class="col-xs-12 col-sm-5 col-lg-3">											
								<label class="input-required">
									{{ Lang::get('Credit Grade') }}
								</label>												
						</div>																
						<div class="col-xs-12 col-sm-7 col-lg-3" id="grade_parent">	
							@var	$gradeInfo	=	[''=>'none']+$adminLoanApprMod->gradeInfo
							{{ Form::select('grade',$gradeInfo, 
															$adminLoanApprMod->grade, 
															['class' => 'selectpicker text-right',$commentButtonsVisibe,
															'id'=>"grade"])
							}}											
						</div>
					</div>
				@endif
				<div class="row">		
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.project_cat') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-3" id="purpose_singleline_parent">															   
						{{ Form::select('purpose_singleline', 
									$BorModLoan->purposeSingleLineInfo, 
									$BorModLoan->purpose_singleline, 
									["class" => "selectpicker required",
																"id"=>"purpose_singleline"]) }}  	
					</div>
					
					<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label class="input-required">
								{{ Lang::get('borrower-applyloan.project_title') }}
							</label>												
					</div>																
					<div class="col-xs-12 col-sm-7 col-lg-3" id="loan_title_parent">													
						<input type="text" class="form-control select-width  required" 
								name="loan_title"												
								id="loan_title"
								value="{{$BorModLoan->loan_title}}" >										
					</div>
				</div>
				<!-- -------------------------------row1-------------------------------------- -->
				<div class="row">		
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label class="input-required">
						{{ Lang::get('borrower-applyloan.project_ref') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-3" id="project_ref_num_parent">
						<input type="text" class="form-control required" 
								name="project_ref_num"												
								id="project_ref_num"
								value="{{$BorModLoan->loan_reference_number}}" >				
					</div>
					
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.funsing_goal') }}
						</label>												
					</div>													
					<div class="col-xs-12 col-sm-7 col-lg-3" id="loan_amount_parent">													
						<input 	type="text" 
								class="form-control select-width text-right required amount-align"
								name="loan_amount"												
								id="loan_amount" 
								decimal="2"
								value="{{$BorModLoan->apply_amount}}"
								{{$applyLoanTab}}>												
					</div>					
				</div>
				<!-- -------------------------------row1-------------------------------------- -->
				<div class="row">		
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.no_of_token') }}
						</label>
					</div>	
					<div class="col-xs-12 col-sm-7 col-lg-3" id=no_of_tokens_parent">
						<input type="text" class="form-control required  amount-align" 
								name="no_of_tokens"												
								id="no_of_tokens"
								decimal="0"
								value="{{$BorModLoan->numberoftokens}}" >				
					</div>
					
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.cost_per_token') }}
						</label>												
					</div>													
					<div class="col-xs-12 col-sm-7 col-lg-3" id="cost_per_token_parent">													
						<input 	type="text" 
								class="form-control select-width text-right required amount-align"
								name="cost_per_token"												
								id="cost_per_token" 
								value="{{$BorModLoan->costpertoken}}"
								readonly >												
					</div>					
				</div>
			</fieldset>	
			
				<!-- ------------------------------row3--------------------------------- -->	
			<fieldset {{$applyLoanTab}}>	
				
				<!-- ------------------------------row4--------------------------------- -->	
				<div class="row">						
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.partial_subsciption') }}
						</label>												
					</div>																	
					<div class="col-xs-12 col-sm-7 col-lg-3" id="payment_type_parent">	<label class="radio-inline">
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
					
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.mini_subscription') }}
						</label>												
					</div>																
					<div class="col-xs-12 col-sm-7 col-lg-3" id="min_for_partial_sub_parent">														 
						<input 	type="text" 
								class="form-control select-width text-right amount-align"
								 name="min_for_partial_sub"
								 id="min_for_partial_sub"
								 decimal="2"
								 {{$par_sub_allowed_disabled}}
								 value="{{$BorModLoan->min_for_partial_sub}}">																				
					</div>
				</div>
				<!-- ------------------------------row5--------------------------------- -->	
				<div class="row">						
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.pre_sale_days') }}
						</label>												
					</div>																	
					<div class="col-xs-12 col-sm-7 col-lg-3" id="pre_duration_parent">	
						<input 	type="text" 
								class="form-control select-width text-right  required  amount-align"
								 name="pre_duration"
								 id="pre_duration"
								  decimal="0"
								 value="{{$BorModLoan->pre_duration}}">									
					</div>	
					
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.pre_sale_start') }}
						</label>												
					</div>																
					<div class="col-xs-12 col-sm-7 col-lg-3" id="pre_start_date_parent">	
						
						<div class="controls">
							<div class="input-group">
								<input 	type="text" 
										id="pre_start_date" 
										name="pre_start_date"
										value="{{ $BorModLoan->pre_start_date }}"
										class="date-picker form-control required"
										 />	
								<label class="input-group-addon btn" for="pre_start_date">
									<span class="glyphicon glyphicon-calendar"></span>
								</label>
							</div>													
						</div>																 
																										
					</div>
				</div>
               <!----crowd seale section -->
               <div class="row">						
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.crowd_sale_days') }}
						</label>												
					</div>																	
					<div class="col-xs-12 col-sm-7 col-lg-3" id="crowd_duration_parent">	
						<input 	type="text" 
								class="form-control select-width text-right  required  amount-align"
								 name="crowd_duration"
								 id="crowd_duration"
								  decimal="0"
								 value="{{$BorModLoan->crowd_duration}}">									
					</div>	
					
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.crowd_sale_date') }}
						</label>												
					</div>																
					<div class="col-xs-12 col-sm-7 col-lg-3" id="fund_start_date_parent">	
						
						<div class="controls">
							<div class="input-group">
								<input 	type="text" 
										id="crowd_start_date" 
										name="crowd_start_date"
										value="{{ $BorModLoan->crowd_start_date }}"
										class="date-picker form-control required"
										 />	
								<label class="input-group-addon btn" for="crowd_start_date">
									<span class="glyphicon glyphicon-calendar"></span>
								</label>
							</div>													
						</div>																 
																										
					</div>
				</div>
				@if(Auth::user()->usertype	==	USER_TYPE_ADMIN && $BorModLoan->contract_address	==	'') 
				<!---add contract address and token address-->
				<div class="row">						
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.Contract_adddress') }}
						</label>												
					</div>																	
					<div class="col-xs-12 col-sm-7 col-lg-3" id="contract_address_parent">			
						<input 	type="text" 
								class="form-control select-width text-right  required"
								 name="contract_address"
								 id="contract_address"
								
								 value="{{$BorModLoan->contract_address}}">									
					</div>	
					
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.wallet_address') }}
						</label>												
					</div>																
				<div class="col-xs-12 col-sm-7 col-lg-3" id="wallet_address_parent">		
					<input 	type="text" 
										id="wallet_address" 
										name="wallet_address"
										value="{{$BorModLoan->wallet_address }}"
										class=" form-control required"
										 />	
																						 
																										
					</div>
				</div>
				@endif 
					@if($BorModLoan->contract_address	!=	'') 
				<!---add contract address and token address-->
				<div class="row">						
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.Contract_adddress') }}
						</label>												
					</div>																	
					<div class="col-xs-12 col-sm-7 col-lg-3" id="contract_address_parent">			
						<input 	type="text" 
								class="form-control select-width text-right  required"
								 name="contract_address"
								 id="contract_address"
								
								 value="{{$BorModLoan->contract_address}}">									
					</div>	
					
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.wallet_address') }}
						</label>												
					</div>																
				<div class="col-xs-12 col-sm-7 col-lg-3" id="token_address_parent">		
					<input 	type="text" 
										id="token_address" 
										name="token_address"
										value="{{$BorModLoan->wallet_address }}"
										class=" form-control required"
										 />	
																						 
																										
					</div>
				</div>
				@endif 
					@if(Auth::user()->usertype	==	USER_TYPE_ADMIN && $BorModLoan->eth_baalance	==	'') 
				<!---add contract address and token address-->
				<div class="row">						
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.eth_bal') }}
						</label>												
					</div>																	
					<div class="col-xs-12 col-sm-7 col-lg-3" id="contract_address_parent">			
						<input 	type="text" 
								class="form-control select-width text-right  required"
								 name="eth_baalance"
								 id="eth_baalance"
								
								 value="{{$BorModLoan->eth_baalance}}">									
					</div>	
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label>
							{{ Lang::get('borrower-applyloan.kyc_varification') }}
						</label>												
					</div>																
				<div class="col-xs-12 col-sm-7 col-lg-3" id="Kyc">		
					<input 	type="checkbox" 
										id="KYC" 
										name="kyc_varify"
										value="1" />	
																						 
																										
					</div>
				</div>
				@endif

<div class="row">	
<?php //echo '<pre>'; print_r($BorModLoan);die; 
	if(!empty($BorModLoan->countries) && $BorModLoan->countries!=''){
		$cechecked = "checked";
	$selectedcountries = explode(",",$BorModLoan->countries);
	}else{
	$selectedcountries = array();
	$cechecked = "";
	}					

?>					
					
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label>
							{{ Lang::get('borrower-applyloan.country_restriction') }}
						</label>												
					</div>																
				<div class="col-xs-12 col-sm-7 col-lg-3" id="Kyc">		
					<input 	type="checkbox" 
										id="country_restriction" 
										name="country_restriction"
										value="" <?php echo "$cechecked"; ?> />	
					
				</div>	
				<div id="restricted_countries" >
				<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label>
							{{ Lang::get('borrower-applyloan.resticted_country') }}
						</label>												
					</div>  
					
					<div class="col-xs-12 col-sm-7 col-lg-3" id="countries">	
				<select class="form-control select-width" multiple="multiple" name="country[]" id="country_name" style="widh:100%;">
														@if(!empty($countries))
														@foreach($countries as $key=>$country)
														<option value="{{$country->id}}" <?php if (in_array($country->id,$selectedcountries)) { echo 'selected'; }?>>{{$country->name}}</option>
														@endforeach
														@endif					
													</select>
													</div>
													</div>

</div>

			
					@if($BorModLoan->eth_baalance	!=	'') 
				<!---add contract address and token address-->
				<div class="row">						
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
								{{ Lang::get('borrower-applyloan.eth_bal') }}
						</label>												
					</div>																	
					<div class="col-xs-12 col-sm-7 col-lg-3" id="contract_address_parent">			
						<input 	type="text" 
								class="form-control select-width text-right  required"
								 name="eth_baalance"
								 id="eth_baalance"
								
								 value="{{$BorModLoan->eth_baalance}}">									
					</div>	
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label>
							{{ Lang::get('borrower-applyloan.kyc_varification') }}
						</label>												
					</div>																
				<div class="col-xs-12 col-sm-7 col-lg-3" id="Kyc">		
					<input 	type="checkbox" 
										id="KYC" 
										name="kyc_varify"
										value="{{$BorModLoan->kyc_varify}} " <?php if($BorModLoan->kyc_varify=='1') { echo 'checked'; }?> />	
					
				</div>
				@endif 


				
				
			

	<!--  ------------- Social Links Section ---------------  -->

		<div class="row">
					<div class="col-xs-12 col-sm-12 col-lg-12">											
						<label>
							<b>{{ Lang::get('borrower-applyloan.social_links') }}:</b>
						</label>												
					</div>	
					
						
				</div>
				
				<div class="row" id="links-container">
					<div class="col-xs-12 col-sm-12 col-lg-12">											
						<div class="table-responsive applyloan"> 
							<table id="links-table" class="table" style="margin-bottom: 10px;">
								<thead>
									<tr >
										<th class="tab-head text-left" width="25%">{{ Lang::get('borrower-applyloan.type')}}</th>
										<th class="tab-head text-left"  width="25%">{{ Lang::get('borrower-applyloan.link') }}</th>
										<th class="tab-head text-left"  width="50%">{{ Lang::get('borrower-applyloan.action') }}</th>
										<!-- <th class="tab-head text-right"  width="20%">{{ Lang::get('% of Disbursal') }}</th>
										@if($applyLoanTab	==	"")
											<th class="tab-head text-center"  width="20%">Action</th>
										@endif -->
									</tr>
								</thead>
								<tbody>	
								@var	$n	=1
									
						@foreach($BorModLoan->socialLinkArry as $key=>$linkRow)
							<tr  id="links_row_{{$n}}" class="links_rows">
								<td>
									<input 	type="hidden" 
											class="form-control select-width text-right"
											name="link_row[id][]"
											id="link_id_{{$n}}"
											 value="{{$key}}">	
												 <div class="select_outer">						
													<select class="form-control select-width" name="link_row[name][]" id="link_name_{{$n}}" style="widh:100%;">
														<option value="">{{ Lang::get('borrower-applyloan.please_select')}}</option>
														<option value="{{ Lang::get('borrower-applyloan.Website')}}" <?php if($linkRow['name']=='Website'){ echo 'selected'; }?>>{{ Lang::get('borrower-applyloan.Website')}}</option>
														<option value="{{ Lang::get('borrower-applyloan.Whitepaper')}}" <?php if($linkRow['name']=='Whitepaper'){ echo 'selected'; }?>>{{ Lang::get('borrower-applyloan.Whitepaper')}}</option>
														<option value="{{ Lang::get('borrower-applyloan.Blog')}}" <?php if($linkRow['name']=='Blog'){ echo 'selected'; }?>>{{ Lang::get('borrower-applyloan.Blog')}}</option>
														<option value="{{ Lang::get('borrower-applyloan.Facebook')}}" <?php if($linkRow['name']=='Facebook'){ echo 'selected'; }?>>{{ Lang::get('borrower-applyloan.Twitter')}}</option>
														<option value="{{ Lang::get('borrower-applyloan.Facebook')}}" <?php if($linkRow['name']=='Twitter'){ echo 'selected'; }?>>{{ Lang::get('borrower-applyloan.Twitter')}}</option>
														<option value="{{ Lang::get('borrower-applyloan.LinkedIn')}}" <?php if($linkRow['name']=='LinkedIn'){ echo 'selected'; }?>>{{ Lang::get('borrower-applyloan.LinkedIn')}}</option>
														<option value="{{ Lang::get('borrower-applyloan.Slack')}}" <?php if($linkRow['name']=='Slack'){ echo 'selected'; }?>>{{ Lang::get('borrower-applyloan.Slack')}}</option>
														<option value="{{ Lang::get('borrower-applyloan.Telegram')}}" <?php if($linkRow['name']=='Telegram'){ echo 'selected'; }?>>{{ Lang::get('borrower-applyloan.Telegram')}}</option>
														<option value="{{ Lang::get('borrower-applyloan.Github')}}" <?php if($linkRow['name']=='Github'){ echo 'selected'; }?>>{{ Lang::get('borrower-applyloan.Github')}}</option>
														<option value="{{ Lang::get('borrower-applyloan.Youtube')}}" <?php if($linkRow['name']=='Youtube'){ echo 'selected'; }?>>{{ Lang::get('borrower-applyloan.Youtube')}}</option>
														<option value="{{ Lang::get('borrower-applyloan.QQ')}}" <?php if($linkRow['name']=='QQ'){ echo 'selected'; }?>>{{ Lang::get('borrower-applyloan.QQ')}}</option>
														<option value="{{ Lang::get('borrower-applyloan.Weibo')}}" <?php if($linkRow['name']=='Weibo'){ echo 'selected'; }?>>{{ Lang::get('borrower-applyloan.Weibo')}}</option>
													</select>
												</div>
											</td>
											<td>
												<input 	type="text" 
														class="form-control select-width"
														name="link_row[link][]"
														id="link_link_{{$n}}"
														value="{{$linkRow['link']}}">	
											</td>
											@if($applyLoanTab	==	"")
												<td class="">
													@if($show_map	==	"yes")
														@if($n	!=	1) 
															<a 	href="javascript:void(0);"
																onclick="delLinkRow({{$n}})"
																style="color:#f6942c;vertical-align: -moz-middle-with-baseline;"
															>
																<i  class="fa fa-remove"
																></i>
															</a>
														@endif
													@endif
												</td>
											@endif
										</tr>
										@var $n++
									@endforeach							
								</tbody>
							</table>
						</div>	
					</div>	
				</div>
				@if($show_map	==	"yes")
					<!-- ------------------------------row8--------------------------------- -->	
				<div class="row" id="add_links_row">
					<div class="col-xs-12 col-sm-12 col-lg-12">											
						<button type="button" 
								class="btn verification-button" 
								onclick="addNewSocialLinkRow()"
					style="margin-left:7px;">
								<i class="fa pull-right"></i>
								{{ Lang::get('borrower-applyloan.add_link') }}
							</button>	
					</div>	
				</div>
				@endif

	
					<div class="row">
					<div class="col-xs-12 col-sm-12 col-lg-12">											
						<label>
							<b>{{ Lang::get('Project Milestones') }}:</b>
						</label>												
					</div>	
					
					<div 	class="col-md-6" 
							id="milestone_error_info"  style="display:none;margin-bottom:10px;">		
							<label 	class="error"
									id="updates_error_label"
							>{{ Lang::get('Sum of the milestone disbursal should be 100% ')}}</label>											
					</div>		
				</div>
				
			 <div class="row" id="milestone-container">
					<div class="col-xs-12 col-sm-12 col-lg-12">											
						<div class="table-responsive applyloan"> 
							<table id="milestone-table" class="table">
								<thead>
									<tr >
										<th class="tab-head text-left" width="20%">{{ Lang::get('Milestone Name')}}</th>
										<th class="tab-head text-left"  width="20%">{{ Lang::get('Milestone Date') }}</th>
										<!-- <th class="tab-head text-right"  width="20%">{{ Lang::get('% of Disbursal') }}</th> -->
										@if($applyLoanTab	==	"")
											<th class="tab-head text-center"  width="20%">Action</th>
										@endif
									</tr>
								</thead>
								<tbody>	
									@var	$i	=1
									
									@foreach($BorModLoan->mileStoneArry as $key=>$mileRow)
										<tr  id="milestone_row_{{$i}}" class="milestone_rows">
											<td>
												<input 	type="hidden" 
														class="form-control select-width text-right"
														name="milstone_row[id][]"
														id="milstone_id_{{$i}}"
														 value="{{$key}}">									
												<input 	type="text" 
														class="form-control select-width"
														name="milstone_row[name][]"
														id="milstone_name_{{$i}}"
														value="{{$mileRow['milestone_name']}}">	
											</td>
											<td>
												<div class="controls">
													<div class="input-group">
														<input 	type="text" 
																name="milstone_row[date][]"
																id="milstone_date_{{$i}}"
																value="{{$mileRow['milestone_date']}}"
																class="date-picker form-control required"
																 />	
														<label class="input-group-addon btn" for="milstone_date_{{$i}}">
															<span class="glyphicon glyphicon-calendar"></span>
														</label>
													</div>													
												</div>			
											</td>
											<?php /*
											<!-- <td>
												<input 	type="text" 
														class="form-control select-width amount-align  text-right "
														name="milstone_row[disbursed][]"
														id="milstone_disbursed_{{$i}}"
														decimal="0"
														value="{{$mileRow['milestone_disbursed']}}" style="float: right;">	
											</td> -->
											*/ ?>
											@if($applyLoanTab	==	"")
												<td class="text-center">
													@if($show_map	==	"yes")
														@if($i	!=	1) 
															<a 	href="javascript:void(0);"
																onclick="delMilestoneRow({{$i}})"
																style="color:#f6942c;vertical-align: -moz-middle-with-baseline;"
															>
																<i  class="fa fa-remove"
																></i>
															</a>
														@endif
													@endif
												</td>
											@endif
										</tr>
										@var $i++
									@endforeach							
								</tbody>
							</table>
						</div>	
					</div>	
				</div> 
<!--
				<div id="milestone-container">
					@var	$i	=1
					@foreach($BorModLoan->mileStoneArry as $key=>$mileRow)
						<div class="row  milestone_rows" id="milestone_row_{{$i}}">						
							<div class="col-xs-12 col-sm-5 col-lg-3">											
								<label id="lbl_milestone_name_{{$i}}">
									{{ Lang::get('Milestone Name').$i }}
								</label>												
							</div>																	
							<div class="col-xs-12 col-sm-7 col-lg-3">	
								<input 	type="hidden" 
										class="form-control select-width text-right"
										name="milstone_row[id][]"
										id="milstone_id_{{$i}}"
										 value="{{$key}}">									
								<input 	type="text" 
										class="form-control select-width"
										name="milstone_row[name][]"
										id="milstone_name_{{$i}}"
										 value="{{$mileRow['milestone_name']}}">									
							</div>	
							
							<div class="col-xs-12 col-sm-5 col-lg-3">											
								<label  id="lbl_milestone_date_{{$i}}">
									{{ Lang::get('Milestone Date').$i }}
								</label>												
							</div>																
							<div class="col-xs-10 col-sm-5 col-lg-2">	
								
								<div class="controls">
									<div class="input-group">
										<input 	type="text" 
												name="milstone_row[date][]"
												id="milstone_date_{{$i}}"
												value="{{$mileRow['milestone_date']}}"
												class="date-picker form-control required"
												 />	
										<label class="input-group-addon btn" for="milstone_date_{{$i}}">
											<span class="glyphicon glyphicon-calendar"></span>
										</label>
									</div>													
								</div>														 
																	
							</div>
							@if($show_map	==	"yes")
								@if($i	!=	1) 
									<div class="col-xs-2 col-sm-2 col-lg-1">	
										<a 	href="javascript:void(0);"
											onclick="delMilestoneRow({{$i}})"
											style="color:#f6942c;vertical-align: -moz-middle-with-baseline;"
										>
											<i  class="fa fa-remove"
											></i>
										</a>
									</div>
								@endif
							@endif
						</div>
						@var $i++
					@endforeach
				</div>
-->
				 @if($show_map	==	"yes")
					
				<div class="row" id="add_milestone_row" {{$add_milestone_button}}>
					<div class="col-xs-12 col-sm-12 col-lg-12">											
						<button type="button" 
								class="btn verification-button" 
								onclick="addNewMilestoneRow()"
								>
								<i class="fa pull-right"></i>
								{{ Lang::get('Add Milestone') }}
							</button>	
					</div>	
				</div>
				@endif 
				<fieldset class="gllpLatlonPicker">
						<!-- ------------------------------row 9--------------------------------- -->	
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-lg-12">	
							<div class="gray_bg">										
								<label>
									{{ Lang::get('borrower-applyloan.project_location') }}
								</label>
							</div>											
						</div>	
					</div>
						<!-- ------------------------------row 10------------------------------ -->	
						
					<div class="row">						
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label>
								{{ Lang::get('borrower-applyloan.location_description') }}
							</label>												
						</div>																	
						<div class="col-xs-12 col-sm-7 col-lg-6">	
							<input 	type="text" 
									class="form-control select-width"
									 name="location_description"
									 id="location_description"
									 value="{{$BorModLoan->location_description}}" 
									 />		
							<input id="find" type="button" value="find" style="display:none;" />							
						</div>	
					</div>
				@if($show_map	==	"yes")		
					<div class="row" style="margin-top:20px;margin-bottom:20px">						
						<div class="col-xs-12 col-sm-12 col-lg-12">	
							 <div id="map" style="width: 100%; height: 400px;"></div>	
							  <div class="clearfix">&nbsp;</div>				
						</div>	
					</div>
					<div class="row">	
											
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label>
								{{ Lang::get('borrower-applyloan.Latitude') }}
							</label>												
						</div>																	
						<div class="col-xs-12 col-sm-7 col-lg-3">	
							<input 	type="text" 
									class="form-control select-width"
									data-geo="lat"
									 name="latitude"
									 id="latitude"
									 readonly
									 value="{{$BorModLoan->latitude}}">									
						</div>	
						
						<div class="col-xs-12 col-sm-5 col-lg-3">											
							<label>
								{{ Lang::get('borrower-applyloan.Longitude') }}
							</label>												
						</div>																
						<div class="col-xs-12 col-sm-7 col-lg-3" id="min_for_partial_sub_parent">														 
							<input 	type="text" 
									class="form-control gllpLongitude"
									 name="longitude"
									 id="longitude"
									 data-geo="lng"
									 readonly
									 value="{{$BorModLoan->longitude}}">																				
						</div>
					</div>
				</fieldset>
				<br>
					<!-- ------------------------------row 11------------------------------- -->	
				<div class="row">						
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.project_image') }}
						</label>												
					</div>																	
					<div class="col-xs-12 col-sm-7 col-lg-3" id="project_image_parent">	
						<input 	type="file" 
								accept="image/*" 
								id="project_image" 
								name="project_image" 
								class="jfilestyle  required choose_btn" 
								>	
						<input 	type="hidden" 
								id="project_image_hidden"
								name="project_image_hidden"
								value="{{ $BorModLoan->loan_image_url }}"
								/>		
						@if($BorModLoan->loan_image_url!="")
							<a href="{{config('moneymatch_settings.image_url') }}{{$BorModLoan->loan_image_url}}" 
								target="_blank" 
								class="hyperlink">
								{{basename($BorModLoan->loan_image_url)}}
							</a>
						@endif							
					</div>	
					
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label>
							{{ Lang::get('borrower-applyloan.project_video') }}
						</label>												
					</div>																
					<div class="col-xs-12 col-sm-7 col-lg-3">	
						
						<input 	type="text" 
								class="form-control"
								id="project_video"
								name="project_video"
								value="{{ $BorModLoan->loan_video_url }}"
								/>	
						<span>{{ Lang::get('borrower-applyloan.video_url') }} <small class="text-muted">{{ Lang::get('borrower-applyloan.url_type') }}</small></span>
					</div>					
				</div>
				<!-- ------------------------------row 12--------------------------------- -->	
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-lg-12">											
						<label>
							<b>{{ Lang::get('borrower-applyloan.project_description') }}:</b>
						</label>												
					</div>	
				</div>
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-lg-12">											
						<textarea	name="project_purpose"
									id="project_purpose" class="tinyTextArea" rows="10"
									>{{$BorModLoan->loan_description}}</textarea>									
					</div>	
				</div>
				@endif
			</fieldset>	
			
		</div><!--panel-body--->
		
	</div><!--panel---->
</div><!--first-tab--->
