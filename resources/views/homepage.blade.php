@extends('layouts.plane')
@section('styles')
	<link href="{{ url('css/frontpage.css') }}" type="text/css" rel="stylesheet" />
	<link href="{{ url('css/slider.css') }}" type="text/css" rel="stylesheet" />
@endsection 
@section('page_heading',Lang::get('Crowd Funding'))  
@section('body')	   

@if(session()->has('success'))
	@include('partials/error', ['type' => 'success', 'message' => session('success')])
@endif
@if(session()->has('failure'))

	@include('partials/error', ['type' => 'failure', 'message' => session('failure')])
@endif	 
@include('header',array('class'=>'',))
<div style="background-color:#fff;">
 <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:1300px;height:600px;overflow:hidden;visibility:hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
            <div style="position:absolute;display:block;background:url('img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
        </div>
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:1300px;height:700px;overflow:hidden;">
            <a data-u="any" href="#" style="display:none">A</a>
            <div>
                <img data-u="image" src="img/businesswork.jpg" style="height:100%"/>
               <div class="slider-maintext"> 
				<h3><strong>Get Help and Funding for Your Idea. Get Rewarded for Your Investment</strong></h3>
				</div></br>
                @if(!Auth::check())					
                <div class="slider-text">					
					<a onclick="videoPopup()" href="javascript:void(0);">WATCH NOW</a>	
				</div>
					@endif	
            </div>
           

<!--
            <div>
                <img data-u="image" src="img/slider11.png" />
                <div class="slider-maintext" data-u="caption" style="width:auto;height:80px;background-color:rgba(235,81,0,0.5);font-size:20px;color:#ffffff;line-height:30px;text-align:center;padding-left:20px;padding-right:20px"> 
					<h3><strong>Get Help and Funding for Your Idea. Get Rewarded for Your Investment</strong></h3>
				</div>
            </div>
            <div>
                <img data-u="image" src="img/slider22.jpg" />
                <div class="slider-maintext" data-u="caption"> 
					<h3><strong>Get Help and Funding for Your Idea. Get Rewarded for Your Investment</strong></h3>
				</div>
            </div>
-->

        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb05" style="bottom:16px;right:16px;" data-autocenter="1">
            <!-- bullet navigator item prototype -->
            <div data-u="prototype" style="width:16px;height:16px;"></div>
        </div>
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora22l" style="top:0px;left:8px;width:40px;height:58px;" data-autocenter="2"></span>
        <span data-u="arrowright" class="jssora22r" style="top:0px;right:8px;width:40px;height:58px;" data-autocenter="2"></span>
    </div>
    			
	@section ('videoPopup-box_panel_body')

	@endsection

	@include('widgets.modal_box.video_panel', array(	
							'id'=>'videoPopup',
							'aria_labelledby'=>'videoPopup',
							'as'=>'videoPopup-box',
							'class'=>'',
							'footerExists'=>'yes'
					))

    <div id="videoPopup"></div>	
	<div class="container-flex" style="margin-top:20px;"> 		
		<!-- Projects Row -->
		<div class="row float-center" style="font-size:12px;">
			<h4 class="col-xs-12"><strong>Featured Projects</strong>
				<span class="col-sm-offset-7 col-xs-offset-8 pull-right">
					<span style="font-size:12px;">
						
							@var $excitingurl = '/projectlisting/exciting'
						
						<strong><a onclick="redirecturl('{{ $excitingurl }}')">See all</a></strong>
					</span>
				</span>
			</h4>
			
			@foreach ($home->recommendedList as $loanRow)
				@include('widgets.homepage_exciting_listing', array('class'=>'', "loanRow"=>$loanRow))
			@endforeach  
			
			<h4 class="col-xs-12"><strong>What's Popular</strong>
				<span class="col-sm-offset-7 col-xs-offset-8 pull-right">
					<span style="font-size:12px;">
						 
							@var $popularurl = '/projectlisting/popular'
						
						<strong><a onclick="redirecturl('{{ $popularurl }}')">See all</a></strong>
					</span>
				</span>
			</h4> 
			
			@foreach ($home->loanList as $loanRow)
				@include('widgets.homepage_popular_listing', array('class'=>'', "loanRow"=>$loanRow))
			@endforeach  
			
			<h4 class="col-xs-12"><strong>Explore Categories</strong>
				<span class="col-sm-offset-7 col-xs-offset-8 pull-right">
					<span style="font-size:12px;">						
							@var $exploreurl = "/categories/"						
						<a onclick="redirecturl('{{ $exploreurl }}')"><strong>See all</strong></a>
					</span>
				</span>
			</h4> 
			<div class="row">
				<div class=" col-sm-12">
				@foreach ($home-> filterIndustryList as $loanRow)
					<div class="col-sm-3">
						<div class="col-sm-12 thumb-image text-center">
							
								@var $loanurl = "/explorecategories/".base64_encode($loanRow->codelist_value)
							
							<a  onclick="redirecturl('{{ $loanurl }}')">
								<img alt="" class="img-responsive" 
								src="{{$loanRow->expression}}">
							</a>
							<div class="caption">
								<span class="icon-cat"><a onclick="redirecturl('{{ $loanurl }}')"><i class="fa fa-expand" aria-hidden="true"></i></a></span>
								<h4><a onclick="redirecturl('{{ $loanurl }}')" style="color:#fff;">{{$loanRow->codelist_value}}</a></h4>
							</div>
						</div>
					</div>        
				@endforeach							   
				</div>  	   
            </div>               	   
            	   
		</div><!--row-->		
	</div><!--container-->	 
	
