@extends('layouts.dashboard')	
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 	
	
@endsection
@section('bottomscripts')
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>  
	<script>
	$(document).ready(function(){ 	
		$(":file").jfilestyle({buttonText: "Upload",buttonBefore: true,inputSize: '110px'});  // file upload  
	}); 
	</script>	 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>		
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>	
	<script src="{{ url('js/jquery-filestyle.min.js') }}" type="text/javascript"></script>	
	<script src="{{ url('js/borrower-profile.js') }}" type="text/javascript"></script>		 	
	<script src="{{ url('js/common.js') }}" type="text/javascript"></script>		 	
	
	<script src="{{ url('js/numeral.min.js') }}" type="text/javascript"></script>		 	
@endsection 
@section('page_heading',Lang::get('borrower-profile.profile'))
@section('status_button')						
		<!--------Status Button Section---->   
		<h4><span class="label label-default status-label">{{$modelBorPrf->statusText}}</span></h4>							
@endsection
@section('section')   
		
		@if($modelBorPrf->borrower_id	==	"")
			@var	$trantype	=	"add"
		@else
			@var	$trantype	=	"edit"
		@endif
		<!-----Body Content----->
		<div class="col-sm-12 space-around"> 
			
			@if($submitted)
				<div class="row">
					<div class="col-sm-12">
						<div class="annoucement-msg-container">
							<div class="alert alert-success">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								@if($modelBorPrf->status	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL)
									{{ Lang::get('borrower-profile.success') }}
								@else
									{{ Lang::get('borrower-profile.save') }}
								@endif
							</div>
						</div>
					</div> 
				</div> 	
			@endif
			<!--comments----->
			@if(!$submitted && $modelBorPrf->status	==	BORROWER_STATUS_COMMENTS_ON_ADMIN)
				<div class="row">
					<div class="col-sm-12">
						<div class="annoucement-msg-container">
							<div class="alert alert-danger annoucement-msg">
								<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								{{$modelBorPrf->comments}}
							</div>
						</div>
					</div> 
				</div> 	
			@endif
			<form method="post" id="form-profile" name="form-profile" enctype="multipart/form-data">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
				<input type="hidden" name="trantype" value="{{ $trantype }}">
				<input type="hidden" id="isSaveButton" name="isSaveButton" value="">
				<input type="hidden" name="borrower_id" value="{{ $modelBorPrf->borrower_id }}">
				<input type="hidden" name="borrower_bankid" value="{{ $modelBorPrf->borrower_bankid }}">
				<div class="row">	
					
					<div class="col-lg-12 col-md-6 col-xs-12">
						<!-----Tab Starts----->
						<ul class="nav nav-tabs">
							<li class="active">
								<a 	data-toggle="tab" 
									href="#company_info">
									{{ Lang::get('borrower-profile.company_info') }}
								</a>
							</li>
							<li class="disabled">
								<a 	data-toggle="tab"
									href="#director_info">
									{{ Lang::get('borrower-profile.directors_info') }}
								</a>
							</li>	  
							<li class="disabled">
								<a 	data-toggle="tab"
									href="#profile_info">
									{{ Lang::get('borrower-profile.profile_info') }}
								</a>
							</li>	
							<li class="disabled">
								<a 	data-toggle="tab"
									href="#financial_info">
									{{ Lang::get('borrower-profile.financial_info') }}
								</a>
							</li>	
							<li class="disabled">
								<a 	data-toggle="tab"
									href="#bank_info">
									{{ Lang::get('borrower-profile.bank_info') }}
								</a>
							</li>						   							
						</ul>	
				
					<div class="tab-content">
						<!-----First Tab content Starts----->
							@include('widgets.borrower.tab.profile_company_info')
						<!-----First Tab content end----->
						
						<!-----Second Tab content starts----->
							@include('widgets.borrower.tab.profile_directory_info')
						<!-----Second Tab content ends----->
						
						<!-----Third Tab content starts----->
							@include('widgets.borrower.tab.profile_info')
						<!-----Third Tab content ends----->	
						
						<!-----Four Tab content starts----->
							@include('widgets.borrower.tab.profile_financial_info')
						<!-----Four Tab content ends----->	
						
						<!-----Five Tab content starts----->
							@include('widgets.borrower.tab.profile_bank_info')
						<!-----Five Tab content ends----->	
						
					</div>	<!---col ends-->	
				
					<div class="row"> 
						<div class="col-sm-12"> 
							<div class="pull-right">
								@if(($modelBorPrf->status	==	BORROWER_STATUS_COMMENTS_ON_ADMIN)
									||	($modelBorPrf->status	==	BORROWER_STATUS_NEW_PROFILE) )
									<button type="submit" 
											id="save_button"
										class="btn verification-button" >
										<i class="fa pull-right"></i>
										{{ Lang::get('borrower-profile.save_button') }}
									</button>
								@endif
								<button type="button" 
											id="next_button"
											data-tab-id="company_info"
										class="btn verification-button" >
										<i class="fa pull-right"></i>
										{{ Lang::get('Next') }}
									</button>
									
								<button type="submit" 
										style="display:none"
										id="submit_button"
										class="btn verification-button {{$modelBorPrf->viewStatus}}"
										 {{$modelBorPrf->viewStatus}}>
									<i class="fa pull-right"></i>
									{{ Lang::get('borrower-profile.submit_verification') }}
								</button>
								
							</div>
						</div> 
					</div> 
				
			</div><!--row end-->
		</form>
	</div><!--body end--->
 </div>
