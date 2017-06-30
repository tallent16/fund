@extends('layouts.dashboard')
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 	
		<link href='{{ asset("assets/summernote/summernote.css") }}' rel="stylesheet">	 
	
@endsection
@section('bottomscripts')
	
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	
	<script src="{{ asset('assets/summernote/summernote.js')}}" type="text/javascript"></script>
	
	<script src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script> 

	<script src="{{ url('js/jquery.geocomplete.js') }}"></script>
	<script src="{{ url('js/jquery-filestyle.min.js') }}" type="text/javascript"></script>	
	
	<script src="{{ url('js/admin-loan-apply.js') }}" type="text/javascript"></script>		
	
	<script>var baseUrl	=	"{{url('')}}"
	$('.table-responsive').on('show.bs.dropdown', function () {
	 $('.table-responsive').css( "overflow", "inherit" );
	});

	$('.table-responsive').on('hide.bs.dropdown', function () {
	 $('.table-responsive').css( "overflow", "auto" );
	})</script>
<script>
$(document).ready(function(){ 
	
		var options = {
		map: "#map",
		details: "form ",
		detailsAttribute: "data-geo",
		markerOptions: {
		draggable: true
		},
		location:"{{$BorModLoan->location_description}}"
	};
	
	$("#location_description").geocomplete(options);
 
	// Main tabs
	$(":file").jfilestyle({buttonText: "Attach Docs",buttonBefore: true,inputSize: '200px'});  // file upload


	// date picker
	$('.date-picker').datetimepicker({
	autoclose: true,
	minView: 2,
	format: 'dd/mm/yyyy'

	}); 
	
	/** Editor -Block */
	
	$('textarea.tinyTextArea').summernote({height:300});
	
	$("input[name=item_type]:radio").change(function () {
		
		
		if ($(this).val() == '1') {
			
			if($("#item_token_table tbody tr:not('.no_data_row')").length	>	0) {
				
				$("#warning_item_type").val(1);
				showWarningPopFunc()	
			}else{
				showRewardTokenBlockFunc();
			}
		}
		else if ($(this).val() == '2') {
			
			if($("#reward_token_table tbody tr:not('.no_data_row')").length	>	0) {
				$("#warning_item_type").val(2);
				showWarningPopFunc();
			}else{
				showItemTokenBlockFunc();
			}
		}
	});
	

	
	//~ $("#location_description").geocomplete(options);
	
	$("#location_description").bind("geocode:dragged", function(event, latLng){
		if(latLng	!=	undefined)	{
			//~ $("#latitude").val(latLng.lat());
			//~ $("#longitude").val(latLng.lng());
			 $("input[name=latitude]").val(latLng.lat());
          $("input[name=longitude]").val(latLng.lng());
		}
    });
	
	$("#location_description").bind("geocode:click", function(event, latLng){
		if(latLng	!=	undefined)	{
			//~ $("#latitude").val(latLng.lat());
			//~ $("#longitude").val(latLng.lng());
			 $("input[name=latitude]").val(latLng.lat());
          $("input[name=longitude]").val(latLng.lng());
		}
    });
  $("#find").click(function(){
          $("#location_description").trigger("geocode");
        }).click();
	
	
    $("#warning_token_popup .close").click(function() {
		remainSameToken();
	});
   
    //~ $("#location_description").trigger("geocode:dragged");
    
}); 

function showRewardTokenBlockFunc() {
	
	noRowFoundItemTokenFunc();
	$("#reward_counter").val(0);
	$("#item_token_block").hide();
	$("#reward_token_block").show();
	
}

function showItemTokenBlockFunc() {
	
	noRowFoundRewardTokenFunc();
	$("#item_counter").val(0);
	$("#reward_token_block").hide();
	$("#item_token_block").show();
	
}

function rewardTokenPopupFunc(type,row_id) {
	
	clearAllText();
	$("#rwd_mod_type").val(type);
	if(type	==	"edit") {
		fetchRewardTokenDetail(row_id);
	}
	$("#reward_token_popup").modal();
}

