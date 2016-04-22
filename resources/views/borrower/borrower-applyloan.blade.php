@extends('layouts.dashboard')
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 		 
@endsection
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>	 
	 
	<script src="{{ url('js/jquery-filestyle.min.js') }}" type="text/javascript"></script>		 
	<script src="{{ url('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>  
	<script src="{{ url('vendor/unisharp/laravel-ckeditor/adapters/jquery.js') }}"></script>  
	<script src="{{ url('js/common.js') }}"></script>  
	<script src="{{ url('js/numeral.min.js') }}"></script>  
	
	<script>
		$(document).ready(function(){		
			 
			$(".borrower_doc_download").on("click",function(){
				var	loan_doc_url	=	$(this).attr("data-download-url");
					loan_doc_url	=	loan_doc_url+"_"+ new Date().getTime();
					window.location	=	loan_doc_url;
			});
			$("#save_button").on("click",function(){
				$("#isSaveButton").val("yes");
			});
			$("#form-applyloan").submit(function( event ) {
		
				var	isSaveButtonClicked		=	$("#isSaveButton").val();
				if(isSaveButtonClicked	!=	"yes") {
					
					if(callTabValidateFunc())
						event.preventDefault();
					if(validateTab("documents_submitted"))
						event.preventDefault();
					$("#next_button").hide();
					$("#submit_button").show();
				}
			
			});
			 $(".nav-tabs > li").click(function(){
				//~ $("#next_button").show();
				//~ $("#submit_button").hide();
				if($(this).hasClass("disabled"))
					return false;
			});
			$("#next_button").click(function(){
				
				callTabValidateFunc();
			});
			$(".amount-align").on("focus", function() {
				onFocusNumberField(this);
			})

			$(".amount-align").on("blur", function() {
				onBlurNumberField(this)
			});
			
			$("input[name=partial_sub_allowed]:radio").change(function () {
				if ($(this).val() == '1') {
					
					$("#min_for_partial_sub").attr("disabled",false);
				}
				else if ($(this).val() == '2') {
					$("#min_for_partial_sub").attr("disabled",true);
					$("#min_for_partial_sub").val("");
					var $parentTag = $("#min_for_partial_sub_parent");
					$parentTag.removeClass("has-error");
					$parentTag.find("span.error").remove();
				}
			});
			 $(".nav-tabs > li").click(function(){
				$("#next_button").show();
				$("#submit_button").hide();
				if($(this).hasClass("disabled"))
					return false;
				if($(this).find("a").attr("href")	==	"#documents_submitted") {
					$("#next_button").hide();
					$("#submit_button").show();
				}
			});
			
			$("input[name=partial_sub_allowed]:radio").trigger("change");
			callcheckAllTabFilledFunc();
		});		
		function callTabValidateFunc() {
			
			$('span.error').remove();
			$('.has-error').removeClass("has-error");
			var active = $("ul.nav-tabs li.active a");
			var	cur_tab		=	active.attr("href");
			cur_tab			=	cur_tab.replace("#","");
			$("#next_button").show();
			$("#submit_button").hide();
			if(validateTab('loans_info')) {
				$('.nav-tabs a[href="#loans_info"]').tab('show');
				return true;
			}
			$("#next_button").hide();
			$("#submit_button").show();
			$('.nav-tabs a[href="#documents_submitted"]').tab('show');
			$('a[href="#documents_submitted"]').parent().removeClass("disabled");
			return false;
		}
		function validateTab(cur_tab) {
			
			$("#"+cur_tab+" :input.required").each(function(){
				
				var	input_id	=	$(this).attr("id");
				var inputVal 	= 	$(this).val();
				
				var $parentTag = $("#"+input_id+"_parent");
				if(inputVal == ''){
					if($(this).hasClass("jfilestyle")) {
						if($("#"+input_id+"_hidden").val() == ''){
							$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
						}
					}else{
						$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
					}
				}
			});
			$partial_sub		=	$("input[name=partial_sub_allowed]:checked").val();
			$partial_sub_amt	=	$("#min_for_partial_sub").val();
			if($partial_sub	==	1) {
				if($partial_sub_amt	==	"") {
					var $parentTag = $("#min_for_partial_sub_parent");
					$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
					$('.nav-tabs a[href="#loans_info"]').tab('show');
					
				}	
			}
			if ($("#"+cur_tab).has('.has-error').length > 0)
				return true;
			else
				return false;
		}
		function callcheckAllTabFilledFunc() {
			if(checkTabFilled("loans_info")){//check Company Info Filled
				$('.nav-tabs a[href="#documents_submitted"]').parent().removeClass("disabled");
				//Enable the Director Info Tab
			}
		}
		function checkTabFilled(cur_tab) {
			var	cnt	=	0;
			$("#"+cur_tab+" :input.required").each(function(){
				var inputVal 	= 	$(this).val();
				var	input_id	=	$(this).attr("id");
				if(inputVal == ''){
							cnt++;
				}
			});
			if (cnt == 0)
				return true;
			else
				return false;
		}
	</script>		
