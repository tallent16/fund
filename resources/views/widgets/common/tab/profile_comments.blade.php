
@var	$commentsInfo		=	$InvBorPrf->commentsInfo
@var	$commentsReplyInfo	=	$InvBorPrf->commentsReplyInfo

@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
	@var	$showCommentSelectAll	=	"yes"
	@var	$editCommentInput		=	""
@else
	@var	$showCommentSelectAll	=	"no"
	@var	$editCommentInput		=	"disabled"
@endif

<div id="comments_info" class="tab-pane fade">  
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
									@if( (Auth::user()->usertype	==	USER_TYPE_BORROWER) 
										|| (isset($user_type) && $user_type	==	"borrower") )
										<div class="col-xs-9 col-lg-4">
											<span class="pull-left">{{ Lang::get('Input Tab') }}</span> 
										</div>
									@endif
									<div class="col-xs-9 col-lg-5">
										<span class="pull-left">{{ Lang::get('Comments') }}</span> 
									</div>
									<div class="col-xs-2 col-lg-2 text-right">
										{{ Lang::get('Closed') }}
									</div>
								</div>
							</div>
						</div>
						@if(count($commentsInfo) == 0)							
							<div class="col-sm-12 table-border-custom">
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
								@if($commentRow['comment_status']	==	BORROWER_COMMENT_CLOSED)
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
														value="{{ $commentRow['profile_comments_id']}}"><br>
											</div>
										@endif
										@var	$disabledReply	=	""
										@if( (Auth::user()->usertype	==	USER_TYPE_BORROWER) 
											|| (isset($user_type) && $user_type	==	"borrower") )
											<div class="col-xs-4">
												{{ Form::select('comment_row[input_tab][]',$inputTabInfo, $commentRow['input_tab'] , 
																		['class' => 'inputTabDropDown selectpicker text-right required',
																		'id'=>'input_tab_'.$i
																		,($editCommentInput=="")?null:$editCommentInput]) 
												}}
											</div>
										@endif
										@if( Auth::user()->usertype	==	USER_TYPE_ADMIN)
											@var	$disabledReply	=	"disabled"
										@endif
										<div class="col-xs-5" id="comments_{{$i}}_parent">
											<div class="col-xs-10">
												<textarea 	rows="4" 
															cols="50" 
															class="form-control"
															name="comment_row[comments][]" 
															id="comments_{{$i}}"
															{{$editCommentInput}}>{{$commentRow['comments']}}</textarea>
												
													<input type="hidden" 
															name="comment_row[comments_id][]" 
															value="{{$commentRow['profile_comments_id']}}" />
													@var	$commentId	=	$commentRow['profile_comments_id']
													
													@if(isset($commentsReplyInfo['id'][$commentId])) 
														@var	$replyText	=	$commentsReplyInfo['text'][$commentId]
														@var	$replyId	=	$commentsReplyInfo['id'][$commentId]
														@var	$showReply	=	"style='display:block;'"
													@else
														@var	$replyText	=	""
														@var	$replyId	=	0
														@var	$showReply	=	"style='display:none;'"
													@endif
													<input 	type="hidden" 
															name="comment_row[comments_reply_id][]" 
															value="{{$replyId}}" />
													<textarea 	rows="4" 
																cols="50" 
																{{$showReply}}
																{{$disabledReply}}
																class="form-control"
																name="comment_row[comments_reply][]" 
																id="comments_reply_box{{$i}}">{{$replyText}}</textarea>
													
												
											</div>
											@if( (Auth::user()->usertype	==	USER_TYPE_BORROWER)
															|| (Auth::user()->usertype	==	USER_TYPE_INVESTOR)) 
												@var	$replyboxId	=	"comments_reply_box".$i
												<div class="col-xs-2">
													<div style="position:relative;padding:20px;">
														<input type="button" 
																value="reply" 
																onclick="writeReply('{{$replyboxId}}')" >
													</div>
													
												</div>
											@endif
										</div>
										<div class="col-xs-2 text-right">
											<input 	type="checkbox" 
													name="comment_row[comment_status][]" 
													id="comment_status_{{$i}}"
													class="commentClass"
													{{$checked}}>
											<input 	type="hidden" 
													name="comment_row[comment_status_hidden][]" 
													id="comment_status_hidden_{{$i}}"
													value="{{$commentRow['comment_status']}}">
											<input 	type="hidden" 
														name="comment_row[comment_id_hidden][]"
														value="{{ $commentRow['profile_comments_id']}}">
										</div>
									</div>
								</div>
								@var	$i++
							@endforeach
						@endif
					</div>
				</div>
				
			</div>
			@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
				@if($commentButtonsVisibe	==	"")
					<div class="row"> 
						<div class="col-sm-12 space-around"> 
							<div class="pull-right">
								<button type="button" id="add_comment_button"	class="btn verification-button">
								<i class="fa pull-right"></i>
								{{ Lang::get('Add Comment')}}
								</button>
								<button type="button" id="delete_comment_button"  class="btn verification-button">
								<i class="fa pull-right"></i>
								{{ Lang::get('Remove Comment')}}
								</button>
								@permission('admin.savecomment')
									<button type="button" id="save_comment_button" class="btn verification-button">
										<i class="fa pull-right"></i>
										{{ Lang::get('Save Comment')}}
									</button>
								@endpermission
							</div>
						</div>
					</div>
				@endif
			@endif
		</div>
	</div>
</div>
