@var $borrowerDirectors = $modelBorPrf->director_details;

<div id="director_info" class="tab-pane fade" >
	<div class="panel panel-default directorinfo applyloan" onload="rem();"> 						
		<div class="panel-body">	
			<div class="col-sm-12 col-lg-4">	
			
				<div class="row">	
					<div class="col-xs-3">																				
						<label>{{ Lang::get('borrower-profile.select') }}:</label>											
					</div>																					 
					<div class="col-xs-9">										  
						<select class="selectpicker select-width" id="directorDropDown">  
						<!--
						<option value="">{{ Lang::get('borrower-profile.select_director') }}</option>
						-->
						{{ $modelBorPrf->directorSelectOptions }}
						</select>											
					</div>										
				</div><!--row-->			
				<div class="row" id="director_error_info" style="display:none">	
					<div class="col-xs-12">																				
						<label class="error"
								id="director_error_label">{{ Lang::get('There is error')}}</label>											
					</div>																					 
				</div><!--row-->
				
			</div>	<!--col-4 end-->		    
			<div class="col-lg-8"></div>
			
			<div class="col-sm-12 col-lg-10">	
				<div class="row">
				<div class="panel-primary panel-container">
					<div class="panel-heading panel-headsection"><!--panel head-->
						<div class="row">
							<div class="col-sm-12">
								<span class="pull-left"><i class="fa fa-trash  {{$modelBorPrf->viewStatus}}"></i></span> 														
							</div>																
						</div>					
					</div><!--panel head end-->
				</div><!--panel-->
				
				<div class="table-responsive"><!---table start-->
					<div class="divs">
						@var	$i	=	1
						@foreach($borrowerDirectors as $directorRow)
							<div  class="dir-list" id="{{ $directorRow['slno']}}" >
								<table class="table table-bordered .tab-fontsize text-left">		
									<tbody>
										<tr>
											<td class="col-md-3">
												<label class="input-required">
													{{ Lang::get('Name') }}
												</label>
											</td>
											<td class="col-md-3" id="name_{{$i}}_parent" colspan="3">
												<input  type="hidden"
														name="director_row[id][]"
														value="{{$directorRow['id'] }}" />
												<input 	type="text"  
														id="name_{{$i}}" 
														name="director_row[name][]"
														value="{{ $directorRow['name']  }}"
														placeholder="Director Name"
														class="form-control required"
														 {{$modelBorPrf->viewStatus}}/>
											</td>
												
										</tr>
										<tr>
											<td class="col-md-3">
												<label class="input-required">
													{{ Lang::get('borrower-profile.age') }}
												</label>
											</td>
											<td class="col-md-3" id="age_{{$i}}_parent">
												<input 	type="text" 
														id="age_{{$i}}" 
														name="director_row[age][]"
														value="{{ $directorRow['age']  }}"
														class="form-control text-right  num required"
														 {{$modelBorPrf->viewStatus}} />
											</td>	
											<td class="col-md-3">
												<label class="input-required">
												{{ Lang::get('borrower-profile.overall_exp') }}
												</label>
											</td>
											<td class="col-md-3" id="overall_experience_{{$i}}_parent">
												<input 	type="text" 
														id="overall_experience_{{$i}}" 
														name="director_row[overall_experience][]"
														value="{{ $directorRow['overall_experience']  }}"
														class="form-control text-right num required col-md-6"
														 {{$modelBorPrf->viewStatus}} />
											</td>
											
										</tr>
										<tr>
											<td class="col-md-3">
												<label class="input-required">
													{{ Lang::get('Team Member Information') }}
												</label>
											</td>
											<td colspan="3" class="col-md-3"  id="directors_profile_{{$i}}_parent">
												<textarea	id="directors_profile_{{$i}}" 
															onload="rem();"
															name="director_row[directors_profile][]"
															class="form-control required"
															rows="6"
														 {{$modelBorPrf->viewStatus}} 
														 >{{ $directorRow['directors_profile'] }}</textarea>
											</td>		
										</tr>
										<tr>
											<td  class="col-md-3">
												{{ Lang::get('borrower-profile.accomplish') }}
											</td>
											<td colspan="3" class="col-md-3">
												<textarea	id="accomplishments_{{$i}}" 
															name="director_row[accomplishments][]"
															class="form-control accomplishments"
															data-toggle="tooltip"
															rows="6"
															title="Please put down a short description of your work experience, important milestones and awards"
														>{{ $directorRow['accomplishments'] }}</textarea>
											</td>
										</tr>						
										<tr>
											<td class="col-md-3">
												<label class="">
													{{ Lang::get('Identification Document') }}
												</label>
											</td>
											<td colspan="3" class="col-md-3" id="identity_card_front_{{$i}}_parent">
												<input 	type="file" 
														class="jfilestyle attachment" 
														data-buttonBefore="true" 
														name="director_row[identity_card_front][]"
														id="identity_card_front_{{$i}}" />
																															
												<input 	type="hidden" 
														id="identity_card_front_{{$i}}_hidden"
														name="director_row[identity_card_front_hidden][]"
														value="{{ $directorRow['identity_card_front'] }}"
														/>		
												@if($directorRow['identity_card_front']!="")
													@var	$frontUrl	=	url('download/borrower/director/attachment');
													@var	$frontUrl	=	$frontUrl."/".$modelBorPrf->borrower_id
													@var	$frontUrl	=	$frontUrl."/".$directorRow['id']."/front"
													<a href="{{$frontUrl}}" 
														class="hyperlink">
														{{basename( $directorRow['identity_card_front'])}}
													</a>
												@endif	
											</td>
										</tr>													
<!--
										<tr>
											<td class="col-md-3">
												<label class="input-required">
													{{ Lang::get('Identity Card Back') }}
												</label>
											</td>
											<td colspan="3" class="col-md-3" id="identity_card_back_{{$i}}_parent">
												<input 	type="file" 
														class="jfilestyle required attachment" 
														data-buttonBefore="true" 
														name="director_row[identity_card_back][]"
														id="identity_card_back_{{$i}}" />
												<input 	type="hidden" 
														id="identity_card_back_{{$i}}_hidden"
														name="director_row[identity_card_back_hidden][]"
														value="{{ $directorRow['identity_card_back'] }}"
														/>		
												@if($directorRow['identity_card_back']!="")
													@var	$backUrl	=	url('download/borrower/director/attachment');
													@var	$backUrl	=	$backUrl."/".$modelBorPrf->borrower_id
													@var	$backUrl	=	$backUrl."/".$directorRow['id']."/back"
													<a href="{{$backUrl}}" 
														class="hyperlink">
														{{basename($directorRow['identity_card_back'])}}
													</a>
												@endif	
											</td>
										</tr>													
-->
									</tbody>
								</table>
							</div>
							@var	$i++
						@endforeach
					</div>
								
												
				</div><!--table-->
				</div>
				<div class="row">	
					<div class="pull-left">											
						<button type="button"
								class="btn verification-button  {{$modelBorPrf->viewStatus}}"
								id="add-director">
							<i class="fa pull-right"></i>
							{{ Lang::get('borrower-profile.add') }}
						</button>											
					</div>
									
						</br> 						
				</div><!--row-->						
				</div>	<!--col-10 end-->		    
			<div class="col-lg-2"></div>
	
		</div><!--panel body-->
	</div><!--panel------>	
</div><!--director tab-->