<div class="container-fluid started-layout">
	<div class="row">
		<div class="col-sm-12">
			<!--
			<div class="container" style="margin:20px 20px">
			
				<div class="row">
					<p class="text-center">
						<strong>Get Started Today</strong>
					</p>				
					<p class="text-center">Discover new crowdfunding campaign or start your own campaign to raise funds.</p>
				</div>				
			
				<div class="row">
					<div class="col-md-4">&nbsp;</div>
					<div class="col-md-4">
						<strong>Get Started Today</strong>
					</div>
					<div class="col-md-4"></div>
				</div>
				<div class="row" style="margin-top:10px;">
					<div class="col-md-4"></div>
					<div class="col-md-8">
						Discover new crowdfunding campaign or start your own campaign to raise funds.
					</div>
				</div>
				<div class="row space-around text-center">
					@var $exploreproject = '/projectlisting/'
					<div class="row-fluid">
						<div class="span4 offset4 text-center">
							<a onclick="redirecturl('{{$exploreproject}}')"> 
								<button class="btn explore-project project">EXPLORE PROJECTS</button>
							</a>
							<a href="{{url('creator/create_project')}}"> 
							   <button class="btn start-project project">START A PROJECT</button>
							</a>
						</div>
					</div>
				</div>-->
				<div style="margin-top:40px" class="container-flex">
					<div class="row text-center">
						<div class="col-md-4"></div>
						<div class="col-md-4 ">
							<strong>Get Started Today</strong>
						</div>
						<div class="col-md-4"></div>
					</div>
					<div style="margin-top:10px;" class="row text-center">
						<div class="col-md-2"></div>
						<div class="col-md-8">
							Discover new crowdfunding campaign or start your own campaign to raise funds.
						</div>
					</div>
					<div class="row text-center"  style="margin-top:10px;" >
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<a onclick="redirecturl('{{$exploreproject}}')"> 
								<button class="btn explore-project project">EXPLORE PROJECTS</button>
							</a>
							<a href="{{url('creator/create_project')}}"> 
							   <button class="btn start-project project">START A PROJECT</button>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div> 

@include('footer',array('class'=>'',))
				 
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ asset('assets/scripts/jssor.slider-22.1.8.mini.js') }}" type="text/javascript"></script>	
	<script src="{{ asset('js/slider.js') }}" type="text/javascript"></script>	
	<script type="text/javascript">
		$(document).ready(function (){
			
			$('.modal').on('hidden.bs.modal', function () {
				 $('iframe').attr('src', $('iframe').attr('src'));
			})
		});
        /*Redirect the url to respected loandetails page*/
		function redirecturl(loanurl)
		{
			window.location=loanurl;
		}
		function videoPopup(){
			var $video = '<iframe width="720" height="360" src="https://www.youtube.com/embed/6he500TIHek" frameborder="0" allowfullscreen title="FundYourself"></iframe>';			
			$('#videoPopup .modal-body').html($video);
			$('#videoPopup').modal("show");				
		}
 
    </script>    
@endsection
@stop
