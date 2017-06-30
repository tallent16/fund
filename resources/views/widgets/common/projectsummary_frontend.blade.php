@var	$allowBidInfo	=	"yes"
@if($LoanDetMod->userType	==	USER_TYPE_BORROWER)
	@if(	$LoanDetMod->inv_or_borr_id		==	$LoanDetMod->borrower_id)
		@var	$allowBidInfo	=	"yes"
	@else
		@var	$allowBidInfo	=	"no"
	@endif
@endif
<div class="col-md-12">
	
	<div>&nbsp;</div>
	<div class="row" style="font-size:16px;">		
		<div class="col-md-12 col-sm-12 col-xs-12">
			@if($LoanDetMod->no_of_bidders)
			<strong>{{$LoanDetMod->no_of_bidders}}	</strong>	
			@else
			<strong>0</strong>
			@endif
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			{{ Lang::get('Backers') }}
		</div>
		<div>&nbsp;</div>
			<div class="col-md-12 col-sm-12 col-xs-12">	
			<div class="progress" style="height:11px;">
				<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="70"
				aria-valuemin="0" aria-valuemax="100" style="width:{{$LoanDetMod->perc_funded}}%">		
				</div>
			</div>
		</div>
			
		<div class="col-md-12 col-sm-12 col-xs-12">
			<strong>{{number_format($LoanDetMod->total_bid,2,'.',',')}} ETH</strong>
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			{{ Lang::get('Pledged of') }} {{number_format($LoanDetMod->apply_amount,2,'.',',')}} ETH {{ Lang::get('borrower-myloans.goal') }}
		</div>		
		<div>&nbsp;</div>	
		<div class="col-md-12 col-sm-12 col-xs-12">
			<strong>{{$LoanDetMod->days_to_go}}</strong>			
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			{{ Lang::get('borrower-myloans.days_left') }}
		</div>
		<div>&nbsp;</div>	
		<div class="col-md-12 col-sm-12 col-xs-12">
			<strong>{{$LoanDetMod->bid_close_date}}</strong>			
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			{{Lang::get('Ending Date')}}
		</div>
		<div>&nbsp;</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			<strong>{{$LoanDetMod->statusText}}</strong>			
		</div>
		<div class="col-md-12 col-sm-12 col-xs-12">
			{{Lang::get('Status ')}}
		</div>
		@if(Auth::user())
			@if(Auth::user()->usertype	==	2)
				<div>&nbsp;</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<strong>{{number_format(InvBal::available_balance(),2,'.',',')}} (ETH)</strong>			
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					{{Lang::get('Balance ')}}
				</div>
			@endif
		@endif
	</div>
					
<!--
	<div class="row  space-around" style="font-size:16px;">	
			<div class="row">						
			<div class="col-md-5 col-xs-4"> 
			<i class="fa fa-check-square-o" aria-hidden="true"></i>
				<span class="bid-now-section">
					{{ Lang::get('Status') }}:
				</span>
			</div>
			{{$LoanDetMod->statusText}}
		</div>
	</div>	
-->
	@if(Auth::user())
	@if(Auth::user()->usertype	==	2)
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
								{{Lang::get('BACK PROJECT')}}
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
			
			
			<form method="post" id="form-bid" {{($bidCnt	==	0)?("style='display:none'"):null}} >
				<input type="hidden" name="_token" value="{{ csrf_token() }}">	
				<input type="hidden" name="bid_id" value="{{ $bid_id }}">	
				<input type="hidden" id="total_bid" name="total_bid" value="{{$LoanDetMod->total_bid}}">	
				<input type="hidden" id="apply_amount" name="apply_amount" value="{{$LoanDetMod->apply_amount}}">	
				<input type="hidden" id="minimum_bid_amount" value="{{number_format($LoanDetMod->min_bid_amount,2,'.',',')}}">	
				<input 	type="hidden" 
						name="bid_trantype"
						id="bid_trantype"
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
				<div class="row">
					<div class="col-md-6 col-xs-6">	
						<strong>{{Lang::get('Backed Amount')}}</strong><br>
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
<!--
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
-->
				</div>
				<div>&nbsp;</div>
				<div class="row">
					<div class="col-md-5 col-xs-5">	
						<button type="button" 
								id="submit_bid"
								onclick="LoanBidClicked()"
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
										id="cancel_bid"
										onclick="cancelLoanBidClicked()">
										{{Lang::get('Cancel')}}
								</button>
							</div>
						@endif
					@endif
				</div>
			</form>
		@endif	
	@endif
	@else
		&nbsp;
	<!-- Investor Bid section ends here -->
	@endif
	@endif
</div>
