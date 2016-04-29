@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url("js/admin-manage-investor.js") }}" type="text/javascript"></script>
	@endsection
@section('page_heading',Lang::get('Manage Investor') )
@section('section')  
@var	$adminInvModel	=	$admininvModel->investorListInfo
<div class="col-sm-12 space-around">
	<form action="" method="get">
		<div class="row">	
			<div class="col-sm-12 col-lg-3"> 														
				<div class="form-group"><br>	
					<strong>{{ Lang::get('Investor Status') }}</strong>							
					{{ 
						Form::select('investorstatus_filter',$admininvModel->filterInvestorStatusList, 
										$admininvModel->filterInvestorStatusValue,
										["class" => "selectpicker"]) 
					}} 
				</div>
			</div>
			<div class="col-sm-12 col-lg-3"> 														
				<div class="form-group"><br><br>			
					<button type="submit" class="btn verification-button">
						{{ Lang::get('Apply Filter') }}			
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
								<span class="pull-left">{{ Lang::get('Investors List') }}</span> 
							</div>									
						</div>                           
					</div>				

					<div class="table-responsive">
						<form method="post" id="form-manage-investor" action="{{url('admin/investor/updateprofile')}}">
							<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
							<input type="hidden" name="processType" id="processType" value="">
							<input 	type="hidden" 
									id="default_approve_applicable" 
									value="{{INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL}}">
							<input 	type="hidden" 
									id="default_reject_applicable" 
									value="{{INVESTOR_STATUS_NEW_PROFILE}},{{INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL}}">
							
							<table class="table tab-fontsize text-left">
								<thead>
									<tr>
										<th class="tab-head text-center col-sm-1">																			
											<label>
												<input type="checkbox" id="select_all_list" value="Select All">
											</label>											
										</th>
										<th class="tab-head text-left col-sm-2">{{ Lang::get('Email Id') }}</th>
										<th class="tab-head text-left col-sm-2">{{ Lang::get('Name') }}</th>
										<th class="tab-head text-left col-sm-2">{{ Lang::get('Mobile Number') }}</th>
										<th class="tab-head text-right col-sm-1">{{ Lang::get('Active Loans') }}</th>
										<th class="tab-head text-right col-sm-2">{{ Lang::get('Available Balance') }}</th>
										<th class="tab-head text-left col-sm-1">{{ Lang::get('Status') }}</th>
										<th class="tab-head text-left col-sm-1">{{ Lang::get('Actions') }}</th>									
									</tr>
								</thead>
								<tbody>	
										@foreach($adminInvModel as $InvRow)
											@var	$invProUrl	=	url('admin/investor/profile/')
											@var	$invProUrl	=	$invProUrl."/".base64_encode($InvRow['investor_id'])
											<tr>
												<td class="text-center">													
														<label>
															<input 	type="checkbox" 
																	name="investor_ids[]"
																	class="select_investor_id"
																	data-status="{{$InvRow['status']}}"
																	data-email="{{$InvRow['email']}}"
																	data-active-loan="{{$InvRow['active_loan']}}"
																	value="{{$InvRow['investor_id']}}">
														</label>													
												</td>
												<td>
													<a href="{{$invProUrl}}">
														{{$InvRow['email']}}
													</a>
												</td>
												<td>
													<a href="{{$invProUrl}}">
														{{$InvRow['display_name']}}
													</a>
												</td>
												<td>
													<a href="{{$invProUrl}}">
														{{$InvRow['mobile_number']}}
													</a>
												</td>
												<td class="text-right">
													<a href="{{$invProUrl}}">
														{{$InvRow['active_loan']}}
													</a>
												</td>
												<td class="text-right">
													<a href="{{$invProUrl}}">
														{{$InvRow['available_balance']}}
													</a>
												</td>
												<td>
													<a href="{{$invProUrl}}">
														{{$InvRow['statusText']}}
													</a>
												</td>
												<td class="text-center">
													@var	$encode_inv_id	=	base64_encode($InvRow['investor_id']);
													@if($InvRow['status']	==	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL)
														@var	$approveClass	=	""
														@var	$approveUrl		=	url('admin/investor/updateprofile/approve/')
														@var	$approveUrl		=	$approveUrl."/".$encode_inv_id
													@else
														@var	$approveClass	=	"disable-indication disabled"
														@var	$approveUrl		=	"javascript:void(0);"
													@endif
													@if(($InvRow['status']	==	INVESTOR_STATUS_NEW_PROFILE)
														|| ($InvRow['status']	==	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL))
														@var	$rejectClass	=	""
														@var	$rejectUrl		=	url('admin/investor/updateprofile/reject/')
														@var	$rejectUrl		=	$rejectUrl."/".$encode_inv_id
													@else
														@var	$rejectClass	=	"disable-indication disabled"
														@var	$rejectUrl		=	"javascript:void(0);"
													@endif
													@if($InvRow['active_loan'] == 0)
														@var	$deleteClass	=	""
														@var	$deleteUrl		=	url('admin/investor/updateprofile/delete/')
														@var	$deleteUrl		=	$deleteUrl."/".$encode_inv_id
													@else
														@var	$deleteClass	=	"disable-indication disabled"
														@var	$deleteUrl		=	"javascript:void(0);"
													@endif
													<ul class="list-unstyled">
														<li class="dropdown">
															<a class="dropdown-toggle" 
																data-toggle="dropdown" href="#">
																<i class="fa fa-caret-down fa-fw action-style"></i> 
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
