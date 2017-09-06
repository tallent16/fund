@extends('layouts.plane')

@section('page_heading',Lang::get('Crowd Funding'))  
@section('bottomscripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script>
		var baseUrl	=	"{{url('')}}"
		$(document).ready(function(){ 	
			$(".jfilestyle").jfilestyle({buttonText: "Upload",buttonBefore: true,inputSize: '110px'});  // file upload  
			$('#company_profile').summernote({height:300});
			$('#about_us').summernote({height:300});
			@if($modelBorPrf->viewStatus	==	"disabled")
				$('#company_profile').summernote('disable');
				$('#about_us').summernote('disable');
			@endif
			
			$( "textarea[name='director_row[accomplishments][]'" ).each(function() {
				var id	=	$(this).attr("id");
				if(	id	!=	"accomplishments_XXX") {
					$(this).summernote({height:300}); 
					@if($modelBorPrf->viewStatus	==	"disabled")
						$(this).summernote('disable');
					@endif
				}
			});
			
			$( "textarea[name='director_row[directors_profile][]'" ).each(function() {
				var id	=	$(this).attr("id");
				if(	id	!=	"directors_profile_XXX") {
					$(this).summernote({height:300}); 
					@if($modelBorPrf->viewStatus	==	"disabled")
						$(this).summernote('disable');
					@endif
				}
			});
		}); 
	</script>	 
	
@endsection 
@section('section')   
		@var	$inputTabInfo	=	array("company info"=>"company info","director info"=>"director info")
		@var	$inputTabInfo["profile info"]	=	"profile info"
		@var	$inputTabInfo["finacial info"]	=	"finacial info"
		@var	$inputTabInfo["bank info"]		=	"bank info"
		@var	$canViewProfileInfoTab			=	"yes"
		
		@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
			@var	$canViewFinacialRatioTab	=	"yes"
		@else
			@if($modelBorPrf->status	==	BORROWER_STATUS_VERIFIED)
				@var	$canViewFinacialRatioTab	=	"yes"
			@else
				@var	$canViewFinacialRatioTab	=	"no"
			@endif
		@endif
		
		@if(($modelBorPrf->status	==	BORROWER_STATUS_COMMENTS_ON_ADMIN)
			|| (Auth::user()->usertype	==	USER_TYPE_ADMIN))
			@var	$canViewCommentsTab	=	"yes"
		@else
			@var	$canViewCommentsTab	=	"no"
		@endif
		@if($modelBorPrf->status	==	BORROWER_STATUS_COMMENTS_ON_ADMIN)
			@var	$borrower_status	=	"corrections_required"
		@else
			@var	$borrower_status	=	""
		@endif
		@if($modelBorPrf->borrower_id	==	"")
			@var	$trantype	=	"add"
		@else
			@var	$trantype	=	"edit"
		@endif
		@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
			{{ '';$modelBorPrf->viewStatus	=	"disabled";''}}
			@if($modelBorPrf->status	!=	BORROWER_STATUS_NEW_PROFILE)
				{{ '';$modelBorPrf->viewStatus	=	"";''}}
			@endif
			@var	$screenMode	=	"admin"
			@var	$gradeStatus	=	""
			@if( ($modelBorPrf->status	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL))
					@var	$commentButtonsVisibe	=	""
			@else
					@var	$commentButtonsVisibe	=	"disabled"
			@endif
		@else
		
			@var	$screenMode	=	"borrower"
			@var	$gradeStatus	=	"disabled"
		@endif
		@if(!isset($activeTab))
			@var	$activeTab	=	"company_info"
		@endif
		@if(session()->has("activeTab"))
			@var	$activeTab	=	session("activeTab")
		@endif
		@if(Auth::user()->usertype	==	USER_TYPE_BORROWER)
			@if( ($modelBorPrf->company_profile=="") || 
				($modelBorPrf->company_aboutus==""))
				@var $profile_info_tab	=	0
			@else
				@var $profile_info_tab	=	1
			@endif
		@else
			@var $profile_info_tab	=	1
		@endif

@section('body')
<div class="bg-dark dk" id="wrap">
                <div id="top">

 @include('header',array('class'=>'',))




	   
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
              <i class="fa fa-user" aria-hidden="true"></i>
&nbsp;
            Profile
          </h3>
		  </div>
		  <div class="col-xs-6 ">
		  <h3><span class="label label-default status-label pull-right">{{$modelBorPrf->statusText}}</span></h3>
		  </div>
                            </div>
                            <!-- /.main-bar -->
						
							
                        </header>
                        <!-- /.head -->
                </div>
 <div id="content">
                    <div class="outer">
                        <div class="inner1 bg-light lter">
						<div class="row">  
				   
												
																
																									
																												<!-----Body Content----->
		<div class="col-sm-12 space-around"> 
			<form method="post" id="form-profile" name="form-profile" enctype="multipart/form-data">
				<input type="hidden" name="_token" id="_token" value="u4e9tp0XvhdZIcoimhUSZW4pn0LbLnu3yh3I2kaK">
				<input type="hidden" name="trantype" value="edit">
				<input type="hidden" id="isSaveButton" name="isSaveButton" value="">
				<input type="hidden" name="borrower_id" value="4">
				<input type="hidden" name="borrower_bankid" value="3">
				<input type="hidden" id="screen_mode" value="borrower">
				<input type="hidden" name="hidden_borrower_status" id="borrower_status" value="">
				<input type="hidden" name="current_profile_status" value="4">
				<input type="hidden" id="profile_status" value="Verified">
				<input type="hidden" name="admin_process" id="admin_process" value="">
				<input type="hidden" id="company_info_complete" value="1">
				<input type="hidden" id="director_info_complete" value="1">
				<input type="hidden" id="profile_info_complete" value="1">
				<input type="hidden" id="bank_info_complete" value="1">
				<input type="hidden" id="active_tab" name="active_tab" value="#company_info">
				<div class="row">	
					
					<div class="col-lg-12 col-md-12 col-xs-12">
						<!-----Tab Starts----->
						<ul class="nav nav-tabs">
							<li class="active" id="company_info_parent" >
								<a 	data-toggle="tab" 
									href="#company_info">
									COMPANY INFO
								</a>
							</li>
							<li class="disabled" id="director_info_parent">
								<a 	data-toggle="tab"
									href="#director_info">
									TEAM INFO
								</a>
							</li>      
								  
								<li  class="disabled"  id="profile_info_parent">
									<a 	data-toggle="tab"
										href="#profile_info">
										PROFILE INFO
									</a>
								</li>	
							<!--
															<li id="financial_ratio_parent">
									<a 	data-toggle="tab"
										href="#financial_ratio">
										FINANCIAL RATIO
									</a>
								</li>	
															<li  class="disabled"  id="financial_info_parent">
									<a 	data-toggle="tab"
										href="#financial_info">
										FINANCIAL INFO
									</a>
								</li>	
-->
							
							<li class="disabled" id="bank_info_parent" >
								<a 	data-toggle="tab"
									href="#bank_info">
									BANK INFO
								</a>
							</li>	
													<!--			-->			   							
						</ul>	
		<div class="tab-content">


<!-----First Tab content Starts----->
							@include('widgets.borrower.tab.profile_company_info')
						<!-----First Tab content end----->
						
						<!-----Second Tab content starts----->
							@include('widgets.borrower.tab.profile_directory_info')
						<!-----Second Tab content ends----->
						@if($canViewProfileInfoTab	==	"yes")
							<!-----Third Tab content starts----->
								@include('widgets.borrower.tab.profile_info')
							<!-----Third Tab content ends----->	
						@endif
<!--
						@if($canViewFinacialRatioTab	==	"yes")
-->
							<!-----Four Tab content starts----->
<!--
								@include('widgets.borrower.tab.profile_financial_ratio')

							<!-----Four Tab content ends----->	
<!--
						@endif

						<!-----Four Tab content starts----->
<!--
							@include('widgets.borrower.tab.profile_financial_info')

						<!-----Four Tab content ends----->	
						
						<!-----Five Tab content starts----->
							@include('widgets.borrower.tab.profile_bank_info')
						<!-----Five Tab content ends----->	
						@if($canViewCommentsTab	==	"yes")
							<!-----Sixth Tab content starts----->
								@include('widgets.common.tab.profile_comments')
							<!-----Sixth Tab content ends----->
						@endif


						<!-----Five Tab content ends----->	
												
					</div>	<!---col ends-->	
				
					
						<div class="col-sm-12"> 
							<div class="pull-right">
								
								
																																																																																											
																
														</div>
						</div> 
				
				
			</div><!--row end-->
		</form>
	</div>
 </div>
<div style="display:none">
<input type="hidden" id="max_director" value= "3" />
<input type="hidden" id="max_comment" value= "0" />
	<div  id="directorTemplate">
		<div id="XXX" class="dir-list">
			<div class="table-responsive">
			<table class="table table-bordered .tab-fontsize text-left">		
				
				<tr>
					<td class="col-md-3">
						<label class="input-required">
							Name
						</label>
					</td>
					<td class="col-md-3"  id="name_XXX_parent" colspan="3">
						<input  type="hidden"
								name="director_row[id][]"
								value="0" />

						<input 	type="text" 
								id="name_XXX" 
								name="director_row[name][]"
								class="form-control required"
								placeholder="Director Name"
								/>
					</td>
						
				</tr>
				<tr>
					<td class="col-md-3">
						<label class="input-required">
						Age
						</label>
					</td>
					<td class="col-md-3" id="age_XXX_parent" >
						<input 	type="text" 
								id="age_XXX" 
								name="director_row[age][]"
								class="form-control text-right num required"
								/>
					</td>	
					<td class="col-md-3">
						<label class="input-required">
						Overall experience in years
						</label>
					</td>
					<td class="col-md-3" id="overall_experience_XXX_parent"  colspan="3">
						<input 	type="text" 
								id="overall_experience_XXX" 
								name="director_row[overall_experience][]"
								class="form-control text-right num required"
								/>
					</td>	
				</tr>
				<tr>
					<td  class="col-md-3">
						<label class="input-required">
							Team Member Information
						</label>
					</td>
					<td colspan="3" class="col-md-3" 	id="directors_profile_XXX_parent">
						<textarea	id="directors_profile_XXX" 
									name="director_row[directors_profile][]"
									class="form-control required"
									rows="6"
								></textarea>
					</td>		
				</tr>
				<tr>
					<td  class="col-md-3">
						Accomplishments/Other info
					</td>
					<td colspan="3" class="col-md-3">
						<textarea	id="accomplishments_XXX" 
									name="director_row[accomplishments][]"
									class="form-control accomplishments"
									data-toggle="tooltip"
									title="Please put down a short description of your work experience, important milestones and awards"
									rows="6"
								></textarea>
					</td>
				</tr>
				<tr>
					<td class="col-md-3">
						<label class="">
							Identification Document
						</label>
					</td>
					<td colspan="3" class="col-md-3" id="identity_card_front_XXX_parent">
						<input 	type="file" 
								class="attachment" 
								data-buttonBefore="true" 
								name="director_row[identity_card_front][]"
								id="identity_card_front_XXX" />
																									
						<input 	type="hidden" 
								id="identity_card_front_XXX_hidden"
								name="director_row[identity_card_front_hidden][]"
								value=""
								/>		
					</td>
				</tr>													
<!--
				<tr>
					<td class="col-md-3">
						<label class="input-required">
							Identity Card Back
						</label>
					</td>
					<td colspan="3" class="col-md-3" id="identity_card_back_XXX_parent">
						<input 	type="file" 
								class="required attachment" 
								data-buttonBefore="true" 
								name="director_row[identity_card_back][]"
								id="identity_card_back_XXX" />
				
						<input 	type="hidden" 
								id="identity_card_back_XXX_hidden"
								name="director_row[identity_card_back_hidden][]"
								value=""
								/>		
					</td>
				</tr>																		
-->
			</table></div>
		</div>
	</div>
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
									value=0>
				</div>
				
				<div class="col-xs-4">
					<select class="inputTabDropDown text-right required" id="input_tab_XXX" name="comment_row[input_tab][]"><option value="company info">company info</option><option value="director info">director info</option><option value="profile info">profile info</option><option value="finacial info">finacial info</option><option value="bank info">bank info</option></select>
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
	<form action="" method="post" id="form-comment"></form>
</div>

  			</div>
		
		</div><!-- /#page-wrapper -->
		
    </div><!-- /#wrapper -->
     
	 
	<script>var baseUrl	=	"http://demo.fundyourselfnow.com"</script> 
 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script>
		var baseUrl	=	"http://demo.fundyourselfnow.com"
		$(document).ready(function(){ 	
			$(".jfilestyle").jfilestyle({buttonText: "Upload",buttonBefore: true,inputSize: '110px'});  // file upload  
			$('#company_profile').summernote({height:300});
			$('#about_us').summernote({height:300});
							$('#company_profile').summernote('disable');
				$('#about_us').summernote('disable');
						
			$( "textarea[name='director_row[accomplishments][]'" ).each(function() {
				var id	=	$(this).attr("id");
				if(	id	!=	"accomplishments_XXX") {
					$(this).summernote({height:300}); 
											$(this).summernote('disable');
									}
			});
			
			$( "textarea[name='director_row[directors_profile][]'" ).each(function() {
				var id	=	$(this).attr("id");
				if(	id	!=	"directors_profile_XXX") {
					$(this).summernote({height:300}); 
											$(this).summernote('disable');
									}
			});
		}); 
	</script>	 
						</div>
						
						
						

@endsection
@stop
