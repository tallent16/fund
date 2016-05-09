$(document).ready(function (){  
	
	/*Pagination Starts Prev & Next*/
	function check_navigation_display(el) {
		//accepts a jQuery object of the containing div as a parameter
		if ($(el).find('.pagination').children('div').first().is(':visible')) {
			$(el).children('.prev').hide();
		} else {
			$(el).children('.prev').show();
		}
		
		if ($(el).find('.pagination').children('div').last().is(':visible')) {
			$(el).children('.next').hide();
		} else {
			$(el).children('.next').show();
		}    
	}

	$('.divs').each(function () {		
		$(this).find('.pagination > div:gt(3)').hide();

		check_navigation_display($(this));
		
		$(this).find('.next').click(function () {
			var last = $(this).siblings('.pagination').children('div:visible:last');
			last.nextAll(':lt(4)').show();
			last.next().prevAll().hide();
			check_navigation_display($(this).closest('div'));
		});

		$(this).find('.prev').click(function () {
			var first = $(this).siblings('.pagination').children('div:visible:first');
			first.prevAll(':lt(4)').show();
			first.prev().nextAll().hide()
			check_navigation_display($(this).closest('div'));
		});

	});
	
	/*pagination ends*/
	
   $.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('#hidden_token').val()
		}
	});
	
    $(".repayment_schedule_btn").on('click',function(){
		
		 $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : baseUrl+'/ajax/borower_repayment_schedule', // the url where we want to POST
            data        : {loan_id:$(this).attr("data-loan-id")},
            dataType    : 'json'
        }) // using the done promise callback
            .done(function(data) {
				showRepaymentScheduleFunc(data);
            });
	});
});
   
function showRepaymentScheduleFunc(data) {
	var	str;
	str		=	"<div class='table-responsive'><table class='table'>";
	str		=	str+"<thead><tr><th>Schedule Date</th>";
	str		=	str+"<th>Schedule Amount</th>";
	str		=	str+"<th>Status</th>";
	str		=	str+"<th>Actual Date</th>";
	str		=	str+"<th>Actual Amount</th></thead>";
	str		=	str+"<tbody>";
	if(data.rows.length > 0){
		$.each( data.rows, function( key ) {
			str	=	str+"<tr><td>";
			str	=	str+data.rows[key].repayment_schedule_date+"</td>";
			str	=	str+"<td>";
			str	=	str+data.rows[key].repayment_scheduled_amount+"</td>";
			str	=	str+"<td>";
			str	=	str+data.rows[key].repayment_status+"</td>";
			str	=	str+"<td>";
			str	=	str+data.rows[key].repayment_actual_date+"</td>";
			str	=	str+"<td>";
			str	=	str+data.rows[key].repayment_actual_amount+"</td></tr>";
		});
	}else{
		str	=	str+"<tr><td colspan='5'> No Repayment Schedule Found</td></tr>";
	}
	str	=	str+"</tbody></table></div>";
	$("#repayment_information .modal-body").html(str);
	$('#repayment_information').modal('show');
}

