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
@section('page_heading',Lang::get('Audit Trail') )
@section('section')  
<div class="col-sm-12 space-around">

	<div class="row">	
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group controls">							
				<label>
					<strong>{{ Lang::get('From Date')}}</strong>
				</label><br>
				<div class="input-group">						
					<input id="fromdate" name="fromdate" value="{{$adminAuditTrailMod->fromDate}}" 
							type="text" class="date-picker form-control" />
							<label class="input-group-addon btn" for="fromdate">
								<span class="glyphicon glyphicon-calendar"></span>
							</label>
				</div>
			</div>	
		</div>

		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group controls">							
				<label>
					<strong>{{ Lang::get('To Date')}}</strong>
				</label><br>
				<div class="input-group">						
					<input id="todate" name="todate" value="{{$adminAuditTrailMod->toDate}}" 
							type="text" class="date-picker form-control" />
							<label class="input-group-addon btn" for="todate">
								<span class="glyphicon glyphicon-calendar"></span>
							</label>
				</div>
			</div>	
		</div>
		
		<div class="col-sm-6 col-lg-3"> 
			<label>
				<strong>{{ Lang::get('Modules')}}</strong>
			</label>
			<div class="form-group">
				{{ 
					Form::select('module_list', 
								$adminAuditTrailMod->modlist, 
								$adminAuditTrailMod->filtermodule,
								["class" => "selectpicker","id" => "modulelist"
								]) 
					}} 
			</div>
		</div>	
		<div class="col-sm-6 col-lg-3"> 
			<label>
				<strong>{{ Lang::get('Actions')}}</strong>
			</label>
			<div class="form-group">
				 <select id="action_list" class="selectpicker" name="action_list">
    		    	<option></option>
				</select>
			</div>
		</div>
		<div class="col-sm-12 col-lg-12 text-right" >
			<input type="submit" value="Apply Filter" id="applyfilter" class="btn verification-button">
		</div>	
		<div>&nbsp;</div>
	</div>
	
	<div class="table-responsive">
		<table class="table table-striped text-left" id="adminaudit">
			<thead>
				<tr>					
					<th class="tab-head text-left">{{ Lang::get('Date') }}</th>
					<th class="tab-head text-left">{{ Lang::get('UserName') }}</th>
					<th class="tab-head text-left">{{ Lang::get('Module') }}</th>
					<th class="tab-head text-left">{{ Lang::get('Action') }}</th>					
					<th class="tab-head text-left">{{ Lang::get('Key Field') }}</th>
					<th class="tab-head text-left">{{ Lang::get('Key Value') }}</th>
					<th class="tab-head"></th>
				</tr>
			</thead>				
			<tbody>
			</tbody>
		</table>
	</div>	
</div>

<input type="hidden" name="_token" id="hidden_token" value="{{ csrf_token() }}">	
@section ('popup-box_panel_title',Lang::get('Audit Trail Info'))
@section ('popup-box_panel_body')	
@endsection
@include('widgets.modal_box.panel', array(	'id'=>'audit_info',
											'aria_labelledby'=>'audit_info',
											'as'=>'popup-box',
											'class'=>'',
										))
@stop
@section('bottomscripts')										
<script>var baseUrl	="{{url('')}}"</script>
<script src="{{ asset('assets/scripts/frontend.js') }}" type="text/javascript"></script>
<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
<script src="{{ url('js/audit-trail.js') }}" type="text/javascript"></script>
{{ Html::script('js/datatable/jquery.dataTables.min.js') }}
{{ Html::script('js/datatable/dataTables.tableTools.min.js') }}
{{ Html::script('js/datatable/dataTables.editor.js') }}	
{{ Html::script('js/customdatatable/adminaudittrail.js') }}
{{ Html::script('js/fake-select.js') }}
@endsection 
