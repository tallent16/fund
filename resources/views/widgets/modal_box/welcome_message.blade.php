<div class='row'>
	<div class='col-sm-12'>
		<div class='col-sm-12'>
			{{$message}}
		</div>
	</div>
</div>
<div class='row space-around'>
	<div class='col-sm-12'>
		<div class='col-sm-6'>
			<input 	type='checkbox' 
					name='show_welcome_message' 
					id='show_welcome_message' 
					value='1' >Show this everytime I login
		</div>
		<div class='col-sm-4'></div>
		<div class='col-sm-2 text-right'>
			<input 	type='button' 
					class='form-control btn btn-primary' 
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
