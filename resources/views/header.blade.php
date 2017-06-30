
<nav class="navbar" role="navigation">
  <div class="container">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
	  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-brand-centered">
		<span class="sr-only">Toggle navigation</span>
		<span class="fa fa-bars"></span>
		<span class=""></span>
		<span class=""></span>
	  </button>
	  <div class="navbar-brand navbar-brand-centered">
		  <a class="navbar-brand" href="{{ url ('') }}">
			{{ Html::image('img/logo_horizontal-500.png','',['class' => 'shape-image']) }}
		  </a>
	  </div>
	</div>

	<!-- Collect the nav links, forms, and other content for toggling -->
	<div class="collapse navbar-collapse" id="navbar-brand-centered">
	  <ul class="nav navbar-nav">
			@var $exploreurl = "/categories/"
		<li>
			<a onclick="redirecturl('{{ $exploreurl }}')">
				<i class="fa fa-plus-square" aria-hidden="true"></i> Explore
			</a>
		</li>	
		<li style="margin-top:10px;" class="hidden-xs">
			<form id="custom-search-form" class="form-search form-horizontal pull-right">
				<input type="text" name="search" placeholder="Search..">
			</form>
		</li>	        
	  </ul>
	  <ul class="nav navbar-nav navbar-right" >
		   <li>				  
				@if(Auth::check())
				@if(Auth::user()->usertype	==	1)
						@var	$manage	=	'creator/dashboard'
					@endif
					@if(Auth::user()->usertype	==	2)
						@var	$manage	=	'backer/dashboard'
					@endif
					@if(Auth::user()->usertype	==	3)
						@var	$manage	=	'admin/dashboard'
					@endif
				<a href="{{url($manage)}}">
					<span class="starta-project">
						Dashboard
					</span>
				</a>
				@else
				<a href="{{url('creator/create_project')}}">
					<span class="starta-project">
						Start a Project
					</span>
				</a>
				@endif				  
			</li>
				@if(Auth::check())
					@if(Auth::user()->usertype	==	1)
						@var	$userProfile	=	'creator/profile'
					@endif
					@if(Auth::user()->usertype	==	2)
						@var	$userProfile	=	'backer/profile'
					@endif
					@if(Auth::user()->usertype	==	3)
						@var	$userProfile	=	'admin/profile'
					@endif					
					<li>
						<a href="{{ url($userProfile)}}">
							<i class="fa fa-user"></i>
							{{Auth::user()->username}}
						</a>
					</li>
					
					<li>
						<a href="{{ url ('auth/logout') }}">
							<i class="fa fa-sign-out"></i>
							{{ Lang::get('borrower-leftmenu.logout') }} 
						</a>
					</li>
				@else
					<li>
						<a href="{{ url ('register') }}">
							{{ Lang::get('Signup')}}
						</a>
					</li>
					<li>
						<a href="{{ url ('auth/login') }}">
							{{ Lang::get('Login')}}
						</a>
					</li>                    
				@endif	
	  </ul>
	</div>
	<!-- /.navbar-collapse -->
  </div>
  <!-- /.container-fluid -->
</nav>
