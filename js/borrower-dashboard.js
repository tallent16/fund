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
		$('.fa-caret-left').on("click", function() { 
				var curLoanLen	=	current_loansJson.length;				
				var curLoanInd	=	$("#current_loan_index").val();
				
				if( curLoanLen > 0) {
					changeCurLoanInd	=	parseInt(curLoanInd)-1;
					if(	parseInt(curLoanLen-1) <  changeCurLoanInd) {
						changeCurLoanInd	=	0;
					}
					setCurrentLoanFunc(changeCurLoanInd);
					$("#current_loan_index").val(changeCurLoanInd);
				}
			});
		repaymentBarChartFunc();
		setwidth();
		
	});
	
	function repaymentBarChartFunc(){
		var datasetsArry	=	[];
		var colors = [];
		
		colors.push({
				fillColor: "rgba(151,187,205,0.5)",
				strokeColor: "rgba(151,187,205,0.8)",
				highlightFill: "rgba(151,187,205,0.75)",
				highlightStroke: "rgba(151,187,205,1)",
		});
		colors.push({
				fillColor : "rgba(95,137,250,0.5)",
				strokeColor : "rgba(95,137,250,0.9)",
				highlightFill: "rgba(95,137,250,0.75)",
				highlightStroke: "rgba(95,137,250,1)"
		});
		colors.push({
				fillColor : "rgba(245,75,75,0.5)",
				strokeColor : "rgba(245,75,75,0.8)",
				highlightFill : "rgba(245,75,75,0.75)",
				highlightStroke : "rgba(245,75,75,1)"
		});
		colors.push({
				fillColor : "rgba(98,223,114,0.5)",
				strokeColor : "rgba(98,223,114,0.8)",
				highlightFill : "rgba(98,223,114,0.75)",
				highlightStroke : "rgba(98,223,114,1)",
		});
		var dataLabel		=	"";
		var dataLabelNew	=	[];
		 if(barchartJson.length > 0){
			dataLabel	=	 (barchartJson[0].barChartLabel).split(',');
			$.each( dataLabel, function( key ) {
				var	monYear	=	(dataLabel[key]).split(' ');
				dataLabelNew.push(months[monYear[1]]+" "+monYear[0]);
			});
			var barcount = 0;
			$.each( barchartJson, function( key ) {
				colorIndex	=	key;
				if(key > 3)
					colorIndex	=	0;
				var dataArry	=	[];
				datasetsArry.push({
					   label:barchartJson[key].loan_ref ,
						fillColor : colors[colorIndex].fillColor,
						strokeColor : colors[colorIndex].strokeColor,
						highlightFill: colors[colorIndex].highlightFill,
						highlightStroke: colors[colorIndex].highlightStroke,
						data : (barchartJson[key].barChartValue).split(',')
					});
				
				loansCount = ((barchartJson[key].barChartValue).split(',')).length
				
				barCount = dataLabel.length * loansCount;
			});
		
			var bdata = {
			  //~ labels : dataLabel, 			  
			  labels : dataLabelNew, 			  
				datasets : datasetsArry
			}

			var options = {
					responsive:true,
			}

			Chart.types.Bar.extend({
				name: "BarWidth",
				draw: function(){
					this.options.barValueSpacing = (this.chart.width) / (barCount + 2);
					Chart.types.Bar.prototype.draw.apply(this, arguments);
				}
			});

			var cbar = document.getElementById("cbar").getContext("2d");
			var barChart = new Chart(cbar).BarWidth(bdata, options);	
			var legend = barChart.generateLegend();

			$('#cbarlegend').append(legend);
		}
	}
	function setCurrentLoanFunc(currentIndex){
		var currentlist	=	current_loansJson[currentIndex];
		
		$("#cur_loan_subhead").html(currentlist.business_name+" "+currentlist.business_organisation);
		$("#cur_loan_content").html(currentlist.purpose);
		$("#cur_loan_rate").html(currentlist.rate+"%");
		$("#cur_loan_duration").html(currentlist.duration);
		$("#cur_loan_amount").html(numeral(currentlist.amount).format("0,0.00"));
	}
	function setwidth(){
		Chart.types.Bar.extend({
			name: "bar",
			draw: function(){
				this.options.barValueSpacing = this.chart.width / 8;
				Chart.types.Bar.prototype.draw.apply(this, arguments);
				}
			});
	}
