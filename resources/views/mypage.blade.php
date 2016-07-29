@extends('layouts.plane')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('MoneyMatch'))
@section('body')	   
<div class="container-fluid">     
	<div class="row">
		 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			 
			<div class="container">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<a class="navbar-brand" href="{{ url ('') }}">{{ Html::image('img/LOGO.jpg') }}</a>                
				</div>
				
			</div><!-- /.container -->
			
		</nav>
	</div><!-- /.row -->
</div>    

<div class="homepage-alert">
	<div class="col-sm-12">		
		@if(session()->has('success'))
			@include('partials/error', ['type' => 'success', 'message' => session('success')])
		@endif
		@if(session()->has('failure'))
			@include('partials/error', ['type' => 'danger', 'message' => session('failure')])
		@endif	
	</div>
	<div class="col-sm-4">
		<div class="panel panel-primary panel-container">
			<div class="panel-heading panel-headsection"><!--panel head-->
				<div class="row">
					<div class="col-sm-12">
						<h4>{{Lang::get('You can access following pages')}}</h4>
					</div>
				</div>
			</div>
			<div class="panel-body"><!--panel body-->
		
	<!--------------------------------------------------->
	<div class="admin-mypage">
		<ul id="side-menu">
		@permission('view.admin.dashboard') 
			<li>
				<a href="{{ url ('admin/dashboard') }}">{{ Lang::get('Dashboard') }} </a> 
			</li>
		@endpermission				
		@permission('listview.admin.manageborrowers') 
			<li>
				<a href="{{ url ('admin/manageborrowers') }}">{{ Lang::get('Manage Borrowers') }} </a> 
			</li>
		@endpermission
		@permission('listview.admin.manageinvestors')
			<li>
				<a href="{{ url ('admin/manageinvestors') }}">{{ Lang::get('Manage Investors') }} </a> 
			</li>
		@endpermission
		@permission('view.admin.manageloans')		
			<li>
				<a href="{{ url ('admin/loanlisting') }}">{{ Lang::get('Loan Listing') }}</a>
			</li> 
		@endpermission
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
		@permission('view.admin.manageusers') 
			<li>
				<a href="{{ url ('admin/user') }}">{{ Lang::get('Manage Users') }} </a> 
			</li>
		@endpermission
		@permission('view.admin.manageroles') 
			<li>
				<a href="{{ url ('admin/roles') }}">{{ Lang::get('Manage Roles') }} </a> 
			</li>
		@endpermission		  
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
	</div>
	<!--------------------------------------------------->
	</div>
	</div>
	</div>
</div>

@stop
