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
	<script>
		$(document).ready(function(){			
			$('#laon_purpose').ckeditor();   //text editor
			$('[data-toggle="tooltip"]').tooltip();
		});		
	</script>		
@endsection
@if($BorModLoan->loan_id	==	"")
	@var	$trantype		=	"add"
	@var	$page_heading	=	Lang::get('borrower-applyloan.apply_loan')
@else
	@var	$trantype		=	"edit"
	@var	$page_heading	=	Lang::get('borrower-applyloan.edit_loan')
@endif   
@section('page_heading',$page_heading) )
@section('status_button')						
		<!--------Status Button Section---->   
		
			  <h4><span class="label label-default status-label">{{$BorModLoan->statusText}}</span></h3>			
													
@endsection
@section('section')

<div class="col-sm-12 text-center space-around">
	<div class="annoucement-msg-container">
		<div class="alert alert-success annoucement-msg">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<h4>{{ Lang::get('borrower-applyloan.loan_title_info_1') }}{{ Lang::get('borrower-applyloan.loan_title_info_2') }}</h4>	
		</div>
	</div>				
</div>
<div class="col-sm-12"> 	
	<form class="form-inline" method="post" enctype="multipart/form-data">	
		<input type="hidden" name="_token" value="{{ csrf_token() }}">	
		<input type="hidden" name="isSaveButton" value="">	
		<input type="hidden" name="trantype" value="{{ $trantype }}">
	<div class="row">				
		<div class="col-lg-12 col-sm-12">				
				
			<!--<div class="row">-->
				<ul class="nav nav-tabs">
					<li class="active">
						<a 	data-toggle="tab"
							href="#loans_info">
							{{ Lang::get('borrower-applyloan.loan_info') }}
						</a>
					</li>
					<li>
						<a 	data-toggle="tab"
							href="#documents_submitted">
							{{ Lang::get('borrower-applyloan.document_submit') }}
						</a>
					</li>								
				</ul>					

				<div class="tab-content">
					<!-------first-tab--------------------------------->
					@include('widgets.borrower.tab.applyloan_info')
					<!-------second tab--starts------------------------>
					@include('widgets.borrower.tab.applyloan_documents_submit')
				</div><!--tab content-->	
			<!--</div><!--row-->	
			
			<div class="row"> 
				<div class="col-sm-12"> 
					<div class="pull-right">	
						
						<button type="submit" 
								class="btn verification-button">
							<i class="fa pull-right"></i>
							Save
						</button>
						
						<button type="submit" 
								class="btn verification-button">
							<i class="fa pull-right"></i>
							{{ Lang::get('borrower-profile.submit_verification') }}
						</button>
						
					</div>
				</div> 
			</div> 
			
			
			
			
		</div><!--col-->										
	</div>	<!--row-->							
	</form>	
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
}); 
</script>  	
    @endsection  
@stop
