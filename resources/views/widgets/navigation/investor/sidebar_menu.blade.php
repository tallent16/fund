 <ul class="nav" id="side-menu">
                        <li class="sidebar-balance">
                            <div class="head-balance">{{ Lang::get('borrower-leftmenu.balance') }} : $100,000</div> 
                            <!-- /input-group -->
                        </li>
                         <li>
                            <a href="{{ url ('investor/dashboard') }}"><i class="fa fa-gear fa-fw"></i>{{ Lang::get('borrower-leftmenu.dashboard') }} </a> 
                        </li>
                        <li> 
							<a href="{{ url ('investor/profile') }}"><i class="fa fa-user fa-fw"></i>{{ Lang::get('borrower-profile.profile') }} </a>
                        </li>                 
                                                                     
                        <li>
                            <a href="#"><i class="fa fa-money fa-fw"></i>{{ Lang::get('borrower-leftmenu.loans') }} <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li> 
                                    <a href="{{ url ('investor/applyloan') }}">{{ Lang::get('borrower-leftmenu.applyloans') }}</a>
                                </li> 
                                 <li> 
                                    <a href="{{ url ('investor/loanslist') }}">{{ Lang::get('borrower-leftmenu.loanslist') }}</a> 
                                </li>       
                                <li> 
                                    <a href="{{ url ('investor/myloans') }}">{{ Lang::get('borrower-leftmenu.myloans') }}</a> 
                                </li>                              
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i>{{ Lang::get('borrower-leftmenu.transcation') }} <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="{{ url ('investor/transhistory') }}">{{ Lang::get('borrower-leftmenu.transhistory') }}</a>
                                </li>  
                                 <li>
                                    <a href="{{ url ('investor/bankdetails') }}">{{ Lang::get('borrower-leftmenu.bankdetails') }}</a>
                                </li>  
                                 <li>
                                    <a href="{{ url ('investor/repayloans') }}">{{ Lang::get('borrower-leftmenu.repayloans') }}</a>
                                </li>                                                             
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>                      
                        <li>
                            <a href="{{ url ('banking') }}"><i class="fa fa-university fa-fw"></i>{{ Lang::get('borrower-leftmenu.banking') }} </a>
                        </li>
                         <li>
                            <a href="{{ url ('support') }}"><i class="fa fa-edit fa-fw"></i>{{ Lang::get('borrower-leftmenu.support') }} </a>
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
