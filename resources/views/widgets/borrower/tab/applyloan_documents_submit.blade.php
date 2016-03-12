
@var $loanDocuments = $BorModLoan->document_details;
<div id="documents_submitted" class="tab-pane fade">
	<div class="panel panel-default applyloan">   
		<div class="panel-body">
		
			<div class="col-sm-12">
				<span class="pull-left"><h4>{{ Lang::get('borrower-applyloan.documents_submitted') }}</h4></span>								
				</br><hr>
						<fieldset {{$BorModLoan->viewStatus}}>
						@var	$i	=	1
						@foreach($loanDocuments as $documentRow)
							@var	$documentRowIndex	=	$documentRow['loan_doc_id']
							<!---doc--rule--1-->
							
							<div class="row">
								<div class="col-sm-6">
									{{ $i.". ".$documentRow['short_name']}}
									<a 	href="#" 
										data-toggle="tooltip" data-placement="top" 
										title="{{ $documentRow['doc_name'] }}">
										<i class="fa fa-question"></i></a>
								</div>
								<div class="col-sm-5">
										<input 	type="hidden" 
												name="document_ids[]"
												value="{{$documentRowIndex}}">
										<input 	type="file" 
												class="jfilestyle" 
												data-buttonBefore="true" 
												name="documents[]">	
								</div>
								<div class="col-sm-1">
									@if(isset($BorModLoan->submitted_document_details[$documentRowIndex]))
										@var	$loan_url	=	$BorModLoan->submitted_document_details[$documentRowIndex]
										@var	$loan_url	=	"borrower/docdownload/".$loan_url
										<a 	href="javascript:void(0)"
											data-download-url="{{url($loan_url)}}"
											class="borrower_doc_download">View
										</a>
									@endif
								</div>
							</div>
						@var	$i++;	
					@endforeach		
					</fieldset>					
				</div>								

		</div><!---panel body-->
	</div><!---panel------>
</div><!---2nd tab ends-->

