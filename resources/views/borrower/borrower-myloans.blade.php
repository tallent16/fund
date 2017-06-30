@extends('layouts.dashboard')
@section('styles')
	<link href='{{ asset("assets/summernote/summernote.css") }}' rel="stylesheet">		 
		<style>
		
		.project-description iframe{
			width:100%
		}
	</style>
@endsection
@section('bottomscripts') 
	<script src="{{ asset('assets/scripts/frontend.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/summernote/summernote.js')}}" type="text/javascript"></script>
	<script src="{{ url('js/jquery.validate.min.js') }}" type="text/javascript"></script>	  
	<script>
		var 	baseUrl	=	"{{url()}}"
		var 	replyUrl=	baseUrl+'/ajax/borrower/send_reply'
		$(document).ready(function() {
			
			$("#manage_bids_button").on('click',function() {
				window.location	=	$(this).attr("data-action");
			});
			
			    
			$("#form-project-updates").submit(function(event) {
					$('.has-error').removeClass("has-error");
						$("#updates_error_info").hide();
					var	updatesTxt	=	$("#project_updates").val();
					
					if(updatesTxt	==	"") {
						event.preventDefault();
						$("#updates_error_info").show();
						$("#updates_error_info").addClass("has-error");
						$("#updates_error_info").addClass("alert-danger");
					}
			});
			
			$("#preview_url").on('click',function (){
				window.open($(this).attr("data-preview-url"), '_blank');
				//~ window.location	=	$(this).attr("data-preview-url");
			});
			
		});
	
		//Create editor here
		$('#project_updates').summernote({height:300});
		
	</script>
@endsection
@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
	@var	$heading	=	Lang::get('Manage Projects')	
@else
	@var	$heading	=	Lang::get('borrower-loaninfo.page_heading')
@endif
@section('page_heading',$heading)
@section('section')     

@var	$pos 			= 	strpos(base64_decode($loan_id), "bids");
@var	$commnetInfo	=	$LoanDetMod->commentInfo	
@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
	@if( ($BorModLoan->loan_status	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL))
			@var	$commentButtonsVisibe	=	""
	@else
			@var	$commentButtonsVisibe	=	"disabled"
	@endif
@endif
<?php $BorModLoan->viewStatus	=	"disabled";?>
<input id="hidden_token" name="_token" type="hidden" value="{{csrf_token()}}">
<div class="col-sm-12 space-around"> 			
	<div class="row">	
					
		<div class="col-sm-12 col-lg-12 ">							
			<ul class="nav nav-tabs">
				<li {{ ($pos === false)?"class='active'":""}}>
					<a data-toggle="tab" href="#project_info"
					 style="text-transform:uppercase; ">
						{{ Lang::get('borrower-applyloan.project_info') }}</a>
				</li>
				<?php	
				if( ($LoanDetMod->loan_status	==	LOAN_STATUS_APPROVED) ) {
				?>

					<li  {{ ($pos !== false)?"class='active'":""}}>
						<a data-toggle="tab" href="#menu3">{{ Lang::get('borrower-myloans.backers_info') }}</a>
					</li>
					<li><a data-toggle="tab" href="#menu2">{{ Lang::get('borrower-myloans.updates') }}</a></li>
				<?php }?>		
			</ul>
 
			<div class="tab-content myloan-wrapper">
				<div id="project_info" class="tab-pane fade {{ ($pos === false)?'in active':'' }}">
					@include('widgets.borrower.tab.applyloan_info',array("show_map"=>"no"))
				</div>
					<?php	
				if( ($LoanDetMod->loan_status	==	LOAN_STATUS_APPROVED)) {
				?>
	
					<div id="menu3" class="tab-pane fade  {{ ($pos !== false)?'in active':'' }}">
						@include('widgets.borrower.tab.myloans_bidinfo')
					</div>
					<div id="menu2" class="tab-pane fade">
						@include('widgets.borrower.tab.myloans_loanupdates')
					</div>
				<?php }?>
			</div>
			<div class="row">	
				<div class="col-sm-12">			
					<div class="pull-right">	
						
						@if( ($BorModLoan->loan_status	==	LOAN_STATUS_APPROVED))
							@var	$preview	=	"projectdetails/".base64_encode($BorModLoan->loan_id)
							<input 	type="button" 
									value="Preview"
									id="preview_url"
									data-preview-url="{{url($preview)}}"
									class="btn verification-button"
								/>
						@endif
					</div>	
				</div>			 
			</div> 			
		</div>
	</div>								
</div>

	@endsection  
@stop
