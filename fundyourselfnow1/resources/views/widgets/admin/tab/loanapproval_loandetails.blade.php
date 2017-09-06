@var	$par_sub_allowed_yes		=	""
@var	$par_sub_allowed_no			=	""
@var	$par_sub_allowed_disabled	=	"disabled"
@if($adminLoanApprMod->partial_sub_allowed	==	1)
	@var	$par_sub_allowed_yes		=	"checked"
	@var	$par_sub_allowed_disabled	=	""
@else
	@var	$par_sub_allowed_no			=	"checked"
@endif  
@var	$showBidCloseDatePicker	="no"  
@if($adminLoanApprMod->status	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL)
	@if($adminLoanApprMod->comments_count	==	0)
		@var	$showBidCloseDatePicker	="yes"
	@endif
@endif
@var $loanDocuments = $adminLoanApprMod->document_details;
<div id="loan_details" class="tab-pane fade in active">
	<div class="table-responsive">
		<table class="table table-bordered .tab-fontsize text-left">		
			<tbody>
				<tr>
					<td class="tab-left-head col-sm-3">{{ Lang::get('Borrower\'s Name')}}</td>
					<td class="col-sm-3">{{$adminLoanApprMod->firstname}}</td>
					<td class="tab-left-head col-sm-3">{{ Lang::get('Borrower\'s Email')}}</td>
					<td class="col-sm-3">{{$adminLoanApprMod->email}}</td>
				</tr>
				
				<tr>
				<td class="tab-left-head col-sm-3">{{ Lang::get('Contact No')}}</td>	
				<td class="col-sm-3">{{$adminLoanApprMod->contact_person_mobile}}</td>
				<td class="tab-left-head col-sm-3">{{ Lang::get('Loan Amount ')}}</td>
				<td class="col-sm-3">
					<input 	type="text" 
								class="form-control select-width text-right required amount-align"
								name="loan_amount"												
								id="loan_amount" 
								decimal="2"
								{{$commentButtonsVisibe}}
								value="{{number_format($adminLoanApprMod->apply_amount,2,'.',',')}}"
						></td>			
				</tr>
				
				<tr>
					<td class="tab-left-head">{{ Lang::get('Purpose of Loan')}}</td>					
					<td>
						{{ Form::select('purpose_singleline', 
									$adminLoanApprMod->purposeSingleLineInfo, 
									$adminLoanApprMod->purpose_singleline, 
									[	"class" => "selectpicker required",
										"id"=>"purpose_singleline",
										$commentButtonsVisibe]) }}  	
				
					</td>
					<td class="tab-left-head">{{ Lang::get('Bid Close Date')}}</td>								
					<td id="bid_close_date_parent">
					
							<div class="controls">
								<div class="input-group">
									<input 	id="bid_close_date" 
											type="text" 
											class="date-picker form-control required" 
											name="bid_close_date"
											value="{{$adminLoanApprMod->bid_close_date}}"
											{{$disableBidCloseDate}}
											readonly />
									<label for="bid_close_date" class="input-group-addon btn">
										<span class="glyphicon glyphicon-calendar"></span>
									</label>
								</div>													
							</div>	
						
					</td>
				</tr>
				<tr>
					<td class="tab-left-head">{{ Lang::get('Tenure of Loan')}}</td></td>	
					<td>
						{{ Form::select('loan_tenure', $adminLoanApprMod->loan_tenure_list, $adminLoanApprMod->loan_tenure,
																["class" => "selectpicker text-right required",
																"id"=>"loan_tenure",
																$commentButtonsVisibe]
																) 
						}}		
					</td>
					<td class="tab-left-head">{{ Lang::get('Accept Partial Subscription')}}</td>								
					<td>
						<label class="radio-inline">
							<input 	type="radio" 
									name="partial_sub_allowed"
									value="1"
									{{$commentButtonsVisibe}}
									{{$par_sub_allowed_yes}} >
							{{ Lang::get('borrower-applyloan.yes') }}
						</label>
						<label class="radio-inline">
							<input 	type="radio" 
									name="partial_sub_allowed"
									value="2"
									{{$commentButtonsVisibe}}
									{{$par_sub_allowed_no}}>
							{{ Lang::get('borrower-applyloan.no') }}
						</label>
					</td>						
				</tr>
				<tr>
					<td class="tab-left-head">{{ Lang::get('Target Interest')}}%</td>	
					<td>
						<input type="text" class="form-control select-width text-right required amount-align" 
								name="target_interest"												
								id="target_interest"
								decimal="2"	
								{{$commentButtonsVisibe}}														
								value="{{$adminLoanApprMod->target_interest}}" >	
					</td>
					<td class="tab-left-head">{{ Lang::get('Minimum Limit For Partial Subscription')}}</td>								
					<td id="min_for_partial_sub_parent">
						<input 	type="text" 
								class="form-control select-width text-right amount-align"
								 name="min_for_partial_sub"
								 id="min_for_partial_sub"
								 decimal="2"
								 {{$commentButtonsVisibe}}
								 {{$par_sub_allowed_disabled}}
								 value="{{number_format($adminLoanApprMod->min_for_partial_sub,2,'.',',')}}">
				</td>					
				</tr>
				<tr>
					<td class="tab-left-head">{{ Lang::get('Loan Reference Number')}}</td>	
					<td>{{$adminLoanApprMod->loan_reference_number}}</td>	
					<td class="tab-left-head">{{ Lang::get('Payment Type')}}</td>								
					<td><select id="payment_type" 
								name="payment_type" 
								{{$commentButtonsVisibe}}
								class="selectpicker required">
								{{$adminLoanApprMod->paymentTypeSelectOptions}}
						</select>	
					</td>	
				</tr>
				<tr>
					<td class="tab-left-head">{{ Lang::get('Bid Type')}}</td>								
					<td class="col-sm-3">
						<select 	id="bid_type" 
									name="bid_type" 
									{{$commentButtonsVisibe}}
									class="selectpicker required"> 
							{{$adminLoanApprMod->bidTypeSelectOptions}}
						</select>
					</td>	
					<td class="tab-left-head">{{ Lang::get('Status')}}</td>								
					<td>{{ $adminLoanApprMod->statusText}}</td>					
				</tr>	
				<tr>
					<td class="tab-left-head input-required">{{ Lang::get('Credit Grade')}}</td>								
					<td class="col-sm-3 " id="grade_parent">
						@var	$gradeInfo	=	[''=>'none']+$adminLoanApprMod->gradeInfo
					{{ Form::select('grade',$gradeInfo, 
													$adminLoanApprMod->grade, 
													['class' => 'selectpicker text-right',$commentButtonsVisibe,
													'id'=>"grade"])
					}}										
					</td>	
					<td class="tab-left-head text-right" colspan="2">
						<button type="button" 
									class="btn verification-button"
									id="update_bidclosedate_button"
									{{$disableBidCloseDate}} >
								{{ Lang::get('Update Bid Close Date')}}
						</button>
					</td>													
				</tr>				
			</tbody>
		</table>
	</div>	
		
	<div class="col-sm-12">
		@var	$i	=	1
		@foreach($loanDocuments as $documentRow)
			@var	$documentRowIndex	=	$documentRow['loan_doc_id']
				<div class="row">
					<div class="col-sm-8">
						{{ $i.". ".$documentRow['short_name']}}
						<a 	href="#" 
							data-toggle="tooltip" data-placement="top" 
							title="{{$documentRow['doc_name']}}">
							<i class="fa fa-question"></i></a>
					</div>
					<div class="col-sm-3 text-right break-word" id="documents_parent">
						@var	$isDocumentAvailable	=	"no"					
						@if(isset($adminLoanApprMod->submitted_document_details[$documentRowIndex]))
							@var	$loan_url	=	$adminLoanApprMod->submitted_document_details[$documentRowIndex]
							@var	$loan_id	=	$adminLoanApprMod->submitted_document_details[$documentRowIndex]
							@var	$loan_url	=	"admin/loandocdownload/".$loan_url
							{{	basename($adminLoanApprMod->submitted_document_details
																['loan_doc_url'][$documentRowIndex])
							}}
							<input type="hidden" name="documents[]" value="{{$loan_id}}" />
							@var	$isDocumentAvailable	=	"yes"
						@endif	
					</div>
					<div class="col-sm-1 text-right">		
						@if($isDocumentAvailable	==	"yes")		
							<a 	href="javascript:void(0)"
								class="borrower_doc_download"
								data-download-url="{{url($loan_url)}}"
								>{{ Lang::get('View') }}
							</a>
						@endif									
					</div>
				</div>	
			@var	$i++;		
		@endforeach		
	</div>	
</div>
