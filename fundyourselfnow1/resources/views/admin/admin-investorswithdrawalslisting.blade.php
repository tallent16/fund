@extends('layouts.dashboard_admin')
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
		table.dataTable thead > tr{
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

@section('page_heading',Lang::get('Investor Withdrawals') )
@section('section')  
<div class="col-sm-12 space-around">
	<form method="get">
	<div class="row">	
		
		<div class="col-sm-12 col-lg-3"> 														
			<div class="form-group">	
				<strong>{{ Lang::get('Filter Status')}}</strong><br>								
					{{ Form::select('filter_transcations', $adminInvWithDrawListMod->allTransList, 
								$adminInvWithDrawListMod->filter_status, 
								["class" => "selectpicker",
								"id" => "filter_transcations",
								"filter_field" => "Yes"])  
					}} 
			</div>	
		</div>
				
		<div class="col-sm-4 col-lg-3"> 														
			<div class="form-group">							
				<strong>{{ Lang::get('From Date') }}</strong><br>							
				<input id="fromdate" name="fromdate" value="{{$adminInvWithDrawListMod->fromDate}}" 
						type="text" filter_field="Yes" class="fromdate form-control" />
			</div>	
		</div>

		<div class="col-sm-4 col-lg-3"> 
			<div class="form-group">								
				<strong>{{ Lang::get('To Date') }}</strong><br>							
				<input id="todate" name="todate" value="{{$adminInvWithDrawListMod->toDate}}"
						type="text" filter_field="Yes" class="todate form-control" />
			</div>	
		</div>

		<div class="col-sm-4 col-lg-3"> 
			<div class="form-group space-around">
				<button type="button" class="btn verification-button" id="filter_status">
					{{ Lang::get('Apply Filter')}}
				</button>
			</div>
		</div>
		
	</div>
	</form>
	<div class="row">
		<div class="col-lg-12">
			<div class="form-group">	
				@permission('approve.admin.investorswithdrawal')
					<button class="btn verification-button"
							id="bulk_approve_button">
						{{ Lang::get('Approve Selected')}}
					</button>
				@endpermission
				@permission('unapprove.admin.investorswithdrawal')
					<button class="btn verification-button"
							id="bulk_unapprove_button">
						{{ Lang::get('UnApprove Selected')}}
					</button>
				@endpermission
				@var	$Url	=	url('admin/investorwithdrawalview/')
				@var	$addUrl	=	$Url."/add/0/0/"
				@permission('add.admin.investorswithdrawal')
					<button class="btn verification-button"
							data-url="{{$addUrl}}"
							id="new_button">
						{{ Lang::get('New Withdrawal')}}
					</button>
				@endpermission
				@permission('delete.admin.investorswithdrawal')
					<button class="btn verification-button"
							id="bulk_delete_button">
							{{ Lang::get('Delete Selected')}}
					</button>
				@endpermission
			</div>
		</div>
	</div>		
	<!-----datatable starts---->
	<form method="post" id="form-investor-listing" action="{{url('admin/investorwithdrawallist/bulkaction')}}">
		<div class="row">		
			<div class="col-lg-12 col-md-12">
				<div class="table-responsive">
					<table class="table table-striped" id="admininvwithdrawlisting">
						<thead>
							<tr>
								<th>														
									<label>
										<input type="checkbox" id="select_all_list" value="Select All">
									</label>											
								</th>
								<th>{{ Lang::get('Ref-No') }}</th>
								<th>{{ Lang::get('Name') }}</th>
								<th>{{ Lang::get('Email-ID') }}</th>
								<th>{{ Lang::get('Mobile No') }}</th>								
								<th>{{ Lang::get('Request Date') }}</th>
								<th>{{ Lang::get('Settlement Date') }}</th>								
								<th>{{ Lang::get('Amt') }}</th>
								<th>{{ Lang::get('Status') }}</th>
								<th>{{ Lang::get('Actions') }}</th>
								<th>{{ Lang::get('Hidden Status') }}</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
						
			<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="processType" id="processType" value="">				
			<input 	type="hidden" 
					name="default_verified_applicable" 
					id="default_verified_applicable" 
					value="{{INVESTOR_BANK_TRANS_STATUS_VERIFIED}}">				
			<input 	type="hidden" 
					name="default_unverified_applicable" 
					id="default_unverified_applicable" 
					value="{{INVESTOR_BANK_TRANS_STATUS_UNVERIFIED}}">	
			</div>
		</div>	
	</form>
	<!-----datatable ends---->
</div>
	@endsection  
@stop
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	<script>var baseUrl	=	"{{url('')}}"
	$('.table-responsive').on('show.bs.dropdown', function () {
	 $('.table-responsive').css( "overflow", "inherit" );
	});

	$('.table-responsive').on('hide.bs.dropdown', function () {
	 $('.table-responsive').css( "overflow", "auto" );
	})
	</script>
	<script src="{{ url("js/admin-investor-withdrawallisting.js") }}" type="text/javascript"></script>
	{{ Html::script('js/datatable/jquery.dataTables.min.js') }}
	{{ Html::script('js/datatable/dataTables.tableTools.min.js') }}
	{{ Html::script('js/datatable/dataTables.editor.js') }}	
	{{ Html::script('js/customdatatable/admininvwithdrawlisting.js') }}
@endsection
