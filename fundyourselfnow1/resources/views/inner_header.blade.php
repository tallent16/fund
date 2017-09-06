
  <link rel="stylesheet"  type="text/css" href="{{ asset('assets/css/style_new.css') }}" />
<nav class="navbar navbar-inverse navbar-static-top">
                        <div class="container-fluid">
						<div class="row">
						    <div class="col-md-4 col-sm-12">
							<aside style="margin-top:10px;" class="explore_area">
					<ul>
                  
						@var $exploreurl = "/categories/"
                   
        <li>
            <a href="{{url('categories')}}">
                <i class="fa fa-plus-square" aria-hidden="true"></i> Explore
            </a>
        </li>   
						<li>
							<input type="text" class="form-control" value="" placeholder="Search.." />
							<i class="fa fa-search" aria-hidden="true"></i>
						</li>
					</ul>
                      </aside>
						 <div class="topnav">
                                <div class="btn-group">
                                    <a href="#">{{Auth::user()->username}}
                                    </a>
                                </div>
                                <div class="btn-group">
                                    <li class='dropdown new_tb'>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                           <i class="fa fa-bell" aria-hidden="true"></i></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Notification</a></li>
                                            <li class="noti">All Notification Caught</li>
                                            
                                        </ul>
                                    </li>
                                </div>
                                <div class="btn-group">
                                    <li class='dropdown '>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                           <i class="fa fa-user" aria-hidden="true"></i> <b class="caret"></b>
                                        </a>
                                        @if(Auth::user()->usertype  ==  1)
                        @var    $userProfile    =   'creator/profile'
                    @endif
                    @if(Auth::user()->usertype  ==  2)

                        @var    $userProfile    =   'backer/profile'

                    @endif
                    @if(Auth::user()->usertype  ==  3)
                        @var    $userProfile    =   'admin/profile'
                    @endif              
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ url($userProfile)}}"><i class="fa fa-user" aria-hidden="true"></i>&nbsp  User Profile</a></li>
                                            <li><a href="{{ url ('auth/logout') }}"><i class="fa fa-external-link fa-fw"></i>&nbsp  Logout</a></li>
                                            
                                        </ul>
                                    </li>
                                </div>
                                
                    
                            </div>
                             </div> 
                    
                             <div class="col-md-4 col-sm-5">
                            <!-- Brand and toggle get grouped for better mobile display -->
                           <header class="navbar-header">
                    
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
            @if(Auth::user()->usertype  ==  1)
                        @var    $manage_usr    =   'creator/dashboard'
                    @endif
                    @if(Auth::user()->usertype  ==  2)
                        @var    $manage_usr    =   'backer/dashboard'
                    @endif
                    @if(Auth::user()->usertype  ==  3)
                        @var    $manage_usr    =   'admin/dashboard'
                    @endif              
                                <a href="{{url($manage_usr)}}" class="navbar-brand"><img src="{{ url('assets/img/logo.png') }}" alt=""></a>
								<a href="{{url($manage_usr)}}" class="navbar-brand mobile"><img src="{{ url('assets/img/logo_m.png') }}" alt=""></a>
								
								<div class="topnav top_n">
                               <!--  <div class="btn-group">
                                    <a href="#">{{Auth::user()->username}}
                                    </a>
                                </div> -->
                                <div class="btn-group">
                                    <li class='dropdown new_tb'>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                           <i class="fa fa-bell" aria-hidden="true"></i></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Notification</a></li>
                                            <li class="noti">All Notification Caught</li>
                                            
                                        </ul>
                                    </li>
                                </div>
                              <!--   <div class="btn-group">
                                    <li class='dropdown '>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                           <i class="fa fa-user" aria-hidden="true"></i> <b class="caret"></b>
                                        </a>
                                        @if(Auth::user()->usertype  ==  1)
                        @var    $userProfile    =   'creator/profile'
                    @endif
                    @if(Auth::user()->usertype  ==  2)
                        @var    $userProfile    =   'backer/profile'
                    @endif
                    @if(Auth::user()->usertype  ==  3)
                        @var    $userProfile    =   'admin/profile'
                    @endif              
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ url($userProfile)}}"><i class="fa fa-user" aria-hidden="true"></i>&nbsp  User Profile</a></li>
                                            <li><a href="{{ url ('auth/logout') }}"><i class="fa fa-external-link fa-fw"></i>&nbsp  Logout</a></li>
                                            
                                        </ul>
                                    </li>
                                </div>
                                 -->
                    
                            </div>
                    
                            </header>
                           </div>
                           <div class="col-md-4 col-sm-7">
                            <div class="collapse navbar-collapse navbar-ex1-collapse">
                                  <div class="topnav1">
                               <!--  <div class="btn-group">
                                    <a href="#">{{Auth::user()->username}}
                                    </a>
                                </div> -->
                                <div class="btn-group">
                                    <li class='dropdown new_tb'>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                           <i class="fa fa-bell" aria-hidden="true"></i></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#">Notification</a></li>
                                            <li class="noti">All Notification Caught</li>
                                            
                                        </ul>
                                    </li>
                                </div>
                               <!--  <div class="btn-group">
                                    <li class='dropdown '>
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                           <i class="fa fa-user" aria-hidden="true"></i> <b class="caret"></b>
                                        </a>
                                         @if(Auth::user()->usertype  ==  1)
                        @var    $userProfile    =   'creator/profile'
                    @endif
                    @if(Auth::user()->usertype  ==  2)
                        @var    $userProfile    =   'backer/profile'
                    @endif
                    @if(Auth::user()->usertype  ==  3)
                        @var    $userProfile    =   'admin/profile'
                    @endif              
                                        <ul class="dropdown-menu">
                                            <li><a href="{{ url($userProfile)}}"><i class="fa fa-user" aria-hidden="true"></i>&nbsp  User Profile</a></li>
                                            <li><a href="{{ url ('auth/logout') }}"><i class="fa fa-external-link fa-fw"></i>&nbsp  Logout</a></li>
                                            
                                        </ul>
                                    </li>
                                </div> -->
                                
                    
                            </div> 

                                <!-- .nav -->
                                <ul class="nav navbar-nav">
                                @if(Auth::user()->usertype  ==  1)
                        @var    $cal_url    =   'creator/project_calander'
                    @endif
                    @if(Auth::user()->usertype  ==  2)
                        @var    $cal_url    =   'backer/project_calander'
                    @endif
                    @if(Auth::user()->usertype  ==  3)
                        @var    $cal_url    =   'admin/project_calander'
                    @endif
