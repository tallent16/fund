  <link rel="stylesheet"  type="text/css" href="{{ asset('assets/css/style_new.css') }}" />
<header class="header">
		<div class="mobile_logo text-center">
		<a href="{{ url ('') }}"><img src="{{ url('assets/images/logo.png') }}" alt="" /></a>
		</div>
		<div class="mobile_search_box">
			<form>
				<div class="form-group">
					<input type="text" class="form-control" value="" placeholder="Search.." />
					<i class="fa fa-search" aria-hidden="true"></i>
				</div>
			</form>
			<a href="#" class="close_btn"><i class="fa fa-close" aria-hidden="true"></i></a>
		</div>
		<div class="container-fluid">
			<div class="row">
				<aside class="col-md-4 col-sm-6 col-xs-8 explore_area">
					<ul>
					@var $exploreurl = "/categories/" 
						<li>	<a href="{{url('categories')}}"><img src="{{ url('assets/images/bulb.png') }}" alt="" /></i> Explore
			</a></li>
						<li class="web_search">
							<input type="text" class="form-control" value="" placeholder="Search.." />
							<i class="fa fa-search" aria-hidden="true"></i>
						</li>
						<li class="mobile_search">
							<i class="fa fa-search" aria-hidden="true"></i>
						</li>
        <li class="block-title new_tb" style="padding:5px;margin: 0 15px 0 0;">            
            <i class="fa fa-bell" data-toggle="popover" data-content="" style="cursor: pointer;" data-original-title="" title="" aria-describedby="popover705785"></i>
                <span class="notificationCount1 label" id="notificationCount" style="display: none;"></span>
                <span class="hidden notifyList">
                    <div class="collection">
                        <center id="empty">All Notifications Caught!</center>
                    </div>
                    <div class="reader" style="display: none;"></div>
                </span>
        </li>

                        <!-- <li class='dropdown new_tb'>
                        
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                               <i class="fa fa-bell" aria-hidden="true"></i></b>
                               <span class="notificationCount1"  style="display:none"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Notification</a></li>
                                <li class="noti">All Notification Caught</li>
                                
                            </ul>
                        </li> -->
					</ul>
				</aside>
				<aside class="col-md-3 col-sm-3 col-xs-8 text-center logo">
					<a href="{{ url ('') }}"><img src="{{ url('assets/images/logo.png') }}" alt="" /></a>
				</aside>
				<aside class="col-md-5 col-sm-6 col-xs-4">
					<nav class="navbar navbar-default custom_navigation">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>          
						</div>
						<div aria-expanded="false" id="navbar" class="navbar-collapse collapse">
							<ul class="nav navbar-nav">


								    @if(Auth::check())
                                    
   @if(Auth::user()->usertype  ==  USER_TYPE_BORROWER)
                        @var    $manage =   'creator/dashboard'
