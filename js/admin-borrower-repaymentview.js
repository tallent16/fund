		$(document).ready(function(){ 
			 $.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('#hidden_token').val()
				}
			});
		// date picker
			$('.actual_date').datetimepicker({
				autoclose: true, 
				minView: 2,
				format: 'dd-mm-yyyy' 
			}); 
			$("#save_button").on("click",function(){
				$("#isSaveButton").val("yes");
			});
			$("#submit_button").on("click",function(){
				$("#isSaveButton").val("");
			});
			$("#save_form_payment").on("submit",function(e){
				$('span.error').remove();
				$('.has-error').removeClass("has-error");
				var $parentTag = $("#trans_ref_parent");
				$('[disabled]').removeAttr('disabled');
				if($("#isSaveButton").val()	!=	"yes") {
					if($("#trans_ref").val()	==	"") {
						$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
						e.preventDefault();
					}
				}
			});
			$("#actual_date").on('change',function(){
				var	schRepDate		=	$("#scdule_date").val();
				var	actRepDate		=	$(this).val();
				var	principalAmt	=	$("#principal_amount").val();
				var	interestAmt		=	$("#interest_amount").val();
				$.ajax({
					type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
					url         : baseUrl+'/admin/ajax/recalculatePenality', // the url where we want to POST
					data        : {	schRepDate:schRepDate,
									actRepDate:actRepDate,
									principalAmt:principalAmt,
									interestAmt:interestAmt,
									},
					dataType    : 'json'
				}) // using the done promise callback
				.done(function(data) {
					resetPenalityFunc(data);
				});
			});
		}); 
		function resetPenalityFunc(data) {
			$("#amount_Paid").val(data.amountPaid);
			$("#penalty_amount").val(data.penaltyAmt);
			$("#penalty_companyshare").val(data.penaltyCompShare);
		}
