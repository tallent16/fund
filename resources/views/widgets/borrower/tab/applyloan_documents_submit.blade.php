
@var $loanDocuments = $BorModLoan->document_details;
<div id="documents_submitted" class="tab-pane fade">
	<div class="panel panel-default applyloan">   
		<div class="panel-body">
		
			<div class="col-sm-12">
				<span class="pull-left"><h4>{{ Lang::get('borrower-applyloan.documents_submitted') }}</h4></span>								
				</br><hr>
						@var	$i	=	1
						@foreach($loanDocuments as $documentRow)
							<!---doc--rule--1-->
							<div class="row">
								<div class="col-sm-6">
									{{ $i.". ".$documentRow['short_name']}}
									<a 	href="#" 
										data-toggle="tooltip" data-placement="top" 
										title="{{ $documentRow['doc_name'] }}">
										<i class="fa fa-question"></i></a>
								</div>
								<div class="col-sm-6">
										<input 	type="hidden" 
												name="document_ids[]"
												value="{{$documentRow['loan_doc_id']}}">
										<input 	type="file" 
												class="jfilestyle" 
												data-buttonBefore="true" 
												name="documents[]">
								</div>
							</div>
						@var	$i++;	
					@endforeach									
				</div>								

		</div><!---panel body-->
	</div><!---panel------>
</div><!---2nd tab ends-->
