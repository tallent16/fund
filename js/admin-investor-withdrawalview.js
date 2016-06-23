$(document).ready(function(){ 
		
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('#hidden_token').val()
			}
		});
		// date picker
		$('.request_date').datetimepicker({
			autoclose: true, 
			minView: 2,
			format: 'dd-mm-yyyy' 
			}); 	
		$('.settlement_date').datetimepicker({
			autoclose: true, 
			minView: 2,
			format: 'dd-mm-yyyy' 
			}); 
			getAvailableBalance();
		$("select#investor_id").on("change",function() {
			$("#approve_button").hide();
			getAvailableBalance();
		});
}); 
					
		$(".amount-align").on("focus", function() {
				onFocusNumberField(this);
		})

		$(".amount-align").on("blur", function() {
			onBlurNumberField(this)
		})
		
		$("#save_button").on("click",function(){
				$("#isSaveButton").val("yes");
				$("#submitType").val("save");
				if($("#screen_mode").val()	==	"admin") {					
					$("#save_form_payment").attr("action",baseUrl+"/admin/investorwithdrawalview/save");
				}else{										
					$("#save_form_payment").attr("action",baseUrl+"/investor/investorwithdrawalview/save");
				}
			});
			$("#approve_button").on("click",function(){
				$("#isSaveButton").val("");
				$("#submitType").val("approve");
				$("#save_form_payment").attr("action","/admin/investorwithdrawalview/approve");
			});
			$("#unapprove_button").on("click",function(){
				$("#isSaveButton").val("");
				$("#submitType").val("unapprove");
				$("#save_form_payment").attr("action","/admin/investorwithdrawalview/unapprove");
			});
			$("#save_form_payment").on("submit",function(e){
				
				$('span.error').remove();
				$('.has-error').removeClass("has-error");
				var	withdrawal_amount	=	numeral($("#withdrawal_amount").val()).value();
				getAvailableBalance();
				
				AvailableBalance		=	numeral($("#avail_bal").val()).value();
				
				var	request_date		=	$("#request_date").val();
				var	settlement_date		=	$("#settlement_date").val();
				request_date=new Date(request_date.split("-")[2], request_date.split("-")[0],
														request_date.split("-")[1]);
				settlement_date=new Date(settlement_date.split("-")[2], settlement_date.split("-")[0],
															settlement_date.split("-")[1]);
				
				//if($("#isSaveButton").val()	!=	"yes") {					
					
					if(	withdrawal_amount <= 0 ) {
						var $parentTag 			=	$("#withdrawal_amount_parent");
						$parentTag.addClass('has-error').append(
												'<span class="control-label error">Withdrawal Amount should be greater than 0</span>');						
					}
						
					if(	withdrawal_amount >	AvailableBalance ) {						
						
						var $parentTag 			=	$("#withdrawal_amount_parent");
						$parentTag.addClass('has-error').append(
												'<span class="control-label error">Withdrawal Amount Exceed Available Balance</span>');
					}
					
					if(	request_date >	settlement_date ) {
						var $parentTag 			=	$("#request_date_parent");
						$parentTag.addClass('has-error').append(
												'<span class="control-label error">Request Date should not be greater than Settlement Date</span>');
					}
				
					if($("#trans_ref_no").val()	==	"") {
						var $parentTag 			=	$("#trans_ref_parent");
						$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
						e.preventDefault();
					}
			//	}
				
				if ($("#save_form_payment").has('.has-error').length > 0) {
					e.preventDefault();
					return false;	
				}
				$('[disabled]').removeAttr('disabled');
			});
			function getAvailableBalance() {
				if($('#screen_mode').val() == "admin"){
					$.ajax({
					  type: "POST",
					  async : false,
					  cache:false,
					  data:{investor_id:$("select#investor_id").find("option:selected").val()},
					  url: baseUrl+"/admin/investor/ajax/availableBalance"
					  
					}).done(function(data) {
						var avail_bal	=	numeral(data).format("0,000.00")
						$("#avail_bal").val(avail_bal);
						$("#approve_button").show();
					});
				}
			}
