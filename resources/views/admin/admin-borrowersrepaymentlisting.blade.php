@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>	
	<script src="{{ url("js/admin-borrower-repaylisting.js") }}" type="text/javascript"></script>	
@endsection
@section('page_heading',Lang::get('Borrowers Repayment') )
@section('section')  
<div class="col-sm-12 space-around">

	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">	
				<button class="btn verification-button"
						id="bulk_approve_button">
					{{ Lang::get('Approve Selected')}}
				</button>
			</div>
		</div>
	</div>
	
	<div class="panel panel-primary panel-container borrower-admin">						
		<form 	method="post" 
				action="{{url('admin/bulkapprove/borrowers/repayment')}}"
				id="form-borrower-repayment">
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
			
			<input 	type="hidden" 
					id="default_unverified_applicable" 
					value="{{BORROWER_REPAYMENT_STATUS_UNVERIFIED}}">
			<div class="table-responsive">
				<table class="table tab-fontsize text-left">
					<thead>
						<tr>
							<th class="tab-head text-center col-sm-1">									
									<label>
										<input 	type="checkbox" 
												id="select_all_list"
												class="select"											
												value="">
									</label>										
							</th>
							<th class="tab-head text-left col-sm-2">
								{{Lang::get('Loan Reference')}}</th>
							<th class="tab-head text-left col-sm-2">
								{{Lang::get('Scheduled Date')}}</th>
							<th class="tab-head text-left col-sm-2">
								{{Lang::get('Actual Date')}}</th>
							<th class="tab-head text-right col-sm-2">
								{{Lang::get('Installment Amount')}}</th>
							<th class="tab-head text-right col-sm-1">
								{{Lang::get('Penalty')}}</th>
							<th class="tab-head text-left col-sm-1">
								{{Lang::get('Status')}}</th>
							<th class="tab-head text-center col-sm-1">
								{{Lang::get('Actions')}}</th>
						</tr>
					</thead>
					<tbody>
						@var 	$repayloanlist 	= 	$adminBorRepayListMod->repaymentLoanList;
						@var	$type			=	""
						@if (count($repayloanlist) > 0)
							@foreach ($repayloanlist as $loanRow)
								@var	$SchUrl		=	url('admin/borrowersrepayview/')
								@var	$repSchUrl	=	$SchUrl."/edit/".base64_encode($loanRow->repayment_schedule_id)
								@var	$repSchUrl	=	$repSchUrl."/".base64_encode($loanRow->loan_id)
							
								@var	$repEditSchUrl	=	$SchUrl."/edit/".base64_encode($loanRow->repayment_schedule_id)
								@var	$repEditSchUrl	=	$repEditSchUrl."/".base64_encode($loanRow->loan_id)
								
								@var	$repViewSchUrl	=	$SchUrl."/view/".base64_encode($loanRow->repayment_schedule_id)
								@var	$repViewSchUrl	=	$repViewSchUrl."/".base64_encode($loanRow->loan_id)
								
								@if($loanRow->repayment_status	==	"Not Approved")
									
									@var	$apprUrl	=	url('admin/approve/borrower/repayment/')
									@var	$apprUrl	=	$apprUrl."/".$loanRow->repayment_schedule_id
									@var	$class		=	""
								@else
									@var	$apprUrl	=	"javascript:void(0);"
									@var	$class		=	"disable-indication disabled"
								@endif
								@if($loanRow->repayment_status	!=	"Approved")
									@var	$classrepaySch		=	""
								@else
									@var	$classrepaySch		=	"disable-indication disabled"
								@endif
								<tr>
									<td class="text-center">									
											<label>
												<input 	type="checkbox" 
														name="repayment_schedule[]"
														class="select_repayment"
														value="{{$loanRow->repayment_schedule_id}}"
														data-loan-ref="{{$loanRow->ref}}"
														data-schdDate="{{$loanRow->schd_date}}"
														data-status="{{$loanRow->dataStatus}}"
														data-penality="{{$loanRow->penalty}}"
														data-tran-ref="{{$loanRow->trans_reference_number}}">
											</label>									
									</td>
									<td>
										<a href="{{$repSchUrl}}">
											{{$loanRow->ref}}
										</a>
									</td>
									<td>
										<a href="{{$repSchUrl}}">
											{{$loanRow->schd_date}}
										</a>
									</td>
									<td>
										<a href="{{$repSchUrl}}">
											{{$loanRow->act_date}}
										</a>
									</td>
									<td class="text-right">
										<a href="{{$repSchUrl}}">
											{{number_format($loanRow->schd_amount,2,'.',',')}}
										</a>
									</td>
									<td class="text-right">
										<a href="{{$repSchUrl}}">
											{{number_format($loanRow->penalty,2,'.',',')}}
										</a>
									</td>
									<td>
										<a href="{{$repSchUrl}}">
											{{$loanRow->repayment_status}}
										</a>
									</td>
									<td class="text-center">
										<ul class="list-unstyled">
											<li class="dropdown">
												<a class="dropdown-toggle" 
													data-toggle="dropdown" href="#">
													<i class="fa fa-caret-down fa-fw action-style"></i> 
												</a>
												<ul class="dropdown-menu dropdown-user">
													<li>	
																										
														<a href="{{$repEditSchUrl}}" class="{{$classrepaySch}}">
															<i class="fa fa-user fa-fw"></i>
															{{ Lang::get('Edit/Approve') }}
														</a>
													</li> 
													<li>													
														<a href="{{$repViewSchUrl}}">
															<i class="fa fa-user fa-fw"></i>
															{{ Lang::get('View') }}
														</a>
													</li> 
													<li>													
														<a href="{{$apprUrl}}" 
															class="approveRepayment {{$class}}"
															data-tranf-no="{{$loanRow->trans_reference_number}}">
															<i class="fa fa-user fa-fw"></i>
															{{ Lang::get('Approve Selected') }}
														</a>
													</li> 
												</ul>
											</li>
										</ul>
									</td>
								</tr>
							@endforeach	
						@endif
					</tbody>
				</table>					
			</div>
		</form>
	</div>	<!--panel-->
</div>
	@endsection  
@stop
