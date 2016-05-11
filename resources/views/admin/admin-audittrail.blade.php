@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('Audit Trail') )
@section('section')  
<div class="col-sm-12 space-around">
	
	<div class="row">	
		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group controls">							
				<strong>
					{{ Lang::get('From Date')}}
				</strong><br>
				<div class="input-group">						
					<input id="fromdate" name="fromdate" value="" 
							type="text" class="date-picker form-control" />
							<label class="input-group-addon btn" for="fromdate">
								<span class="glyphicon glyphicon-calendar"></span>
							</label>
				</div>
			</div>	
		</div>

		<div class="col-sm-6 col-lg-3"> 														
			<div class="form-group controls">							
				<strong>
					{{ Lang::get('To Date')}}
				</strong><br>
				<div class="input-group">						
					<input id="todate" name="todate" value="" 
							type="text" class="date-picker form-control" />
							<label class="input-group-addon btn" for="todate">
								<span class="glyphicon glyphicon-calendar"></span>
							</label>
				</div>
			</div>	
		</div>
		
		<div class="col-sm-6 col-lg-3"> 
			<label><strong>
				Actions
			</label></strong>
			<div class="form-group">
				<select name="actions" class="selectpicker">
					<option value="Insert">Insert</option>
					<option value="Update">Update</option>
					<option value="delete">delete</option>
					<option value="All">All</option>
				</select>
			</div>
		</div>
		
		<div class="col-sm-6 col-lg-3"> 
			<label><strong>
				Modules
			</label></strong>
			<div class="form-group">
				<select name="actions" class="selectpicker">
					<option value="Borrower">Borrower</option>
					<option value="Investor">Investor</option>
					<option value="Loans">Loans</option>
					<option value="System">System</option>
					<option value="All">All</option>
				</select>
			</div>
		</div>		
		
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
				<tr id="12" role="row">
						<td>25-05-2016</td>
						<td>Borrower-Sign Up</td>
						<td>Add</td>
						<td>XXXXX</td>
						<td>Borrower Name</td>
						<td>borrower@example.com</td>
						<td class="details-control"></td>
				</tr>
				<tr id="tran_row_12" style="display:none;">	
					<td colspan="7">	
						<div class="col-sm-1"></div>	
						<div class="col-sm-10 pull-right">	
							<div class="table-responsive" id="audit-trail">
								<table class="table text-left">
									<tr>		
										<td class=""></td>																	
										<td class="">Borrower-Sign Up</td>
										<td class="">Add</td>
										<td class="">XXXXX</td>
										<td class="">Borrower Name</td>
										<td class="">borrower@example.com</td>
										<td class=""><i class="fa fa-exclamation-circle"></i></td>		
									</tr>
									<tr>		
										<td class=""></td>																	
										<td class="">Borrower-Sign Up</td>
										<td class="">Add</td>
										<td class="">XXXXX</td>
										<td class="">Borrower Name</td>
										<td class="">borrower@example.com</td>
										<td class=""><i class="fa fa-exclamation-circle"></i></td>	
									</tr>
								</table>
							</div>
						</div>
					</td>				
				</tr>
				<tr id="13" role="row">
						<td>25-05-2016</td>
						<td>Borrower-Sign Up</td>
						<td>Add</td>
						<td>XXXXX</td>
						<td>Borrower Name</td>
						<td>borrower@example.com</td>
						<td class="details-control"></td>
				</tr>
				
				<tr id="tran_row_13" style="display:none;">	
					<td colspan="7">	
						<div class="col-sm-1"></div>	
						<div class="col-sm-10 pull-right">	
							<div class="table-responsive" id="audit-trail">
								<table class="table text-left">
									<tr>		
										<td class=""></td>																	
										<td class="">Borrower-Sign Up</td>
										<td class="">Add</td>
										<td class="">XXXXX</td>
										<td class="">Borrower Name</td>
										<td class="">borrower@example.com</td>
										<td class=""><i class="fa fa-exclamation-circle"></i></td>	
									</tr>
									<tr>		
										<td class=""></td>																	
										<td class="">Borrower-Sign Up</td>
										<td class="">Add</td>
										<td class="">XXXXX</td>
										<td class="">Borrower Name</td>
										<td class="">borrower@example.com</td>
										<td class=""><i class="fa fa-exclamation-circle"></i></td>		
									</tr>
								</table>
							</div>
						</div>
					</td>				
				</tr>
				
			</tbody>
		</table>
	</div>	
	
	
</div>
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
}); 
</script> 
	@endsection  
@stop
