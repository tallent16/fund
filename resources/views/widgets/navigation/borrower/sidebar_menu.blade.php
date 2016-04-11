	@var	$profileStatus		=	BorProfile::checkProfileStatus()
	@var	$LoanAllowingStatus	=	BorProfile::getBorrowerLoanAllowingStatus()
	
	@if($profileStatus	==	0	||	$profileStatus	==BORROWER_STATUS_NEW_PROFILE
								||	$profileStatus	==BORROWER_STATUS_SUBMITTED_FOR_APPROVAL)
		
		@var	$dashboardUrl		=	'javascript:void(0);'
		@var	$applyLoanUrl		=	'javascript:void(0);'
		@var	$loansListUrl		=	'javascript:void(0);'
		@var	$myLoanInfoUrl		=	'javascript:void(0);'
		@var	$loanSummaryUrl		=	'javascript:void(0);'
		@var	$transactionUrl		=	'javascript:void(0);'
		@var	$bankDetailsUrl		=	'javascript:void(0);'
		@var	$repayLoanUrl		=	'javascript:void(0);'
		@var	$class				=	'disabled'
		@var	$class1				=	'disabled'
		@var	$title				=	''
		@var	$showToolTipClass	=	''
	@else
		@var	$class			=	''
		@var	$dashboardUrl	=	url ('borrower/dashboard')
		@if(!$LoanAllowingStatus)
			@var	$applyLoanUrl		=	'javascript:void(0);'
			@var	$class1				=	'disabled'
			@var	$title				=	'Your are not Eligible for apply loan'
			@var	$showToolTipClass	=	'tooltip'
		@else
			@var	$applyLoanUrl		=	url ('borrower/applyloan')
			@var	$class1				=	''
			@var	$title				=	''
			@var	$showToolTipClass	=	''
		@endif
		@var	$loansListUrl	=	url ('borrower/loanslist')
		@var	$myLoanInfoUrl	=	url ('borrower/myloaninfo')
		@var	$loanSummaryUrl	=	url ('borrower/loansummary')
		@var	$transactionUrl	=	url ('borrower/transhistory')
		@var	$bankDetailsUrl	=	url ('borrower/bankdetails')
		@var	$repayLoanUrl	=	url ('borrower/repayloans')
		
		
	@endif
	
	<ul class="nav" id="side-menu">
		<!--<li class="sidebar-balance">
			{{ Lang::get('borrower-leftmenu.balance') }} : $100,000 		
		</li>-->
		<li class="{{$class}}">
			<a href="{{ $dashboardUrl }}"><i class="fa fa-tachometer fa-fw"></i>{{ Lang::get('borrower-leftmenu.dashboard') }} </a> 
		</li>
		<li> 
			<a href="{{ url ('borrower/profile') }}"><i class="fa fa-user fa-fw"></i>{{ Lang::get('borrower-profile.profile') }} </a>
		</li>               
									 
		<li class="{{$class}}">
			<a href="#"><i class="fa fa-file-image-o fa-fw"></i>{{ Lang::get('borrower-leftmenu.loans') }} <span class="fa arrow"></span></a>
			<ul class="nav nav-second-level">
				<li class="{{$class1}}">
					<a 	href="{{ $applyLoanUrl }}"
						title="{{$title}}" 
						data-toggle="{{$showToolTipClass}}"
						>
						{{ Lang::get('borrower-leftmenu.applyloans') }}
					</a>
				</li> 
			
				<li class="{{$class}}">
					<a href="{{ $loansListUrl }}">{{ Lang::get('borrower-leftmenu.loanslist') }}</a> 
				</li>       
				<li class="{{$class}}">
					<a href="{{ $myLoanInfoUrl }}">{{ Lang::get('borrower-leftmenu.myloans') }}</a> 
				</li>                              
			</ul>
		<!-- /.nav-second-level -->
		</li>
		<li class="{{$class}}">
			<a href="#"><i class="fa fa-list-ul fa-fw"></i>{{ Lang::get('borrower-leftmenu.transcation') }} <span class="fa arrow"></span></a>
			<ul class="nav nav-second-level">
				<li class="{{$class}}">
					<a href="{{ $loanSummaryUrl }}">{{ Lang::get('Loan Summary') }}</a>
				</li> 
				<li class="{{$class}}">
					<a href="{{ $transactionUrl }}">{{ Lang::get('borrower-leftmenu.transhistory') }}</a>
				</li>  
				<li class="{{$class}}">
					<a href="{{ $bankDetailsUrl }}">{{ Lang::get('borrower-leftmenu.bankdetails') }}</a>
				</li>  
				<li class="{{$class}}">
					<a href="{{ $repayLoanUrl }}">{{ Lang::get('borrower-leftmenu.repayloans') }}</a>
				</li>                                                             
			</ul>
		<!-- /.nav-second-level -->
		</li>                             
	</ul>
	<ul class="nav settings-menu" id="side-menu">	                
		<li>
			<a href="javascript:void(0)"><i class="fa fa-cogs fa-fw"></i>{{ Lang::get('borrower-leftmenu.settings') }}</a>
		</li>  
		<li>
			<a href="javascript:void(0)"><i class="fa fa-gear fa-fw"></i>{{ Lang::get('borrower-leftmenu.pinnacle') }} </a>
		</li>                      
		<li>
			<a href="{{ url ('auth/logout') }}"><i class="fa fa-external-link fa-fw"></i>{{ Lang::get('borrower-leftmenu.logout') }}</a>
		</li>
	</ul>
