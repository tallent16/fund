@var	$token_reward		=	""
@var	$token_item			=	""
@var	$reward_block	=	""
@var	$item_block	=	""

@if($show_reward_type == "no")
	@var $item_remove = "style='display:none'"
@else
	@var $item_remove = ""
@endif

@if( (isset($trantype)	==	"edit" && $trantype	==	"edit") || $show_map	==	"no" )
	@if($BorModLoan->token_type	==	1)
		@var	$token_reward		=	"checked"
		@var	$item_block	=	"style='display:none'"
		
	@else
		@var	$token_item		=	"checked"
		@var	$reward_block	=	"style='display:none'"
		
	@endif  
@else
		@var	$token_reward		=	"checked"
		@var	$item_block	=	"style='display:none'"
@endif
@if($show_map	==	"yes")
	@var	$divID	=	"documents_submitted"
	@var    $css	= "applyloan"
@else
	@var	$divID	=	"rewards"
	@var    $css	=  ""
@endif

@if(Auth::user())
	@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
		@if($BorModLoan->loan_status	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL)
			@var	$applyLoanRwdTab	=	""
		@else
			@var	$applyLoanRwdTab	=	"disabled"
		@endif
	@else
		@var		$applyLoanRwdTab	=	""
	@endif
@else
		@var	$applyLoanRwdTab	=	$BorModLoan->viewStatus
@endif


<div id="{{$divID}}" class="tab-pane fade">
	<div class="panel panel-default {{$css}}">   
		<div class="panel-body">
			<fieldset {{$applyLoanRwdTab}} >
			<div class="col-sm-12">
				
<!--
				<div class="row" {{$item_remove}}>
					<div class="col-sm-2">
						<label>
							Item Type
						</label>
					</div>
					<div class="col-sm-10">		
					@if($show_map	==	"yes")
						<label class="radio-inline">
							<input 	type="radio" 
									name="item_type"
									value="1"
									{{$token_reward}}
									 >
							{{ Lang::get('Reward Token') }}
						</label>
						<label class="radio-inline">
							<input 	type="radio" 
									name="item_type"
									value="2"
									{{$token_item}}
									>
							{{ Lang::get('Item Token') }}
						</label>	
					@else
						
						@if(!empty($token_reward)) 
							<label>{{ Lang::get('Reward Token') }}</label>
						@else
							<label>{{ Lang::get('Item Token') }}</label>
						@endif
						
					@endif														
					</div>
					
				</div>
