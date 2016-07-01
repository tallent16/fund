<div 	class="modal fade" 
		id="{{$id}}" 
		role="dialog" 
		aria-labelledby="{{$aria_labelledby}}" 
		aria-hidden="true" 
		data-backdrop="static"
		style="display: none;">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header  {{$class}}">
				<button type="button" class="close itrack-modal-close" 
					data-dismiss="modal" aria-hidden="true"
					>
						×
				</button>
				<h4 class="modal-title" id="{{$id}}Label">
					@yield ($as . '_panel_title')
				</h4>
			</div>
			<div class="modal-body">
				@yield ($as . '_panel_body')
			</div>
<!--
			<div class="modal-footer">
				<button type="button" class="btn btn-default itrack-modal-close" data-dismiss="{{$id}}">
						Close
				</button>
			</div>
-->
		</div>
	</div>
</div>