@endsection
@if($BorModLoan->loan_id	==	"")
	@var	$trantype		=	"add"
	@var	$page_heading	=	Lang::get('borrower-applyloan.apply_loan')
@else
	@var	$trantype		=	"edit"
	@var	$page_heading	=	Lang::get('borrower-applyloan.edit_loan')
@endif   
@if($BorModLoan->status	==	LOAN_STATUS_PENDING_COMMENTS)
	@var	$loan_status			=	"corrections_required"
	@var	$canViewCommentsTab		=	"yes"
@else
	@var	$loan_status			=	""
	@var	$canViewCommentsTab		=	""
@endif
@section('page_heading',$page_heading) )
@section('status_button')						
<!--------Status Button Section---->   
 <h4><span class="label label-default status-label">{{$BorModLoan->statusText}}</span></h3>														
@endsection
@section('section')

<div class="col-sm-12 space-around"> 
	
	<div class="row">
		<div class="col-sm-12 text-center " style="display:none;">
			<div class="annoucement-msg-container">
				<div class="alert alert-success annoucement-msg">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<h4>{{ Lang::get('borrower-applyloan.loan_title_info_1') }}{{ Lang::get('borrower-applyloan.loan_title_info_2') }}</h4>	
				</div>
			</div>				
		</div>
		@if(isset($status))
			@var	$alertClass	=	($status	==	"success"?"":"annoucement-msg")
			<div class="col-sm-12 space-around">
				<div class="annoucement-msg-container">
					<div class="alert alert-success {{$alertClass}}">
						<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
						{{$msg}}
					</div>
				</div>				
			</div>
		@endif
	</div>	
	
	<!--<div class="row">	
		<div class="col-lg-12 col-sm-12">	-->
			<form class="form-inline" id="form-applyloan" method="post" enctype="multipart/form-data">	
				<input type="hidden" name="_token" value="{{ csrf_token() }}">	
				<input type="hidden" name="isSaveButton" id="isSaveButton" value="">	
				<input type="hidden" name="loan_id" value="{{$BorModLoan->loan_id}}">	
				<input type="hidden" name="trantype" value="{{ $trantype }}">
				<input type="hidden" name="hidden_loan_status" id="hidden_loan_status" value="{{ $loan_status }}">
				
				
				
			<div class="row">
				<div class="col-lg-12 col-md-6 col-xs-12">
				<ul class="nav nav-tabs">
					<li class="active">
						<a 	data-toggle="tab"
							href="#loans_info">
							{{ Lang::get('borrower-applyloan.loan_info') }}
						</a>
					</li>
					<li class="disabled">
						<a 	data-toggle="tab"
							href="#documents_submitted">
							{{ Lang::get('borrower-applyloan.document_submit') }}
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
					
					<!-------first-tab--------------------------------->
					@include('widgets.borrower.tab.applyloan_info')
					<!-------second tab--starts------------------------>
					@include('widgets.borrower.tab.applyloan_documents_submit')
					@if($canViewCommentsTab	==	"yes")
						<!-----Sixth Tab content starts----->
							@include('widgets.admin.tab.loanapproval_comments')	
						<!-----Sixth Tab content ends----->
					@endif
				</div><!--tab content-->	
			
			
			<div class="row">	
				<div class="col-sm-12">			
				<div class="pull-right">	
					@if($trantype	==	"edit")
						@var	$preview	=	"borrower/myloans/".base64_encode($BorModLoan->loan_id)
						<input 	type="button" 
								value="Preview"
								id="preview_url"
								data-preview-url="{{url($preview)}}"
								class="btn verification-button"
								/>
					@endif
						
					<button type="submit" 
							id="save_button"
							class="btn verification-button"
							{{$BorModLoan->viewStatus}}>
						<i class="fa pull-right"></i>
						Save
					</button>
					<button type="button" 
							id="next_button"
							data-tab-id="company_info"
							class="btn verification-button" >
							<i class="fa pull-right"></i>
							{{ Lang::get('Next') }}
					</button>
								
					<button type="submit" 
							class="btn verification-button"
							style="display:none"
							id="submit_button"
							{{$BorModLoan->viewStatus}}>
						<i class="fa pull-right"></i>
						{{ Lang::get('borrower-profile.submit_verification') }}
					</button>
					
				</div>	
				</div>			 
			</div> 			
			</form>	
			
			</div><!--row-->	
			</div>
			
	<!--	</div><!--col-->	
	<!--</div>	<!--row-->	
</div><!--col-->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>    
<script>
$(document).ready(function(){ 
	// Main tabs
	$(":file").jfilestyle({buttonText: "Attach Docs",buttonBefore: true,inputSize: '200px'});  // file upload


	// date picker
	$('.date-picker').datetimepicker({
	autoclose: true,
	minView: 2,
	format: 'dd/mm/yyyy'

	}); 
	$("#preview_url").on('click',function (){
		window.location	=	$(this).attr("data-preview-url");
	});
}); 
</script>  	
    @endsection  
@stop