function showWarningPopFunc() {
		
	$("#warning_token_popup").modal();
}


function remainSameToken() {
	
	if($("#warning_item_type").val()	==	1) {
		$("input[name=item_type][value='2']:radio").attr("checked",true);
		$("input[name=item_type][value='2']:radio").prop("checked",true);
	}else{
		$("input[name=item_type][value='1']:radio").attr("checked",true);
		$("input[name=item_type][value='1']:radio").prop("checked",true);
	}
	$('#warning_token_popup').modal('hide');
}


function delTokenRows() {
	
	if($("#warning_item_type").val()	==	1) {
		noRowFoundItemTokenFunc();
	}else{
		noRowFoundRewardTokenFunc();
	}
	$('#warning_token_popup').modal('hide');
}


function addNewRewardTokenRow() {
	
	$("#reward_token_table .no_data_row").remove();
	
	htmlTemplate = "";
	htmlTemplate = $("#rwdrow_template").html();
	counterint = parseInt($("#reward_counter").val());
	counterint++;
	
	counterstr = counterint.toString();
	
	htmlTemplate = htmlTemplate.replace(/XXX/g, counterstr)

	$("#reward_token_table").append("<tr id='rwdrow_"+counterstr+"'>\n"+htmlTemplate+"\n</tr>");
	$("#reward_counter").val(counterstr);
	$("#rwd_mod_id").val(counterstr);
}

function delRewardTokenRow(rowId) {
	$("#rwdrow_"+rowId).remove();
	if($("#reward_token_table tbody tr").length	==	0) {
		noRowFoundRewardTokenFunc();
	}
}

function updateRewardTokenRow() {
	type	=	$("#rwd_mod_type").val();
	if(type	==	"add") {
		addNewRewardTokenRow();
	}
	setRewardTokenRow();
	$('#reward_token_popup').modal('hide');
}

function setRewardTokenRow() {
	
	var	row_id	=	$("#rwd_mod_id").val();
	var	title	=	$("#rwd_tok_title").val();
	var	cost	=	$("#rwd_tok_cost").val();
	var	desc	=	$("#rwd_tok_desc").val();
	var	limit	=	$("#rwd_tok_limit").val();
	
	$("#reward_title_span_"+row_id).html(title);
	$("#reward_cost_span_"+row_id).html(cost);
	$("#reward_desc_span_"+row_id).html(desc);
	$("#reward_limit_span_"+row_id).html(limit);
	
	$("#reward_title_"+row_id).val(title);
	$("#reward_cost_"+row_id).val(cost);
	$("#reward_desc_"+row_id).val(desc);
	$("#reward_limit_"+row_id).val(limit);
	
}

function fetchRewardTokenDetail(row_id) {
		
	var	title	=	$("#reward_title_"+row_id).val();
	var	cost	=	$("#reward_cost_"+row_id).val();
	var	desc	=	$("#reward_desc_"+row_id).val();
	var	limit	=	$("#reward_limit_"+row_id).val();
	
	$("#rwd_tok_title").val(title);
	$("#rwd_tok_cost").val(cost);
	$("#rwd_tok_desc").val(desc);
	$("#rwd_tok_limit").val(limit);
	$("#rwd_mod_id").val(row_id);
}

function clearAllText() {
	$("#reward_token_popup input[type=text], #reward_token_popup textarea").val("");
}

function noRowFoundRewardTokenFunc() {
	$("#reward_token_table tbody").html("<tr class='no_data_row'>"+
											"<td colspan='5' >"+
											"No Data Found"+
										"</td></tr>");
}

function itemTokenPopupFunc(type,row_id) {
	
	
	clearAllItemText();
	$("#item_mod_type").val(type);
	if(type	==	"edit") {
		fetchItemTokenDetail(row_id);
	}
	$("#item_token_popup").modal();
}

