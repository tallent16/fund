@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script>var baseUrl	=	"{{url('')}}"</script>
	<script src="{{ url("js/admin-manage-investor.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('Manage Investor') )
@section('section')  
@var	$adminInvModel	=	$admininvModel->investorListInfo
<div class="col-sm-12 space-around">
	
	<div class="row">	
		<form action="" method="get">
			<div class="col-sm-12 col-lg-3"> 														
				<div class="form-group">
					<strong>{{ Lang::get('Investor Status') }}</strong>							
					{{ 
						Form::select('investorstatus_filter',$admininvModel->filterInvestorStatusList, 
										$admininvModel->filterInvestorStatusValue,
										["class" => "selectpicker"]) 
					}} 
				</div>	
			</div>
			<div class="col-sm-12 col-lg-3"><br>
				<div class="form-group">		
					<button type="submit" class="btn verification-button">
						{{ Lang::get('Apply Filter') }}			
					</button>	
				</div>				
			</div>	
		</form>
	</div><!-------- First row--------------->
	
	<div class="row">		
		<div class="col-lg-12 col-md-12 borrower-admin">
			<div class="panel panel-primary panel-container">				

					<div class="panel-heading panel-headsection">
						<div class="row">
						   <div class="col-xs-6">
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
										<th class="tab-head text-center">																			
											<label>
												<input type="checkbox" id="select_all_list" value="Select All">
											</label>											
										</th>
										<th class="tab-head text-left">{{ Lang::get('Email Id') }}</th>
										<th class="tab-head text-left">{{ Lang::get('Name') }}</th>
										<th class="tab-head text-left">{{ Lang::get('Mobile No') }}</th>
										<th class="tab-head text-right">{{ Lang::get('Active Loans') }}</th>
										<th class="tab-head text-right">{{ Lang::get('Available Balance') }}</th>
										<th class="tab-head text-left">{{ Lang::get('Status') }}</th>
										<th class="tab-head text-left">{{ Lang::get('Actions') }}</th>									
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
														{{number_format($InvRow['available_balance'],2,'.',',')}}
													</a>
												</td>
												<td>
													<a href="{{$invProUrl}}">
														{{$InvRow['statusText']}}
													</a>
												</td>
												<td class="text-center">
													@var	$encode_inv_id	=	base64_encode($InvRow['investor_id']);
													@var	$appClass	=	"disable-indication disabled"
													@var	$appUrl		=	"javascript:void(0);"
													@var	$rejClass	=	"disable-indication disabled"
													@var	$rejUrl		=	"javascript:void(0);"
													@var	$delClass	=	"disable-indication disabled"
													@var	$delUrl		=	"javascript:void(0);"
													@if($InvRow['status']	==	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL)
														@permission('approve.admin.manageinvestors')
															@var	$appClass	=	""
															@var	$appUrl		=	url('admin/manageinvestors/approve/')
															@var	$appUrl		=	$appUrl."/".$encode_inv_id
														@endpermission
													@endif
													@if(($InvRow['status']	==	INVESTOR_STATUS_NEW_PROFILE)
														|| ($InvRow['status']	==	INVESTOR_STATUS_SUBMITTED_FOR_APPROVAL))
														@permission('reject.admin.manageinvestors')
															@var	$rejClass	=	""
															@var	$rejUrl		=	url('admin/manageinvestors/reject/')
															@var	$rejUrl		=	$rejUrl."/".$encode_inv_id
														@endpermission
													@endif
													@if($InvRow['active_loan'] == 0)
														@permission('delete.admin.manageinvestors')
															@var	$delClass	=	""
															@var	$delUrl		=	url('admin/manageinvestors/delete/')
															@var	$delUrl		=	$delUrl."/".$encode_inv_id
														@endpermission
													@endif
													<ul class="list-unstyled">
														<li class="dropdown">
															<a class="dropdown-toggle" 
																data-toggle="dropdown" href="#">
																<i class="fa fa-caret-down fa-fw action-style"></i> 
															</a>
															<ul class="dropdown-menu dropdown-user">
																<li>
																	
																	<a href="{{$appUrl}}" class="{{$appClass}}">
																		<i class="fa fa-user fa-fw"></i>
																		{{ Lang::get('Approve') }}
																	</a>
																</li>  
																<li>	
																	<a href="{{$rejUrl}}"   class="{{$rejClass}}">
																		<i class="fa fa-user fa-fw"></i>
																		{{ Lang::get('Reject') }}
																	</a>
																</li>
																<li>
																	<a href="{{$delUrl}}"  class="{{$delClass}}">
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
					</div><!-----table responsive--->
				</div> <!-----panel container--->
				<div class="row">
					<div class="col-sm-12">						
						@permission('approve.admin.manageinvestors')					
							<button type="button"
									id="bulk_approve_button"
									class="btn verification-button"	>
									<i class="fa pull-right"></i>
									{{ Lang::get('Approve')}}
							</button>
						@endpermission
						@permission('reject.admin.manageinvestors')
							<button type="button" 
								id="bulk_reject_button"
								class="btn verification-button"	>
								<i class="fa pull-right"></i>
								{{ Lang::get('Reject')}}
							</button>
						@endpermission
						@permission('delete.admin.manageinvestors')
							<button type="button"
									id="bulk_delete_button"
									class="btn verification-button"	>
									<i class="fa pull-right"></i>
									{{ Lang::get('Delete')}}
							</button>
						@endpermission
					</div>										
				</div>	<!--------Button row--------------->				
			
		</div><!-------- col--------------->
	</div> <!-------- Second row--------------->
	
</div><!-------- col--------------->
@endsection  
@stop
