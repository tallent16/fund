<div class="form-group">
	<label>
		Thanks You for bidding for Project Reference Number:
					<span id="modal_loan_number">{{$LoanDetMod->loan_reference_number}}</span>
	</label>
</div>
<!--
<div class="form-group">
	<label>
		You avaiable balance after this bid will be : SGD &nbsp;&nbsp;<span id="modal_aval_bal_after"></span>
	</label>
</div>
-->
<div class="form-group">
	<label>
		Once your bid is accepted by the Creator you will be notified of this before further peocessing made
	</label>
</div>
<div class="form-group">
	<label>
		<input type="checkbox" id="modal_confirm_bid" >Confirm that you have read the Terms  & Conditions
	</label>
</div>
<div class="form-group text-right">
	<input 	type="button" 
			value="Confirm" 
			id="confirmation_button"
			disabled
			class="btn verification-button">
	<input 	type="button" 
			value="Cancel" 
			class="btn verification-button"
			data-dismiss="modal">
</div>
