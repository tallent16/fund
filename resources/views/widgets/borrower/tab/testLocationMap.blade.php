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
							{{ Lang::get('Project Category') }}
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
								{{ Lang::get('Project Title') }}
							</label>												
					</div>																
					<div class="col-xs-12 col-sm-7 col-lg-3" id="loan_title_parent">													
						<input type="text" class="form-control select-width  required" 
								name="loan_title"												
								id="loan_title"
								value="{{$BorModLoan->loan_title}}" >										
					</div>
				</div>
				<!---------------------------------row1---------------------------------------->
				<div class="row">		
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label class="input-required">
							{{ Lang::get('Project Ref Number') }}
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
							{{ Lang::get('Funding Goal ETH') }}
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
				<!---------------------------------row1---------------------------------------->
				<div class="row">		
					<div class="col-xs-12 col-sm-5 col-lg-3">
						<label class="input-required">
							{{ Lang::get('No of Tokens') }}
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
							{{ Lang::get('Cost Per Token') }}
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
			
				<!--------------------------------row3----------------------------------->	
			<fieldset {{$applyLoanTab}}>	
				
				<!--------------------------------row4----------------------------------->	
				<div class="row">						
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('borrower-applyloan.accept_partial_sub') }}
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
							{{ Lang::get('borrower-applyloan.minimum_limit') }}
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
				<!--------------------------------row5----------------------------------->	
				<div class="row">						
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('Funding Duration (No of Days)') }}
						</label>												
					</div>																	
					<div class="col-xs-12 col-sm-7 col-lg-3" id="fund_duration_parent">	
						<input 	type="text" 
								class="form-control select-width text-right  required  amount-align"
								 name="fund_duration"
								 id="fund_duration"
								  decimal="0"
								 value="{{$BorModLoan->funding_duration}}">									
					</div>	
					
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('Funding Starting Date') }}
						</label>												
					</div>																
					<div class="col-xs-12 col-sm-7 col-lg-3" id="fund_start_date_parent">	
						
						<div class="controls">
							<div class="input-group">
								<input 	type="text" 
										id="fund_start_date" 
										name="fund_start_date"
										value="{{ $BorModLoan->apply_date }}"
										class="date-picker form-control required"
										 />	
								<label class="input-group-addon btn" for="fund_start_date">
									<span class="glyphicon glyphicon-calendar"></span>
								</label>
							</div>													
						</div>																 
																										
					</div>
				</div>
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
										<th class="tab-head text-right"  width="20%">{{ Lang::get('% of Disbursal') }}</th>
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
											<td>
												<input 	type="text" 
														class="form-control select-width amount-align  text-right "
														name="milstone_row[disbursed][]"
														id="milstone_disbursed_{{$i}}"
														decimal="0"
														value="{{$mileRow['milestone_disbursed']}}">	
											</td>
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
					<!--------------------------------row8----------------------------------->	
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
						<!--------------------------------row 9----------------------------------->	
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-lg-12">											
							<label>
								<b>{{ Lang::get('Project Location') }}:</b>
							</label>												
						</div>	
					</div>
						<!--------------------------------row 10----------------------------------->	
					<div id="ajaxMapContentDiv">
						
					</div>
				</fieldset>
				<br>
					<!--------------------------------row 11----------------------------------->	
				<div class="row">						
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label class="input-required">
							{{ Lang::get('Project Image') }}
						</label>												
					</div>																	
					<div class="col-xs-12 col-sm-7 col-lg-3" id="project_image_parent">	
						<input 	type="file" 
								accept="image/*" 
								id="project_image" 
								name="project_image" 
								class="jfilestyle  required" 
								>	
						<input 	type="hidden" 
								id="project_image_hidden"
								name="project_image_hidden"
								value="{{ $BorModLoan->loan_image_url }}"
								/>		
						@if($BorModLoan->loan_image_url!="")
							<a href="{{url($BorModLoan->loan_image_url)}}" 
								target="_blank" 
								class="hyperlink">
								{{basename($BorModLoan->loan_image_url)}}
							</a>
						@endif							
					</div>	
					
					<div class="col-xs-12 col-sm-5 col-lg-3">											
						<label>
							{{ Lang::get('Project Video') }}
						</label>												
					</div>																
					<div class="col-xs-12 col-sm-7 col-lg-3">	
						
						<input 	type="text" 
								class="form-control"
								id="project_video"
								name="project_video"
								value="{{ $BorModLoan->loan_video_url }}"
								/>	
						<span>Video URL? <small class="text-muted">(YouTube, Vimeo, Vine, Instagram, DailyMotion or Youku)</small></span>
					</div>
				</div>
				<!--------------------------------row 12----------------------------------->	
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-lg-12">											
						<label>
							<b>{{ Lang::get('Purpose of Project') }}:</b>
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
