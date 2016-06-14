<div id="mail_config" class="tab-pane fade">
	<div class="panel panel-default applyloan">   
		<div class="panel-body">
			<div class="col-sm-12">
				@foreach($settings_list as $row)
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Mail Driver')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="mail_driver"												
								id="mail_driver"
								value="{{$row->mail_driver}}">										
					</div>
				</div>		
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Mail Host')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="mail_host"												
								id="mail_host"
								value="{{$row->mail_host}}">										
					</div>
				</div>		
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Mail Port')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="mail_port"												
								id="mail_port"
								value="{{$row->mail_port}}">										
					</div>
				</div>		
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Mail Encryption')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="mail_encryption"												
								id="mail_encryption"
								value="{{$row->mail_encryption}}">										
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Mail UserName')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="mail_username"												
								id="mail_username"
								value="{{$row->mail_username}}">										
					</div>
				</div>	
				<div class="row">
					<div class="col-sm-3">
					{{Lang::get('Mail Password')}}
					</div>
					<div class="col-sm-4">
						<input type="text" class="form-control" 
								name="mail_password"												
								id="mail_password"
								value="{{$row->mail_password}}">											
					</div>
				</div>	
				@endforeach	
			</div>
			
		</div>
	</div>
</div>
