@extends('layouts.dashboard')
@section('styles') 
	{{ Html::style('css/multi-select/style.css') }} 
@stop 
@section('page_heading',Lang::get($title) )
@section('section')  
<div class="col-sm-12 space-around">
 <div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="panel panel-primary panel-container">				

					<div class="panel-heading panel-headsection">
						<div class="row">
						   <div class="col-xs-6">
								<span class="pull-left">{{ Lang::get($title) }}</span>
							</div>
						</div>
					</div>

					<div class="panel-body">
						<div class="col-sm-12 col-md-12 col-lg-12">
								<div class="col-sm-12 col-md-12 col-lg-12">
										<div class="row">
											<strong>Filter Receipients</strong>
										</div>
										<div class="row"> 
												<div class="col-sm-3 col-md-3 col-lg-3"> 
													<input type="radio" name="selectReceipients" value="1" {{(isset($filter['borrowers']))?"checked":""}}/>All Borrowers 
												</div>
												 <div class="col-sm-2 col-md-2 col-lg-2">
													  <input type="radio" name="selectReceipients"  value="2" {{(isset($filter['Investers']))?'checked':''}}/>All Investers
												</div>
												 <div class="col-sm-3 col-md-3 col-lg-3">
													  <input type="radio" name="selectReceipients"  value="3" {{(isset($filter['system']))?'checked':''}}/>All System Users 
												</div>
												<div class="col-sm-2 col-md-2 col-lg-2">
													 <input type="radio" name="selectReceipients"   value="0" {{(isset($filter['users']))?'checked':''}}/>All Users
												</div>
												<div class="col-sm-2 col-md-2 col-lg-2">
													 <input type="button" id="filterReceipient" class="btn btn-warning" value="Filter"/> 
												</div>
										</div> 
								</div>
								<form action='' method="post">
										<input type="hidden" name="_token" id="hidden_token" value="{{ csrf_token() }}">	
										<!-- receipient selector-->
										<div class="col-sm-12 col-md-12 col-lg-12">
												<div class="row">
														<div class="col-sm-5">
															<strong>All Receipients</strong>
															<select name="group[]" id="multiselect" class="form-control" size="8" multiple="multiple">{{(isset($multiSelector["options"]))?$multiSelector["options"]:''}}</select>
														</div> 
														<div class="col-sm-2">
															<br/>
															<button type="button" id="multiselect_rightAll" class="btn btn-block"><i class="glyphicon glyphicon-forward"></i></button>
															<button type="button" id="multiselect_rightSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
															<button type="button" id="multiselect_leftSelected" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
															<button type="button" id="multiselect_leftAll" class="btn btn-block"><i class="glyphicon glyphicon-backward"></i></button>
														</div> 
														<div class="col-sm-5">
															<strong>Selected Receipients</strong>
															<select name="receipients[]" id="multiselect_to" class="form-control recepientsList" size="8" multiple="multiple" required>{{(isset($receipientSelector["options"]))?$receipientSelector["options"]:''}}</select> 
														</div>
												</div>
										</div>
										<div class="">&nbsp;</div>
										<!-- Send buttons -->
										<div class="col-sm-12 col-md-12 col-lg-12"> 
													<div class="row">
														<div class="col-sm-5">
																<input type="radio" name="sendMethod" value="1"  {{(isset($send['now']))?'checked':''}}/> Send Now
														</div>
													</div> 
													<div class="row">
														<div class="col-sm-5">
																<input type="radio" name="sendMethod" value="2"  {{(isset($send['later']))?'checked':''}}/> Send Later
														</div>
														<div class="col-sm-5">
																<input type="text" name="sendTime" id="sendTime" class="form-control datetime-picker" placeholder="Send Time" disabled required value="{{(isset($send['later']))?$send['later']:''}}"/>
														</div>
													</div> 
												
													
													@if($useBlade == "notifications")
																<div class="row"> 
																		<br/>
																		<div class="col-sm-12 col-md-12 col-lg-12">
																				<strong>Broadcast Message</strong><br/>
																				<textarea id="message" class="form-control message" name="message" style="width:100%; height:100px;" required>{{(isset($send['message']))?$send['message']:''}}</textarea>
																		</div>
																</div>
													@else
															<div class="row"> 
																		<div class="col-sm-12 col-md-12 col-lg-12">
																				<br/>
																				<strong>Subject</strong><br/>
																				<input type="text" name="subject" id="subject" class="form-control" placeholder="Subject"  required value="{{(isset($send['subject']))?$send['subject']:''}}"/>
																		</div>
																		<br/>
																		<div class="col-sm-12 col-md-12 col-lg-12">
																				<br/>
																				<strong>Message</strong><br/>
																				<textarea id="body" class="form-control body" name="body" style="width:100%; height:180px;" required>{{(isset($send['body']))?$send['body']:''}}</textarea>
																		</div>
																</div>
													@endif
													
													<div class="row"> 
															<br/>
															<div class="col-sm-12 col-md-12 col-lg-12">
																<input type="submit" class="btn btn-warning" value="Process Broadcast"/>
															</div>
													</div> 
										</div>
								</form>
						</div>
					</div> 
			</div>
		</div>
	</div>
</div> 
@endsection
@section('bottomscripts') 
	<script src="{{ asset("assets/scripts/frontend.js") }}" type="text/javascript"></script>
	<script src="{{ url('js/multi-select/multiselect.js') }}" type="text/javascript"></script>
	<script src="{{ url('js/bootstrap-datetimepicker.js') }}" type="text/javascript"></script>
	    <script type="text/javascript">
				$(document).ready(function($) {
						 $.ajaxSetup({
							headers: {
								'X-CSRF-TOKEN': $("#token").val()
							}
						});
						
						var path = '{{URL::to("admin/broadcast-receipients")}}';  
						$('#multiselect').multiselect();
						
						$("#filterReceipient").click('on',function(){
							getReceipents(path);
						});
						
						$('.datetime-picker').datetimepicker({
								format: 'dd-mm-yyyy hh:ii	',
								startDate : new Date(),
								icons: {
									time: "fa fa-clock-o",
									date: "fa fa-calendar",
									up: "fa fa-arrow-up",
									down: "fa fa-arrow-down"
								 }
						});
						
						disableEnableDateInput();
						$("input[name='sendMethod']").change(function(){
								disableEnableDateInput(); 
						}); 
				});
				
				function getReceipents(path){
					$.ajax({
						url: path, 
						type:'POST', 
						data:{
							userType : $("input[name='selectReceipients']:checked").val()
						},
						success: function(result){
								var loop = 0;
								var option = "";
								$.each( result, function( key, value ){
									if(value['name']){
										option+="<option value="+value['id']+">"+value['name']+"</option>";
										loop++;
									}
								});
								$("#multiselect").html(option);
						}
					});
				}
				
				//Enable and Disable datepicker input based on sendMethod radio button
				function disableEnableDateInput(){
					
					if($("input[name='sendMethod']:checked").val()==2){
							$("#sendTime").removeAttr("disabled");
					}else{
						$("#sendTime").attr("disabled","disabled");
					}
					
				}
		  </script>
@stop  
