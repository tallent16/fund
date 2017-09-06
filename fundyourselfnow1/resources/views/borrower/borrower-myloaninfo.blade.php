@extends('layouts.dashboard')
@section('bottomscripts') 
	<!-- <script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script> -->
	<script>
		var baseUrl	=	"{{url('')}}"
	</script>
	
	<script>
		//~ $(document).ready(function(){   	
		//~ 
			//~ var newHeight1 = $(".loan-list-table tr:nth-child(7)").innerHeight();
			//~ $(".loaninfo-table-label tr:nth-child(7)").css("height", newHeight1+"px"); 	 //Effective interest label row height based on right side data
			//~ 
			//~ var newHeight2 = $(".loaninfo-table-label tr:nth-child(7)").innerHeight(); 
			//~ $(".loan-list-table tr:nth-child(7)").css("height", newHeight2+"px"); 	     //Effective interest data row height based on left side label when screen size 1280px
			//~ 
			//~ var newHeight3 = $(".loan-list-table tr:nth-child(10)").innerHeight();
			//~ $(".loaninfo-table-label tr:nth-child(10)").css("height", newHeight3+"px");	 //Repayments till date	row height based on right side data
				//~ 
			//~ var newHeight4 = $(".loaninfo-table-label tr:nth-child(10)").innerHeight();
			//~ $(".loan-list-table tr:nth-child(10)").css("height", newHeight4+"px");       //Repayments till date	data row height based on left side label when screen size 1280px
			//~ 
			//~ var newHeight5 = $(".loaninfo-table-label tr:nth-child(11)").innerHeight();
			//~ $(".loan-list-table tr:nth-child(11)").css("height", newHeight5+"px");       //Principal outstanding data based on left side label when screen size 1280px
				//~ 
		//~ });
	</script>
	<script src="{{ asset("js/borrower-myloaninfo.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('My Projects') )
@section('body')    
@var	$borrowerAllList	=	$BorModMyLoanInfo->allloan_details
@var    $borrowerAllList    =   $BorModMyLoanInfo->allloan_details
            <div class="bg-dark dk" id="wrap">
                <div id="top">
                    <!-- .navbar -->
                    @include('header')
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
                            <div class="main-bar">
                                <h3>
              <i class="fa fa-google-wallet fa-fw"></i>
&nbsp;
            My Projects
          </h3>
                            </div>
                            <!-- /.main-bar -->
                        </header>
                          <div id="content">
                    <div class="outer">
                        <div class="inner1 bg-light lter">
						
			<div class="row">  
<div class="col-sm-12 space-around"> 			
	<div class="row">			
			
			<div class="col-sm-12"> 
				<div class="panel panel-primary panel-container">
					
					<div class="panel-heading panel-headsection">					
						{{ Lang::get('PROJECT INFO') }}
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
																$BorModMyLoanInfo->filterloanStatusList, 
																$BorModMyLoanInfo->filterloanStatusValue,
																["class" => "selectpicker",
																"filter_field" => "Yes"]) 
											}} 
										</div>
									</div>
									<div class="col-sm-12 col-lg-3"> 														
										<div class="form-group">	
											<button type="submit" class="btn verification-button">
												{{ Lang::get('Apply Filter') }}			
											</button>
										</div>	
									</div>
								</div>
							</form>
						</div>
						
						
						
						@if(count($borrowerAllList) > 0)
						<div class="row"> 
							<!----col--2--->
							<div class="col-sm-6 col-lg-2">
									<a class="btn btn-lg loan-detail-button" style="visibility:hidden;">Hidden Field														
									</a>											
								<div class="table-responsive"><!---table start-->
									<table class="table text-left loaninfo-table-label">		
										<tbody>																								
											<tr>
												<td>{{ Lang::get('Project Reference') }}</td>														
											</tr>
											<tr>
												<td>{{ Lang::get('borrower-loaninfo.date_applied') }}</td>												
											</tr>
											<tr>
												<td>{{ Lang::get('borrower-loaninfo.status') }}</td>												
											</tr>
											<tr>
												<td>{{ Lang::get('Backer List') }} %</td>												
											</tr>
											<tr>
												<td>{{ Lang::get('borrower-loaninfo.amount_applied') }}</td>												
											</tr>
											<tr>
												<td>{{ Lang::get('Amount Funded') }}</td>												
											</tr> 
											
											<tr>
												<td>
													
												</td>
											</tr>		
										</tbody>
									</table>	
								</div>							
							</div> <!----col--2--->
							<!---col--10-->
							<div class="divs text-right">
