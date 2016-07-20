@extends('layouts.dashboard')
@section('styles')

	{{ Html::style('css/datatable/jquery.dataTables.css') }}
	{{ Html::style('css/datatable/dataTables.tableTools.css') }}
	{{ Html::style('css/datatable/dataTables.editor.css') }}
		
	<style>
		table.dataTable thead th, table.dataTable thead td {
			padding: 10px;
	}
		table.dataTable thead th, table.dataTable tr td a.user_edit_master  {
			color: #333333;
	}
		table.dataTable thead th, table.dataTable tr td a.user_edit_master:hover  {
			text-decoration:none;
	}
	#ToolTables_user_0,#ToolTables_user_1 {
		visibility:hidden;
	}
	</style>
@stop

@section('page_heading',Lang::get('Manage Borrowers') )
@section('section')  
@var	$adminBorModel	=	$adminbormodel->borrowerListInfo
<div class="col-sm-12 space-around">	
	
	<div class="row">
		<form action="" method="get">
			<div class="col-sm-12 col-lg-3">	
				<div class="form-group">			
					<strong>{{ Lang::get('Borrower Status') }}</strong>							
					{{ 
						Form::select('borrowerstatus_filter',$adminbormodel->filterBorrowerStatusList, 
										$adminbormodel->filterBorrowerStatusValue,
										["class" => "selectpicker"]) 
					}} 		
				</div>		
			</div>
			<div class="col-sm-12 col-lg-3 space-around">			
				<button type="submit" class="btn verification-button">
					{{ Lang::get('borrower-loanlisting.apply_filter') }}			
				</button>				
			</div>	
		</form>
	</div><!-------- First row--------------->
	

<!--
	<div class="row">		
		<div class="col-lg-12 col-md-12 borrower-admin">
			<div class="panel panel-primary panel-container">
				
					<div class="panel-heading panel-headsection">
						<div class="row">
						   <div class="col-xs-6">
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
										<th class="tab-head text-center">																			
											<label>
												<input type="checkbox" id="select_all_list" value="Select All">
											</label>											
										</th>
										<th class="tab-head text-left">{{ Lang::get('Email Id') }}</th>
										<th class="tab-head text-left">{{ Lang::get('Business Name') }}</th>
										<th class="tab-head text-left">{{ Lang::get('Industry') }}</th>
										<th class="tab-head text-right">{{ Lang::get('Active Loans') }}</th>
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
												<td class="text-center">													
													<label>
														<input 	type="checkbox" 
																name="borrower_ids[]"
																class="select_borrower_id"
																data-status="{{$BorRow['status']}}"
																data-email="{{$BorRow['email']}}"
																data-active-loan="{{$BorRow['active_loan']}}"
																value="{{$BorRow['borrower_id']}}">
													</label>													
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
														{{number_format($BorRow['tot_bal_outstanding'],2,'.',',')}}
													</a>
												</td>
												<td>
													<a href="{{$borProUrl}}">
														{{$BorRow['statusText']}}
													</a>
												</td>
												<td class="text-center">
													@var	$encode_bor_id	=	base64_encode($BorRow['borrower_id']);
													@var	$enuser_id		=	base64_encode($BorRow['user_id']);
													@var	$appClass	=	"disable-indication disabled"
													@var	$appUrl		=	"javascript:void(0);"
													
													@var	$rejClass	=	"disable-indication disabled"
													@var	$rejUrl		=	"javascript:void(0);"
													
													@var	$delClass	=	"disable-indication disabled"
													@var	$delUrl		=	"javascript:void(0);"
													
													@if($BorRow['status']	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL)
														@permission('approve.admin.manageborrowers')
															@var	$appClass	=	""
															@var	$appUrl		=	url('admin/manageborrowers/approve/')
															@var	$appUrl		=	$appUrl."/".$encode_bor_id
														@endpermission
													@endif
													@if(($BorRow['status']	==	BORROWER_STATUS_NEW_PROFILE)
														|| ($BorRow['status']	==	BORROWER_STATUS_SUBMITTED_FOR_APPROVAL))
														@permission('reject.admin.manageborrowers')
															@var	$rejClass	=	"manageborrowers_reject"
															@var	$rejUrl		=	url('admin/manageborrowers/reject/')
															@var	$rejUrl		=	$rejUrl."/".$encode_bor_id
														@endpermission
													@endif
													@if($BorRow['active_loan'] == 0)
														@permission('delete.admin.manageborrowers')
															@var	$delClass	=	"manageborrowers_delete"
															@var	$delUrl		=	url('admin/manageborrowers/delete/')
															@var	$delUrl		=	$delUrl."/".$encode_bor_id
														@endpermission
													@endif
													@var	$changePasswordUrl	=	url('admin/changepassword')
													@var	$changePasswordUrl	=	$changePasswordUrl.'/'.$enuser_id
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
																<li>
																	<a href="{{$changePasswordUrl}}" >
																		<i class="fa fa-user fa-fw"></i>
																		{{ Lang::get('Change Password') }}
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
					</div>	<!-----table responsive---><!--
				</div> <!-----panel container--->
				
				<!-----datatable starts---->

				
					<div class="row">		
						<div class="col-lg-12 col-md-12">
							<div class="table-responsive">
								<table class="table table-bordered" id="adminborrower">
									<thead>
										<tr>
											<th>														
												<label>
													<input type="checkbox" id="select_all_list" value="Select All">
												</label>											
											</th>
											<th>{{ Lang::get('Email Id') }}</th>
											<th>{{ Lang::get('Business Name') }}</th>
											<th>{{ Lang::get('Industry') }}</th>
											<th>{{ Lang::get('Active Loans') }}</th>
											<th>{{ Lang::get('Total Balance Outstanding') }}</th>
											<th>{{ Lang::get('Status') }}</th>
