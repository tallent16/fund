@var	$profileStatus		=	InvBal::checkProfileStatus()
@var	$class	=	""
@if($profileStatus	==	0	||	$profileStatus	==INVESTOR_STATUS_NEW_PROFILE
									||	$profileStatus	==INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL
									||	$profileStatus	==INVESTOR_STATUS_COMMENTS_ON_ADMIN)
	@var	$class	=	"disabled"
@endif
	<ul class="nav" id="side-menu">
		<li class="sidebar-balance">
			<div class="head-balance">{{ Lang::get('borrower-leftmenu.balance') }} : 
				{{number_format(InvBal::available_balance(),2,'.',',')}}
			</div>                             
		</li>
		 <li class="{{$class}}">
			<a href="{{ url ('investor/dashboard') }}"><i class="fa fa-tachometer fa-fw"></i>{{ Lang::get('borrower-leftmenu.dashboard') }} </a> 
		</li>
		<li> 
			<a href="{{ url ('investor/profile') }}"><i class="fa fa-user fa-fw"></i>{{ Lang::get('borrower-profile.profile') }} </a>
		</li>                 
													 
		<li class="{{$class}}">
			<a href="#"><i class="fa fa-file-image-o fa-fw"></i>{{ Lang::get('borrower-leftmenu.loans') }} <span class="fa arrow"></span></a>
			<ul class="nav nav-second-level">                              
				 <li> 
					<a href="{{ url ('investor/loanslist') }}">{{ Lang::get('borrower-leftmenu.loanslist') }}</a> 
				</li>       
				<li> 
					<a href="{{ url ('investor/myloaninfo') }}">{{ Lang::get('borrower-leftmenu.myloans') }}</a> 
				</li>                              
			</ul>
			<!-- /.nav-second-level -->
		</li>
		<li class="{{$class}}">
			<a href="#"><i class="fa fa-list-ul fa-fw"></i>{{ Lang::get('borrower-leftmenu.transcation') }} <span class="fa arrow"></span></a>
			<ul class="nav nav-second-level">
				<li>
					<a href="{{ url ('investor/transhistory') }}">{{ Lang::get('borrower-leftmenu.transhistory') }}</a>
				</li>                                                                                            
			</ul>
			<!-- /.nav-second-level -->
		</li>                      
		<li class="{{$class}}">
			<a href="{{ url ('banking') }}"><i class="fa fa-university fa-fw"></i>{{ Lang::get('borrower-leftmenu.banking') }}<span class="fa arrow"></span> </a>
			  <ul class="nav nav-second-level">
				<li class="{{$class}}">
					<a href="{{ url ('investor/bankdetails') }}">{{ Lang::get('borrower-leftmenu.bankdetails') }}</a>
				</li>                                 
				 <li class="{{$class}}">
					<a href="{{ url ('investor/deposit') }}">{{ Lang::get('Deposit') }}</a>
				</li>               
				 <li class="{{$class}}">
					<a href="{{ url ('investor/withdraw') }}">{{ Lang::get('borrower-leftmenu.withdraw') }}</a>
				</li>                                                                              
			</ul>
		</li>                         
	</ul>
	<ul class="nav settings-menu" id="side-menu">	                 
		<li>
			<a href="{{ url ('investor/settings') }}"><i class="fa fa-cogs fa-fw"></i>{{ Lang::get('borrower-leftmenu.settings') }}</a>
		</li>  
		<li>
			<a href="#"><i class="fa fa-gear fa-fw"></i>{{ Lang::get('borrower-leftmenu.pinnacle') }} </a>
		</li>                      
		<li>
			<a href="{{ url ('auth/logout') }}"><i class="fa fa-external-link fa-fw"></i>{{ Lang::get('borrower-leftmenu.logout') }}</a>
		</li>
	</ul>
