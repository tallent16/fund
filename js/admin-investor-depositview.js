$(document).ready(function(){ 
			
			 $.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('#hidden_token').val()
				}
			});
			// date picker
			$('.deposit_date').datetimepicker({
				autoclose: true, 
				minView: 2,
				format: 'dd-mm-yyyy' 
			}); 
			$("#save_button").on("click",function(){
				$("#isSaveButton").val("yes");
				$("#submitType").val("save");
				$("#save_form_payment").attr("action",baseUrl+"/admin/investordepositview/save");
			});
			$("#approve_button").on("click",function(){
				$("#isSaveButton").val("");
				$("#submitType").val("approve");
				$("#save_form_payment").attr("action",baseUrl+"/admin/investordepositview/approve");
			});
			$("#unapprove_button").on("click",function(){
				$("#isSaveButton").val("");
				$("#submitType").val("unapprove");
				$("#save_form_payment").attr("action",baseUrl+"/admin/investordepositview/unapprove");
			});
			$("#save_form_payment").on("submit",function(e){
				$('span.error').remove();
				$('.has-error').removeClass("has-error");
				var $parentTag = $("#trans_ref_parent");
				$('[disabled]').removeAttr('disabled');
				if($("#isSaveButton").val()	!=	"yes") {
					if($("#trans_ref_no").val()	==	"") {
						$parentTag.addClass('has-error').append('<span class="control-label error">Required field</span>');
						e.preventDefault();
					}
				}
			});
			
			$(".amount-align").on("focus", function() {
					onFocusNumberField(this);
			})

			$(".amount-align").on("blur", function() {
				onBlurNumberField(this)
			})
		}); 
