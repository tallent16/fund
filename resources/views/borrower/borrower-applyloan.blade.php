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
	<script>var	baseUrl	=	"{{url('')}}"</script>
	<script src="{{ url('js/apply-loan.js') }}"></script>  
	
@endsection
@if($BorModLoan->loan_id	==	"")
	@var	$trantype		=	"add"
	@var	$page_heading	=	Lang::get('borrower-applyloan.apply_loan')
@else
	@var	$trantype		=	"edit"
	@var	$page_heading	=	Lang::get('borrower-applyloan.edit_loan')
@endif   
@if($BorModLoan->loan_status	==	LOAN_STATUS_PENDING_COMMENTS)
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
					@if( ($BorModLoan->loan_status	==	LOAN_STATUS_NEW)
						||  ($BorModLoan->loan_status	==	LOAN_STATUS_PENDING_COMMENTS))
						<button type="submit" 
								id="save_button"
								class="btn verification-button"
								{{$BorModLoan->viewStatus}}>
							<i class="fa pull-right"></i>
							Save
						</button>
						@if($BorModLoan->loan_status	==	LOAN_STATUS_NEW)
							@if(!$BorModLoan->completeLoanDetails)
								<button type="button" 
										id="next_button"
										data-tab-id="company_info"
										class="btn verification-button" >
										<i class="fa pull-right"></i>
										{{ Lang::get('Next') }}
								</button>
							@endif		
						@endif		
						<button type="submit" 
								class="btn verification-button"
								style="display:none"
								id="submit_button"
								{{$BorModLoan->viewStatus}}>
							<i class="fa pull-right"></i>
							{{ Lang::get('borrower-profile.submit_verification') }}
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
