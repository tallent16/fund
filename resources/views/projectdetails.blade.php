@extends('layouts.plane')
@section('styles')
	<link href="{{ url('css/frontpage.css') }}" type="text/css" rel="stylesheet" />	
	<style>
	.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus{
		background-color:#ccc;
		color:#333;
	}
	</style>
@endsection 
@section('body')	
@include('header',array('class'=>'',)) 
@var	$pos 			= 	strpos(base64_decode($loan_id), "bids"); 
@var	$commnetInfo	=	$LoanDetMod->commentInfo	
@var	$desitinationPath	=	$LoanDetMod->loan_image_url;	
@var	$loan_video_url		=	$LoanDetMod->loanEmbedvideoUrl;	
<input id="hidden_token" name="_token" type="hidden" value="{{csrf_token()}}">
<div class="container-flex" style="margin-bottom:20px;">
	<div class="row">
		<div class="col-sm-12">
			<h2>{{$LoanDetMod->loan_title}}</h2>
			<h4>{{$LoanDetMod->purpose_singleline}}</h4>
		</div>
	</div>
	<div class="row"><!----row2--->	
		<div class="col-sm-8">			
			<div class="row"><!----row1--->	
		<div class="col-sm-12 col-lg-12 ">	
			<div class="img-container">
				@if(!empty($loan_video_url))
					{{$loan_video_url}}
				@else
					{{ Html::image($LoanDetMod->getImagePath($desitinationPath),"",['class' => '']) }}
				@endif
			 
<!--
				<div class="text-bottom text-center no-image">	
					<div class="imageoverlap img-arrow">
						{{ Html::image('img/arrow.png',"",['class' => 'img-responsive']) }}
					</div>					
											
				</div>					
-->
			</div>	
		</div>
	</div>
	&nbsp;
	&nbsp;
			<div class="row"><!----inner row1--->						
				<div class="col-sm-12 col-lg-12 ">							
					
					<ul class="nav nav-tabs project-details" style="background-color:#fff;color:#222;">				
						<li {{ ($pos === false)?"class='active'":""}}>
							<a data-toggle="tab" href="#home">{{ Lang::get('PROJECT INFO') }}</a>
						</li>
						<li>
							<a data-toggle="tab" href="#menu1">{{ Lang::get('OWNER INFO') }}</a>
						</li>
						<li><a data-toggle="tab" href="#rewards">{{ Lang::get('borrower-myloans.rewards') }}</a></li>@if(Auth::user()  !=   NULL)			
						<li>
							<a data-toggle="tab" href="#comments">{{Lang::get('borrower-myloans.comments')}}</a>
						</li>
						@endif	
						<li><a data-toggle="tab" href="#menu2">{{ Lang::get('borrower-myloans.updates') }}</a></li>
					</ul>	
					
					<div class="tab-content myloan-wrapper" style="border:1px solid #ccc;min-height:180px;">
						<!--1--Project Details tab--->
						<div id="home" class="tab-pane fade {{ ($pos === false)?'in active':'' }}">
							@include('widgets.common.tab.projectdetails_frontend') 
						</div>
						<!--2--Owner Details tab--->
						<div id="menu1" class="tab-pane fade">
							@include('widgets.common.tab.ownerdetails_frontend')
						</div>
						<!--3--Rewards tab--->
						<div id="menu3" class="tab-pane fade ">
								@include('widgets.borrower.tab.myloans_bidinfo')
						</div>
						@include('widgets.borrower.tab.applyloan_documents_submit',array("show_map"=>"no","show_reward_type"=>"no"))
						@if(Auth::user()  !=   NULL)
						<!--4--comments tab--->
						<div id="comments" class="tab-pane fade">
							<!-- comments panel starts here -->
							<div class="panel panel-primary panel-container myloans">
								<div class="panel-body"><!--panel body--> 
									@if(count($commnetInfo) > 0)
										@include('widgets.common.myloans_comments',array("commnetInfo"=>$commnetInfo)) 
									@else
										<p>
											{{ Lang::get('borrower-myloans.no_comments') }} 
										</p>
									@endif
								</div>	<!--end panel body-->					
							</div>
						<!-- comments panel ends here -->
						</div><!--comments-->
						@endif
						<!--5--Updates tab--->
						<div id="menu2" class="tab-pane fade">					
							<div class="panel panel-primary panel-container">		
								<div class="panel-body">
									<div class="col-md-12">	
										<h4>"We have just launched our fundraising. Please support us now!"</h4>
									</div>
								</div>
							</div>
						</div>						
						
					</div><!---tab- content-->
				
				</div><!--col--->
			</div><!--row--->
		</div><!--col-sm-8-->	
			
		<div class="col-sm-4">
