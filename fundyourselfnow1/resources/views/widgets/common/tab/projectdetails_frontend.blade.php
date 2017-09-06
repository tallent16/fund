	@var	$finacialRatioInfo	=	$LoanDetMod->finacialRatioInfo;
	@var	$desitinationPath	=	$LoanDetMod->loan_image_url;	
	@var	$loan_video_url		=	$LoanDetMod->loanEmbedvideoUrl;	
	
	<p>Note: This is sample project loaded into our platform with the purpose of displaying how the information and system will work. No actual funding is currently raised and we are not related with the team/founders of this project in any way. </p>
						    	<h3>{{ Lang::get('Purpose of the Project')}} </h3>
						    	<p>So, here's a little bit of info on our project:</p>
						    	<p>{{$LoanDetMod->loan_description}}</p>
						    	<p>{{ Lang::get('Project Location')}} </p>
						    	<p><i class="fa fa-map-marker" aria-hidden="true"></i> {{$LoanDetMod->location_description}}</p>