@var    $profileStatus      =   BorProfile::checkProfileStatus()
    @var    $LoanAllowingStatus =   BorProfile::getBorrowerLoanAllowingStatus()
    
    @if($profileStatus  ==  0   ||  $profileStatus  ==BORROWER_STATUS_NEW_PROFILE
                                ||  $profileStatus  ==BORROWER_STATUS_SUBMITTED_FOR_APPROVAL
                                ||  $profileStatus  ==BORROWER_STATUS_COMMENTS_ON_ADMIN)
        
        @var    $dashboardUrl       =   'javascript:void(0);'
        @var    $applyLoanUrl       =   'javascript:void(0);'
        @var    $loansListUrl       =   'javascript:void(0);'
        @var    $myLoanInfoUrl      =   'javascript:void(0);'
        @var    $loanSummaryUrl     =   'javascript:void(0);'
        @var    $transactionUrl     =   'javascript:void(0);'
        @var    $bankDetailsUrl     =   'javascript:void(0);'
        @var    $repayLoanUrl       =   'javascript:void(0);'
        @var    $class              =   'disabled'
        @var    $class1             =   'disabled'
        @var    $title              =   ''
        @var    $showToolTipClass   =   ''
        @var    $reqHelpUrl     =   url ('creator/request_help')
        @var    $rewdHelpUrl    =   url ('creator/reward_help')
        @var    $walletUrl      =   url ('creator/wallet')
    @else
        @var    $class          =   ''
        @var    $dashboardUrl   =   url ('creator/dashboard')
        @if(!$LoanAllowingStatus)
            @var    $applyLoanUrl       =   'javascript:void(0);'
            @var    $class1             =   'disabled'
            @var    $title              =   'Your are not Eligible for apply loan'
            @var    $showToolTipClass   =   'tooltip'
        @else
            @var    $applyLoanUrl       =   url ('creator/create_project')
            @var    $class1             =   ''
            @var    $title              =   ''
            @var    $showToolTipClass   =   ''
        @endif
        @var    $loansListUrl   =   url ('borrower/loanslist')
        @var    $myLoanInfoUrl  =   url ('creator/myloaninfo')
        @var    $loanSummaryUrl =   url ('creator/projectsummary')
        @var    $transactionUrl =   url ('creator/transhistory')
        @var    $bankDetailsUrl =   url ('borrower/bankdetails')
        @var    $repayLoanUrl   =   url ('borrower/repayloans')
        @var    $reqHelpUrl     =   url ('creator/request_help')
        @var    $rewdHelpUrl    =   url ('creator/reward_help')
        @var    $walletUrl      =   url ('creator/wallet')
        
        
    @endif

 

                    @endif
                    @if(Auth::user()->usertype  ==  USER_TYPE_INVESTOR)

                      @var    $profileStatus      =   InvBal::checkProfileStatus()
@var    $class  =   ""
@if($profileStatus  ==  0   ||  $profileStatus  ==INVESTOR_STATUS_NEW_PROFILE
                                    ||  $profileStatus  ==INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL
                                    ||  $profileStatus  ==INVESTOR_STATUS_COMMENTS_ON_ADMIN)
    @var    $class  =   "disabled"
@endif
    @var    $walletUrl      =   url ('backer/wallet')
                        @var    $manage =   'backer/dashboard'
                    @endif
                    @if(Auth::user()->usertype  ==  USER_TYPE_ADMIN)
                        @var    $manage =   'admin/dashboard'
                    @endif

				@if(Auth::user()->usertype	==	1)
						@var	$cal_url	=	'creator/project_calander'
					@endif
					@if(Auth::user()->usertype	==	2)
						@var	$cal_url	=	'backer/project_calander'
					@endif
					@if(Auth::user()->usertype	==	3)
						@var	$cal_url	=	'admin/project_calander'
					@endif
<li role="presentation"><a href="{{url($cal_url)}}">Project Calendar</a></li>
				


@if(Auth::user()->usertype	==	1)
						@var	$manage	=	'creator/dashboard'
					@endif
					@if(Auth::user()->usertype	==	2)
						@var	$manage	=	'backer/dashboard'
					@endif
					@if(Auth::user()->usertype	==	3)
						@var	$manage	=	'admin/dashboard'
					@endif
 <?php  $eth = Session::get('eth');
 ?>
<li role="presentation" class="dashboard_drop dropdown">
 <a href="{{url($manage)}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard <b class="caret"></b></a>

