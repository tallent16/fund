@extends('layouts.plane')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading','Blank')
@section('body')
           
	<div class="container-fluid">     
	<div class="row">
 <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>                
                <a class="navbar-brand" href="{{ url ('') }}">{{ Html::image('img/LOGO.jpg') }}</a>                
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
					@if(Auth::check())
						@if(Auth::user()->usertype	==	1)
							@var	$userProfile	=	'borrower/profile'
						@endif
						@if(Auth::user()->usertype	==	2)
							@var	$userProfile	=	'investor/profile'
						@endif
						@if(Auth::user()->usertype	==	3)
							@var	$userProfile	=	'adminnn/profile'
						@endif
						
						<li>
							<a href="{{ url($userProfile)}}">
								<i class="fa fa-user"></i>
								{{ Lang::get('borrower-leftmenu.user_profile') }}
							</a>
						<li>
							<a href="{{ url ('auth/logout') }}">
								<i class="fa fa-sign-out"></i>
								{{ Lang::get('borrower-leftmenu.logout') }} 
							</a>
						</li>
					@else
						<li>
							<a href="{{ url ('register') }}">Signup</a>
						</li>
						<li>
							<a href="{{ url ('auth/login') }}">Login</a>
						</li>                    
					@endif	
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

	 
	</div>
	<!-- /.row -->

	</div>  
            
@stop
