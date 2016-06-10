<ul class="nav" id="side-menu">
	@permission('view.admin.dashboard') 
		<li>
			<a href="{{ url ('admin/dashboard') }}"><i class="fa fa-dashboard fa-fw"></i>{{ Lang::get('Dashboard') }} </a> 
		</li>
	@endpermission				
	@permission('listview.admin.manageborrowers') 
		<li>
			<a href="{{ url ('admin/manageborrowers') }}"><i class="fa  fa-reply fa-fw"></i>{{ Lang::get('Manage Borrowers') }} </a> 
		</li>
	@endpermission
	@permission('listview.admin.manageinvestors')
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
					@permission('listview.admin.borrowerrepayment')
						<li>
							<a href="{{ url ('admin/borrowersrepaylist') }}">{{ Lang::get('Repayment List') }}</a>
						</li>
					@endpermission
					@permission('listview.admin.investorsdeposit')			
						<li>
							<a href="{{ url ('admin/investordepositlist') }}">{{ Lang::get('Investor Deposit List') }}</a>
						</li>
					@endpermission
					@permission('listview.admin.investorswithdrawal')	
						<li>
							<a href="{{ url ('admin/investorwithdrawallist') }}">{{ Lang::get('Investor Withdrawal List') }}</a>
						</li>
					@endpermission	
					<li>
						<a href="{{ url ('admin/changeofbank') }}">{{ Lang::get('Change of Bank') }}</a>
					</li>
					<li>
						<a href="{{ url ('admin/approvechangeofbank') }}">{{ Lang::get('Approve Change of Bank') }}</a>
					</li>		
				</ul>	
		</li>
	@endpermission
	@permission('view.admin.reports')
	<li>
		<a href="{{ url ('admin/reports') }}"><i class="fa fa-line-chart fa-fw"></i>{{ Lang::get('Reports') }} </a> 
	</li>
	@endpermission
	@permission('view.admin.manageusers') 
		<li>
			<a href="{{ url ('admin/user') }}"><i class="fa fa-users fa-fw"></i>{{ Lang::get('Manage Users') }} </a> 
		</li>
	@endpermission
	@permission('view.admin.manageroles') 
		<li>
			<a href="{{ url ('admin/roles') }}"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Manage Roles') }} </a> 
		</li>
	@endpermission	
	<li>
		<a href="{{ url ('admin/settings') }}"><i class="fa fa-cogs fa-fw"></i>{{ Lang::get('Settings') }} <span class="fa arrow"></span></a> 
			<ul class="nav nav-second-level">				
				<li>
					<a href="{{ url ('admin/challengequestions') }}">{{ Lang::get('Challenge Questions') }}</a>
				</li>
				<li>
					<a href="{{ url ('admin/businessorgtype') }}">{{ Lang::get('Business Organisation Type') }}</a>
				</li>
				<li>
					<a href="{{ url ('admin/industries') }}">{{ Lang::get('Industries') }}</a>
				</li>
				<li>
					<a href="{{ url ('admin/loandocrequired') }}">{{ Lang::get('Loan Documents Required') }}</a>
				</li>
			</ul>
	</li>	  
</ul>
	
