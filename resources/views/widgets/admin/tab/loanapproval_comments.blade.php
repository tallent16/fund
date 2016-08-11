

@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
	@var	$showCommentSelectAll	=	"yes"
	@var	$editCommentInput		=	""
	@var	$commentsInfo			=	$adminLoanApprMod->commentsInfo
@else
	@var	$showCommentSelectAll	=	"no"
	@var	$editCommentInput		=	"disabled"
	@var	$commentsInfo			=	$BorModLoan->commentsInfo
@endif
<div id="comments" class="tab-pane fade">  
	<div class="panel panel-default directorinfo applyloan"> 
		<div class="panel-body">
			<div class="row">
				
				<div class="col-sm-12">
					<div class="panel-primary panel-container">
						<div class="panel-heading panel-headsection"><!--panel head-->
							
							<div class="row">
								<div class="col-xs-12">
									@if($showCommentSelectAll	==	"yes")
										<div class="col-xs-1 col-lg-1">
											<input type="checkbox" id="select_all_comments" ><br>
										</div>
									@endif
									<div class="col-xs-9 col-lg-9">
										<span class="pull-left">{{Lang::get('Comments')}}</span> 
									</div>
									<div class="col-xs-2 col-lg-2 text-right">
										{{Lang::get('Closed')}}
									</div>
								</div>
							</div>
							
							
						</div>
						@if(count($commentsInfo) == 0)							
							<div class="col-sm-12 table-border-custom hide-comments">
								<div>&nbsp;</div>
								<div>&nbsp;</div>
								<div>&nbsp;</div>
								<div class="text-center">No Comments to Display</div> 
								<div>&nbsp;</div>
								<div>&nbsp;</div>
								<div>&nbsp;</div>
								<div>&nbsp;</div>
							</div>
						@endif
					</div>
					<div id="commentBoxContainer">
						@if(count($commentsInfo) > 0)
							@var	$i	=	1
							@foreach($commentsInfo as $commentRow)
								@if($commentRow['comments_status']	==	PROFILE_COMMENT_CLOSED)
									@var	$checked	=	"checked"
								@else
									@var	$checked	=	""
								@endif
								<div class="row" id="comment-row-{{$i}}">
									<div class="col-xs-12 space-around">
										@if($showCommentSelectAll	==	"yes")
											<div class="col-xs-1">
												<input 	type="checkbox" 
														name="comment_row[comment_id][]" 
														id="comment_id_{{$i}}"
														data-row-id="{{$i}}"
														class="select_comment"
														value="{{ $commentRow['loan_approval_comments_id']}}"><br>
											</div>
										@endif
										<div class="col-xs-9" id="comments_{{$i}}_parent">
											<textarea 	rows="4" 
														cols="50" 
														class="form-control"
														name="comment_row[comments][]" 
														id="comments_{{$i}}"
														{{$editCommentInput}}>{{$commentRow['comemnt_text']}}</textarea>
										</div>
										<div class="col-xs-2 text-right">
											<input 	type="checkbox" 
													name="comment_row[comments_status][]" 
													id="comment_status_{{$i}}"
													class="commentClass"
													{{$checked}}>
											<input 	type="hidden" 
													name="comment_row[comment_status_hidden][]" 
													id="comment_status_hidden_{{$i}}"
													value="{{$commentRow['comments_status']}}">
											<input 	type="hidden" 
														name="comment_row[comment_id_hidden][]"
														value="{{ $commentRow['loan_approval_comments_id']}}">
										</div>
									</div>
								</div>
								@var	$i++
							@endforeach
							
						@endif
					</div>
				</div>
			</div>
				
			</div>
			@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
				@if($commentButtonsVisibe	==	"")
			
					<div class="row"> 
						<div class="col-sm-12 space-around"> 
							<div class="pull-right">
								<button type="button" id="add_loanapply_comment_button"	class="btn verification-button">
								<i class="fa pull-right"></i>
								{{Lang::get('Add Comments')}}
								</button>
								<button type="button" id="delete_comment_button"  class="btn verification-button">
								<i class="fa pull-right"></i>
								{{Lang::get('Delete Comments')}}
								</button>
								<button type="button" id="close_comment_button" class="btn verification-button">
								<i class="fa pull-right"></i>
								{{Lang::get('Close Comments')}}
								</button>
							</div>
						</div>
					</div>
				@endif	
			@endif
		</div>
	</div>
</div>
