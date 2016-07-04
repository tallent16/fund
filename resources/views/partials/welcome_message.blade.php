@section ('popup-box_panel_title',Lang::get('Welcome to Fund Yourself Now'))
	@section ('popup-box_panel_body')
		@include('widgets.modal_box.welcome_message', ['message' => session('welcome_message')])
	@endsection
	@section ('popup-box_panel_footer')
		<button type="button" class="btn btn-default itrack-modal-close" data-dismiss="modal">
			Close
		</button>
	@endsection
	@include('widgets.modal_box.panel', array(	'id'=>'welcome_message',
												'aria_labelledby'=>'welcome_message',
												'as'=>'popup-box',
												'class'=>'',
												'footerExists'=>'yes'
											))
