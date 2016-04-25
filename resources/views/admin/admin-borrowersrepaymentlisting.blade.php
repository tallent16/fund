@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>	
	@endsection
@section('page_heading',Lang::get('Borrowers Repayment') )
@section('section')  
<div class="col-sm-12 space-around">
	
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">	
						<button class="btn verification-button">
							{{ Lang::get('Approve Selected')}}
						</button>
					</div>
				</div>
			</div>
			
			<div class="panel panel-primary panel-container borrower-admin">						
					
				<div class="table-responsive">
					<table class="table tab-fontsize text-left">
						<thead>
							<tr>
								<th class="tab-head text-center col-sm-1">									
										<label>
											<input 	type="checkbox" 
													name="id"
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
								<th class="tab-head text-left col-sm-1">
									{{Lang::get('Actions')}}</th>
							</tr>
						</thead>
						<tbody>
							@var $repayloanlist = $adminBorRepayListMod->repaymentLoanList;
							@if (count($repayloanlist) > 0)
								@foreach ($repayloanlist as $loanRow)
									@var	$repSchUrl	=	url('admin/borrowersrepayview/')
									@var	$repSchUrl	=	$repSchUrl."/".base64_encode($loanRow->installment_number)
									@var	$repSchUrl	=	$repSchUrl."/".base64_encode($loanRow->loan_id)
									@if($loanRow->repayment_status	==	"Not Approved")
										@var	$encodeId	=	$loanRow->loan_id."_"
										@var	$encodeId	=	$encodeId.$loanRow->installment_number
										@var	$apprUrl	=	url('admin/borrowersrepayupdatestatus/')
										@var	$apprUrl	=	$apprUrl."/".base64_encode($encodeId)
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
															value="">
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
												{{$loanRow->schd_amount}}
											</a>
										</td>
										<td class="text-right">
											<a href="{{$repSchUrl}}">
												{{$loanRow->penalty}}
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
															<a href="{{$repSchUrl}}" class="{{$classrepaySch}}">
																<i class="fa fa-user fa-fw"></i>
																{{ Lang::get('Edit/Approve') }}
															</a>
														</li> 
														<li>													
															<a href="">
																<i class="fa fa-user fa-fw"></i>
																{{ Lang::get('View') }}
															</a>
														</li> 
														<li>													
															<a href="" class="{{$class}}">
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
			</div>	<!--panel-->

</div>
	@endsection  
@stop