<!--

								<a class="prev"><i class="fa fa-chevron-circle-left"></i></a> <a class="next"><i class="fa fa-chevron-circle-right"></i></a>
-->

							<div class="col-sm-6 col-lg-10 loan-details pagination">
								
									
									<div class="col-xs-12 col-md-10 loan-details pagination">
							
							<div class="carousel slide" id="myCarousel">
							        <div class="carousel-inner">
							          <div class="item active">
                               
							       <?php $i = 1; ?>
							       <ul class="thumbnails">

							         @foreach($borrowerAllList as $loanRow)
							 
							                 
							          
							                    
							                        <li class="col-sm-3">
							    						<div class="fff">
															<div class="caption">
                                                                 @if(($loanRow->status	==	BORROWER_STATUS_NEW) || 
															($loanRow->status	==	LOAN_STATUS_PENDING_COMMENTS))
												@var	$loan_url	=	'creator/create_project/'.base64_encode($loanRow->loan_id)
												@var	$bid_url	=	'creator/myprojects/'
												@var	$bid_url	=	$bid_url.base64_encode($loanRow->loan_id."_bids")
											@else
												@var	$loan_url	=	'creator/myprojects/'.base64_encode($loanRow->loan_id)
												@var	$bid_url	=	'creator/myprojects/'
												@var	$bid_url	=	$bid_url.base64_encode($loanRow->loan_id."_bids")
											@endif
											@if($loanRow->viewStatus	!=	"Cancelled Loan" && $loanRow->viewStatus	!=	"")

												<a href="{{ url ($loan_url) }}"
													class="btn btn-lg loan-detail-button">
													{{$loanRow->viewStatus}}
												</a>
											@else
												<!-- <a href="javascript:void(0);"
													class="btn btn-lg loan-detail-button">
													{{$loanRow->viewStatus}}
												</a> -->
											@endif	
												<p>@if($loanRow->loan_reference_number	!=	"")
																{{$loanRow->loan_reference_number}}
															@else
																--
															@endif	</p>
															<p>	@if($loanRow->apply_date	!=	"")
																{{$loanRow->apply_date}}
															@else
																--
															@endif		</p>

															<p>	@if($loanRow->statusText	!=	"")
																{{$loanRow->statusText}}
															@else
																--
															@endif		</p>
															<p>@if(($loanRow->status	==	LOAN_STATUS_APPROVED)
																||	($loanRow->status	==	LOAN_STATUS_CLOSED_FOR_BIDS)
																||	($loanRow->status	==	LOAN_STATUS_BIDS_ACCEPTED) )
																<a href="{{ url ($bid_url) }}"
																	class="btn button-grey">
																	{{ Lang::get('View All Backers') }}
																</a>														
															@else
																--
															@endif </p>
															<p>	@if($loanRow->amount_applied	!=	"")
																{{number_format($loanRow->amount_applied,2,'.',',')}}
															@else
																--
															@endif</p>
															<p>	@if($loanRow->amount_realized	!=	"")
																{{number_format($loanRow->amount_realized,2,'.',',')}}
															@else
																--
															@endif				</p>
											</div>
					                                                </div>
											                        </li>
											                 
											              @if($i % 4 == 0)</div><div class="item">@endif
											            <?php $i++  ?>
											              	@endforeach
											              	   </ul>
											              
                                                       </div>
                                                       	</div>
							
       
													   <nav>
															<ul class="control-box pager">
																<li><a data-slide="prev" href="#myCarousel" class=""><i class="glyphicon glyphicon-chevron-left"></i></a></li>
																<li><a data-slide="next" href="#myCarousel" class=""><i class="glyphicon glyphicon-chevron-right"></i></li>
															</ul>
														</nav>
													   <!-- /.control-box -->   
												
			
						@else
							<p>
								{{ Lang::get('borrower-loaninfo.no_loan_found') }}
							</p>
						@endif
					
			           </div>
						</div>
						</div>
						</div>		
							</div>
						</div>
						</div>
						</div>
							
<input type="hidden" name="_token" id="hidden_tokenz" value="{{ csrf_token() }}">	
 @section ('popup-box_panel_title',Lang::get('borrower-loaninfo.all_repayment_schedule'))
	@section ('popup-box_panel_body')
		
	@endsection
	@include('widgets.modal_box.panel', array(	'id'=>'repayment_information',
												'aria_labelledby'=>'repayment_information',
												'as'=>'popup-box',
												'class'=>'',
											))


@endsection  
@stop
