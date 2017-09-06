var $adminaudit;

//calling AJAX 
$(document).ready(function() {
	callDataTableFunc();
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('#hidden_token').val()
			}
	} );
	
	//filter module and action     
	$("#applyfilter").click(function(event){   //filter the status 		
		var	transcation_filter	=	$("#modulelist").find("option:selected").val();
		transcation_filter		=	(transcation_filter	==	"all")?"":transcation_filter;		
		$adminaudit.columns(2).search(transcation_filter).draw();
		
		var	action_filter	=	$("#action_list").find("option:selected").val();
		action_filter		=	(action_filter	==	"all")?"":action_filter;		
		$adminaudit.columns(3).search(action_filter).draw();
		
	});
	
	//From date and To date filtering
	$.fn.dataTableExt.afnFiltering.push(
		function( oSettings, aData, iDataIndex ) {
			var iFini = document.getElementById('fromdate').value;
			var iFfin = document.getElementById('todate').value;
			var iStartDateCol = 0;
			var iEndDateCol = 0;

			iFini=iFini.substring(6,10) + iFini.substring(3,5)+ iFini.substring(0,2);
			iFfin=iFfin.substring(6,10) + iFfin.substring(3,5)+ iFfin.substring(0,2);

			var datofini=aData[iStartDateCol].substring(6,10) + aData[iStartDateCol].substring(3,5)+ aData[iStartDateCol].substring(0,2);
			var datoffin=aData[iEndDateCol].substring(6,10) + aData[iEndDateCol].substring(3,5)+ aData[iEndDateCol].substring(0,2);

			if ( iFini === "" && iFfin === "" )
			{
				return true;
			}
			else if ( iFini <= datofini && iFfin === "")
			{
				return true;
			}
			else if ( iFfin >= datoffin && iFini === "")
			{
				return true;
			}
			else if (iFini <= datofini && iFfin >= datoffin)
			{
				return true;
			}
			return false;
		});	
		
		var p = new Date();
	var n = new Date();

	p.setMonth(p.getMonth() - 2); //subtract month - prev
	n.setMonth(n.getMonth() + 2); //adding month - next
	
	if((p.getDate()) < 10){	
		var pdate = ("0"+p.getDate());
	}else{
		var pdate = (p.getDate());
	}
	if((n.getDate()) < 10){	
		var ndate = ("0"+n.getDate());
	}else{
		var ndate = (n.getDate());
	}	
	
	//~ //adding zero for month
	if((p.getMonth()+1) < 10){	
		var prevDate = (pdate + '-' +("0"+(p.getMonth() + 1) ) + '-' +  p.getFullYear());
	}else{
		var prevDate = (pdate + '-' +(p.getMonth() + 1)  + '-' +  p.getFullYear());
	}
	if((n.getMonth()+1) < 10){	
		var nextDate = (ndate + '-' +("0"+(n.getMonth() + 1) ) + '-' +  n.getFullYear());
	}else{
		var nextDate = (ndate + '-' +(n.getMonth() + 1)  + '-' +  n.getFullYear());
	}

	//set in the datepicker
	$("#fromdate").val(prevDate);
	$("#todate").val(nextDate);

     // Add event listener for opening and closing details
    $('#adminaudit tbody').on('click', 'td.details-control', function () {
		var currentid = $(this).closest('tr').attr('id');
		
		//~ $("tr:not('"+currentid+"')").siblings('tr.shown').next().toggle();
		//~ $(this).parent().siblings('tr.shown').removeClass("shown");
		//~ $(currentid).show();
				
        var tr = $(this).closest('tr');
        var row = $adminaudit.row( tr );
        var modulename = $(this).find('input').val()
        		
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
			row.child( format(row.data()) ).show();
            getaudittablesinfo(modulename);
            tr.addClass('shown');
            
        }
    } );

	$('#adminaudit tbody').on('click', '.module_list li', function () {
		
		var str1 	= $(this).find('input').val();
		var str2	= $(this).closest('ul').closest('tr').prev().attr("id");
		
		 $.ajax({ 
			type        : 'GET', 								// define the type of HTTP verb we want to use (POST for our form)
			url         : baseUrl+"/admin/audit_trial/"+str1+"/"+str2, 	// the url where we want to POST          
			dataType    : 'json',
			async: false,
		   
		}) // using the done promise callback
		.done(function(data) {  						
			showAuditPopupFunc(data);
		}).	fail(function (data){					
		});			
	});
}); //document ready ends
//popup info
function showAuditPopupFunc(data){
	var	str 		= 	"";
	var	afterRow	=	data.rows.rowAfter;
	str				=	"<div class='table-responsive'><table class='table text-left' id='popup_table'>";
	str				=	str+"<thead><tr style='background-color:#222;color:#fff'><th class='text-left col-sm-4'>Columns</th><th class='text-left col-sm-4'>Before</th>";	
	str				=	str+"<th class='text-left col-sm-4'>After</th></tr></thead>";
	str				=	str+"<tbody>";	

	if(data.rows.rowBefore != null){		
		$.each( data.rows.rowBefore, function(key1,val1) {					
				str =	str +"<tr><td>";					
				str	=	str+key1;
				str =	str +"</td>";	
				str = 	str +"<td class='before'>";	
				if(afterRow[key1])		{		
					str	= 	str+afterRow[key1];
				}
				str = 	str +"</td>";
				str = 	str +"<td class='after'>";				
				str	= 	str+val1;
				str = 	str +"</td></tr>";
		});				
	}
	else{		
		str =	str +"<tr class='text-center'><td colspan='3'>No Records Found</td></tr>";
	}
	str		=	str+"</tbody></table></div>";
	$("#audit_info .modal-body").html(str);
	$("#audit_info").modal("show");
}
//main listing audit entries
function callDataTableFunc(){	
						
	$adminaudit =$('#adminaudit').DataTable( {
		
			dom: "Tfrtip",			
			ajax: baseUrl+"/admin/ajax/adminauditinfo",			
			columns: [
						
						{ 													
							data: null,		
							className: "text-left",											
							render: function(data, type, full, meta){ 								
									           				
								var str ="";  								
								str=str+data.action_date;						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "text-left",											
							render: function(data, type, full, meta){ 								
									           				
								var str ="";  								
								str=str+data.username;						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "text-left",											
							render: function(data, type, full, meta){ 								
									           				
								var str ="";  								
								str=str+data.module_name;						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "text-left",											
							render: function(data, type, full, meta){ 								
									           				
								var str ="";  								
								str=str+data.action_summary;						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "text-left",											
							render: function(data, type, full, meta){ 								
									           				
								var str ="";  								
								str=str+data.action_detail;						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "text-left",											
							render: function(data, type, full, meta){ 								
									           				
								var str ="";  								
								str=str+data.display_key;						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "text-left",											
							render: function(data, type, full, meta){ 								
									           				
								var str ="";  								
								str=str+data.display_value;						
								return str;
        					 
        					}
						},
						{ 													
							data: null,		
							className: "details-control",											
							render: function(data, type, full, meta){ 								
									           				
								var str ="";  								
								str=str+"<input type='hidden' id='module_name' value='"+data.module_name+"' name='module-name'>";						
								return str;
        					 
        					}
						},
			],
		order: [ 0, 'asc' ],
		tableTools: {			
			aButtons: [		
				
			]
		}
    });	    	
}

function format ( d ) {
    // `d` is the original data object for the row
    return '<div class="module_list"></div>';
}
//audit table entries
function getaudittablesinfo(modulename){
		var a= $(this).closest('tr').attr('id');
		$(this).parent().siblings('tr.shown').removeClass("shown");
		
		var b = '#tran_row_'+a;		
		$("tr:not('"+b+"')").siblings('[id^="tran_row_"]').hide();
		$(b).show();
					     
		var ret = modulename.split(" ");
		var str1 = ret[0];	
		var str2 = ret[1];	
		if(str1 == 'Loans'){
			str2 = 'Info';			
		}
			
		$.ajax({ 
            type        : 'GET', 				// define the type of HTTP verb we want to use (POST for our form)
            url         : baseUrl+"/admin/audit_trial/module/"+str1+"/"+str2, 	// the url where we want to POST           
            dataType    : 'json',
            async		: false,
        }) // using the done promise callback
		.done(function(data) {					
			showTablesList(data);
		}); 
	}
//list entries 
function showTablesList(data){
	var	str = 	"";	
	str		=	str+"<ul style='list-style-type:none;'>";
	
		$.each( data.rows, function(key,val) {
			str	=	str+"<li style='cursor:pointer;' >";
			str	=	str+"<span class='fa fa-check-square'></span>"+" "+val+"\n";	
			str	=	str+"<input type ='hidden' value="+ key+">\n";	
			str	=	str+"</li></br>";
		});
		str	=	str+"</ul>";
		$('.module_list').html(str);
}
