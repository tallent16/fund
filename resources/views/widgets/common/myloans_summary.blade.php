@var	$allowBidInfo	=	"yes"
@if($LoanDetMod->userType	==	USER_TYPE_BORROWER)
	@if(	$LoanDetMod->inv_or_borr_id		==	$LoanDetMod->borrower_id)
		@var	$allowBidInfo	=	"yes"
	@else
		@var	$allowBidInfo	=	"no"
	@endif
@endif
<div class="col-md-12">
	<div class="row">
		<div class="col-md-3 col-sm-4 col-xs-4">
			{{$LoanDetMod->no_of_bidders}}
		</div>
		<div class="col-md-5 col-sm-4 col-xs-4">
			{{number_format($LoanDetMod->total_bid,2,'.',',')}}
		</div>
		<div class="col-md-4 col-sm-4 col-xs-4">
			{{$LoanDetMod->days_to_go}}			
		</div>
	</div>

	<div class="row bidders-value">
		<div class="col-md-3 col-sm-4 col-xs-4">
			{{ Lang::get('borrower-myloans.bidders') }}
		</div>
		<div class="col-md-5 col-sm-4 col-xs-4">
			{{ Lang::get('borrower-myloans.of') }} {{number_format($LoanDetMod->apply_amount,2,'.',',')}} {{ Lang::get('borrower-myloans.goal') }}
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
			<div class="col-md-5 col-xs-5">{{$LoanDetMod->loan_risk_grade}}</div>
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
		@if( ($LoanDetMod->bid_type	==	LOAN_BID_TYPE_OPEN_AUCTION) && 
			($allowBidInfo	==	"yes") )
			<div class="row">
				<div class="col-md-7 col-xs-7"> 
					<i class="fa fa-bar-chart-o "></i><span class="bid-now-section">{{ Lang::get('borrower-myloans.avg_interest_bid') }}:</span>
				</div>
				<div class="col-md-5 col-xs-5">{{$LoanDetMod->avg_int_bid}}</div>
			</div>
		@endif
		
		<div class="row">					
			<div class="col-md-7 col-xs-7"> 
				<i class="fa fa-dollar fa-lg"></i><span class="bid-now-section"> {{ Lang::get('borrower-myloans.amt_bidded') }}:</span>
			</div>
			<div class="col-md-5 col-xs-5">{{number_format($LoanDetMod->total_bid,2,'.',',')}}</div>
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
	@var	$bidCnt				=	count($LoanDetMod->bidDetail)
	<!-- Investor Bid section starts here -->
	@if($LoanDetMod->userType	==	USER_TYPE_INVESTOR)
		@if($LoanDetMod->loan_status	==	LOAN_STATUS_APPROVED)
			<div class="row space-around">
				<div class="text-center">
					<input 	type="hidden" 
							value=""
							id="available_balance" />
					@if($bidCnt	==	0) 
						<button type="button" 
								class="btn verification-button"
								id="bid_now">
								{{Lang::get('BID NOW')}}
							<i class="fa fa-gavel"></i>
						</button>
					@endif
				</div>
			</div>
			@var	$bidTypeStatus	=	""
			@if( isset($LoanDetMod->bidDetail['bid_amount']) )
				@var	$bid_amount	=	$LoanDetMod->bidDetail['bid_amount']
			@else
				@var	$bid_amount	=	"0.00"
			@endif
			
			@if( isset($LoanDetMod->bidDetail['bid_interest_rate']) )
				@var	$bid_interest_rate	=	$LoanDetMod->bidDetail['bid_interest_rate']
			@else
				@var	$bid_interest_rate	=	$LoanDetMod->target_interest
			@endif
			
			@if($LoanDetMod->bid_type	==	LOAN_BID_TYPE_FIXED_INTEREST)
				@var	$bidTypeStatus	=	"readonly"
			@endif
			
			@if( isset($LoanDetMod->bidDetail['bid_id']) )
				@var	$bid_id	=	$LoanDetMod->bidDetail['bid_id']
			@else
				@var	$bid_id	=	''
			@endif
			
			
			<form method="post" id="form-bid" {{($bidCnt	==	0)?"style='display:none'":""}} >
				<input type="hidden" name="_token" value="{{ csrf_token() }}">	
				<input type="hidden" name="bid_id" value="{{ $bid_id }}">	
				<input type="hidden" id="minimum_bid_amount" value="{{number_format($LoanDetMod->min_bid_amount,2,'.',',')}}">	
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
				<input 	type="hidden" 
						id="bid_type"
						value="{{$LoanDetMod->bid_type}}"
						/>
				
				<input 	type="hidden" 
						id="target_interest"
						value="{{$LoanDetMod->target_interest}}"
						/>
				<div class="row space-around">
					<div class="col-md-6 col-xs-6">	
						<strong>{{Lang::get('Bid Amount')}}</strong><br>
						<input 	type="text" 
								name="bid_amount"
								id="bid_amount"
								value="{{$bid_amount}}"
								decimal=2
								class="form-control amount-align">
								
						<input 	type="hidden" 
								name="prev_bid_amount"
								id="prev_bid_amount"
								value="{{$bid_amount}}"
								class="form-control">
					</div>
					<div class="col-md-6 col-xs-6">	
						<strong>{{Lang::get('Bid Interest')}}</strong><br>
						<input 	type="text" 
								name="bid_interest_rate"
								id="bid_interest_rate"
								value="{{$bid_interest_rate}}"
								decimal=2
								class="form-control  amount-align"
								{{$bidTypeStatus}} >
					</div>
				</div>
				<div class="row space-around">
					<div class="col-md-5 col-xs-5">	
						<button type="button" 
								id="submit_bid"
								onclick="LoanBidClicked()"
								class="btn verification-button"
								>{{Lang::get('Submit Bid')}}
						</button>
					</div>
					@if($bidCnt > 0)
						@if( ($LoanDetMod->bidDetail['bid_status'] ==	LOAN_BIDS_STATUS_OPEN)
								|| ($LoanDetMod->bidDetail['bid_status'] ==	LOAN_BIDS_STATUS_ACCEPTED))
							<div class="col-md-5 col-xs-5">	
								<button type="submit" 
										class="btn verification-button"
										id="cancel_bid"
										onclick="cancelLoanBidClicked()">
										{{Lang::get('Cancel Bid')}}
								</button>
							</div>
						@endif
					@endif
				</div>
			</form>
		@endif	
	@endif
	<!-- Investor Bid section ends here -->
	
</div>
