$(document).ready(function (){  
	
	var newHeight = $(".loan-list-table tr:nth-child(2) td").innerHeight();
	$(".myloan-table-left-label tr:nth-child(2) td").css("height", newHeight+"px");  //Borrower's Name label height updated based on right side data

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
});
