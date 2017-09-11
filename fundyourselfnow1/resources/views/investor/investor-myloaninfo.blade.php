@extends('layouts.dashboard')
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 	
		<link href='{{ asset("assets/summernote/summernote.css") }}' rel="stylesheet">	 
	<style>
	textarea{
		margin-top:7px;
	}
	
	.btn.verification-button {
    	margin-top: 47px !important;
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

@endsection
@section('body')

<div class="bg-dark dk" id="wrap">
                <div id="top">
                    <!-- .navbar -->
                   @include('header')
                    <!-- /.navbar -->
                </div>
           	<header class="head">
                                
                                <!-- /.search-bar -->
								
                            <div class="main-bar">
							<div class="container-fluid">
							<div class="row">
                 <div class="col-xs-6">
                                <h3>
              <i class="fa fa-google-wallet" aria-hidden="true"></i>
&nbsp;
            My Projects
          </h3>
		  </div>
                            </div>
                            <!-- /.main-bar -->

							</div>
							</div>
                        </header>
                        <!-- /.head -->
 </div>


 <div id="content">
                    <div class="outer">
                        <div class="inner1 bg-light lter">

			<div class="row"> 
@var	$investortAllLoan	=	$InvModMyLoanInfo->allLoanInfo

<div class="col-sm-12"> 			
	<div class="row">			
			
			<div class="col-sm-12 space-around"> 
				<div class="panel panel-primary panel-container">
					
					<div class="panel-heading panel-headsection">					
						{{ Lang::get('PROJECT INFO')}}
					</div>
					
					<div class="col-sm-12 loan-info-wrapper">
						<div id="filter_area">
							<form >
								<div class="row">	
									<div class="col-sm-12 col-lg-3"> 														
										<div class="form-group"><br>	
											<strong>{{ Lang::get('Project Status') }}</strong>							
											{{ 
												Form::select('loanstatus_filter', 
																$InvModMyLoanInfo->filterloanStatusList, 
																$InvModMyLoanInfo->filterloanStatusValue,
																["class" => "selectpicker",
																"filter_field" => "Yes"]) 
											}} 
										</div>
									</div>
									<div class="col-sm-12 col-lg-3"> 														
										<div class="form-group">		
											<button type="submit" class="btn verification-button">
												{{ Lang::get('borrower-loanlisting.apply_filter') }}			
											</button>
										</div>	
									</div>	
<!--
									<div class="col-sm-12 col-lg-6 text-right"> 
										<ul class="pagination">
											<li>
												<a href="javascript:void(0)" id="prev">
													<i class="fa fa-chevron-circle-left"></i>
												</a>
											</li>
											<li>
												<a href="javascript:void(0)" id="next">
													<i class="fa fa-chevron-circle-right"></i>
												</a>
											</li>	
										</ul>
									</div>
-->
								</div>
							</form>
						</div>
						<div class="row"> 
							@if(count($investortAllLoan) > 0)
								<div class="col-sm-5 col-lg-2" style="padding-top: 8px;">		
									<a class="btn btn-lg loan-detail-button" style="visibility:hidden;">Hidden Field														
									</a>								
									<div class="table-responsive"><!---table start-->
										<table class="table text-left loaninfo-table-label">		
											<tbody>																								
												<tr>
													<td>{{ Lang::get('Project Reference')}}</td>														
												</tr>
												<tr>
													<td>{{ Lang::get('Project Title')}}</td>												
												</tr>
<!--
												<tr>
													<td>{{ Lang::get('Grade')}}</td>												
												</tr>
												<tr>
													<td>{{ Lang::get('Target Interest')}}</td>												
												</tr>
												<tr>
													<td>{{ Lang::get('Amount Applied')}}</td>												
												</tr>
												<tr>
													<td>{{ Lang::get('Amount Offered')}}</td>												
												</tr>
												<tr>
													<td>{{ Lang::get('Amount Accepted')}}</td>												
												</tr>
												<tr>
													<td>{{ Lang::get('Interest % bid')}}</td>												
												</tr>
-->
												<tr>
													<td>{{ Lang::get('Status')}}</td>												
												</tr>	
												<tr>
													<td>
														
													</td>
												</tr>									
											</tbody>
										</table>	
									</div>							
								</div> <!----col--2--->
							<div class="divs text-right">
<!--
								
								<a class="prev"><i class="fa fa-chevron-circle-left"></i></a> <a class="next"><i class="fa fa-chevron-circle-right"></i></a>
-->				


								<div class="col-sm-6 col-lg-10 loan-details pagination" style="margin:0;">
								
							
							<div class="carousel slide" id="myCarousel">
							        <div class="carousel-inner">
							          <div class="item active">
									 <?php $i = 1; ?>
							       <ul class="thumbnails">

									@foreach($investortAllLoan as $loanRow)
										@var	$loan_url	=	'/projectdetails/'.base64_encode($loanRow->loan_id)
										<li class="col-sm-3">
							    						<div class="fff">
															<div class="caption">			
										@if($loanRow->viewStatus !=	"")
												<a 	href="{{ url ($loan_url) }}"
													class="btn btn-lg loan-detail-button">
													{{$loanRow->viewStatus}}
												</a>
										@endif	
												<p>
												@if($loanRow->loan_reference_number	!=""	)
																	{{$loanRow->loan_reference_number}}
																@else
																	--
																@endif
																</p>

															<p>
															@if($loanRow->loan_title	!=""	)
																	{{$loanRow->loan_title}}
																@else
																	--
																@endif</p>
																<p>
																@if($loanRow->status	!=""	)
																	{{$loanRow->status}}
																@else
																	--
																@endif
																</p>
												</div>
												</div>
												</li>

									 @if($i % 4 == 0)</div><div class="item">@endif
											            <?php $i++  ?>
											              	@endforeach
											              	   </ul>
											              	   </div>
											              	   </div>
											              	   </div>
								</div><!---col--10-->
										<div class="clearfix"></div>
									                      <nav>
															<ul class="control-box pager">
																<li><a data-slide="prev" href="#myCarousel" class=""><i class="glyphicon glyphicon-chevron-left"></i></a></li>
																<li><a data-slide="next" href="#myCarousel" class=""><i class="glyphicon glyphicon-chevron-right"></i></li>
															</ul>
														</nav>
							</div>	
							</div>
							<!---row--->
						@else
							<p style="padding:10px">
								{{ Lang::get('No Projects Found') }}
							</p>
						@endif
						
					</div>	<!---col 12--->
									
				</div><!--panel container--->			
			</div><!---col 12--->
					
	<div><!---row--->
</div><!- --col 12- -->
</div>
</div>
</div>
</div>

 
@endsection  
@stop
