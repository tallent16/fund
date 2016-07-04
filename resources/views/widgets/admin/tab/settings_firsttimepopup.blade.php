<div id="firsttimepopup" class="tab-pane fade in">
	<div class="panel panel-default applyloan">   
		<div class="panel-body">
			<div class="col-sm-12">
				@foreach($settings_list as $row)
				<div class="row">
					<div class="col-sm-3">
						{{Lang::get('Borrower First Time Popup')}}
					</div>
					<div class="col-sm-4">
						<textarea rows="5" class="form-control" name="bor_popup" id="bor_popup">{{$row->firsttime_borrower_popup}}</textarea>
					</div>
					<div class="col-sm-3 pull-bottom">
						<button class="btn verification-button" type="button" onclick="previewBorFirsttimePopup()">Preview</button>
					</div>
					@section ('borfirstpopup-box_panel_title',Lang::get('Borrower First Time Popup'))
					@section ('borfirstpopup-box_panel_body')

					@endsection
					@section ('borfirstpopup-box_panel_footer')
							<button type="button" class="btn btn-default itrack-modal-close" data-dismiss="modal">
									Close
								</button>
					@endsection
					@include('widgets.modal_box.panel', array(	'id'=>'borFirstPopup',
																'aria_labelledby'=>'borFirstPopup',
																'as'=>'borfirstpopup-box',
																'class'=>'',
																'footerExists'=>'yes'
														))
													
					<div id="borFirstPopup"></div>
				</div>	
				
				<div class="row">
					<div class="col-sm-3">
						{{Lang::get('Investor First Time Popup')}}
					</div>
					<div class="col-sm-4">
						<textarea rows="5" class="form-control" name="inv_popup" id="inv_popup">{{$row->firsttime_investor_popup}}</textarea>
					</div>
					<div class="col-sm-3 pull-bottom">
						<button class="btn verification-button" type="button" onclick="previewInvFirsttimePopup()">Preview</button>
					</div>
					@section ('invfirstpopup-box_panel_title',Lang::get('Investor First Time Popup'))
					@section ('invfirstpopup-box_panel_body')

					@endsection
					@section ('invfirstpopup-box_panel_footer')
						<button type="button" class="btn btn-default itrack-modal-close" data-dismiss="modal">
							Close
						</button>
					@endsection
					@include('widgets.modal_box.panel', array(	'id'=>'invFirstPopup',
																'aria_labelledby'=>'invFirstPopup',
																'as'=>'invfirstpopup-box',
																'class'=>'',
																'footerExists'=>'yes'
														))
													
					<div id="invFirstPopup"></div>
				</div>	
				@endforeach	
			</div>
		</div>	
	</div>
</div>	
