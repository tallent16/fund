var $mailer;

$(document).ready(function() {
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
	} );	
	
	$('.datetime-picker').datetimepicker({
		format:"dd-mm-yyyy",
		minView:2,
		autoclose:true
	});
						
	callDataTableFunc();
	
	$("#filter").click(function(event){   //filter the status 		
			var	status	=	$("#status").find("option:selected").text(); 
			$mailer.columns(3).search(status).draw();
		
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
	
	$mailer=$('#mailers').DataTable({
			dom: "Tfrtip",
			ajax: baseUrl+"/admin/ajax/getMailers",			
			columns: [{ 
					data: null,
					render: function(data, type, full, meta){
							var str ="";  
							str=str+'<input type="checkbox"  name="mailers_ids[]" class="select_mailer_id" '; 
							str=str+' value="'+data.ID+'"  />';								
							return str;
					},
					orderable: false
				},  
				{
					data: null,		
					className: "text-left",
					width:"500px",											
					render: function(data, type, full, meta){
							return  data.subject ;
					}        					
				},
				{
					data: null,		
					className: "text-left",	
					width:"200px",										
					render: function(data, type, full, meta){
							return  data.date ;
					}        					
				},
				{
					data: null,		
					className: "text-left",		
					width:"100px",									
					render: function(data, type, full, meta){
							return  data.status ;
					}        					
				},
				{ 
					data: null,		
					className: "text-center",	
					orderable: false,												
					render: function(data, type, full, meta){
						str='';
						var	viewClass	=	"showReceipients";
						var	copyUrl		=	baseUrl+'/admin/mailer/action/copy/'+data.ID;
						var	editUrl		=	baseUrl+'/admin/mailer/action/edit/'+data.ID;
						var	delUrl			=	baseUrl+'/admin/mailer/action/delete/'+data.ID;
						var	processUrl	=	baseUrl+'/admin/mailer/action/process/'+data.ID;
						faViewClass 		=	"fa-bell";
						if(data.status	==	"Sent"){
								activeElement	 = "disable-indication disabled"; 
								faClass 			=	"fa-bell-slash";  
								copyClass  		=	 "";
						}else{
								activeElement 	= "";
								faClass 				=	"fa-bell";
								copyClass            	=	"hidden"; 
						}
					
						str=str+'<ul class="list-unstyled">'
						str=str+'	<li class="dropdown">'
						str=str+'			<a class="dropdown-toggle" data-toggle="dropdown" href="#">'
						str=str+'				<i class="fa fa-caret-down fa-fw action-style"></i> '
						str=str+'			</a>'
						str=str+'			<ul class="dropdown-menu dropdown-user dropdown-menu-right">'
						str=str+'				<li>'
						str=str+'					<a href="#"class="'+viewClass+'">'
						str=str+'						<i class="fa '+faViewClass+' fa-fw"></i>  View Receipients '
						str=str+'					</a>'
						str=str+'				</li> ' 
						str=str+'				<li>'	
						str=str+'					<a href="'+copyUrl+'" class="'+copyClass+'">'
						str=str+'						<i class="fa '+faViewClass+' fa-fw"></i> Duplicate Message '
						str=str+'					</a>'
						str=str+'				</li>'
						str=str+'				<li>'	
						str=str+'					<a href="'+editUrl+'" class="'+activeElement+'">'
						str=str+'						<i class="fa '+faClass+' fa-fw"></i> Edit Message '
						str=str+'					</a>'
						str=str+'				</li>'
						str=str+'				<li>'
						str=str+'					<a href="'+delUrl+'"  class="'+activeElement+'">'
						str=str+'						<i class="fa '+faClass+' fa-fw"></i> Delete Message'
						str=str+'					</a>'
						str=str+'				</li>'
						str=str+'				<li>'
						str=str+'					<a href="'+processUrl+'"  class="'+activeElement+'">'
						str=str+'						<i class="fa '+faClass+' fa-fw"></i> Process Now'
						str=str+'					</a>'
						str=str+'				</li>'
						str=str+'			</ul>'	
						str=str+'		</li>'
						str=str+'</ul>'	
													
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
		url: baseUrl+"/admin/mailer/action/viewReceipients/"+ID, 
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