-->
				<div class="row" {{$item_remove}}>
					<div class="col-sm-12">		
						&nbsp;&nbsp;
					</div>
				</div>
				<!-- Reward Token Block starts -->
				
				<div class="row" id="reward_token_block">
					@if($show_map	==	"yes")
					<div class="col-sm-12">	
						<input type="button" 
								class="btn verification-button"
								value="Add a new reward"
								onclick="rewardTokenPopupFunc('add',0)" />
					</div>
					@endif
					
					<div class="col-sm-12">		
						&nbsp;&nbsp;
					</div>
				
					<div class="col-sm-12">		
						<div class="table-responsive applyloan"> 
							<table class="table"  id="reward_token_table">
								<thead>
									<tr>
										<th class="tab-head text-left">Token Title</th>
										<th class="tab-head text-right">No of Token</th>
										<th class="tab-head text-left">Token Description</th>
										<th class="tab-head text-right">Token Limit</th>
										<th class="tab-head text-left">Estimate Delivery Date</th>
										@if($applyLoanRwdTab	==	"")
											@if($show_map	==	"yes")
												<th class="tab-head text-left">Action</th>
											@endif
										@endif
									</tr>
								</thead>
								<tbody>
									@if(!empty($BorModLoan->reward_details))
										@var	$i	=	1
										@foreach($BorModLoan->reward_details as $rwdRow)
											@var	$est_delv_date	=	$rwdRow['estimated_delivery_date']
											@if($est_delv_date	===	"0000-00-00 00:00:00")
												@var $est_delv_date	=	""
											@else
												@var	$est_delv_date	=	date('d/m/Y',strtotime($rwdRow['estimated_delivery_date']))
											@endif
												<tr id="rwdrow_{{$i}}">
												
													<td  class="text-left">
														<span id="reward_title_span_{{$i}}">{{$rwdRow['token_title']}}</span>
														<input 	type="hidden" 
																name="reward_row[id][]" 
																id="reward_id_{{$i}}" 
																class="form-control" 
																value="{{$rwdRow['id']}}" 
																 />
														<input 	type="hidden" 
																name="reward_row[title][]" 
																id="reward_title_{{$i}}" 
																class="form-control" 
																value="{{$rwdRow['token_title']}}" 
																 />
													</td>
													<td class="text-right">
														<span id="reward_cost_span_{{$i}}">
														{{number_format($rwdRow['token_cost'], 2, '.', ',')}}
														</span>
														<input 	type="hidden" 
																name="reward_row[cost][]" 
																id="reward_cost_{{$i}}" 
																class="form-control" 
																value="{{number_format($rwdRow['token_cost'], 2, '.', ',')}}" 
																 />
													</td>
													<td class="text-left">
														<span id="reward_desc_span_{{$i}}">{{$rwdRow['token_description']}}</span>
														<textarea name="reward_row[desc][]" 
																id="reward_desc_{{$i}}" 
																class="form-control"
																style="display:none;"
																>{{$rwdRow['token_description']}}</textarea>
													</td>
													<td class="text-right">
														<span id="reward_limit_span_{{$i}}">{{$rwdRow['token_limit']}}</span>
														<input 	type="hidden" 
																name="reward_row[limit][]" 
																id="reward_limit_{{$i}}" 
																class="form-control" 
																value="{{$rwdRow['token_limit']}}" 
																 />
													</td>
													<td class="text-right">
														<span id="reward_estDelDate_span_{{$i}}">{{$est_delv_date}}</span>
														<input 	type="hidden" 
																name="reward_row[estDelDate][]" 
																id="reward_estDelDate_{{$i}}" 
																class="form-control" 
																value="{{$est_delv_date}}" 
																 />
													</td>
													@if($applyLoanRwdTab	==	"")
														@if($show_map	==	"yes")
															<td class="text-left">
																<a 	href="javascript:void(0);"
																	onclick="rewardTokenPopupFunc('edit',{{$i}})"
																>
																	<i  class="fa fa-edit"
																	></i>
																</a>
																<a 	href="javascript:void(0);"
																	onclick="delRewardTokenRow({{$i}})"
																>
																	<i  class="fa fa-remove"
																	></i>
																</a>
															</td>
														@endif
													@endif
												</tr>		
												@var $i++;
										@endforeach
									@else
										<tr class="no_data_row">
											<td colspan="5" >
												No Data Found
											</td>
										</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- Reward Token Block ends -->
				
				<!-- Item Token Block starts -->

				<div class="row" id="item_token_block" {{$item_block}}>
				@if($show_map	==	"yes")
					
						<div class="col-sm-12">	
							<input type="button" 
									class="btn verification-button"
									value="Add a new Item"
									onclick="itemTokenPopupFunc('add',0)" />
						</div>
							<div class="col-sm-12">		
						&nbsp;&nbsp;
					</div>
				@endif
					<div class="col-sm-12">		
						<div class="table-responsive applyloan"> 
							<table class="table"  id="item_token_table">
								<thead>
									<tr>
										<th class="tab-head text-left">Title</th>
										<th class="tab-head text-right">Pledge amount</th>
										<th class="tab-head text-left">Description</th>
										<th class="tab-head text-right">Estimate Delivery Date</th>
										<th class="tab-head text-right">Reward Limit</th>
										@if($show_map	==	"yes")
											<th class="tab-head text-left">Action</th>
										@endif
									</tr>
								</thead>
								<tbody>
									@if(!empty($BorModLoan->item_details))
										@var	$i	=	1
										@foreach($BorModLoan->item_details as $itemRow)
											@var	$est_delv_date	=	$itemRow['token_est_delv_date']
											@if($est_delv_date	===	"0000-00-00 00:00:00")
												@var $est_delv_date	=	""
											@else
												@var	$est_delv_date	=	date('d/m/Y',strtotime($itemRow['token_est_delv_date']))
											@endif
											<tr id="itemrow_{{$i}}">
												
												<td  class="text-left">
													<span id="item_title_span_{{$i}}">{{$itemRow['token_title']}}</span>
													<input 	type="hidden" 
															name="item_row[id][]" 
															id="item_id_{{$i}}" 
															class="form-control" 
															value="{{$itemRow['id']}}" 
															 />
													<input 	type="hidden" 
															name="item_row[title][]" 
															id="item_title_{{$i}}" 
															class="form-control" 
															value="{{$itemRow['token_title']}}" 
															 />
												</td>
												<td class="text-right">
													<span id="item_plgamt_span_{{$i}}">{{
															number_format($itemRow['token_pledge_amount'], 2, '.', ',')}}</span>
													<input 	type="hidden" 
															name="item_row[plgamt][]" 
															id="item_plgamt_{{$i}}" 
															class="form-control" 
															value="{{
															number_format($itemRow['token_pledge_amount'], 2, '.', ',')}}" 
															 />
												</td>
												<td class="text-left">
													<span id="item_desc_span_{{$i}}">{{$itemRow['token_description']}}</span>
													<textarea name="item_row[desc][]" 
															id="item_desc_{{$i}}" 
															style="display:none;"
															class="form-control"
															>{{$itemRow['token_description']}}</textarea>
												</td>
												<td class="text-right">
													<span id="item_estDelDate_span_{{$i}}">{{$est_delv_date}}</span>
													<input 	type="hidden" 
															name="item_row[estDelDate][]" 
															id="item_estDelDate_{{$i}}" 
															class="form-control" 
															value="{{$est_delv_date}}" 
															 />
												</td>
												<td class="text-right">
													<span id="item_limit_span_{{$i}}">{{$itemRow['token_limit']}}</span>
													<input 	type="hidden" 
															name="item_row[limit][]" 
															id="item_limit_{{$i}}" 
															class="form-control" 
															value="{{$itemRow['token_limit']}}" 
															 />
												</td>
												@if($show_map	==	"yes")
													<td class="text-left">
														<a 	href="javascript:void(0);"
															onclick="itemTokenPopupFunc('edit',{{$i}})"
														>
															<i  class="fa fa-edit"
															></i>
														</a>
														<a 	href="javascript:void(0);"
															onclick="delItemTokenRow({{$i}})"
														>
															<i  class="fa fa-remove"
															></i>
														</a>
													</td>
												@endif
											</tr>
											@var $i++;
										@endforeach
									@else
										<tr class="no_data_row">
											<td colspan="6" >
												No Data Found
											</td>
										</tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<!-- Item Token Block ends -->
			</div>								
			</fieldset>
		</div><!---panel body-->
	</div><!---panel------>
</div><!---2nd tab ends-->

@if($show_map	==	"yes")
	@include('partials/reward_item_token_modals')
@endif
