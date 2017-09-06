@extends('layouts.plane')

@section('page_heading',Lang::get('Crowd Funding'))  
@section('body')	   

@if(session()->has('success'))
	@include('partials/error', ['type' => 'success', 'message' => session('success')])
@endif
@if(session()->has('failure'))

	@include('partials/error', ['type' => 'failure', 'message' => session('failure')])
@endif	

 
@include('header',array('class'=>'',))
	
<?php // echo '<pre>';print_r($home->loanList);die; ?>
<section class="banner_area">
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		 <ol class="carousel-indicators">
		  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
		  <li data-target="#carousel-example-generic" data-slide-to="1"></li>
		  <li data-target="#carousel-example-generic" data-slide-to="2"></li>
      
         </ol>
			  <!-- Wrapper for slides -->
			  <div class="carousel-inner" role="listbox">
			    <div class="item active">
			      <img src="{{ url('assets/images/banner1.jpg') }}" alt="banner1">
			      <div class="carousel-caption">
			        <div class="table_box">
			        	<div class="table_inner">
			        		<h1>Get Help and Funding for Your Idea.<br/>Get Rewarded for Your Investment</h1>
			        		<a href="#" class="watch_now_btn animated_slow" data-toggle="modal" data-target="#info_video">Watch Now</a>
			        	</div>
			        </div>
			      </div>
			    </div>
				<div class="item">
			      <img src="{{ url('assets/images/banner2.jpg')}}" alt="banner2">
			      <div class="carousel-caption">
			        <div class="table_box">
			        	<div class="table_inner">
			        		<h1>The Doctor's Case Movie Project</h1>
			        		@var $excitingurl = '/projectlisting/exciting'
			        		<a href="{{url('projectlisting/exciting') }}" class="watch_now_btn animated_slow">Featured Project</a>
			        	</div>
			        </div>
			      </div>
			    </div>
				<div class="item">
			      <img src="{{ url('assets/images/banner3.jpg')}}" alt="banner2">
			      <div class="carousel-caption">
			        <div class="table_box">
			        	<div class="table_inner">
			        		<h1>Relive what the Russian punk </br>collective experienced </h1>
			        		<a href="{{url('projectlisting')}}" class="watch_now_btn animated_slow">View Project</a>
			        	</div>
			        </div>
			      </div>
			    </div>
			  </div>

		 <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
           <span class="glyphicon glyphicon-chevron-left"></span>
           <span class="sr-only">Previous</span>
         </a>
         <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
            <span class="sr-only">Next</span>
         </a>
		</div>
		
		
	</section>
 
	<div class="modal fade video_pop" id="info_video" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
  		<div class="table_box">
  			<div class="table_inner">
       			 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
       			 <div class="video_frame_outer">
       			 	<iframe src="https://www.youtube.com/embed/6he500TIHek" allowfullscreen="" title="FundYourself" height="400" frameborder="0" width="100%"></iframe>
       			 </div>
       		</div>
       	</div>
  </div>
</div>
<!-- end banner area here -->
  			
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
<!-- start projects area here -->
	<section class="project_area">
		<div class="container">

		<!-- feature projects area here -->
			<article class="project_boxouter">
                            @var $excitingurl = '/projectlisting/exciting'
                             @var $excitingurl = url($excitingurl)
				<h3>Featured Projects <a href="{{ $excitingurl }}" class="see_all">See All</a></h3>
				<div class="row">
					@foreach ($home->recommendedList as $loanRow)
				@include('widgets.homepage_exciting_listing', array('class'=>'', "loanRow"=>$loanRow))
			@endforeach  
			
				</div>
			</article>
		<!-- feature projects area here -->

		<!-- popular projects area here -->
			<article class="project_boxouter">
                         @var $popularurl = '/projectlisting/popular'
				 @var $popularurl = url($popularurl)		
				<h3>What's Popular<a href="{{ $popularurl }}" class="see_all">See All</a></h3>
				<div class="row">
					@foreach ($home->loanList as $loanRow)
				@include('widgets.homepage_popular_listing', array('class'=>'', "loanRow"=>$loanRow))
			@endforeach 
				</div>
			</article>
		<!-- popular projects area here -->

		<!-- explore categories area here -->
			<article class="project_boxouter">
                            @var $exploreurl = "/categories/"
                             @var $exploreurl = url($exploreurl)
				<h3>Explore Categories <a href="{{ $exploreurl }}" class="see_all">See All</a></h3>
				<div class="row">
                                  @foreach ($home-> filterIndustryList as $loanRow)
					<aside class="col-sm-3 col-xs-6">
                                              @var $loanurl = "/explorecategories/".base64_encode($loanRow->codelist_value)
                                                  @var $exploreurl = url($loanurl)
						<div class="category_box">
                                    <a  href="{{ url($loanurl) }}">
							<img src="{{config('moneymatch_settings.image_url') }}{{$loanRow->expression}}" alt="" /></a>
							<div class="category_caption">
								<a href="{{url($loanurl)}}">
									<span class="icon-cat"><i class="fa fa-cogs" aria-hidden="true"></i></span><br/>
									{{$loanRow->codelist_value}}
								</a>
							</div>
						</div>
					</aside>
	                            @endforeach
					
				</div>
			</article>
		
		<!-- explore categories area here -->

		</div>
	</section>
<!-- end projects area here -->

<!-- start get start today area here -->
	<section class="get_started text-center">
		<div class="container">
			<h3>Get Started Today</h3>
			<p>Discover new crowdfunding campaign or start your own campaign to raise funds.</p>
			<a href="{{url('projectlisting')}}" class="white_btn border_btn animated_slow">EXPLORE PROJECTS</a>
			<a href="#" class="white_btn animated_slow">START A PROJECT</a>
		</div>
	</section>

<footer class="footer">
@include('footer')
</footer>
@section('bottomscripts')
	<script>
	
/*Redirect the url to respected loandetails page*/
		function redirecturl(loanurl)
		{
			window.location=loanurl;
		}
</script>
<script type="text/javascript">
		jQuery(document).ready(function (){
			
			jQuery('.modal').on('hidden.bs.modal', function () {
				 jQuery('iframe').attr('src', jQuery('iframe').attr('src'));
			}) 
		});
        /*Redirect the url to respected loandetails page*/
		function redirecturl(loanurl)
		{
			window.location=loanurl;
		}
		function videoPopup(){
			var $video = '<iframe width="720" height="360" src="https://www.youtube.com/embed/6he500TIHek" frameborder="0" allowfullscreen title="FundYourself"></iframe>';			
			jQuery('#videoPopup .modal-body').html($video);
			jQuery('#videoPopup').modal("show");				
		}
 


    </script>
@endsection
@endsection

@stop
