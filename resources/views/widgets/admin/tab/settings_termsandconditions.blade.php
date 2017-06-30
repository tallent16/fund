<div id="termsandconditions" class="tab-pane fade in">
	<div class="panel panel-default applyloan">   
		<div class="panel-body">
			<div class="col-sm-12">
				@foreach($settings_list as $row)
				<div class="row">
					<div class="col-sm-3">
						{{Lang::get('Creator\'s Terms & Conditions')}}
					</div>
					<div class="col-sm-4">
						<textarea rows="5" class="form-control" name="bor_terms" id="bor_terms">{{$row->toc_borrower}}</textarea>										
					</div>
					<div class="col-sm-3 pull-bottom">
						<button class="btn verification-button" type="button" onclick="previewBorTerms()">Preview</button>
					</div>
					@section ('bortermspopup-box_panel_title',Lang::get('Creator Terms & Conditions'))
					@section ('bortermspopup-box_panel_body')

					@endsection
					@section ('bortermspopup-box_panel_footer')
						<button type="button" class="btn btn-default itrack-modal-close" data-dismiss="modal">
							Close
						</button>
					@endsection
					@include('widgets.modal_box.panel', array(	'id'=>'borTermsPopup',
																'aria_labelledby'=>'borTermsPopup',
																'as'=>'bortermspopup-box',
																'class'=>'',
																'footerExists'=>'yes'
														))
													
					<div id="borTermsPopup"></div>
				</div>
				
				<div class="row">
					<div class="col-sm-3">
						{{Lang::get('Backer\'s Terms & Conditions')}}
					</div>
					<div class="col-sm-4">
						<textarea rows="5" class="form-control" name="inv_terms" id="inv_terms">{{$row->toc_investor}}</textarea>										
					</div>
					<div class="col-sm-3 pull-bottom">
						<button class="btn verification-button" type="button" onclick="previewInvTerms()">Preview</button>
					</div>
					@section ('invtermspopup-box_panel_title',Lang::get('Backer Terms & Conditions'))
					@section ('invtermspopup-box_panel_body')

					@endsection
					@section ('invtermspopup-box_panel_footer')
						<button type="button" class="btn btn-default itrack-modal-close" data-dismiss="modal">
							Close
						</button>
					@endsection
					@include('widgets.modal_box.panel', array(	'id'=>'invTermsPopup',
																'aria_labelledby'=>'invTermsPopup',
																'as'=>'invtermspopup-box',
																'class'=>'',
																'footerExists'=>'yes'
														))
													
					<div id="invTermsPopup"></div>
				</div>	
				@endforeach	
			</div>
		</div>	
	</div>
</div>	
