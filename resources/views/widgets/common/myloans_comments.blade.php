<div class="col-md-12 comments-section">	
	@var	$loanID		=	$LoanDetMod->loan_id
	@var	$userID	=	Auth::user()->user_id
	@if($LoanDetMod->userType	==	USER_TYPE_INVESTOR	)
		<div class="writeCommentDivBlock" style="margin-bottom:15px;">
			<div class="row">						
				
					<textarea	id="newCommentBoxInput" 
								class="form-control"
								placeholder="Write Comment"></textarea>
				
			</div>
			<div class="row">						
				
					<div class="pull-right">
						<p>
																
							<button type="button" id="newCommentBoxButton" class="col-md-2 btn verification-button submit_comment">
								<i class="fa fa-plus-circle"></i> {{ Lang::get('Post') }}
							</button>
							
						</p>
					</div>
					<br>
				
			</div>
		</div>
	@endif
	<div class="mainCommentDivBlock">
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
								data-reply-id="{{$commentRow['comments_id']}}">
								<span class="comments-reply">
									<i class="fa fa-arrow-left"></i> {{ Lang::get('reply') }}</span></p>
						</div>		
						<!--Reply Block starts -->
						<div class="col-md-12" id="replyBlock-{{$commentRow['comments_id']}}">	
						@foreach($commnetInfo as $ReplyRow)
							@if($ReplyRow['in_response_to']	==	$commentRow['comments_id'])
									<div class="row col-md-offset-1">						
										<div class="col-md-6 col-lg-7">
											<i class="fa fa-user panel-subhead"></i>  
											<span class="loan-comments">
												{{$ReplyRow['username']}}
											</span>
										</div>
										<div class="col-md-6 col-lg-5 text-right">
											<span class="loan-comments">
												{{$LoanDetMod->getTimeAgo($ReplyRow['comment_datetime'])}}
												</span>
										</div>
										<div class="col-md-12">
											<p>{{$ReplyRow['comments_text']}}</p>
											<p class="loan-comments text-right replyLink"
												data-reply-id="{{$commentRow['comments_id']}}"><span class="comments-reply">
													<i class="fa fa-arrow-left"></i> {{ Lang::get('reply') }}</span></p>
										</div>		
									</div>
							@endif
						@endforeach
						</div>
						<!--Reply Block starts -->
					
							<div class="col-md-12" 
									id="commentBoxDiv-{{$commentRow['comments_id']}}">
								<textarea	id="commentBoxInput-{{$commentRow['comments_id']}}" 
											class="col-md-10 form-control"
											rows=1></textarea>
								<div class="pull-right space-around">
									
									<button type="button" id="{{$commentRow['comments_id']}}" style="padding:3px 5px 3px 5px" 
										class="col-md-2 btn verification-button submit_reply">
										<i class="fa fa-plus-circle"></i> {{ Lang::get('Add	') }}
									</button>								
								
								</div>
								<input type="hidden" id="loanID-{{$commentRow['comments_id']}}" value="{{$loanID}}" />
								<input type="hidden" id="commentUser-{{$commentRow['comments_id']}}" value="{{$userID}}" />
			
						</div>
					</div>
			@endif
		@endforeach
	</div>
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
				{{ Lang::get('Just Now') }}
				</span>
		</div>
		<div class="col-md-12">
			<p>{{ Lang::get('COMMENTTEXT') }}</p>
			<p class="loan-comments text-right replyLink"
				data-reply-id="COMMENTID"><span class="comments-reply"><i class="fa fa-arrow-left"></i> {{ Lang::get('reply') }}</span></p>
		</div>		
	</div>
</div>
<div style="display:none" id="commentTemplate">
	<div class="row">						
		<div class="col-md-6">
			<i class="fa fa-user panel-subhead"></i>  
			<span class="loan-comments">
				{{Auth::user()->username}}
			</span>
		</div>
		<div class="col-md-6 text-right">
			<span class="loan-comments">
				{{ Lang::get('Just Now') }}
				</span>
		</div>
		<div class="col-md-12">
			<p>{{ Lang::get('COMMENTTEXT') }}</p>
			<p class="loan-comments text-right replyLink"
				data-reply-id="XXX"><span class="comments-reply"><i class="fa fa-arrow-left"></i> {{ Lang::get('reply') }}</span></p>
		</div>		
		<!--Reply Block starts -->
		<div class="col-md-12" id="replyBlock-XXX">	
	
		</div>
		<!--Reply Block starts -->
		<div 	class="col-md-12" 
				id="commentBoxDiv-XXX">
			<textarea	id="commentBoxInput-XXX" 
						class="col-md-10"
						rows=1></textarea>
			<div class="pull-right space-around">
				<button type="button" id="XXX" style="padding:3px 5px 3px 5px" 
						class="col-md-2 btn verification-button submit_reply">
						<i class="fa fa-plus-circle"></i> {{ Lang::get('Add	') }}
				</button>		
			</div>
			<input type="hidden" id="loanID-XXX" value="{{$loanID}}" />
			<input type="hidden" id="commentUser-XXX" value="{{$userID}}" />
		</div>
	</div>
</div>