<!--
											<th>{{ Lang::get('Actions') }}</th>
-->
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							<input id="hidden_token" name="_token" type="hidden" value="{{csrf_token()}}">	
							<input type="hidden" name="processType" id="processType" value="">
							<input 	type="hidden" 
									id="default_approve_applicable" 
									value="{{BORROWER_STATUS_SUBMITTED_FOR_APPROVAL}}">
							<input 	type="hidden" 
									id="default_reject_applicable" 
									value="{{BORROWER_STATUS_NEW_PROFILE}},{{BORROWER_STATUS_SUBMITTED_FOR_APPROVAL}}">
						</div>
					</div>
				

				<!-----datatable ends---->
				
				<div class="row">
					<div class="col-sm-12">		
						@permission('approve.admin.manageborrowers')					
							<button type="button"
									id="bulk_approve_button"
									class="btn verification-button"	>
									<i class="fa pull-right"></i>
									{{ Lang::get('Approve')}}
							</button>
						@endpermission
						@permission('reject.admin.manageborrowers')
							<button type="button" 
								id="bulk_reject_button"
								class="btn verification-button"	>
								<i class="fa pull-right"></i>
								{{ Lang::get('Reject')}}
							</button>
						@endpermission
						@permission('delete.admin.manageborrowers')
							<button type="button"
									id="bulk_delete_button"
									class="btn verification-button"	>
									<i class="fa pull-right"></i>
									{{ Lang::get('Delete')}}
							</button>
						@endpermission
					</div>										
				</div> <!--------Button row--------------->			
					
		</div><!-------- col--------------->
	</div> <!-------- Second row--------------->
	
</div><!-------- col--------------->
@endsection  
@stop
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script>var baseUrl	=	"{{url('')}}"</script>
	<script src="{{ url("js/admin-manage-borrower.js") }}" type="text/javascript"></script>
	
	{{ Html::script('js/datatable/jquery.dataTables.min.js') }}
	{{ Html::script('js/datatable/dataTables.tableTools.min.js') }}
	{{ Html::script('js/datatable/dataTables.editor.js') }}
	{{ Html::script('js/bootstrap-datetimepicker.js') }}
	{{ Html::script('js/customdatatable/adminborrower.js') }}
	
@endsection
