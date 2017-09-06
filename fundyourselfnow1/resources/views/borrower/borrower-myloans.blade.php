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
	<!-- <script src="{{ asset('assets/scripts/frontend.js') }}" type="text/javascript"></script> -->
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
		$('.project_updates').summernote({height:100});
		
		function edit_update(id){
			var description = $('#updateDescription'+id).html();

			$('.updates_detail').hide();
			$('#loanUpdateId').val(id);
			$('.note-editable').html(description);
			$('#editupdates').show();
			$('#View_Update').show();

		}

		function add_update(){
			$('#Add_Update').hide();
			$('#editupdates').hide();
			$('.updates_detail').hide();
			$('#View_Update').show();
			$('#add_update_form').show();
			$('.note-editable').html('');
		}

		function view_update(){
			$('#View_Update').hide();
			$('#editupdates').hide();
			$('#add_update_form').hide();
			$('#Add_Update').show();
			$('.updates_detail').show();
		}

		function delete_update(update_id,id){
			alert(update_id);
			$.ajax({
  				method: "POST",
  				url: "<?php echo url('creator/delete_update');?>",
  				dataType:"json",
  				data: { loan_id: id, update_id : update_id},
  				success: function(data){
    				window.location.href = data;
  				}
			});
		}
	</script>
@endsection
@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
	@var	$heading	=	Lang::get('Manage Projects')	
@else
	@var $heading	=	Lang::get('borrower-loaninfo.page_heading')
@endif
@section('page_heading',$heading)
@section('body')     

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
      <div class="bg-dark dk" id="wrap">
                <div id="top">
                    <!-- .navbar -->
                   @include('header')
                    <!-- /.navbar -->
                        <header class="head">
                                <!--div class="search-bar">
                                    <form class="main-search" action="">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Live Search ...">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary btn-sm text-muted" type="button">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </form>
                                    <!-- /.main-search -->                                
                                <!-- /.search-bar -->
                            <div class="main-bar row">
							
							
							<div class="col-xs-6">
                                <h3>
              <i class="fa fa-google-wallet fa-fw"></i>
&nbsp;
            View Projects
          </h3></div>
		   <div class="col-xs-6 ">
		  <h3><span class="label label-default status-label pull-right">{{$BorModLoan->statusText}}</span></h3>
		  </div>
                           
                            <!-- /.main-bar -->
							</div>
							
							
                        </header>
                        <!-- /.head -->
                </div>
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
					@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
					<li><a data-toggle="tab" href="#menu4">Links</a></li> 
					@endif
				<?php }?>		
			</ul>
 
			<div class="tab-content myloan-wrapper">
				<div id="project_info" class="tab-pane fade {{ ($pos === false)?'in active':'' }}">
					@include('widgets.borrower.tab.applyloan_info',array("show_map"=>"no"))
				</div>
					<?php	
				if(($LoanDetMod->loan_status	==	LOAN_STATUS_APPROVED)) {
				?>
	
					<div id="menu3" class="tab-pane fade  {{ ($pos !== false)?'in active':'' }}">
						@include('widgets.borrower.tab.myloans_bidinfo')
					</div>
					<div id="menu2" class="tab-pane fade">
						@include('widgets.borrower.tab.myloans_loanupdates')
					</div>
					@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
					<div id="menu4" class="tab-pane fade">
					<ul>
					@if($datalinks)
					@foreach($datalinks as $links)
					<li style="list-style:outside none disc;margin-left: 10px; margin-top: 10px; padding-top: 10px;"><b>{{$links->name}}:</b>{{$links->link}}</li>
					@endforeach
					@endif
					</ul>
					</div>
					@endif
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
