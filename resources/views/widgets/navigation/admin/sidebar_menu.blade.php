<ul class="nav" id="side-menu">
	@permission('view.admin.dashboard') 
		<li>
			<a href="{{ url ('admin/dashboard') }}"><i class="fa fa-dashboard fa-fw"></i>{{ Lang::get('Dashboard') }} </a> 
		</li>
	@endpermission				
	@permission('view.admin.manageborrowers') 
		<li>
			<a href="{{ url ('admin/manageborrowers') }}"><i class="fa  fa-reply fa-fw"></i>{{ Lang::get('Manage Borrowers') }} </a> 
		</li>
	@endpermission
	@permission('view.admin.manageinvestors')
		<li>
			<a href="{{ url ('admin/manageinvestors') }}"><i class="fa fa-share fa-fw"></i>{{ Lang::get('Manage Investors') }} </a> 
		</li>
	@endpermission
	@permission('view.admin.manageloans')
		<li>
			<a href="{{ url ('admin/manageloans') }}"><i class="fa fa-signal fa-fw"></i>{{ Lang::get('Manage Loans') }} <span class="fa arrow"></span></a> 
				<ul class="nav nav-second-level">
					<li>
						<a href="{{ url ('admin/loanlisting') }}">{{ Lang::get('Loan Listing') }}</a>
					</li> 
				<!--	<li>
						<a href="{{ url ('admin/loanapproval') }}">{{ Lang::get('Loan Approval') }}</a>
					</li> 
					<li>
						<a href="{{ url ('admin/managebids') }}">{{ Lang::get('Manage Bids') }}</a>
					</li>
					<li>
						<a href="{{ url ('admin/disburseloan') }}">{{ Lang::get('Loan Disbursal') }}</a>
					</li>-->
				</ul>
		</li>
	@endpermission
	@permission('view.admin.banking')
		<li>
			<a href="{{ url ('admin/borrowersrepayment') }}"><i class="fa  fa-bank fa-fw"></i>{{ Lang::get('Banking') }} <span class="fa arrow"></span></a> 
				<ul class="nav nav-second-level">
					@permission('view.admin.repaymentlist')
						<li>
							<a href="{{ url ('admin/borrowersrepaylist') }}">{{ Lang::get('Repayment List') }}</a>
						</li>
					@endpermission
					@permission('view.admin.investorsdeposit')			
						<li>
							<a href="{{ url ('admin/investordepositlist') }}">{{ Lang::get('Investor Deposit List') }}</a>
						</li>
					@endpermission
					@permission('view.admin.investorswithdrawals')	
						<li>
							<a href="{{ url ('admin/investorwithdrawallist') }}">{{ Lang::get('Investor Withdrawal List') }}</a>
						</li>
					@endpermission			
				</ul>	
		</li>
	@endpermission
	<li>
		<a href="{{ url ('admin/reports') }}"><i class="fa fa-line-chart fa-fw"></i>{{ Lang::get('Reports') }} </a> 
	</li>
	@permission('view.admin.dashboard') 
		<li>
			<a href="{{ url ('admin/user') }}"><i class="fa fa-dashboard fa-fw"></i>{{ Lang::get('Manage Users') }} </a> 
		</li>
	@endpermission	@permission('view.admin.dashboard') 
		<li>
			<a href="{{ url ('admin/roles') }}"><i class="fa fa-dashboard fa-fw"></i>{{ Lang::get('Manage Roles') }} </a> 
		</li>
	@endpermission		  
</ul>
