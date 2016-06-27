<div id="general" class="tab-pane fade in active">
	<div class="panel panel-default applyloan">   
		<div class="panel-body">
			<div class="col-sm-12">
				@foreach($settings_list as $row)
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Application Name')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="application_name"												
								id="application_name"
								value="{{$row->application_name}}">										
					</div>
				</div>		
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Mail From Address')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="mail_from_address"												
								id="mail_from_address"
								value="{{$row->admin_email}}">										
					</div>
				</div>		
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Mail From Name')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="mail_from_name"												
								id="mail_from_name"
								value="{{$row->admin_email_label}}">										
					</div>
				</div>		
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Backend Team Mail Address')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="backend_team_mailaddress"												
								id="backend_team_mailaddress"
								value="{{$row->backend_email}}">										
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Backend Team Mail Name')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="backend_team_mailname"												
								id="backend_team_mailname"
								value="{{$row->backend_email_label}}">										
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Mail CC\'s To')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="mail_cc"												
								id="mail_cc"
								value="{{$row->mail_cc_to}}">										
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Send Live Mails')}}
					</div>
					<div class="col-sm-4">						
						{{ Form::checkbox('livemails', 1, $row->send_live_mails) }}
						<br>					
					</div>
				</div>	
				@endforeach	
			</div>
			
		</div>
	</div>
</div>
