@extends('layouts.dashboard')
@section('styles')
	<link href="{{ url('css/bootstrap-datetimepicker.css') }}" rel="stylesheet"> 	
		<link href='{{ asset("assets/summernote/summernote.css") }}' rel="stylesheet">	 
	<style>
	textarea{
		margin-top:7px;
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
		@var 	$fundsDepolyedInfo 		= 	$InvDashMod->fundsDepolyedInfo;
		@var 	$invUnderBidInfo 		= 	$InvDashMod->invUnderBidInfo;
		@var 	$overDueInfo 			= 	$InvDashMod->overDueInfo;
		@var 	$Investments_verified 	= 	$InvDashMod->invested_amount;
		@var 	$Investments_pending 	= 	$InvDashMod->pending_investment;
		@var 	$deposits_verified 		= 	$InvDashMod->deposits;
		@var 	$deposits_pending 		= 	$InvDashMod->pending_deposits;
		@var 	$withdrawals_verified 	= 	$InvDashMod->withdrawals;
		@var 	$withdrawals_pending	= 	$InvDashMod->pending_withdrawals;
		@var 	$earnings_verified		= 	$InvDashMod->earnings_verified;
		@var 	$earnings_pending		= 	$InvDashMod->earnings_pending;
		@var 	$ava_for_invest			= 	$InvDashMod->ava_for_invest;
		@var	$invFeatureLoans		=	$InvDashMod->featuredLoanInfo;
      <div class="bg-dark dk" id="wrap">
                <div id="top">
                    <!-- .navbar -->
                   @include('header')
                    <!-- /.navbar -->
               
                        <header class="head">
                               
                                <!-- /.search-bar -->
                            <div class="main-bar">
                                <h3>
              <i class="fa fa-tachometer" aria-hidden="true"></i>
&nbsp;
           {{Lang::get('backer-dashboard.dashboard')}}
          </h3>
                            </div>
                            <!-- /.main-bar -->
                        </header>
                        <!-- /.head -->
                </div>
                
                <div id="content">
                    <div class="outer">
                        <div class="inner1 bg-light lter">
						<div class="row">
				<!-----first col----->
				<div class="col-lg-6 col-md-6">
					<div class="panel panel-primary panel-container table-border-custom">
						
						<div class="panel-heading panel-headsection"><!--panel head-->
							<div class="row">
								<div class="col-xs-8 col-lg-10">
									<span class="pull-left">
									@if( $InvDashMod->isFeaturedLoanInfo	==	"yes" )
											{{Lang::get('backer-dashboard.feature_project')}}
										@else
											{{Lang::get('backer-dashboard.available_project')}}
										@endif

									</span> 
								</div>
								<div class="col-xs-1 col-lg-1 pull-right ar_l">
									<i class="fa fa-caret-left cursor-pointer"></i>
								</div>
								<div class="col-xs-1 col-lg-1 pull-right ar_r">
									<i class="fa fa-caret-right cursor-pointer"></i>
								</div>	
																
							</div>							
						</div>	<!--end panel head-->
						
						<div class="panel-body"><!--panel body-->
								<input 	type="hidden" id="current_loan_index" 
										value="0" />
							   <div class="panel-subhead" id="cur_loan_subhead">

								 @if(isset($invFeatureLoans[0]))
											{{$invFeatureLoans[0]->business_name}}
										@endif
																		</div>
							   <div  id="cur_loan_content">
								 @if(isset($invFeatureLoans[0]))
										{{$invFeatureLoans[0]->purpose}}
									@endif											
																	</div>
						</div>	<!--end panel body-->
						<div class="table-responsive"><!---table start-->
							<table class="table text-left">								
								<tbody>
									<tr>
										<td class="tab-left-head" >
											{{Lang::get('Amount')}}
										</td> 
										<td  id="cur_project_amount">
											 @if(isset($invFeatureLoans[0]))
												{{number_format($invFeatureLoans[0]->amount,2,'.',',')}}
											@endif
																					</td>										
									</tr>
									<tr>
										<td class="tab-left-head" >
											{{Lang::get('backer-dashboard.amount_realised')}}
										</td> 
										<td  id="cur_project_amount_realized">
											@if(isset($invFeatureLoans[0]))
												{{number_format($invFeatureLoans[0]->amount_realized,2,'.',',')}}
											@endif
																					</td>										
									</tr>
									<tr>
										<td class="tab-left-head" >
											{{Lang::get('backer-dashboard.close_date')}}
										</td> 
										<td  id="cur_project_close_date">
											 @if(isset($invFeatureLoans[0]))
												{{$invFeatureLoans[0]->funding_duration}}
											@endif
																					</td>										
									</tr>
									<tr>
										<td class="tab-left-head" >
											{{Lang::get('backer-dashboard.no_of_days')}}
										</td> 
										<td  id="cur_project_noofdays">
											 												20
																					</td>										
									</tr>
								</tbody>
							</table>							 
						</div> <!---table end--->   	
					</div>
				</div>
				<!-----first col end----->
				<!-----second col-------->
				<div class="col-lg-6 col-md-6">
<!--
					<div class="panel panel-default">
						<div class="panel-body">
																					<div class="panel panel-default">
	  
		<div class="panel-heading">
		<h3 class="panel-title">Return on Investment(%)			</h3>
	
	</div>
		
	<div class="panel-body">
									<canvas id="cbar" width="350" height="100"></canvas>
<div id="cbarlegend" class="chart-legend"></div>
								</div>
	</div>

						</div>								
					</div>	
-->
				</div>			
			<!--second col end--->				
		</div>
		<!---third row---->
		<!--div class="row">
			 <div class="col-lg-12 col-md-12">
				 
				 <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
       <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">PROJECTS FUNDED
          <span class="pull-right"><i class="fa fa-caret-down cursor-pointer"></i></span></a>
        </h4>
      
      </div>
      <div id="collapse1" class="panel-collapse collapse in">
        <div class="panel-body">
        
						 <div class="panel panel-primary panel-container">
								
					<div class="table-responsive">
						<table class="table text-left">
							<thead>
								<tr>
									<th class="tab-head text-left">Creator's Name</th>
									<th class="tab-head text-left">Grade</th>
									<th class="tab-head text-right">Amount Invested</th>
									<th class="tab-head text-center">Date of Investment</th>
								</tr>
							</thead>
							<tbody>
																	<tr>
										<td colspan="10" class="text-center">
											No Data Found
										</td>
									</tr>
																				
							</tbody>
						</table>						
					</div>	
                </div>              
        
        
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">PROJECTS UNDER BID
            <span class="pull-right"><i class="fa fa-caret-down cursor-pointer"></i></span></a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
        <div class="panel-body">
        
         <div class="panel panel-primary panel-container">
							
					<div class="table-responsive">
						<table class="table text-left">
							<thead>
								<tr>
									<th class="tab-head text-left">Creator's Name</th>
									<th class="tab-head text-left">Grade</th>
									<th class="tab-head text-right">Amount Invested</th>
									<th class="tab-head text-center">Date of Investment</th>
								</tr>
							</thead>
							<tbody>
																									<tr>
										<td>ABC company</td>
										<td>A</td>
										<td class="text-right">23,000.00</td>
										<td class="text-center">06-03-17</td>
									</tr>				
																	<tr>
										<td>ABC company</td>
										<td>C</td>
										<td class="text-right">40,000.00</td>
										<td class="text-center">25-02-17</td>
									</tr>				
																	<tr>
										<td>ABC company</td>
										<td>A</td>
										<td class="text-right">10,000.00</td>
										<td class="text-center">03-07-17</td>
									</tr>				
																	<tr>
										<td>ABC company</td>
										<td></td>
										<td class="text-right">1,000.00</td>
										<td class="text-center">12-07-17</td>
									</tr>				
																	<tr>
										<td>ABC company</td>
										<td>A</td>
										<td class="text-right">50,000.00</td>
										<td class="text-center">12-07-17</td>
									</tr>				
																	<tr>
										<td>ABC company</td>
										<td>C</td>
										<td class="text-right">1,000.00</td>
										<td class="text-center">11-07-17</td>
									</tr>				
																	<tr>
										<td>ABC company</td>
										<td>A</td>
										<td class="text-right">10,000.00</td>
										<td class="text-center">03-07-17</td>
									</tr>				
									
															</tbody>
						</table>											
					</div>
                </div>              
             
        
        
        </div>
      </div>
    </div>
			
														
										
										
			
                       
                    </div>
                    
                </div>
				</div-->
				</div>
				</div>
				</div>
                <!-- /#content -->

    @endsection  
@stop
