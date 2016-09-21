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
			<div class="form-group" id="actiondropdown">
				{{ 
					Form::select('action_list', 
								$adminAuditTrailMod->actionlist, 
								$adminAuditTrailMod->actionmodule,
								["class" => "selectpicker",
								]) 
					}}
			</div>
		</div>
		<div class="col-sm-12 col-lg-12 text-right" >
			<input type="submit" value="Apply Filter" id="applyfilter" class="btn verification-button">
		</div>	
		<div>&nbsp;</div>
		</form>
	</div>
	
	<div class="table-responsive applyloan " id="transhistory-container"> 
		<table class="table tab-fontsize text-left ">
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
				@foreach($adminAuditTrailMod->header_rs as $row)
				<tr id="{{ $row->audit_key}}" role="row" class="tablesrow">
						<td>{{ $row->action_datetime}}</td>
						<td>{{ $row->username}}</td>
						<td>{{ $row->module_name}}</td>
						<td>{{ $row->action_summary}}</td>						
						<td>{{ $row->key_displayfieldname}}</td>
						<td>{{ $row->key_displayfieldvalue}}</td>
						<td class="details-control"><input type="hidden" id="module_name" name="module_name" value="{{ $row->module_name}}"></td>
				</tr>
				<tr id="tran_row_{{ $row->audit_key}}" style="display:none;">	
					<td colspan="7">
						<div class="table-responsive" id="audit-trail">
							<table class="table text-left">
								<tr class="" style="background-color:none;">	
									<td class="module_list" id="{{ $row->audit_key}}"></td>	
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
 @section ('popup-box_panel_title',Lang::get('Audit Trail Info'))
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
	 $("tr.tablesrow:odd").css("background-color", "rgb(225, 225, 225)");
	
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
	    
    $('.module_list').on('click', 'li', function () {
		//~ var str1 	= $(this).html();
		var str1 	= $(this).find('input').val();
		var str2	= $(this).closest("td").attr("id");
		
		 $.ajax({ 
            type        : 'GET', 								// define the type of HTTP verb we want to use (POST for our form)
            url         : baseUrl+"/admin/audit_trial/"+str1+"/"+str2, 	// the url where we want to POST          
            dataType    : 'json',
            async: false,
           
        }) // using the done promise callback
		.done(function(data) {  						
			showAuditPopupFunc(data);
		}).	fail(function (data){
					
		});			
	});
	
	$(".details-control").on('click',function(){
		
		var a= $(this).closest('tr').attr('id');
		$(this).parent().siblings('tr.shown').removeClass("shown");
		
		var b = '#tran_row_'+a;		
		$("tr:not('"+b+"')").siblings('[id^="tran_row_"]').hide();
		$(b).show();
		
		var modulename = $(this).find('input').val();		     
		var ret = modulename.split(" ");
		var str1 = ret[0];	
		var str2 = ret[1];	
		if(str1 == 'Loans'){
			str2 = 'Info';			
		}
			
		$.ajax({ 
            type        : 'GET', 				// define the type of HTTP verb we want to use (POST for our form)
            url         : baseUrl+"/admin/audit_trial/module/"+str1+"/"+str2, 	// the url where we want to POST           
            dataType    : 'json',
            async		: false,
        }) // using the done promise callback
		.done(function(data) {				
			showTablesList(data);
		}); 
	});	
	
	$("#modulelist").change(function() {	
				
		$.ajax({
			type: "POST",
			url: baseUrl+"/admin/audit_trial/optionfilter",
			data: {module_list: $(this).find(":selected").text()},			                  
			dataType    : 'json'
		})
		.done(function(data) {				
			showdropdown(data);
		});
	});
	$("#modulelist").trigger("change");
	
	
	
}); 

function showdropdown(data){
	var	str = 	"";	
	str		=	str+"<select name='action_list' id='action_list' class='selectpicker form-control'> ";
	//~ str		=	str+"	<div class='btn-group bootstrap-select'>";
	//~ str = str + "<button class='btn dropdown-toggle btn-default ' type='button' id='action_list' data-toggle='dropdown' aria-expanded='true'>";
	//~ str = str +" <span data-bind='label'>Select One</span><span class='caret'></span>";
   //~ str = str + " </button>";
   //~ str = str +" <select class='dropdown-menu' name='action_list' role='menu'> ";
	$.each(data.rows, function(value, key) {
		
		str		=	str+"<option value='"+value.toString()+"' >"+key+" ";
		//~ str = str +" <li>"+key+"</li>";
	
	});
	//~ str = str +  " </ul></div>";
	str		=	str+"</select>";
	$('#actiondropdown').html(str);
	$("#action_list").val("{{$adminAuditTrailMod->actionListValue}}");
}

function showTablesList(data){
	var	str = 	"";	
	str		=	str+"<ul style='list-style-type:none;'>";
	
		$.each( data.rows, function(key,val) {
			str	=	str+"<li id='mod_id' style='cursor:pointer;' >";
			str	=	str+"<span class='fa fa-check-square'></span>"+" "+val+"\n";	
			str	=	str+"<input type ='hidden' value="+ key+">\n";	
			str	=	str+"</li></br>";		
		});
		str	=	str+"</ul>";
		$('.module_list').html(str);
	
}

function showAuditPopupFunc(data){
	var	str 		= 	"";
	var	afterRow	=	data.rows.rowAfter;
	str				=	"<div class='table-responsive'><table class='table text-left' id='popup_table'>";
	str				=	str+"<thead><tr style='background-color:#222;color:#fff'><th class='text-left col-sm-4'>Columns</th><th class='text-left col-sm-4'>Before</th>";	
	str				=	str+"<th class='text-left col-sm-4'>After</th></tr></thead>";
	str				=	str+"<tbody>";	

	if(data.rows.rowBefore != null){		
		$.each( data.rows.rowBefore, function(key1,val1) {					
				str =	str +"<tr><td>";					
				str	=	str+key1;
				str =	str +"</td>";	
				str = 	str +"<td class='before'>";	
				if(afterRow[key1])		{		
					str	= 	str+afterRow[key1];
				}
				str = 	str +"</td>";
				str = 	str +"<td class='after'>";				
				str	= 	str+val1;
				str = 	str +"</td></tr>";
		});				
	}
	else{		
		str =	str +"<tr class='text-center'><td colspan='3'>No Records Found</td></tr>";
	}
	str		=	str+"</tbody></table></div>";
	$("#audit_info .modal-body").html(str);
	$("#audit_info").modal("show");
}
/**********************************************************************/
</script> 
	@endsection  
@stop
