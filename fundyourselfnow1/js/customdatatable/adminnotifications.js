var $broadcast;

$(document).ready(function() {
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('#hidden_token').val()
			}
	} );	
	callDataTableFunc();
	
	$('.datetime-picker').datetimepicker({
		format:"dd-mm-yyyy",
		minView:2,
		autoclose:true
	});
	
	$("#filter").click(function(event){   //filter the status 
			var	status	=	$("#status").find("option:selected").text(); 
			$broadcast.columns(3).search(status).draw();
		
			$.fn.dataTableExt.afnFiltering.push( function( oSettings, aData, iDataIndex ) {
				   var iFini = $('#from').val();
				   var iFfin = $('#to').val();
				   var col =2;
			 
				   iFini=iFini.substring(6,10) + iFini.substring(3,5)+ iFini.substring(0,2);
				   iFfin=iFfin.substring(6,10) + iFfin.substring(3,5)+ iFfin.substring(0,2);
			 
				   var datofini=aData[col].substring(6,10) + aData[col].substring(3,5)+ aData[col].substring(0,2);
				   var datoffin=aData[col].substring(6,10) + aData[col].substring(3,5)+ aData[col].substring(0,2);
			 
				   if ( iFini === "" && iFfin === "" ) {
					  return true;
				   } else if ( iFini <= datofini && iFfin === "") {
					  return true;
				   } else if ( iFfin >= datoffin && iFini === "") {
					  return true;
				   } else if (iFini <= datofini && iFfin >= datoffin) {
					  return true;
				   }
				   return false;
			});
		});
	
});
      
function callDataTableFunc(){
	
		$broadcast=$('#notifications').DataTable({
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
															str=str+'										<i class="fa '+faClass+' fa-fw"></i> Edit Notification '
															str=str+'									</a>'
															str=str+'								</li>'
															str=str+'								<li>'
															str=str+'									<a href="'+delUrl+'"  class="'+activeElement+'">'
															str=str+'										<i class="fa '+faClass+' fa-fw"></i> Delete Notification'
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