<div style="display:none">
<input type="hidden" id="max_director" value= "{{ count($modelBorPrf->director_details) }}" />
	<div  id="directorTemplate">
		<div id="XXX" class="dir-list">
			<div class="table-responsive">
			<table class="table table-bordered .tab-fontsize text-left">		
				
				<tr>
					<td class="col-md-3">
						<label class="input-required">
							{{ Lang::get('borrower-profile.director_name') }}
						</label>
					</td>
					<td class="col-md-3"  id="name_XXX_parent">
						<input 	type="text" 
								id="name_XXX" 
								name="director_row[name][]"
								class="form-control required"
								/>
					</td>		
				</tr>
				<tr>
					<td class="col-md-3">
						<label class="input-required">
							{{ Lang::get('borrower-profile.director_info') }}
						</label>
					</td>
					<td class="col-md-3" 	id="directors_profile_XXX_parent">
						<textarea	id="directors_profile_XXX" 
									name="director_row[directors_profile][]"
									class="form-control required"
								></textarea>
					</td>		
				</tr>												
				<tr>
					<td class="col-md-3">
						{{ Lang::get('borrower-profile.age') }}
					</td>
					<td class="col-md-3">
						<input 	type="text" 
								id="age_XXX" 
								name="director_row[age][]"
								class="form-control"
								/>
					</td>			
				</tr>
					<tr>
					<td class="col-md-3">
						{{ Lang::get('borrower-profile.period_since') }}
					</td>
					<td class="col-md-3">
						<input 	type="text" 
								id="period_in_this_business_XXX" 
								name="director_row[period_in_this_business][]"
								class="form-control"
								/>
					</td>	
				</tr>
					<tr>
					<td class="col-md-3">
						{{ Lang::get('borrower-profile.overall_exp') }}
					</td>
					<td class="col-md-3">
						<input 	type="text" 
								id="overall_experience_XXX" 
								name="director_row[overall_experience][]"
								class="form-control"
								/>
					</td>	
				</tr>
					<tr>
					<td class="col-md-3">
						{{ Lang::get('borrower-profile.accomplish') }}
					</td>
					<td class="col-md-3">
						<textarea	id="accomplishments_XXX" 
									name="director_row[accomplishments][]"
									class="form-control"
								></textarea>
					</td>
				</tr>													
			</table></div>
		</div>
	</div>
</div>

  @endsection  
@stop
