@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('Audit Trail') )
@section('section')  
<div class="col-sm-12 space-around">
	<form >
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
				<strong>{{ Lang::get('Actions')}}</strong>
			</label>
			<div class="form-group">
				{{ 
					Form::select('action_list', 
								$adminAuditTrailMod->actionlist, 
								$adminAuditTrailMod->actionmodule,
								["class" => "selectpicker",
								]) 
					}}
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
								["class" => "selectpicker",
								]) 
					}} 
			</div>
		</div>	
		<div class="col-sm-12 col-lg-12 text-right" >
			<input type="submit" value="Apply Filter" class="btn verification-button">
		</div>	
		<div>&nbsp;</div>
		</form>
	</div>
	
	<div class="table-responsive applyloan " id="transhistory-container"> 
		<table class="table tab-fontsize text-left">
			<thead>
				<tr>					
					<th class="tab-head text-left">{{ Lang::get('Date') }}</th>
					<th class="tab-head text-left">{{ Lang::get('Module') }}</th>
					<th class="tab-head text-left">{{ Lang::get('Action') }}</th>
					<th class="tab-head text-left">{{ Lang::get('UserName') }}</th>
					<th class="tab-head text-left">{{ Lang::get('Key Field') }}</th>
					<th class="tab-head text-left">{{ Lang::get('Key Value') }}</th>
					<th class="tab-head"></th>
				</tr>
			</thead>				
			<tbody>
				@foreach($adminAuditTrailMod->header_rs as $row)
				<tr id="{{ $row->audit_key}}" role="row">
						<td>{{ $row->action_datetime}}</td>
						<td>{{ $row->module_name}}</td>
						<td>{{ $row->action_summary}}</td>
						<td>{{ $row->action_datetime}}</td>
						<td>{{ $row->key_displayfieldname}}</td>
						<td>{{ $row->key_displayfieldvalue}}</td>
						<td class="details-control"><input type="hidden" id="module_name" name="module_name" value="{{ $row->module_name}}"></td>
				</tr>
				<tr id="tran_row_{{ $row->audit_key}}" style="display:none;">	
					<td colspan="7">	
						<div class="table-responsive" id="audit-trail">
							<table class="table text-left">
								<tr>	
									<td class="module_list"><a href="javascript:void(0);" id="audit-popup">Link</a></td>		
								</tr>									
							</table>
						</div>						
					</td>				
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>	
	
	
</div>

<input type="hidden" name="_token" id="hidden_token" value="{{ csrf_token() }}">	
 @section ('popup-box_panel_title',Lang::get('Audit Trail'))
	@section ('popup-box_panel_body')
		
	@endsection
	@include('widgets.modal_box.panel', array(	'id'=>'audit_info',
												'aria_labelledby'=>'audit_info',
												'as'=>'popup-box',
												'class'=>'',
											))
											
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>    
<script>
$(document).ready(function(){ 	
	// date picker
	$('#fromdate').datetimepicker({
	autoclose: true, 
	minView: 2,
	format: 'dd/mm/yyyy' 
	}); 
	
	$('#todate').datetimepicker({
	autoclose: true, 
	minView: 2,
	format: 'dd/mm/yyyy' 
	});         
	
	// Add event listener for opening and closing transcation details
	$(".details-control").click(function() {
		var loan_id = $(this).parent().attr("id");		
		if($(this).parent().hasClass("shown")){
			$("#"+loan_id).removeClass("shown");
			$("#tran_row_"+loan_id).hide();
		}
		else{
			$("#"+loan_id).addClass("shown");
			$("#tran_row_"+loan_id).show();				
		}
	});
	/******************************Popup Function**********************/
	var baseUrl	=	"{{url('')}}"
	 $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
	});
	
    $("#audit-popup").on('click',function(){
		
		 $.ajax({ 
            type        : 'GET', 						// define the type of HTTP verb we want to use (POST for our form)
            url         : baseUrl+'', 	// the url where we want to POST
            data        : 'name',
            dataType    : 'json'
        }) // using the done promise callback
		.done(function() {  
			showAuditPopupFunc(data);
		}); 
	});
	
	$(".details-control").on('click',function(){
		var modulename = $(this).find('input').val();
		modulename = modulename.toLowerCase();      
		var ret = modulename.split(" ");
		var str1 = ret[0];	
			
		$.ajax({ 
            type        : 'GET', 								// define the type of HTTP verb we want to use (POST for our form)
            url         : baseUrl+"/admin/audit_trial/"+str1, 	// the url where we want to POST
            data        : {TABLE_NAME:''},
            dataType    : 'json'
        }) // using the done promise callback
		.done(function(data) {			
			showTablesList(data);
		}); 
	});
	
}); 

function showTablesList(data){
	var	str = 	"";
	str		=	"<table class='table table-bordered .tab-fontsize text-left'>";
	str		=	str+"<thead><tr>";
	if(data.rows.length > 0){
		$.each( data.rows, function( key ) {
			str	=	str+"<td>";
			str	=	str+data.rows[key].TABLE_NAME+"</td>";
			str	=	str+"<td>";			
			str	=	str+"</tr>";
		});
		str	=	str+"</tbody></table>";
		$('.module_list').html(str);
	}
}



//~ $('.details-control').on('click', function(e) {
    //~ var modulename = $(this).find('input').val();
    //~ modulename = modulename.toLowerCase();      
    //~ var ret = modulename.split(" ");
	//~ var str1 = ret[0];
	//~ var baseUrl	=	"{{url('')}}"
    //~ window.location.href = baseUrl + "/admin/audit_trial/"+str1;
//~ });


function showAuditPopupFunc(data){
	var	str;
	str		=	"<div class='table-responsive'><table class='table text-left'>";
	str		=	str+"<thead><tr><th class='text-left'>Col1</th>";	
	str		=	str+"<th class='text-right'>Col2</th></thead>";
	str		=	str+"<tbody><tr><td>test data</td></tr>";
	str		=	str+"</tbody></table></div>";
	$("#audit_info .modal-body").html(str);
	$("#audit_info").modal("show");
}
/**********************************************************************/
</script> 
	@endsection  
@stop
