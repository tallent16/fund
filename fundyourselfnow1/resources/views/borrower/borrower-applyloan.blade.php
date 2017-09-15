@extends('layouts.dashboard')
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 	
		<link href='{{ asset("assets/summernote/summernote.css") }}' rel="stylesheet">	 
	<style>
	textarea{
		margin-top:7px;
	}

	 
   .multiselect-container.dropdown-menu{ 
    max-height: 200px;
   	overflow: auto;
    width: 422px;
    }

	</style>
@endsection

@section('bottomscripts') 
<script type="text/javascript" src='http://maps.google.com/maps/api/js?key=AIzaSyDRAUL60x59Me2ISReMzt5UiOLHP8kDFUU&libraries=places'></script>
	<!-- <script src="{{ asset('assets/scripts/frontend.js') }}" type="text/javascript"></script> -->
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>	 
	 <script src="{{ asset('assets/summernote/summernote.js')}}" type="text/javascript"></script>
	 
	<!-- <script src="{{ url('js/locationpicker.jquery.js') }}"></script> -->
	<script src="{{ url('js/jquery.geocomplete.js') }}"></script>
	
	<script src="{{ url('js/jquery-filestyle.min.js') }}" type="text/javascript"></script>		
	
<!--
	<script src="{{ url('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>  
	<script src="{{ url('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>  
-->
	<script>var	baseUrl	=	"{{url('')}}"</script>
	<script src="{{ url('js/apply-loan.js') }}"></script>  
