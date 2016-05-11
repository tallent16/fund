<ul class="nav" id="side-menu">
	<li>
		<a href="{{ url ('admin/dashboard') }}"><i class="fa fa-dashboard fa-fw"></i>{{ Lang::get('Dashboard') }} </a> 
	</li>				
	<li>
		<a href="{{ url ('admin/manageborrowers') }}"><i class="fa  fa-reply fa-fw"></i>{{ Lang::get('Manage Borrowers') }} </a> 
	</li>
	<li>
		<a href="{{ url ('admin/manageinvestors') }}"><i class="fa fa-share fa-fw"></i>{{ Lang::get('Manage Investors') }} </a> 
	</li>
	<li>
		<a href="{{ url ('admin/manageloans') }}"><i class="fa fa-signal fa-fw"></i>{{ Lang::get('Manage Loans') }} <span class="fa arrow"></span></a> 
			<ul class="nav nav-second-level">
				<li>
					<a href="{{ url ('admin/loanlisting') }}">{{ Lang::get('Loan Listing') }}</a>
				</li> 			
			</ul>
	</li>
	<li>
		<a href="{{ url ('admin/borrowersrepayment') }}"><i class="fa  fa-bank fa-fw"></i>{{ Lang::get('Banking') }} <span class="fa arrow"></span></a> 
			<ul class="nav nav-second-level">
				<li>
					<a href="{{ url ('admin/borrowersrepaylist') }}">{{ Lang::get('Repayment List') }}</a>
				</li> 				
				<li>
					<a href="{{ url ('admin/investordepositlist') }}">{{ Lang::get('Investor Deposit List') }}</a>
				</li> 				
				<li>
					<a href="{{ url ('admin/investorwithdrawallist') }}">{{ Lang::get('Investor Withdrawal List') }}</a>
				</li> 				
			</ul>	
	</li>
	<li>
		<a href="{{ url ('admin/reports') }}"><i class="fa fa-line-chart fa-fw"></i>{{ Lang::get('Reports') }} <span class="fa arrow"></span></a> 
		<ul class="nav nav-second-level">
				<li>
					<a href="{{ url ('admin/auditstrail') }}">{{ Lang::get('Audit Trail') }}</a>
				</li> 
			</ul>	
	</li>	  
</ul>
