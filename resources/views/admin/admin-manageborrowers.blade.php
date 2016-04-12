@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	@endsection
@section('page_heading',Lang::get('Manage Borrowers') )
@section('section')  
@var	$adminBorModel	=	$adminbormodel->borrowerListInfo
<div class="col-sm-12 space-around">
	<form action="" method="get">
		<div class="row">	
			<div class="col-sm-12 col-lg-3"> 														
				<div class="form-group"><br>	
					<strong>{{ Lang::get('Borrower Status') }}</strong>							
					{{ 
						Form::select('borrowerstatus_filter',$adminbormodel->filterBorrowerStatusList, 
										$adminbormodel->filterBorrowerStatusValue,
										["class" => "selectpicker"]) 
					}} 
				</div>
			</div>
			<div class="col-sm-12 col-lg-3"> 														
				<div class="form-group"><br><br>			
					<button type="submit" class="btn verification-button">
						{{ Lang::get('borrower-loanlisting.apply_filter') }}			
					</button>
				</div>	
			</div>	
		</div>
	</form>
	<div class="row">
		
		<div class="col-lg-12 col-md-12 borrower-admin">
			<div class="panel panel-primary panel-container">
				
					<div class="panel-heading panel-headsection">
						<div class="row">
						   <div class="col-xs-3">
								<span class="pull-left">{{ Lang::get('Borrowers List') }}</span> 
							</div>									
						</div>                           
					</div>				
					<div class="table-responsive">
						<table class="table tab-fontsize">
							<thead>
								<tr>
									<th class="tab-head">																			
										<label><input type="checkbox" value="Select All"></label>											
									</th>
									<th class="tab-head">{{ Lang::get('Email Id') }}</th>
									<th class="tab-head">{{ Lang::get('Business Name') }}</th>
									<th class="tab-head">{{ Lang::get('Contact Person') }}</th>
									<th class="tab-head">{{ Lang::get('Industry') }}</th>
									<th class="tab-head text-right">{{ Lang::get('Number of Active Loans') }}</th>
									<th class="tab-head text-right">{{ Lang::get('Total Balance Outstanding') }}</th>
									<th class="tab-head">{{ Lang::get('Status') }}</th>
									<th class="tab-head">{{ Lang::get('Actions') }}</th>									
								</tr>
							</thead>
							<tbody>	
									@foreach($adminBorModel as $BorRow)
										@var	$borProUrl	=	url('admin/borrower/profile/')
										@var	$borProUrl	=	$borProUrl."/".base64_encode($BorRow['borrower_id'])
										<tr>
											<td>
												<div class="checkbox">
													<label><input type="checkbox" value=""></label>
												</div>
											</td>
											<td>
												@if(($BorRow['status']	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL)
																|| ($BorRow['status']	==	BORROWER_STATUS_VERIFIED))
													<a href="{{$borProUrl}}">
														{{$BorRow['email']}}
													</a>
												@else
													{{$BorRow['email']}}
												@endif
											</td>
											<td>
												@if(($BorRow['status']	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL)
																|| ($BorRow['status']	==	BORROWER_STATUS_VERIFIED))
													<a href="{{$borProUrl}}">
														{{$BorRow['business_name']}}
													</a>
												@else
													{{$BorRow['business_name']}}
												@endif
											</td>
											<td>
												@if(($BorRow['status']	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL)
																|| ($BorRow['status']	==	BORROWER_STATUS_VERIFIED))
												<a href="{{$borProUrl}}">
													{{$BorRow['contact_person']}}
												</a>
												@else
													{{$BorRow['contact_person']}}
												@endif
											</td>
											<td>
												@if(($BorRow['status']	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL)
																|| ($BorRow['status']	==	BORROWER_STATUS_VERIFIED))
													<a href="{{$borProUrl}}">
														{{$BorRow['industry']}}
													</a>
												@else
													{{$BorRow['industry']}}
												@endif
											</td>
											<td class="text-right">
												@if(($BorRow['status']	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL)
																|| ($BorRow['status']	==	BORROWER_STATUS_VERIFIED))
													<a href="{{$borProUrl}}">
														{{$BorRow['active_loan']}}
													</a>
												@else
													{{$BorRow['active_loan']}}
												@endif
											</td>
											<td class="text-right">
												@if(($BorRow['status']	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL)
																|| ($BorRow['status']	==	BORROWER_STATUS_VERIFIED))
													<a href="{{$borProUrl}}">
														{{$BorRow['tot_bal_outstanding']}}
													</a>
												@else
													{{$BorRow['tot_bal_outstanding']}}
												@endif
											</td>
											<td>
												@if(($BorRow['status']	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL)
																|| ($BorRow['status']	==	BORROWER_STATUS_VERIFIED))
													<a href="{{$borProUrl}}">
														{{$BorRow['status']}}
													</a>
												@else
													{{$BorRow['status']}}
												@endif
											</td>
											<td>
												<ul class="list-unstyled">
													<li class="dropdown">
														<a class="dropdown-toggle" data-toggle="dropdown" href="#">
															<i class="fa fa-edit fa-fw"></i> 
														</a>
														<ul class="dropdown-menu dropdown-user">
															<li>
																<a href="#">
																	<i class="fa fa-user fa-fw"></i>
																	{{ Lang::get('Approve') }}
																</a>
															</li>  
															<li>
																<a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Reject') }}</a>
															</li>
															<li><a href="#"><i class="fa fa-user fa-fw"></i>{{ Lang::get('Delete') }}</a>
															</li>
														</ul>	
													</li>
												</ul>											
											</td>										
										</tr>	
									@endforeach
							</tbody>
						</table>						
					</div><!-----third row end--->	
					
					
					
		
			</div>     
			<div class="row">
					<div class="col-sm-12">
						
						
								<button type="submit" 
									class="btn verification-button"	>
									<i class="fa pull-right"></i>
									{{ Lang::get('Approve')}}
								</button>
							<button type="submit" 
									class="btn verification-button"	>
									<i class="fa pull-right"></i>
									{{ Lang::get('Reject')}}
								</button>
								<button type="submit" 
									class="btn verification-button"	>
									<i class="fa pull-right"></i>
									{{ Lang::get('Delete')}}
								</button>
						</div>
										
					</div>		
		</div>
		</div>
	</div>
</div>


@endsection  
@stop
