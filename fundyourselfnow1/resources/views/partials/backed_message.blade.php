@section ('popupnew-box_panel_title',Lang::get('Update Message'))
	@section ('popupnew-box_panel_body')
		<div class='row'>
			<div class='col-sm-12'>
				<div class='col-sm-12'>
					{{$message}}
				</div>
			</div>
		</div>

	@endsection
	@section ('popupnew-box_panel_footer')
	<div class='row'>
		<div class='col-sm-12'>
			<div class='col-sm-6 text-left'>
				
			</div>
			<div class='col-sm-4'></div>
			<div class='col-sm-2 text-right'>
				<input 	type='button' 
						class='form-control btn verification-button' 
						name='backed_message_dismiss' 
						id='backed_message_dismiss' 
						data-dismiss="modal"
						value='Close' 
			</div>
		</div>
	</div>
	@endsection
	@include('widgets.modal_box.panel', array(	'id'=>'backed_message',
												'aria_labelledby'=>'backed_message',
												'as'=>'popupnew-box',
												'class'=>'',
												'footerExists'=>'yes'
											))
