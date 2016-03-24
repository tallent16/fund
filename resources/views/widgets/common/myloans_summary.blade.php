<div class="col-md-12">
	<div class="row">
		<div class="col-md-3 col-sm-4 col-xs-4">
			{{$LoanDetMod->no_of_bidders}}
		</div>
		<div class="col-md-5 col-sm-4 col-xs-4">
			{{$LoanDetMod->total_bid}}
		</div>
		<div class="col-md-4 col-sm-4 col-xs-4">
			{{$LoanDetMod->days_to_go}}
			<span class="pull-right">
				<i class="fa fa-exclamation-circle"></i>
			</span>
		</div>
	</div>

	<div class="row bidders-value">
		<div class="col-md-3 col-sm-4 col-xs-4">
			{{ Lang::get('borrower-myloans.bidders') }}
		</div>
		<div class="col-md-5 col-sm-4 col-xs-4">
			{{ Lang::get('borrower-myloans.of') }} {{$LoanDetMod->apply_amount}} {{ Lang::get('borrower-myloans.goal') }}
		</div>
		<div class="col-md-4 col-sm-4 col-xs-4">
			{{ Lang::get('borrower-myloans.days_left') }}
		</div>
	</div>
	<div class="row  space-around">	
			<div class="progress">
				<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70"
				aria-valuemin="0" aria-valuemax="100" style="width:{{$LoanDetMod->perc_funded}}%">		
				</div>
			</div>
		</div>	
			
	<div class="row  space-around">	
		<div class="row">												
			<div class="col-md-7 col-xs-7"> 									
				<i class="fa fa-file-text"></i><span class="bid-now-section">{{ Lang::get('borrower-myloans.grade_borrower') }}:</span>
			</div>
			<div class="col-md-5 col-xs-5">{{$LoanDetMod->borrower_risk_grade}}</div>
		</div>
		
		<div class="row">													
			<div class="col-md-7 col-xs-7">									
				<i class="fa fa-database"></i><span class="bid-now-section">{{ Lang::get('borrower-myloans.loan_type') }}:</span>
			</div>
			<div class="col-md-5 col-xs-5">{{$LoanDetMod->repayment_type}}</div>
		</div>
		
		<div class="row">											 		
			<div class="col-md-7 col-xs-7">									
				<i class="fa fa-archive"></i><span class="bid-now-section">{{ Lang::get('borrower-myloans.tenure') }}:</span>
			</div>
			<div class="col-md-5 col-xs-5">{{$LoanDetMod->loan_tenure}}</div>
		</div>
		
		<div class="row">										
			<div class="col-md-7 col-xs-7"> 									
				<i class="fa fa-inr fa-lg"></i><span class="bid-now-section"> {{ Lang::get('borrower-myloans.interest_range') }}:</span>
			</div>
			<div class="col-md-5 col-xs-5">{{$LoanDetMod->target_interest}} %</div>
		</div>
		
		<div class="row">						
			<div class="col-md-7 col-xs-7"> 
				<i class="fa fa-bar-chart-o "></i><span class="bid-now-section">{{ Lang::get('borrower-myloans.avg_interest_bid') }}:</span>
			</div>
			<div class="col-md-5 col-xs-5">{{$LoanDetMod->avg_int_bid}} %</div>
		</div>
		
		<div class="row">					
			<div class="col-md-7 col-xs-7"> 
				<i class="fa fa-dollar fa-lg"></i><span class="bid-now-section"> {{ Lang::get('borrower-myloans.amt_bidded') }}:</span>
			</div>
			<div class="col-md-5 col-xs-5">{{$LoanDetMod->total_bid}}</div>
		</div>
		
		<div class="row">						
			<div class="col-md-7 col-xs-7"> 
				<i class="fa fa-info-circle fa-lg"></i>
				<span class="bid-now-section">
					{{ Lang::get('borrower-loaninfo.status') }}:
				</span>
			</div>
			<div class="col-md-5 col-xs-5">{{$LoanDetMod->statusText}}</div>
		</div>
	</div>	
	<!-- Investor Bid section starts here -->
	@if($LoanDetMod->userType	==	USER_TYPE_INVESTOR)
		@if($LoanDetMod->loan_status	==	LOAN_STATUS_APPROVED)
			<div class="row space-around">
				<div class="text-center">	
					<button type="button" 
							class="btn verification-button"
							id="bid_now">
							{{Lang::get('BID NOW')}}
						<i class="fa fa-gavel"></i>
					</button>
				</div>
			</div>
			@var	$bidCnt				=	count($LoanDetMod->bidDetail)
			@var	$bid_amount			=	isset($LoanDetMod->bidDetail['bid_amount'])?$LoanDetMod->bidDetail['bid_amount']:''
			@if( isset($LoanDetMod->bidDetail['bid_interest_rate']) )
				@var	$bid_interest_rate	=	$LoanDetMod->bidDetail['bid_interest_rate']
			@else
				@var	$bid_interest_rate	=	''
			@endif
			@if( isset($LoanDetMod->bidDetail['bid_id']) )
				@var	$bid_id	=	$LoanDetMod->bidDetail['bid_id']
			@else
				@var	$bid_id	=	''
			@endif
			
			<form method="post" id="form-bid" style="display:none">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">	
				<input type="hidden" name="bid_id" value="{{ $bid_id }}">	
				<input 	type="hidden" 
						name="bid_trantype"
						value="{{($bidCnt	==	0)?'new':'edit'}}"
						/>
				<input 	type="hidden" 
						name="isCancelButton"
						id="isCancelButton"
						value="no"
						/>
				<input 	type="hidden" 
						name="loan_id"
						value="{{$LoanDetMod->loan_id}}"
						/>
				<div class="row space-around">
					<div class="col-md-6 col-xs-6">	
						<strong>{{Lang::get('Bid Amount')}}</strong><br>
						<input 	type="text" 
								name="bid_amount"
								value="{{$bid_amount}}"
								class="form-control">
					</div>
					<div class="col-md-6 col-xs-6">	
						<strong>{{Lang::get('Bid Interest')}}</strong><br>
						<input 	type="text" 
								name="bid_interest_rate"
								value="{{$bid_interest_rate}}"
								class="form-control">
					</div>
				</div>
				<div class="row space-around">
					<div class="col-md-5 col-xs-5">	
						<button type="submit" 
								class="btn verification-button"
								>{{Lang::get('Submit')}}
						</button>
					</div>
					@if($bidCnt > 0)
						@if( ($LoanDetMod->bidDetail['bid_status'] ==	LOAN_BIDS_STATUS_OPEN)
								|| ($LoanDetMod->bidDetail['bid_status'] ==	LOAN_BIDS_STATUS_ACCEPTED))
							<div class="col-md-5 col-xs-5">	
								<button type="submit" 
										class="btn verification-button"
										id="cancel_bid">
										{{Lang::get('Cancel')}}
								</button>
							</div>
						@endif
					@endif
				</div>
			</form>
		@endif	
	@endif
	<!-- Investor Bid section ends here -->
	
	<!-- Borrwer Cancel button	Starts here -->
	@if($LoanDetMod->userType	==	USER_TYPE_BORROWER)
		<div class="row space-around">
			<div class="text-center">	
				@switch($LoanDetMod->loan_status)
					@case(LOAN_STATUS_NEW)
					@case(LOAN_STATUS_SUBMITTED_FOR_APPROVAL)
					@case(LOAN_STATUS_APPROVED)
					@case(LOAN_STATUS_PENDING_COMMENTS)
					@case(LOAN_STATUS_CLOSED_FOR_BIDS)
					@var	$url	='borrower/cancelloan/'.base64_encode($LoanDetMod->loan_id)
						<a 	class="btn btn-lg loan-detail-button" 
							href="{{url($url)}}">
							{{Lang::get('Cancel Loan')}}
						</a>
					@break
					
				@endswitch 
			</div>
		</div>
	@endif
	<!-- Borrwer Cancel button	Ends here -->
</div>