<script>

	
	$(document).ready(function(){ 
	// Main tabs
	//$(":file").jfilestyle({buttonText: "Attach Docs",buttonBefore: true,inputSize: '200px'});  // file upload

$('#country_name').multiselect({
		includeSelectAllOption: true           
		 });
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
    $("#loan_amount").on("change", function() {
		calculateCostOfTokenFunc();
	});
	
    $("#no_of_tokens").on("change", function() {
		calculateCostOfTokenFunc();
	});
	
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
	
	var	row_id		=	$("#rwd_mod_id").val();
	var	title		=	$("#rwd_tok_title").val();
	var	cost		=	$("#rwd_tok_cost").val();
	var	desc		=	$("#rwd_tok_desc").val();
	var	limit		=	$("#rwd_tok_limit").val();
	var	esdeldate	=	$("#rwd_tok_esdldate").val();
	
	$("#reward_title_span_"+row_id).html(title);
	$("#reward_cost_span_"+row_id).html(cost);
	$("#reward_desc_span_"+row_id).html(desc);
	$("#reward_limit_span_"+row_id).html(limit);
	$("#reward_estDelDate_span_"+row_id).html(esdeldate);
	
	$("#reward_title_"+row_id).val(title);
	$("#reward_cost_"+row_id).val(cost);
	$("#reward_desc_"+row_id).val(desc);
	$("#reward_limit_"+row_id).val(limit);
	$("#reward_estDelDate_"+row_id).val(esdeldate);
	
}

function fetchRewardTokenDetail(row_id) {
		
	var	title		=	$("#reward_title_"+row_id).val();
	var	cost		=	$("#reward_cost_"+row_id).val();
	var	desc		=	$("#reward_desc_"+row_id).val();
	var	limit		=	$("#reward_limit_"+row_id).val();
	var	esdeldate	=	$("#reward_estDelDate_"+row_id).val();
	$("#rwd_tok_title").val(title);
	$("#rwd_tok_cost").val(cost);
	$("#rwd_tok_desc").val(desc);
	$("#rwd_tok_limit").val(limit);
	$("#rwd_tok_esdldate").val(esdeldate);
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

function addNewSocialLinkRow() {
	
	htmlTemplate 	= "";
	htmlTemplate 	= $("#linksrow_template").html();
	counterint 		=	 parseInt($("#links_counter").val());
	counterint++;
	counterstr = counterint.toString();
	
	htmlTemplate = htmlTemplate.replace(/XXX/g, counterstr)
	
	$("#links-table tbody").append('<tr  id="links_row_'+counterstr+'"' 
									+'  class="links_rows" >'+htmlTemplate+'</tr>');
	
	$(".amount-align").on("focus", function() {
		onFocusNumberField(this);
	})

	$(".amount-align").on("blur", function() {
		onBlurNumberField(this)
		
	});
	
	$("#reward_counter").val(counterstr);
	$("#links_counter").val(counterstr);
	/*if($("#links-table .links_rows").length	>=	3) {
		$("#add_links_row").hide();
	}*/
}

function delMilestoneRow(rowId) {
	$("#milestone_row_"+rowId).remove();
	//~ resetMilestoneLabels();
	if($("#milestone-container .milestone_rows").length	<	3) {
		$("#add_milestone_row").show();
	}
}

function delLinkRow(rowId) {
	$("#links_row_"+rowId).remove();
	//~ resetMilestoneLabels();
	if($("#links-container .link_rows").length	<	3) {
		$("#add_link_row").show();
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

function calculateCostOfTokenFunc() {
	var	apply_amount	=	numeral($("#loan_amount").val()).value();
	var	no_of_token		=	numeral($("#no_of_tokens").val()).value();
	
	if(no_of_token	==	0) {
		$("#no_of_tokens").val(1);
		no_of_token	=	1;
	}
		
	costofTokens		=	apply_amount	/	no_of_token;
	$("#cost_per_token").val(numeral(costofTokens).format("(0,000.00)"));
}
</script> 

@endsection
@if($BorModLoan->loan_id	==	"")
	@var	$trantype		=	"add"
	@var	$page_heading	=	Lang::get('borrower-applyloan.create_project')
@else
	@var	$trantype		=	"edit"
	@var	$page_heading	=	Lang::get('borrower-applyloan.edit_project')
@endif   
@if($BorModLoan->loan_status	==	LOAN_STATUS_PENDING_COMMENTS)
	@var	$loan_status			=	"corrections_required"
	@var	$canViewCommentsTab		=	"yes"
@else
	@var	$loan_status			=	""
	@var	$canViewCommentsTab		=	""
@endif
@section('page_heading',$page_heading )

@section('body')
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

@if($BorModLoan->loan_id	==	"")
	{{ Lang::get('borrower-applyloan.create_projects') }}
@else 
{{ Lang::get('borrower-applyloan.edit_project') }}
   @endif         
          </h3></div>
		   <div class="col-xs-6 ">
		  <h3><span class="label label-default status-label pull-right">{{ Lang::get('borrower-applyloan.new') }}</span></h3>
		  </div>
                           
                            <!-- /.main-bar -->
							</div>
							
							
                        </header>
                        <!-- /.head -->
                </div>
                
                <div id="content">
                    <div class="outer">
                        <div class="inner1 bg-light lter">
						<div class="row">  
				
<div class="col-sm-12 space-around"> 
	
	<div class="row">
		<div class="col-sm-12 text-center " style="display:none;">
			<div class="annoucement-msg-container">
				<div class="alert alert-success annoucement-msg">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<h4>{{ Lang::get('borrower-applyloan.long_text') }}</h4>	
				</div>
			</div>				
		</div>
			</div>	
			<form class="form-inline" id="form-applyloan" method="post" enctype="multipart/form-data">	
				<input type="hidden" name="_token" id="hidden_token" value="{{ csrf_token() }}">	
				<input type="hidden" name="isSaveButton" id="isSaveButton" value="">	
				<input type="hidden" name="loan_id" value="{{$BorModLoan->loan_id}}">	
				<input type="hidden" name="trantype" value="{{ $trantype }}">
				<input type="hidden" name="hidden_loan_status" id="hidden_loan_status" value="{{ $BorModLoan->loan_status }}">
				<input 	type="hidden" 
						name="hidden_loan_statusText" 
						id="hidden_loan_statusText" 
						value="{{ $loan_status }}">
				<input type="hidden" id="completeLoanDetails" value="{{ $BorModLoan->completeLoanDetails }}">
				
				
				
			<div class="row">
				<div class="col-lg-12 col-md-6 col-xs-12">
				<ul class="nav nav-tabs">
					<li class="active">
						<a 	data-toggle="tab"
							href="#loans_info" style="text-transform:uppercase; ">
							{{ Lang::get('borrower-applyloan.project_info') }}
						</a>
					</li>
					<li class="">
						<a 	data-toggle="tab"
							href="#documents_submitted"  style="text-transform:uppercase; ">
							{{ Lang::get('borrower-applyloan.rewards_submitted') }}
						</a>
					</li>
					@if($canViewCommentsTab	==	"yes")
						<li>
							<a 	data-toggle="tab"
								href="#comments">
								{{ Lang::get('COMMENTS') }}
							</a>
						</li>	
					@endif							
				</ul>					

				<div class="tab-content">
					
					<!--  -----first-tab-------------------------------  -->
					@include('widgets.borrower.tab.applyloan_info',array("show_map"=>"yes"))
					<!-------second tab--starts------------------------>
					@include('widgets.borrower.tab.applyloan_documents_submit'	
													,array("show_map"=>"yes","show_reward_type"=>"yes"))
					@if($canViewCommentsTab	==	"yes")
						<!-----Sixth Tab content starts----->
							@include('widgets.admin.tab.loanapproval_comments')	
						<!-----Sixth Tab content ends----->
					@endif
				</div><!--tab content-->	
			
			
			<div class="row">	
				<div class="col-sm-12">			
				<div class="pull-right">	
					
					
					@if( ($BorModLoan->loan_status	==	LOAN_STATUS_NEW)
						||  ($BorModLoan->loan_status	==	LOAN_STATUS_PENDING_COMMENTS))
						<button type="submit" 
								id="save_button"
								class="btn verification-button"
								{{$BorModLoan->viewStatus}}>
							<i class="fa pull-right"></i>
								{{ Lang::get('borrower-applyloan.save') }}
						</button>
						@if($BorModLoan->loan_status	==	LOAN_STATUS_NEW)
							@if(!$BorModLoan->completeLoanDetails)
								<button type="button" 
										id="next_button"
										data-tab-id="company_info"
										class="btn verification-button" >
										<i class="fa pull-right"></i>
										{{ Lang::get('borrower-applyloan.next') }}
								</button>
							@endif		
						@endif		
						<button type="submit" 
								class="btn verification-button"
								style="display:none"
								id="submit_button"
								{{$BorModLoan->viewStatus}}>
							<i class="fa pull-right"></i>
							{{ Lang::get('borrower-applyloan.submit_varify') }}
						</button>
					@endif
				</div>	
				</div>			 
			</div> 			
			</form>	
			
			</div><!--row-->	
			</div>
			
	<!--	</div><!--col-->	
	<!--</div>	<!--row-->	
</div><!--col-->

<!-- reward and item template starts-->

<div style="display:none" id="hidden_rows" >
	<input type="hidden" id="reward_counter" value="{{count($BorModLoan->reward_details)}}"/>
	<input type="hidden" id="item_counter" value="{{count($BorModLoan->item_details)}}"/>
	<input type="hidden" id="milestone_counter" value="{{count($BorModLoan->mileStoneArry)}}"/>
	<input type="hidden" id="links_counter" value="1"/>
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
							class="form-control"
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
					<span id="reward_estDelDate_span_XXX"></span>
					<input 	type="hidden" 
							name="reward_row[estDelDate][]" 
							id="reward_estDelDate_XXX" 
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
							class="form-control"
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
					><i  class="fa fa-edit"
						></i>
					</a>
					<a 	href="javascript:void(0);"
						onclick="delItemTokenRow(XXX)">
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
				<!-- <td>
					<input 	type="text" 
							class="form-control select-width amount-align text-right "
							name="milstone_row[disbursed][]"
							id="milstone_disbursed_XXX"
							decimal="0"
							value="" style="float:right">	
				</td> -->
				<td class="text-center">
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
 
	<div id="link_template">
		<table id="dummy_table">
			<tr  id="linksrow_template">
				<td>
					<input 	type="hidden" 
							class="form-control select-width text-right"
							name="link_row[id][]"
							id="link_id_XXX"
							 value="">									
					<div class="select_outer">
<select id="link_name_1" class="form-control select-width" name="link_row[name][]" style="widh:100%;">
                            <option value="">{{ Lang::get('borrower-applyloan.please_select')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Website')}}">{{ Lang::get('borrower-applyloan.Website')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Whitepaper')}}" >{{ Lang::get('borrower-applyloan.Whitepaper')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Blog')}}" >{{ Lang::get('borrower-applyloan.Blog')}}</option>
						    <option value="{{ Lang::get('borrower-applyloan.Facebook')}}" >{{ Lang::get('borrower-applyloan.Twitter')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Facebook')}}" >{{ Lang::get('borrower-applyloan.Twitter')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.LinkedIn')}}" >{{ Lang::get('borrower-applyloan.LinkedIn')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Slack')}}" >{{ Lang::get('borrower-applyloan.Slack')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Telegram')}}">{{ Lang::get('borrower-applyloan.Telegram')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Github')}}">{{ Lang::get('borrower-applyloan.Github')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Youtube')}}">{{ Lang::get('borrower-applyloan.Youtube')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.QQ')}}" >{{ Lang::get('borrower-applyloan.QQ')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Weibo')}}" >{{ Lang::get('borrower-applyloan.Weibo')}}</option>
					</select>
					</div>	
				</td>
				<td>
					<input 	type="text" 
							class="form-control select-width"
							name="link_row[link][]"
							id="link_link_XXX"
							value="">	
				</td>
				<td class="">
					<a 	href="javascript:void(0);"
								onclick="delLinkRow(XXX)"
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
<div style="display:none" id="hidden_rows" >
	<input type="hidden" id="reward_counter" value="{{count($BorModLoan->reward_details)}}"/>
	<input type="hidden" id="item_counter" value="{{count($BorModLoan->item_details)}}"/>
	<input type="hidden" id="milestone_counter" value="{{count($BorModLoan->mileStoneArry)}}"/>
	<input type="hidden" id="links_counter" value="1"/>
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
							class="form-control"
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
					<span id="reward_estDelDate_span_XXX"></span>
					<input 	type="hidden" 
							name="reward_row[estDelDate][]" 
							id="reward_estDelDate_XXX" 
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
							class="form-control"
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
					><i  class="fa fa-edit"
						></i>
					</a>
					<a 	href="javascript:void(0);"
						onclick="delItemTokenRow(XXX)">
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
				<!-- <td>
					<input 	type="text" 
							class="form-control select-width amount-align text-right "
							name="milstone_row[disbursed][]"
							id="milstone_disbursed_XXX"
							decimal="0"
							value="" style="float:right">	
				</td> -->
				<td class="text-center">
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
 
	<div id="link_template">
		<table id="dummy_table">
			<tr  id="linksrow_template">
				<td>
					<input 	type="hidden" 
							class="form-control select-width text-right"
							name="link_row[id][]"
							id="link_id_XXX"
							 value="">									
					<div class="select_outer">
