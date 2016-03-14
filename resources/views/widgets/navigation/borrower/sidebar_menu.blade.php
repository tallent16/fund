	<ul class="nav" id="side-menu">
		<li class="sidebar-balance">
			{{ Lang::get('borrower-leftmenu.balance') }} : $100,000 		
		</li>
		<li>
			<a href="{{ url ('borrower/dashboard') }}"><i class="fa fa-gear fa-fw"></i>{{ Lang::get('borrower-leftmenu.dashboard') }} </a> 
		</li>
		<li> 
			<a href="{{ url ('borrower/profile') }}"><i class="fa fa-user fa-fw"></i>{{ Lang::get('borrower-profile.profile') }} </a>
		</li>               
									 
		<li>
			<a href="#"><i class="fa fa-money fa-fw"></i>{{ Lang::get('borrower-leftmenu.loans') }} <span class="fa arrow"></span></a>
			<ul class="nav nav-second-level">
				<li> 
					<a href="{{ url ('borrower/applyloan') }}">{{ Lang::get('borrower-leftmenu.applyloans') }}</a>
				</li> 
				<li> 
					<a href="{{ url ('borrower/loanslist') }}">{{ Lang::get('borrower-leftmenu.loanslist') }}</a> 
				</li>       
				<li> 
					<a href="{{ url ('borrower/myloaninfo') }}">{{ Lang::get('borrower-leftmenu.myloans') }}</a> 
				</li>                              
			</ul>
		<!-- /.nav-second-level -->
		</li>
		<li>
			<a href="#"><i class="fa fa-sitemap fa-fw"></i>{{ Lang::get('borrower-leftmenu.transcation') }} <span class="fa arrow"></span></a>
			<ul class="nav nav-second-level">
				<li>
					<a href="{{ url ('borrower/transhistory') }}">{{ Lang::get('borrower-leftmenu.transhistory') }}</a>
				</li>  
				<li>
					<a href="{{ url ('borrower/bankdetails') }}">{{ Lang::get('borrower-leftmenu.bankdetails') }}</a>
				</li>  
				<li>
					<a href="{{ url ('borrower/repayloans') }}">{{ Lang::get('borrower-leftmenu.repayloans') }}</a>
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
