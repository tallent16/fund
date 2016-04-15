@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url("js/admin-manage-borrower.js") }}" type="text/javascript"></script>
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
						<form method="post" id="form-manage-borrower" action="{{url('admin/borrower/updateprofile')}}">
							<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="processType" id="processType" value="">
							<input 	type="hidden" 
									id="default_approve_applicable" 
									value="{{BORROWER_STATUS_SUBMITTED_FOR_APPROVAL}}">
							<input 	type="hidden" 
									id="default_reject_applicable" 
									value="{{BORROWER_STATUS_NEW_PROFILE}},{{BORROWER_STATUS_SUBMITTED_FOR_APPROVAL}}">
							
							<table class="table tab-fontsize text-left">
								<thead>
									<tr>
										<th class="tab-head">																			
											<label>
												<input type="checkbox" id="select_all_list" value="Select All">
											</label>											
										</th>
										<th class="tab-head text-left">{{ Lang::get('Email Id') }}</th>
										<th class="tab-head text-left">{{ Lang::get('Business Name') }}</th>
										<th class="tab-head text-left">{{ Lang::get('Industry') }}</th>
										<th class="tab-head text-right">{{ Lang::get('Number of Active Loans') }}</th>
										<th class="tab-head text-right">{{ Lang::get('Total Balance Outstanding') }}</th>
										<th class="tab-head text-left">{{ Lang::get('Status') }}</th>
										<th class="tab-head text-left">{{ Lang::get('Actions') }}</th>									
									</tr>
								</thead>
								<tbody>	
										@foreach($adminBorModel as $BorRow)
											@var	$borProUrl	=	url('admin/borrower/profile/')
											@var	$borProUrl	=	$borProUrl."/".base64_encode($BorRow['borrower_id'])
											<tr>
												<td>
													<div class="checkbox">
														<label>
															<input 	type="checkbox" 
																	name="borrower_ids[]"
																	class="select_borrower_id"
																	data-status="{{$BorRow['status']}}"
																	data-email="{{$BorRow['email']}}"
																	data-active-loan="{{$BorRow['active_loan']}}"
																	value="{{$BorRow['borrower_id']}}">
														</label>
													</div>
												</td>
												<td>
													<a href="{{$borProUrl}}">
														{{$BorRow['email']}}
													</a>
												</td>
												<td>
													<a href="{{$borProUrl}}">
														{{$BorRow['business_name']}}
													</a>
												</td>
												<td>
													<a href="{{$borProUrl}}">
														{{$BorRow['industry']}}
													</a>
												</td>
												<td class="text-right">
													<a href="{{$borProUrl}}">
														{{$BorRow['active_loan']}}
													</a>
												</td>
												<td class="text-right">
													<a href="{{$borProUrl}}">
														{{$BorRow['tot_bal_outstanding']}}
													</a>
												</td>
												<td>
													<a href="{{$borProUrl}}">
														{{$BorRow['statusText']}}
													</a>
												</td>
												<td>
													@var	$encode_bor_id	=	base64_encode($BorRow['borrower_id']);
													@if($BorRow['status']	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL)
														@var	$approveClass	=	""
														@var	$approveUrl		=	url('admin/borrower/updateprofile/approve/')
														@var	$approveUrl		=	$approveUrl."/".$encode_bor_id
													@else
														@var	$approveClass	=	"disable-indication disabled"
														@var	$approveUrl		=	"javascript:void(0);"
													@endif
													@if(($BorRow['status']	==	BORROWER_STATUS_NEW_PROFILE)
														|| ($BorRow['status']	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL))
														@var	$rejectClass	=	""
														@var	$rejectUrl		=	url('admin/borrower/updateprofile/reject/')
														@var	$rejectUrl		=	$rejectUrl."/".$encode_bor_id
													@else
														@var	$rejectClass	=	"disable-indication disabled"
														@var	$rejectUrl		=	"javascript:void(0);"
													@endif
													@if($BorRow['active_loan'] == 0)
														@var	$deleteClass	=	""
														@var	$deleteUrl		=	url('admin/borrower/updateprofile/delete/')
														@var	$deleteUrl		=	$deleteUrl."/".$encode_bor_id
													@else
														@var	$deleteClass	=	"disable-indication disabled"
														@var	$deleteUrl		=	"javascript:void(0);"
													@endif
													<ul class="list-unstyled">
														<li class="dropdown">
															<a class="dropdown-toggle" 
																data-toggle="dropdown" href="#">
																<i class="fa fa-edit fa-fw"></i> 
															</a>
															<ul class="dropdown-menu dropdown-user">
																<li>
																	
																	<a href="{{$approveUrl}}" class="{{$approveClass}}">
																		<i class="fa fa-user fa-fw"></i>
																		{{ Lang::get('Approve') }}
																	</a>
																</li>  
																<li>	
																	<a href="{{$rejectUrl}}"   class="{{$rejectClass}}">
																		<i class="fa fa-user fa-fw"></i>
																		{{ Lang::get('Reject') }}
																	</a>
																</li>
																<li>
																	<a href="{{$deleteUrl}}"  class="{{$deleteClass}}">
																		<i class="fa fa-user fa-fw"></i>
																		{{ Lang::get('Delete') }}
																	</a>
																</li>
															</ul>	
														</li>
													</ul>											
												</td>										
											</tr>	
										@endforeach
								</tbody>
							</table>			
						</form>			
					</div><!-----third row end--->	
					
					
					
		
			</div>     
			<div class="row">
					<div class="col-sm-12">
						
						
								<button type="button"
										id="bulk_approve_button"
										class="btn verification-button"	>
										<i class="fa pull-right"></i>
										{{ Lang::get('Approve')}}
								</button>
							<button type="button" 
									id="bulk_reject_button"
									class="btn verification-button"	>
									<i class="fa pull-right"></i>
									{{ Lang::get('Reject')}}
								</button>
								<button type="button"
										id="bulk_delete_button"
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