<!--
			<div class="row"><p >Project Summary</p></div>
-->
			<div class="row" style="border:1px solid #ccc;padding:5px;min-height:400px;">
				<div class="panel">
					@include('widgets.common.projectsummary_frontend')
				</div>
			</div>
			
			<div class="row"><p class="sidebar-title">Milestones</p></div>
			
			<div class="row" style="border:1px solid #ccc;padding:0px 10px 10px 10px;overflow:hidden;">
									
				@if(!empty($BorModLoan->mileStoneArry))
					<div class="row" style="overflow:hidden;background-color:#ccc;">
						<div class="col-sm-4">Date</div>
						<div class="col-sm-5">Name</div>
						<div class="">Release %</div>
					</div>
				
					@foreach($BorModLoan->mileStoneArry as $val)	
								
						<div class="row">
							<div class="col-sm-4">{{$val['milestone_date']}}</div>
							<div class="col-sm-5"> {{$val['milestone_name']}}</div>
							<div class=""> {{$val['milestone_disbursed']}}</div>
						</div>
						@if($val['milestone_date'] ==''  && $val['milestone_name']=='' && $val['milestone_disbursed'] =='')
							<div class="row text-center">
								No Milestones Found
							</div>
						@endif
					@endforeach
				
				@endif
						
			</div>	
			
			<div class="row" >
				<p class="sidebar-title">
					Rewards			
				</p>
			</div>
									
				@if($BorModLoan->reward_details)
<!--
				<div class="row" style="overflow:hidden;background-color:#ccc;">
						<div class="col-sm-6">Token Title</div>
						<div class="col-sm-6">Token Cost</div>
					</div>	
-->			
					@foreach($BorModLoan->reward_details as $val)
						
						<div class="row" style="background-color:#F8F9FD;border:1px solid #e0e4fb;padding:5px 10px 10px 10px;overflow:hidden;color:rgb(114, 114, 132)">	
							<div class="row">
								<div class="col-sm-12"><strong>{{$val['token_title']}}</strong>
								@if($val['token_cost'] != 0)
									({{ Round($val['token_cost'],0)}} tokens required)
								@endif
								</div></div>&nbsp;
<!--
							<div class="row">
								<div class="col-sm-12">Back {{number_format($val['claimamount'],0)}} (ETH) to Claim this Reward</div>
							</div>&nbsp;
-->
							<div class="row">
								<div class="col-sm-12">{{$val['token_description']}}</div>						
							</div>&nbsp;
<!--
							@if($val['estimated_delivery_date']	!="") 
								<div class="row">
									<div class="col-sm-12" style="text-transform: uppercase">Estimated delivery</div>						
								</div>&nbsp;
								<div class="row">
									<div class="col-sm-12">
										{{ date("M Y",strtotime($val['estimated_delivery_date'])) }}</div>						
								</div>&nbsp;
							@endif

							@if($val['token_limit'] != 0)
								<div class="row">
									<div class="col-sm-12">{{number_format($val['token_limit']) - 1}} claimed of {{$val['token_limit']}}</div>
								</div>
							@endif
					-->
						</div>	
						&nbsp;																		
											
					@endforeach		
				@else
					<div class="row text-center"style="border:1px solid #ccc;padding:5px;">
						No Rewards Found
					</div>
				@endif
								
			
		</div><!--col-sm-4-->
		
	</div><!--row-->		
	
</div><!--container-flex-->
@include('footer',array('class'=>'',))

@section ('popup-box_panel_title',Lang::get('Fund Yourself Now'))
@section ('popup-box_panel_body')
@include('widgets.modal_box.bid_information')
@endsection
@include('widgets.modal_box.panel', array(	'id'=>'bid_information',
										'aria_labelledby'=>'bid_information',
										'as'=>'popup-box',
										'class'=>'',
									))
@if(session()->has('success'))
	@include('partials/backed_message', ['message' => session('success')])
	{{'';session()->forget("success");'';}}
@endif 
@endsection  



@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url("js/loan-details.js") }}" type="text/javascript"></script>	
	<script>
		var baseUrl			=	"{{url()}}"
		var replyUrl		=	baseUrl+'/ajax/investor/send_reply'
		var	jsonBidMessage	=	{{$LoanDetMod->bidSystemMessageInfo}}
		
		$(document).ready(function (){
			
			$('#backed_message').exists(function() {
				$('#backed_message').modal();
			});
		});
		
		function redirecturl(loanurl)
		{
			window.location=loanurl;
		}
		
	$('.modal-body').on('hidden.bs.modal', function () {
		$('video').each(function() {
		  this.player.pause();
		});
	})
	</script>	
@endsection

@stop



