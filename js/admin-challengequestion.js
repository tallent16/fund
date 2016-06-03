$(document).ready(function (){  
		$("#select_all_list").click(function(){	 
			checkall_list(this,"select_question_id");
		});
		
		
});
/*
$("#new_question").click(function(){	
	$("#security_table>tbody>tr:last-child").show();
});*/
$("#new_question").click(function () { 

    $("#security_table").each(function () {
       
        var tds = '<tr">';
        jQuery.each($('tr:last td', this), function () {
            tds += '<td>' + $(this).html() + '</td>';
        });
        tds += '</tr>';
        if ($('tbody', this).length > 0) {
            $('tbody', this).append(tds);
        } else {
            $(this).append(tds);
        }
    });
});
