@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/admin-loan-apply.js') }}" type="text/javascript"></script>		 
@endsection
@section('page_heading',Lang::get('Manage Loans') )
@section('section')  
@if($adminLoanApprMod->status	==	LOAN_STATUS_PENDING_COMMENTS)
	@var	$borrower_status	=	"corrections_required"
@else
	@var	$borrower_status	=	""
@endif
@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
	{{ '';$adminLoanApprMod->viewStatus	=	"disabled";''}}
	@var	$screenMode	=	"admin"

	@if( ($adminLoanApprMod->status	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL))
			@var	$commentButtonsVisibe	=	""
	@else
			@var	$commentButtonsVisibe	=	"disabled"
	@endif
@else
	@var	$screenMode	=	"borrower"
@endif
<div class="col-sm-12 space-around">
	
	<div class="panel-primary panel-container">
			@if($submitted)
				<div class="row">
					<div class="col-sm-12">
						<div class="annoucement-msg-container">
							<div class="alert alert-success">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									{{ Lang::get('Loan Apply submitted suceesfully') }}
							</div>
						</div>
					</div> 
				</div> 	
			@endif
			
			<div class="panel-heading panel-headsection"><!--panel head-->
				<div class="row">
					<div class="col-sm-12">
						<span class="pull-left">{{ Lang::get('LOAN APPROVAL')}}</span> 														
					</div>																
				</div>					
			</div><!--panel head end-->
			
			<form method="post" id="form-profile" name="form-profile">
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
				<input type="hidden" id="screen_mode" value="{{$screenMode}}">
				<input type="hidden" name="admin_process" id="admin_process" value="">
				<input type="hidden" name="hidden_borrower_status" id="borrower_status" value="{{$borrower_status}}">
				<input type="hidden" name="borrower_id" value="{{ $adminLoanApprMod->borrower_id }}">
				<div class="panel-body applyloan table-border-custom">	
					@if($adminLoanApprMod->status	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL)
						<div class="col-sm-12 text-right"> 	
							@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
								@if( $adminLoanApprMod->status	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL)
									@if($adminLoanApprMod->comments_count	==	0)				
										<button type="button" 
												class="btn verification-button"
												id="approve_loanapply_button">
											{{ Lang::get('Approve')}}
										</button>
									@endif
								@endif
							@endif
							<button type="button" 
									class="btn verification-button"
									id="cancel_loanapply_button">						
								{{ Lang::get('Cancel')}}</button>
							<button type="button" class="btn verification-button" id="save_comment_button">						
								{{ Lang::get('Save Comments')}}</button>
							@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
									@if( $adminLoanApprMod->status	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL)
										@if($adminLoanApprMod->comments_count	>	0)
											<button type="button" 
													class="btn verification-button"
													id="returnback_loanapply_button">						
													{{ Lang::get('Return to Borrower')}}
											</button>					
									@endif
								@endif
							@endif
						</div>
					@endif
					
						<div class="row">
							<div class="col-lg-12 col-md-6 col-xs-12 space-around">
								<ul class="nav nav-tabs">
									<li class="active">
										<a 	data-toggle="tab"
											href="#loan_details">
											{{ Lang::get('LOAN DETAILS') }}
										</a>
									</li>
									<li>
										<a 	data-toggle="tab"
											href="#comments">
											{{ Lang::get('COMMENTS') }}
										</a>
									</li>								
								</ul>					

								<div class="tab-content">						
									<!-------first-tab--------------------------------->
									@include('widgets.admin.tab.loanapproval_loandetails')
									<!-------second tab--starts------------------------>
									@include('widgets.admin.tab.loanapproval_comments')						
								</div><!--tab content-->
							</div>	
						</div>
				</div><!--panel-body--->
			</form>
	
	</div><!--panel-->
</div>	
<div style="display:none">
<input type="hidden" id="max_comment" value= "{{ count($adminLoanApprMod->commentsInfo) }}" />
	
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
				<div class="col-xs-9" id="comments_XXX_parent">
					<textarea 	rows="4" 
								cols="50" 
								class="form-control"
								name="comment_row[comments][]" 
								id="comments_XXX"
								></textarea>
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
	@endsection  
@stop
