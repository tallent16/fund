@extends('layouts.dashboard')
@section('bottomscripts')
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>	
	<script src="{{ url("js/admin-challengequestion.js") }}" type="text/javascript"></script>
@endsection
@section('page_heading',Lang::get('User Security Questions') )
@section('section')  
		@var $security_list = $adminchallqueModel->securityque_list;
<div class="col-sm-12 space-around">
	
	<form method="post" id="form-challenge-questions" action="">
		<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">	
		
	<div class="row">		
		<div class="col-lg-12 col-md-12">
			<div class="panel panel-primary panel-container">				

					<div class="panel-heading panel-headsection">
						<div class="row">
						   <div class="col-xs-6">
								<span class="pull-left">{{ Lang::get('Questions') }}</span> 
							</div>									
						</div>                           
					</div>				

					<div class="table-responsive">
						<table class="table tab-fontsize text-left" id="security_table">
							<thead>
								<tr>									
									<th class="tab-head text-left col-sm-2 text-center">{{ Lang::get('S.No') }}</th>
									<th class="tab-head text-left col-sm-8">{{ Lang::get('Question') }}</th>
									<th class="tab-head text-left col-sm-2 text-center">
										<label>
											<input type="checkbox" id="select_all_list" value="Select All">
										</label>	
									</th>
								</tr>
							</thead>
							
							<tbody>	
								@foreach ($security_list as $queRow)
								<tr>
									<td class="question text-center" >
										{{$queRow->slno}}
										<input  type="hidden"
												name="questions[id][]"
												value="{{$queRow->challenge_id}}" />
									</td>
									<td>
										<input type="text" 
												value="{{$queRow->challenge_text}}"
												name="questions[question_list][]"
												class="form-control"
										/>
									</td>										
									<td class="text-center">													
											<label>
												<input 	type="checkbox" 
														class="select_question_id"	
														name="questions[selected][]"															
														value="{{$queRow->challenge_id}}">
											</label>													
									</td>
								</tr>								
								@endforeach									
							</tbody>
						</table>
					</div>
						
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-12">	
			<button type="button"
					id="new_question"
					class="btn verification-button"	>
					<i class="fa pull-right"></i>
					{{ Lang::get('New Questions')}}
			</button>
			<button type="button"
					id="delete_question"
					class="btn verification-button"	>
					<i class="fa pull-right"></i>
					{{ Lang::get('Delete Selected')}}
			</button>
			<button type="submit"
					id="update_question"
					class="btn verification-button"	>
					<i class="fa pull-right"></i>
					{{ Lang::get('Save')}}
			</button>
		</div>
	</div>
	</form>	
</div>
<div class="space-around">&nbsp;</div>
<div style="display:none;">
	<input type="hidden" id="question_id" value= "{{$queRow->slno}}" />
	<input type="hidden" id="count_question_id" value= "{{count($queRow->challenge_id)}}" />
	
	<div>
		<table  >
		<tr id="questionTemplate">
			<td class="security_id text-center">
				XXX
				<input  type="hidden"
						name="questions[id][]"
						value="0" />
			</td>
			<td>
				<input type="text" 
						value=""
						name="questions[question_list][]"
						class="form-control"
						value=""
				/>
			</td>
			<td class="text-center">
				<label>
						<input 	type="checkbox" 
								class="select_newquestion_id"																
								value="	">
					</label>
			</td>
		</tr>
		</table>
	</div>
</div>
	@endsection  
@stop

