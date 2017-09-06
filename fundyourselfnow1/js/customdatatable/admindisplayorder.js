var $displayorder;
var editor;

$(document).ready(function() {
	callDataTableFunc();
	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('#hidden_token').val()
			}
	} );	
	
	$('#admindisplayorder').on( 'change', 'input.editor-active', function () {
        editor
            .edit( $(this).closest('tr'), false )
            .set( 'featured_loan', $(this).prop( 'checked' ) ? 1 : 0 )
            .submit();
    });
    
    	
	$('#admindisplayorder').on('click', 'a.editor_edit', function (e) {
        e.preventDefault();
		
        editor.edit( $(this).closest('tr'), {
            title: 'Edit Display Order',
            buttons: 'Update'
        });
		
     });
	
});

function callDataTableFunc(){	
	
	editor = new $.fn.dataTable.Editor( {
		ajax: baseUrl+"/admin/ajax/adminloandisplay",
		table: "#admindisplayorder",
		fields: [ 
					{
						label:     "Featured Loan:",
						name:      "featured_loan",
						type:      "checkbox",						
						options:   [
							{ label: '', value: 1 }
						]
					},
					{
						label: "Loan Display Order:",
						name: "loan_display_order"
					},
				]		       
	} );
	
	
	$displayorder =$('#admindisplayorder').DataTable( {
		dom: "Tfrtip",
		ajax: baseUrl+"/admin/ajax/adminloandisplay",			
		columns: [		
					{ 
						data: "loan_id",visible:false
					},				
					{ 
						data: null,
						className: "text-left",
						render: function(data, type, full, meta){
							
							var str ="";							      					    
								str=str+'<a href="javascript:void(0);"';
								str=str+' class="editor_edit" >';
								str=str+data.loan_reference_number+'</a>';							
							return str;
						}
					},			
					{ 
						data: null,
						className: "text-left",
						render: function(data, type, full, meta){
							
							var str ="";							      					    
								str=str+'<a href="javascript:void(0);"';
								str=str+' class="editor_edit" >';
								str=str+data.business_name+'</a>';							
							return str;
						}
					},{ 
						data: null,
						className: "text-left",
						render: function(data, type, full, meta){
							
							var str ="";							      					    
								str=str+'<a href="javascript:void(0);"';
								str=str+' class="editor_edit" >';
								str=str+data.loan_title+'</a>';							
							return str;
						}
					},
					{ 
						data: null,
						className: "text-right",
						render: function(data, type, full, meta){
							
							var str ="";							      					    
								str=str+'<a href="javascript:void(0);"';
								str=str+' class="editor_edit" >';
								str=str+data.loan_sanctioned_amount+'</a>';							
							return str;
						}
					},	
					{ 
						data: null,
						className: "text-left",
						render: function(data, type, full, meta){
							
							var str ="";							      					    
								str=str+'<a href="javascript:void(0);"';
								str=str+' class="editor_edit" >';
								str=str+data.crowd_end_date+'</a>';							
							return str;
						}
					},
					{ 
						data: null,
						className: "text-left",
						render: function(data, type, full, meta){
							
							var str ="";							      					    
								str=str+'<a href="javascript:void(0);"';
								str=str+' class="editor_edit" >';
								str=str+data.loan_status_name+'</a>';							
							return str;
						}
					},
					{
						data:   "featured_loan",
						className: "text-center",
						render: function ( data, type, row ) {
							if ( type === 'display' ) {
								return '<input type="checkbox" class="editor-active">';
							}
							return data;
						},						
					},					
					{ 
						data: null,
						className: "text-center",
						render: function(data, type, full, meta){
							
							var str ="";							      					    
								str=str+'<a href="javascript:void(0);"';
								str=str+' class="editor_edit" >';
								str=str+data.loan_display_order+'</a>';							
							return str;
						}
					},
				],
		order: [ 0, 'asc' ],
		
           select: {
				style: 'os',
				selector: 'td:not(:last-child)' // no row selection on last column
        },
			
	   tableTools: {
			
				aButtons: []
		},
        rowCallback: function ( row, data ) {
            // Set the checked state of the checkbox in the table
            $('input.editor-active', row).prop( 'checked', data.featured_loan == 1 );
        }					
				
	});		
}
