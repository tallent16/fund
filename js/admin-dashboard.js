	$(document).ready(function(){
		adminDashboardBarChartFunc();
	});
		
		function adminDashboardBarChartFunc(){
			var datasetsArry	=	[];
			var loanLabelArry	=	[];
			var loanValueArry	=	[];
			var invLabelArry	=	[];
			var invValueArry	=	[];
			var colors = [];
		
			colors.push({
					fillColor : "rgba(245,75,75,0.5)",
					strokeColor : "rgba(245,75,75,0.8)",
					highlightFill : "rgba(245,75,75,0.75)",
					highlightStroke : "rgba(245,75,75,1)"
			});
			colors.push({
					fillColor : "rgba(145,65,65,0.5)",
					strokeColor : "rgba(145,65,65,0.8)",
					highlightFill : "rgba(145,65,65,0.75)",
					highlightStroke : "rgba(145,65,65,1)"
			});
			 if(loanJsonObj.length > 0){
				$.each( loanJsonObj, function( key ) {
				
					loanLabelArry.push(loanJsonObj[key].month_year);
					loanValueArry.push(loanJsonObj[key].tot_loan_amount);
					invLabelArry.push(loanJsonObj[key].month_year);
					invValueArry.push(getInvestmentByMonth(loanJsonObj[key].month_year));
					
				});
				datasetsArry.push({
					  
						label: "Loan",
						fillColor : colors[0].fillColor,
						strokeColor : colors[0].strokeColor,
						pointColor: "rgba(220,220,220,1)",
						pointStrokeColor: "#fff",
						pointHighlightFill: colors[0].highlightFill,
						pointHighlightStroke: colors[0].highlightStroke,
						data: loanValueArry
					});
				datasetsArry.push({
					  
						label: "Investment",
						fillColor : colors[1].fillColor,
						strokeColor : colors[1].strokeColor,
						pointColor: "rgba(120,120,120,1)",
						pointStrokeColor: "#fff",
						pointHighlightFill: colors[1].highlightFill,
						pointHighlightStroke: colors[1].highlightStroke,
						data: invValueArry
					});
				
			
					var bdata = {
					  labels :loanLabelArry , 			  
					  width:10,
						datasets : datasetsArry
					}

					var options = {
						responsive:true
					}

					var cbar = document.getElementById("cbar").getContext("2d");
					var barChart = new Chart(cbar).Line(bdata, options);	
					var legend = barChart.generateLegend();
					$('#cbarlegend').append(legend);
			}
		}
		function getInvestmentByMonth(monthyear){
			var	invAmt	=	0;
			$.each( investmentJsonObj, function( key ) {
				if(monthyear	==	investmentJsonObj[key].month_year) {
					invAmt	=	investmentJsonObj[key].tot_loan_amount;
				}
			});
			return	invAmt;
		}
