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
		<a href="{{ url ('admin/manageloans') }}"><i class="fa fa-signal fa-fw"></i>{{ Lang::get('Manage Loans') }} </a> 
	</li>
	<li>
		<a href="{{ url ('admin/banking') }}"><i class="fa  fa-bank fa-fw"></i>{{ Lang::get('Banking') }} </a> 
	</li>
	<li>
		<a href="{{ url ('admin/reports') }}"><i class="fa fa-line-chart fa-fw"></i>{{ Lang::get('Reports') }} </a> 
	</li>	  
</ul>