function addNewItemTokenRow() {

	$("#item_token_table tbody .no_data_row").remove();
	htmlTemplate = "";
	htmlTemplate = $("#itemrow_template").html();
	counterint = parseInt($("#item_counter").val());
	counterint++;
	
	counterstr = counterint.toString();
	
	htmlTemplate = htmlTemplate.replace(/XXX/g, counterstr)

	$("#item_token_table tbody").append("<tr id='itemrow_"+counterstr+"'>\n"+htmlTemplate+"\n</tr>");
	$("#item_counter").val(counterstr);
	$("#item_mod_id").val(counterstr);
}

function delItemTokenRow(rowId) {
	$("#itemrow_"+rowId).remove();
	if($("#item_token_table tbody tr").length	==	0) {
		noRowFoundItemTokenFunc();
	}
}

function updateItemTokenRow() {
	type	=	$("#item_mod_type").val();
	if(type	==	"add") {
		addNewItemTokenRow();
	}
	setItemTokenRow();
	$('#item_token_popup').modal('hide');
}

function setItemTokenRow() {
	
	var	row_id		=	$("#item_mod_id").val();
	var	title		=	$("#item_tok_title").val();
	var	pledgeAmt	=	$("#item_tok_pledge_amt").val();
	var	desc		=	$("#item_tok_desc").val();
	var	esdeldate	=	$("#item_tok_esdldate").val();
	var	limit		=	$("#item_tok_limit").val();
	
	$("#item_title_span_"+row_id).html(title);
	$("#item_plgamt_span_"+row_id).html(pledgeAmt);
	$("#item_desc_span_"+row_id).html(desc);
	$("#item_estDelDate_span_"+row_id).html(esdeldate);
	$("#item_limit_span_"+row_id).html(limit);
	
	$("#item_title_"+row_id).val(title);
	$("#item_plgamt_"+row_id).val(pledgeAmt);
	$("#item_desc_"+row_id).val(desc);
	$("#item_estDelDate_"+row_id).val(esdeldate);
	$("#item_limit_"+row_id).val(limit);
	
}

function fetchItemTokenDetail(row_id) {
		
	var	title		=	$("#item_title_"+row_id).val();
	var	pledgeAmt	=	$("#item_plgamt_"+row_id).val();
	var	desc		=	$("#item_desc_"+row_id).val();
	var	esdeldate	=	$("#item_estDelDate_"+row_id).val();
	var	limit		=	$("#item_limit_"+row_id).val();
	
	$("#item_tok_title").val(title);
	$("#item_tok_pledge_amt").val(pledgeAmt);
	$("#item_tok_desc").val(desc);
	$("#item_tok_esdldate").val(esdeldate);
	$("#item_tok_limit").val(limit);
	$("#item_mod_id").val(row_id);
}

function clearAllItemText() {
	$("#item_token_popup input[type=text], #item_token_popup textarea").val("");
}

function noRowFoundItemTokenFunc() {
	$("#item_token_table tbody").html("<tr class='no_data_row'>"+
											"<td colspan='6' >"+
											"No Data Found"+
										"</td></tr>");
}

function addNewMilestoneRow() {
	
	htmlTemplate 	= "";
	htmlTemplate 	= $("#milestonerow_template").html();
	counterint 		=	 parseInt($("#milestone_counter").val());
	counterint++;
	counterstr = counterint.toString();
	
	htmlTemplate = htmlTemplate.replace(/XXX/g, counterstr)
	
	$("#milestone-table tbody").append('<tr  id="milestone_row_'+counterstr+'"' 
									+'  class="milestone_rows" >'+htmlTemplate+'</tr>');
	
	$("#milstone_date_"+counterstr).datetimepicker({
		autoclose: true,
		minView: 2,
		format: 'dd/mm/yyyy'
	}); 
	
	$(".amount-align").on("focus", function() {
		onFocusNumberField(this);
	})

	$(".amount-align").on("blur", function() {
		onBlurNumberField(this)
	});
	
	$("#reward_counter").val(counterstr);
	$("#milestone_counter").val(counterstr);
	if($("#milestone-table .milestone_rows").length	>=	3) {
		$("#add_milestone_row").hide();
	}
}

