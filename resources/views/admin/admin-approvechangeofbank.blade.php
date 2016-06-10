@extends('layouts.dashboard')
@section('bottomscripts')	
	
	
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
	<script>
		var baseUrl	=	"{{url('')}}"
		$(document).ready(function(){ 	
			$(".jfilestyle").jfilestyle({buttonText: "Upload",buttonBefore: true,inputSize: '110px'});  // file upload  
		}); 
	</script>
	<script src="{{ url('js/jquery-filestyle.min.js') }}" type="text/javascript"></script>	
@endsection
@section('page_heading',Lang::get('Approve Change of Bank Requests'))
@section('section')  
<div class="col-sm-12 space-around">
	<div class="panel-primary panel-container">
		
		<div class="panel-heading panel-headsection"><!--panel head-->
			<div class="row">
				<div class="col-sm-12">
					<span class="pull-left">{{ Lang::get('Bank Requests')}}</span> 
				</div>
			</div>					
		</div><!--panel head end-->

		<div class="panel-body applyloan table-border-custom input-space">	
			
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
							value="" 
							placeholder=""
							/>	
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
							value="" 
							placeholder=""
							/>	
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
							value="" 
							placeholder=""
							/>	
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
							value="" 
							placeholder=""
							/>	
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
							value="" 
							placeholder=""
							/>
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
							value="" 
							placeholder=""
							/>
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
								/>	
				</div>							
			</div> <!-- Row 4-->
			<!-- button-->
			<div class="row">
				<div class="col-lg-12 space-around">
					<div class="form-group">
						<button class="btn verification-button"
									id="save_button"											
									 >
							 {{ Lang::get('Approve')}}
						</button>
						<button class="btn verification-button"
									id="reject_button"											
									 >
							 {{ Lang::get('Reject')}}
						</button>
					</div>					
				</div>
			</div>
			<!-- button-->
			
		</div>	
		
	</div>
</div>	
	@endsection  
@stop
