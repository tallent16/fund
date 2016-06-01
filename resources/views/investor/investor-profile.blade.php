@extends('layouts.dashboard')
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 		 
@endsection
@section('bottomscripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>  
	<script>
		var baseUrl	=	"{{url('')}}"
		$(document).ready(function(){ 	
			$(":file").jfilestyle({buttonText: "Upload",buttonBefore: true,inputSize: '110px'});  // file upload  
		}); 
	</script>
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> 
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>	
	<script src="{{ url('js/jquery-filestyle.min.js') }}" type="text/javascript"></script>	
	<script src="{{ url('js/investor-profile.js') }}" type="text/javascript"></script>
	
@endsection
@section('page_heading',Lang::get('Profile') )
@section('status_button')						
		<!--------Status Button Section----> 
		<h4><span class="label label-default status-label">{{$InvPrfMod->statusText}}</span></h4>							
@endsection
@section('section')  		
@if(($InvPrfMod->status	==	INVESTOR_STATUS_COMMENTS_ON_ADMIN)
			|| (Auth::user()->usertype	==	USER_TYPE_ADMIN))
	@var	$canViewCommentsTab	=	"yes"
@else
	@var	$canViewCommentsTab	=	"no"
@endif
@if($InvPrfMod->status	==	INVESTOR_STATUS_COMMENTS_ON_ADMIN)
	@var	$investor_status	=	"corrections_required"
@else
	@var	$investor_status	=	""
@endif
@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
	{{ '';$InvPrfMod->viewStatus	=	"disabled";''}}
	@if($InvPrfMod->status	!=	INVESTOR_STATUS_NEW_PROFILE)
		{{ '';$InvPrfMod->viewStatus	=	"";''}}
	@endif
	@var	$screenMode	=	"admin"

	@if( ($InvPrfMod->status	==	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL))
			@var	$commentButtonsVisibe	=	""
	@else
			@var	$commentButtonsVisibe	=	"disabled"
	@endif
@else
	@var	$screenMode	=	"investor"
@endif
@if($InvPrfMod->investor_id	==	"")
	@var	$trantype	=	"add"
@else
	@var	$trantype	=	"edit"
@endif
@if(!isset($activeTab))
	@var	$activeTab	=	"inv_profile_info"
@endif
@if(session()->has("activeTab"))
	@var	$activeTab	=	session("activeTab")
@endif
<div class="col-sm-12 space-around"> 
	<div class="row">
		<div class="col-sm-12" style="display:none">
			<div class="annoucement-msg-container">
				<div class="alert alert-danger annoucement-msg">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{ Lang::get('Comments/remarks') }}
				</div>
			</div>
		</div>
		@if($submitted)
		<div class="col-sm-12">
			<div class="annoucement-msg-container">
				<div class="alert alert-success">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					{{ Lang::get('investor-profile.save') }}
				</div>
			</div>
		</div> 
			
		@endif
	</div>
	<form method="post" id="form-profile" name="form-profile"enctype="multipart/form-data" >
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="trantype" value="{{ $trantype }}">
			<input type="hidden" id="isSaveButton" name="isSaveButton" value="">
			<input type="hidden" name="investor_id" value="{{ $InvPrfMod->investor_id }}">
			<input type="hidden" id="user_id" value="{{ $InvPrfMod->user_id }}">
			<input type="hidden" name="investor_bankid" value="{{ $InvPrfMod->investor_bankid }}">
			<input type="hidden" id="screen_mode" value="{{$screenMode}}">
			<input type="hidden" id="active_tab" name="active_tab" value="{{$activeTab}}">
			<input type="hidden" name="current_profile_status" value="{{$InvPrfMod->status}}">
			<input 	type="hidden" 
					name="hidden_investor_status" 
					id="investor_status" 
					value="{{$investor_status}}">
			<input type="hidden" name="admin_process" id="admin_process" value="">
	
			<div class="row">					
				<div class="col-lg-12 col-md-6 col-xs-12">
						<!-----Tab Starts----->
						<ul class="nav nav-tabs">
							<li class="active">
								<a 	data-toggle="tab" 
									href="#inv_profile_info">
									{{ Lang::get('PROFILE INFO') }}
								</a>
							</li>
							<!--	@if(Auth::user()->username == "admin")-->
							<!--	@endif		-->	
							@if($canViewCommentsTab	==	"yes")
								<li class="">
									<a 	data-toggle="tab"
										href="#comments_info">
										{{ Lang::get('COMMENTS INFO') }}
									</a>
								</li>
							@endif
						</ul>	
				
					<div class="tab-content">
						<!-----First Tab content Starts----->
							@include('widgets.investor.tab.investor_profile_info')
						<!-----First Tab content end----->
						@if($canViewCommentsTab	==	"yes")
							<!-----Second Tab content starts----->
								@include('widgets.common.tab.profile_comments')
							<!-----Second Tab content ends----->	
						@endif					
					</div>	<!---col ends-->	
				</div>				
			</div>
			<div><p class="bg-warning">If you need to change your profile information, please drop an email to admin@fundyourselfnow.com</p></div> 
			<div class="col-sm-12 col-lg-12  space-around">
				<div class="pull-right">
				<!---mobile number update--->
				@if(Auth::user()->usertype	==	USER_TYPE_INVESTOR)
					@if(($InvPrfMod->status	==	INVESTOR_STATUS_VERIFIED)
						||	($InvPrfMod->status	==	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL) )
					
						<button type="button" 
								class="btn verification-button"
								id="update_mobile_button"
								>
								<i class="fa pull-right"></i>
								{{ Lang::get('Save') }}
						</button>
					
					@endif
				@endif	
				<!----->	
				@if(Auth::user()->usertype	==	USER_TYPE_INVESTOR)
					@if(($InvPrfMod->status	==	INVESTOR_STATUS_COMMENTS_ON_ADMIN)
						||	($InvPrfMod->status	==	INVESTOR_STATUS_NEW_PROFILE) )
					
								<button type="submit" 
										id="save_button"
									class="btn verification-button"
									{{$InvPrfMod->viewStatus}} >
									<i class="fa pull-right"></i>
										{{ Lang::get('Save') }}
								</button>
						
					@endif
				@endif
				@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
					@if($InvPrfMod->status	!=	INVESTOR_STATUS_NEW_PROFILE)
						<button type="submit" 
								id="admin_save_button"
							class="btn verification-button" >
							<i class="fa pull-right"></i>
							{{ Lang::get('Save') }}
						</button>
					@endif
				@endif
				@if(Auth::user()->usertype	==	USER_TYPE_INVESTOR)
					@if(($InvPrfMod->status	==	INVESTOR_STATUS_COMMENTS_ON_ADMIN)
						||	($InvPrfMod->status	==	INVESTOR_STATUS_NEW_PROFILE) )
					<button type="submit" 
							id="submit_button"
							class="btn verification-button"
							>
						<i class="fa pull-right"></i>
						{{ Lang::get('Submit for verification') }}
					</button>
					@endif
				@endif
				
				@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
					@if( $InvPrfMod->status	==	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL)
						@permission('returninvestor.admin.manageinvestors')
								<button type="button"
										id="returnback_button"
										style="display:none"
										class="btn verification-button"
										data-screen-type="investor"
									<i class="fa pull-right"></i>
									{{ Lang::get('Return to Investor') }}
								</button>
						@endpermission
					@endif
				@endif
				
				@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
					@if( $InvPrfMod->status	==	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL)
						@permission('approve.admin.manageinvestors')
								<button type="button"
										id="approve_profile_button"
										class="btn verification-button"
										data-screen-type="investor"
									<i class="fa pull-right"></i>
									{{ Lang::get('Approve Profile') }}
								</button>
						@endpermission
					@endif
				@endif
			</div>
		</div>		
	</form>          	  
