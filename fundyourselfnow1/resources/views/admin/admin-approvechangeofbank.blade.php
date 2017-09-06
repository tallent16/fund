@extends('layouts.dashboard_admin')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script>
		var baseUrl	=	"{{url('')}}"
		$(document).ready(function(){ 	
			$(".jfilestyle").jfilestyle({buttonText: "Upload",buttonBefore: true,inputSize: '110px'});  // file upload  
		}); 
		$('#reject_button').click(function (){
			$('#form-approvechangeofbank').attr('action',baseUrl+'/admin/approvechangeofbank/reject');
			$('#form-approvechangeofbank').submit();	
		});		
	</script>
	<script src="{{ url('js/jquery-filestyle.min.js') }}" type="text/javascript"></script>	
@endsection
@section('page_heading',Lang::get('Approve Change of Bank Requests'))
@section('section')  
<div class="col-sm-12 space-around">
	<div class="panel-primary panel-container borrower-admin">
		
		<div class="panel-heading panel-headsection"><!--panel head-->
			<div class="row">
				<div class="col-sm-12">
					<span class="pull-left">{{ Lang::get('Bank Requests')}}</span> 
				</div>
			</div>					
		</div><!--panel head end-->

		<div class="panel-body applyloan table-border-custom input-space">	
		<form method="post" id="form-approvechangeofbank" 
							action="{{url('admin/approvechangeofbank/approve')}}"
							>
			<input type="hidden" name="_token" 		id="_token" 	value="{{ csrf_token() }}">
			<input type="hidden" name="bor_id" 		id="bor_id"		value="{{$adminbankviewModel->borrower_id }}">
			<input type="hidden" name="bor_bankid" 	id="bor_bankid" value="{{$adminbankviewModel->borrower_bankid }}">
			<input type="hidden" name="inv_id" 		id="inv_id" 	value="{{$adminbankviewModel->investor_id }}">
			<input type="hidden" name="inv_bankid" 	id="inv_bankid" value="{{$adminbankviewModel->investor_bankid }}">
			<input type="hidden" name="usertype" 	id="usertype" 	value="{{$adminbankviewModel->user_type_name }}">
			<input type="hidden" name="bank_statement_url" 	id="bank_statement_url" 	value=			    "{{$adminbankviewModel->bank_statement_url}}">
			<div class="row"><!-- Row 1 -->					   
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('User Type')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-3">
						<input 	id="usertype" 
							type="text" 
							class="usertype form-control" 
							name="usertype"									
							value="{{$adminbankviewModel->user_type_name}}" 
							placeholder=""
							disabled />	
				</div>							
			</div> <!-- Row 1 -->
			
			<div class="row"><!-- Row 2 -->					
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Name')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-3">
					<input 	id="name" 
							type="text" 
							class="name form-control" 
							name="name"									
							value="{{$adminbankviewModel->name}}"  
							placeholder=""
							disabled />	
				</div>							
			</div> <!-- Row 2 -->
			
			<div class="row"><!-- Row 3-->					
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Bank Name')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-3">
					<input 	id="bankname" 
							type="text" 
							class="bankname form-control" 
							name="bankname"									
							value="{{$adminbankviewModel->bank_name}}" 
							placeholder=""
							disabled />	
				</div>
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Bank Code')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-3">
					<input 	id="bankcode" 
							type="text" 
							class="bankcode form-control" 
							name="bankcode"									
							value="{{$adminbankviewModel->bank_code}}" 
							placeholder=""
							disabled />	
				</div>							
			</div> <!-- Row 3-->
			
			<div class="row"><!-- Row 4-->					
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Branch Code')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-3">
					<input 	id="branchcode" 
							type="text" 
							class="branchcode form-control" 
							name="branchcode"									
							value="{{$adminbankviewModel->branch_code}}"
							placeholder=""
							disabled />
				</div>
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Account Number')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-3">
					<input 	id="acc_num" 
							type="text" 
							class="acc_num form-control" 
							name="acc_num"									
							value="{{$adminbankviewModel->bank_account_number}}" 
							placeholder=""
							disabled />
				</div>							
			</div> <!-- Row 4-->
			
			<div class="row"><!-- Row 4-->					
				<div class="col-xs-12 col-sm-5 col-lg-3">
					<label>
						{{ Lang::get('Account Proof Doc')}}
					</label>
				</div>								
				<div class="col-xs-12 col-sm-7 col-lg-3">
				<input 	type="file" 
								class="jfilestyle  required" 
								data-buttonBefore="true" 
								name="account_proof"
								id="account_proof"
								accept="image/*" 
								disabled 
								 />	
					
					@if($adminbankviewModel->bank_statement_url)
						<a  href='{{url($adminbankviewModel->bank_statement_url)}}'>							
							{{basename($adminbankviewModel->bank_statement_url)}}							
						</a>
					@endif
				</div>							
			</div> <!-- Row 4-->
			<!-- button-->
			<div class="row">
				<div class="col-lg-12 space-around">
					<div class="form-group">
						<button class="btn verification-button"
									id="save_button"	
									type="submit"										
									 >
							 {{ Lang::get('Approve')}}
						</button>
						<button class="btn verification-button"
									id="reject_button"
									type="button"																			
									 >
							 {{ Lang::get('Reject')}}
						</button>
					</div>					
				</div>
			</div>
			<!-- button-->
			
		</div>	
		</form>
	</div>
</div>	
	@endsection  
@stop
