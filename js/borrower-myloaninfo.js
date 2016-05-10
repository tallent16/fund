$(document).ready(function (){  
	
	var newHeight1 = $(".loan-list-table tr:nth-child(7)").innerHeight();
	$(".loaninfo-table-label tr:nth-child(7)").css("height", newHeight1+"px"); 	 //Effective interest label row height based on right side data
	
	var newHeight2 = $(".loaninfo-table-label tr:nth-child(7)").innerHeight(); 
	$(".loan-list-table tr:nth-child(7)").css("height", newHeight2+"px"); 	     //Effective interest data row height based on left side label when screen size 1280px
	
	var newHeight3 = $(".loan-list-table tr:nth-child(10)").innerHeight();
	$(".loaninfo-table-label tr:nth-child(10)").css("height", newHeight3+"px");	 //Repayments till date	row height based on right side data
		
	var newHeight4 = $(".loaninfo-table-label tr:nth-child(10)").innerHeight();
	$(".loan-list-table tr:nth-child(10)").css("height", newHeight4+"px");       //Repayments till date	data row height based on left side label when screen size 1280px
	
	var newHeight5 = $(".loaninfo-table-label tr:nth-child(11)").innerHeight();
	$(".loan-list-table tr:nth-child(11)").css("height", newHeight5+"px");       //Principal outstanding data based on left side label when screen size 1280px
	
	/*************************** Pagination Starts Prev & Next *********************************/
	function check_navigation_display(el) {
		//accepts a jQuery object of the containing div as a parameter
		if ($(el).find('.pagination').children('div').first().is(':visible')) {
			$(el).children('.prev').addClass('disabled').css({"color": "#ccc"});
		} else {
			$(el).children('.prev').removeClass('disabled').css({"color": "#222"});
		}
		
		if ($(el).find('.pagination').children('div').last().is(':visible')) {
			$(el).children('.next').addClass('disabled').css({"color": "#ccc"});;
		} else {
			$(el).children('.next').removeClass('disabled').css({"color": "#222"});
		}    
	}

	$('.divs').each(function () {		
		
		$(this).find('.prev').css({"color": "#222", "font-size": "28px","cursor": "pointer"}); 
		$(this).find('.next').css({"color": "#222", "font-size": "28px", "margin-right": "20px","cursor": "pointer"}); 
		$(this).find('.pagination').css({"margin": "0"});
		
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
	
	/*******************************pagination ends*************************************/
	
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
	str		=	"<div class='table-responsive'><table class='table text-left'>";
	str		=	str+"<thead><tr><th class='text-left'>Schedule Date</th>";
	str		=	str+"<th class='text-right'>Schedule Amount</th>";
	str		=	str+"<th class='text-left'>Status</th>";
	str		=	str+"<th class='text-left'>Actual Date</th>";
	str		=	str+"<th class='text-right'>Actual Amount</th></thead>";
	str		=	str+"<tbody>";
	if(data.rows.length > 0){
		$.each( data.rows, function( key ) {
			str	=	str+"<tr><td>";
			str	=	str+data.rows[key].repayment_schedule_date+"</td>";
			str	=	str+"<td class='text-right'>";
			str	=	str+data.rows[key].repayment_scheduled_amount+"</td>";
			str	=	str+"<td>";
			str	=	str+data.rows[key].repayment_status+"</td>";
			str	=	str+"<td>";
			str	=	str+data.rows[key].repayment_actual_date+"</td>";
			str	=	str+"<td class='text-right'>";
			str	=	str+data.rows[key].repayment_actual_amount+"</td></tr>";
		});
	}else{
		str	=	str+"<tr><td colspan='5'> No Repayment Schedule Found</td></tr>";
	}
	str	=	str+"</tbody></table></div>";
	$("#repayment_information .modal-body").html(str);
	$('#repayment_information').modal('show');
}