</div><!-----col--12--->

  <div style="display:none">

	<input type="hidden" id="max_comment" value= "{{ count($InvPrfMod->commentsInfo) }}" />
	
	<div id="commentTemplate">
		<div class="row" id="comment-row-XXX">
			<div class="col-xs-12 space-around">
				<div class="col-xs-1">
					<input 	type="checkbox" 
							name="comment_row[comment_id][]" 
							id="comment_id_XXX"
							data-row-id="XXX"
							class="select_comment"
							value="">
							<input 	type="hidden" 
									name="comment_row[comment_id_hidden][]"
									value="">
				</div>
				<div class="col-xs-5" id="comments_XXX_parent">
					<div class="col-xs-10">
						<textarea 	rows="4" 
									cols="50" 
									class="form-control"
									name="comment_row[comments][]" 
									id="comments_XXX"
									></textarea>
						<input 	type="hidden" 
								name="comment_row[comments_reply_id][]" 
								value="" />
						<textarea 	rows="4" 
									cols="50" 
									disabled
									style="display:none"
									class="form-control"
									name="comment_row[comments_reply][]" 
									id="comments_reply_boxXXX"></textarea>
					</div>
				</div>
				<div class="col-xs-2 text-right">
					<input 	type="checkbox" 
							name="comment_row[comment_status][]" 
							id="comment_status_XXX"
							class="commentClass"
							>
					<input 	type="hidden" 
							name="comment_row[comment_status_hidden][]" 
							id="comment_status_hidden_XXX"
							value="1">
				</div>
			</div>
		</div>
	</div>
	
</div>
  @endsection  
@stop
