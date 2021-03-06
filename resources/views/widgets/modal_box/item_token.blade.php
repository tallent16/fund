<div class="row">
	<label 	class="col-sm-3 control-label">Title</label>
	<div class="col-sm-8">
		<input type="text" class="form-control" id="item_tok_title" placeholder="Title">
	</div>
</div>
<div class="row">
	<label 	class="col-sm-3 control-label">Pledge Amount</label>
	<div class="col-sm-8">
		<input 	type="text" 
				class="form-control amount-align" 
				id="item_tok_pledge_amt" 
				placeholder="Pledge Amount"
				decimal="2">
	</div>
</div>
<div class="row">
	<label 	class="col-sm-3 control-label">Description</label>
	<div class="col-sm-8">
		<textarea id="item_tok_desc" style="width:100%" placeholder="Description"></textarea>
	</div>
</div>
<div class="row">
	<label 	class="col-sm-3 control-label">Estimate Delivery Date</label>
	<div class="col-sm-8">
		<div class="controls">
			<div class="input-group">
				<input 	type="text" 
						id="item_tok_esdldate" 
						name="item_tok_esdldate"
						value=""
						class="date-picker form-control required"
						placeholder="Estimate Delivery Date"
						 />	
				<label class="input-group-addon btn" for="item_tok_esdldate">
					<span class="glyphicon glyphicon-calendar"></span>
				</label>
			</div>													
		</div>			
		
	</div>
</div>
<div class="row">
	<label 	class="col-sm-3 control-label">Reward Limit</label>
	<div class="col-sm-8">
		<input 	type="text" 
				class="form-control amount-align" 
				id="item_tok_limit" 
				placeholder="Token Limit"
				decimal="0">
	</div>
</div>
