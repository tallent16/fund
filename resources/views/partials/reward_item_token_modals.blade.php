<!--Reward Token Popup Block -->
@section ('popup-box-one_panel_title',Lang::get('Create New Reward Token'))
	@section ('popup-box-one_panel_body')
		@include('widgets.modal_box.reward_token')
	@endsection
	@section ('popup-box-one_panel_footer')
	<div class='row'>
		<div class='col-sm-12'>
			<div class='col-sm-6 text-left'>
				&nbsp;&nbsp;
			</div>
			<div class='col-sm-2'></div>
			<div class='col-sm-2 text-right'>
				<input 	type='button' 
						class='form-control btn verification-button' 
						id='rwd_save' 
						value='Save' 
						onclick="updateRewardTokenRow()"
						>
			</div>
			<div class='col-sm-2 text-right'>
				<input 	type='button' 
						class='form-control btn verification-button' 
						value='Dismiss' 
						data-dismiss='modal'>
				<input 	type='hidden' 
						id='rwd_mod_id' 
						value="" 
						>
				<input 	type='hidden' 
						id='rwd_mod_type' 
						value="" 
						>
			</div>
		</div>
	</div>
	@endsection
	@include('widgets.modal_box.panel', array(	'id'=>'reward_token_popup',
												'aria_labelledby'=>'reward_token_popup',
												'as'=>'popup-box-one',
												'class'=>'',
												'footerExists'=>'yes'
											))

<!--Item Token Popup Block -->
@section ('popup-box_panel_title',Lang::get('Create New Item Token'))
	@section ('popup-box_panel_body')
		@include('widgets.modal_box.item_token')
	@endsection
	@section ('popup-box_panel_footer')
	<div class='row'>
		<div class='col-sm-12'>
			<div class='col-sm-6 text-left'>
				&nbsp;&nbsp;
			</div>
			<div class='col-sm-2'></div>
			<div class='col-sm-2'>
				<input 	type='button' 
						class='form-control btn verification-button' 
						id='item_save' 
						value='Save' 
						onclick="updateItemTokenRow()"
						>
			</div>
			<div class='col-sm-2 text-right'>
				<input 	type='button' 
						class='form-control btn verification-button' 
						value='Dismiss' 
						data-dismiss='modal'>
				<input 	type='hidden' 
						id='item_mod_id' 
						value="" 
						>
				<input 	type='hidden' 
						id='item_mod_type' 
						value="" 
						>
			</div>
		</div>
	</div>
	@endsection
	@include('widgets.modal_box.panel', array(	'id'=>'item_token_popup',
												'aria_labelledby'=>'item_token_popup',
												'as'=>'popup-box',
												'class'=>'',
												'footerExists'=>'yes'
											))


<!--Warning Token Popup Block -->
@section ('warning-popup-box_panel_title',Lang::get('Changing Item Type'))
	@section ('warning-popup-box_panel_body')
		<h3>
		Do you want to change type. It will loss the entered token details
		</h3>
	@endsection
	@section ('warning-popup-box_panel_footer')
	<div class='row'>
		<div class='col-sm-12'>
			<div class='col-sm-6 text-left'>
				&nbsp;&nbsp;
			</div>
			<div class='col-sm-2'></div>
			<div class='col-sm-2'>
				<input 	type='button' 
						class='form-control btn verification-button' 
						value='Yes' 
						onclick="delTokenRows()"
						>
			</div>
			<div class='col-sm-2 text-right'>
				<input 	type='button' 
						class='form-control btn verification-button' 
						value='No' 
						onclick="remainSameToken()"
						>
			
				<input 	type='hidden' 
						id='warning_item_type' 
						value="" 
						>
			</div>
		</div>
	</div>
	@endsection
	@include('widgets.modal_box.panel', array(	'id'=>'warning_token_popup',
												'aria_labelledby'=>'warning_token_popup',
												'as'=>'warning-popup-box',
												'class'=>'',
												'footerExists'=>'yes'
											))

