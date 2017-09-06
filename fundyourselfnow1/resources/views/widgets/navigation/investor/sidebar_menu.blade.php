@var	$profileStatus		=	InvBal::checkProfileStatus()
@var	$class	=	""
@if($profileStatus	==	0	||	$profileStatus	==INVESTOR_STATUS_NEW_PROFILE
									||	$profileStatus	==INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL
									||	$profileStatus	==INVESTOR_STATUS_COMMENTS_ON_ADMIN)
	@var	$class	=	"disabled"
@endif
	@var	$walletUrl		=	url ('backer/wallet')
	<ul class="nav" id="side-menu">
		<li class="sidebar-balance">
			<div class="head-balance">{{ Lang::get('borrower-leftmenu.balance') }} : 
				{{number_format(InvBal::available_balance(),2,'.',',')}} (ETH)
			</div>                             
		</li>
		 <li class="{{$class}}">
			<a href="{{ url ('backer/dashboard') }}"><i class="fa fa-tachometer fa-fw"></i>{{ Lang::get('borrower-leftmenu.dashboard') }} </a> 
		</li>
		<li> 
			<a href="{{ url ('backer/profile') }}"><i class="fa fa-user fa-fw"></i>{{ Lang::get('borrower-profile.profile') }} </a>
		</li>                 
													 
		<li class="{{$class}}">
			<a href="#"><i class="fa fa-file-image-o fa-fw"></i>{{ Lang::get('Projects') }} <span class="fa arrow"></span></a>
			<ul class="nav nav-second-level">                              
				 <li> 
					<a href="{{ url ('/projectlisting') }}">{{ Lang::get('Project Listing') }}</a> 
				</li>       
				<li> 
					<a href="{{ url ('backer/myprojects') }}">{{ Lang::get('My Projects') }}</a> 
				</li>                              
			</ul>
			<!-- /.nav-second-level -->
		</li>
<!--
		<li class="{{$class}}">
			<a href="#"><i class="fa fa-list-ul fa-fw"></i>{{ Lang::get('borrower-leftmenu.transcation') }} <span class="fa arrow"></span></a>
			<ul class="nav nav-second-level">
				<li>
					<a href="{{ url ('investor/transhistory') }}">{{ Lang::get('borrower-leftmenu.transhistory') }}</a>
				</li>                                                                                            
			</ul>
			
		</li>                      
-->
<!--
		<li class="{{$class}}">
			<a href="{{ url ('banking') }}"><i class="fa fa-university fa-fw"></i>{{ Lang::get('borrower-leftmenu.banking') }}<span class="fa arrow"></span> </a>
			  <ul class="nav nav-second-level">
				<li class="{{$class}}">
					<a href="{{ url ('backer/bankdetails') }}">{{ Lang::get('borrower-leftmenu.bankdetails') }}</a>
				</li>                                 
				 <li class="{{$class}}">
					<a href="{{ url ('backer/depositlist') }}">{{ Lang::get('Deposit') }}</a>
				</li>               
				 <li class="{{$class}}">
					<a href="{{ url ('backer/withdrawallist') }}">{{ Lang::get('borrower-leftmenu.withdraw') }}</a>
				</li>                                                                              
			</ul>
	
		</li>    
-->
		<li class="{{$class}}">
			<a href="{{$walletUrl}}">
				<i class="fa fa-google-wallet fa-fw"></i>
				{{ Lang::get('Wallet') }} 
			</a>
		</li>  
		<li class="{{$class}}">
			<a href="{{ url ('backer/marketplace') }}"><i class="fa fa-external-link fa-fw"></i>{{ Lang::get('borrower-leftmenu.marketplace') }}</a>
		</li>   
		<li>
			<a href="{{ url ('auth/logout') }}"><i class="fa fa-external-link fa-fw"></i>{{ Lang::get('borrower-leftmenu.logout') }}</a>
		</li>                     
		                  
	</ul>
	
