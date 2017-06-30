	@var	$finacialRatioInfo	=	$LoanDetMod->finacialRatioInfo;
	@var	$desitinationPath	=	$LoanDetMod->loan_image_url;	
	@var	$loan_video_url		=	$LoanDetMod->loanEmbedvideoUrl;	
	
	<div class="panel panel-primary panel-container">
<!--
		@if ($LoanDetMod->featured_loan == 1)
			<div class="imageoverlap">
				{{ Html::image('img/featured.png',"",['class' => 'img-responsive']) }}
			</div>
		@endif
-->
<!--
		<div class="img-container">
			@if(!empty($loan_video_url))
				{{$loan_video_url}}
			@else
				{{ Html::image($LoanDetMod->getImagePath($desitinationPath),"",['class' => 'img-responsive']) }}
			@endif
		 
			<div class="text-bottom text-center no-image">	
				<div class="imageoverlap img-arrow">
					{{ Html::image('img/arrow.png',"",['class' => 'img-responsive']) }}
				</div>					
				<h3>{{$LoanDetMod->loan_title}}</h3>
				<h6>{{$LoanDetMod->purpose_singleline}}</h6>						
			</div>					
		</div>	
-->
	
	<div class="panel-body" style="overflow-x: auto;">
		
		<div class="col-md-12">	
			<p class="project-description">
				<b>Note:</b> This is sample project loaded into our platform with the purpose of displaying how the information and system will work. No actual funding is currently raised and we are not related with the team/founders of this project in any way.
			</p>	
		</div>
		<div class="col-md-12">	
			<div class="panel-subhead">
				{{ Lang::get('Purpose of the Project')}}
			</div>
				
			<p class="project-description">
				{{$LoanDetMod->loan_description}}
			</p>		
		</div>

		<div class="col-md-12">
			<div class="panel-subhead">
				{{ Lang::get('Project Location')}}
			</div>
			<p>
				<i class="fa fa-map-marker" aria-hidden="true"></i> {{$LoanDetMod->location_description}}
			</p>
		</div>
		
	</div><!---panel body--->
</div><!----panel container-->
