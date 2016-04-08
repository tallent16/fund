	@var	$finacialRatioInfo	=	$LoanDetMod->finacialRatioInfo;
	@var	$desitinationPath	=	$LoanDetMod->company_image;
	
	<div class="panel panel-primary panel-container">
		@if ($LoanDetMod->isfeatured == 1)
			<div class="imageoverlap">
				{{ Html::image('img/featured.png',"",['class' => 'img-responsive']) }}
			</div>
		@endif
		<div class="img-container">
		 {{ Html::image($LoanDetMod->getImagePath($desitinationPath),"",['class' => 'img-responsive']) }}
			<div class="text-bottom text-center no-image">	
				<div class="imageoverlap img-arrow">
					{{ Html::image('img/arrow.png',"",['class' => 'img-responsive']) }}
				</div>					
				<h3>{{$LoanDetMod->company_name}}</h3>
				<h6>{{$LoanDetMod->industry}}, {{$LoanDetMod->purpose_singleline}}</h6>						
			</div>					
		</div>	
	
	<div class="panel-body">
			
		<div class="row">
			<div class="col-md-12">
				<div class="pull-right">
					<i class="fa fa-exclamation-circle"></i>
				</div>
			</div>
		</div>

		<div class="col-md-12">	
			<div class="panel-subhead">
				{{ Lang::get('borrower-myloans.purpose_loan')}}
			</div>
			<P>
				{{$LoanDetMod->purpose}}
			</P>		
		</div>

		<div class="col-md-12">
			<div class="panel-subhead">
				{{ Lang::get('borrower-myloans.about_us')}}
			</div>
			<p>
				{{$LoanDetMod->about_us}}
			</p>
		</div>
		
		<div class="col-md-8  col-xs-12 col-lg-offset-2">
			<div class="table-responsive"><!---table start-->
				<table class="table applyloan">		
					<tbody>
						<tr>
							<th class="tab-head-red">{{ Lang::get('borrower-myloans.financial_ratio')}}</th>
							<th class="tab-head text-right">{{date("Y",strtotime("-1 year"))}}</th>	
							<th class="tab-head text-right">{{date("Y")}}</th>				
						</tr>
						@if(count($finacialRatioInfo)>0)
							@foreach($finacialRatioInfo as $finRatioRow)
								<tr>
									<td class="tab-left-head">{{$finRatioRow['ratio_name']}}</td>
									<td class="text-right">{{$finRatioRow['current_ratio']}}</td>	
									<td class="text-right">{{$finRatioRow['previous_ratio']}}</td>		
								</tr>			
							@endforeach
						@endif
					</tbody>
				</table>	
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-6">	
					<div class="pull-left">	
						<button type="submit" class="btn verification-button">{{ Lang::get('borrower-myloans.download_info')}}</button>
					</div>
				</div>
				
				<div class="col-md-6">	
					<div class="pull-right social-share">	  
						{{ Lang::get('borrower-myloans.share_us')}} : <a href="">{{ Html::image('img/twitter.png') }}</a>
						<a href="">{{ Html::image('img/facebook.png') }}</a>
						<a href="">{{ Html::image('img/mail.png') }}</a>
					</div>
				</div>
			</div>
		</div>

	</div><!---panel body--->
</div><!----panel container-->
