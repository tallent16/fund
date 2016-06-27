@section ('popup-box_panel_title',Lang::get('Welcome to Fund Yourself Now'))
	@section ('popup-box_panel_body')
		@include('widgets.modal_box.welcome_message', ['message' => session('welcome_message')])
	@endsection
	@include('widgets.modal_box.panel', array(	'id'=>'welcome_message',
												'aria_labelledby'=>'welcome_message',
												'as'=>'popup-box',
												'class'=>'',
											))
