@section ('popup-box_panel_title',Lang::get('Welcome to Fund Yourself Now'))
	@section ('popup-box_panel_body')
		@include('widgets.modal_box.welcome_message', ['message' => session('welcome_message')])
	@endsection
	@section ('popup-box_panel_footer')
	<div class='row'>
		<div class='col-sm-12'>
			<div class='col-sm-6 text-left'>
				<input 	type='checkbox' 
						name='show_welcome_message' 
						id='show_welcome_message' 
						value='1' > Show this everytime I login
			</div>
			<div class='col-sm-4'></div>
			<div class='col-sm-2 text-right'>
				<input 	type='button' 
						class='form-control btn verification-button' 
						name='welcome_message_dismiss' 
						id='welcome_message_dismiss' 
						value='Dismiss' 
						data-dismiss='modal'>
				<input 	type='hidden' 
						id='welcome_message_url' 
						value="{{url('update/show_welcome/popup')}}" 
						>
				<input 	type='hidden' 
						id='welcome_message_userId' 
						value="{{Auth::user()->user_id}}" 
						>
				<input type="hidden" id="hidden_token" name="_token" value="{{ csrf_token() }}" />
						
			</div>
		</div>
	</div>
	@endsection
	@include('widgets.modal_box.panel', array(	'id'=>'welcome_message',
												'aria_labelledby'=>'welcome_message',
												'as'=>'popup-box',
												'class'=>'',
												'footerExists'=>'yes'
											))
