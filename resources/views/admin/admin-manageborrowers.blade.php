@extends('layouts.dashboard')
@section('styles')
	{{ Html::style('css/datatable/jquery.dataTables.css') }}
	{{ Html::style('css/datatable/dataTables.tableTools.css') }}
	{{ Html::style('css/datatable/dataTables.editor.css') }}		
	<style>
		table.dataTable thead th, table.dataTable thead td {
			padding: 10px;
			border-bottom:none;
			font-size:12px;
		}
		table.dataTable thead > th {
			color: #fff;			
			text-decoration:none;
		}		
		table.dataTable tr{
			background-color:#333;
			color:#fff;
		}
		.dataTable td a{
			color:#333;
			text-decoration:none;		
		}		
		table.dataTable.no-footer{
			border:none;
		}
	</style>
@stop
@section('page_heading',Lang::get('Manage Borrowers') )
@section('section')  
@var	$adminBorModel	=	$adminbormodel->borrowerListInfo

@var	$approveborrower	=	"no"
@var	$rejectborrower		=	"no"
@var	$deleteborrower		=	"no"

@permission('approve.admin.manageborrowers')
	@var	$approveborrower =	"yes"
@endpermission
@permission('reject.admin.manageborrowers')
	@var	$rejectborrower =	"yes"
@endpermission
@permission('delete.admin.manageborrowers')
	@var	$deleteborrower	=	"yes"
@endpermission

<div class="col-sm-12 space-around">	
	
	<div class="row">
		<form action="" method="get">
			<div class="col-sm-6 col-lg-3">	
				<div class="form-group">			
					<strong>{{ Lang::get('Borrower Status') }}</strong>							
					{{ 
						Form::select('borrowerstatus_filter',$adminbormodel->filterBorrowerStatusList, 
										$adminbormodel->filterBorrowerStatusValue,
										[	"class" => "selectpicker",
											"id"=>"borrowerstatus_filter",
											"filter_field" => "Yes"])  
					}} 		
				</div>		
			</div>
			<div class="col-sm-6 col-lg-3 space-around">			
				<button id="filter_status" type="button" class="btn verification-button">
					{{ Lang::get('borrower-loanlisting.apply_filter') }}			
				</button>				
			</div>	
		</form>
	</div>	

				<!-----datatable starts---->

				<form method="post" id="form-manage-borrower" action="{{url('admin/borrower/updateprofile')}}">
					<div class="row">		
						<div class="col-lg-12 col-md-12">
							<div class="table-responsive">
								<table class="table table-striped" id="adminborrower">
									<thead>
										<tr>
											<th>														
												<label>
													<input type="checkbox" id="select_all_list" value="Select All">
												</label>											
											</th>
											<th>{{ Lang::get('Reg No') }}</th>
											<th>{{ Lang::get('Business Name') }}</th>
											<th>{{ Lang::get('Industry') }}</th>
											<th>{{ Lang::get('Email Id') }}</th>										
											<th>{{ Lang::get('Mobile No') }}</th>											
											<th>{{ Lang::get('Active Loans') }}</th>
											<th>{{ Lang::get('Total Balance Outstanding') }}</th>
											<th>{{ Lang::get('Status') }}</th>
											<th>{{ Lang::get('Actions') }}</th>
											<th>{{ Lang::get('Hidden Staus') }}</th>
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
							<input id="approveborrower" type="hidden" value="{{$approveborrower}}">
							<input id="rejectborrower"  type="hidden" value="{{$rejectborrower}}">
							<input id="deleteborrower"  type="hidden" value="{{$deleteborrower}}">
						</div>
					</div>
				</form>	

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
	<script>var baseUrl	=	"{{url('')}}"	
	$('.table-responsive').on('show.bs.dropdown', function () {
	 $('.table-responsive').css( "overflow", "inherit" );
	});

	$('.table-responsive').on('hide.bs.dropdown', function () {
	 $('.table-responsive').css( "overflow", "auto" );
	})
	</script>
	<script src="{{ url("js/admin-manage-borrower.js") }}" type="text/javascript"></script>
	
	{{ Html::script('js/datatable/jquery.dataTables.min.js') }}
	{{ Html::script('js/datatable/dataTables.tableTools.min.js') }}
	{{ Html::script('js/datatable/dataTables.editor.js') }}
	{{ Html::script('js/bootstrap-datetimepicker.js') }}
	{{ Html::script('js/customdatatable/adminborrower.js') }}
	
@endsection
