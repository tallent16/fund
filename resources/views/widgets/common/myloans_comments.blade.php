<div class="col-md-12 comments-section">	
	@var	$loanID		=	$LoanDetMod->loan_id
	@var	$userID	=	Auth::user()->user_id
	@foreach($commnetInfo as $commentRow)	
		@if($commentRow['in_response_to']	==	"")
			<div class="row">						
				<div class="col-md-6">
					<i class="fa fa-user panel-subhead"></i>  
					<span class="loan-comments">
						{{$commentRow['username']}}
					</span>
				</div>
				<div class="col-md-6 text-right">
					<span class="loan-comments">
						{{$LoanDetMod->getTimeAgo($commentRow['comment_datetime']) }}
						</span>
				</div>
				<div class="col-md-12">
					<p>{{$commentRow['comments_text']}}</p>
					<p class="loan-comments text-right replyLink"
						data-reply-id="{{$commentRow['comments_id']}}">reply</p>
				</div>		
				<!--Reply Block starts -->
				<div class="col-md-12" id="replyBlock-{{$commentRow['comments_id']}}">	
				@foreach($commnetInfo as $ReplyRow)
					@if($ReplyRow['in_response_to']	==	$commentRow['comments_id'])
							<div class="row col-md-offset-1">						
								<div class="col-md-6">
									<i class="fa fa-user panel-subhead"></i>  
									<span class="loan-comments">
										{{$ReplyRow['username']}}
									</span>
								</div>
								<div class="col-md-6 text-right">
									<span class="loan-comments">
										{{$LoanDetMod->getTimeAgo($ReplyRow['comment_datetime'])}}
										</span>
								</div>
								<div class="col-md-12">
									<p>{{$ReplyRow['comments_text']}}</p>
									<p class="loan-comments text-right replyLink"
										data-reply-id="{{$commentRow['comments_id']}}">reply</p>
								</div>		
							</div>
					@endif
				@endforeach
				</div>
				<!--Reply Block starts -->
				<div 	class="col-md-12" 
						id="commentBoxDiv-{{$commentRow['comments_id']}}">
					<textarea	id="commentBoxInput-{{$commentRow['comments_id']}}" 
								class="col-md-10"
								rows=1></textarea>
					<input 	type="button" 
							id="{{$commentRow['comments_id']}}" 
							class="col-md-2 btn verification-button submit_comment"
							value="Add"
							style="padding:6px">
					<input type="hidden" id="loanID-{{$commentRow['comments_id']}}" value="{{$loanID}}" />
					<input type="hidden" id="commentUser-{{$commentRow['comments_id']}}" value="{{$userID}}" />
				</div>
			</div>
	@endif
@endforeach
</div>
<div style="display:none" id="replyTemplate">
	<div class="row col-md-offset-1">						
		<div class="col-md-6">
			<i class="fa fa-user panel-subhead"></i>  
			<span class="loan-comments">
				{{Auth::user()->username}}
			</span>
		</div>
		<div class="col-md-6 text-right">
			<span class="loan-comments">
				Just Now
				</span>
		</div>
		<div class="col-md-12">
			<p>COMMENTTEXT</p>
			<p class="loan-comments text-right replyLink"
				data-reply-id="COMMENTID">reply</p>
		</div>		
	</div>
</div>
