var $borrower;

$(document).ready(function() {
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('#hidden_token').val()
			}
	} );	
	callDataTableFunc();
	
	
});
      
function callDataTableFunc(){
	
		var brodcast=$('#notifications').DataTable({
										dom: "Tfrtip",
										ajax: baseUrl+"/admin/ajax/getNotifications",			
										columns: [
													{ 
														data: null,
														render: function(data, type, full, meta){
																var str ="";  
																str=str+'<input type="checkbox"  name="notifications_ids[]" class="select_notification_id" '; 
																str=str+' value="'+data.ID+'"  />';								
																return str;
														},
														orderable: false
													},  
													{
														data: null,		
														className: "text-left",											
														render: function(data, type, full, meta){
																return  data.message ;
														}        					
													},
													{
														data: null,		
														className: "text-left",											
														render: function(data, type, full, meta){
																return  data.date ;
														}        					
													},
													{
														data: null,		
														className: "text-left",											
														render: function(data, type, full, meta){
																return  data.status ;
														}        					
													},
													{ 
														data: null,		
														className: "text-center",													
														render: function(data, type, full, meta){
															str='';
															var	viewClass	=	"showReceipients";
															var	editUrl		=	baseUrl+'/admin/notifications/action/edit/'+data.ID;
															var	delUrl			=	baseUrl+'/admin/notifications/action/delete/'+data.ID;
															var	processUrl	=	baseUrl+'/admin/notifications/action/process/'+data.ID;
															faViewClass 		=	"fa-bell";
															if(data.status	==	"Sent"){
																	activeElement	 = "disable-indication disabled"; 
																		faClass 			=	"fa-bell-slash";  
															}else{
																	activeElement 	= "";
																	faClass 				=	"fa-bell";
															}
															
															str=str+'<ul class="list-unstyled">'
															str=str+'	<li class="dropdown">'
															str=str+'		<a class="dropdown-toggle" data-toggle="dropdown" href="#">'
															str=str+'					<i class="fa fa-caret-down fa-fw action-style"></i> '
															str=str+'						</a>'
															str=str+'							<ul class="dropdown-menu dropdown-user dropdown-menu-right">'
															str=str+'								<li>'
															str=str+'									<a href="#"class="'+viewClass+'">'
															str=str+'										<i class="fa '+faViewClass+' fa-fw"></i>  View Receipients '
															str=str+'									</a>'
															str=str+'								</li> ' 
															str=str+'								<li>'	
															str=str+'									<a href="'+editUrl+'" class="'+activeElement+'">'
															str=str+'										<i class="fa '+faClass+' fa-fw"></i> Edit Notifications '
															str=str+'									</a>'
															str=str+'								</li>'
															str=str+'								<li>'
															str=str+'									<a href="'+delUrl+'"  class="'+activeElement+'">'
															str=str+'										<i class="fa '+faClass+' fa-fw"></i> Delete Notifications'
															str=str+'									</a>'
															str=str+'								</li>'
															str=str+'								<li>'
															str=str+'									<a href="'+processUrl+'"  class="'+activeElement+'">'
															str=str+'										<i class="fa '+faClass+' fa-fw"></i> Process Now'
															str=str+'									</a>'
															str=str+'								</li>'
															str=str+'							</ul>'	
															str=str+'						</li>'
															str=str+'					</ul>'	
																							
															return str;				    
														}
													}
										],
										order: [ 2, 'desc' ],
										tableTools: {			
											aButtons: []
										},
										fnDrawCallback: function (oSettings) {
												$(".showReceipients").on('click',function(){
													var nId = $(this).closest("tr").attr("id");
													actionReceipientsView(nId);
													$("#receipientModal").modal("show");
												});
										}
								});
}

function actionReceipientsView(ID){
			$.ajax({
					url: baseUrl+"/admin/notifications/action/viewReceipients/"+ID, 
					type:'POST',
					success: function(result){
							 viewReceipientsModal(result)
					}
			});
}

function viewReceipientsModal(data){
		var userNames='';
		$.each( data, function( key, value ){
			userNames +='<li class="list-group-item">'+value ['name']+'</li> ';
		});
		userNames='<ul class="list-group">'+userNames+'</ul>';
		$("#receipientModal .content").html(userNames);
}
