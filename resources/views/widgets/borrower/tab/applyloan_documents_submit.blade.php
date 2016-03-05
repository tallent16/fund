<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<div id="documents_submitted" class="tab-pane fade">
	<div class="panel panel-default applyloan">   
		<div class="panel-body">
		
			<div class="col-sm-12">
				<span class="pull-left"><h4>{{ Lang::get('borrower-applyloan.documents_submitted') }}</h4></span>								
				</br><hr>
						<!---doc--rule--1-->
						<div class="row">
							<div class="col-sm-6">
								{{ Lang::get('borrower-applyloan.short_desc_1') }}
								<a href="#" data-toggle="tooltip" data-placement="top" title="{{ Lang::get('borrower-applyloan.doc_rule_1') }}">
									<i class="fa fa-question"></i></a>
							</div>
							<div class="col-sm-6">
									<input type="file" class="jfilestyle" data-buttonBefore="true" >
							</div>
						</div>
						<!---doc--rule--2-->														
						<div class="row">
							<div class="col-sm-6">
								{{ Lang::get('borrower-applyloan.short_desc_2') }}
								<a href="#" data-toggle="tooltip" data-placement="top" title="{{ Lang::get('borrower-applyloan.doc_rule_2') }}">
									<i class="fa fa-question"></i></a>
								
							</div>
							<div class="col-sm-6">										
									<input type="file" class="jfilestyle" data-buttonBefore="true" >									
							</div>
						</div>
						<!---doc--rule--3-->
						<div class="row">
							<div class="col-sm-6">
								{{ Lang::get('borrower-applyloan.short_desc_3') }}
								<a href="#" data-toggle="tooltip" data-placement="top" title="{{ Lang::get('borrower-applyloan.doc_rule_3') }}
								{{ Lang::get('borrower-applyloan.doc_rule_3a') }}
								{{ Lang::get('borrower-applyloan.doc_rule_3b') }}">
									<i class="fa fa-question"></i></a>							
							</div>
							<div class="col-sm-6">										
									<input type="file" class="jfilestyle" data-buttonBefore="true" >										
							</div>
						</div>
						<!---doc--rule--4-->
						<div class="row">
							<div class="col-sm-6">
							{{ Lang::get('borrower-applyloan.short_desc_4') }}
							<a href="#" data-toggle="tooltip" data-placement="top" title="{{ Lang::get('borrower-applyloan.doc_rule_4') }}">
									<i class="fa fa-question"></i></a>							
							</div>
							<div class="col-sm-6">										
									<input type="file" class="jfilestyle" data-buttonBefore="true" >										
							</div>
						</div>
						<!---doc--rule--5-->
						<div class="row">
							<div class="col-sm-6">
							{{ Lang::get('borrower-applyloan.short_desc_5') }}
							<a href="#" data-toggle="tooltip" data-placement="top" title="{{ Lang::get('borrower-applyloan.doc_rule_5') }}">
									<i class="fa fa-question"></i></a>						
							</div>
							<div class="col-sm-6">										
									<input type="file" class="jfilestyle" data-buttonBefore="true" >									
							</div>
						</div>
						<!---doc--rule--6-->
						<div class="row">
							<div class="col-sm-6">
								{{ Lang::get('borrower-applyloan.short_desc_6') }}
								<a href="#" data-toggle="tooltip" data-placement="top" title="{{ Lang::get('borrower-applyloan.doc_rule_6') }}
							{{ Lang::get('borrower-applyloan.doc_rule_6a') }}
							{{ Lang::get('borrower-applyloan.doc_rule_6b') }}">
								<i class="fa fa-question"></i></a>								
							</div>
							<div class="col-sm-6">										
									<input type="file" class="jfilestyle" data-buttonBefore="true" >										
							</div>
						</div>
						<!---doc--rule--7-->
						<div class="row">
							<div class="col-sm-6">
							{{ Lang::get('borrower-applyloan.short_desc_7') }}								
							<a href="#" data-toggle="tooltip" data-placement="top" title="{{ Lang::get('borrower-applyloan.doc_rule_7') }}">
									<i class="fa fa-question"></i></a>													
							</div>
							<div class="col-sm-6">										
									<input type="file" class="jfilestyle" data-buttonBefore="true" >										
							</div>
						</div>
						<!---doc--rule--8-->
						<div class="row">
							<div class="col-sm-6">
							{{ Lang::get('borrower-applyloan.short_desc_8') }}							
							<a href="#" data-toggle="tooltip" data-placement="top" title="{{ Lang::get('borrower-applyloan.doc_rule_8') }}">
									<i class="fa fa-question"></i></a>
							</div>
							<div class="col-sm-6">										
									<input type="file" class="jfilestyle" data-buttonBefore="true" >									
							</div>
						</div>
						<!---doc--rule--9-->
						<div class="row">
							<div class="col-sm-6">
							{{ Lang::get('borrower-applyloan.short_desc_9') }}		
							<a href="#" data-toggle="tooltip" data-placement="top" title="{{ Lang::get('borrower-applyloan.doc_rule_9') }}">
									<i class="fa fa-question"></i></a>				
							</div>
							<div class="col-sm-6">										
									<input type="file" class="jfilestyle" data-buttonBefore="true" >								
							</div>
						</div>
						<!---doc--rule--10-->
						<div class="row">
							<div class="col-sm-6">
							{{ Lang::get('borrower-applyloan.short_desc_10') }}	
							<a href="#" data-toggle="tooltip" data-placement="top" title="{{ Lang::get('borrower-applyloan.doc_rule_10') }}">
									<i class="fa fa-question"></i></a>												
							</div>
							<div class="col-sm-6">														
								<input type="file" class="jfilestyle" data-buttonBefore="true" >																			
							</div>												
						</div>					
									 											
				</div>								

		</div><!---panel body-->
	</div><!---panel------>
</div><!---2nd tab ends-->