<li role="presentation"><a href="{{url($cal_url)}}">Project Calendar</a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle active1" data-toggle="dropdown">
                                            <i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">

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
										   <li><a href="{{url($manage)}}"><i class="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a></li>
                                    @if(Auth::user()->usertype == USER_TYPE_BORROWER)
                                     <li><a href="{{ url ('creator/profile') }}"><i class="fa fa-user fa-fw"></i>{{     
                                Lang::get('borrower-leftmenu.user_profile') }}</a>
                        </li>
                        <li><a href="{{ $loanSummaryUrl }}"><i class="fa fa-list-ul fa-fw"></i>Project Summary</a></li>
                        @elseif(Auth::user()->usertype == USER_TYPE_INVESTOR)
                        <li><a href="{{ url ('backer/profile') }}"><i class="fa fa-user fa-fw"></i>User Profile</a>
                        </li>
                            <li class="{{$class}}">
            <a href="{{ url ('backer/marketplace') }}"><i class="fa fa-external-link fa-fw"></i>{{ Lang::get('borrower-leftmenu.marketplace') }}</a>
        </li>

                        @else
                        
                        @endif
                         @if(Auth::user()->usertype == USER_TYPE_ADMIN)
                        <li><a href="{{ url ('admin/settings') }}"><i class="fa fa-cogs fa-fw"></i>{{ Lang::get('borrower-leftmenu.settings') }}</a>
                        </li>
                        @endif


                                          
                                           
                                            <li><a href="{{$walletUrl}}" target="_blank"><i class="fa fa-google-wallet fa-fw"></i>Wallet</a></li>
											<li><a href="{{ url ('auth/logout') }}"><i class="fa fa-external-link fa-fw"></i>Logout</a></li>
                                        </ul>
                                    </li>

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
									
                                    
                                </ul>
                                <!-- /.nav -->
								
                             </div> 
							<!-- left aside end--->
                            </div>
							
							
							
							</div>
							</div>
                        </div>
                        <!-- /.container-fluid -->
                    </nav>