function delMilestoneRow(rowId) {
	$("#milestone_row_"+rowId).remove();
	//~ resetMilestoneLabels();
	if($("#milestone-container .milestone_rows").length	<	3) {
		$("#add_milestone_row").show();
	}
}

function resetMilestoneLabels() {
	
	var	i	=	1;
	$("#milestone-container .milestone_rows").each(function() {
		var	id	=	$(this).attr("id");
		id		=	id.replace("milestone_row_","");
		$("#lbl_milestone_name_"+id).html("Milestone Name"+i);
		$("#lbl_milestone_date_"+id).html("Milestone Date"+i);
		i++;
	})
}
</script>  	
@endsection
@section('page_heading',Lang::get('Manage Projects') )
@section('section')  
@if($adminLoanApprMod->status	==	LOAN_STATUS_PENDING_COMMENTS)
	@var	$borrower_status	=	"corrections_required"
@else
	@var	$borrower_status	=	""
@endif
@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
	{{ '';$adminLoanApprMod->viewStatus	=	"disabled";''}}
	@var	$screenMode	=	"admin"

	@if( ($adminLoanApprMod->loan_status	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL))
			@var	$commentButtonsVisibe	=	""
	@else
			@var	$commentButtonsVisibe	=	"disabled"
	@endif
@else
	@var	$screenMode	=	"borrower"
@endif

@if( ($adminLoanApprMod->loan_status	==	 LOAN_STATUS_SUBMITTED_FOR_APPROVAL)
		|| ($adminLoanApprMod->loan_status	==	 LOAN_STATUS_APPROVED)
		|| ($adminLoanApprMod->loan_status	==	 LOAN_STATUS_PENDING_COMMENTS)
		|| ($adminLoanApprMod->loan_status	==	 LOAN_STATUS_CLOSED_FOR_BIDS))
			@var	$disableBidCloseDate	=	""
@else
	@var	$disableBidCloseDate	=	"disabled"
@endif
<div class="col-sm-12 space-around">
	
	<div class="panel-primary panel-container">
			@if($submitted)
				<div class="row">
					<div class="col-sm-12">
						<div class="annoucement-msg-container">
							<div class="alert alert-success">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									{{ Lang::get('Loan Apply submitted successfully') }}
							</div>
						</div>
					</div> 
				</div> 	
			@endif
			
			<div class="panel-heading panel-headsection"><!--panel head-->
				<div class="row">
					<div class="col-sm-12">
						<span class="pull-left">{{ Lang::get('PROJECT APPROVAL')}}</span> 														
					</div>																
				</div>					
			</div><!--panel head end-->
			
			<form method="post" id="form-profile" name="form-profile"  enctype="multipart/form-data">
				<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
				<input type="hidden" id="screen_mode" value="{{$screenMode}}">
				<input type="hidden" name="admin_process" id="admin_process" value="">
				<input type="hidden" name="hidden_borrower_status" id="borrower_status" value="{{$borrower_status}}">
				<input type="hidden" name="borrower_id" value="{{ $adminLoanApprMod->borrower_id }}">
				<input type="hidden" name="loan_id" value="{{ $adminLoanApprMod->loan_id }}">
				<input type="hidden" name="isSaveButton" id="isSaveButton" value="">
				<input type="hidden" name="trantype" value="edit">
				<input type="hidden" name="hidden_loan_status" id="hidden_loan_status" 
						value="{{$adminLoanApprMod->loan_status}}">
				<input 	type="hidden" 
						name="laon_purpose"
						value="{{$adminLoanApprMod->purpose}}">
				<div class="panel-body applyloan table-border-custom">	
					<div class="col-sm-12 text-right"> 
						
						@if($adminLoanApprMod->loan_status	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL)
								<button type="button" 
									class="btn verification-button"
									id="save_loanapply_button">						
									{{ Lang::get('Save')}}
								</button>	
								@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
									@if( $adminLoanApprMod->loan_status	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL)
										@permission('approve.admin.loanapproval')			
												<button type="button" 
														class="btn verification-button"
														id="approve_loanapply_button">
													{{ Lang::get('Approve')}}
												</button>
										@endpermission
									@endif
								@endif
								@permission('cancel.admin.loanapproval')
									<button type="button" 
											class="btn verification-button"
											id="cancel_loanapply_button">						
										{{ Lang::get('Cancel')}}</button>
								@endpermission