<!--<a href="{{url($manage)}}"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard</a>-->
<ul class="dropdown-menu" aria-labelledby="dLabel">
										   <li><a href="{{url($manage)}}"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a></li>
                                    @if(Auth::user()->usertype == USER_TYPE_BORROWER)
                                      <li><a href="{{ url ('creator/profile') }}"><i class="fa fa-user fa-fw"></i>{{     
                                Lang::get('borrower-leftmenu.user_profile') }}</a>
                        </li>
                        <li><a href="{{ $loanSummaryUrl }}"><i class="fa fa-list-ul fa-fw"></i>Project Summary</a></li>
                        @elseif(Auth::user()->usertype == USER_TYPE_INVESTOR)
                        <li><a href="{{ url ('backer/profile') }}"><i class="fa fa-user fa-fw"></i>User Profile</a>
                        </li>
                            <li>
            <a href="{{ url ('backer/marketplace') }}"><i class="fa fa-external-link fa-fw"></i>{{ Lang::get('borrower-leftmenu.marketplace') }}</a>
        </li>

                        @else
                        
                        @endif
                         @if(Auth::user()->usertype == USER_TYPE_ADMIN)
                        <li><a href="{{ url ('admin/settings') }}"><i class="fa fa-cogs fa-fw"></i>{{ Lang::get('borrower-leftmenu.settings') }}</a>
                        </li>
                        @endif


                                             @if(Auth::user()->usertype == USER_TYPE_BORROWER)
                                            <li><a href="{{$walletUrl}}" target="_blank"><i class="fa fa-google-wallet fa-fw"></i>Wallet</a></li>
                                               @endif
                                                    @if(Auth::user()->usertype == USER_TYPE_INVESTOR)
										  <li><a href="https://www.myetherwallet.com/" target="_blank"><i class="fa fa-google-wallet fa-fw"></i>Wallet</a>
                                          </li>
                                          @if($eth)
  <li><a href="{{ url ('backer/transaction') }}" target="_blank"><i class="fa fa-clock-o" aria-hidden="true"></i>Transaction History </a></li> 
  @endif
                                               @endif
                                                <li><a href="{{ url ('auth/logout') }}"><i class="fa fa-external-link fa-fw"></i>Logout</a></li>
									</ul> 
									</li> 
                                       @if(Auth::user()->usertype != USER_TYPE_ADMIN)
    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-file-image-o fa-fw"></i> Projects <b class="caret"></b>
                                        </a>

                                        <ul class="dropdown-menu">
                                         @if(Auth::user()->usertype == USER_TYPE_BORROWER)
                                            <li><a  href="{{ $applyLoanUrl }}">Create Projects</a></li>
                                            <li><a href="{{$reqHelpUrl}}">Request Help</a></li>
                                            <li><a href="{{$rewdHelpUrl}}">Reward Helpers</a></li>
                                            <li><a href="{{ $myLoanInfoUrl }}">My Projects</a></li>
                                             @endif
                                              @if(Auth::user()->usertype == USER_TYPE_INVESTOR)
                                            <li>    <a href="{{ url ('/projectlisting') }}">{{ Lang::get('Project Listing') }}</a> </li>       
                                            <li><a href="{{ url ('backer/myprojects') }}">{{ Lang::get('My Projects') }}</a> </li>
                                         
                                             @endif

                                        </ul>
                                    </li>
                                    @endif

        <li class="block-title new_tb" style="padding:5px;margin: 0 15px 0 0;">            
            <i class="fa fa-bell notification_btn" data-toggle="popover" data-content="" style="cursor: pointer;" data-original-title="" title="" aria-describedby="popover705785"></i>
                <span class="notificationCount1 label" id="notificationCount" style="display: none;"></span>
                <span class="hidden notifyList">
                    <div class="collection">
                        <center id="empty">All Notifications Caught!</center>
                    </div>
                    <div class="reader" style="display: none;"></div>
                </span>
        </li>

                                    <!--  <li class='dropdown new_tb'>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                           <i class="fa fa-bell" aria-hidden="true"></i></b>
                                           <span class="notificationCount1" style="display:none"></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Notification</a></li>
                                            <li class="noti">All Notification Caught</li>
                                            
                                        </ul>
                                    </li> -->
                               		
				@else
						<li role="presentation"><a href="{{url('project_calander')}}">Project Calendar</a></li>		
						<li role="presentation"><a href="{{ url ('auth/login') }}">Login</a></li>

								<li role="presentation"><a href="{{ url ('register') }}">Signup</a></li>   
								 
				<li role="presentation"><a href="{{ url ('auth/login') }}" class="orange_btn animated_slow">Start a Project</a></li>	 								
  @endif				  
							</ul>
						</div>
					</nav>	
				</aside>
			</div>
		</div>
	</header>