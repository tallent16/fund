$(document).ready(function(){ 
			 $.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('#hidden_token').val()
				}
			});
			$(".trans_detail_icon").on('click',function(){
				$.ajax({
					type        : "POST", // define the type of HTTP verb we want to use (POST for our form)
					url         : "{{url()}}/borrower/ajax/trans_detail", // the url where we want to POST
					data        : {loan_id:$(this).attr("data-loan-id")},
					dataType    : 'json'
				}).done(function(data) {
					showTransDetailPopupFunc(data);
				});
			});
		}); 
		function showTransDetailPopupFunc(data) {
			$("#span_loan_ref_no").html(data.row.loan_ref_no);
			$("#span_bid_close_date").html(data.row.bid_close_date);
			$("#span_sanctioned_amount").html(data.row.sanctioned_amount);
			$("#span_interest_rate").html(data.row.interest_rate);
			$("#span_balance_outstanding").html(data.row.balance_outstanding);
			$('#transaction_detail').modal('show');
		}
