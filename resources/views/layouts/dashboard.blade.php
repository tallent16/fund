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
                <input type="hidden" id="hidden_token" value="{{ csrf_token() }}"/>
                  <a class="navbar-brand" href="{{ url ('') }}">{{ Html::image('img/logo_horizontal-small.png') }}</a>
            </div>
            <!-- /.navbar-header --> 
			
			<div class="page-header-title"><i class="{{(isset($classname)?$classname:'')}}"></i>@yield('page_heading')</div>
			          
            <ul class="nav navbar-top-links navbar-right" >
				@if(Auth::check()) <li class="block-title" style="color:#eea236;width:200px;">{{Auth::user()->username}}</li>	@endif	
				<li class="block-title" style="padding:15px;color:#eea236;margin: 0 -3px 0 0;">
					
						<i class="fa fa-bell" data-toggle="popover" data-content="" style="cursor: pointer;" ></i>
						<span class="label"  id="notificationCount" ></span>
						<span class="hidden notifyList"></span>
				 </li>
				
                <!-- /.dropdown -->               
                <li class="dropdown" style="background-color: #353333;">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                         <i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i>
                    </a>
                   
                    <ul class="dropdown-menu dropdown-user" >
                         @if(Auth::user()->usertype == USER_TYPE_BORROWER)
						<li><a href="{{ url ('borrower/profile') }}"><i class="fa fa-user fa-fw"></i>{{ 			Lang::get('borrower-leftmenu.user_profile') }}</a>
                        </li>
						@elseif(Auth::user()->usertype == USER_TYPE_INVESTOR)
						<li><a href="{{ url ('backer/profile') }}"><i class="fa fa-user fa-fw"></i>User Profile</a>
                        </li>
                        @else
                        
						@endif
						 @if(Auth::user()->usertype == USER_TYPE_ADMIN)
                        <li><a href="{{ url ('admin/settings') }}"><i class="fa fa-cogs fa-fw"></i>{{ Lang::get('borrower-leftmenu.settings') }}</a>
                        </li>
                        @endif
                        <li class="divider"></li>
                        <li><a href="{{ url ('auth/logout') }}"><i class="fa fa-external-link fa-fw"></i>{{ Lang::get('borrower-leftmenu.logout') }} </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->               
            </ul>
            <!-- /.navbar-top-links -->
		 <div class="status-label-section">@yield('status_button')</div>
			
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
					@if(Auth::user()->usertype == USER_TYPE_BORROWER)
						@include('widgets.navigation.borrower.sidebar_menu')
					@elseif(Auth::user()->usertype == USER_TYPE_INVESTOR)	
						@include('widgets.navigation.investor.sidebar_menu')
					@elseif(Auth::user()->usertype == USER_TYPE_ADMIN)	
						@include('widgets.navigation.admin.sidebar_menu')
					@endif
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
	
		<div id="page-wrapper">
			
			
			<div class="dashboard-alert">
				@if(session()->has('success'))
					@include('partials/error', ['type' => 'success', 'message' => session('success')])
					{{'';session()->forget("success");'';}}
				@endif
				@if(session()->has('failure'))
					@include('partials/error', ['type' => 'danger', 'message' => session('failure')])
					{{'';session()->forget("failure");'';}}
				@endif    
				
				@if(session()->has('notification'))
					@include('partials/error', ['type' => 'notification', 'message' => session('notification')])
					{{'';session()->put("notification_seen","yes");'';}}
					{{'';session()->forget("notification");'';}}
				@endif    
			</div> 
			
			<div class="row">  
				@yield('section')
			</div>
		
		</div><!-- /#page-wrapper -->
		
    </div><!-- /#wrapper -->
    @if(session()->has('show_welcome_popup'))
		@include('partials/welcome_message', ['message' => session('welcome_message')])
		{{'';session()->forget("show_welcome_popup");'';}}
		{{'';session()->forget("welcome_message");'';}}
	@endif 
	 
	<script>var baseUrl	=	"{{url('')}}"</script> 
@stop 
