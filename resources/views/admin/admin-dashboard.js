	$(document).ready(function(){
			$('.fa-caret-right').on("click", function() {
				var curLoanLen	=	current_loansJson.length;
				var curLoanInd	=	$("#current_loan_index").val();
				if( curLoanLen > 0) {
					changeCurLoanInd	=	parseInt(curLoanInd)+1;
					if(	changeCurLoanInd >  parseInt(curLoanLen-1)) {
						changeCurLoanInd	=	0;
					}
					setCurrentLoanFunc(changeCurLoanInd);
					$("#current_loan_index").val(changeCurLoanInd);
				}
			});
			repaymentBarChartFunc();
		});
		
		function repaymentBarChartFunc(){
			var datasetsArry	=	[];
			var dataLabelArry	=	[];
			var datavalueArry	=	[];
			var colors = [];
		
			colors.push({
					fillColor : "rgba(245,75,75,0.5)",
					strokeColor : "rgba(245,75,75,0.8)",
					highlightFill : "rgba(245,75,75,0.75)",
					highlightStroke : "rgba(245,75,75,1)"
			});
			 if(barchartJson.length > 0){
				$.each( barchartJson, function( key ) {
				
					dataLabelArry.push(barchartJson[key].pay_period);
					datavalueArry.push(barchartJson[key].percentage_payment);
				});
				datasetsArry.push({
					  
						label: "",
						fillColor : colors[0].fillColor,
						strokeColor : colors[0].strokeColor,
						pointColor: "rgba(220,220,220,1)",
						pointStrokeColor: "#fff",
						pointHighlightFill: colors[0].highlightFill,
						pointHighlightStroke: colors[0].highlightStroke,
						//~ data: datavalueArry
						data: datavalueArry
					});
				
			}
			var bdata = {
			  labels :dataLabelArry , 			  
			  width:10,
				datasets : datasetsArry
			}

			var options = {
					responsive:true
			}

			var cbar = document.getElementById("cbar").getContext("2d");
			var barChart = new Chart(cbar).Line(bdata, options);	
		}
		function setCurrentLoanFunc(currentIndex){
			var currentlist	=	current_loansJson[currentIndex];
			
			$("#cur_loan_subhead").html(currentlist.business_name);
			$("#cur_loan_content").html(currentlist.purpose);
			$("#cur_loan_rate").html(currentlist.rate+"%");
			$("#cur_loan_duration").html(currentlist.duration);
			$("#cur_loan_amount").html(numeral(currentlist.amount).format("0,0.00"));
			$("#cur_loan_repayment_type").html(currentlist.repayment_type);
			$("#cur_loan_bid_type").html(currentlist.bid_type);
		}
		//~ function setwidth(){
			//~ Chart.types.Bar.extend({
				//~ name: "bar",
				//~ draw: function(){
					//~ this.options.barValueSpacing = this.chart.width / 8;
					//~ Chart.types.Bar.prototype.draw.apply(this, arguments);
					//~ }
				//~ });
		//~ }
