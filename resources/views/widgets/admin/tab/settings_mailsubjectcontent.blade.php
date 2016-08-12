<div id="mail_subjectcontent" class="tab-pane fade">
	<div class="panel panel-default applyloan">   
		<div class="panel-body">
			<div class="col-sm-12">
				
				<div class="row">
					<div class="col-sm-1">
						<label>Module</label>
					</div>
					<div class="col-sm-3">
						{{ Form::select('modulelist', $adminsettingModel->moduleList, '$adminsettingModel->defaultmoduleval', ["class" => "selectpicker",
							"id" => "type",
							"filter_field" => "Yes"]) }} 
					</div>
				</div>
				
				<div>&nbsp;</div>
			
				<div id="module_table"></div>
			
				<div class="row">
				@section ('popup-box_panel_title',Lang::get('Edit Messages'))
				@section ('popup-box_panel_body')

				@endsection
				@include('widgets.modal_box.panel', array(	'id'=>'module_popup',
															'aria_labelledby'=>'module_popup',
															'as'=>'popup-box',
															'class'=>'',
													))
													
				<div id="module_popup"></div>
				</div>
				<div class="row">
				@section ('email-popup-box_panel_title',Lang::get('Edit Email Contents'))
				@section ('email-popup-box_panel_body')

				@endsection
				@include('widgets.modal_box.panel', array(	'id'=>'email_popup',
															'aria_labelledby'=>'email_popup',
															'as'=>'email-popup-box',
															'class'=>'',
														))	
				<div id="email_popup"></div>	
				</div>			
		</div>
	</div>
</div>
</div>
