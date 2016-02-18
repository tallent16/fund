@extends('layouts.plane')
@section('body')
 <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                  <a class="navbar-brand" href="{{ url ('') }}">{{ Html::image('img/LOGO.jpg') }}</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">               
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('borrower-leftmenu.user_profile') }}</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i>{{ Lang::get('borrower-leftmenu.settings') }}</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="{{ url ('auth/logout') }}"><i class="fa fa-sign-out fa-fw"></i>{{ Lang::get('borrower-leftmenu.logout') }} </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-balance">
                            <div class="head-balance">{{ Lang::get('borrower-leftmenu.balance') }} : $100,000</div> 
                            <!-- /input-group -->
                        </li>
                        <li {{ (Request::is('/') ? 'class="active"' : '') }}>
                            <a href="{{ url ('') }}"><i class="fa fa-gear fa-fw"></i>{{ Lang::get('borrower-leftmenu.dashboard') }} </a>
                        </li>
                         <li>
							<a href="{{ url ('borrower/profile') }}"><i class="fa fa-user fa-fw"></i>{{ Lang::get('borrower-profile.profile') }} </a>
                        </li>                                            
                        <li >
                            <a href="#"><i class="fa fa-money fa-fw"></i>{{ Lang::get('borrower-leftmenu.loans') }} <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li {{ (Request::is('*panels') ? 'class="active"' : '') }}> 
                                    <a href="{{ url ('borrower/applyloan') }}">Apply Loans</a>
                                </li>                               
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i>{{ Lang::get('borrower-leftmenu.transcation') }} <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">sub menu</a>
                                </li>                                                             
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                      
                        <li {{ (Request::is('*documentation') ? 'class="active"' : '') }}>
                            <a href="{{ url ('documentation') }}"><i class="fa fa-university fa-fw"></i>{{ Lang::get('borrower-leftmenu.banking') }} </a>
                        </li>
                         <li {{ (Request::is('*forms') ? 'class="active"' : '') }}>
                            <a href="{{ url ('forms') }}"><i class="fa fa-edit fa-fw"></i>{{ Lang::get('borrower-leftmenu.support') }} </a>
                        </li>
                    </ul>
                     <ul class="nav settings-menu" id="side-menu">	                    
                        <li>
							<a href="#"><i class="fa fa-cogs fa-fw"></i>{{ Lang::get('borrower-leftmenu.settings') }}</a>
                        </li>  
                        <li>
							<a href="#"><i class="fa fa-gear fa-fw"></i>{{ Lang::get('borrower-leftmenu.pinnacle') }} </a>
                        </li>                      
                        <li>
							<a href="{{ url ('auth/logout') }}"><i class="fa fa-external-link fa-fw"></i>{{ Lang::get('borrower-leftmenu.logout') }}</a>
                        </li>
                        </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
			 <div class="row">
                <div class="col-lg-12"> 
                    <h1 class="page-header">@yield('page_heading')</h1>
                </div>
                <!-- /.col-lg-12 -->
           </div>
			<div class="row">  
				@yield('section')

            </div>
            <!-- /#page-wrapper -->
        </div>
    </div>
@stop
