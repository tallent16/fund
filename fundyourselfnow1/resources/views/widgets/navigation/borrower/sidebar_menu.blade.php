	@var	$profileStatus		=	BorProfile::checkProfileStatus()
	@var	$LoanAllowingStatus	=	BorProfile::getBorrowerLoanAllowingStatus()
	
	@if($profileStatus	==	0	||	$profileStatus	==BORROWER_STATUS_NEW_PROFILE
								||	$profileStatus	==BORROWER_STATUS_SUBMITTED_FOR_APPROVAL
								||	$profileStatus	==BORROWER_STATUS_COMMENTS_ON_ADMIN)
		
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
		@var	$reqHelpUrl		=	url ('creator/request_help')
		@var	$rewdHelpUrl	=	url ('creator/reward_help')
		@var	$walletUrl		=	url ('creator/wallet')
	@else
		@var	$class			=	''
		@var	$dashboardUrl	=	url ('creator/dashboard')
		@if(!$LoanAllowingStatus)
			@var	$applyLoanUrl		=	'javascript:void(0);'
			@var	$class1				=	'disabled'
			@var	$title				=	'Your are not Eligible for apply project'
			@var	$showToolTipClass	=	'tooltip'
		@else
			@var	$applyLoanUrl		=	url ('creator/create_project')
			@var	$class1				=	''
			@var	$title				=	''
			@var	$showToolTipClass	=	''
		@endif
		@var	$loansListUrl	=	url ('borrower/loanslist')
		@var	$myLoanInfoUrl	=	url ('creator/myloaninfo')
		@var	$loanSummaryUrl	=	url ('creator/projectsummary')
		@var	$transactionUrl	=	url ('creator/transhistory')
		@var	$bankDetailsUrl	=	url ('borrower/bankdetails')
		@var	$repayLoanUrl	=	url ('borrower/repayloans')
		@var	$reqHelpUrl		=	url ('creator/request_help')
		@var	$rewdHelpUrl	=	url ('creator/reward_help')
		@var	$walletUrl		=	url ('creator/wallet')
		
		
	@endif
	
	<ul class="nav" id="side-menu">
		<!--<li class="sidebar-balance">
			{{ Lang::get('borrower-leftmenu.balance') }} : $100,000 		
		</li>-->
		<li class="{{$class}}">
			<a href="{{ $dashboardUrl }}"><i class="fa fa-tachometer fa-fw"></i>{{ Lang::get('borrower-leftmenu.dashboard') }} </a> 
		</li>
		<li> 
			<a href="{{ url ('creator/profile') }}"><i class="fa fa-user fa-fw"></i>{{ Lang::get('borrower-profile.profile') }} </a>
		</li>               
								 
		<li class="{{$class}}">
			<a href="#"><i class="fa fa-file-image-o fa-fw"></i>{{ Lang::get('Projects') }} <span class="fa arrow"></span></a>
			<ul class="nav nav-second-level">
				<li class="{{$class1}}">
					<a 	href="{{ $applyLoanUrl }}"
						title="{{$title}}" 
						data-toggle="{{$showToolTipClass}}"
						>
						{{ Lang::get('Create Projects') }}
					</a>
				</li> 
			<li class="{{$class}}">
				<a href="{{$reqHelpUrl}}">{{ Lang::get('Request Help') }}</a> 
			</li> 
			<li class="{{$class}}">
				<a href="{{$rewdHelpUrl}}">{{ Lang::get('Reward Helpers') }}</a> 
			</li> 	
<!--
				<li class="{{$class}}">
					<a href="{{ $loansListUrl }}">{{ Lang::get('Project Listing') }}</a> 
				</li>       
-->
				<li class="{{$class}}">
					<a href="{{ $myLoanInfoUrl }}">{{ Lang::get('My Projects') }}</a> 
				</li>                              
			</ul>
		<!-- /.nav-second-level -->
		</li>
		<li class="{{$class}}">
			<a href="{{ $loanSummaryUrl }}"><i class="fa fa-list-ul fa-fw"></i>
			{{ Lang::get('Project Summary') }} </a>
		</li> 
		
		<li class="{{$class}}">
			<a href="{{$walletUrl}}"><i class="fa fa-google-wallet fa-fw"></i>{{ Lang::get('Wallet') }} 
<!--
			<span class="fa arrow"></span></a>

			<ul class="nav nav-second-level">
				<li class="{{$class}}">
					<a href="#">{{ Lang::get('My Account') }}</a>
				</li>								                                                        
			</ul>
-->
		<!-- /.nav-second-level -->
		</li>   
		<li>
			<a href="{{ url ('auth/logout') }}"><i class="fa fa-external-link fa-fw"></i>{{ Lang::get('borrower-leftmenu.logout') }}</a>
		</li>                          
	</ul>
	
