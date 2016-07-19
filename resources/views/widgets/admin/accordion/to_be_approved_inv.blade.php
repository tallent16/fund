<?php 
	//~ echo "<pre>",print_r($panelBody),"</pre>";
	
 ?>
<div class="table-responsive"><!---table start-->	
	<table class="table tab-fontsize text-left">
		<thead>
			<tr>
				<th class="tab-head text-left">{{Lang::get('Investor NAME')}}</th>
				<th class="tab-head text-left">{{Lang::get('Register Date')}}</th>
			</tr>
		</thead>
		<tbody>
			@if( is_array($panelBody) && count($panelBody)	>	0	)
				@foreach($panelBody as $tableRow) 
					@var	$url	=	url("admin/investor/profile")."/".base64_encode($tableRow->investor_id)
					<tr>
						<td>
							<a href="{{$url}}" >
								{{$tableRow->investor_name}}
							</a>
						</td>
						<td>
							<a href="{{$url}}" >
								{{$tableRow->register_datetime}}
							</a>
						</td>
					</tr>
				@endforeach
			@endif
		</tbody>
	</table>
</div>
