@if(Auth::user()->usertype	==	USER_TYPE_ADMIN)
	@var	$url	=	url('admin/manageprojects/project-updates')."/". base64_encode($LoanDetMod->loan_id)
@else
	@var	$url	=	url('creator/myprojects/project-updates')."/". base64_encode($LoanDetMod->loan_id)
@endif

	<div class="panel panel-primary panel-container">	
		<div class="panel-body">
		<div class="col-md-12 updates_btnbox">	
				<button class="btn  pull-right verification-button" id="Add_Update" onclick="add_update();" style="margin-bottom: 20px">
					<i class="fa pull-right"></i>
					Add Update
				</button>
				<button  class="btn  pull-right verification-button" id="View_Update" onclick="view_update();" style="display: none">
					<i class="fa pull-right"></i>
					View Updates
				</button>
		</div>
		@if(@$updateDetailArray)
		
		<div class="col-md-12 updates_detail">	
			<ul>
			@foreach($updateDetailArray as $val)
				<li>
					<div id="updateDescription{{$val->loan_update_id}}">{{$val->update_description}}</div>
					<div class="btns_edit_delete">	
						<button  class="btn btn-success" onclick="edit_update({{$val->loan_update_id}});">
							<i class="fa fa-edit" aria-hidden="true"></i>
						</button>
						<button  class="btn btn-danger" onclick="delete_update({{$val->loan_update_id}},{{$val->loan_id}});">
							<i class="fa fa-trash-o" aria-hidden="true"></i>
						</button>
					</div>
				</li>
				@endforeach
			</ul>
		</div>

		<div class="col-md-12" id="editupdates" style="display: none">
			<form action="{{url('creator/edit_update')}}" method="post" novalidate="novalidate">
				<input type="hidden" value="{{$val->loan_id}}" name="loanId">
				<input type="hidden" value="" name="loanUpdateId" id="loanUpdateId">
				<textarea class="project_updates" name="project_updates" required="true"
				></textarea>
				<input  class="btn verification-button" type="submit" value="Save">
			</form>
		</div>
		<div id="add_update_form" style="display: none">
			<form id="form-project-updates" action ="{{url('creator/add_update')}}" method="POST" novalidate="novalidate">
				<input type="hidden" name="loan_id" value="{{$LoanDetMod->loan_id}}">
				<div class="col-md-12">	
				<textarea class="project_updates" name="project_updates" required="true"
				></textarea>
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
			</form>
		</div>
		@else
			<form id="form-project-updates" action ="{{$url}}" method="POST" novalidate="novalidate">
				<input type="hidden" name="_token" id="hidden_token" value="{{ csrf_token() }}">
				<input type="hidden" name="loan_update_id" id="loan_update_id" value="{{$LoanDetMod->loan_update_id}}">
				<div class="col-md-12">	
				<textarea class="project_updates" name="project_updates" required="true"
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
			</form>
		@endif
		</div>
	</div>

