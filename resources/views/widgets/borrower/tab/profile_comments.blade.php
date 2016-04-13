@var	$commentsInfo	=	$modelBorPrf->commentsInfo
@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
	@var	$showCommentSelectAll	=	"yes"
	@var	$editCommentInput		=	""
@else
	@var	$showCommentSelectAll	=	"no"
	@var	$editCommentInput		=	"disabled"
@endif
@var	$inputTabInfo	=	array("company info"=>"company info","director info"=>"director info")
@var	$inputTabInfo["profile info"]	=	"profile info"
@var	$inputTabInfo["finacial info"]	=	"finacial info"
@var	$inputTabInfo["bank info"]		=	"bank info"
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
									<div class="col-xs-9 col-lg-4">
										<span class="pull-left">{{ Lang::get('Input Tab') }}</span> 
									</div>
									<div class="col-xs-9 col-lg-5">
										<span class="pull-left">{{ Lang::get('Comments') }}</span> 
									</div>
									<div class="col-xs-2 col-lg-2 text-right">
										{{ Lang::get('Closed') }}
									</div>
								</div>
							</div>
						</div>
					</div>
					@if(count($commentsInfo) > 0)
						@foreach($commentsInfo as $commentRow)
							@if($commentRow['comment_status']	==	BORROWER_COMMENT_CLOSED)
								@var	$checked	=	"checked"
							@else
								@var	$checked	=	""
							@endif
							<div class="row">
								<div class="col-xs-12 space-around">
									@if($showCommentSelectAll	==	"yes")
										<div class="col-xs-1">
											<input 	type="checkbox" 
													name="comment_row[comment_id][]" 
													id="comment_id_{{$commentRow['profile_comments_id']}}"
													value="{{ $commentRow['profile_comments_id']}}"><br>
										</div>
									@endif
									<div class="col-xs-4">
										{{ Form::select('comment_row[input_tab][]',$inputTabInfo, $commentRow['input_tab'] , 
																['class' => 'selectpicker text-right required',
																'id'=>'input_tab_'.$commentRow['profile_comments_id']
																,($editCommentInput=="")?null:$editCommentInput]) 
										}}
									</div>
									<div class="col-xs-5">
										<textarea 	rows="4" 
													cols="50" 
													class="form-control"
													name="comment_row[comments][]" 
													id="comments_{{$commentRow['profile_comments_id']}}"
													{{$editCommentInput}}>{{$commentRow['comments']}}</textarea>
									</div>
									<div class="col-xs-2 text-right">
										<input 	type="checkbox" 
												name="comment_row[comment_status][]" 
												id="comment_status_{{$commentRow['profile_comments_id']}}"
												{{$checked}}>
									</div>
								</div>
							</div>
						@endforeach
					@endif
				</div>
				
			</div>
			@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
				@if($gradeStatus	==	"")
					<div class="row"> 
						<div class="col-sm-12 space-around"> 
							<div class="pull-right">
								<button type="button" id="add_comment_button"	class="btn verification-button">
								<i class="fa pull-right"></i>
								Add Comment</button>
								<button type="button" id="delete_comment_button"  class="btn verification-button">
								<i class="fa pull-right"></i>
								Remove Comment
								</button>
								<button type="button" id="save_comment_button" class="btn verification-button">
								<i class="fa pull-right"></i>
								Save Comment
								</button>
							</div>
						</div>
					</div>
				@endif
			@endif
		</div>
	</div>
</div>