<select id="link_name_1" class="form-control select-width" name="link_row[name][]" style="widh:100%;">
						<option value="">{{ Lang::get('borrower-applyloan.please_select')}}</option>
						  <option value="{{ Lang::get('borrower-applyloan.Website')}}">{{ Lang::get('borrower-applyloan.Website')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Whitepaper')}}" >{{ Lang::get('borrower-applyloan.Whitepaper')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Blog')}}" >{{ Lang::get('borrower-applyloan.Blog')}}</option>
						    <option value="{{ Lang::get('borrower-applyloan.Facebook')}}" >{{ Lang::get('borrower-applyloan.Twitter')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Facebook')}}" >{{ Lang::get('borrower-applyloan.Twitter')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.LinkedIn')}}" >{{ Lang::get('borrower-applyloan.LinkedIn')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Slack')}}" >{{ Lang::get('borrower-applyloan.Slack')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Telegram')}}">{{ Lang::get('borrower-applyloan.Telegram')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Github')}}">{{ Lang::get('borrower-applyloan.Github')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Youtube')}}">{{ Lang::get('borrower-applyloan.Youtube')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.QQ')}}" >{{ Lang::get('borrower-applyloan.QQ')}}</option>
							<option value="{{ Lang::get('borrower-applyloan.Weibo')}}" >{{ Lang::get('borrower-applyloan.Weibo')}}</option>
					</select>
					</div>	
				</td>
				<td>
					<input 	type="text" 
							class="form-control select-width"
							name="link_row[link][]"
							id="link_link_XXX"
							value="">	
				</td>
				<td class="">
					<a 	href="javascript:void(0);"
								onclick="delLinkRow(XXX)"
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


<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>  -->   

</div>
		
		</div><!-- /#page-wrapper -->
		
    </div><!-- /#wrapper -->
     
	 
						
					</div>	 	
    @endsection  
@stop
