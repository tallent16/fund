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
						<a href="{{ url ('admin/loanlisting') }}">{{ Lang::get('All Loans') }}</a>
					</li> 
				<li>
						<a href="{{ url ('admin/loandisplayorder') }}">{{ Lang::get('Loan Display Ordering') }}</a>
					</li> 					
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
					@permission('view_changeofbank.admin.banking')
						<li>
							<a href="{{ url ('admin/changeofbank') }}">{{ Lang::get('Bank Change Request') }}</a>
						</li>	
					@endpermission
				</ul>	
		</li>
	@endpermission
	@permission('view.admin.reports')
	<li>
		<a href="{{ url ('admin/reports') }}">
			<i class="fa fa-line-chart fa-fw"></i>
			{{ Lang::get('Reports') }} 
			<span class="fa arrow">
		</a>
		<ul class="nav nav-second-level">
			@permission('viewinvestor.admin.reportactivity')
			<li>
				<a href="{{ url ('admin/investoractivity/report') }}">
					{{ Lang::get('Investor Activity Report') }}
				</a>
			</li> 
			@endpermission
			@permission('viewborrower.admin.reportactivity')
			<li>
				<a href="{{ url ('admin/borroweractivity/report') }}">
					{{ Lang::get('Borrower Activity Report') }}
				</a>
			</li> 
			@endpermission
			@permission('viewbank.admin.reportactivity')
			<li>
				<a href="{{ url ('admin/bankactivity/report') }}">
					{{ Lang::get('Bank Activity Report') }}
				</a>
			</li>
			@endpermission
			@permission('viewloan.admin.reportlisting')
			<li>
				<a href="{{ url ('admin/loan-listing/report') }}">
					{{ Lang::get('Loan Listing Report') }}
				</a>
			</li>
			@endpermission
			@permission('viewinvestor.admin.reportprofile')
			<li>
				<a href="{{ url ('admin/investor-profiles/report') }}">
					{{ Lang::get('Investor Profiles Report') }}
				</a>
			</li>
			@endpermission
			@permission('viewborrower.admin.reportprofile')
			<li>
				<a href="{{ url ('admin/borrower-profiles/report') }}">
					{{ Lang::get('Borrower Profiles Report') }}
				</a>
			</li>
			@endpermission
			@permission('viewloan.admin.reportperformance')
			<li>
				<a href="{{ url ('admin/loan-perform/report') }}">
					{{ Lang::get('Loan Performance Report') }}
				</a>
			</li>
			@endpermission
			@permission('viewcommfees.admin.reportledger')
			<li>
				<a href="{{ url ('admin/commission-fees-ledger/report') }}">
					{{ Lang::get('Commissions & Fees Ledger Report') }}
				</a>
			</li>
			@endpermission
			@permission('viewpenlev.admin.reportledger')
			<li>
				<a href="{{ url ('admin/penalties-levies/report') }}">
					{{ Lang::get('Penalties & Levies Ledger Report') }}
				</a>
			</li>
			@endpermission
		</ul>
	</li>
	<li>
	<a href="{{ url ('admin/audit_trial') }}">
		<i class="fa fa fa-key fa-fw"></i>
					{{ Lang::get('Audit trail') }}
				</a>
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
		<a href="{{ url ('admin/settings') }}"><i class="fa fa-cogs fa-fw"></i>{{ Lang::get('Marketing') }} <span class="fa arrow"></span></a> 
			<ul class="nav nav-second-level">	 
				@permission('view_general_message.admin.settings') 
					<li>
						<a href="{{ url ('admin/broadcast/notificationsList') }}">{{ Lang::get('Notifications List') }}</a>
					</li>
				@endpermission 
				@permission('view_general_message.admin.settings') 
					<li>
						<a href="{{ url ('admin/bulkMailer/mailList') }}">{{ Lang::get('Mailers List') }}</a>
					</li>
				@endpermission 
			</ul>
	</li>
	<li>
		<a href="{{ url ('admin/settings') }}"><i class="fa fa-cogs fa-fw"></i>{{ Lang::get('Settings') }} <span class="fa arrow"></span></a> 
			<ul class="nav nav-second-level">	
				@permission('view_general_message.admin.settings') 
					<li>
						<a href="{{ url ('admin/settings') }}">{{ Lang::get('General & Messages') }}</a>
					</li>	
				@endpermission
				@permission('view_challenge_question.admin.settings') 
					<li>
						<a href="{{ url ('admin/challengequestions') }}">{{ Lang::get('Challenge Questions') }}</a>
					</li>
				@endpermission
				@permission('view_organisation_type.admin.settings') 
					<li>
						<a href="{{ url ('admin/businessorgtype') }}">{{ Lang::get('Business Organisation Type') }}</a>
					</li>
				@endpermission
				@permission('view_industries.admin.settings') 
					<li>
						<a href="{{ url ('admin/industries') }}">{{ Lang::get('Industries') }}</a>
					</li>
				@endpermission	
				@permission('view_general_message.admin.settings') 
					<li>
						<a href="{{ url ('admin/loandocrequired') }}">{{ Lang::get('Loan Documents Required') }}</a>
					</li>
				@endpermission
			</ul>
	</li>	  
</ul>
	
