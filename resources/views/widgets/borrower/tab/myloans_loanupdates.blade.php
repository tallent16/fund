@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
	@var	$url	=	url('admin/manageprojects/project-updates')."/". base64_encode($LoanDetMod->loan_id)
@else
	@var	$url	=	url('creator/myprojects/project-updates')."/". base64_encode($LoanDetMod->loan_id)
@endif
<form 	id="form-project-updates"
		action ="{{$url}}"
		method="POST"
		novalidate="novalidate">
		<input type="hidden" name="_token" id="hidden_token" value="{{ csrf_token() }}">
		<input type="hidden" name="loan_update_id" id="loan_update_id" value="{{$LoanDetMod->loan_update_id}}">
	<div class="panel panel-primary panel-container">		
		<div class="panel-body">
			<div class="col-md-12">	
				<textarea id="project_updates" name="project_updates" required="true"
				>{{$LoanDetMod->update_description}}</textarea>
			</div>
			<div 	class="col-md-6" 
					id="updates_error_info"  style="display:none;margin-bottom:10px;">		
					<label 	class="error"
							id="updates_error_label"
							>{{ Lang::get('Please enter the Project Updates')}}</label>											
			</div>																					 
			<div class="col-md-12">	
				<button  class="btn verification-button" type="submit">
					<i class="fa pull-right"></i>
					Submit Updates
				</button>
			</div>
		</div>
	</div>
</form>
