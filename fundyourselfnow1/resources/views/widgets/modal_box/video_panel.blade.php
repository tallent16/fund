<div 	class="modal fade" 
		id="{{$id}}" 
		role="dialog" 
		aria-labelledby="{{$aria_labelledby}}" 
		aria-hidden="true" 
		data-backdrop="static"
		style="display: none;">

	<div class="modal-dialog">
		<div class="modal-content">
			
				<button type="button" class="close itrack-modal-close" 
					data-dismiss="modal" aria-hidden="true"
					>
						×
				</button>
				
		
			<div class="modal-body video" style="max-height:100% !important;overflow-y:auto !important">
				@yield ($as . '_panel_body')
			</div>
		
		</div>
	</div>
</div>