<!--
								@permission('admin.savecomment')
									<button type="button" class="btn verification-button" id="save_comment_button">						
										{{ Lang::get('Save Comments')}}</button>
								@endpermission
-->
								@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
										@if( $adminLoanApprMod->loan_status	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL)
											@permission('returnborrower.admin.loanapproval')
													<button type="button" 
															class="btn verification-button"
															id="returnback_loanapply_button">						
															{{ Lang::get('Return to Creator')}}
													</button>	
										@endpermission				
										
									@endif
								@endif
								@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
									@if( $adminLoanApprMod->loan_status	==	LOAN_STATUS_SUBMITTED_FOR_APPROVAL)
<!--
										<button type="button" 
												class="btn verification-button"
												id="download_all_document">						
												{{ Lang::get('Download All')}}
										</button>	
-->
									@endif
								@endif
							
						@endif
					</div>
						<div class="row">
							<div class="col-lg-12 col-md-6 col-xs-12 space-around">
								<ul class="nav nav-tabs">
									<li class="active">
										<a 	data-toggle="tab"
											href="#loans_info"
											style=" text-transform: uppercase;">
											{{ Lang::get('borrower-applyloan.project_info') }}
										</a>
									</li>
									<li>
										<a 	data-toggle="tab"
											href="#documents_submitted"
											style=" text-transform: uppercase;">
											{{ Lang::get('borrower-applyloan.rewards_submitted') }}
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
									@include('widgets.borrower.tab.applyloan_info',array("show_map"=>"yes"))
									<!-------second tab--starts------------------------>
									@include('widgets.borrower.tab.applyloan_documents_submit'	
													,array("show_map"=>"yes","show_reward_type"=>"yes"))
									<!-------Third tab--starts------------------------>
									@include('widgets.admin.tab.loanapproval_comments')						
									<!--tab content-->
								</div>
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

<!-- reward and item template starts-->

<div style="display:none" id="hidden_rows" >
	<input type="hidden" id="reward_counter" value="{{count($BorModLoan->reward_details)}}"/>
	<input type="hidden" id="item_counter" value="{{count($BorModLoan->item_details)}}"/>
	<input type="hidden" id="milestone_counter" value="{{count($BorModLoan->mileStoneArry)}}"/>
	<div style="display:none" id="template_prodrow">
		<!-- to be used as the template for inserting new product rows -->
		<table id="dummy_table">
			<tr id="rwdrow_template">
				
				<td  class="text-left">
					<span id="reward_title_span_XXX"></span>
					<input 	type="hidden" 
							name="reward_row[id][]" 
							id="reward_id_XXX" 
							class="form-control" 
							value="0" 
							 />
					<input 	type="hidden" 
							name="reward_row[title][]" 
							id="reward_title_XXX" 
							class="form-control" 
							value="" 
							 />
				</td>
				<td class="text-right">
					<span id="reward_cost_span_XXX"></span>
					<input 	type="hidden" 
							name="reward_row[cost][]" 
							id="reward_cost_XXX" 
							class="form-control" 
							value="" 
							 />
				</td>
				<td class="text-left">
					<span id="reward_desc_span_XXX"></span>
					<textarea name="reward_row[desc][]" 
							id="reward_desc_XXX" 
							style="display:none;">
					</textarea>
				</td>
				<td class="text-right">
					<span id="reward_limit_span_XXX"></span>
					<input 	type="hidden" 
							name="reward_row[limit][]" 
							id="reward_limit_XXX" 
							class="form-control" 
							value="" 
							 />
				</td>
				<td class="text-left">
					<a 	href="javascript:void(0);"
						onclick="rewardTokenPopupFunc('edit',XXX)"
					>
						<i  class="fa fa-edit"
						></i>
					</a>
					<a 	href="javascript:void(0);"
						onclick="delRewardTokenRow(XXX)"
					>
						<i  class="fa fa-remove"
						></i>
					</a>
				</td>
			</tr>		
			<tr id="itemrow_template">
				
				<td  class="text-left">
					<span id="item_title_span_XXX"></span>
					<input 	type="hidden" 
							name="item_row[id][]" 
							id="item_id_XXX" 
							class="form-control" 
							value="" 
							 />
					<input 	type="hidden" 
							name="item_row[title][]" 
							id="item_title_XXX" 
							class="form-control" 
							value="" 
							 />
				</td>
				<td class="text-right">
					<span id="item_plgamt_span_XXX"></span>
					<input 	type="hidden" 
							name="item_row[plgamt][]" 
							id="item_plgamt_XXX" 
							class="form-control" 
							value="" 
							 />
				</td>
				<td class="text-left">
					<span id="item_desc_span_XXX"></span>
					<textarea name="item_row[desc][]" 
							id="item_desc_XXX" 
							style="display:none;">
					</textarea>
				</td>
				<td class="text-right">
					<span id="item_estDelDate_span_XXX"></span>
					<input 	type="hidden" 
							name="item_row[estDelDate][]" 
							id="item_estDelDate_XXX" 
							class="form-control" 
							value="" 
							 />
				</td>
				<td class="text-right">
					<span id="item_limit_span_XXX"></span>
					<input 	type="hidden" 
							name="item_row[limit][]" 
							id="item_limit_XXX" 
							class="form-control" 
							value="" 
							 />
				</td>
				<td class="text-left">
					<a 	href="javascript:void(0);"
						onclick="itemTokenPopupFunc('edit',XXX)"
					>
						<i  class="fa fa-edit"
						></i>
					</a>
					<a 	href="javascript:void(0);"
						onclick="delItemTokenRow(XXX)"
					>
						<i  class="fa fa-remove"
						></i>
					</a>
				</td>
			</tr>		
		</table>
	</div>
	<div id="milestone_template">
		<table id="dummy_table">
			<tr  id="milestonerow_template">
				<td>
					<input 	type="hidden" 
							class="form-control select-width text-right"
							name="milstone_row[id][]"
							id="milstone_id_XXX"
							 value="">									
					<input 	type="text" 
							class="form-control select-width"
							name="milstone_row[name][]"
							id="milstone_name_XXX"
							value="">	
				</td>
				<td>
					<div class="controls">
						<div class="input-group">
							<input 	type="text" 
									name="milstone_row[date][]"
									id="milstone_date_XXX"
									value=""
									class="date-picker form-control required"
									 />	
							<label class="input-group-addon btn" for="milstone_date_XXX">
								<span class="glyphicon glyphicon-calendar"></span>
							</label>
						</div>													
					</div>			
				</td>
				<td>
					<input 	type="text" 
							class="form-control select-width amount-align"
							name="milstone_row[disbursed][]"
							id="milstone_disbursed_XXX"
							decimal="0"
							value="">	
				</td>
				<td class="text-left">
					<a 	href="javascript:void(0);"
								onclick="delMilestoneRow(XXX)"
								style="color:#f6942c;vertical-align: -moz-middle-with-baseline;"
							>
						<i  class="fa fa-remove"
						></i>
					</a>
				</td>
			</tr>
		</table>
	</div>
</div>	

<!-- reward and item template ends-->

	@endsection  
@stop
